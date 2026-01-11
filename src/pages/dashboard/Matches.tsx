import { useState } from "react";
import { Link } from "react-router-dom";
import { Heart, Eye, Filter, MapPin, GraduationCap, Briefcase, ChevronDown } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Card, CardContent } from "@/components/ui/card";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import DashboardSidebar from "@/components/dashboard/DashboardSidebar";
import DashboardHeader from "@/components/dashboard/DashboardHeader";
import defaultMale from "@/assets/default-male.jpg";
import defaultFemale from "@/assets/default-female.jpg";

const userData = {
  name: "Rahul More",
  profileId: "NX1235",
  avatar: defaultMale,
};

// Dummy matches data
const matchesData = [
  { id: "NX1234", name: "Priya Sharma", age: 26, height: "5ft 4in", city: "Mumbai", education: "MBA", occupation: "Software Engineer", matchPercent: 92, gender: "female", lastActive: "Online now" },
  { id: "NX1236", name: "Sneha Kamble", age: 24, height: "5ft 2in", city: "Nagpur", education: "B.Com", occupation: "Bank Employee", matchPercent: 88, gender: "female", lastActive: "2 hours ago" },
  { id: "NX1237", name: "Pooja Gaikwad", age: 25, height: "5ft 3in", city: "Pune", education: "B.Tech", occupation: "IT Professional", matchPercent: 85, gender: "female", lastActive: "5 hours ago" },
  { id: "NX1238", name: "Anjali Jadhav", age: 23, height: "5ft 5in", city: "Thane", education: "BBA", occupation: "Marketing Executive", matchPercent: 82, gender: "female", lastActive: "1 day ago" },
  { id: "NX1239", name: "Kavita Shinde", age: 27, height: "5ft 4in", city: "Aurangabad", education: "MBBS", occupation: "Doctor", matchPercent: 80, gender: "female", lastActive: "3 hours ago" },
  { id: "NX1240", name: "Meera Salve", age: 26, height: "5ft 6in", city: "Kolhapur", education: "M.Com", occupation: "Accountant", matchPercent: 78, gender: "female", lastActive: "Online now" },
  { id: "NX1241", name: "Rekha Ghodke", age: 24, height: "5ft 3in", city: "Mumbai", education: "BDS", occupation: "Dentist", matchPercent: 76, gender: "female", lastActive: "4 hours ago" },
  { id: "NX1242", name: "Sunita Wankhede", age: 28, height: "5ft 5in", city: "Nagpur", education: "B.Sc", occupation: "Teacher", matchPercent: 74, gender: "female", lastActive: "2 days ago" },
];

const Matches = () => {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [sortBy, setSortBy] = useState("match");

  const sortedMatches = [...matchesData].sort((a, b) => {
    if (sortBy === "match") return b.matchPercent - a.matchPercent;
    if (sortBy === "age") return a.age - b.age;
    if (sortBy === "recent") return a.lastActive.includes("now") ? -1 : 1;
    return 0;
  });

  return (
    <div className="min-h-screen bg-gradient-to-br from-secondary/30 via-background to-secondary/20">
      <DashboardSidebar isOpen={sidebarOpen} onClose={() => setSidebarOpen(false)} />
      
      <div className="lg:pl-64">
        <DashboardHeader onMenuClick={() => setSidebarOpen(true)} user={userData} />
        
        <main className="p-4 md:p-6 lg:p-8">
          <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
              <h1 className="text-2xl md:text-3xl font-bold text-foreground">Your Matches</h1>
              <p className="text-muted-foreground">
                {matchesData.length} profiles matched your preferences
              </p>
            </div>
            <div className="flex items-center gap-3">
              <Select value={sortBy} onValueChange={setSortBy}>
                <SelectTrigger className="w-40">
                  <SelectValue placeholder="Sort by" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="match">Best Match</SelectItem>
                  <SelectItem value="recent">Recently Active</SelectItem>
                  <SelectItem value="age">Age</SelectItem>
                </SelectContent>
              </Select>
              <Button variant="outline" className="gap-2">
                <Filter className="h-4 w-4" />
                Filters
              </Button>
            </div>
          </div>

          <div className="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            {sortedMatches.map((match) => (
              <Card key={match.id} className="overflow-hidden hover:shadow-lg transition-all hover:-translate-y-1">
                <div className="relative aspect-[3/4]">
                  <img
                    src={match.gender === "female" ? defaultFemale : defaultMale}
                    alt={match.name}
                    className="w-full h-full object-cover object-top"
                  />
                  <Badge className="absolute top-3 left-3 bg-green-500 text-white">
                    {match.matchPercent}% Match
                  </Badge>
                  <div className="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-3">
                    <span className="text-white text-xs">{match.lastActive}</span>
                  </div>
                </div>
                <CardContent className="p-4">
                  <div className="flex items-start justify-between mb-2">
                    <div>
                      <h3 className="font-semibold text-foreground">{match.name}</h3>
                      <p className="text-xs text-primary">{match.id}</p>
                    </div>
                    <Button size="icon" variant="ghost" className="h-8 w-8 text-rose-500 hover:text-rose-600">
                      <Heart className="h-4 w-4" />
                    </Button>
                  </div>
                  
                  <div className="space-y-1 text-sm text-muted-foreground mb-3">
                    <p className="font-medium text-foreground">
                      {match.age} yrs, {match.height}
                    </p>
                    <p className="flex items-center gap-1.5 text-xs">
                      <MapPin className="h-3 w-3" /> {match.city}
                    </p>
                    <p className="flex items-center gap-1.5 text-xs">
                      <GraduationCap className="h-3 w-3" /> {match.education}
                    </p>
                    <p className="flex items-center gap-1.5 text-xs">
                      <Briefcase className="h-3 w-3" /> {match.occupation}
                    </p>
                  </div>

                  <div className="flex gap-2">
                    <Link to={`/profile/${match.id}`} className="flex-1">
                      <Button size="sm" variant="outline" className="w-full gap-1">
                        <Eye className="h-3.5 w-3.5" />
                        View
                      </Button>
                    </Link>
                    <Button size="sm" className="flex-1 gap-1 bg-gradient-primary">
                      <Heart className="h-3.5 w-3.5" />
                      Interest
                    </Button>
                  </div>
                </CardContent>
              </Card>
            ))}
          </div>
        </main>
      </div>
    </div>
  );
};

export default Matches;
