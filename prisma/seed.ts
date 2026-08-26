import { PrismaClient } from "@prisma/client";
import bcrypt from "bcryptjs";

const db = new PrismaClient();

const lomba = [
  ["Olimpiade IPAS", "olimpiade-ipas", "Akademik", "Olimpiade sains terpadu untuk siswa SD kelas 4-6.", 1],
  ["Olimpiade Matematika", "olimpiade-matematika", "Akademik", "Kompetisi matematika mengasah logika dan numerasi.", 1],
  ["Cerdas Cermat Agama (CCA)", "cerdas-cermat-agama", "Religi", "Kuis cerdas cermat materi agama Islam antar tim.", 3],
  ["MHQ", "mhq", "Religi", "Musabaqah Hifzil Qur'an \u2014 lomba hafalan Al-Qur'an.", 1],
  ["MTQ", "mtq", "Religi", "Musabaqah Tilawatil Qur'an \u2014 lomba seni baca Al-Qur'an.", 1],
  ["Pildacil", "pildacil", "Seni", "Pidato anak cerdas \u2014 lomba pidato singkat.", 1],
  ["Story Telling", "story-telling", "Bahasa", "Lomba bercerita dalam bahasa Inggris.", 1],
  ["Maca Cerak", "maca-cerak", "Bahasa", "Lomba membaca cepat dan jelas berbahasa Sunda.", 1],
  ["Membaca Puisi", "membaca-puisi", "Seni", "Deklamasi puisi dengan ekspresi terbaik.", 1],
  ["Menggambar", "menggambar", "Seni", "Lomba gambar dengan tema keislaman dan kreativitas.", 1],
  ["Fotografi", "fotografi", "Seni", "Lomba foto tunggal bertema kegiatan positif.", 1],
  ["Video Pendek", "video-pendek", "Seni", "Karya video pendek maksimal 3 menit.", 3],
] as const;

async function main() {
  await db.user.upsert({
    where: { email: process.env.ADMIN_EMAIL || "admin@akashiq.id" },
    update: {},
    create: {
      email: process.env.ADMIN_EMAIL || "admin@akashiq.id",
      name: "Super Admin",
      role: "SUPER_ADMIN",
      passwordHash: bcrypt.hashSync(process.env.ADMIN_PASSWORD || "admin12345", 10),
    },
  });

  for (const [name, slug, category, description, teamSize] of lomba) {
    await db.competition.upsert({
      where: { slug },
      update: { teamSize },
      create: {
        name,
        slug,
        category,
        description,
        level: "SD",
        status: "OPEN",
        quota: 100,
        teamSize,
        location: "SMP Muhammadiyah Unggulan Ashidiq",
        contactPerson: "0812-7757-0669 (Ust. Nur Wahyudi)",
        prize1: "Rp 500.000 + Trophy + Sertifikat",
        prize2: "Rp 300.000 + Trophy + Sertifikat",
        prize3: "Rp 200.000 + Trophy + Sertifikat",
      },
    });
  }

  const acts = [
    ["Gelar Karya", "Pameran karya terbaik peserta didik."],
    ["Talkshow Bersama Penulis Buku", "Diskusi inspiratif bersama penulis buku."],
    ["Bazar Buku", "Bazar buku dengan harga terjangkau."],
    ["Edukasi Dolanan Tradisional", "Belajar sambil bermain permainan tradisional."],
    ["Edukasi Membatik", "Praktik membatik untuk siswa."],
  ];
  for (const [name, description] of acts) {
    const exists = await db.activity.findFirst({ where: { name } });
    if (!exists)
      await db.activity.create({ data: { name, description, date: new Date("2026-09-16T08:00:00+07:00") } });
  }

  const scheds = [
    ["Pendaftaran dibuka", "2026-09-01T00:00:00+07:00"],
    ["Pelaksanaan AKASHI 2026", "2026-09-16T07:00:00+07:00"],
  ];
  for (const [title, d] of scheds) {
    const date = new Date(d);
    const exists = await db.schedule.findFirst({ where: { title, date } });
    if (!exists) await db.schedule.create({ data: { title, date } });
  }

  const faqs = [
    ["Siapa yang boleh mengikuti lomba?", "Seluruh siswa-siswi tingkat SD sesuai jenjang masing-masing lomba."],
    ["Bagaimana cara mendaftar?", "Isi formulir pendaftaran online di halaman Daftar, lalu simpan nomor pendaftaran Anda."],
    ["Apakah pendaftaran berbayar?", "Biaya pendaftaran dapat berbeda tiap lomba. Lihat detail lomba untuk informasi biaya."],
    ["Apa saja dokumen yang diperlukan?", "Umumnya kartu pelajar/pas foto. Detail dokumen wajib ada di halaman detail lomba."],
    ["Bagaimana cara mengetahui status pendaftaran?", "Gunakan halaman Cek Pendaftaran dengan memasukkan nomor pendaftaran."],
    ["Kapan pendaftaran ditutup?", "Pendaftaran dibuka mulai 1 September 2026 hingga kuota penuh."],
    ["Di mana lokasi lomba?", "SMP Muhammadiyah Unggulan Ashidiq."],
  ];
  let i = 0;
  for (const [question, answer] of faqs) {
    const exists = await db.faq.findFirst({ where: { question } });
    if (!exists) await db.faq.create({ data: { question, answer, order: i++ } });
  }

  const pages = [
    ["juknis", "Juknis Lomba", `PETUNJUK TEKNIS UMUM AKASHI 2026

1. Peserta adalah siswa-siswi tingkat SD sesuai jenjang lomba yang dipilih.
2. Pendaftaran dilakukan online melalui website resmi panitia.
3. Setiap peserta/regu wajib mengisi data dengan benar dan menyimpan nomor pendaftaran.
4. Lomba individu diikuti 1 peserta; lomba regu diikuti sesuai jumlah anggota yang ditentukan (lihat detail lomba).
5. Peserta hadir 30 menit sebelum lomba dimulai dan membawa kartu peserta.
6. Keputusan juri bersifat mutlak.
7. Detail teknis per lomba dapat berubah; pantau halaman Pengumuman.`],
    ["dokumentasi", "Dokumentasi", `Dokumentasi kegiatan AKASHI akan dipublikasikan setelah acara berlangsung.

Foto pemenang, liputan kegiatan, dan rekaman video dapat dilihat di halaman ini serta Instagram resmi sekolah.`],
  ] as const;
  for (const [slug, title, body] of pages) {
    await db.infoPage.upsert({ where: { slug }, update: {}, create: { slug, title, body } });
  }

  const ann = ["Pendaftaran AKASHI 2026 dibuka", "Pendaftaran seluruh lomba dibuka mulai 1 September 2026. Kuota terbatas, daftar sekarang!"];
  if (!(await db.announcement.findFirst({ where: { title: ann[0] } }))) {
    await db.announcement.create({ data: { year: 2026, title: ann[0], body: ann[1] } });
  }

  console.log("Seed done");
}

main().finally(() => db.$disconnect());
