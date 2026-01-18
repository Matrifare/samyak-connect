import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Users, UserCheck, UserX, CreditCard, TrendingUp, Clock } from "lucide-react";
import AdminLayout from "@/components/admin/AdminLayout";

const stats = [
  {
    title: "Total Users",
    value: "15,234",
    change: "+12%",
    icon: Users,
    color: "text-blue-500",
    bgColor: "bg-blue-500/10",
  },
  {
    title: "Pending Approvals",
    value: "48",
    change: "Needs attention",
    icon: Clock,
    color: "text-amber-500",
    bgColor: "bg-amber-500/10",
  },
  {
    title: "Approved Profiles",
    value: "12,456",
    change: "+8%",
    icon: UserCheck,
    color: "text-green-500",
    bgColor: "bg-green-500/10",
  },
  {
    title: "Premium Members",
    value: "2,341",
    change: "+15%",
    icon: CreditCard,
    color: "text-purple-500",
    bgColor: "bg-purple-500/10",
  },
];

const recentActivities = [
  { id: 1, user: "Priya Sharma", action: "New registration", time: "2 mins ago" },
  { id: 2, user: "Rahul More", action: "Profile updated", time: "5 mins ago" },
  { id: 3, user: "Sneha Kamble", action: "Upgraded to Premium", time: "10 mins ago" },
  { id: 4, user: "Amit Pawar", action: "New registration", time: "15 mins ago" },
  { id: 5, user: "Pooja Gaikwad", action: "Photo uploaded", time: "20 mins ago" },
];

const AdminDashboard = () => {
  return (
    <AdminLayout>
      <div className="p-6 space-y-6">
        {/* Header */}
        <div>
          <h1 className="text-2xl font-bold text-white">Dashboard</h1>
          <p className="text-slate-400">Welcome back! Here's what's happening.</p>
        </div>

        {/* Stats Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          {stats.map((stat) => (
            <Card key={stat.title} className="bg-slate-800/50 border-slate-700">
              <CardContent className="p-6">
                <div className="flex items-center justify-between">
                  <div>
                    <p className="text-sm text-slate-400">{stat.title}</p>
                    <p className="text-2xl font-bold text-white mt-1">{stat.value}</p>
                    <p className="text-xs text-slate-500 mt-1">{stat.change}</p>
                  </div>
                  <div className={`p-3 rounded-lg ${stat.bgColor}`}>
                    <stat.icon className={`h-6 w-6 ${stat.color}`} />
                  </div>
                </div>
              </CardContent>
            </Card>
          ))}
        </div>

        {/* Content Grid */}
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
          {/* Recent Activity */}
          <Card className="bg-slate-800/50 border-slate-700">
            <CardHeader>
              <CardTitle className="text-white">Recent Activity</CardTitle>
            </CardHeader>
            <CardContent>
              <div className="space-y-4">
                {recentActivities.map((activity) => (
                  <div
                    key={activity.id}
                    className="flex items-center justify-between py-2 border-b border-slate-700 last:border-0"
                  >
                    <div>
                      <p className="text-sm font-medium text-white">{activity.user}</p>
                      <p className="text-xs text-slate-400">{activity.action}</p>
                    </div>
                    <span className="text-xs text-slate-500">{activity.time}</span>
                  </div>
                ))}
              </div>
            </CardContent>
          </Card>

          {/* Quick Actions */}
          <Card className="bg-slate-800/50 border-slate-700">
            <CardHeader>
              <CardTitle className="text-white">Quick Actions</CardTitle>
            </CardHeader>
            <CardContent className="space-y-3">
              <a
                href="/admin/approvals"
                className="flex items-center gap-3 p-3 rounded-lg bg-slate-700/50 hover:bg-slate-700 transition-colors"
              >
                <UserCheck className="h-5 w-5 text-green-500" />
                <div>
                  <p className="text-sm font-medium text-white">Review Pending Profiles</p>
                  <p className="text-xs text-slate-400">48 profiles awaiting approval</p>
                </div>
              </a>
              <a
                href="/admin/users"
                className="flex items-center gap-3 p-3 rounded-lg bg-slate-700/50 hover:bg-slate-700 transition-colors"
              >
                <Users className="h-5 w-5 text-blue-500" />
                <div>
                  <p className="text-sm font-medium text-white">Manage All Users</p>
                  <p className="text-xs text-slate-400">View, edit, or suspend users</p>
                </div>
              </a>
              <a
                href="/admin/reports"
                className="flex items-center gap-3 p-3 rounded-lg bg-slate-700/50 hover:bg-slate-700 transition-colors"
              >
                <TrendingUp className="h-5 w-5 text-purple-500" />
                <div>
                  <p className="text-sm font-medium text-white">View Reports</p>
                  <p className="text-xs text-slate-400">Analytics and statistics</p>
                </div>
              </a>
            </CardContent>
          </Card>
        </div>
      </div>
    </AdminLayout>
  );
};

export default AdminDashboard;