import { useState, useEffect } from "react";
import { Plus, Search, Edit, Trash2, MoreVertical, UserCheck, Crown, Eye, EyeOff, User, Shield, Ban } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Card, CardContent } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from "@/components/ui/dialog";
import { Label } from "@/components/ui/label";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Switch } from "@/components/ui/switch";
import { Textarea } from "@/components/ui/textarea";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";
import { ScrollArea } from "@/components/ui/scroll-area";
import AdminLayout from "@/components/admin/AdminLayout";
import { supabase } from "@/integrations/supabase/client";
import { useToast } from "@/hooks/use-toast";
import { format, addMonths } from "date-fns";

interface Profile {
  id: string;
  matri_id: string;
  email: string | null;
  phone: string | null;
  first_name: string;
  last_name: string | null;
  gender: string;
  date_of_birth: string | null;
  age: number | null;
  height: string | null;
  religion: string | null;
  caste: string | null;
  education: string | null;
  occupation: string | null;
  annual_income: string | null;
  state: string | null;
  city: string | null;
  marital_status: string | null;
  about_me: string | null;
  status: string;
  is_verified: boolean;
  is_premium: boolean;
  membership_plan_id: string | null;
  membership_end_date: string | null;
  created_at: string;
}

interface MembershipPlan {
  id: string;
  name: string;
  slug: string;
  duration_months: number;
  price: number;
  category: string;
}

const emptyProfile: Partial<Profile> = {
  first_name: "",
  last_name: "",
  email: "",
  phone: "",
  gender: "male",
  marital_status: "Never Married",
  religion: "Buddhist",
  caste: "",
  education: "",
  occupation: "",
  annual_income: "",
  state: "",
  city: "",
  about_me: "",
  status: "pending",
  is_verified: false,
  is_premium: false,
};

const casteOptions = ["Mahar", "Nav Bauddha", "Bauddha", "Other"];
const maritalStatusOptions = ["Never Married", "Divorced", "Widowed", "Awaiting Divorce"];
const educationOptions = ["10th Pass", "12th Pass", "Diploma", "Graduate", "Post Graduate", "Doctorate", "Other"];
const stateOptions = ["Maharashtra", "Madhya Pradesh", "Karnataka", "Gujarat", "Rajasthan", "Uttar Pradesh", "Delhi", "Other"];

