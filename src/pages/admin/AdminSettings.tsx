import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Switch } from "@/components/ui/switch";
import { Save } from "lucide-react";
import AdminLayout from "@/components/admin/AdminLayout";
import { toast } from "sonner";

const AdminSettings = () => {
  const handleSave = () => {
    toast.success("Settings saved successfully");
  };

  return (
    <AdminLayout>
      <div className="p-6 space-y-6">
        <div>
          <h1 className="text-2xl font-bold text-white">Settings</h1>
          <p className="text-slate-400">Configure your admin dashboard settings</p>
        </div>

        <div className="grid gap-6">
          <Card className="bg-slate-800/50 border-slate-700">
            <CardHeader>
              <CardTitle className="text-white">Site Settings</CardTitle>
            </CardHeader>
            <CardContent className="space-y-4">
              <div className="grid gap-2">
                <Label className="text-slate-200">Site Name</Label>
                <Input
                  defaultValue="Samyak Matrimony"
                  className="bg-slate-700/50 border-slate-600 text-white"
                />
              </div>
              <div className="grid gap-2">
                <Label className="text-slate-200">Admin Email</Label>
                <Input
                  defaultValue="admin@samyakmatrimony.in"
                  className="bg-slate-700/50 border-slate-600 text-white"
                />
              </div>
              <div className="grid gap-2">
                <Label className="text-slate-200">Support WhatsApp Number</Label>
                <Input
                  defaultValue="+91 79779 93616"
                  className="bg-slate-700/50 border-slate-600 text-white"
                />
              </div>
            </CardContent>
          </Card>

          <Card className="bg-slate-800/50 border-slate-700">
            <CardHeader>
              <CardTitle className="text-white">Registration Settings</CardTitle>
            </CardHeader>
            <CardContent className="space-y-4">
              <div className="flex items-center justify-between">
                <div>
                  <p className="text-white font-medium">Enable New Registrations</p>
                  <p className="text-sm text-slate-400">Allow new users to register</p>
                </div>
                <Switch defaultChecked />
              </div>
              <div className="flex items-center justify-between">
                <div>
                  <p className="text-white font-medium">Require Email Verification</p>
                  <p className="text-sm text-slate-400">Users must verify email before login</p>
                </div>
                <Switch />
              </div>
              <div className="flex items-center justify-between">
                <div>
                  <p className="text-white font-medium">Auto-approve Profiles</p>
                  <p className="text-sm text-slate-400">Skip manual approval for new profiles</p>
                </div>
                <Switch />
              </div>
            </CardContent>
          </Card>

          <Card className="bg-slate-800/50 border-slate-700">
            <CardHeader>
              <CardTitle className="text-white">Notification Settings</CardTitle>
            </CardHeader>
            <CardContent className="space-y-4">
              <div className="flex items-center justify-between">
                <div>
                  <p className="text-white font-medium">Email Notifications</p>
                  <p className="text-sm text-slate-400">Receive email for new registrations</p>
                </div>
                <Switch defaultChecked />
              </div>
              <div className="flex items-center justify-between">
                <div>
                  <p className="text-white font-medium">WhatsApp Notifications</p>
                  <p className="text-sm text-slate-400">Receive WhatsApp for urgent matters</p>
                </div>
                <Switch defaultChecked />
              </div>
            </CardContent>
          </Card>

          <Button onClick={handleSave} className="w-fit">
            <Save className="h-4 w-4 mr-2" />
            Save Settings
          </Button>
        </div>
      </div>
    </AdminLayout>
  );
};

export default AdminSettings;