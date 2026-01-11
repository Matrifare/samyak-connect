import { useParams, Link } from "react-router-dom";
import { ArrowLeft, MapPin, Briefcase, GraduationCap, Calendar, Ruler, Users, Home, Star, CheckCircle, Heart } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Separator } from "@/components/ui/separator";
import Header from "@/components/matrimony/Header";
import Footer from "@/components/matrimony/Footer";
import ProfileActions from "@/components/profile/ProfileActions";
import defaultMale from "@/assets/default-male.jpg";
import defaultFemale from "@/assets/default-female.jpg";

// Dummy profile data with extended details
const profilesData: Record<string, {
  id: string;
  name: string;
  age: number;
  height: string;
  religion: string;
  caste: string;
  education: string;
  occupation: string;
  city: string;
  gender: string;
  verified: boolean;
  premium: boolean;
  lastOnline: string;
  about: string;
  income: string;
  maritalStatus: string;
  motherTongue: string;
  familyType: string;
  familyStatus: string;
  fatherOccupation: string;
  motherOccupation: string;
  siblings: string;
  partnerAgeRange: string;
  partnerHeightRange: string;
  partnerEducation: string;
  partnerOccupation: string;
  partnerLocation: string;
  hobbies: string[];
}> = {
  "NX1234": {
    id: "NX1234",
    name: "Priya Sharma",
    age: 26,
    height: "5ft 4in",
    religion: "Buddhist",
    caste: "Mahar",
    education: "MBA",
    occupation: "Software Engineer",
    city: "Mumbai",
    gender: "female",
    verified: true,
    premium: true,
    lastOnline: "Online now",
    about: "I am a career-oriented individual who believes in balancing work and personal life. I enjoy reading, traveling, and exploring new cuisines. Looking for a life partner who shares similar values and has a positive outlook towards life.",
    income: "15-20 LPA",
    maritalStatus: "Never Married",
    motherTongue: "Marathi",
    familyType: "Nuclear Family",
    familyStatus: "Middle Class",
    fatherOccupation: "Government Employee",
    motherOccupation: "Homemaker",
    siblings: "1 Brother (Married)",
    partnerAgeRange: "27-32 years",
    partnerHeightRange: "5ft 6in - 6ft",
    partnerEducation: "Graduate or above",
    partnerOccupation: "Private/Government Job",
    partnerLocation: "Maharashtra, Delhi, Karnataka",
    hobbies: ["Reading", "Traveling", "Cooking", "Yoga"]
  }
};

// Default profile for IDs not in our detailed data
const getDefaultProfile = (id: string) => ({
  id,
  name: "Profile Member",
  age: 28,
  height: "5ft 6in",
  religion: "Buddhist",
  caste: "Bauddha",
  education: "Graduate",
  occupation: "Professional",
  city: "Mumbai",
  gender: id.startsWith("NX") ? "female" : "male",
  verified: true,
  premium: false,
  lastOnline: "Recently active",
  about: "I am looking for a compatible life partner who values family, respects traditions, and believes in mutual growth. I am a simple person with strong family values and a positive attitude towards life. Looking forward to meeting someone who shares similar interests and life goals.",
  income: "8-12 LPA",
  maritalStatus: "Never Married",
  motherTongue: "Marathi",
  familyType: "Joint Family",
  familyStatus: "Middle Class",
  fatherOccupation: "Business",
  motherOccupation: "Homemaker",
  siblings: "1 Sister",
  partnerAgeRange: "25-32 years",
  partnerHeightRange: "5ft 2in - 5ft 8in",
  partnerEducation: "Graduate or above",
  partnerOccupation: "Any",
  partnerLocation: "Maharashtra",
  hobbies: ["Music", "Movies", "Sports", "Reading"]
});

