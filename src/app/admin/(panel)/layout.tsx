import Link from "next/link";
import { redirect } from "next/navigation";
import {
  LayoutDashboard,
  Trophy,
  Users,
  CalendarDays,
  Gift,
  PartyPopper,
  Megaphone,
  ScrollText,
  BookOpen,
  HelpCircle,
  Settings,
  LogOut,
  UsersRound,
  ExternalLink,
} from "lucide-react";
import { getSession } from "@/lib/auth";
import { getSettings } from "@/lib/constants";
import { logoutAction } from "../auth-actions";

export const metadata = { title: "Admin" };

export default async function AdminLayout({ children }: LayoutProps<"/admin">) {
  const session = await getSession();
  if (!session) redirect("/admin/login");
  const settings = await getSettings();

  const nav = [
    ["/admin/dashboard", "Dashboard", LayoutDashboard],
    ["/admin/lomba", "Lomba", Trophy],
    ["/admin/peserta", "Peserta", Users],
    ["/admin/jadwal", "Jadwal", CalendarDays],
    ["/admin/hadiah", "Hadiah", Gift],
    ["/admin/kegiatan", "Kegiatan", PartyPopper],
    ["/admin/pengumuman", "Pengumuman", Megaphone],
    ["/admin/juknis", "Juknis", BookOpen],
    ["/admin/kop-surat", "Kop Surat", ScrollText],
    ["/admin/faq", "FAQ", HelpCircle],
    ["/admin/pengguna", "Pengguna", UsersRound],
    ["/admin/pengaturan", "Pengaturan", Settings],
  ] as const;

  return (
    <div className="flex min-h-screen bg-slate-50">
      <aside className="fixed inset-y-0 left-0 z-30 hidden w-60 flex-col bg-gradient-to-b from-violet-900 to-purple-950 text-violet-100 lg:flex">
        <div className="flex h-16 items-center gap-2 border-b border-white/10 px-5 font-extrabold text-white">
          <span className="grid size-8 place-items-center rounded-lg bg-gradient-to-br from-violet-500 to-cyan-400 text-sm">
            A
          </span>
          Admin {settings.event_name.split(" ")[0]}
        </div>
        <nav className="flex-1 space-y-1 overflow-y-auto p-3">
          {nav.map(([href, label, Icon]) => (
            <Link
              key={href}
              href={href}
              className="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition hover:bg-white/10 hover:text-white"
            >
              <Icon size={18} />
              {label}
            </Link>
          ))}
        </nav>
        <div className="border-t border-white/10 p-3 text-xs">
          <p className="px-3 pb-2 font-semibold text-white">{session.name}</p>
          <p className="px-3 pb-3 opacity-60">{session.role}</p>
          <form action={logoutAction}>
            <button className="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 font-medium transition hover:bg-white/10 hover:text-white">
              <LogOut size={18} /> Keluar
            </button>
          </form>
        </div>
      </aside>

      <div className="flex min-h-screen flex-1 flex-col lg:pl-60">
        <header className="sticky top-0 z-20 flex h-14 items-center justify-between gap-4 overflow-x-auto border-b bg-white px-4 lg:justify-end">
          <nav className="flex gap-1 lg:hidden">
            {nav.slice(0, 5).map(([href, label]) => (
              <Link
                key={href}
                href={href}
                className="whitespace-nowrap rounded-lg px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-violet-50"
              >
                {label}
              </Link>
            ))}
            {nav.slice(5).map(([href, label]) => (
              <Link
                key={href}
                href={href}
                className="whitespace-nowrap rounded-lg px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-violet-50"
              >
                {label}
              </Link>
            ))}
          </nav>
          <a
            href="/"
            target="_blank"
            className="flex items-center gap-1.5 whitespace-nowrap rounded-lg px-3 py-1.5 text-xs font-semibold text-violet-700 hover:bg-violet-50"
          >
            Lihat Website <ExternalLink size={13} />
          </a>
        </header>
        <main className="flex-1 p-4 sm:p-6">{children}</main>
      </div>
    </div>
  );
}
