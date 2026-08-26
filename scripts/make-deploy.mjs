// Rakit folder deploy/ lalu push ke branch production di GitHub.
// Jalankan: node scripts/make-deploy.mjs
import { cp, rm, writeFile, readdir } from "fs/promises";
import { execSync } from "child_process";

const SRC = ".next/standalone";
const DST = "deploy";

const run = (cmd) => execSync(cmd, { stdio: "inherit" });

// ── 1. Rakit folder deploy/ ──────────────────────────────────────────────────
await rm(DST, { recursive: true, force: true });
await cp(SRC, DST, { recursive: true });
await cp(".next/static", `${DST}/.next/static`, { recursive: true });
await cp("public", `${DST}/public`, { recursive: true });

// bersihkan engine Windows + tmp sampah dari generate gagal
{
  const dir = `${DST}/node_modules/.prisma/client`;
  await rm(`${dir}/query_engine-windows.dll.node`, { force: true });
  for (const f of await readdir(dir))
    if (/\.tmp\d+$/.test(f)) await rm(`${dir}/${f}`, { force: true });
}

// buang file non-runtime
for (const junk of [
  "dev.log", "tests", "src", "package-lock.json",
  "AGENTS.md", "CLAUDE.md", "README.md",
  "eslint.config.mjs", "postcss.config.mjs", "tsconfig.json",
])
  await rm(`${DST}/${junk}`, { recursive: true, force: true });

// .env.example sebagai reminder di server
await cp(".env.example", `${DST}/.env.example`);

// ── 2. Push deploy/ ke branch production ────────────────────────────────────
console.log("Pushing to branch production...");

// simpan hash commit main saat ini untuk pesan commit
const mainHash = execSync("git rev-parse --short HEAD").toString().trim();

run("git fetch origin");

// worktree sementara di luar folder proyek
const WT = "../_production_wt";
await rm(WT, { recursive: true, force: true });

try {
  run(`git worktree add ${WT} production`);
} catch {
  // branch belum ada — buat orphan
  run(`git worktree add --orphan -b production ${WT}`);
}

// bersihkan isi worktree lama (kecuali .git)
const wtFiles = await readdir(WT);
for (const f of wtFiles)
  if (f !== ".git")
    await rm(`${WT}/${f}`, { recursive: true, force: true });

// salin deploy/ → worktree
await cp(DST, WT, { recursive: true });

// .gitignore minimal di production branch (jangan commit .env)
await writeFile(`${WT}/.gitignore`, ".env\nuploads/\npublic/uploads/\n");

run(`git -C ${WT} add -A`);
run(`git -C ${WT} commit -m "build: standalone from main@${mainHash}"`);
run(`git -C ${WT} push origin production --force`);

run("git worktree remove --force ../_production_wt");

console.log("✅ deploy/ rakitan, branch production ter-push ke GitHub.");
console.log("Di server: git pull origin production && node server.js");
