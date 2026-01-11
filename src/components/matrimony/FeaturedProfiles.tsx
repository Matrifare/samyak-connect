import { MapPin, Briefcase, GraduationCap, Heart } from "lucide-react";
import { Button } from "@/components/ui/button";
import defaultMale from "@/assets/default-male.jpg";
import defaultFemale from "@/assets/default-female.jpg";

const profiles = [
  {
    id: 1,
    name: "Priya Ambedkar",
    age: 26,
    height: "5'4\"",
    education: "MBA",
    occupation: "Software Engineer",
    location: "Mumbai, Maharashtra",
    caste: "Buddhist - Mahar",
    image: defaultFemale,
    gender: "female"
  },
  {
    id: 2,
    name: "Rahul Gaikwad",
    age: 29,
    height: "5'10\"",
    education: "B.Tech",
    occupation: "Civil Engineer",
    location: "Pune, Maharashtra",
    caste: "Buddhist - Mahar",
    image: defaultMale,
    gender: "male"
  },
  {
    id: 3,
    name: "Sneha Kamble",
    age: 24,
    height: "5'3\"",
    education: "MBBS",
    occupation: "Doctor",
    location: "Nagpur, Maharashtra",
    caste: "Buddhist - Chambhar",
    image: defaultFemale,
    gender: "female"
  },
  {
    id: 4,
    name: "Amit Wankhede",
    age: 31,
    height: "5'11\"",
    education: "M.Tech",
    occupation: "Data Scientist",
    location: "Bangalore, Karnataka",
    caste: "Buddhist - Mahar",
    image: defaultMale,
    gender: "male"
  },
];

const FeaturedProfiles = () => {
  return (
    <section className="py-20">
      <div className="container mx-auto px-4">
        <div className="text-center mb-12">
          <h2 className="text-3xl md:text-4xl font-serif font-bold gradient-text mb-4">
            Featured Profiles
          </h2>
          <p className="text-muted-foreground max-w-2xl mx-auto">
            Meet some of our verified members looking for their life partner
          </p>
        </div>
        
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {profiles.map((profile, index) => (
            <div
              key={profile.id}
              className="glass rounded-2xl overflow-hidden hover-lift animate-fade-up group"
              style={{ animationDelay: `${index * 0.1}s` }}
            >
              <div className="relative aspect-[3/4] overflow-hidden">
                <img
                  src={profile.image}
                  alt={profile.name}
                  className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent" />
                <div className="absolute bottom-4 left-4 right-4 text-white">
                  <h3 className="text-xl font-serif font-bold">{profile.name}</h3>
                  <p className="text-white/80 text-sm">{profile.age} yrs, {profile.height}</p>
                </div>
              </div>
              
              <div className="p-4 space-y-3">
                <div className="flex items-center gap-2 text-sm text-muted-foreground">
                  <GraduationCap className="h-4 w-4 text-primary" />
                  <span>{profile.education}</span>
                </div>
                <div className="flex items-center gap-2 text-sm text-muted-foreground">
                  <Briefcase className="h-4 w-4 text-primary" />
                  <span>{profile.occupation}</span>
                </div>
                <div className="flex items-center gap-2 text-sm text-muted-foreground">
                  <MapPin className="h-4 w-4 text-primary" />
                  <span>{profile.location}</span>
                </div>
                
                <Button className="w-full bg-gradient-primary hover:opacity-90 gap-2 mt-4">
                  <Heart className="h-4 w-4" />
                  Send Interest
                </Button>
              </div>
            </div>
          ))}
        </div>
        
        <div className="text-center mt-12">
          <Button variant="outline" size="lg" className="border-primary text-primary hover:bg-primary hover:text-white">
            View All Profiles
          </Button>
        </div>
      </div>
    </section>
  );
};

export default FeaturedProfiles;
