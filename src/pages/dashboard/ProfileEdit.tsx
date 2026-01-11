import { useState } from "react";
import { Camera, Save, Plus, X, User, Briefcase, GraduationCap, Home, Heart } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Switch } from "@/components/ui/switch";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { toast } from "@/hooks/use-toast";
import DashboardSidebar from "@/components/dashboard/DashboardSidebar";
import DashboardHeader from "@/components/dashboard/DashboardHeader";
import defaultMale from "@/assets/default-male.jpg";

// Dummy user data
const userData = {
  name: "Rahul More",
  profileId: "NX1235",
  email: "rahul.more@email.com",
  phone: "+91 98765 43210",
  avatar: defaultMale,
};

const ProfileEdit = () => {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [formData, setFormData] = useState({
    // Personal Details
    firstName: "Rahul",
    lastName: "More",
    gender: "male",
    dateOfBirth: "1995-06-15",
    height: "5ft 10in",
    weight: "72",
    bloodGroup: "O+",
    maritalStatus: "never_married",
    motherTongue: "marathi",
    
    // Religion
    religion: "buddhist",
    caste: "nav_bauddha",
    subCaste: "",
    gothra: "",
    
    // Education & Career
    education: "btech",
    educationDetails: "B.Tech in Computer Science from Pune University",
    occupation: "civil_engineer",
    company: "Larsen & Toubro",
    annualIncome: "8-12",
    workingCity: "Pune",
    
    // Family Details
    familyType: "nuclear",
    familyStatus: "middle_class",
    fatherOccupation: "Government Employee",
    motherOccupation: "Homemaker",
    siblings: "1 Sister (Married)",
    familyValues: "moderate",
    
    // Lifestyle
    diet: "vegetarian",
    smoking: "no",
    drinking: "occasionally",
    
    // About
    about: "I am a career-oriented individual who believes in balancing work and personal life. I enjoy reading, traveling, and exploring new cuisines. Looking for a life partner who shares similar values and has a positive outlook towards life.",
    
    // Contact Privacy
    showEmail: true,
    showPhone: false,
  });

  const handleInputChange = (field: string, value: string | boolean) => {
    setFormData(prev => ({ ...prev, [field]: value }));
  };

  const handleSave = () => {
    toast({
      title: "Profile Updated",
      description: "Your profile has been saved successfully.",
    });
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-secondary/30 via-background to-secondary/20">
      <DashboardSidebar isOpen={sidebarOpen} onClose={() => setSidebarOpen(false)} />
      
      <div className="lg:pl-64">
        <DashboardHeader onMenuClick={() => setSidebarOpen(true)} user={userData} />
        
        <main className="p-4 md:p-6 lg:p-8">
          <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
              <h1 className="text-2xl md:text-3xl font-bold text-foreground">Edit Profile</h1>
              <p className="text-muted-foreground">Update your matrimony profile details</p>
            </div>
            <Button onClick={handleSave} className="bg-gradient-primary gap-2">
              <Save className="h-4 w-4" />
              Save Changes
            </Button>
          </div>

          {/* Photo Section */}
          <Card className="mb-6">
            <CardHeader>
              <CardTitle className="flex items-center gap-2">
                <Camera className="h-5 w-5 text-primary" />
                Profile Photos
              </CardTitle>
            </CardHeader>
            <CardContent>
              <div className="flex flex-wrap gap-4">
                {/* Main Photo */}
                <div className="relative">
                  <img
                    src={defaultMale}
                    alt="Profile"
                    className="h-32 w-32 rounded-lg object-cover border-2 border-primary"
                  />
                  <button className="absolute -bottom-2 -right-2 bg-primary text-primary-foreground p-2 rounded-full hover:bg-primary/90 transition-colors">
                    <Camera className="h-4 w-4" />
                  </button>
                  <span className="absolute -top-2 -left-2 bg-primary text-primary-foreground text-xs px-2 py-0.5 rounded">
                    Main
                  </span>
                </div>
                
                {/* Additional Photos */}
                {[1, 2, 3].map((index) => (
                  <div
                    key={index}
                    className="h-32 w-32 rounded-lg border-2 border-dashed border-muted-foreground/30 flex items-center justify-center hover:border-primary/50 transition-colors cursor-pointer bg-secondary/30"
                  >
                    <div className="text-center">
                      <Plus className="h-6 w-6 mx-auto text-muted-foreground" />
                      <span className="text-xs text-muted-foreground">Add Photo</span>
                    </div>
                  </div>
                ))}
              </div>
              <p className="text-sm text-muted-foreground mt-4">
                Add up to 6 photos. First photo will be your profile picture.
              </p>
            </CardContent>
          </Card>

          {/* Profile Form Tabs */}
          <Tabs defaultValue="personal" className="space-y-6">
            <TabsList className="grid grid-cols-2 md:grid-cols-5 gap-2 h-auto p-1">
              <TabsTrigger value="personal" className="gap-2">
                <User className="h-4 w-4" />
                <span className="hidden sm:inline">Personal</span>
              </TabsTrigger>
              <TabsTrigger value="religion" className="gap-2">
                <Heart className="h-4 w-4" />
                <span className="hidden sm:inline">Religion</span>
              </TabsTrigger>
              <TabsTrigger value="education" className="gap-2">
                <GraduationCap className="h-4 w-4" />
                <span className="hidden sm:inline">Education</span>
              </TabsTrigger>
              <TabsTrigger value="family" className="gap-2">
                <Home className="h-4 w-4" />
                <span className="hidden sm:inline">Family</span>
              </TabsTrigger>
              <TabsTrigger value="lifestyle" className="gap-2">
                <Briefcase className="h-4 w-4" />
                <span className="hidden sm:inline">Lifestyle</span>
              </TabsTrigger>
            </TabsList>

            {/* Personal Details */}
            <TabsContent value="personal">
              <Card>
                <CardHeader>
                  <CardTitle>Personal Details</CardTitle>
                </CardHeader>
                <CardContent className="space-y-6">
                  <div className="grid md:grid-cols-2 gap-4">
                    <div className="space-y-2">
                      <Label htmlFor="firstName">First Name</Label>
                      <Input
                        id="firstName"
                        value={formData.firstName}
                        onChange={(e) => handleInputChange("firstName", e.target.value)}
                      />
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="lastName">Last Name</Label>
                      <Input
                        id="lastName"
                        value={formData.lastName}
                        onChange={(e) => handleInputChange("lastName", e.target.value)}
                      />
                    </div>
                  </div>

                  <div className="grid md:grid-cols-3 gap-4">
                    <div className="space-y-2">
                      <Label htmlFor="gender">Gender</Label>
                      <Select value={formData.gender} onValueChange={(v) => handleInputChange("gender", v)}>
                        <SelectTrigger>
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="male">Male</SelectItem>
                          <SelectItem value="female">Female</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="dob">Date of Birth</Label>
                      <Input
                        id="dob"
                        type="date"
                        value={formData.dateOfBirth}
                        onChange={(e) => handleInputChange("dateOfBirth", e.target.value)}
                      />
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="maritalStatus">Marital Status</Label>
                      <Select value={formData.maritalStatus} onValueChange={(v) => handleInputChange("maritalStatus", v)}>
                        <SelectTrigger>
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="never_married">Never Married</SelectItem>
                          <SelectItem value="divorced">Divorced</SelectItem>
                          <SelectItem value="widowed">Widowed</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                  </div>

                  <div className="grid md:grid-cols-3 gap-4">
                    <div className="space-y-2">
                      <Label htmlFor="height">Height</Label>
                      <Select value={formData.height} onValueChange={(v) => handleInputChange("height", v)}>
                        <SelectTrigger>
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          {["5ft 0in", "5ft 2in", "5ft 4in", "5ft 6in", "5ft 8in", "5ft 10in", "6ft 0in", "6ft 2in"].map(h => (
                            <SelectItem key={h} value={h}>{h}</SelectItem>
                          ))}
                        </SelectContent>
                      </Select>
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="weight">Weight (kg)</Label>
                      <Input
                        id="weight"
                        type="number"
                        value={formData.weight}
                        onChange={(e) => handleInputChange("weight", e.target.value)}
                      />
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="motherTongue">Mother Tongue</Label>
                      <Select value={formData.motherTongue} onValueChange={(v) => handleInputChange("motherTongue", v)}>
                        <SelectTrigger>
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="marathi">Marathi</SelectItem>
                          <SelectItem value="hindi">Hindi</SelectItem>
                          <SelectItem value="english">English</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                  </div>

                  <div className="space-y-2">
                    <Label htmlFor="about">About Me</Label>
                    <Textarea
                      id="about"
                      value={formData.about}
                      onChange={(e) => handleInputChange("about", e.target.value)}
                      rows={4}
                      placeholder="Write about yourself..."
                    />
                    <p className="text-xs text-muted-foreground">
                      {formData.about.length}/500 characters
                    </p>
                  </div>
                </CardContent>
              </Card>
            </TabsContent>

            {/* Religion */}
            <TabsContent value="religion">
              <Card>
                <CardHeader>
                  <CardTitle>Religion & Community</CardTitle>
                </CardHeader>
                <CardContent className="space-y-6">
                  <div className="grid md:grid-cols-2 gap-4">
                    <div className="space-y-2">
                      <Label htmlFor="religion">Religion</Label>
                      <Select value={formData.religion} onValueChange={(v) => handleInputChange("religion", v)}>
                        <SelectTrigger>
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="buddhist">Buddhist</SelectItem>
                          <SelectItem value="hindu">Hindu</SelectItem>
                          <SelectItem value="jain">Jain</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="caste">Caste</Label>
                      <Select value={formData.caste} onValueChange={(v) => handleInputChange("caste", v)}>
                        <SelectTrigger>
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="mahar">Mahar</SelectItem>
                          <SelectItem value="nav_bauddha">Nav Bauddha</SelectItem>
                          <SelectItem value="bauddha">Bauddha</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div className="space-y-2">
                      <Label htmlFor="subCaste">Sub Caste (Optional)</Label>
                      <Input
                        id="subCaste"
                        value={formData.subCaste}
                        onChange={(e) => handleInputChange("subCaste", e.target.value)}
                        placeholder="Enter sub caste"
                      />
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="gothra">Gothra (Optional)</Label>
                      <Input
                        id="gothra"
                        value={formData.gothra}
                        onChange={(e) => handleInputChange("gothra", e.target.value)}
                        placeholder="Enter gothra"
                      />
                    </div>
                  </div>
                </CardContent>
              </Card>
            </TabsContent>

            {/* Education & Career */}
            <TabsContent value="education">
              <Card>
                <CardHeader>
                  <CardTitle>Education & Career</CardTitle>
                </CardHeader>
                <CardContent className="space-y-6">
                  <div className="grid md:grid-cols-2 gap-4">
                    <div className="space-y-2">
                      <Label htmlFor="education">Highest Education</Label>
                      <Select value={formData.education} onValueChange={(v) => handleInputChange("education", v)}>
                        <SelectTrigger>
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="10th">10th</SelectItem>
                          <SelectItem value="12th">12th</SelectItem>
                          <SelectItem value="diploma">Diploma</SelectItem>
                          <SelectItem value="graduate">Graduate</SelectItem>
                          <SelectItem value="btech">B.Tech/B.E</SelectItem>
                          <SelectItem value="mba">MBA</SelectItem>
                          <SelectItem value="mtech">M.Tech/M.E</SelectItem>
                          <SelectItem value="mbbs">MBBS</SelectItem>
                          <SelectItem value="phd">PhD</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="educationDetails">Education Details</Label>
                      <Input
                        id="educationDetails"
                        value={formData.educationDetails}
                        onChange={(e) => handleInputChange("educationDetails", e.target.value)}
                        placeholder="College name, specialization..."
                      />
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div className="space-y-2">
                      <Label htmlFor="occupation">Occupation</Label>
                      <Select value={formData.occupation} onValueChange={(v) => handleInputChange("occupation", v)}>
                        <SelectTrigger>
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="software_engineer">Software Engineer</SelectItem>
                          <SelectItem value="civil_engineer">Civil Engineer</SelectItem>
                          <SelectItem value="doctor">Doctor</SelectItem>
                          <SelectItem value="teacher">Teacher</SelectItem>
                          <SelectItem value="government">Government Employee</SelectItem>
                          <SelectItem value="business">Business</SelectItem>
                          <SelectItem value="other">Other</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="company">Company/Organization</Label>
                      <Input
                        id="company"
                        value={formData.company}
                        onChange={(e) => handleInputChange("company", e.target.value)}
                        placeholder="Company name"
                      />
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div className="space-y-2">
                      <Label htmlFor="annualIncome">Annual Income (LPA)</Label>
                      <Select value={formData.annualIncome} onValueChange={(v) => handleInputChange("annualIncome", v)}>
                        <SelectTrigger>
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="0-3">0-3 LPA</SelectItem>
                          <SelectItem value="3-5">3-5 LPA</SelectItem>
                          <SelectItem value="5-8">5-8 LPA</SelectItem>
                          <SelectItem value="8-12">8-12 LPA</SelectItem>
                          <SelectItem value="12-20">12-20 LPA</SelectItem>
                          <SelectItem value="20+">20+ LPA</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="workingCity">Working City</Label>
                      <Input
                        id="workingCity"
                        value={formData.workingCity}
                        onChange={(e) => handleInputChange("workingCity", e.target.value)}
                        placeholder="City name"
                      />
                    </div>
                  </div>
                </CardContent>
              </Card>
            </TabsContent>

            {/* Family Details */}
            <TabsContent value="family">
              <Card>
                <CardHeader>
                  <CardTitle>Family Details</CardTitle>
                </CardHeader>
                <CardContent className="space-y-6">
                  <div className="grid md:grid-cols-2 gap-4">
                    <div className="space-y-2">
                      <Label htmlFor="familyType">Family Type</Label>
                      <Select value={formData.familyType} onValueChange={(v) => handleInputChange("familyType", v)}>
                        <SelectTrigger>
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="nuclear">Nuclear Family</SelectItem>
                          <SelectItem value="joint">Joint Family</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="familyStatus">Family Status</Label>
                      <Select value={formData.familyStatus} onValueChange={(v) => handleInputChange("familyStatus", v)}>
                        <SelectTrigger>
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="middle_class">Middle Class</SelectItem>
                          <SelectItem value="upper_middle_class">Upper Middle Class</SelectItem>
                          <SelectItem value="rich">Rich</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div className="space-y-2">
                      <Label htmlFor="fatherOccupation">Father's Occupation</Label>
                      <Input
                        id="fatherOccupation"
                        value={formData.fatherOccupation}
                        onChange={(e) => handleInputChange("fatherOccupation", e.target.value)}
                      />
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="motherOccupation">Mother's Occupation</Label>
                      <Input
                        id="motherOccupation"
                        value={formData.motherOccupation}
                        onChange={(e) => handleInputChange("motherOccupation", e.target.value)}
                      />
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div className="space-y-2">
                      <Label htmlFor="siblings">Siblings</Label>
                      <Input
                        id="siblings"
                        value={formData.siblings}
                        onChange={(e) => handleInputChange("siblings", e.target.value)}
                        placeholder="e.g., 1 Brother, 1 Sister (Married)"
                      />
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="familyValues">Family Values</Label>
                      <Select value={formData.familyValues} onValueChange={(v) => handleInputChange("familyValues", v)}>
                        <SelectTrigger>
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="traditional">Traditional</SelectItem>
                          <SelectItem value="moderate">Moderate</SelectItem>
                          <SelectItem value="liberal">Liberal</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                  </div>
                </CardContent>
              </Card>
            </TabsContent>

            {/* Lifestyle */}
            <TabsContent value="lifestyle">
              <Card>
                <CardHeader>
                  <CardTitle>Lifestyle & Habits</CardTitle>
                </CardHeader>
                <CardContent className="space-y-6">
                  <div className="grid md:grid-cols-3 gap-4">
                    <div className="space-y-2">
                      <Label htmlFor="diet">Diet</Label>
                      <Select value={formData.diet} onValueChange={(v) => handleInputChange("diet", v)}>
                        <SelectTrigger>
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="vegetarian">Vegetarian</SelectItem>
                          <SelectItem value="non_vegetarian">Non-Vegetarian</SelectItem>
                          <SelectItem value="eggetarian">Eggetarian</SelectItem>
                          <SelectItem value="vegan">Vegan</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="smoking">Smoking</Label>
                      <Select value={formData.smoking} onValueChange={(v) => handleInputChange("smoking", v)}>
                        <SelectTrigger>
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="no">No</SelectItem>
                          <SelectItem value="occasionally">Occasionally</SelectItem>
                          <SelectItem value="yes">Yes</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="drinking">Drinking</Label>
                      <Select value={formData.drinking} onValueChange={(v) => handleInputChange("drinking", v)}>
                        <SelectTrigger>
                          <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="no">No</SelectItem>
                          <SelectItem value="occasionally">Occasionally</SelectItem>
                          <SelectItem value="yes">Yes</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                  </div>

                  <div className="space-y-4 pt-4 border-t">
                    <h4 className="font-medium">Privacy Settings</h4>
                    <div className="flex items-center justify-between">
                      <div>
                        <Label htmlFor="showEmail">Show Email to Matches</Label>
                        <p className="text-sm text-muted-foreground">Allow matched profiles to see your email</p>
                      </div>
                      <Switch
                        id="showEmail"
                        checked={formData.showEmail}
                        onCheckedChange={(v) => handleInputChange("showEmail", v)}
                      />
                    </div>
                    <div className="flex items-center justify-between">
                      <div>
                        <Label htmlFor="showPhone">Show Phone to Matches</Label>
                        <p className="text-sm text-muted-foreground">Allow matched profiles to see your phone number</p>
                      </div>
                      <Switch
                        id="showPhone"
                        checked={formData.showPhone}
                        onCheckedChange={(v) => handleInputChange("showPhone", v)}
                      />
                    </div>
                  </div>
                </CardContent>
              </Card>
            </TabsContent>
          </Tabs>
        </main>
      </div>
    </div>
  );
};

export default ProfileEdit;
