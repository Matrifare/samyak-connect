import { useState } from "react";
import { Link } from "react-router-dom";
import { Search, Filter, Grid, List, Eye, MapPin, Briefcase, GraduationCap, Crown, BadgeCheck, Heart } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Badge } from "@/components/ui/badge";
import Header from "@/components/matrimony/Header";
import Footer from "@/components/matrimony/Footer";
import ProfileActions from "@/components/profile/ProfileActions";
import defaultMale from "@/assets/default-male.jpg";
import defaultFemale from "@/assets/default-female.jpg";

// Dummy profile data - 48 profiles total for pagination demo
const allProfiles = [
  { id: "NX1234", name: "Priya Sharma", age: 26, height: "5ft 4in", religion: "Buddhist", caste: "Mahar", education: "MBA", occupation: "Software Engineer", city: "Mumbai", gender: "female", verified: true, premium: true, lastOnline: "Online now", about: "I am a career-oriented individual who believes in balancing work and personal life. I enjoy reading, traveling, and exploring new cuisines. Looking for a life partner who shares similar values and has a positive outlook towards life." },
  { id: "NX1235", name: "Rahul More", age: 29, height: "5ft 10in", religion: "Buddhist", caste: "Nav Bauddha", education: "B.Tech", occupation: "Civil Engineer", city: "Pune", gender: "male", verified: true, premium: false, lastOnline: "2 hours ago", about: "A simple person with traditional values. I believe in hard work and dedication. Looking for a kind-hearted partner who values family and relationships." },
  { id: "NX1236", name: "Sneha Kamble", age: 24, height: "5ft 2in", religion: "Buddhist", caste: "Bauddha", education: "B.Com", occupation: "Bank Employee", city: "Nagpur", gender: "female", verified: false, premium: false, lastOnline: "1 day ago", about: "Fun-loving and optimistic person. I enjoy music, dancing, and spending time with family. Seeking a partner who is caring, understanding, and has a good sense of humor." },
  { id: "AR2001", name: "Amit Pawar", age: 31, height: "5ft 8in", religion: "Buddhist", caste: "Mahar", education: "M.Sc", occupation: "Government Officer", city: "Delhi", gender: "male", verified: true, premium: true, lastOnline: "Online now", about: "I am a government officer with a stable career. I value honesty, integrity, and respect in relationships. Looking for a life partner who is educated and family-oriented." },
  { id: "NX1237", name: "Pooja Gaikwad", age: 25, height: "5ft 3in", religion: "Buddhist", caste: "Mahar", education: "B.Tech", occupation: "IT Professional", city: "Pune", gender: "female", verified: true, premium: false, lastOnline: "3 hours ago", about: "Tech enthusiast with a passion for learning. I love traveling and photography. Looking for someone who is ambitious, caring, and has a positive approach to life." },
  { id: "AR2002", name: "Vikram Sonawane", age: 28, height: "5ft 9in", religion: "Buddhist", caste: "Bauddha", education: "CA", occupation: "Chartered Accountant", city: "Mumbai", gender: "male", verified: true, premium: true, lastOnline: "5 hours ago", about: "I am a Chartered Accountant working in Mumbai. I enjoy sports, movies, and traveling. Seeking a partner who is understanding, supportive, and shares similar interests." },
  { id: "NX1238", name: "Anjali Jadhav", age: 23, height: "5ft 5in", religion: "Buddhist", caste: "Nav Bauddha", education: "BBA", occupation: "Marketing Executive", city: "Thane", gender: "female", verified: true, premium: false, lastOnline: "1 hour ago", about: "Creative and ambitious professional. I believe in living life to the fullest. Looking for a partner who is honest, caring, and has a good sense of humor." },
  { id: "AR2003", name: "Suresh Bansode", age: 30, height: "5ft 11in", religion: "Buddhist", caste: "Mahar", education: "M.Tech", occupation: "Senior Developer", city: "Bangalore", gender: "male", verified: false, premium: false, lastOnline: "2 days ago", about: "Software professional based in Bangalore. I enjoy coding, reading books, and exploring new technologies. Looking for a partner who is intelligent and understanding." },
  { id: "NX1239", name: "Kavita Shinde", age: 27, height: "5ft 4in", religion: "Buddhist", caste: "Bauddha", education: "MBBS", occupation: "Doctor", city: "Aurangabad", gender: "female", verified: true, premium: true, lastOnline: "Online now", about: "I am a doctor who loves serving people. I value education, respect, and compassion. Looking for a supportive partner who understands the demands of my profession." },
  { id: "AR2004", name: "Rajesh Waghmare", age: 32, height: "5ft 10in", religion: "Buddhist", caste: "Mahar", education: "LLB", occupation: "Advocate", city: "Nashik", gender: "male", verified: true, premium: false, lastOnline: "4 hours ago", about: "Practicing advocate with a passion for justice. I believe in equality and fairness. Looking for a partner who is educated, independent, and family-oriented." },
  { id: "NX1240", name: "Meera Salve", age: 26, height: "5ft 6in", religion: "Buddhist", caste: "Nav Bauddha", education: "M.Com", occupation: "Accountant", city: "Kolhapur", gender: "female", verified: false, premium: false, lastOnline: "6 hours ago", about: "I am a simple and down-to-earth person. I enjoy cooking, gardening, and spending time with family. Looking for a caring and understanding life partner." },
  { id: "AR2005", name: "Nitin Ahire", age: 29, height: "5ft 8in", religion: "Buddhist", caste: "Bauddha", education: "BE", occupation: "Mechanical Engineer", city: "Solapur", gender: "male", verified: true, premium: true, lastOnline: "30 mins ago", about: "Engineer by profession, artist by passion. I love sketching and playing guitar. Looking for someone who appreciates creativity and has a kind heart." },
  { id: "NX1241", name: "Rekha Ghodke", age: 24, height: "5ft 3in", religion: "Buddhist", caste: "Mahar", education: "BDS", occupation: "Dentist", city: "Mumbai", gender: "female", verified: true, premium: false, lastOnline: "Online now", about: "Dental professional with a cheerful personality. I enjoy music, dancing, and traveling. Seeking a partner who is caring, ambitious, and has a positive outlook." },
  { id: "AR2006", name: "Sachin Kale", age: 27, height: "5ft 7in", religion: "Buddhist", caste: "Nav Bauddha", education: "MBA", occupation: "Business Analyst", city: "Pune", gender: "male", verified: true, premium: false, lastOnline: "1 day ago", about: "Business analyst working in IT sector. I enjoy trekking, reading, and exploring new places. Looking for an understanding and supportive life partner." },
  { id: "NX1242", name: "Sunita Wankhede", age: 28, height: "5ft 5in", religion: "Buddhist", caste: "Bauddha", education: "B.Sc", occupation: "Teacher", city: "Nagpur", gender: "female", verified: false, premium: true, lastOnline: "8 hours ago", about: "I am a teacher who loves shaping young minds. I value education and family traditions. Looking for a partner who respects relationships and is family-oriented." },
  { id: "AR2007", name: "Deepak Meshram", age: 33, height: "6ft 0in", religion: "Buddhist", caste: "Mahar", education: "PhD", occupation: "Professor", city: "Delhi", gender: "male", verified: true, premium: true, lastOnline: "2 hours ago", about: "Academic professional with a passion for research. I enjoy reading, writing, and intellectual discussions. Seeking a partner who values education and knowledge." },
  { id: "NX1243", name: "Swati Bhalerao", age: 25, height: "5ft 4in", religion: "Buddhist", caste: "Mahar", education: "B.Pharm", occupation: "Pharmacist", city: "Satara", gender: "female", verified: true, premium: false, lastOnline: "5 hours ago", about: "Healthcare professional with a caring nature. I enjoy yoga, reading, and spending time in nature. Looking for a partner who is honest and supportive." },
  { id: "AR2008", name: "Anil Dongre", age: 30, height: "5ft 9in", religion: "Buddhist", caste: "Nav Bauddha", education: "B.Tech", occupation: "Project Manager", city: "Hyderabad", gender: "male", verified: true, premium: false, lastOnline: "3 hours ago", about: "IT professional managing global projects. I enjoy traveling, photography, and fitness. Looking for a partner who is ambitious and understanding." },
  { id: "NX1244", name: "Rashmi Kharat", age: 22, height: "5ft 2in", religion: "Buddhist", caste: "Bauddha", education: "B.Ed", occupation: "Primary Teacher", city: "Jalgaon", gender: "female", verified: false, premium: false, lastOnline: "1 week ago", about: "Young and enthusiastic teacher. I love children and enjoy creative activities. Looking for a caring partner with good family values." },
  { id: "AR2009", name: "Prakash Sarode", age: 28, height: "5ft 11in", religion: "Buddhist", caste: "Mahar", education: "MCA", occupation: "Software Developer", city: "Chennai", gender: "male", verified: true, premium: true, lastOnline: "Online now", about: "Software developer with a creative mind. I enjoy gaming, music, and exploring new technologies. Seeking a partner who is understanding and supportive." },
  { id: "NX1245", name: "Ashwini Bhosale", age: 26, height: "5ft 5in", religion: "Buddhist", caste: "Nav Bauddha", education: "MBA", occupation: "HR Manager", city: "Mumbai", gender: "female", verified: true, premium: true, lastOnline: "45 mins ago", about: "HR professional who loves connecting with people. I enjoy traveling, reading, and fitness. Looking for a partner who is ambitious and family-oriented." },
  { id: "AR2010", name: "Ganesh Thorat", age: 31, height: "5ft 8in", religion: "Buddhist", caste: "Bauddha", education: "B.Com", occupation: "Bank Manager", city: "Pune", gender: "male", verified: true, premium: false, lastOnline: "7 hours ago", about: "Banking professional with stable career. I believe in traditional values and respect for elders. Looking for a partner who is educated and caring." },
  { id: "NX1246", name: "Pallavi Ingole", age: 24, height: "5ft 3in", religion: "Buddhist", caste: "Mahar", education: "BCA", occupation: "Web Designer", city: "Amravati", gender: "female", verified: false, premium: false, lastOnline: "2 days ago", about: "Creative web designer with an artistic eye. I enjoy painting, music, and exploring new design trends. Seeking a partner who appreciates creativity." },
  { id: "AR2011", name: "Mahesh Gawande", age: 29, height: "5ft 10in", religion: "Buddhist", caste: "Mahar", education: "B.Arch", occupation: "Architect", city: "Nagpur", gender: "male", verified: true, premium: true, lastOnline: "1 hour ago", about: "Architect with a passion for sustainable design. I enjoy traveling, sketching, and photography. Looking for a partner who shares my creative vision." },
  { id: "NX1247", name: "Nisha Lanjewar", age: 27, height: "5ft 6in", religion: "Buddhist", caste: "Nav Bauddha", education: "M.Sc", occupation: "Research Scientist", city: "Bangalore", gender: "female", verified: true, premium: false, lastOnline: "4 hours ago", about: "Research scientist passionate about discovery. I enjoy reading, hiking, and intellectual conversations. Seeking a partner who values education and curiosity." },
  { id: "AR2012", name: "Tushar Bawane", age: 26, height: "5ft 7in", religion: "Buddhist", caste: "Bauddha", education: "BBA", occupation: "Sales Manager", city: "Indore", gender: "male", verified: false, premium: false, lastOnline: "3 days ago", about: "Sales professional with excellent communication skills. I enjoy traveling, networking, and outdoor activities. Looking for a supportive and understanding partner." },
  { id: "NX1248", name: "Jyoti Gade", age: 25, height: "5ft 4in", religion: "Buddhist", caste: "Mahar", education: "B.Tech", occupation: "Data Analyst", city: "Hyderabad", gender: "female", verified: true, premium: true, lastOnline: "Online now", about: "Data analyst with a logical mind. I enjoy puzzles, reading, and learning new skills. Looking for a partner who is intelligent and has a positive attitude." },
  { id: "AR2013", name: "Vishal Giri", age: 32, height: "6ft 1in", religion: "Buddhist", caste: "Nav Bauddha", education: "MD", occupation: "Physician", city: "Mumbai", gender: "male", verified: true, premium: true, lastOnline: "2 hours ago", about: "Medical professional dedicated to patient care. I value compassion and empathy. Seeking a partner who understands the medical profession and is supportive." },
  { id: "NX1249", name: "Rutuja Khandare", age: 23, height: "5ft 3in", religion: "Buddhist", caste: "Bauddha", education: "B.Com", occupation: "Finance Executive", city: "Pune", gender: "female", verified: true, premium: false, lastOnline: "6 hours ago", about: "Finance professional with a keen eye for detail. I enjoy movies, music, and spending time with friends. Looking for an honest and caring partner." },
  { id: "AR2014", name: "Santosh Bagde", age: 30, height: "5ft 9in", religion: "Buddhist", caste: "Mahar", education: "B.E", occupation: "Civil Contractor", city: "Nashik", gender: "male", verified: false, premium: false, lastOnline: "1 day ago", about: "Self-employed civil contractor with entrepreneurial spirit. I enjoy building things and solving problems. Looking for a supportive and understanding life partner." },
  { id: "NX1250", name: "Dipali Chavhan", age: 28, height: "5ft 5in", religion: "Buddhist", caste: "Mahar", education: "MDS", occupation: "Orthodontist", city: "Aurangabad", gender: "female", verified: true, premium: true, lastOnline: "30 mins ago", about: "Specialist orthodontist with a passion for perfect smiles. I enjoy traveling, yoga, and healthy living. Seeking a partner who values health and wellness." },
  { id: "AR2015", name: "Rohit Bhagat", age: 27, height: "5ft 8in", religion: "Buddhist", caste: "Nav Bauddha", education: "CA", occupation: "Tax Consultant", city: "Delhi", gender: "male", verified: true, premium: false, lastOnline: "5 hours ago", about: "Tax consultant helping businesses grow. I enjoy cricket, movies, and spending time with family. Looking for a partner who is caring and family-oriented." },
  { id: "NX1251", name: "Manisha Lokhande", age: 26, height: "5ft 4in", religion: "Buddhist", caste: "Bauddha", education: "LLB", occupation: "Corporate Lawyer", city: "Mumbai", gender: "female", verified: true, premium: false, lastOnline: "8 hours ago", about: "Corporate lawyer with a passion for justice. I enjoy reading, debating, and exploring new cultures. Seeking an intelligent and understanding partner." },
  { id: "AR2016", name: "Akash Dhawale", age: 29, height: "5ft 11in", religion: "Buddhist", caste: "Mahar", education: "M.Tech", occupation: "AI Engineer", city: "Bangalore", gender: "male", verified: true, premium: true, lastOnline: "Online now", about: "AI engineer working on cutting-edge technology. I enjoy learning, gaming, and fitness. Looking for a partner who is ambitious and shares my curiosity." },
  { id: "NX1252", name: "Komal Thakur", age: 24, height: "5ft 2in", religion: "Buddhist", caste: "Nav Bauddha", education: "B.Sc Nursing", occupation: "Staff Nurse", city: "Thane", gender: "female", verified: false, premium: false, lastOnline: "2 days ago", about: "Caring nurse dedicated to patient care. I enjoy cooking, reading, and spending time with family. Looking for a supportive and understanding life partner." },
  { id: "AR2017", name: "Yogesh Bawane", age: 31, height: "5ft 10in", religion: "Buddhist", caste: "Bauddha", education: "MBA", occupation: "Operations Manager", city: "Chennai", gender: "male", verified: true, premium: false, lastOnline: "3 hours ago", about: "Operations manager with leadership skills. I enjoy sports, traveling, and team activities. Seeking a partner who is ambitious and understanding." },
  { id: "NX1253", name: "Shweta Ramteke", age: 25, height: "5ft 5in", religion: "Buddhist", caste: "Mahar", education: "BDS", occupation: "Dental Surgeon", city: "Nagpur", gender: "female", verified: true, premium: true, lastOnline: "1 hour ago", about: "Dental surgeon with a caring approach. I enjoy music, dancing, and creative activities. Looking for a partner who is honest and has a good sense of humor." },
  { id: "AR2018", name: "Kiran Ghuge", age: 28, height: "5ft 7in", religion: "Buddhist", caste: "Mahar", education: "B.Com", occupation: "Entrepreneur", city: "Pune", gender: "male", verified: true, premium: true, lastOnline: "45 mins ago", about: "Entrepreneur with multiple business ventures. I enjoy networking, traveling, and exploring new opportunities. Seeking a supportive and ambitious partner." },
  { id: "NX1254", name: "Archana Wasnik", age: 27, height: "5ft 4in", religion: "Buddhist", caste: "Nav Bauddha", education: "M.Pharm", occupation: "Clinical Researcher", city: "Hyderabad", gender: "female", verified: true, premium: false, lastOnline: "4 hours ago", about: "Clinical researcher contributing to medical science. I enjoy reading, yoga, and healthy living. Looking for a partner who values education and wellness." },
  { id: "AR2019", name: "Sagar Gawai", age: 26, height: "5ft 9in", religion: "Buddhist", caste: "Bauddha", education: "BCA", occupation: "System Administrator", city: "Mumbai", gender: "male", verified: false, premium: false, lastOnline: "1 week ago", about: "IT professional managing system infrastructure. I enjoy gaming, movies, and technology. Looking for an understanding and caring partner." },
  { id: "NX1255", name: "Vaishali Bhoyar", age: 29, height: "5ft 6in", religion: "Buddhist", caste: "Mahar", education: "PhD", occupation: "Associate Professor", city: "Delhi", gender: "female", verified: true, premium: true, lastOnline: "2 hours ago", about: "Academic professional passionate about teaching. I enjoy research, writing, and intellectual discussions. Seeking a partner who values education and growth." },
  { id: "AR2020", name: "Nilesh Sakhare", age: 33, height: "6ft 0in", religion: "Buddhist", caste: "Nav Bauddha", education: "MS", occupation: "Cloud Architect", city: "Bangalore", gender: "male", verified: true, premium: true, lastOnline: "Online now", about: "Cloud architect designing enterprise solutions. I enjoy technology, traveling, and fitness. Looking for an ambitious and supportive life partner." },
  { id: "NX1256", name: "Shruti Mendhe", age: 23, height: "5ft 3in", religion: "Buddhist", caste: "Bauddha", education: "B.Tech", occupation: "UX Designer", city: "Pune", gender: "female", verified: true, premium: false, lastOnline: "6 hours ago", about: "UX designer creating user-friendly experiences. I enjoy art, music, and exploring new design trends. Seeking a creative and understanding partner." },
  { id: "AR2021", name: "Prashant Lokhande", age: 30, height: "5ft 8in", religion: "Buddhist", caste: "Mahar", education: "MBA", occupation: "Product Manager", city: "Mumbai", gender: "male", verified: true, premium: false, lastOnline: "5 hours ago", about: "Product manager building innovative solutions. I enjoy strategy games, reading, and fitness. Looking for an ambitious and caring partner." },
  { id: "NX1257", name: "Bhagyashree Khobragade", age: 26, height: "5ft 5in", religion: "Buddhist", caste: "Mahar", education: "MBBS", occupation: "Resident Doctor", city: "Nagpur", gender: "female", verified: true, premium: true, lastOnline: "30 mins ago", about: "Medical resident committed to patient care. I value compassion and dedication. Seeking a partner who understands the medical profession and is supportive." },
  { id: "AR2022", name: "Vivek Kamble", age: 28, height: "5ft 10in", religion: "Buddhist", caste: "Nav Bauddha", education: "B.E", occupation: "Electrical Engineer", city: "Kolhapur", gender: "male", verified: false, premium: false, lastOnline: "2 days ago", about: "Electrical engineer working on power systems. I enjoy trekking, photography, and outdoor activities. Looking for an adventurous and caring partner." },
  { id: "NX1258", name: "Pranita Gawande", age: 24, height: "5ft 4in", religion: "Buddhist", caste: "Bauddha", education: "M.Com", occupation: "Financial Analyst", city: "Thane", gender: "female", verified: true, premium: false, lastOnline: "3 hours ago", about: "Financial analyst with attention to detail. I enjoy movies, traveling, and spending time with friends. Looking for an honest and supportive partner." },
  { id: "AR2023", name: "Omkar Meshram", age: 27, height: "5ft 9in", religion: "Buddhist", caste: "Mahar", education: "MCA", occupation: "Full Stack Developer", city: "Hyderabad", gender: "male", verified: true, premium: true, lastOnline: "1 hour ago", about: "Full stack developer passionate about coding. I enjoy learning new technologies, gaming, and music. Seeking a partner who appreciates creativity and growth." },
];