const AdminProfiles = () => {
  const [profiles, setProfiles] = useState<Profile[]>([]);
  const [plans, setPlans] = useState<MembershipPlan[]>([]);
  const [searchQuery, setSearchQuery] = useState("");
  const [statusFilter, setStatusFilter] = useState<string>("all");
  const [isLoading, setIsLoading] = useState(true);
  const [isDialogOpen, setIsDialogOpen] = useState(false);
  const [editingProfile, setEditingProfile] = useState<Partial<Profile> | null>(null);
  const [isDeleteDialogOpen, setIsDeleteDialogOpen] = useState(false);
  const [profileToDelete, setProfileToDelete] = useState<Profile | null>(null);
  const [isUpgradeDialogOpen, setIsUpgradeDialogOpen] = useState(false);
  const [profileToUpgrade, setProfileToUpgrade] = useState<Profile | null>(null);
  const [selectedPlanId, setSelectedPlanId] = useState<string>("");
  const [activateImmediately, setActivateImmediately] = useState(true);
  const { toast } = useToast();

  const fetchProfiles = async () => {
    setIsLoading(true);
    const { data, error } = await supabase
      .from("profiles")
      .select("*")
      .order("created_at", { ascending: false });

    if (error) {
      toast({ title: "Error", description: "Failed to load profiles", variant: "destructive" });
    } else {
      setProfiles(data || []);
    }
    setIsLoading(false);
  };

  const fetchPlans = async () => {
    const { data } = await supabase
      .from("membership_plans")
      .select("*")
      .eq("is_active", true)
      .order("sort_order");
    if (data) setPlans(data);
  };

  useEffect(() => {
    fetchProfiles();
    fetchPlans();
  }, []);

  const filteredProfiles = profiles.filter((profile) => {
    const matchesSearch =
      profile.first_name.toLowerCase().includes(searchQuery.toLowerCase()) ||
      profile.matri_id.toLowerCase().includes(searchQuery.toLowerCase()) ||
      (profile.email?.toLowerCase().includes(searchQuery.toLowerCase()) ?? false) ||
      (profile.phone?.includes(searchQuery) ?? false);

    const matchesStatus = statusFilter === "all" || profile.status === statusFilter;

    return matchesSearch && matchesStatus;
  });

  const handleAddNew = () => {
    setEditingProfile({ ...emptyProfile });
    setActivateImmediately(true);
    setIsDialogOpen(true);
  };

  const handleEdit = (profile: Profile) => {
    setEditingProfile({ ...profile });
    setIsDialogOpen(true);
  };

  const handleSave = async () => {
    if (!editingProfile?.first_name || !editingProfile?.gender) {
      toast({ title: "Error", description: "Name and gender are required", variant: "destructive" });
      return;
    }

    const profileData = {
      first_name: editingProfile.first_name,
      last_name: editingProfile.last_name || null,
      email: editingProfile.email || null,
      phone: editingProfile.phone || null,
      gender: editingProfile.gender,
      marital_status: editingProfile.marital_status || "Never Married",
      religion: editingProfile.religion || "Buddhist",
      caste: editingProfile.caste || null,
      education: editingProfile.education || null,
      occupation: editingProfile.occupation || null,
      annual_income: editingProfile.annual_income || null,
      state: editingProfile.state || null,
      city: editingProfile.city || null,
      about_me: editingProfile.about_me || null,
      status: activateImmediately ? "active" : (editingProfile.status || "pending"),
      is_verified: editingProfile.is_verified || false,
      is_premium: editingProfile.is_premium || false,
    };

    if (editingProfile.id) {
      // Update existing
      const { error } = await supabase
        .from("profiles")
        .update(profileData)
        .eq("id", editingProfile.id);

      if (error) {
        toast({ title: "Error", description: error.message, variant: "destructive" });
        return;
      }
      toast({ title: "Success", description: "Profile updated successfully" });
    } else {
      // Create new - matri_id will be auto-generated
      const { error } = await supabase.from("profiles").insert({
        ...profileData,
        matri_id: "", // Will be auto-generated by trigger
      });

      if (error) {
        toast({ title: "Error", description: error.message, variant: "destructive" });
        return;
      }
      toast({ title: "Success", description: "Profile created successfully" });
    }

    setIsDialogOpen(false);
    setEditingProfile(null);
    fetchProfiles();
  };

  const handleDelete = async () => {
    if (!profileToDelete) return;

    const { error } = await supabase.from("profiles").delete().eq("id", profileToDelete.id);

    if (error) {
      toast({ title: "Error", description: "Failed to delete profile", variant: "destructive" });
    } else {
      toast({ title: "Success", description: "Profile deleted successfully" });
      fetchProfiles();
    }

    setIsDeleteDialogOpen(false);
    setProfileToDelete(null);
  };

  const handleStatusChange = async (profile: Profile, newStatus: string) => {
    const { error } = await supabase
      .from("profiles")
      .update({ status: newStatus })
      .eq("id", profile.id);

    if (error) {
      toast({ title: "Error", description: "Failed to update status", variant: "destructive" });
    } else {
      toast({ title: "Success", description: `Profile ${newStatus}` });
      fetchProfiles();
    }
  };

  const handleUpgrade = async () => {
    if (!profileToUpgrade || !selectedPlanId) return;

    const plan = plans.find((p) => p.id === selectedPlanId);
    if (!plan) return;

    const startDate = new Date();
    const endDate = addMonths(startDate, plan.duration_months);

    const { error } = await supabase
      .from("profiles")
      .update({
        membership_plan_id: selectedPlanId,
        membership_start_date: startDate.toISOString(),
        membership_end_date: endDate.toISOString(),
        is_premium: true,
        status: "active",
        contacts_used: 0,
        messages_used: 0,
      })
      .eq("id", profileToUpgrade.id);

    if (error) {
      toast({ title: "Error", description: "Failed to upgrade membership", variant: "destructive" });
    } else {
      toast({ title: "Success", description: `Upgraded to ${plan.name} plan` });
      fetchProfiles();
    }

    setIsUpgradeDialogOpen(false);
    setProfileToUpgrade(null);
    setSelectedPlanId("");
  };

  const getStatusBadge = (status: string) => {
    const styles: Record<string, string> = {
      active: "bg-green-500/20 text-green-400 border-green-500/30",
      pending: "bg-yellow-500/20 text-yellow-400 border-yellow-500/30",
      suspended: "bg-red-500/20 text-red-400 border-red-500/30",
      deleted: "bg-slate-500/20 text-slate-400 border-slate-500/30",
    };
    return <Badge className={styles[status] || styles.pending}>{status}</Badge>;
  };

  return (
    <AdminLayout>
      <div className="p-6 space-y-6">
        {/* Header */}
        <div className="flex flex-col sm:flex-row justify-between gap-4">
          <div>
            <h1 className="text-2xl font-bold text-white">Manage Profiles</h1>
            <p className="text-slate-400">Add, edit, and manage user profiles</p>
          </div>
          <div className="flex flex-wrap gap-3">
            <div className="relative w-full sm:w-64">
              <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
              <Input
                placeholder="Search profiles..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="pl-10 bg-slate-800 border-slate-700 text-white"
              />
            </div>
            <Select value={statusFilter} onValueChange={setStatusFilter}>
              <SelectTrigger className="w-32 bg-slate-800 border-slate-700 text-white">
                <SelectValue />
              </SelectTrigger>
              <SelectContent className="bg-slate-800 border-slate-700">
                <SelectItem value="all">All Status</SelectItem>
                <SelectItem value="active">Active</SelectItem>
                <SelectItem value="pending">Pending</SelectItem>
                <SelectItem value="suspended">Suspended</SelectItem>
              </SelectContent>
            </Select>
            <Button onClick={handleAddNew} className="bg-primary hover:bg-primary/90">
              <Plus className="h-4 w-4 mr-2" /> Add Profile
            </Button>
          </div>
        </div>

        {/* Stats */}
        <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
          <Card className="bg-slate-800/50 border-slate-700">
            <CardContent className="p-4">
              <div className="text-2xl font-bold text-white">{profiles.length}</div>
              <div className="text-sm text-slate-400">Total Profiles</div>
            </CardContent>
          </Card>
          <Card className="bg-slate-800/50 border-slate-700">
            <CardContent className="p-4">
              <div className="text-2xl font-bold text-green-400">{profiles.filter((p) => p.status === "active").length}</div>
              <div className="text-sm text-slate-400">Active</div>
            </CardContent>
          </Card>
          <Card className="bg-slate-800/50 border-slate-700">
            <CardContent className="p-4">
              <div className="text-2xl font-bold text-yellow-400">{profiles.filter((p) => p.status === "pending").length}</div>
              <div className="text-sm text-slate-400">Pending</div>
            </CardContent>
          </Card>
          <Card className="bg-slate-800/50 border-slate-700">
            <CardContent className="p-4">
              <div className="text-2xl font-bold text-amber-400">{profiles.filter((p) => p.is_premium).length}</div>
              <div className="text-sm text-slate-400">Premium</div>
            </CardContent>
          </Card>
        </div>

        {/* Profiles Table */}
        <Card className="bg-slate-800/50 border-slate-700">
          <CardContent className="p-0">
            <Table>
              <TableHeader>
                <TableRow className="border-slate-700 hover:bg-transparent">
                  <TableHead className="text-slate-400">Matri ID</TableHead>
                  <TableHead className="text-slate-400">Name</TableHead>
                  <TableHead className="text-slate-400">Contact</TableHead>
                  <TableHead className="text-slate-400">Gender</TableHead>
                  <TableHead className="text-slate-400">Location</TableHead>
                  <TableHead className="text-slate-400">Status</TableHead>
                  <TableHead className="text-slate-400">Membership</TableHead>
                  <TableHead className="text-slate-400 text-right">Actions</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {isLoading ? (
                  <TableRow>
                    <TableCell colSpan={8} className="text-center text-slate-400 py-8">
                      Loading profiles...
                    </TableCell>
                  </TableRow>
                ) : filteredProfiles.length === 0 ? (
                  <TableRow>
                    <TableCell colSpan={8} className="text-center text-slate-400 py-8">
                      No profiles found
                    </TableCell>
                  </TableRow>
                ) : (
                  filteredProfiles.map((profile) => (
                    <TableRow key={profile.id} className="border-slate-700 hover:bg-slate-800/50">
                      <TableCell className="text-primary font-medium">{profile.matri_id}</TableCell>
                      <TableCell>
                        <div className="flex items-center gap-2">
                          <span className="text-white">{profile.first_name} {profile.last_name}</span>
                          {profile.is_verified && (
                            <Shield className="h-4 w-4 text-blue-400" />
                          )}
                        </div>
                      </TableCell>
                      <TableCell className="text-slate-300">
                        <div className="text-xs">
                          {profile.email && <div>{profile.email}</div>}
                          {profile.phone && <div>{profile.phone}</div>}
                        </div>
                      </TableCell>
                      <TableCell className="text-slate-300 capitalize">{profile.gender}</TableCell>
                      <TableCell className="text-slate-300">
                        {profile.city && profile.state ? `${profile.city}, ${profile.state}` : "-"}
                      </TableCell>
                      <TableCell>{getStatusBadge(profile.status)}</TableCell>
                      <TableCell>
                        {profile.is_premium ? (
                          <Badge className="bg-amber-500/20 text-amber-400 border-amber-500/30">
                            <Crown className="h-3 w-3 mr-1" /> Premium
                          </Badge>
                        ) : (
                          <Badge variant="outline" className="border-slate-600 text-slate-400">Free</Badge>
                        )}
                      </TableCell>
                      <TableCell className="text-right">
                        <DropdownMenu>
                          <DropdownMenuTrigger asChild>
                            <Button variant="ghost" size="icon" className="text-slate-400 hover:text-white">
                              <MoreVertical className="h-4 w-4" />
                            </Button>
                          </DropdownMenuTrigger>
                          <DropdownMenuContent align="end" className="bg-slate-800 border-slate-700">
                            <DropdownMenuItem onClick={() => handleEdit(profile)} className="text-slate-300 hover:text-white focus:text-white focus:bg-slate-700">
                              <Edit className="mr-2 h-4 w-4" /> Edit Profile
                            </DropdownMenuItem>
                            <DropdownMenuItem 
                              onClick={() => {
                                setProfileToUpgrade(profile);
                                setIsUpgradeDialogOpen(true);
                              }} 
                              className="text-slate-300 hover:text-white focus:text-white focus:bg-slate-700"
                            >
                              <Crown className="mr-2 h-4 w-4" /> Upgrade Membership
                            </DropdownMenuItem>
                            <DropdownMenuSeparator className="bg-slate-700" />
                            {profile.status !== "active" && (
                              <DropdownMenuItem onClick={() => handleStatusChange(profile, "active")} className="text-green-400 hover:text-green-300 focus:text-green-300 focus:bg-slate-700">
                                <UserCheck className="mr-2 h-4 w-4" /> Activate
                              </DropdownMenuItem>
                            )}
                            {profile.status !== "suspended" && (
                              <DropdownMenuItem onClick={() => handleStatusChange(profile, "suspended")} className="text-yellow-400 hover:text-yellow-300 focus:text-yellow-300 focus:bg-slate-700">
                                <Ban className="mr-2 h-4 w-4" /> Suspend
                              </DropdownMenuItem>
                            )}
                            <DropdownMenuItem
                              onClick={() => {
                                setProfileToDelete(profile);
                                setIsDeleteDialogOpen(true);
                              }}
                              className="text-red-400 hover:text-red-300 focus:text-red-300 focus:bg-slate-700"
                            >
                              <Trash2 className="mr-2 h-4 w-4" /> Delete
                            </DropdownMenuItem>
                          </DropdownMenuContent>
                        </DropdownMenu>
                      </TableCell>
                    </TableRow>
                  ))
                )}
              </TableBody>
            </Table>
          </CardContent>
        </Card>

        {/* Add/Edit Profile Dialog */}
        <Dialog open={isDialogOpen} onOpenChange={setIsDialogOpen}>
          <DialogContent className="bg-slate-900 border-slate-700 text-white max-w-3xl max-h-[90vh]">
            <DialogHeader>
              <DialogTitle>{editingProfile?.id ? "Edit Profile" : "Add New Profile"}</DialogTitle>
              <DialogDescription className="text-slate-400">
                {editingProfile?.id ? "Update profile details" : "Fill in the profile details. Matri ID will be auto-generated."}
              </DialogDescription>
            </DialogHeader>

            {editingProfile && (
              <ScrollArea className="max-h-[60vh] pr-4">
                <Tabs defaultValue="personal" className="w-full">
                  <TabsList className="grid w-full grid-cols-3 bg-slate-800">
                    <TabsTrigger value="personal">Personal</TabsTrigger>
                    <TabsTrigger value="education">Education & Work</TabsTrigger>
                    <TabsTrigger value="other">Other Details</TabsTrigger>
                  </TabsList>

                  <TabsContent value="personal" className="space-y-4 mt-4">
                    <div className="grid grid-cols-2 gap-4">
                      <div className="space-y-2">
                        <Label>First Name *</Label>
                        <Input
                          value={editingProfile.first_name || ""}
                          onChange={(e) => setEditingProfile({ ...editingProfile, first_name: e.target.value })}
                          className="bg-slate-800 border-slate-700"
                        />
                      </div>
                      <div className="space-y-2">
                        <Label>Last Name</Label>
                        <Input
                          value={editingProfile.last_name || ""}
                          onChange={(e) => setEditingProfile({ ...editingProfile, last_name: e.target.value })}
                          className="bg-slate-800 border-slate-700"
                        />
                      </div>
                    </div>

                    <div className="grid grid-cols-2 gap-4">
                      <div className="space-y-2">
                        <Label>Email</Label>
                        <Input
                          type="email"
                          value={editingProfile.email || ""}
                          onChange={(e) => setEditingProfile({ ...editingProfile, email: e.target.value })}
                          className="bg-slate-800 border-slate-700"
                        />
                      </div>
                      <div className="space-y-2">
                        <Label>Phone</Label>
                        <Input
                          value={editingProfile.phone || ""}
                          onChange={(e) => setEditingProfile({ ...editingProfile, phone: e.target.value })}
                          className="bg-slate-800 border-slate-700"
                        />
                      </div>
                    </div>

                    <div className="grid grid-cols-2 gap-4">
                      <div className="space-y-2">
                        <Label>Gender *</Label>
                        <Select
                          value={editingProfile.gender}
                          onValueChange={(value) => setEditingProfile({ ...editingProfile, gender: value })}
                        >
                          <SelectTrigger className="bg-slate-800 border-slate-700">
                            <SelectValue />
                          </SelectTrigger>
                          <SelectContent className="bg-slate-800 border-slate-700">
                            <SelectItem value="male">Male</SelectItem>
                            <SelectItem value="female">Female</SelectItem>
                          </SelectContent>
                        </Select>
                      </div>
                      <div className="space-y-2">
                        <Label>Marital Status</Label>
                        <Select
                          value={editingProfile.marital_status || "Never Married"}
                          onValueChange={(value) => setEditingProfile({ ...editingProfile, marital_status: value })}
                        >
                          <SelectTrigger className="bg-slate-800 border-slate-700">
                            <SelectValue />
                          </SelectTrigger>
                          <SelectContent className="bg-slate-800 border-slate-700">
                            {maritalStatusOptions.map((status) => (
                              <SelectItem key={status} value={status}>{status}</SelectItem>
                            ))}
                          </SelectContent>
                        </Select>
                      </div>
                    </div>

                    <div className="grid grid-cols-2 gap-4">
                      <div className="space-y-2">
                        <Label>Religion</Label>
                        <Input
                          value={editingProfile.religion || "Buddhist"}
                          onChange={(e) => setEditingProfile({ ...editingProfile, religion: e.target.value })}
                          className="bg-slate-800 border-slate-700"
                        />
                      </div>
                      <div className="space-y-2">
                        <Label>Caste</Label>
                        <Select
                          value={editingProfile.caste || ""}
                          onValueChange={(value) => setEditingProfile({ ...editingProfile, caste: value })}
                        >
                          <SelectTrigger className="bg-slate-800 border-slate-700">
                            <SelectValue placeholder="Select caste" />
                          </SelectTrigger>
                          <SelectContent className="bg-slate-800 border-slate-700">
                            {casteOptions.map((caste) => (
                              <SelectItem key={caste} value={caste}>{caste}</SelectItem>
                            ))}
                          </SelectContent>
                        </Select>
                      </div>
                    </div>
                  </TabsContent>

                  <TabsContent value="education" className="space-y-4 mt-4">
                    <div className="grid grid-cols-2 gap-4">
                      <div className="space-y-2">
                        <Label>Education</Label>
                        <Select
                          value={editingProfile.education || ""}
                          onValueChange={(value) => setEditingProfile({ ...editingProfile, education: value })}
                        >
                          <SelectTrigger className="bg-slate-800 border-slate-700">
                            <SelectValue placeholder="Select education" />
                          </SelectTrigger>
                          <SelectContent className="bg-slate-800 border-slate-700">
                            {educationOptions.map((edu) => (
                              <SelectItem key={edu} value={edu}>{edu}</SelectItem>
                            ))}
                          </SelectContent>
                        </Select>
                      </div>
                      <div className="space-y-2">
                        <Label>Occupation</Label>
                        <Input
                          value={editingProfile.occupation || ""}
                          onChange={(e) => setEditingProfile({ ...editingProfile, occupation: e.target.value })}
                          className="bg-slate-800 border-slate-700"
                        />
                      </div>
                    </div>

                    <div className="space-y-2">
                      <Label>Annual Income</Label>
                      <Input
                        value={editingProfile.annual_income || ""}
                        onChange={(e) => setEditingProfile({ ...editingProfile, annual_income: e.target.value })}
                        className="bg-slate-800 border-slate-700"
                        placeholder="e.g., 5-10 Lakhs"
                      />
                    </div>
                  </TabsContent>

                  <TabsContent value="other" className="space-y-4 mt-4">
                    <div className="grid grid-cols-2 gap-4">
                      <div className="space-y-2">
                        <Label>State</Label>
                        <Select
                          value={editingProfile.state || ""}
                          onValueChange={(value) => setEditingProfile({ ...editingProfile, state: value })}
                        >
                          <SelectTrigger className="bg-slate-800 border-slate-700">
                            <SelectValue placeholder="Select state" />
                          </SelectTrigger>
                          <SelectContent className="bg-slate-800 border-slate-700">
                            {stateOptions.map((state) => (
                              <SelectItem key={state} value={state}>{state}</SelectItem>
                            ))}
                          </SelectContent>
                        </Select>
                      </div>
                      <div className="space-y-2">
                        <Label>City</Label>
                        <Input
                          value={editingProfile.city || ""}
                          onChange={(e) => setEditingProfile({ ...editingProfile, city: e.target.value })}
                          className="bg-slate-800 border-slate-700"
                        />
                      </div>
                    </div>

                    <div className="space-y-2">
                      <Label>About Me</Label>
                      <Textarea
                        value={editingProfile.about_me || ""}
                        onChange={(e) => setEditingProfile({ ...editingProfile, about_me: e.target.value })}
                        className="bg-slate-800 border-slate-700 min-h-[100px]"
                        placeholder="Write about yourself..."
                      />
                    </div>

                    <div className="flex items-center gap-6 pt-4">
                      <div className="flex items-center gap-2">
                        <Switch
                          checked={editingProfile.is_verified}
                          onCheckedChange={(checked) => setEditingProfile({ ...editingProfile, is_verified: checked })}
                        />
                        <Label>Verified</Label>
                      </div>
                      {!editingProfile.id && (
                        <div className="flex items-center gap-2">
                          <Switch
                            checked={activateImmediately}
                            onCheckedChange={setActivateImmediately}
                          />
                          <Label>Activate Immediately</Label>
                        </div>
                      )}
                    </div>
                  </TabsContent>
                </Tabs>
              </ScrollArea>
            )}

            <DialogFooter>
              <Button variant="outline" onClick={() => setIsDialogOpen(false)} className="border-slate-600">
                Cancel
              </Button>
              <Button onClick={handleSave} className="bg-primary hover:bg-primary/90">
                {editingProfile?.id ? "Update Profile" : "Create Profile"}
              </Button>
            </DialogFooter>
          </DialogContent>
        </Dialog>

        {/* Upgrade Membership Dialog */}
        <Dialog open={isUpgradeDialogOpen} onOpenChange={setIsUpgradeDialogOpen}>
          <DialogContent className="bg-slate-900 border-slate-700 text-white">
            <DialogHeader>
              <DialogTitle>Upgrade Membership</DialogTitle>
              <DialogDescription className="text-slate-400">
                Select a membership plan for {profileToUpgrade?.first_name} ({profileToUpgrade?.matri_id})
              </DialogDescription>
            </DialogHeader>

            <div className="space-y-4 py-4">
              <div className="space-y-2">
                <Label>Select Plan</Label>
                <Select value={selectedPlanId} onValueChange={setSelectedPlanId}>
                  <SelectTrigger className="bg-slate-800 border-slate-700">
                    <SelectValue placeholder="Choose a plan" />
                  </SelectTrigger>
                  <SelectContent className="bg-slate-800 border-slate-700">
                    {plans.map((plan) => (
                      <SelectItem key={plan.id} value={plan.id}>
                        <div className="flex items-center justify-between gap-4">
                          <span>{plan.name}</span>
                          <span className="text-slate-400">₹{plan.price.toLocaleString()} - {plan.duration_months} months</span>
                        </div>
                      </SelectItem>
                    ))}
                  </SelectContent>
                </Select>
              </div>

              {selectedPlanId && (
                <div className="p-4 bg-slate-800 rounded-lg">
                  <p className="text-sm text-slate-400">
                    Membership will start immediately and be valid for{" "}
                    <span className="text-white font-medium">
                      {plans.find((p) => p.id === selectedPlanId)?.duration_months} months
                    </span>
                  </p>
                </div>
              )}
            </div>

            <DialogFooter>
              <Button variant="outline" onClick={() => setIsUpgradeDialogOpen(false)} className="border-slate-600">
                Cancel
              </Button>
              <Button onClick={handleUpgrade} disabled={!selectedPlanId} className="bg-amber-500 hover:bg-amber-600">
                <Crown className="h-4 w-4 mr-2" /> Upgrade
              </Button>
            </DialogFooter>
          </DialogContent>
        </Dialog>

        {/* Delete Confirmation Dialog */}
        <Dialog open={isDeleteDialogOpen} onOpenChange={setIsDeleteDialogOpen}>
          <DialogContent className="bg-slate-900 border-slate-700 text-white">
            <DialogHeader>
              <DialogTitle>Delete Profile</DialogTitle>
              <DialogDescription className="text-slate-400">
                Are you sure you want to delete profile "{profileToDelete?.first_name}" ({profileToDelete?.matri_id})? This action cannot be undone.
              </DialogDescription>
            </DialogHeader>
            <DialogFooter>
              <Button variant="outline" onClick={() => setIsDeleteDialogOpen(false)} className="border-slate-600">
                Cancel
              </Button>
              <Button onClick={handleDelete} variant="destructive">
                Delete
              </Button>
            </DialogFooter>
          </DialogContent>
        </Dialog>
      </div>
    </AdminLayout>
  );
};

export default AdminProfiles;
