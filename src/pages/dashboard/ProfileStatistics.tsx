import { useState } from "react";
import DashboardSidebar from "@/components/dashboard/DashboardSidebar";
import DashboardHeader from "@/components/dashboard/DashboardHeader";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import defaultMale from "@/assets/default-male.jpg";
import { 
  Heart, 
  MessageSquare,
  Bookmark, 
  Ban, 
  Eye, 
  Users, 
  Phone, 
  UserCheck,
  Send,
  Inbox,
  Clock,
  CheckCircle,
  XCircle
} from "lucide-react";

// Dummy statistics data
const expressInterestStats = {
  received: { pending: 5, accepted: 12, rejected: 3 },
  sent: { pending: 8, accepted: 15, rejected: 7 }
};

const messageStats = {
  received: 24,
  sent: 18
};

const profileStats = [
  { label: "Short Listed Profiles By Me", count: 45, icon: Bookmark },
  { label: "Block Listed Profiles By Me", count: 2, icon: Ban },
  { label: "Profiles Visited by Me", count: 351, icon: Eye },
  { label: "Visitor List of My Profile", count: 128, icon: Users },
  { label: "Contact Details of profiles viewed by me", count: 26, icon: Phone },
  { label: "Who Viewed my Contact Details", count: 14, icon: UserCheck }
];

const planDetails = {
  name: "CLASSIC PLAN",
  price: "Rs. 3000",
  duration: "365 Days",
  contact: { total: 25, used: 0 },
  viewProfile: { total: 3000, used: 8 },
  message: { total: 25, used: 1 },
  expiryDate: "29 Dec 2026"
};

// Dummy user data
const userData = {
  name: "Rahul More",
  profileId: "NX1235",
  email: "rahul.more@email.com",
  phone: "+91 98765 43210",
  avatar: defaultMale,
};

