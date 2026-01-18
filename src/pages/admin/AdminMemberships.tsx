import { useState, useEffect } from "react";
import { Plus, Search, Edit, Trash2, MoreVertical, Star, Zap, Check, X, Eye, EyeOff } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Card, CardContent } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from "@/components/ui/dialog";
import { Label } from "@/components/ui/label";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Switch } from "@/components/ui/switch";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";
import AdminLayout from "@/components/admin/AdminLayout";
import { supabase } from "@/integrations/supabase/client";
import { useToast } from "@/hooks/use-toast";

interface MembershipPlan {
  id: string;
  name: string;
  slug: string;
  duration: string;
  duration_months: number;
  category: string;
  view_contacts: number;
  send_messages: number;
  price: number;
  icon: string;
  color: string;
  bg_color: string;
  border_color: string;
  is_popular: boolean;
  is_active: boolean;
  sort_order: number;
  created_at: string;
  updated_at: string;
}

const emptyPlan: Partial<MembershipPlan> = {
  name: "",
  slug: "",
  duration: "3 Months",
  duration_months: 3,
  category: "online",
  view_contacts: 50,
  send_messages: 400,
  price: 2500,
  icon: "💎",
  color: "text-gray-800",
  bg_color: "bg-gradient-to-br from-gray-100 to-gray-200",
  border_color: "border-gray-300",
  is_popular: false,
  is_active: true,
  sort_order: 0,
};

const iconOptions = ["🥈", "🥇", "💎", "⚡", "👑", "💫", "🌟", "✨", "🎯", "🔥"];

const colorPresets = [
  { name: "Amber", color: "text-amber-800", bg: "bg-gradient-to-br from-amber-100 to-amber-200", border: "border-amber-300" },
  { name: "Yellow", color: "text-yellow-800", bg: "bg-gradient-to-br from-yellow-200 to-amber-300", border: "border-yellow-400" },
  { name: "Emerald", color: "text-emerald-800", bg: "bg-gradient-to-br from-emerald-200 to-teal-300", border: "border-emerald-400" },
  { name: "Slate", color: "text-slate-800", bg: "bg-gradient-to-br from-slate-200 to-slate-300", border: "border-slate-400" },
  { name: "Orange", color: "text-orange-800", bg: "bg-gradient-to-br from-orange-200 to-rose-300", border: "border-orange-400" },
  { name: "Purple", color: "text-purple-800", bg: "bg-gradient-to-br from-purple-200 to-violet-300", border: "border-purple-400" },
  { name: "Blue", color: "text-blue-800", bg: "bg-gradient-to-br from-blue-200 to-indigo-300", border: "border-blue-400" },
  { name: "Rose", color: "text-rose-800", bg: "bg-gradient-to-br from-rose-200 to-pink-300", border: "border-rose-400" },
];

