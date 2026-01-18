import { useState, useEffect } from "react";
import { supabase } from "@/integrations/supabase/client";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/components/ui/dialog";
import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { toast } from "sonner";
import { Shield, Plus, Trash2, Users, Crown, UserCheck } from "lucide-react";
import AdminSidebar from "@/components/admin/AdminSidebar";
import AdminGuard from "@/components/admin/AdminGuard";

type AppRole = "admin" | "moderator" | "user";

interface UserRole {
  id: string;
  user_id: string;
  role: AppRole;
  created_at: string;
  user_email?: string;
}

const AdminRoles = () => {
  const [userRoles, setUserRoles] = useState<UserRole[]>([]);
  const [loading, setLoading] = useState(true);
  const [dialogOpen, setDialogOpen] = useState(false);
  const [newUserEmail, setNewUserEmail] = useState("");
  const [newRole, setNewRole] = useState<AppRole>("user");
  const [saving, setSaving] = useState(false);

  useEffect(() => {
    fetchUserRoles();
  }, []);

  const fetchUserRoles = async () => {
    try {
      const { data, error } = await supabase
        .from("user_roles")
        .select("*")
        .order("created_at", { ascending: false });

      if (error) throw error;
      setUserRoles(data || []);
    } catch (error) {
      console.error("Error fetching user roles:", error);
      toast.error("Failed to fetch user roles");
    } finally {
      setLoading(false);
    }
  };

  const handleAddRole = async () => {
    if (!newUserEmail.trim()) {
      toast.error("Please enter a user email");
      return;
    }

    setSaving(true);
    try {
      // First, find the user by email using auth admin API via edge function
      // For now, we'll ask for user ID directly or look up from profiles
      const { data: profile, error: profileError } = await supabase
        .from("profiles")
        .select("id, email")
        .eq("email", newUserEmail.trim())
        .single();

      if (profileError || !profile) {
        toast.error("User not found with this email. Make sure the user has a profile.");
        setSaving(false);
        return;
      }

      // Check if role already exists
      const { data: existingRole } = await supabase
        .from("user_roles")
        .select("id")
        .eq("user_id", profile.id)
        .eq("role", newRole)
        .single();

      if (existingRole) {
        toast.error("This user already has this role");
        setSaving(false);
        return;
      }

      const { error } = await supabase.from("user_roles").insert({
        user_id: profile.id,
        role: newRole,
      });

      if (error) throw error;

      toast.success("Role assigned successfully");
      setDialogOpen(false);
      setNewUserEmail("");
      setNewRole("user");
      fetchUserRoles();
    } catch (error: any) {
      console.error("Error adding role:", error);
      toast.error(error.message || "Failed to assign role");
    } finally {
      setSaving(false);
    }
  };

  const handleDeleteRole = async (id: string) => {
    if (!confirm("Are you sure you want to remove this role?")) return;

    try {
      const { error } = await supabase.from("user_roles").delete().eq("id", id);

      if (error) throw error;

      toast.success("Role removed successfully");
      fetchUserRoles();
    } catch (error) {
      console.error("Error deleting role:", error);
      toast.error("Failed to remove role");
    }
  };

  const getRoleBadgeVariant = (role: AppRole) => {
    switch (role) {
      case "admin":
        return "destructive";
      case "moderator":
        return "default";
      default:
        return "secondary";
    }
  };

  const getRoleIcon = (role: AppRole) => {
    switch (role) {
      case "admin":
        return <Crown className="h-3 w-3 mr-1" />;
      case "moderator":
        return <Shield className="h-3 w-3 mr-1" />;
      default:
        return <UserCheck className="h-3 w-3 mr-1" />;
    }
  };

  const stats = {
    total: userRoles.length,
    admins: userRoles.filter((r) => r.role === "admin").length,
    moderators: userRoles.filter((r) => r.role === "moderator").length,
    users: userRoles.filter((r) => r.role === "user").length,
  };

  return (
    <AdminGuard>
      <div className="flex min-h-screen bg-gray-100">
        <AdminSidebar />
        <div className="flex-1 p-8">
          <div className="max-w-6xl mx-auto">
            <div className="flex justify-between items-center mb-8">
              <div>
                <h1 className="text-3xl font-bold text-gray-900">
                  Roles & Access Management
                </h1>
                <p className="text-gray-600 mt-1">
                  Manage user roles and permissions
                </p>
              </div>
              <Dialog open={dialogOpen} onOpenChange={setDialogOpen}>
                <DialogTrigger asChild>
                  <Button>
                    <Plus className="h-4 w-4 mr-2" />
                    Assign Role
                  </Button>
                </DialogTrigger>
                <DialogContent>
                  <DialogHeader>
                    <DialogTitle>Assign Role to User</DialogTitle>
                  </DialogHeader>
                  <div className="space-y-4 mt-4">
                    <div>
                      <Label htmlFor="email">User Email</Label>
                      <Input
                        id="email"
                        type="email"
                        value={newUserEmail}
                        onChange={(e) => setNewUserEmail(e.target.value)}
                        placeholder="Enter user email"
                      />
                      <p className="text-xs text-gray-500 mt-1">
                        User must have a profile in the system
                      </p>
                    </div>
                    <div>
                      <Label htmlFor="role">Role</Label>
                      <Select
                        value={newRole}
                        onValueChange={(value: AppRole) => setNewRole(value)}
                      >
                        <SelectTrigger>
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="admin">
                            <div className="flex items-center">
                              <Crown className="h-4 w-4 mr-2 text-red-500" />
                              Admin - Full access
                            </div>
                          </SelectItem>
                          <SelectItem value="moderator">
                            <div className="flex items-center">
                              <Shield className="h-4 w-4 mr-2 text-blue-500" />
                              Moderator - Limited admin access
                            </div>
                          </SelectItem>
                          <SelectItem value="user">
                            <div className="flex items-center">
                              <UserCheck className="h-4 w-4 mr-2 text-green-500" />
                              User - Basic access
                            </div>
                          </SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                    <Button
                      onClick={handleAddRole}
                      disabled={saving}
                      className="w-full"
                    >
                      {saving ? "Assigning..." : "Assign Role"}
                    </Button>
                  </div>
                </DialogContent>
              </Dialog>
            </div>

            {/* Stats Cards */}
            <div className="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
              <Card>
                <CardHeader className="pb-2">
                  <CardTitle className="text-sm font-medium text-gray-600">
                    Total Roles
                  </CardTitle>
                </CardHeader>
                <CardContent>
                  <div className="flex items-center">
                    <Users className="h-8 w-8 text-gray-400 mr-3" />
                    <span className="text-2xl font-bold">{stats.total}</span>
                  </div>
                </CardContent>
              </Card>
              <Card>
                <CardHeader className="pb-2">
                  <CardTitle className="text-sm font-medium text-gray-600">
                    Admins
                  </CardTitle>
                </CardHeader>
                <CardContent>
                  <div className="flex items-center">
                    <Crown className="h-8 w-8 text-red-400 mr-3" />
                    <span className="text-2xl font-bold">{stats.admins}</span>
                  </div>
                </CardContent>
              </Card>
              <Card>
                <CardHeader className="pb-2">
                  <CardTitle className="text-sm font-medium text-gray-600">
                    Moderators
                  </CardTitle>
                </CardHeader>
                <CardContent>
                  <div className="flex items-center">
                    <Shield className="h-8 w-8 text-blue-400 mr-3" />
                    <span className="text-2xl font-bold">{stats.moderators}</span>
                  </div>
                </CardContent>
              </Card>
              <Card>
                <CardHeader className="pb-2">
                  <CardTitle className="text-sm font-medium text-gray-600">
                    Users
                  </CardTitle>
                </CardHeader>
                <CardContent>
                  <div className="flex items-center">
                    <UserCheck className="h-8 w-8 text-green-400 mr-3" />
                    <span className="text-2xl font-bold">{stats.users}</span>
                  </div>
                </CardContent>
              </Card>
            </div>

            {/* Roles Table */}
            <Card>
              <CardHeader>
                <CardTitle>User Roles</CardTitle>
              </CardHeader>
              <CardContent>
                {loading ? (
                  <div className="text-center py-8">Loading...</div>
                ) : userRoles.length === 0 ? (
                  <div className="text-center py-8 text-gray-500">
                    <Shield className="h-12 w-12 mx-auto mb-4 text-gray-300" />
                    <p>No roles assigned yet</p>
                    <p className="text-sm">
                      Click "Assign Role" to add the first admin
                    </p>
                  </div>
                ) : (
                  <Table>
                    <TableHeader>
                      <TableRow>
                        <TableHead>User ID</TableHead>
                        <TableHead>Role</TableHead>
                        <TableHead>Assigned On</TableHead>
                        <TableHead className="text-right">Actions</TableHead>
                      </TableRow>
                    </TableHeader>
                    <TableBody>
                      {userRoles.map((userRole) => (
                        <TableRow key={userRole.id}>
                          <TableCell className="font-mono text-sm">
                            {userRole.user_id.substring(0, 8)}...
                          </TableCell>
                          <TableCell>
                            <Badge variant={getRoleBadgeVariant(userRole.role)}>
                              <span className="flex items-center">
                                {getRoleIcon(userRole.role)}
                                {userRole.role.charAt(0).toUpperCase() +
                                  userRole.role.slice(1)}
                              </span>
                            </Badge>
                          </TableCell>
                          <TableCell>
                            {new Date(userRole.created_at).toLocaleDateString()}
                          </TableCell>
                          <TableCell className="text-right">
                            <Button
                              variant="ghost"
                              size="sm"
                              onClick={() => handleDeleteRole(userRole.id)}
                            >
                              <Trash2 className="h-4 w-4 text-red-500" />
                            </Button>
                          </TableCell>
                        </TableRow>
                      ))}
                    </TableBody>
                  </Table>
                )}
              </CardContent>
            </Card>
          </div>
        </div>
      </div>
    </AdminGuard>
  );
};

export default AdminRoles;
