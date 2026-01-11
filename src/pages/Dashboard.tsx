import { useState } from "react";
import { Link } from "react-router-dom";
import { 
  LayoutDashboard, 
  User, 
  Heart, 
  MessageCircle, 
  Settings, 
  Eye, 
  Users, 
  Star,
  Bell,
  ChevronRight,
  Camera,
  CheckCircle,
  Clock,
  TrendingUp
} from "lucide-react";
import { Button } from "@/components/ui/button";
import { Progress } from "@/components/ui/progress";
import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import DashboardSidebar from "@/components/dashboard/DashboardSidebar";
import DashboardHeader from "@/components/dashboard/DashboardHeader";
import defaultMale from "@/assets/default-male.jpg";

// Dummy user data
const userData = {
  name: "Rahul More",
  profileId: "NX1235",
  email: "rahul.more@email.com",
  phone: "+91 98765 43210",
  profileCompletion: 75,
  profileStatus: "Active",
  memberSince: "Jan 2024",
  plan: "Premium",
  avatar: defaultMale,
};

// Dummy stats
const stats = {
  newMatches: 12,
  profileViews: 48,
  shortlisted: 8,
  interestReceived: 5,
  interestSent: 15,
  profileViewsToday: 7,
};

// Recent activity
const recentActivity = [
  { type: "view", name: "Priya S.", time: "2 hours ago", avatar: "PS" },
  { type: "interest", name: "Sneha K.", time: "5 hours ago", avatar: "SK" },
  { type: "shortlist", name: "Anjali J.", time: "1 day ago", avatar: "AJ" },
  { type: "match", name: "Pooja G.", time: "2 days ago", avatar: "PG" },
];

// Recommended matches
const recommendedMatches = [
  { id: "NX1234", name: "Priya Sharma", age: 26, city: "Mumbai", education: "MBA", occupation: "Software Engineer", matchPercent: 92 },
  { id: "NX1236", name: "Sneha Kamble", age: 24, city: "Nagpur", education: "B.Com", occupation: "Bank Employee", matchPercent: 88 },
  { id: "NX1237", name: "Pooja Gaikwad", age: 25, city: "Pune", education: "B.Tech", occupation: "IT Professional", matchPercent: 85 },
];