const Profile = () => {
  const { id } = useParams<{ id: string }>();
  const profile = id && profilesData[id] ? profilesData[id] : getDefaultProfile(id || "NX0000");

  return (
    <div className="min-h-screen bg-gradient-to-b from-secondary/30 to-background">
      <Header />
      
      <main className="pt-24 pb-16">
        <div className="container mx-auto px-4">
          {/* Back Button */}
          <Link to="/search" className="inline-flex items-center gap-2 text-muted-foreground hover:text-primary mb-6 transition-colors">
            <ArrowLeft className="h-4 w-4" />
            Back to Search Results
          </Link>

          <div className="grid lg:grid-cols-3 gap-6">
            {/* Left Column - Photo & Quick Actions */}
            <div className="lg:col-span-1">
              <div className="bg-card rounded-xl shadow-lg border border-border overflow-hidden sticky top-24">
                {/* Profile Photo */}
                <div className="relative aspect-[3/4]">
                  <img
                    src={profile.gender === "female" ? defaultFemale : defaultMale}
                    alt={profile.name}
                    className="w-full h-full object-cover object-top"
                  />
                  {profile.premium && (
                    <Badge className="absolute top-4 left-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white">
                      Premium Member
                    </Badge>
                  )}
                  {profile.verified && (
                    <Badge className="absolute top-4 right-4 bg-green-500 text-white flex items-center gap-1">
                      <CheckCircle className="h-3 w-3" />
                      Verified
                    </Badge>
                  )}
                  <div className="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-4">
                    <span className="text-white text-sm font-medium">{profile.lastOnline}</span>
                  </div>
                </div>

                {/* Quick Actions */}
                <div className="p-4 space-y-4">
                  <h4 className="font-semibold text-sm text-foreground">Quick Actions</h4>
                  <ProfileActions profileId={profile.id} variant="full" className="flex-col" />
                </div>
              </div>
            </div>

            {/* Right Column - Profile Details */}
            <div className="lg:col-span-2 space-y-6">
              {/* Basic Info */}
              <div className="bg-card rounded-xl shadow-lg border border-border p-6">
                <div className="flex items-start justify-between mb-4">
                  <div>
                    <h1 className="text-2xl font-bold text-foreground">{profile.name}</h1>
                    <p className="text-primary font-medium">{profile.id}</p>
                  </div>
                </div>

                <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                  <div className="flex items-center gap-2 text-muted-foreground">
                    <Calendar className="h-4 w-4" />
                    <span className="text-sm">{profile.age} years</span>
                  </div>
                  <div className="flex items-center gap-2 text-muted-foreground">
                    <Ruler className="h-4 w-4" />
                    <span className="text-sm">{profile.height}</span>
                  </div>
                  <div className="flex items-center gap-2 text-muted-foreground">
                    <MapPin className="h-4 w-4" />
                    <span className="text-sm">{profile.city}</span>
                  </div>
                  <div className="flex items-center gap-2 text-muted-foreground">
                    <Users className="h-4 w-4" />
                    <span className="text-sm">{profile.maritalStatus}</span>
                  </div>
                </div>

                <Separator className="my-4" />

                <h3 className="font-semibold text-foreground mb-3">About</h3>
                <p className="text-muted-foreground leading-relaxed">{profile.about}</p>
              </div>

              {/* Personal Details */}
              <div className="bg-card rounded-xl shadow-lg border border-border p-6">
                <h3 className="font-semibold text-foreground mb-4 flex items-center gap-2">
                  <Star className="h-5 w-5 text-primary" />
                  Personal Details
                </h3>
                <div className="grid md:grid-cols-2 gap-4">
                  <DetailRow label="Religion" value={profile.religion} />
                  <DetailRow label="Caste" value={profile.caste} />
                  <DetailRow label="Mother Tongue" value={profile.motherTongue} />
                  <DetailRow label="Marital Status" value={profile.maritalStatus} />
                </div>
              </div>

              {/* Education & Career */}
              <div className="bg-card rounded-xl shadow-lg border border-border p-6">
                <h3 className="font-semibold text-foreground mb-4 flex items-center gap-2">
                  <GraduationCap className="h-5 w-5 text-primary" />
                  Education & Career
                </h3>
                <div className="grid md:grid-cols-2 gap-4">
                  <DetailRow label="Education" value={profile.education} />
                  <DetailRow label="Occupation" value={profile.occupation} />
                  <DetailRow label="Annual Income" value={profile.income} />
                  <DetailRow label="Working In" value={profile.city} />
                </div>
              </div>

              {/* Family Details */}
              <div className="bg-card rounded-xl shadow-lg border border-border p-6">
                <h3 className="font-semibold text-foreground mb-4 flex items-center gap-2">
                  <Home className="h-5 w-5 text-primary" />
                  Family Details
                </h3>
                <div className="grid md:grid-cols-2 gap-4">
                  <DetailRow label="Family Type" value={profile.familyType} />
                  <DetailRow label="Family Status" value={profile.familyStatus} />
                  <DetailRow label="Father's Occupation" value={profile.fatherOccupation} />
                  <DetailRow label="Mother's Occupation" value={profile.motherOccupation} />
                  <DetailRow label="Siblings" value={profile.siblings} />
                </div>
              </div>

              {/* Partner Preferences */}
              <div className="bg-card rounded-xl shadow-lg border border-border p-6">
                <h3 className="font-semibold text-foreground mb-4 flex items-center gap-2">
                  <Heart className="h-5 w-5 text-primary" />
                  Partner Preferences
                </h3>
                <div className="grid md:grid-cols-2 gap-4">
                  <DetailRow label="Age" value={profile.partnerAgeRange} />
                  <DetailRow label="Height" value={profile.partnerHeightRange} />
                  <DetailRow label="Education" value={profile.partnerEducation} />
                  <DetailRow label="Occupation" value={profile.partnerOccupation} />
                  <DetailRow label="Location" value={profile.partnerLocation} />
                </div>
              </div>

              {/* Hobbies & Interests */}
              <div className="bg-card rounded-xl shadow-lg border border-border p-6">
                <h3 className="font-semibold text-foreground mb-4 flex items-center gap-2">
                  <Briefcase className="h-5 w-5 text-primary" />
                  Hobbies & Interests
                </h3>
                <div className="flex flex-wrap gap-2">
                  {profile.hobbies.map((hobby) => (
                    <Badge key={hobby} variant="secondary" className="text-sm px-3 py-1">
                      {hobby}
                    </Badge>
                  ))}
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>

      <Footer />
    </div>
  );
};

// Helper component for detail rows
const DetailRow = ({ label, value }: { label: string; value: string }) => (
  <div className="flex flex-col">
    <span className="text-sm text-muted-foreground">{label}</span>
    <span className="font-medium text-foreground">{value}</span>
  </div>
);

export default Profile;
