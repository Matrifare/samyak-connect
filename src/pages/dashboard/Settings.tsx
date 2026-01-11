import { useState } from "react";
import { Key, Bell, Eye, Shield, Trash2, AlertTriangle } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Switch } from "@/components/ui/switch";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Separator } from "@/components/ui/separator";
import { toast } from "@/hooks/use-toast";
import DashboardSidebar from "@/components/dashboard/DashboardSidebar";
import DashboardHeader from "@/components/dashboard/DashboardHeader";
import defaultMale from "@/assets/default-male.jpg";
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from "@/components/ui/alert-dialog";

const userData = {
  name: "Rahul More",
  profileId: "NX1235",
  avatar: defaultMale,
};

const Settings = () => {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [settings, setSettings] = useState({
    // Password
    currentPassword: "",
    newPassword: "",
    confirmPassword: "",
    
    // Notifications
    emailNotifications: true,
    smsNotifications: false,
    newMatchNotification: true,
    interestNotification: true,
    viewNotification: true,
    messageNotification: true,
    
    // Privacy
    profileVisibility: "all",
    showLastSeen: true,
    allowScreenshot: false,
    
    // Account
    profileStatus: "active",
  });

  const handleSettingChange = (key: string, value: boolean | string) => {
    setSettings(prev => ({ ...prev, [key]: value }));
  };

  const handlePasswordChange = () => {
    if (settings.newPassword !== settings.confirmPassword) {
      toast({
        title: "Error",
        description: "Passwords do not match",
        variant: "destructive",
      });
      return;
    }
    toast({
      title: "Password Updated",
      description: "Your password has been changed successfully.",
    });
    setSettings(prev => ({
      ...prev,
      currentPassword: "",
      newPassword: "",
      confirmPassword: "",
    }));
  };

  const handleDeactivate = () => {
    toast({
      title: "Account Deactivated",
      description: "Your account has been deactivated. You can reactivate anytime by logging in.",
    });
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-secondary/30 via-background to-secondary/20">
      <DashboardSidebar isOpen={sidebarOpen} onClose={() => setSidebarOpen(false)} />
      
      <div className="lg:pl-64">
        <DashboardHeader onMenuClick={() => setSidebarOpen(true)} user={userData} />
        
        <main className="p-4 md:p-6 lg:p-8 max-w-4xl">
          <div className="mb-6">
            <h1 className="text-2xl md:text-3xl font-bold text-foreground">Account Settings</h1>
            <p className="text-muted-foreground">Manage your account preferences and security</p>
          </div>

          <div className="space-y-6">
            {/* Change Password */}
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center gap-2">
                  <Key className="h-5 w-5 text-primary" />
                  Change Password
                </CardTitle>
                <CardDescription>
                  Update your password to keep your account secure
                </CardDescription>
              </CardHeader>
              <CardContent className="space-y-4">
                <div className="space-y-2">
                  <Label htmlFor="currentPassword">Current Password</Label>
                  <Input
                    id="currentPassword"
                    type="password"
                    value={settings.currentPassword}
                    onChange={(e) => handleSettingChange("currentPassword", e.target.value)}
                  />
                </div>
                <div className="grid md:grid-cols-2 gap-4">
                  <div className="space-y-2">
                    <Label htmlFor="newPassword">New Password</Label>
                    <Input
                      id="newPassword"
                      type="password"
                      value={settings.newPassword}
                      onChange={(e) => handleSettingChange("newPassword", e.target.value)}
                    />
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="confirmPassword">Confirm New Password</Label>
                    <Input
                      id="confirmPassword"
                      type="password"
                      value={settings.confirmPassword}
                      onChange={(e) => handleSettingChange("confirmPassword", e.target.value)}
                    />
                  </div>
                </div>
                <Button onClick={handlePasswordChange}>Update Password</Button>
              </CardContent>
            </Card>

            {/* Notification Settings */}
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center gap-2">
                  <Bell className="h-5 w-5 text-primary" />
                  Notification Settings
                </CardTitle>
                <CardDescription>
                  Choose how you want to be notified
                </CardDescription>
              </CardHeader>
              <CardContent className="space-y-6">
                <div className="flex items-center justify-between">
                  <div>
                    <Label>Email Notifications</Label>
                    <p className="text-sm text-muted-foreground">Receive updates via email</p>
                  </div>
                  <Switch
                    checked={settings.emailNotifications}
                    onCheckedChange={(v) => handleSettingChange("emailNotifications", v)}
                  />
                </div>
                <div className="flex items-center justify-between">
                  <div>
                    <Label>SMS Notifications</Label>
                    <p className="text-sm text-muted-foreground">Receive updates via SMS</p>
                  </div>
                  <Switch
                    checked={settings.smsNotifications}
                    onCheckedChange={(v) => handleSettingChange("smsNotifications", v)}
                  />
                </div>
                
                <Separator />
                
                <p className="font-medium text-sm">Notify me about:</p>
                <div className="space-y-4 pl-4">
                  <div className="flex items-center justify-between">
                    <Label>New Matches</Label>
                    <Switch
                      checked={settings.newMatchNotification}
                      onCheckedChange={(v) => handleSettingChange("newMatchNotification", v)}
                    />
                  </div>
                  <div className="flex items-center justify-between">
                    <Label>Interest Received</Label>
                    <Switch
                      checked={settings.interestNotification}
                      onCheckedChange={(v) => handleSettingChange("interestNotification", v)}
                    />
                  </div>
                  <div className="flex items-center justify-between">
                    <Label>Profile Views</Label>
                    <Switch
                      checked={settings.viewNotification}
                      onCheckedChange={(v) => handleSettingChange("viewNotification", v)}
                    />
                  </div>
                  <div className="flex items-center justify-between">
                    <Label>Messages</Label>
                    <Switch
                      checked={settings.messageNotification}
                      onCheckedChange={(v) => handleSettingChange("messageNotification", v)}
                    />
                  </div>
                </div>
              </CardContent>
            </Card>

            {/* Privacy Settings */}
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center gap-2">
                  <Eye className="h-5 w-5 text-primary" />
                  Privacy Settings
                </CardTitle>
                <CardDescription>
                  Control who can see your profile
                </CardDescription>
              </CardHeader>
              <CardContent className="space-y-6">
                <div className="space-y-2">
                  <Label>Profile Visibility</Label>
                  <Select
                    value={settings.profileVisibility}
                    onValueChange={(v) => handleSettingChange("profileVisibility", v)}
                  >
                    <SelectTrigger className="w-full md:w-64">
                      <SelectValue />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="all">Visible to All Members</SelectItem>
                      <SelectItem value="premium">Visible to Premium Members Only</SelectItem>
                      <SelectItem value="none">Hidden from All</SelectItem>
                    </SelectContent>
                  </Select>
                  <p className="text-sm text-muted-foreground">
                    Choose who can view your profile
                  </p>
                </div>

                <div className="flex items-center justify-between">
                  <div>
                    <Label>Show Last Seen</Label>
                    <p className="text-sm text-muted-foreground">Show when you were last active</p>
                  </div>
                  <Switch
                    checked={settings.showLastSeen}
                    onCheckedChange={(v) => handleSettingChange("showLastSeen", v)}
                  />
                </div>
              </CardContent>
            </Card>

            {/* Account Management */}
            <Card className="border-destructive/20">
              <CardHeader>
                <CardTitle className="flex items-center gap-2 text-destructive">
                  <Shield className="h-5 w-5" />
                  Account Management
                </CardTitle>
                <CardDescription>
                  Manage your account status
                </CardDescription>
              </CardHeader>
              <CardContent className="space-y-6">
                <div className="space-y-2">
                  <Label>Profile Status</Label>
                  <Select
                    value={settings.profileStatus}
                    onValueChange={(v) => handleSettingChange("profileStatus", v)}
                  >
                    <SelectTrigger className="w-full md:w-64">
                      <SelectValue />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="active">Active - Visible & Searchable</SelectItem>
                      <SelectItem value="hidden">Hidden - Not Visible to Others</SelectItem>
                    </SelectContent>
                  </Select>
                </div>

                <Separator />

                <div className="space-y-4">
                  <div className="flex items-start gap-4">
                    <AlertTriangle className="h-5 w-5 text-amber-500 mt-0.5" />
                    <div>
                      <h4 className="font-medium">Deactivate Account</h4>
                      <p className="text-sm text-muted-foreground">
                        Temporarily hide your profile. You can reactivate anytime.
                      </p>
                      <AlertDialog>
                        <AlertDialogTrigger asChild>
                          <Button variant="outline" className="mt-2">
                            Deactivate Account
                          </Button>
                        </AlertDialogTrigger>
                        <AlertDialogContent>
                          <AlertDialogHeader>
                            <AlertDialogTitle>Deactivate your account?</AlertDialogTitle>
                            <AlertDialogDescription>
                              Your profile will be hidden from all members. You can reactivate
                              your account anytime by logging in again.
                            </AlertDialogDescription>
                          </AlertDialogHeader>
                          <AlertDialogFooter>
                            <AlertDialogCancel>Cancel</AlertDialogCancel>
                            <AlertDialogAction onClick={handleDeactivate}>
                              Deactivate
                            </AlertDialogAction>
                          </AlertDialogFooter>
                        </AlertDialogContent>
                      </AlertDialog>
                    </div>
                  </div>

                  <div className="flex items-start gap-4">
                    <Trash2 className="h-5 w-5 text-destructive mt-0.5" />
                    <div>
                      <h4 className="font-medium text-destructive">Delete Account</h4>
                      <p className="text-sm text-muted-foreground">
                        Permanently delete your account and all data. This cannot be undone.
                      </p>
                      <AlertDialog>
                        <AlertDialogTrigger asChild>
                          <Button variant="destructive" className="mt-2">
                            Delete Account
                          </Button>
                        </AlertDialogTrigger>
                        <AlertDialogContent>
                          <AlertDialogHeader>
                            <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                            <AlertDialogDescription>
                              This action cannot be undone. This will permanently delete your
                              account and remove all your data from our servers.
                            </AlertDialogDescription>
                          </AlertDialogHeader>
                          <AlertDialogFooter>
                            <AlertDialogCancel>Cancel</AlertDialogCancel>
                            <AlertDialogAction className="bg-destructive text-destructive-foreground hover:bg-destructive/90">
                              Delete Account
                            </AlertDialogAction>
                          </AlertDialogFooter>
                        </AlertDialogContent>
                      </AlertDialog>
                    </div>
                  </div>
                </div>
              </CardContent>
            </Card>
          </div>
        </main>
      </div>
    </div>
  );
};

export default Settings;