const Dashboard = () => {
  const [sidebarOpen, setSidebarOpen] = useState(false);

  return (
    <div className="min-h-screen bg-gradient-to-br from-secondary/30 via-background to-secondary/20">
      <DashboardSidebar isOpen={sidebarOpen} onClose={() => setSidebarOpen(false)} />
      
      <div className="lg:pl-64">
        <DashboardHeader onMenuClick={() => setSidebarOpen(true)} user={userData} />
        
        <main className="p-4 md:p-6 lg:p-8">
          {/* Welcome Section */}
          <div className="mb-8">
            <h1 className="text-2xl md:text-3xl font-bold text-foreground">
              Welcome back, {userData.name.split(" ")[0]}! 👋
            </h1>
            <p className="text-muted-foreground mt-1">
              Here's what's happening with your profile today.
            </p>
          </div>

          {/* Profile Completion Card */}
          <Card className="mb-6 border-primary/20 bg-gradient-to-r from-primary/5 to-primary/10">
            <CardContent className="p-6">
              <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div className="flex items-center gap-4">
                  <div className="relative">
                    <img
                      src={userData.avatar}
                      alt={userData.name}
                      className="h-16 w-16 rounded-full object-cover border-2 border-primary"
                    />
                    <button className="absolute -bottom-1 -right-1 bg-primary text-primary-foreground p-1.5 rounded-full hover:bg-primary/90 transition-colors">
                      <Camera className="h-3 w-3" />
                    </button>
                  </div>
                  <div>
                    <h3 className="font-semibold text-lg">{userData.name}</h3>
                    <p className="text-sm text-muted-foreground">{userData.profileId}</p>
                    <div className="flex items-center gap-2 mt-1">
                      <Badge variant="secondary" className="bg-green-100 text-green-700 hover:bg-green-100">
                        <CheckCircle className="h-3 w-3 mr-1" />
                        {userData.profileStatus}
                      </Badge>
                      <Badge variant="outline" className="text-primary border-primary">
                        {userData.plan}
                      </Badge>
                    </div>
                  </div>
                </div>
                <div className="flex-1 max-w-sm">
                  <div className="flex items-center justify-between mb-2">
                    <span className="text-sm font-medium">Profile Completion</span>
                    <span className="text-sm font-bold text-primary">{userData.profileCompletion}%</span>
                  </div>
                  <Progress value={userData.profileCompletion} className="h-2" />
                  <p className="text-xs text-muted-foreground mt-2">
                    Complete your profile to get more matches
                  </p>
                </div>
                <Link to="/dashboard/profile">
                  <Button className="bg-gradient-primary">
                    Complete Profile
                    <ChevronRight className="h-4 w-4 ml-1" />
                  </Button>
                </Link>
              </div>
            </CardContent>
          </Card>

          {/* Stats Grid */}
          <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <StatCard
              icon={<Users className="h-5 w-5" />}
              label="New Matches"
              value={stats.newMatches}
              trend="+3 today"
              color="text-blue-500"
              bgColor="bg-blue-500/10"
            />
            <StatCard
              icon={<Eye className="h-5 w-5" />}
              label="Profile Views"
              value={stats.profileViews}
              trend={`+${stats.profileViewsToday} today`}
              color="text-purple-500"
              bgColor="bg-purple-500/10"
            />
            <StatCard
              icon={<Heart className="h-5 w-5" />}
              label="Interests Received"
              value={stats.interestReceived}
              trend="2 pending"
              color="text-rose-500"
              bgColor="bg-rose-500/10"
            />
            <StatCard
              icon={<Star className="h-5 w-5" />}
              label="Shortlisted"
              value={stats.shortlisted}
              trend="View all"
              color="text-amber-500"
              bgColor="bg-amber-500/10"
            />
          </div>

          {/* Main Content Grid */}
          <div className="grid lg:grid-cols-3 gap-6">
            {/* Recommended Matches */}
            <div className="lg:col-span-2">
              <Card>
                <CardHeader className="flex flex-row items-center justify-between">
                  <CardTitle className="text-lg font-semibold">Recommended Matches</CardTitle>
                  <Link to="/dashboard/matches">
                    <Button variant="ghost" size="sm" className="text-primary">
                      View All
                      <ChevronRight className="h-4 w-4 ml-1" />
                    </Button>
                  </Link>
                </CardHeader>
                <CardContent>
                  <div className="space-y-4">
                    {recommendedMatches.map((match) => (
                      <div
                        key={match.id}
                        className="flex items-center gap-4 p-4 rounded-lg border border-border hover:border-primary/30 hover:bg-secondary/30 transition-all cursor-pointer"
                      >
                        <div className="h-14 w-14 rounded-full bg-gradient-to-br from-primary/20 to-primary/40 flex items-center justify-center text-primary font-semibold">
                          {match.name.split(" ").map(n => n[0]).join("")}
                        </div>
                        <div className="flex-1 min-w-0">
                          <div className="flex items-center gap-2">
                            <h4 className="font-medium text-foreground truncate">{match.name}</h4>
                            <Badge variant="secondary" className="text-xs bg-green-100 text-green-700">
                              {match.matchPercent}% Match
                            </Badge>
                          </div>
                          <p className="text-sm text-muted-foreground">
                            {match.age} yrs • {match.city} • {match.education}
                          </p>
                          <p className="text-xs text-muted-foreground">{match.occupation}</p>
                        </div>
                        <div className="flex gap-2">
                          <Button size="sm" variant="outline" className="hidden sm:flex">
                            <Eye className="h-4 w-4" />
                          </Button>
                          <Button size="sm" className="bg-gradient-primary">
                            <Heart className="h-4 w-4" />
                          </Button>
                        </div>
                      </div>
                    ))}
                  </div>
                </CardContent>
              </Card>
            </div>

            {/* Recent Activity */}
            <div>
              <Card>
                <CardHeader className="flex flex-row items-center justify-between">
                  <CardTitle className="text-lg font-semibold">Recent Activity</CardTitle>
                  <Bell className="h-5 w-5 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                  <div className="space-y-4">
                    {recentActivity.map((activity, index) => (
                      <div key={index} className="flex items-center gap-3">
                        <div className="h-10 w-10 rounded-full bg-gradient-to-br from-primary/20 to-primary/40 flex items-center justify-center text-primary text-sm font-medium">
                          {activity.avatar}
                        </div>
                        <div className="flex-1 min-w-0">
                          <p className="text-sm font-medium text-foreground truncate">
                            {activity.name}
                          </p>
                          <p className="text-xs text-muted-foreground">
                            {activity.type === "view" && "Viewed your profile"}
                            {activity.type === "interest" && "Sent you an interest"}
                            {activity.type === "shortlist" && "Shortlisted your profile"}
                            {activity.type === "match" && "New match found!"}
                          </p>
                        </div>
                        <div className="flex items-center text-xs text-muted-foreground">
                          <Clock className="h-3 w-3 mr-1" />
                          {activity.time}
                        </div>
                      </div>
                    ))}
                  </div>
                  <Button variant="outline" className="w-full mt-4">
                    View All Activity
                  </Button>
                </CardContent>
              </Card>

              {/* Quick Actions */}
              <Card className="mt-6">
                <CardHeader>
                  <CardTitle className="text-lg font-semibold">Quick Actions</CardTitle>
                </CardHeader>
                <CardContent className="space-y-2">
                  <Link to="/dashboard/profile">
                    <Button variant="outline" className="w-full justify-start gap-2">
                      <User className="h-4 w-4" />
                      Edit Profile
                    </Button>
                  </Link>
                  <Link to="/search">
                    <Button variant="outline" className="w-full justify-start gap-2">
                      <Users className="h-4 w-4" />
                      Search Profiles
                    </Button>
                  </Link>
                  <Link to="/dashboard/preferences">
                    <Button variant="outline" className="w-full justify-start gap-2">
                      <Heart className="h-4 w-4" />
                      Partner Preferences
                    </Button>
                  </Link>
                  <Link to="/dashboard/settings">
                    <Button variant="outline" className="w-full justify-start gap-2">
                      <Settings className="h-4 w-4" />
                      Account Settings
                    </Button>
                  </Link>
                </CardContent>
              </Card>
            </div>
          </div>
        </main>
      </div>
    </div>
  );
};

// Stat Card Component
const StatCard = ({ 
  icon, 
  label, 
  value, 
  trend, 
  color, 
  bgColor 
}: { 
  icon: React.ReactNode; 
  label: string; 
  value: number; 
  trend: string;
  color: string;
  bgColor: string;
}) => (
  <Card className="hover:shadow-md transition-shadow">
    <CardContent className="p-4">
      <div className="flex items-center gap-3">
        <div className={`p-2 rounded-lg ${bgColor}`}>
          <span className={color}>{icon}</span>
        </div>
        <div>
          <p className="text-2xl font-bold text-foreground">{value}</p>
          <p className="text-xs text-muted-foreground">{label}</p>
        </div>
      </div>
      <div className="flex items-center gap-1 mt-2 text-xs text-muted-foreground">
        <TrendingUp className="h-3 w-3 text-green-500" />
        <span>{trend}</span>
      </div>
    </CardContent>
  </Card>
);

export default Dashboard;
