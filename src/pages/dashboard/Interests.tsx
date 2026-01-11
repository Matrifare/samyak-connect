import { useState } from "react";
import { Link } from "react-router-dom";
import { Heart, Eye, Check, X, Send, Inbox, MapPin, GraduationCap, Briefcase } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Card, CardContent } from "@/components/ui/card";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
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

// Dummy interests data
const receivedInterests = [
  { id: "NX1234", name: "Priya Sharma", age: 26, city: "Mumbai", education: "MBA", occupation: "Software Engineer", gender: "female", receivedOn: "2 hours ago", status: "pending" },
  { id: "NX1238", name: "Anjali Jadhav", age: 23, city: "Thane", education: "BBA", occupation: "Marketing Executive", gender: "female", receivedOn: "1 day ago", status: "pending" },
  { id: "NX1241", name: "Rekha Ghodke", age: 24, city: "Mumbai", education: "BDS", occupation: "Dentist", gender: "female", receivedOn: "3 days ago", status: "accepted" },
];

const sentInterests = [
  { id: "NX1237", name: "Pooja Gaikwad", age: 25, city: "Pune", education: "B.Tech", occupation: "IT Professional", gender: "female", sentOn: "1 day ago", status: "pending" },
  { id: "NX1239", name: "Kavita Shinde", age: 27, city: "Aurangabad", education: "MBBS", occupation: "Doctor", gender: "female", sentOn: "3 days ago", status: "accepted" },
  { id: "NX1240", name: "Meera Salve", age: 26, city: "Kolhapur", education: "M.Com", occupation: "Accountant", gender: "female", sentOn: "1 week ago", status: "declined" },
];

const Interests = () => {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [received, setReceived] = useState(receivedInterests);
  const [sent] = useState(sentInterests);

  const handleAccept = (id: string) => {
    setReceived(received.map(i => i.id === id ? { ...i, status: "accepted" } : i));
    toast({
      title: "Interest Accepted",
      description: "You can now message this profile.",
    });
  };

  const handleDecline = (id: string) => {
    setReceived(received.map(i => i.id === id ? { ...i, status: "declined" } : i));
    toast({
      title: "Interest Declined",
      description: "The interest has been declined.",
    });
  };

  const InterestCard = ({ 
    profile, 
    type,
    onAccept,
    onDecline,
  }: { 
    profile: typeof receivedInterests[0] | typeof sentInterests[0];
    type: "received" | "sent";
    onAccept?: (id: string) => void;
    onDecline?: (id: string) => void;
  }) => (
    <Card className="overflow-hidden hover:shadow-lg transition-all">
      <div className="flex">
        <div className="relative w-32 shrink-0">
          <img
            src={profile.gender === "female" ? defaultFemale : defaultMale}
            alt={profile.name}
            className="w-full h-full object-cover object-top"
          />
        </div>
        <CardContent className="p-4 flex-1">
          <div className="flex items-start justify-between mb-2">
            <div>
              <h3 className="font-semibold text-foreground">{profile.name}</h3>
              <p className="text-xs text-primary">{profile.id}</p>
            </div>
            <Badge 
              variant={profile.status === "accepted" ? "default" : profile.status === "declined" ? "destructive" : "secondary"}
              className={profile.status === "accepted" ? "bg-green-500" : ""}
            >
              {profile.status === "pending" ? "Pending" : profile.status === "accepted" ? "Accepted" : "Declined"}
            </Badge>
          </div>
          
          <div className="space-y-1 text-sm text-muted-foreground mb-3">
            <p className="font-medium text-foreground">{profile.age} yrs</p>
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

          <p className="text-xs text-muted-foreground mb-3">
            {type === "received" ? "Received" : "Sent"} {"receivedOn" in profile ? profile.receivedOn : profile.sentOn}
          </p>

          <div className="flex gap-2">
            <Link to={`/profile/${profile.id}`}>
              <Button size="sm" variant="outline" className="gap-1">
                <Eye className="h-3.5 w-3.5" />
                View
              </Button>
            </Link>
            {type === "received" && profile.status === "pending" && (
              <>
                <Button 
                  size="sm" 
                  className="gap-1 bg-green-500 hover:bg-green-600"
                  onClick={() => onAccept?.(profile.id)}
                >
                  <Check className="h-3.5 w-3.5" />
                  Accept
                </Button>
                <Button 
                  size="sm" 
                  variant="outline"
                  className="gap-1 text-rose-500 hover:text-rose-600"
                  onClick={() => onDecline?.(profile.id)}
                >
                  <X className="h-3.5 w-3.5" />
                  Decline
                </Button>
              </>
            )}
          </div>
        </CardContent>
      </div>
    </Card>
  );

  return (
    <div className="min-h-screen bg-gradient-to-br from-secondary/30 via-background to-secondary/20">
      <DashboardSidebar isOpen={sidebarOpen} onClose={() => setSidebarOpen(false)} />
      
      <div className="lg:pl-64">
        <DashboardHeader onMenuClick={() => setSidebarOpen(true)} user={userData} />
        
        <main className="p-4 md:p-6 lg:p-8">
          <div className="mb-6">
            <h1 className="text-2xl md:text-3xl font-bold text-foreground">Interests</h1>
            <p className="text-muted-foreground">Manage your sent and received interests</p>
          </div>

          <Tabs defaultValue="received" className="space-y-6">
            <TabsList className="grid w-full max-w-md grid-cols-2">
              <TabsTrigger value="received" className="gap-2">
                <Inbox className="h-4 w-4" />
                Received ({received.filter(i => i.status === "pending").length})
              </TabsTrigger>
              <TabsTrigger value="sent" className="gap-2">
                <Send className="h-4 w-4" />
                Sent ({sent.length})
              </TabsTrigger>
            </TabsList>

            <TabsContent value="received">
              {received.length === 0 ? (
                <Card className="text-center py-12">
                  <CardContent>
                    <Inbox className="h-12 w-12 mx-auto text-muted-foreground/50 mb-4" />
                    <h3 className="text-lg font-semibold mb-2">No interests received</h3>
                    <p className="text-muted-foreground">
                      Complete your profile to get more interests
                    </p>
                  </CardContent>
                </Card>
              ) : (
                <div className="space-y-4">
                  {received.map((interest) => (
                    <InterestCard
                      key={interest.id}
                      profile={interest}
                      type="received"
                      onAccept={handleAccept}
                      onDecline={handleDecline}
                    />
                  ))}
                </div>
              )}
            </TabsContent>

            <TabsContent value="sent">
              {sent.length === 0 ? (
                <Card className="text-center py-12">
                  <CardContent>
                    <Send className="h-12 w-12 mx-auto text-muted-foreground/50 mb-4" />
                    <h3 className="text-lg font-semibold mb-2">No interests sent</h3>
                    <p className="text-muted-foreground mb-4">
                      Start exploring profiles and send interests
                    </p>
                    <Link to="/search">
                      <Button className="bg-gradient-primary">Browse Profiles</Button>
                    </Link>
                  </CardContent>
                </Card>
              ) : (
                <div className="space-y-4">
                  {sent.map((interest) => (
                    <InterestCard
                      key={interest.id}
                      profile={interest}
                      type="sent"
                    />
                  ))}
                </div>
              )}
            </TabsContent>
          </Tabs>
        </main>
      </div>
    </div>
  );
};

export default Interests;
