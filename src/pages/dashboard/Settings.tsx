import { useState } from "react";
import { 
  Key, 
  Phone, 
  Shield, 
  Camera, 
  User, 
  Heart, 
  Image, 
  EyeOff, 
  FileText, 
  Lock, 
  Trash2,
  Edit,
  CheckCircle2,
  Mail,
  BadgeCheck
} from "lucide-react";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { toast } from "@/hooks/use-toast";
import DashboardSidebar from "@/components/dashboard/DashboardSidebar";
import DashboardHeader from "@/components/dashboard/DashboardHeader";
import defaultMale from "@/assets/default-male.jpg";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/components/ui/dialog";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
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

// Settings menu items
const settingsOptions = [
  { 
    label: "Change Password", 
    icon: Key, 
    action: "password",
    description: "Update your account password"
  },
  { 
    label: "Edit Contact Details", 
    icon: Phone, 
    action: "contact",
    description: "Update your phone and email"
  },
  { 
    label: "Contact Security", 
    icon: Shield, 
    action: "security",
    description: "Manage who can view your contact details"
  },
  { 
    label: "Edit Photo", 
    icon: Camera, 
    action: "photo",
    description: "Update your profile photos"
  },
  { 
    label: "Edit Profile", 
    icon: User, 
    action: "profile",
    description: "Update your profile information"
  },
  { 
    label: "Edit Match", 
    icon: Heart, 
    action: "match",
    description: "Update partner preferences"
  },
  { 
    label: "Photo Hide/Unhide", 
    icon: Image, 
    action: "photo-visibility",
    description: "Control photo visibility"
  },
  { 
    label: "Profile Hide/Unhide", 
    icon: EyeOff, 
    action: "profile-visibility",
    description: "Control profile visibility"
  },
  { 
    label: "Profile Description Update", 
    icon: FileText, 
    action: "description",
    description: "Update your bio and about me"
  },
  { 
    label: "Express Interest / View Contact Privacy", 
    icon: Lock, 
    action: "privacy",
    description: "Manage interest and contact privacy"
  },
];

// Trust status items
const trustStatus = [
  { label: "Phone Number", verified: true, icon: Phone },
  { label: "Email Verification", verified: true, icon: Mail },
  { label: "Photo Id Proof Verification", verified: true, icon: BadgeCheck },
];

