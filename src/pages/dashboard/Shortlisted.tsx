import { useState } from "react";
import { Link } from "react-router-dom";
import { Heart, Eye, Trash2, MapPin, GraduationCap, Briefcase, MessageCircle } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Card, CardContent } from "@/components/ui/card";
import { toast } from "@/hooks/use-toast";
import DashboardSidebar from "@/components/dashboard/DashboardSidebar";
import DashboardHeader from "@/components/dashboard/DashboardHeader";
import defaultMale from "@/assets/default-male.jpg";
import defaultFemale from "@/assets/default-female.jpg";

const userData = {
  name: "Rahul More",
  profileId: "NX1235",
  avatar: defaultMale,
};

// Dummy shortlisted profiles
const shortlistedData = [
  { id: "NX1234", name: "Priya Sharma", age: 26, height: "5ft 4in", city: "Mumbai", education: "MBA", occupation: "Software Engineer", gender: "female", shortlistedOn: "2 days ago" },
  { id: "NX1237", name: "Pooja Gaikwad", age: 25, height: "5ft 3in", city: "Pune", education: "B.Tech", occupation: "IT Professional", gender: "female", shortlistedOn: "5 days ago" },
  { id: "NX1239", name: "Kavita Shinde", age: 27, height: "5ft 4in", city: "Aurangabad", education: "MBBS", occupation: "Doctor", gender: "female", shortlistedOn: "1 week ago" },
  { id: "NX1245", name: "Ashwini Bhosale", age: 26, height: "5ft 5in", city: "Mumbai", education: "MBA", occupation: "HR Manager", gender: "female", shortlistedOn: "1 week ago" },
];

const Shortlisted = () => {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [profiles, setProfiles] = useState(shortlistedData);

  const handleRemove = (id: string) => {
    setProfiles(profiles.filter(p => p.id !== id));
    toast({
      title: "Profile Removed",
      description: "Profile has been removed from your shortlist.",
    });
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-secondary/30 via-background to-secondary/20">
      <DashboardSidebar isOpen={sidebarOpen} onClose={() => setSidebarOpen(false)} />
      
      <div className="lg:pl-64">
        <DashboardHeader onMenuClick={() => setSidebarOpen(true)} user={userData} />
        
        <main className="p-4 md:p-6 lg:p-8">
          <div className="mb-6">
            <h1 className="text-2xl md:text-3xl font-bold text-foreground">Shortlisted Profiles</h1>
            <p className="text-muted-foreground">
              {profiles.length} profiles in your shortlist
            </p>
          </div>

          {profiles.length === 0 ? (
            <Card className="text-center py-12">
              <CardContent>
                <Heart className="h-12 w-12 mx-auto text-muted-foreground/50 mb-4" />
                <h3 className="text-lg font-semibold mb-2">No shortlisted profiles</h3>
                <p className="text-muted-foreground mb-4">
                  Start exploring profiles and shortlist the ones you like
                </p>
                <Link to="/search">
                  <Button className="bg-gradient-primary">Browse Profiles</Button>
                </Link>
              </CardContent>
            </Card>
          ) : (
            <div className="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
              {profiles.map((profile) => (
                <Card key={profile.id} className="overflow-hidden hover:shadow-lg transition-all">
                  <div className="relative aspect-[3/4]">
                    <img
                      src={profile.gender === "female" ? defaultFemale : defaultMale}
                      alt={profile.name}
                      className="w-full h-full object-cover object-top"
                    />
                    <button
                      onClick={() => handleRemove(profile.id)}
                      className="absolute top-3 right-3 p-2 bg-white/90 rounded-full hover:bg-rose-50 transition-colors group"
                    >
                      <Trash2 className="h-4 w-4 text-muted-foreground group-hover:text-rose-500" />
                    </button>
                    <div className="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-3">
                      <span className="text-white text-xs">Shortlisted {profile.shortlistedOn}</span>
                    </div>
                  </div>
                  <CardContent className="p-4">
                    <div className="mb-2">
                      <h3 className="font-semibold text-foreground">{profile.name}</h3>
                      <p className="text-xs text-primary">{profile.id}</p>
                    </div>
                    
                    <div className="space-y-1 text-sm text-muted-foreground mb-3">
                      <p className="font-medium text-foreground">
                        {profile.age} yrs, {profile.height}
                      </p>
                      <p className="flex items-center gap-1.5 text-xs">
                        <MapPin className="h-3 w-3" /> {profile.city}
                      </p>
                      <p className="flex items-center gap-1.5 text-xs">
                        <GraduationCap className="h-3 w-3" /> {profile.education}
                      </p>
                      <p className="flex items-center gap-1.5 text-xs">
                        <Briefcase className="h-3 w-3" /> {profile.occupation}
                      </p>
                    </div>

                    <div className="flex gap-2">
                      <Link to={`/profile/${profile.id}`} className="flex-1">
                        <Button size="sm" variant="outline" className="w-full gap-1">
                          <Eye className="h-3.5 w-3.5" />
                          View
                        </Button>
                      </Link>
                      <Button size="sm" className="flex-1 gap-1 bg-gradient-primary">
                        <MessageCircle className="h-3.5 w-3.5" />
                        Interest
                      </Button>
                    </div>
                  </CardContent>
                </Card>
              ))}
            </div>
          )}
        </main>
      </div>
    </div>
  );
};

export default Shortlisted;
