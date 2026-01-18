import { supabase } from "@/integrations/supabase/client";

export interface SiteSettings {
  site_name: string;
  site_tagline: string;
  contact_address: string;
  contact_phone: string;
  contact_email: string;
  facebook_url: string;
  twitter_url: string;
  instagram_url: string;
  youtube_url: string;
  whatsapp_number: string;
}

export const defaultSettings: SiteSettings = {
  site_name: "Samyak Matrimony",
  site_tagline: "The most trusted Buddhist matrimonial service. Join thousands of happy couples who found their perfect match.",
  contact_address: "123 Buddhist Lane, Nagpur, Maharashtra 440001",
  contact_phone: "+91 98765 43210",
  contact_email: "support@samyakmatrimony.com",
  facebook_url: "",
  twitter_url: "",
  instagram_url: "",
  youtube_url: "",
  whatsapp_number: "+91 79779 93616",
};

interface SettingRow {
  key: string;
  value: string | null;
}

export async function getSiteSettings(): Promise<SiteSettings> {
  const { data, error } = await supabase
    .from("site_settings" as any)
    .select("key, value");

  if (error || !data) {
    console.error("Error fetching site settings:", error);
    return defaultSettings;
  }

  const settings: SiteSettings = { ...defaultSettings };
  
  (data as unknown as SettingRow[]).forEach((row) => {
    if (row.key in settings) {
      (settings as any)[row.key] = row.value || "";
    }
  });

  return settings;
}

export async function updateSiteSetting(key: string, value: string): Promise<boolean> {
  const { error } = await supabase
    .from("site_settings" as any)
    .update({ value, updated_at: new Date().toISOString() })
    .eq("key", key);

  if (error) {
    console.error("Error updating site setting:", error);
    return false;
  }

  return true;
}

export async function updateSiteSettings(settings: Partial<SiteSettings>): Promise<boolean> {
  const updates = Object.entries(settings).map(([key, value]) => ({
    key,
    value,
    updated_at: new Date().toISOString(),
  }));

  for (const update of updates) {
    const { error } = await supabase
      .from("site_settings" as any)
      .update({ value: update.value, updated_at: update.updated_at })
      .eq("key", update.key);

    if (error) {
      console.error(`Error updating ${update.key}:`, error);
      return false;
    }
  }

  return true;
}