const Settings = () => {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [passwordData, setPasswordData] = useState({
    currentPassword: "",
    newPassword: "",
    confirmPassword: "",
  });

  const handleSettingClick = (action: string) => {
    switch (action) {
      case "photo":
        window.location.href = "/dashboard/photos";
        break;
      case "profile":
        window.location.href = "/dashboard/profile";
        break;
      case "match":
        window.location.href = "/dashboard/preferences";
        break;
      default:
        toast({
          title: "Settings",
          description: `Opening ${action} settings...`,
        });
    }
  };

  const handlePasswordChange = () => {
    if (passwordData.newPassword !== passwordData.confirmPassword) {
      toast({
        title: "Error",
        description: "Passwords do not match",
        variant: "destructive",
      });
      return;
    }
    if (passwordData.newPassword.length < 6) {
      toast({
        title: "Error",
        description: "Password must be at least 6 characters",
        variant: "destructive",
      });
      return;
    }
    toast({
      title: "Password Updated",
      description: "Your password has been changed successfully.",
    });
    setPasswordData({
      currentPassword: "",
      newPassword: "",
      confirmPassword: "",
    });
  };

  const handleDeleteAccount = () => {
    toast({
      title: "Account Deletion Requested",
      description: "Your account deletion request has been submitted. You will receive a confirmation email.",
      variant: "destructive",
    });
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-secondary/30 via-background to-secondary/20">
      <DashboardSidebar isOpen={sidebarOpen} onClose={() => setSidebarOpen(false)} />
      
      <div className="lg:pl-64">
        <DashboardHeader onMenuClick={() => setSidebarOpen(true)} user={userData} />
        
        <main className="p-4 md:p-6 lg:p-8 max-w-4xl">
          <div className="mb-6">
            <h1 className="text-2xl md:text-3xl font-bold text-foreground">Settings</h1>
            <p className="text-muted-foreground">Manage your account settings and preferences</p>
          </div>

          <div className="space-y-6">
            {/* Settings Options */}
            <Card>
              <CardHeader className="pb-2">
                <CardTitle className="text-lg">Settings</CardTitle>
              </CardHeader>
              <CardContent className="p-0">
                <div className="divide-y divide-border">
                  {settingsOptions.map((option, index) => (
                    <div key={index}>
                      {option.action === "password" ? (
                        <Dialog>
                          <DialogTrigger asChild>
                            <button className="w-full flex items-center justify-between py-4 px-6 hover:bg-muted/50 transition-colors text-left">
                              <div className="flex items-center gap-3">
                                <option.icon className="h-5 w-5 text-primary" />
                                <span className="font-medium">{option.label}</span>
                              </div>
                              <Edit className="h-5 w-5 text-muted-foreground" />
                            </button>
                          </DialogTrigger>
                          <DialogContent>
                            <DialogHeader>
                              <DialogTitle>Change Password</DialogTitle>
                              <DialogDescription>
                                Enter your current password and a new password to update.
                              </DialogDescription>
                            </DialogHeader>
                            <div className="space-y-4 py-4">
                              <div className="space-y-2">
                                <Label htmlFor="currentPassword">Current Password</Label>
                                <Input
                                  id="currentPassword"
                                  type="password"
                                  value={passwordData.currentPassword}
                                  onChange={(e) => setPasswordData(prev => ({ ...prev, currentPassword: e.target.value }))}
                                />
                              </div>
                              <div className="space-y-2">
                                <Label htmlFor="newPassword">New Password</Label>
                                <Input
                                  id="newPassword"
                                  type="password"
                                  value={passwordData.newPassword}
                                  onChange={(e) => setPasswordData(prev => ({ ...prev, newPassword: e.target.value }))}
                                />
                              </div>
                              <div className="space-y-2">
                                <Label htmlFor="confirmPassword">Confirm New Password</Label>
                                <Input
                                  id="confirmPassword"
                                  type="password"
                                  value={passwordData.confirmPassword}
                                  onChange={(e) => setPasswordData(prev => ({ ...prev, confirmPassword: e.target.value }))}
                                />
                              </div>
                            </div>
                            <DialogFooter>
                              <Button onClick={handlePasswordChange}>Update Password</Button>
                            </DialogFooter>
                          </DialogContent>
                        </Dialog>
                      ) : (
                        <button
                          onClick={() => handleSettingClick(option.action)}
                          className="w-full flex items-center justify-between py-4 px-6 hover:bg-muted/50 transition-colors text-left"
                        >
                          <div className="flex items-center gap-3">
                            <option.icon className="h-5 w-5 text-primary" />
                            <span className="font-medium">{option.label}</span>
                          </div>
                          <Edit className="h-5 w-5 text-muted-foreground" />
                        </button>
                      )}
                    </div>
                  ))}
                  
                  {/* Delete Profile Option */}
                  <AlertDialog>
                    <AlertDialogTrigger asChild>
                      <button className="w-full flex items-center justify-between py-4 px-6 hover:bg-destructive/10 transition-colors text-left">
                        <div className="flex items-center gap-3">
                          <Trash2 className="h-5 w-5 text-destructive" />
                          <span className="font-medium text-destructive">Delete Profile</span>
                        </div>
                        <Trash2 className="h-5 w-5 text-destructive" />
                      </button>
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
                        <AlertDialogAction 
                          onClick={handleDeleteAccount}
                          className="bg-destructive text-destructive-foreground hover:bg-destructive/90"
                        >
                          Delete Account
                        </AlertDialogAction>
                      </AlertDialogFooter>
                    </AlertDialogContent>
                  </AlertDialog>
                </div>
              </CardContent>
            </Card>

            {/* Profile Trust Status */}
            <Card>
              <CardHeader className="pb-2">
                <CardTitle className="text-lg">Profile Trust Status</CardTitle>
              </CardHeader>
              <CardContent>
                <div className="space-y-4">
                  {trustStatus.map((item, index) => (
                    <div 
                      key={index}
                      className="flex items-center justify-between py-3 px-4 rounded-lg bg-muted/30"
                    >
                      <div className="flex items-center gap-3">
                        <item.icon className="h-5 w-5 text-muted-foreground" />
                        <span className="font-medium">{item.label}</span>
                      </div>
                      {item.verified ? (
                        <CheckCircle2 className="h-6 w-6 text-green-600" />
                      ) : (
                        <Button size="sm" variant="outline">Verify</Button>
                      )}
                    </div>
                  ))}
                </div>
                <p className="text-sm text-muted-foreground text-center mt-6 px-4">
                  By verifying email address, mobile number, and Photo Id Proof trust score will be increased. 
                  Profile having good trust score gets more interest from other users.
                </p>
              </CardContent>
            </Card>
          </div>
        </main>
      </div>
    </div>
  );
};

export default Settings;
