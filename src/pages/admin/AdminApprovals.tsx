import { useState } from "react";
import { Card, CardContent } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { CheckCircle, XCircle, Eye, MapPin, GraduationCap, Briefcase, Clock } from "lucide-react";
import AdminLayout from "@/components/admin/AdminLayout";
import { toast } from "sonner";

const pendingProfiles = [
  {
    id: "SM1005",
    name: "Vikram Jadhav",
    age: 28,
    gender: "Male",
    city: "Pune",
    education: "M.Tech",
    occupation: "Software Developer",
    religion: "Buddhist",
    caste: "Mahar",
    submittedAt: "2 hours ago",
  },
  {
    id: "SF1006",
    name: "Anjali Gaikwad",
    age: 25,
    gender: "Female",
    city: "Mumbai",
    education: "MBA",
    occupation: "Marketing Manager",
    religion: "Buddhist",
    caste: "Nav Bauddha",
    submittedAt: "5 hours ago",
  },
  {
    id: "SM1007",
    name: "Suresh Kamble",
    age: 32,
    gender: "Male",
    city: "Nagpur",
    education: "B.Com",
    occupation: "Business Owner",
    religion: "Buddhist",
    caste: "Chambhar",
    submittedAt: "1 day ago",
  },
];

const AdminApprovals = () => {
  const [profiles, setProfiles] = useState(pendingProfiles);

  const handleApprove = (id: string) => {
    setProfiles(profiles.filter((p) => p.id !== id));
    toast.success(`Profile ${id} approved successfully`);
  };

  const handleReject = (id: string) => {
    setProfiles(profiles.filter((p) => p.id !== id));
    toast.error(`Profile ${id} rejected`);
  };

  return (
    <AdminLayout>
      <div className="p-6 space-y-6">
        {/* Header */}
        <div>
          <h1 className="text-2xl font-bold text-white">Profile Approvals</h1>
          <p className="text-slate-400">Review and approve new profile registrations</p>
        </div>

        {/* Tabs */}
        <Tabs defaultValue="pending" className="w-full">
          <TabsList className="bg-slate-800 border-slate-700">
            <TabsTrigger value="pending" className="data-[state=active]:bg-slate-700">
              Pending ({profiles.length})
            </TabsTrigger>
            <TabsTrigger value="approved" className="data-[state=active]:bg-slate-700">
              Recently Approved
            </TabsTrigger>
            <TabsTrigger value="rejected" className="data-[state=active]:bg-slate-700">
              Rejected
            </TabsTrigger>
          </TabsList>

          <TabsContent value="pending" className="mt-4">
            {profiles.length === 0 ? (
              <Card className="bg-slate-800/50 border-slate-700">
                <CardContent className="p-8 text-center">
                  <CheckCircle className="h-12 w-12 text-green-500 mx-auto mb-4" />
                  <p className="text-white font-medium">All caught up!</p>
                  <p className="text-slate-400 text-sm">No pending profiles to review.</p>
                </CardContent>
              </Card>
            ) : (
              <div className="grid gap-4">
                {profiles.map((profile) => (
                  <Card key={profile.id} className="bg-slate-800/50 border-slate-700">
                    <CardContent className="p-4">
                      <div className="flex flex-col md:flex-row gap-4">
                        {/* Profile Image Placeholder */}
                        <div className="w-24 h-24 md:w-32 md:h-32 bg-slate-700 rounded-lg flex items-center justify-center flex-shrink-0">
                          <span className="text-4xl text-slate-500">
                            {profile.gender === "Male" ? "👨" : "👩"}
                          </span>
                        </div>

                        {/* Profile Info */}
                        <div className="flex-1 min-w-0">
                          <div className="flex items-start justify-between gap-2 mb-2">
                            <div>
                              <h3 className="text-lg font-semibold text-white">{profile.name}</h3>
                              <p className="text-primary text-sm">{profile.id}</p>
                            </div>
                            <Badge className="bg-amber-500/20 text-amber-400 border-0 flex-shrink-0">
                              <Clock className="h-3 w-3 mr-1" />
                              {profile.submittedAt}
                            </Badge>
                          </div>

                          <div className="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm mb-4">
                            <div className="flex items-center gap-1 text-slate-400">
                              <span className="font-medium text-white">{profile.age} yrs</span>
                              • {profile.gender}
                            </div>
                            <div className="flex items-center gap-1 text-slate-400">
                              <MapPin className="h-3.5 w-3.5" />
                              {profile.city}
                            </div>
                            <div className="flex items-center gap-1 text-slate-400">
                              <GraduationCap className="h-3.5 w-3.5" />
                              {profile.education}
                            </div>
                            <div className="flex items-center gap-1 text-slate-400">
                              <Briefcase className="h-3.5 w-3.5" />
                              {profile.occupation}
                            </div>
                          </div>

                          <p className="text-xs text-slate-500 mb-4">
                            {profile.religion} • {profile.caste}
                          </p>

                          {/* Actions */}
                          <div className="flex gap-2">
                            <Button
                              size="sm"
                              className="bg-green-600 hover:bg-green-700"
                              onClick={() => handleApprove(profile.id)}
                            >
                              <CheckCircle className="h-4 w-4 mr-1" />
                              Approve
                            </Button>
                            <Button
                              size="sm"
                              variant="destructive"
                              onClick={() => handleReject(profile.id)}
                            >
                              <XCircle className="h-4 w-4 mr-1" />
                              Reject
                            </Button>
                            <Button size="sm" variant="outline" className="border-slate-600 text-slate-300">
                              <Eye className="h-4 w-4 mr-1" />
                              View Full Profile
                            </Button>
                          </div>
                        </div>
                      </div>
                    </CardContent>
                  </Card>
                ))}
              </div>
            )}
          </TabsContent>

          <TabsContent value="approved" className="mt-4">
            <Card className="bg-slate-800/50 border-slate-700">
              <CardContent className="p-8 text-center">
                <p className="text-slate-400">Recently approved profiles will appear here.</p>
              </CardContent>
            </Card>
          </TabsContent>

          <TabsContent value="rejected" className="mt-4">
            <Card className="bg-slate-800/50 border-slate-700">
              <CardContent className="p-8 text-center">
                <p className="text-slate-400">Rejected profiles will appear here.</p>
              </CardContent>
            </Card>
          </TabsContent>
        </Tabs>
      </div>
    </AdminLayout>
  );
};

export default AdminApprovals;