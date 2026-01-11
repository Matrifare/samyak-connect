import { useState } from "react";
import { Link } from "react-router-dom";
import { 
  Search as SearchIcon, 
  SlidersHorizontal, 
  Heart, 
  Eye, 
  MapPin, 
  GraduationCap, 
  Briefcase,
  ChevronDown,
  ChevronUp,
  RotateCcw,
  User
} from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Slider } from "@/components/ui/slider";
import { Checkbox } from "@/components/ui/checkbox";
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

// Sample search results
const sampleProfiles = [
  { id: "NX1234", name: "Priya Sharma", age: 26, height: "5ft 4in", city: "Mumbai", state: "Maharashtra", education: "MBA", occupation: "Software Engineer", caste: "Buddhist", income: "10-15 LPA", gender: "female", maritalStatus: "Never Married" },
  { id: "NX1236", name: "Sneha Kamble", age: 24, height: "5ft 2in", city: "Nagpur", state: "Maharashtra", education: "B.Com", occupation: "Bank Employee", caste: "Buddhist", income: "5-7 LPA", gender: "female", maritalStatus: "Never Married" },
  { id: "NX1237", name: "Pooja Gaikwad", age: 25, height: "5ft 3in", city: "Pune", state: "Maharashtra", education: "B.Tech", occupation: "IT Professional", caste: "Buddhist", income: "8-10 LPA", gender: "female", maritalStatus: "Never Married" },
  { id: "NX1238", name: "Anjali Jadhav", age: 23, height: "5ft 5in", city: "Thane", state: "Maharashtra", education: "BBA", occupation: "Marketing Executive", caste: "Buddhist", income: "4-6 LPA", gender: "female", maritalStatus: "Never Married" },
  { id: "NX1239", name: "Kavita Shinde", age: 27, height: "5ft 4in", city: "Aurangabad", state: "Maharashtra", education: "MBBS", occupation: "Doctor", caste: "Buddhist", income: "15-20 LPA", gender: "female", maritalStatus: "Never Married" },
  { id: "NX1240", name: "Meera Salve", age: 26, height: "5ft 6in", city: "Kolhapur", state: "Maharashtra", education: "M.Com", occupation: "Accountant", caste: "Buddhist", income: "6-8 LPA", gender: "female", maritalStatus: "Divorced" },
];

const casteOptions = ["Buddhist", "Mahar", "Matang", "Chambhar", "Dhor", "Nav-Bauddha", "Other"];
const educationOptions = ["High School", "Graduate", "Post Graduate", "Doctorate", "Diploma", "Professional"];
const occupationOptions = ["IT Professional", "Doctor", "Engineer", "Teacher", "Government Job", "Business", "Lawyer", "Accountant", "Bank Employee", "Other"];
const incomeOptions = ["Below 2 LPA", "2-5 LPA", "5-7 LPA", "7-10 LPA", "10-15 LPA", "15-20 LPA", "Above 20 LPA"];
const maritalStatusOptions = ["Never Married", "Divorced", "Widowed", "Awaiting Divorce"];
const stateOptions = ["Maharashtra", "Gujarat", "Karnataka", "Tamil Nadu", "Uttar Pradesh", "Delhi", "Rajasthan", "Other"];

