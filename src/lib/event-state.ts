// ponytail: dipisah agar pemanggilan Date.now() di luar scope render (aturan purity RSC)
export function isEventFinished(eventDateIso: string): boolean {
  const end = new Date(eventDateIso);
  if (isNaN(end.getTime())) return false;
  end.setHours(23, 59, 59, 999);
  return Date.now() > end.getTime();
}