const ProfileStatistics = () => {
  const [sidebarOpen, setSidebarOpen] = useState(false);

  return (
    <div className="min-h-screen bg-gradient-to-br from-secondary/30 via-background to-secondary/20">
      <DashboardSidebar isOpen={sidebarOpen} onClose={() => setSidebarOpen(false)} />
      
      <div className="lg:pl-64">
        <DashboardHeader onMenuClick={() => setSidebarOpen(true)} user={userData} />
        
        <main className="p-4 md:p-6 lg:p-8 space-y-6">
          <div>
            <h1 className="text-2xl font-bold text-foreground">Profile Statistics</h1>
            <p className="text-muted-foreground">View all your profile activity and usage statistics</p>
          </div>

        {/* Express Interest Section */}
        <Card>
          <CardHeader className="flex flex-row items-center justify-between pb-2">
            <CardTitle className="text-lg font-semibold flex items-center gap-2">
              <Heart className="h-5 w-5 text-primary" />
              Express Interest
            </CardTitle>
            <Badge className="bg-green-600 hover:bg-green-700">
              <MessageSquare className="h-3 w-3 mr-1" />
              Get On WhatsApp
            </Badge>
          </CardHeader>
          <CardContent>
            <div className="overflow-x-auto">
              <table className="w-full">
                <thead>
                  <tr className="border-b">
                    <th className="text-left py-3 px-4 font-medium text-muted-foreground"></th>
                    <th className="text-center py-3 px-4 font-medium text-muted-foreground">
                      <div className="flex items-center justify-center gap-1">
                        <Clock className="h-4 w-4" />
                        Pending
                      </div>
                    </th>
                    <th className="text-center py-3 px-4 font-medium text-muted-foreground">
                      <div className="flex items-center justify-center gap-1">
                        <CheckCircle className="h-4 w-4" />
                        Accepted
                      </div>
                    </th>
                    <th className="text-center py-3 px-4 font-medium text-muted-foreground">
                      <div className="flex items-center justify-center gap-1">
                        <XCircle className="h-4 w-4" />
                        Rejected
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr className="border-b hover:bg-muted/50">
                    <td className="py-3 px-4 flex items-center gap-2">
                      <Inbox className="h-4 w-4 text-primary" />
                      Received
                    </td>
                    <td className="text-center py-3 px-4">
                      <Badge variant="secondary">{expressInterestStats.received.pending}</Badge>
                    </td>
                    <td className="text-center py-3 px-4">
                      <Badge variant="secondary">{expressInterestStats.received.accepted}</Badge>
                    </td>
                    <td className="text-center py-3 px-4">
                      <Badge variant="secondary">{expressInterestStats.received.rejected}</Badge>
                    </td>
                  </tr>
                  <tr className="hover:bg-muted/50">
                    <td className="py-3 px-4 flex items-center gap-2">
                      <Send className="h-4 w-4 text-primary" />
                      Sent
                    </td>
                    <td className="text-center py-3 px-4">
                      <Badge variant="secondary">{expressInterestStats.sent.pending}</Badge>
                    </td>
                    <td className="text-center py-3 px-4">
                      <Badge variant="secondary">{expressInterestStats.sent.accepted}</Badge>
                    </td>
                    <td className="text-center py-3 px-4">
                      <Badge variant="secondary">{expressInterestStats.sent.rejected}</Badge>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </CardContent>
        </Card>

        {/* Messages Section */}
        <Card>
          <CardHeader className="flex flex-row items-center justify-between pb-2">
            <CardTitle className="text-lg font-semibold flex items-center gap-2">
              <MessageSquare className="h-5 w-5 text-primary" />
              Messages
            </CardTitle>
            <Badge className="bg-green-600 hover:bg-green-700">
              <MessageSquare className="h-3 w-3 mr-1" />
              Get On WhatsApp
            </Badge>
          </CardHeader>
          <CardContent>
            <div className="space-y-3">
              <div className="flex items-center justify-between py-3 px-4 rounded-lg bg-muted/50 hover:bg-muted transition-colors">
                <div className="flex items-center gap-3">
                  <Inbox className="h-5 w-5 text-primary" />
                  <span className="font-medium">Received Messages</span>
                </div>
                <Badge variant="secondary" className="text-base px-4">{messageStats.received}</Badge>
              </div>
              <div className="flex items-center justify-between py-3 px-4 rounded-lg bg-muted/50 hover:bg-muted transition-colors">
                <div className="flex items-center gap-3">
                  <Send className="h-5 w-5 text-primary" />
                  <span className="font-medium">Sent Messages</span>
                </div>
                <Badge variant="secondary" className="text-base px-4">{messageStats.sent}</Badge>
              </div>
            </div>
          </CardContent>
        </Card>

        {/* Statistics Section */}
        <Card>
          <CardHeader className="flex flex-row items-center justify-between pb-2">
            <CardTitle className="text-lg font-semibold flex items-center gap-2">
              <Eye className="h-5 w-5 text-primary" />
              Statistics
            </CardTitle>
            <Badge className="bg-green-600 hover:bg-green-700">
              <MessageSquare className="h-3 w-3 mr-1" />
              Get On WhatsApp
            </Badge>
          </CardHeader>
          <CardContent>
            <div className="space-y-3">
              {profileStats.map((stat, index) => (
                <div 
                  key={index}
                  className="flex items-center justify-between py-3 px-4 rounded-lg bg-muted/50 hover:bg-muted transition-colors"
                >
                  <div className="flex items-center gap-3">
                    <stat.icon className="h-5 w-5 text-primary" />
                    <span className="font-medium">{stat.label}</span>
                  </div>
                  <Badge variant="secondary" className="text-base px-4">{stat.count}</Badge>
                </div>
              ))}
            </div>
          </CardContent>
        </Card>

        {/* Plan Details Section */}
        <Card>
          <CardHeader>
            <CardTitle className="text-lg font-semibold">Plan Details</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
              <div className="text-center p-4 rounded-lg bg-muted/50 border">
                <p className="text-sm text-muted-foreground font-medium uppercase">{planDetails.name}</p>
                <p className="text-lg font-bold text-primary mt-1">{planDetails.price}</p>
              </div>
              <div className="text-center p-4 rounded-lg bg-muted/50 border">
                <p className="text-sm text-muted-foreground font-medium uppercase">Duration</p>
                <p className="text-lg font-bold text-primary mt-1">{planDetails.duration}</p>
              </div>
              <div className="text-center p-4 rounded-lg bg-muted/50 border">
                <p className="text-sm text-muted-foreground font-medium uppercase">Contact</p>
                <p className="text-lg font-bold text-primary mt-1">{planDetails.contact.total}</p>
                <p className="text-xs text-muted-foreground">(Used: {planDetails.contact.used})</p>
              </div>
              <div className="text-center p-4 rounded-lg bg-muted/50 border">
                <p className="text-sm text-muted-foreground font-medium uppercase">View Profile</p>
                <p className="text-lg font-bold text-primary mt-1">{planDetails.viewProfile.total}</p>
                <p className="text-xs text-muted-foreground">(Used: {planDetails.viewProfile.used})</p>
              </div>
              <div className="text-center p-4 rounded-lg bg-muted/50 border">
                <p className="text-sm text-muted-foreground font-medium uppercase">Message</p>
                <p className="text-lg font-bold text-primary mt-1">{planDetails.message.total}</p>
                <p className="text-xs text-muted-foreground">(Used: {planDetails.message.used})</p>
              </div>
              <div className="text-center p-4 rounded-lg bg-muted/50 border">
                <p className="text-sm text-muted-foreground font-medium uppercase">Expiry Date</p>
                <p className="text-lg font-bold text-primary mt-1">{planDetails.expiryDate}</p>
              </div>
            </div>
          </CardContent>
        </Card>
      </main>
      </div>
    </div>
  );
};

export default ProfileStatistics;