const PROFILES_PER_PAGE = 12;

const SearchResults = () => {
  const [viewType, setViewType] = useState<"grid" | "list">("grid");
  const [showFilters, setShowFilters] = useState(false);
  const [currentPage, setCurrentPage] = useState(1);

  const totalPages = Math.ceil(allProfiles.length / PROFILES_PER_PAGE);
  const startIndex = (currentPage - 1) * PROFILES_PER_PAGE;
  const currentProfiles = allProfiles.slice(startIndex, startIndex + PROFILES_PER_PAGE);

  const handlePageChange = (page: number) => {
    setCurrentPage(page);
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  return (
    <div className="min-h-screen bg-gradient-to-b from-secondary/30 to-background">
      <Header />
      
      <main className="pt-24 pb-16">
        <div className="container mx-auto px-4">
          {/* Search Header */}
          <div className="bg-card rounded-xl shadow-lg p-6 mb-6 border border-border">
            <div className="flex flex-col lg:flex-row gap-4 items-center justify-between">
              <div className="flex items-center gap-4 w-full lg:w-auto">
                <div className="relative flex-1 lg:w-80">
                  <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-muted-foreground" />
                  <Input placeholder="Search by Profile ID" className="pl-10" />
                </div>
                <Button
                  variant="outline"
                  className="gap-2"
                  onClick={() => setShowFilters(!showFilters)}
                >
                  <Filter className="h-4 w-4" />
                  Filters
                </Button>
              </div>

              <div className="flex items-center gap-4">
                <span className="text-muted-foreground text-sm">
                  Found <strong className="text-primary">{allProfiles.length}</strong> profiles
                </span>
                <div className="flex gap-1 border rounded-lg p-1">
                  <Button
                    size="sm"
                    variant={viewType === "grid" ? "default" : "ghost"}
                    onClick={() => setViewType("grid")}
                  >
                    <Grid className="h-4 w-4" />
                  </Button>
                  <Button
                    size="sm"
                    variant={viewType === "list" ? "default" : "ghost"}
                    onClick={() => setViewType("list")}
                  >
                    <List className="h-4 w-4" />
                  </Button>
                </div>
              </div>
            </div>

            {/* Filters Panel */}
            {showFilters && (
              <div className="mt-6 pt-6 border-t border-border animate-fade-in">
                <div className="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                  <Select>
                    <SelectTrigger>
                      <SelectValue placeholder="Gender" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="male">Male</SelectItem>
                      <SelectItem value="female">Female</SelectItem>
                    </SelectContent>
                  </Select>

                  <Select>
                    <SelectTrigger>
                      <SelectValue placeholder="Age" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="21-25">21-25 years</SelectItem>
                      <SelectItem value="26-30">26-30 years</SelectItem>
                      <SelectItem value="31-35">31-35 years</SelectItem>
                    </SelectContent>
                  </Select>

                  <Select>
                    <SelectTrigger>
                      <SelectValue placeholder="Religion" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="buddhist">Buddhist</SelectItem>
                      <SelectItem value="hindu">Hindu</SelectItem>
                    </SelectContent>
                  </Select>

                  <Select>
                    <SelectTrigger>
                      <SelectValue placeholder="City" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="mumbai">Mumbai</SelectItem>
                      <SelectItem value="pune">Pune</SelectItem>
                      <SelectItem value="delhi">Delhi</SelectItem>
                    </SelectContent>
                  </Select>

                  <Select>
                    <SelectTrigger>
                      <SelectValue placeholder="Education" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="graduate">Graduate</SelectItem>
                      <SelectItem value="postgraduate">Post Graduate</SelectItem>
                    </SelectContent>
                  </Select>

                  <Button className="bg-gradient-primary">Apply Filters</Button>
                </div>
              </div>
            )}
          </div>

          {/* Results Grid/List with About Us Sidebar for List View on Desktop */}
          <div className={viewType === "list" ? "flex gap-6" : ""}>
            <div
              className={
                viewType === "grid"
                  ? "grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6"
                  : "flex flex-col gap-4 flex-1"
              }
            >
            {currentProfiles.map((profile) => (
              <div
                key={profile.id}
                className={`bg-card rounded-xl shadow-lg border border-border overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 ${
                  viewType === "list" ? "flex flex-row" : "flex flex-col"
                }`}
              >
                {/* Profile Image */}
                <div className={`relative ${viewType === "list" ? "w-36 sm:w-44 md:w-48 flex-shrink-0 self-stretch" : "aspect-[3/4]"}`}>
                  <img
                    src={profile.gender === "female" ? defaultFemale : defaultMale}
                    alt={profile.name}
                    className={`w-full h-full object-cover object-top ${viewType === "list" ? "absolute inset-0" : ""}`}
                  />
                  {/* Status Icons */}
                  <div className={`absolute ${viewType === "list" ? "top-2 left-2" : "top-3 left-3"} flex gap-1.5`}>
                    {profile.premium && (
                      <div className="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-gradient-to-r from-amber-500 to-orange-500 flex items-center justify-center shadow-md" title="Premium Member">
                        <Crown className="h-3 w-3 sm:h-3.5 sm:w-3.5 text-white" />
                      </div>
                    )}
                    {profile.verified && (
                      <div className="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-green-500 flex items-center justify-center shadow-md" title="Verified Profile">
                        <BadgeCheck className="h-3 w-3 sm:h-3.5 sm:w-3.5 text-white" />
                      </div>
                    )}
                  </div>
                  <div className="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-2 sm:p-3">
                    <span className="text-white text-xs font-medium">{profile.lastOnline}</span>
                  </div>
                </div>

                {/* Profile Info */}
                <div className={`p-3 sm:p-4 flex flex-col ${viewType === "list" ? "min-w-0 w-52 lg:w-56 flex-shrink-0" : "flex-1"}`}>
                  <div className="mb-2">
                    <h3 className="font-semibold text-sm sm:text-base text-foreground line-clamp-1">{profile.name}</h3>
                    <p className="text-xs text-primary font-medium">{profile.id}</p>
                  </div>

                  <div className={`space-y-1 text-sm text-muted-foreground mb-2 sm:mb-3 flex-1 ${viewType === "list" ? "text-xs sm:text-sm" : ""}`}>
                    <p className="font-medium text-foreground text-xs sm:text-sm">
                      {profile.age} yrs, {profile.height}
                    </p>
                    <p className="flex items-center gap-1 sm:gap-1.5 text-xs">
                      <MapPin className="h-3 w-3 sm:h-3.5 sm:w-3.5 flex-shrink-0" />
                      <span className="truncate">{profile.city}</span>
                    </p>
                    <p className="flex items-center gap-1 sm:gap-1.5 text-xs">
                      <GraduationCap className="h-3 w-3 sm:h-3.5 sm:w-3.5 flex-shrink-0" />
                      <span className="truncate">{profile.education}</span>
                    </p>
                    <p className="flex items-center gap-1 sm:gap-1.5 text-xs">
                      <Briefcase className="h-3 w-3 sm:h-3.5 sm:w-3.5 flex-shrink-0" />
                      <span className="truncate">{profile.occupation}</span>
                    </p>
                    <p className="text-xs text-muted-foreground/80 truncate">
                      {profile.religion} • {profile.caste}
                    </p>
                  </div>

                  {/* Profile Actions */}
                  <div className="border-t pt-2 sm:pt-3 mt-auto">
                    <ProfileActions profileId={profile.id} variant="card" className="justify-start" />
                    <Link to={`/profile/${profile.id}`} className="block mt-2">
                      <Button size="sm" variant="outline" className="w-full gap-1 text-xs h-8 sm:h-9">
                        <Eye className="h-3 w-3 sm:h-3.5 sm:w-3.5" />
                        View Full Profile
                      </Button>
                    </Link>
                  </div>
                </div>

                {/* About Me Section - Only visible on desktop in list view */}
                {viewType === "list" && (
                  <div className="hidden lg:flex flex-col p-4 border-l border-border flex-1 bg-muted/20">
                    <h4 className="text-sm font-semibold text-foreground mb-2">About Me</h4>
                    <p className="text-xs text-muted-foreground leading-relaxed line-clamp-5">
                      {profile.about}
                    </p>
                  </div>
                )}
              </div>
            ))}
            </div>

            {/* About Us Sidebar - Only visible on desktop in list view */}
            {viewType === "list" && (
              <div className="hidden lg:block w-72 flex-shrink-0">
                <div className="bg-card rounded-xl shadow-lg border border-border p-5 sticky top-28">
                  <h3 className="text-lg font-semibold text-foreground mb-4">About Samyak Matrimony</h3>
                  <div className="space-y-3 text-sm text-muted-foreground">
                    <p>
                      A trusted matrimonial service dedicated to helping Buddhist community members find their life partners.
                    </p>
                    <p>
                      With over 15 years of experience, we have successfully connected thousands of couples across India.
                    </p>
                    <div className="border-t pt-3 mt-3">
                      <h4 className="font-medium text-foreground mb-2 text-sm">Why Choose Us?</h4>
                      <ul className="space-y-1 text-xs list-disc list-inside">
                        <li>Verified Profiles</li>
                        <li>Privacy Protected</li>
                        <li>Dedicated Support</li>
                        <li>Trusted Community</li>
                      </ul>
                    </div>
                    <div className="border-t pt-3 mt-3">
                      <h4 className="font-medium text-foreground mb-2 text-sm">Contact Us</h4>
                      <p className="text-xs">📞 +91 98765 43210</p>
                      <p className="text-xs">📧 info@samyakmatrimony.com</p>
                    </div>
                  </div>
                </div>
              </div>
            )}
          </div>

          {/* Pagination */}
          <div className="flex justify-center mt-8">
            <div className="flex flex-wrap gap-2 justify-center">
              <Button 
                variant="outline" 
                disabled={currentPage === 1}
                onClick={() => handlePageChange(currentPage - 1)}
              >
                Previous
              </Button>
              {Array.from({ length: totalPages }, (_, i) => i + 1).map((page) => (
                <Button
                  key={page}
                  variant={currentPage === page ? "default" : "outline"}
                  className={currentPage === page ? "bg-gradient-primary" : ""}
                  onClick={() => handlePageChange(page)}
                >
                  {page}
                </Button>
              ))}
              <Button 
                variant="outline"
                disabled={currentPage === totalPages}
                onClick={() => handlePageChange(currentPage + 1)}
              >
                Next
              </Button>
            </div>
          </div>
          
          {/* Page Info */}
          <p className="text-center text-sm text-muted-foreground mt-4">
            Showing {startIndex + 1}-{Math.min(startIndex + PROFILES_PER_PAGE, allProfiles.length)} of {allProfiles.length} profiles
          </p>
        </div>
      </main>

      <Footer />
    </div>
  );
};

export default SearchResults;