const AdminMemberships = () => {
  const [plans, setPlans] = useState<MembershipPlan[]>([]);
  const [searchQuery, setSearchQuery] = useState("");
  const [isLoading, setIsLoading] = useState(true);
  const [isDialogOpen, setIsDialogOpen] = useState(false);
  const [editingPlan, setEditingPlan] = useState<Partial<MembershipPlan> | null>(null);
  const [isDeleteDialogOpen, setIsDeleteDialogOpen] = useState(false);
  const [planToDelete, setPlanToDelete] = useState<MembershipPlan | null>(null);
  const { toast } = useToast();

  const fetchPlans = async () => {
    setIsLoading(true);
    const { data, error } = await supabase
      .from("membership_plans")
      .select("*")
      .order("sort_order", { ascending: true });

    if (error) {
      toast({ title: "Error", description: "Failed to load plans", variant: "destructive" });
    } else {
      setPlans(data || []);
    }
    setIsLoading(false);
  };

  useEffect(() => {
    fetchPlans();
  }, []);

  const filteredPlans = plans.filter(
    (plan) =>
      plan.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
      plan.category.toLowerCase().includes(searchQuery.toLowerCase())
  );

  const handleAddNew = () => {
    setEditingPlan({ ...emptyPlan });
    setIsDialogOpen(true);
  };

  const handleEdit = (plan: MembershipPlan) => {
    setEditingPlan({ ...plan });
    setIsDialogOpen(true);
  };

  const handleSave = async () => {
    if (!editingPlan?.name || !editingPlan?.slug) {
      toast({ title: "Error", description: "Name and slug are required", variant: "destructive" });
      return;
    }

    if (editingPlan.id) {
      // Update existing
      const { error } = await supabase
        .from("membership_plans")
        .update({
          name: editingPlan.name,
          slug: editingPlan.slug,
          duration: editingPlan.duration,
          duration_months: editingPlan.duration_months,
          category: editingPlan.category,
          view_contacts: editingPlan.view_contacts,
          send_messages: editingPlan.send_messages,
          price: editingPlan.price,
          icon: editingPlan.icon,
          color: editingPlan.color,
          bg_color: editingPlan.bg_color,
          border_color: editingPlan.border_color,
          is_popular: editingPlan.is_popular,
          is_active: editingPlan.is_active,
          sort_order: editingPlan.sort_order,
        })
        .eq("id", editingPlan.id);

      if (error) {
        toast({ title: "Error", description: "Failed to update plan", variant: "destructive" });
        return;
      }
      toast({ title: "Success", description: "Plan updated successfully" });
    } else {
      // Create new
      const { error } = await supabase.from("membership_plans").insert({
        name: editingPlan.name,
        slug: editingPlan.slug,
        duration: editingPlan.duration,
        duration_months: editingPlan.duration_months,
        category: editingPlan.category,
        view_contacts: editingPlan.view_contacts,
        send_messages: editingPlan.send_messages,
        price: editingPlan.price,
        icon: editingPlan.icon,
        color: editingPlan.color,
        bg_color: editingPlan.bg_color,
        border_color: editingPlan.border_color,
        is_popular: editingPlan.is_popular,
        is_active: editingPlan.is_active,
        sort_order: editingPlan.sort_order,
      });

      if (error) {
        toast({ title: "Error", description: error.message, variant: "destructive" });
        return;
      }
      toast({ title: "Success", description: "Plan created successfully" });
    }

    setIsDialogOpen(false);
    setEditingPlan(null);
    fetchPlans();
  };

  const handleDelete = async () => {
    if (!planToDelete) return;

    const { error } = await supabase.from("membership_plans").delete().eq("id", planToDelete.id);

    if (error) {
      toast({ title: "Error", description: "Failed to delete plan", variant: "destructive" });
    } else {
      toast({ title: "Success", description: "Plan deleted successfully" });
      fetchPlans();
    }

    setIsDeleteDialogOpen(false);
    setPlanToDelete(null);
  };

  const toggleActive = async (plan: MembershipPlan) => {
    const { error } = await supabase
      .from("membership_plans")
      .update({ is_active: !plan.is_active })
      .eq("id", plan.id);

    if (error) {
      toast({ title: "Error", description: "Failed to update plan", variant: "destructive" });
    } else {
      fetchPlans();
    }
  };

  const togglePopular = async (plan: MembershipPlan) => {
    const { error } = await supabase
      .from("membership_plans")
      .update({ is_popular: !plan.is_popular })
      .eq("id", plan.id);

    if (error) {
      toast({ title: "Error", description: "Failed to update plan", variant: "destructive" });
    } else {
      fetchPlans();
    }
  };

  const applyColorPreset = (preset: typeof colorPresets[0]) => {
    if (editingPlan) {
      setEditingPlan({
        ...editingPlan,
        color: preset.color,
        bg_color: preset.bg,
        border_color: preset.border,
      });
    }
  };

  return (
    <AdminLayout>
      <div className="p-6 space-y-6">
        {/* Header */}
        <div className="flex flex-col sm:flex-row justify-between gap-4">
          <div>
            <h1 className="text-2xl font-bold text-white">Membership Plans</h1>
            <p className="text-slate-400">Manage and configure membership plans</p>
          </div>
          <div className="flex gap-3">
            <div className="relative w-full sm:w-64">
              <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
              <Input
                placeholder="Search plans..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="pl-10 bg-slate-800 border-slate-700 text-white"
              />
            </div>
            <Button onClick={handleAddNew} className="bg-primary hover:bg-primary/90">
              <Plus className="h-4 w-4 mr-2" /> Add Plan
            </Button>
          </div>
        </div>

        {/* Plans Table */}
        <Card className="bg-slate-800/50 border-slate-700">
          <CardContent className="p-0">
            <Table>
              <TableHeader>
                <TableRow className="border-slate-700 hover:bg-transparent">
                  <TableHead className="text-slate-400">Plan</TableHead>
                  <TableHead className="text-slate-400">Category</TableHead>
                  <TableHead className="text-slate-400">Duration</TableHead>
                  <TableHead className="text-slate-400">Contacts</TableHead>
                  <TableHead className="text-slate-400">Messages</TableHead>
                  <TableHead className="text-slate-400">Price</TableHead>
                  <TableHead className="text-slate-400">Status</TableHead>
                  <TableHead className="text-slate-400 text-right">Actions</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {isLoading ? (
                  <TableRow>
                    <TableCell colSpan={8} className="text-center text-slate-400 py-8">
                      Loading plans...
                    </TableCell>
                  </TableRow>
                ) : filteredPlans.length === 0 ? (
                  <TableRow>
                    <TableCell colSpan={8} className="text-center text-slate-400 py-8">
                      No plans found
                    </TableCell>
                  </TableRow>
                ) : (
                  filteredPlans.map((plan) => (
                    <TableRow key={plan.id} className="border-slate-700 hover:bg-slate-800/50">
                      <TableCell>
                        <div className="flex items-center gap-2">
                          <span className="text-xl">{plan.icon}</span>
                          <div>
                            <span className="text-white font-medium">{plan.name}</span>
                            {plan.is_popular && (
                              <Badge className="ml-2 bg-amber-500/20 text-amber-400 border-amber-500/30">
                                <Star className="h-3 w-3 mr-1" /> Popular
                              </Badge>
                            )}
                          </div>
                        </div>
                      </TableCell>
                      <TableCell>
                        <Badge
                          variant="outline"
                          className={
                            plan.category === "elite"
                              ? "border-purple-500 text-purple-400"
                              : "border-blue-500 text-blue-400"
                          }
                        >
                          {plan.category === "elite" ? (
                            <Star className="h-3 w-3 mr-1" />
                          ) : (
                            <Zap className="h-3 w-3 mr-1" />
                          )}
                          {plan.category}
                        </Badge>
                      </TableCell>
                      <TableCell className="text-slate-300">{plan.duration}</TableCell>
                      <TableCell className="text-slate-300">{plan.view_contacts}</TableCell>
                      <TableCell className="text-slate-300">{plan.send_messages}</TableCell>
                      <TableCell className="text-emerald-400 font-medium">₹{plan.price.toLocaleString()}</TableCell>
                      <TableCell>
                        <Badge
                          className={
                            plan.is_active
                              ? "bg-green-500/20 text-green-400 border-green-500/30"
                              : "bg-slate-500/20 text-slate-400 border-slate-500/30"
                          }
                        >
                          {plan.is_active ? (
                            <>
                              <Eye className="h-3 w-3 mr-1" /> Active
                            </>
                          ) : (
                            <>
                              <EyeOff className="h-3 w-3 mr-1" /> Inactive
                            </>
                          )}
                        </Badge>
                      </TableCell>
                      <TableCell className="text-right">
                        <DropdownMenu>
                          <DropdownMenuTrigger asChild>
                            <Button variant="ghost" size="icon" className="text-slate-400 hover:text-white">
                              <MoreVertical className="h-4 w-4" />
                            </Button>
                          </DropdownMenuTrigger>
                          <DropdownMenuContent align="end" className="bg-slate-800 border-slate-700">
                            <DropdownMenuItem
                              onClick={() => handleEdit(plan)}
                              className="text-slate-300 hover:text-white focus:text-white focus:bg-slate-700"
                            >
                              <Edit className="mr-2 h-4 w-4" /> Edit
                            </DropdownMenuItem>
                            <DropdownMenuItem
                              onClick={() => toggleActive(plan)}
                              className="text-slate-300 hover:text-white focus:text-white focus:bg-slate-700"
                            >
                              {plan.is_active ? (
                                <>
                                  <EyeOff className="mr-2 h-4 w-4" /> Deactivate
                                </>
                              ) : (
                                <>
                                  <Eye className="mr-2 h-4 w-4" /> Activate
                                </>
                              )}
                            </DropdownMenuItem>
                            <DropdownMenuItem
                              onClick={() => togglePopular(plan)}
                              className="text-slate-300 hover:text-white focus:text-white focus:bg-slate-700"
                            >
                              <Star className="mr-2 h-4 w-4" />
                              {plan.is_popular ? "Remove Popular" : "Mark Popular"}
                            </DropdownMenuItem>
                            <DropdownMenuItem
                              onClick={() => {
                                setPlanToDelete(plan);
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

        {/* Edit/Add Dialog */}
        <Dialog open={isDialogOpen} onOpenChange={setIsDialogOpen}>
          <DialogContent className="bg-slate-900 border-slate-700 text-white max-w-2xl max-h-[90vh] overflow-y-auto">
            <DialogHeader>
              <DialogTitle>{editingPlan?.id ? "Edit Plan" : "Add New Plan"}</DialogTitle>
              <DialogDescription className="text-slate-400">
                Configure the membership plan details
              </DialogDescription>
            </DialogHeader>

            {editingPlan && (
              <div className="grid gap-4 py-4">
                <div className="grid grid-cols-2 gap-4">
                  <div className="space-y-2">
                    <Label>Plan Name</Label>
                    <Input
                      value={editingPlan.name || ""}
                      onChange={(e) => setEditingPlan({ ...editingPlan, name: e.target.value })}
                      className="bg-slate-800 border-slate-700"
                      placeholder="e.g., Gold"
                    />
                  </div>
                  <div className="space-y-2">
                    <Label>Slug (URL-friendly)</Label>
                    <Input
                      value={editingPlan.slug || ""}
                      onChange={(e) => setEditingPlan({ ...editingPlan, slug: e.target.value })}
                      className="bg-slate-800 border-slate-700"
                      placeholder="e.g., gold"
                    />
                  </div>
                </div>

                <div className="grid grid-cols-2 gap-4">
                  <div className="space-y-2">
                    <Label>Category</Label>
                    <Select
                      value={editingPlan.category}
                      onValueChange={(value) => setEditingPlan({ ...editingPlan, category: value })}
                    >
                      <SelectTrigger className="bg-slate-800 border-slate-700">
                        <SelectValue />
                      </SelectTrigger>
                      <SelectContent className="bg-slate-800 border-slate-700">
                        <SelectItem value="online">Online</SelectItem>
                        <SelectItem value="elite">Elite</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>
                  <div className="space-y-2">
                    <Label>Icon</Label>
                    <Select
                      value={editingPlan.icon}
                      onValueChange={(value) => setEditingPlan({ ...editingPlan, icon: value })}
                    >
                      <SelectTrigger className="bg-slate-800 border-slate-700">
                        <SelectValue />
                      </SelectTrigger>
                      <SelectContent className="bg-slate-800 border-slate-700">
                        {iconOptions.map((icon) => (
                          <SelectItem key={icon} value={icon}>
                            <span className="text-xl">{icon}</span>
                          </SelectItem>
                        ))}
                      </SelectContent>
                    </Select>
                  </div>
                </div>

                <div className="grid grid-cols-2 gap-4">
                  <div className="space-y-2">
                    <Label>Duration Label</Label>
                    <Input
                      value={editingPlan.duration || ""}
                      onChange={(e) => setEditingPlan({ ...editingPlan, duration: e.target.value })}
                      className="bg-slate-800 border-slate-700"
                      placeholder="e.g., 6 Months"
                    />
                  </div>
                  <div className="space-y-2">
                    <Label>Duration (Months)</Label>
                    <Input
                      type="number"
                      value={editingPlan.duration_months || 0}
                      onChange={(e) =>
                        setEditingPlan({ ...editingPlan, duration_months: parseInt(e.target.value) || 0 })
                      }
                      className="bg-slate-800 border-slate-700"
                    />
                  </div>
                </div>

                <div className="grid grid-cols-3 gap-4">
                  <div className="space-y-2">
                    <Label>View Contacts</Label>
                    <Input
                      type="number"
                      value={editingPlan.view_contacts || 0}
                      onChange={(e) =>
                        setEditingPlan({ ...editingPlan, view_contacts: parseInt(e.target.value) || 0 })
                      }
                      className="bg-slate-800 border-slate-700"
                    />
                  </div>
                  <div className="space-y-2">
                    <Label>Send Messages</Label>
                    <Input
                      type="number"
                      value={editingPlan.send_messages || 0}
                      onChange={(e) =>
                        setEditingPlan({ ...editingPlan, send_messages: parseInt(e.target.value) || 0 })
                      }
                      className="bg-slate-800 border-slate-700"
                    />
                  </div>
                  <div className="space-y-2">
                    <Label>Price (₹)</Label>
                    <Input
                      type="number"
                      value={editingPlan.price || 0}
                      onChange={(e) =>
                        setEditingPlan({ ...editingPlan, price: parseFloat(e.target.value) || 0 })
                      }
                      className="bg-slate-800 border-slate-700"
                    />
                  </div>
                </div>

                <div className="space-y-2">
                  <Label>Color Theme</Label>
                  <div className="flex flex-wrap gap-2">
                    {colorPresets.map((preset) => (
                      <button
                        key={preset.name}
                        onClick={() => applyColorPreset(preset)}
                        className={`px-3 py-1.5 rounded-lg text-sm font-medium transition-all ${preset.bg} ${preset.color} ${preset.border} border hover:scale-105`}
                      >
                        {preset.name}
                      </button>
                    ))}
                  </div>
                </div>

                <div className="grid grid-cols-2 gap-4">
                  <div className="space-y-2">
                    <Label>Sort Order</Label>
                    <Input
                      type="number"
                      value={editingPlan.sort_order || 0}
                      onChange={(e) =>
                        setEditingPlan({ ...editingPlan, sort_order: parseInt(e.target.value) || 0 })
                      }
                      className="bg-slate-800 border-slate-700"
                    />
                  </div>
                </div>

                <div className="flex items-center gap-6">
                  <div className="flex items-center gap-2">
                    <Switch
                      checked={editingPlan.is_active}
                      onCheckedChange={(checked) => setEditingPlan({ ...editingPlan, is_active: checked })}
                    />
                    <Label>Active</Label>
                  </div>
                  <div className="flex items-center gap-2">
                    <Switch
                      checked={editingPlan.is_popular}
                      onCheckedChange={(checked) => setEditingPlan({ ...editingPlan, is_popular: checked })}
                    />
                    <Label>Popular</Label>
                  </div>
                </div>

                {/* Preview */}
                <div className="space-y-2">
                  <Label>Preview</Label>
                  <div className={`p-4 rounded-lg ${editingPlan.bg_color} ${editingPlan.border_color} border`}>
                    <div className="flex items-center gap-3">
                      <span className="text-3xl">{editingPlan.icon}</span>
                      <div className={editingPlan.color}>
                        <div className="font-bold text-lg">{editingPlan.name || "Plan Name"}</div>
                        <div className="text-sm opacity-80">{editingPlan.duration || "Duration"}</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            )}

            <DialogFooter>
              <Button variant="outline" onClick={() => setIsDialogOpen(false)} className="border-slate-600">
                Cancel
              </Button>
              <Button onClick={handleSave} className="bg-primary hover:bg-primary/90">
                {editingPlan?.id ? "Update Plan" : "Create Plan"}
              </Button>
            </DialogFooter>
          </DialogContent>
        </Dialog>

        {/* Delete Confirmation Dialog */}
        <Dialog open={isDeleteDialogOpen} onOpenChange={setIsDeleteDialogOpen}>
          <DialogContent className="bg-slate-900 border-slate-700 text-white">
            <DialogHeader>
              <DialogTitle>Delete Plan</DialogTitle>
              <DialogDescription className="text-slate-400">
                Are you sure you want to delete "{planToDelete?.name}"? This action cannot be undone.
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

export default AdminMemberships;
