"use client";

import { useActionState } from "react";
import { loginAction } from "../auth-actions";

export default function AdminLoginPage() {
  const [error, action, pending] = useActionState(loginAction, null);
  return (
    <main className="grid min-h-screen place-items-center bg-gradient-to-br from-violet-900 via-purple-800 to-cyan-700 px-4">
      <form
        action={action}
        className="w-full max-w-sm rounded-3xl bg-white p-8 shadow-2xl"
      >
        <div className="mb-6 text-center">
          <span className="mx-auto mb-3 grid size-12 place-items-center rounded-2xl bg-gradient-to-br from-violet-600 to-cyan-500 text-xl font-extrabold text-white">
            A
          </span>
          <h1 className="text-xl font-extrabold text-slate-800">Admin AKASHI</h1>
          <p className="text-sm text-slate-400">Masuk untuk mengelola event</p>
        </div>
        <div className="space-y-4">
          <input
            name="email"
            type="email"
            placeholder="Email"
            className="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-200"
            required
          />
          <input
            name="password"
            type="password"
            placeholder="Password"
            className="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-200"
            required
          />
        </div>
        {error && (
          <p className="mt-3 rounded-lg bg-red-50 p-2.5 text-center text-xs font-medium text-red-600">
            {error}
          </p>
        )}
        <button
          disabled={pending}
          className="mt-5 w-full rounded-xl bg-gradient-to-r from-violet-600 to-cyan-500 py-3 font-bold text-white transition hover:opacity-90 disabled:opacity-50"
        >
          {pending ? "Memproses..." : "Masuk"}
        </button>
      </form>
    </main>
  );
}
