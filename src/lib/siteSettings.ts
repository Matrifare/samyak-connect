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
  // Contact Page Settings
  contact_page_title: string;
  contact_page_subtitle: string;
  contact_office_address: string;
  contact_phone_2: string;
  contact_email_2: string;
  contact_office_hours: string;
  contact_map_embed: string;
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
  // Contact Page Settings
  contact_page_title: "Contact Us",
  contact_page_subtitle: "Have questions or need help? We're here to assist you on your journey to finding your perfect match.",
  contact_office_address: "Samyak Matrimony\n123, ABC Complex, Near XYZ Junction\nAndheri West, Mumbai - 400058\nMaharashtra, India",
  contact_phone_2: "+91 79779 93616",
  contact_email_2: "support@samyakmatrimony.com",
  contact_office_hours: "Monday - Saturday: 10:00 AM - 7:00 PM\nSunday: Closed",
  contact_map_embed: "",
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
