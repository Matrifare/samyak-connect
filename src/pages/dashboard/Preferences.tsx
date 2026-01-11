import { useState } from "react";
import { Save, Heart } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Checkbox } from "@/components/ui/checkbox";
import { Slider } from "@/components/ui/slider";
import { toast } from "@/hooks/use-toast";
import DashboardSidebar from "@/components/dashboard/DashboardSidebar";
import DashboardHeader from "@/components/dashboard/DashboardHeader";
import defaultMale from "@/assets/default-male.jpg";

const userData = {
  name: "Rahul More",
  profileId: "NX1235",
  avatar: defaultMale,
};

const Preferences = () => {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [preferences, setPreferences] = useState({
    ageRange: [22, 30],
    heightRange: [5.0, 5.8],
    maritalStatus: ["never_married"],
    religions: ["buddhist"],
    castes: ["mahar", "nav_bauddha", "bauddha"],
    educations: ["graduate", "postgraduate"],
    occupations: ["private", "government", "business"],
    incomeRange: "5-12",
    cities: ["mumbai", "pune", "nagpur", "delhi", "bangalore"],
    diet: "any",
    smoking: "no",
    drinking: "any",
  });

  const handleSave = () => {
    toast({
      title: "Preferences Saved",
      description: "Your partner preferences have been updated.",
    });
  };

  const toggleArrayItem = (key: string, value: string) => {
    setPreferences(prev => {
      const arr = prev[key as keyof typeof prev] as string[];
      if (arr.includes(value)) {
        return { ...prev, [key]: arr.filter(v => v !== value) };
      }
      return { ...prev, [key]: [...arr, value] };
    });
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-secondary/30 via-background to-secondary/20">
      <DashboardSidebar isOpen={sidebarOpen} onClose={() => setSidebarOpen(false)} />
      
      <div className="lg:pl-64">
        <DashboardHeader onMenuClick={() => setSidebarOpen(true)} user={userData} />
        
        <main className="p-4 md:p-6 lg:p-8 max-w-4xl">
          <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
              <h1 className="text-2xl md:text-3xl font-bold text-foreground">Partner Preferences</h1>
              <p className="text-muted-foreground">Set your preferences to find the perfect match</p>
            </div>
            <Button onClick={handleSave} className="bg-gradient-primary gap-2">
              <Save className="h-4 w-4" />
              Save Preferences
            </Button>
          </div>

          <div className="space-y-6">
            {/* Basic Preferences */}
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center gap-2">
                  <Heart className="h-5 w-5 text-primary" />
                  Basic Preferences
                </CardTitle>
                <CardDescription>
                  Set your preferred age and height range
                </CardDescription>
              </CardHeader>
              <CardContent className="space-y-8">
                <div className="space-y-4">
                  <div className="flex items-center justify-between">
                    <Label>Age Range</Label>
                    <span className="text-sm font-medium text-primary">
                      {preferences.ageRange[0]} - {preferences.ageRange[1]} years
                    </span>
                  </div>
                  <Slider
                    value={preferences.ageRange}
                    onValueChange={(v) => setPreferences(p => ({ ...p, ageRange: v }))}
                    min={18}
                    max={50}
                    step={1}
                    className="w-full"
                  />
                </div>

                <div className="space-y-4">
                  <div className="flex items-center justify-between">
                    <Label>Height Range</Label>
                    <span className="text-sm font-medium text-primary">
                      {preferences.heightRange[0].toFixed(1)}ft - {preferences.heightRange[1].toFixed(1)}ft
                    </span>
                  </div>
                  <Slider
                    value={preferences.heightRange}
                    onValueChange={(v) => setPreferences(p => ({ ...p, heightRange: v }))}
                    min={4.0}
                    max={7.0}
                    step={0.1}
                    className="w-full"
                  />
                </div>

                <div className="grid md:grid-cols-2 gap-6">
                  <div className="space-y-3">
                    <Label>Marital Status</Label>
                    <div className="space-y-2">
                      {[
                        { value: "never_married", label: "Never Married" },
                        { value: "divorced", label: "Divorced" },
                        { value: "widowed", label: "Widowed" },
                      ].map(item => (
                        <div key={item.value} className="flex items-center gap-2">
                          <Checkbox
                            id={item.value}
                            checked={preferences.maritalStatus.includes(item.value)}
                            onCheckedChange={() => toggleArrayItem("maritalStatus", item.value)}
                          />
                          <label htmlFor={item.value} className="text-sm cursor-pointer">
                            {item.label}
                          </label>
                        </div>
                      ))}
                    </div>
                  </div>

                  <div className="space-y-3">
                    <Label>Annual Income</Label>
                    <Select
                      value={preferences.incomeRange}
                      onValueChange={(v) => setPreferences(p => ({ ...p, incomeRange: v }))}
                    >
                      <SelectTrigger>
                        <SelectValue />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="any">Any</SelectItem>
                        <SelectItem value="0-5">0 - 5 LPA</SelectItem>
                        <SelectItem value="5-12">5 - 12 LPA</SelectItem>
                        <SelectItem value="12-20">12 - 20 LPA</SelectItem>
                        <SelectItem value="20+">20+ LPA</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>
                </div>
              </CardContent>
            </Card>

            {/* Religion & Community */}
            <Card>
              <CardHeader>
                <CardTitle>Religion & Community</CardTitle>
              </CardHeader>
              <CardContent className="space-y-6">
                <div className="grid md:grid-cols-2 gap-6">
                  <div className="space-y-3">
                    <Label>Religion</Label>
                    <div className="space-y-2">
                      {[
                        { value: "buddhist", label: "Buddhist" },
                        { value: "hindu", label: "Hindu" },
                        { value: "jain", label: "Jain" },
                      ].map(item => (
                        <div key={item.value} className="flex items-center gap-2">
                          <Checkbox
                            id={`religion-${item.value}`}
                            checked={preferences.religions.includes(item.value)}
                            onCheckedChange={() => toggleArrayItem("religions", item.value)}
                          />
                          <label htmlFor={`religion-${item.value}`} className="text-sm cursor-pointer">
                            {item.label}
                          </label>
                        </div>
                      ))}
                    </div>
                  </div>

                  <div className="space-y-3">
                    <Label>Caste</Label>
                    <div className="space-y-2">
                      {[
                        { value: "mahar", label: "Mahar" },
                        { value: "nav_bauddha", label: "Nav Bauddha" },
                        { value: "bauddha", label: "Bauddha" },
                      ].map(item => (
                        <div key={item.value} className="flex items-center gap-2">
                          <Checkbox
                            id={`caste-${item.value}`}
                            checked={preferences.castes.includes(item.value)}
                            onCheckedChange={() => toggleArrayItem("castes", item.value)}
                          />
                          <label htmlFor={`caste-${item.value}`} className="text-sm cursor-pointer">
                            {item.label}
                          </label>
                        </div>
                      ))}
                    </div>
                  </div>
                </div>
              </CardContent>
            </Card>

            {/* Education & Occupation */}
            <Card>
              <CardHeader>
                <CardTitle>Education & Occupation</CardTitle>
              </CardHeader>
              <CardContent className="space-y-6">
                <div className="grid md:grid-cols-2 gap-6">
                  <div className="space-y-3">
                    <Label>Education</Label>
                    <div className="space-y-2">
                      {[
                        { value: "any", label: "Any" },
                        { value: "graduate", label: "Graduate" },
                        { value: "postgraduate", label: "Post Graduate" },
                        { value: "doctorate", label: "Doctorate" },
                      ].map(item => (
                        <div key={item.value} className="flex items-center gap-2">
                          <Checkbox
                            id={`edu-${item.value}`}
                            checked={preferences.educations.includes(item.value)}
                            onCheckedChange={() => toggleArrayItem("educations", item.value)}
                          />
                          <label htmlFor={`edu-${item.value}`} className="text-sm cursor-pointer">
                            {item.label}
                          </label>
                        </div>
                      ))}
                    </div>
                  </div>

                  <div className="space-y-3">
                    <Label>Occupation</Label>
                    <div className="space-y-2">
                      {[
                        { value: "private", label: "Private Job" },
                        { value: "government", label: "Government Job" },
                        { value: "business", label: "Business" },
                        { value: "professional", label: "Professional" },
                      ].map(item => (
                        <div key={item.value} className="flex items-center gap-2">
                          <Checkbox
                            id={`occ-${item.value}`}
                            checked={preferences.occupations.includes(item.value)}
                            onCheckedChange={() => toggleArrayItem("occupations", item.value)}
                          />
                          <label htmlFor={`occ-${item.value}`} className="text-sm cursor-pointer">
                            {item.label}
                          </label>
                        </div>
                      ))}
                    </div>
                  </div>
                </div>
              </CardContent>
            </Card>

            {/* Lifestyle */}
            <Card>
              <CardHeader>
                <CardTitle>Lifestyle Preferences</CardTitle>
              </CardHeader>
              <CardContent>
                <div className="grid md:grid-cols-3 gap-6">
                  <div className="space-y-2">
                    <Label>Diet</Label>
                    <Select
                      value={preferences.diet}
                      onValueChange={(v) => setPreferences(p => ({ ...p, diet: v }))}
                    >
                      <SelectTrigger>
                        <SelectValue />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="any">Any</SelectItem>
                        <SelectItem value="vegetarian">Vegetarian</SelectItem>
                        <SelectItem value="non_vegetarian">Non-Vegetarian</SelectItem>
                        <SelectItem value="vegan">Vegan</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>

                  <div className="space-y-2">
                    <Label>Smoking</Label>
                    <Select
                      value={preferences.smoking}
                      onValueChange={(v) => setPreferences(p => ({ ...p, smoking: v }))}
                    >
                      <SelectTrigger>
                        <SelectValue />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="any">Any</SelectItem>
                        <SelectItem value="no">No</SelectItem>
                        <SelectItem value="occasionally">Occasionally</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>

                  <div className="space-y-2">
                    <Label>Drinking</Label>
                    <Select
                      value={preferences.drinking}
                      onValueChange={(v) => setPreferences(p => ({ ...p, drinking: v }))}
                    >
                      <SelectTrigger>
                        <SelectValue />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="any">Any</SelectItem>
                        <SelectItem value="no">No</SelectItem>
                        <SelectItem value="occasionally">Occasionally</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>
                </div>
              </CardContent>
            </Card>
          </div>
        </main>
      </div>
    </div>
  );
};

export default Preferences;
