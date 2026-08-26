import { getSettings } from "@/lib/constants";
import { isEventFinished } from "@/lib/event-state";
import { SiteHeader } from "@/components/site-header";
import { SiteFooter } from "@/components/site-footer";

export default async function SiteLayout({ children }: LayoutProps<"/">) {
  const settings = await getSettings();
  const finished = isEventFinished(settings.event_date);

  return (
    <>
      <SiteHeader finished={finished} logoUrl={settings.site_logo_url} />
      {children}
      <SiteFooter settings={settings} />
    </>
  );
}
