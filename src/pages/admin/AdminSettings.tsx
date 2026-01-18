import { useState, useEffect } from "react";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import { Switch } from "@/components/ui/switch";
import { Save, Loader2 } from "lucide-react";
import AdminLayout from "@/components/admin/AdminLayout";
import { toast } from "sonner";
import { getSiteSettings, updateSiteSettings, SiteSettings, defaultSettings } from "@/lib/siteSettings";

const AdminSettings = () => {
  const [settings, setSettings] = useState<SiteSettings>(defaultSettings);
  const [loading, setLoading] = useState(true);
  const [saving, setSaving] = useState(false);

  useEffect(() => {
    loadSettings();
  }, []);

  const loadSettings = async () => {
    setLoading(true);
    const data = await getSiteSettings();
    setSettings(data);
    setLoading(false);
  };

  const handleChange = (key: keyof SiteSettings, value: string) => {
    setSettings((prev) => ({ ...prev, [key]: value }));
  };

  const handleSave = async () => {
    setSaving(true);
    const success = await updateSiteSettings(settings);
    if (success) {
      toast.success("Settings saved successfully");
    } else {
      toast.error("Failed to save settings");
    }
    setSaving(false);
  };

  if (loading) {
    return (
      <AdminLayout>
        <div className="p-6 flex items-center justify-center">
          <Loader2 className="h-8 w-8 animate-spin text-primary" />
        </div>
      </AdminLayout>
    );
  }

  return (
    <AdminLayout>
      <div className="p-6 space-y-6">
        <div>
          <h1 className="text-2xl font-bold text-white">Settings</h1>
          <p className="text-slate-400">Configure your site and footer settings</p>
        </div>

        <div className="grid gap-6">
          {/* Site Information */}
          <Card className="bg-slate-800/50 border-slate-700">
            <CardHeader>
              <CardTitle className="text-white">Site Information</CardTitle>
            </CardHeader>
            <CardContent className="space-y-4">
              <div className="grid gap-2">
                <Label className="text-slate-200">Site Name</Label>
                <Input
                  value={settings.site_name}
                  onChange={(e) => handleChange("site_name", e.target.value)}
                  className="bg-slate-700/50 border-slate-600 text-white"
                />
              </div>
              <div className="grid gap-2">
                <Label className="text-slate-200">Site Tagline / About (displays in footer)</Label>
                <Textarea
                  value={settings.site_tagline}
                  onChange={(e) => handleChange("site_tagline", e.target.value)}
                  className="bg-slate-700/50 border-slate-600 text-white min-h-[100px]"
                />
              </div>
            </CardContent>
          </Card>

          {/* Contact Information */}
          <Card className="bg-slate-800/50 border-slate-700">
            <CardHeader>
              <CardTitle className="text-white">Contact Information</CardTitle>
            </CardHeader>
            <CardContent className="space-y-4">
              <div className="grid gap-2">
                <Label className="text-slate-200">Address</Label>
                <Textarea
                  value={settings.contact_address}
                  onChange={(e) => handleChange("contact_address", e.target.value)}
                  className="bg-slate-700/50 border-slate-600 text-white"
                />
              </div>
              <div className="grid gap-2">
                <Label className="text-slate-200">Phone Number</Label>
                <Input
                  value={settings.contact_phone}
                  onChange={(e) => handleChange("contact_phone", e.target.value)}
                  className="bg-slate-700/50 border-slate-600 text-white"
                />
              </div>
              <div className="grid gap-2">
                <Label className="text-slate-200">Email Address</Label>
                <Input
                  value={settings.contact_email}
                  onChange={(e) => handleChange("contact_email", e.target.value)}
                  className="bg-slate-700/50 border-slate-600 text-white"
                />
              </div>
              <div className="grid gap-2">
                <Label className="text-slate-200">WhatsApp Number</Label>
                <Input
                  value={settings.whatsapp_number}
                  onChange={(e) => handleChange("whatsapp_number", e.target.value)}
                  className="bg-slate-700/50 border-slate-600 text-white"
                />
              </div>
            </CardContent>
          </Card>

          {/* Social Media Links */}
          <Card className="bg-slate-800/50 border-slate-700">
            <CardHeader>
              <CardTitle className="text-white">Social Media Links</CardTitle>
            </CardHeader>
            <CardContent className="space-y-4">
              <div className="grid gap-2">
                <Label className="text-slate-200">Facebook URL</Label>
                <Input
                  value={settings.facebook_url}
                  onChange={(e) => handleChange("facebook_url", e.target.value)}
                  placeholder="https://facebook.com/yourpage"
                  className="bg-slate-700/50 border-slate-600 text-white placeholder:text-slate-500"
                />
              </div>
              <div className="grid gap-2">
                <Label className="text-slate-200">Twitter URL</Label>
                <Input
                  value={settings.twitter_url}
                  onChange={(e) => handleChange("twitter_url", e.target.value)}
                  placeholder="https://twitter.com/yourhandle"
                  className="bg-slate-700/50 border-slate-600 text-white placeholder:text-slate-500"
                />
              </div>
              <div className="grid gap-2">
                <Label className="text-slate-200">Instagram URL</Label>
                <Input
                  value={settings.instagram_url}
                  onChange={(e) => handleChange("instagram_url", e.target.value)}
                  placeholder="https://instagram.com/yourhandle"
                  className="bg-slate-700/50 border-slate-600 text-white placeholder:text-slate-500"
                />
              </div>
              <div className="grid gap-2">
                <Label className="text-slate-200">YouTube URL</Label>
                <Input
                  value={settings.youtube_url}
                  onChange={(e) => handleChange("youtube_url", e.target.value)}
                  placeholder="https://youtube.com/yourchannel"
                  className="bg-slate-700/50 border-slate-600 text-white placeholder:text-slate-500"
                />
              </div>
            </CardContent>
          </Card>

          {/* Contact Us Page Settings */}
          <Card className="bg-slate-800/50 border-slate-700">
            <CardHeader>
              <CardTitle className="text-white">Contact Us Page</CardTitle>
            </CardHeader>
            <CardContent className="space-y-4">
              <div className="grid gap-2">
                <Label className="text-slate-200">Page Title</Label>
                <Input
                  value={settings.contact_page_title}
                  onChange={(e) => handleChange("contact_page_title", e.target.value)}
                  className="bg-slate-700/50 border-slate-600 text-white"
                />
              </div>
              <div className="grid gap-2">
                <Label className="text-slate-200">Page Subtitle</Label>
                <Textarea
                  value={settings.contact_page_subtitle}
                  onChange={(e) => handleChange("contact_page_subtitle", e.target.value)}
                  className="bg-slate-700/50 border-slate-600 text-white"
                />
              </div>
              <div className="grid gap-2">
                <Label className="text-slate-200">Office Address (displayed on contact page)</Label>
                <Textarea
                  value={settings.contact_office_address}
                  onChange={(e) => handleChange("contact_office_address", e.target.value)}
                  className="bg-slate-700/50 border-slate-600 text-white min-h-[100px]"
                  placeholder="Full address with line breaks"
                />
              </div>
              <div className="grid md:grid-cols-2 gap-4">
                <div className="grid gap-2">
                  <Label className="text-slate-200">Phone Number 2</Label>
                  <Input
                    value={settings.contact_phone_2}
                    onChange={(e) => handleChange("contact_phone_2", e.target.value)}
                    className="bg-slate-700/50 border-slate-600 text-white"
                  />
                </div>
                <div className="grid gap-2">
                  <Label className="text-slate-200">Email Address 2</Label>
                  <Input
                    value={settings.contact_email_2}
                    onChange={(e) => handleChange("contact_email_2", e.target.value)}
                    className="bg-slate-700/50 border-slate-600 text-white"
                  />
                </div>
              </div>
              <div className="grid gap-2">
                <Label className="text-slate-200">Office Hours</Label>
                <Textarea
                  value={settings.contact_office_hours}
                  onChange={(e) => handleChange("contact_office_hours", e.target.value)}
                  className="bg-slate-700/50 border-slate-600 text-white"
                  placeholder="e.g., Monday - Saturday: 10:00 AM - 7:00 PM"
                />
              </div>
              <div className="grid gap-2">
                <Label className="text-slate-200">Google Map Embed URL (optional)</Label>
                <Input
                  value={settings.contact_map_embed}
                  onChange={(e) => handleChange("contact_map_embed", e.target.value)}
                  placeholder="https://www.google.com/maps/embed?..."
                  className="bg-slate-700/50 border-slate-600 text-white placeholder:text-slate-500"
                />
              </div>
            </CardContent>
          </Card>

          <Button onClick={handleSave} disabled={saving} className="w-fit">
            {saving ? (
              <Loader2 className="h-4 w-4 mr-2 animate-spin" />
            ) : (
              <Save className="h-4 w-4 mr-2" />
            )}
            Save Settings
          </Button>
        </div>
      </div>
    </AdminLayout>
  );
};

export default AdminSettings;