const Search = () => {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [activeTab, setActiveTab] = useState("quick");
  const [showResults, setShowResults] = useState(false);
  const [searchResults, setSearchResults] = useState(sampleProfiles);

  // Quick Search State
  const [profileId, setProfileId] = useState("");
  const [quickGender, setQuickGender] = useState("");
  const [quickAgeRange, setQuickAgeRange] = useState([21, 35]);
  const [quickCaste, setQuickCaste] = useState("");

  // Advanced Search State
  const [advGender, setAdvGender] = useState("");
  const [advAgeRange, setAdvAgeRange] = useState([18, 45]);
  const [advHeightRange, setAdvHeightRange] = useState([4.5, 6.5]);
  const [advCaste, setAdvCaste] = useState<string[]>([]);
  const [advEducation, setAdvEducation] = useState<string[]>([]);
  const [advOccupation, setAdvOccupation] = useState<string[]>([]);
  const [advIncome, setAdvIncome] = useState("");
  const [advMaritalStatus, setAdvMaritalStatus] = useState<string[]>([]);
  const [advState, setAdvState] = useState("");
  const [advCity, setAdvCity] = useState("");
  const [advShowAdvancedFilters, setAdvShowAdvancedFilters] = useState(false);

  const handleQuickSearch = () => {
    if (profileId) {
      const found = sampleProfiles.filter(p => p.id.toLowerCase().includes(profileId.toLowerCase()));
      if (found.length > 0) {
        setSearchResults(found);
        setShowResults(true);
        toast({ title: "Profile Found", description: `Found ${found.length} matching profile(s)` });
      } else {
        toast({ title: "No Results", description: "No profile found with this ID", variant: "destructive" });
      }
      return;
    }

    // Filter by quick search criteria
    let results = sampleProfiles;
    if (quickGender) results = results.filter(p => p.gender === quickGender);
    if (quickCaste) results = results.filter(p => p.caste === quickCaste);
    results = results.filter(p => p.age >= quickAgeRange[0] && p.age <= quickAgeRange[1]);
    
    setSearchResults(results);
    setShowResults(true);
    toast({ title: "Search Complete", description: `Found ${results.length} matching profile(s)` });
  };

  const handleAdvancedSearch = () => {
    let results = sampleProfiles;
    
    if (advGender) results = results.filter(p => p.gender === advGender);
    if (advCaste.length > 0) results = results.filter(p => advCaste.includes(p.caste));
    if (advEducation.length > 0) results = results.filter(p => advEducation.some(e => p.education.includes(e)));
    if (advOccupation.length > 0) results = results.filter(p => advOccupation.includes(p.occupation));
    if (advMaritalStatus.length > 0) results = results.filter(p => advMaritalStatus.includes(p.maritalStatus));
    if (advState) results = results.filter(p => p.state === advState);
    if (advCity) results = results.filter(p => p.city.toLowerCase().includes(advCity.toLowerCase()));
    results = results.filter(p => p.age >= advAgeRange[0] && p.age <= advAgeRange[1]);
    
    setSearchResults(results);
    setShowResults(true);
    toast({ title: "Advanced Search Complete", description: `Found ${results.length} matching profile(s)` });
  };

  const resetQuickSearch = () => {
    setProfileId("");
    setQuickGender("");
    setQuickAgeRange([21, 35]);
    setQuickCaste("");
    setShowResults(false);
  };

  const resetAdvancedSearch = () => {
    setAdvGender("");
    setAdvAgeRange([18, 45]);
    setAdvHeightRange([4.5, 6.5]);
    setAdvCaste([]);
    setAdvEducation([]);
    setAdvOccupation([]);
    setAdvIncome("");
    setAdvMaritalStatus([]);
    setAdvState("");
    setAdvCity("");
    setShowResults(false);
  };

  const toggleArrayValue = (arr: string[], value: string, setter: (v: string[]) => void) => {
    if (arr.includes(value)) {
      setter(arr.filter(v => v !== value));
    } else {
      setter([...arr, value]);
    }
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-secondary/30 via-background to-secondary/20">
      <DashboardSidebar isOpen={sidebarOpen} onClose={() => setSidebarOpen(false)} />
      
      <div className="lg:pl-64">
        <DashboardHeader onMenuClick={() => setSidebarOpen(true)} user={userData} />
        
        <main className="p-4 md:p-6 lg:p-8">
          <div className="mb-6">
            <h1 className="text-2xl md:text-3xl font-bold text-foreground">Search Profiles</h1>
            <p className="text-muted-foreground">Find your perfect match using Quick or Advanced search</p>
          </div>

          {/* Search Tabs */}
          <Tabs value={activeTab} onValueChange={setActiveTab} className="space-y-6">
            <TabsList className="grid w-full max-w-md grid-cols-2">
              <TabsTrigger value="quick" className="gap-2">
                <SearchIcon className="h-4 w-4" />
                Quick Search
              </TabsTrigger>
              <TabsTrigger value="advanced" className="gap-2">
                <SlidersHorizontal className="h-4 w-4" />
                Advanced Search
              </TabsTrigger>
            </TabsList>

            {/* Quick Search Tab */}
            <TabsContent value="quick" className="space-y-6">
              <Card>
                <CardHeader>
                  <CardTitle className="flex items-center gap-2 text-lg">
                    <SearchIcon className="h-5 w-5 text-primary" />
                    Quick Search
                  </CardTitle>
                </CardHeader>
                <CardContent className="space-y-6">
                  {/* Profile ID Search */}
                  <div className="p-4 bg-secondary/50 rounded-lg border border-border">
                    <Label className="text-sm font-medium mb-2 block">Search by Profile ID</Label>
                    <div className="flex gap-3">
                      <div className="relative flex-1">
                        <User className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                        <Input 
                          placeholder="Enter Profile ID (e.g., NX1234)" 
                          value={profileId}
                          onChange={(e) => setProfileId(e.target.value)}
                          className="pl-10"
                        />
                      </div>
                      <Button onClick={handleQuickSearch} className="bg-gradient-primary gap-2">
                        <SearchIcon className="h-4 w-4" />
                        Search
                      </Button>
                    </div>
                  </div>

                  <div className="relative">
                    <div className="absolute inset-0 flex items-center">
                      <span className="w-full border-t border-border" />
                    </div>
                    <div className="relative flex justify-center text-xs uppercase">
                      <span className="bg-card px-2 text-muted-foreground">Or search by criteria</span>
                    </div>
                  </div>

                  {/* Quick Filters */}
                  <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div className="space-y-2">
                      <Label>Looking for</Label>
                      <Select value={quickGender} onValueChange={setQuickGender}>
                        <SelectTrigger>
                          <SelectValue placeholder="Select Gender" />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="male">Groom (Male)</SelectItem>
                          <SelectItem value="female">Bride (Female)</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>

                    <div className="space-y-2">
                      <Label>Age Range: {quickAgeRange[0]} - {quickAgeRange[1]} years</Label>
                      <Slider
                        value={quickAgeRange}
                        onValueChange={setQuickAgeRange}
                        min={18}
                        max={60}
                        step={1}
                        className="mt-3"
                      />
                    </div>

                    <div className="space-y-2">
                      <Label>Caste</Label>
                      <Select value={quickCaste} onValueChange={setQuickCaste}>
                        <SelectTrigger>
                          <SelectValue placeholder="Select Caste" />
                        </SelectTrigger>
                        <SelectContent>
                          {casteOptions.map(caste => (
                            <SelectItem key={caste} value={caste}>{caste}</SelectItem>
                          ))}
                        </SelectContent>
                      </Select>
                    </div>

                    <div className="flex items-end gap-2">
                      <Button onClick={handleQuickSearch} className="flex-1 bg-gradient-primary gap-2">
                        <SearchIcon className="h-4 w-4" />
                        Search
                      </Button>
                      <Button variant="outline" size="icon" onClick={resetQuickSearch}>
                        <RotateCcw className="h-4 w-4" />
                      </Button>
                    </div>
                  </div>
                </CardContent>
              </Card>
            </TabsContent>

            {/* Advanced Search Tab */}
            <TabsContent value="advanced" className="space-y-6">
              <Card>
                <CardHeader>
                  <CardTitle className="flex items-center gap-2 text-lg">
                    <SlidersHorizontal className="h-5 w-5 text-primary" />
                    Advanced Search
                  </CardTitle>
                </CardHeader>
                <CardContent className="space-y-6">
                  {/* Basic Filters */}
                  <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div className="space-y-2">
                      <Label>Looking for</Label>
                      <Select value={advGender} onValueChange={setAdvGender}>
                        <SelectTrigger>
                          <SelectValue placeholder="Select Gender" />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="male">Groom (Male)</SelectItem>
                          <SelectItem value="female">Bride (Female)</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>

                    <div className="space-y-2">
                      <Label>Age Range: {advAgeRange[0]} - {advAgeRange[1]} years</Label>
                      <Slider
                        value={advAgeRange}
                        onValueChange={setAdvAgeRange}
                        min={18}
                        max={60}
                        step={1}
                        className="mt-3"
                      />
                    </div>

                    <div className="space-y-2">
                      <Label>Height: {advHeightRange[0].toFixed(1)} - {advHeightRange[1].toFixed(1)} ft</Label>
                      <Slider
                        value={advHeightRange}
                        onValueChange={setAdvHeightRange}
                        min={4}
                        max={7}
                        step={0.1}
                        className="mt-3"
                      />
                    </div>
                  </div>

                  {/* Marital Status */}
                  <div className="space-y-3">
                    <Label>Marital Status</Label>
                    <div className="flex flex-wrap gap-2">
                      {maritalStatusOptions.map(status => (
                        <Badge
                          key={status}
                          variant={advMaritalStatus.includes(status) ? "default" : "outline"}
                          className="cursor-pointer hover:bg-primary/80 transition-colors"
                          onClick={() => toggleArrayValue(advMaritalStatus, status, setAdvMaritalStatus)}
                        >
                          {status}
                        </Badge>
                      ))}
                    </div>
                  </div>

                  {/* Caste */}
                  <div className="space-y-3">
                    <Label>Caste</Label>
                    <div className="flex flex-wrap gap-2">
                      {casteOptions.map(caste => (
                        <Badge
                          key={caste}
                          variant={advCaste.includes(caste) ? "default" : "outline"}
                          className="cursor-pointer hover:bg-primary/80 transition-colors"
                          onClick={() => toggleArrayValue(advCaste, caste, setAdvCaste)}
                        >
                          {caste}
                        </Badge>
                      ))}
                    </div>
                  </div>

                  {/* Toggle More Filters */}
                  <Button
                    variant="ghost"
                    className="w-full justify-center gap-2 text-primary"
                    onClick={() => setAdvShowAdvancedFilters(!advShowAdvancedFilters)}
                  >
                    {advShowAdvancedFilters ? (
                      <>
                        <ChevronUp className="h-4 w-4" />
                        Show Less Filters
                      </>
                    ) : (
                      <>
                        <ChevronDown className="h-4 w-4" />
                        Show More Filters
                      </>
                    )}
                  </Button>

                  {/* Extended Filters */}
                  {advShowAdvancedFilters && (
                    <div className="space-y-6 pt-4 border-t border-border animate-fade-in">
                      {/* Education */}
                      <div className="space-y-3">
                        <Label>Education</Label>
                        <div className="flex flex-wrap gap-2">
                          {educationOptions.map(edu => (
                            <Badge
                              key={edu}
                              variant={advEducation.includes(edu) ? "default" : "outline"}
                              className="cursor-pointer hover:bg-primary/80 transition-colors"
                              onClick={() => toggleArrayValue(advEducation, edu, setAdvEducation)}
                            >
                              {edu}
                            </Badge>
                          ))}
                        </div>
                      </div>

                      {/* Occupation */}
                      <div className="space-y-3">
                        <Label>Occupation</Label>
                        <div className="flex flex-wrap gap-2">
                          {occupationOptions.map(occ => (
                            <Badge
                              key={occ}
                              variant={advOccupation.includes(occ) ? "default" : "outline"}
                              className="cursor-pointer hover:bg-primary/80 transition-colors"
                              onClick={() => toggleArrayValue(advOccupation, occ, setAdvOccupation)}
                            >
                              {occ}
                            </Badge>
                          ))}
                        </div>
                      </div>

                      {/* Income & Location */}
                      <div className="grid sm:grid-cols-3 gap-4">
                        <div className="space-y-2">
                          <Label>Annual Income</Label>
                          <Select value={advIncome} onValueChange={setAdvIncome}>
                            <SelectTrigger>
                              <SelectValue placeholder="Select Income" />
                            </SelectTrigger>
                            <SelectContent>
                              {incomeOptions.map(inc => (
                                <SelectItem key={inc} value={inc}>{inc}</SelectItem>
                              ))}
                            </SelectContent>
                          </Select>
                        </div>

                        <div className="space-y-2">
                          <Label>State</Label>
                          <Select value={advState} onValueChange={setAdvState}>
                            <SelectTrigger>
                              <SelectValue placeholder="Select State" />
                            </SelectTrigger>
                            <SelectContent>
                              {stateOptions.map(st => (
                                <SelectItem key={st} value={st}>{st}</SelectItem>
                              ))}
                            </SelectContent>
                          </Select>
                        </div>

                        <div className="space-y-2">
                          <Label>City</Label>
                          <Input 
                            placeholder="Enter city name" 
                            value={advCity}
                            onChange={(e) => setAdvCity(e.target.value)}
                          />
                        </div>
                      </div>
                    </div>
                  )}

                  {/* Action Buttons */}
                  <div className="flex gap-3 pt-4">
                    <Button onClick={handleAdvancedSearch} className="flex-1 bg-gradient-primary gap-2">
                      <SearchIcon className="h-4 w-4" />
                      Search Profiles
                    </Button>
                    <Button variant="outline" onClick={resetAdvancedSearch} className="gap-2">
                      <RotateCcw className="h-4 w-4" />
                      Reset
                    </Button>
                  </div>
                </CardContent>
              </Card>
            </TabsContent>
          </Tabs>

          {/* Search Results */}
          {showResults && (
            <div className="mt-8 space-y-4">
              <div className="flex items-center justify-between">
                <h2 className="text-xl font-semibold text-foreground">
                  Search Results ({searchResults.length})
                </h2>
                <Button variant="ghost" size="sm" onClick={() => setShowResults(false)}>
                  Clear Results
                </Button>
              </div>

              {searchResults.length > 0 ? (
                <div className="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                  {searchResults.map((profile) => (
                    <Card key={profile.id} className="overflow-hidden hover:shadow-lg transition-all hover:-translate-y-1">
                      <div className="relative aspect-[3/4]">
                        <img
                          src={profile.gender === "female" ? defaultFemale : defaultMale}
                          alt={profile.name}
                          className="w-full h-full object-cover object-top"
                        />
                        <Badge className="absolute top-3 left-3 bg-primary text-primary-foreground">
                          {profile.caste}
                        </Badge>
                      </div>
                      <CardContent className="p-4">
                        <div className="flex items-start justify-between mb-2">
                          <div>
                            <h3 className="font-semibold text-foreground">{profile.name}</h3>
                            <p className="text-xs text-primary">{profile.id}</p>
                          </div>
                          <Button size="icon" variant="ghost" className="h-8 w-8 text-rose-500 hover:text-rose-600">
                            <Heart className="h-4 w-4" />
                          </Button>
                        </div>
                        
                        <div className="space-y-1 text-sm text-muted-foreground mb-3">
                          <p className="font-medium text-foreground">
                            {profile.age} yrs, {profile.height}
                          </p>
                          <p className="flex items-center gap-1.5 text-xs">
                            <MapPin className="h-3 w-3" /> {profile.city}, {profile.state}
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
                            <Heart className="h-3.5 w-3.5" />
                            Interest
                          </Button>
                        </div>
                      </CardContent>
                    </Card>
                  ))}
                </div>
              ) : (
                <Card className="p-8 text-center">
                  <SearchIcon className="h-12 w-12 mx-auto text-muted-foreground mb-4" />
                  <h3 className="text-lg font-semibold text-foreground mb-2">No Profiles Found</h3>
                  <p className="text-muted-foreground">Try adjusting your search criteria</p>
                </Card>
              )}
            </div>
          )}
        </main>
      </div>
    </div>
  );
};

export default Search;
