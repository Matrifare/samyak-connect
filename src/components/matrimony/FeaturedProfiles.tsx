import { useState } from "react";
import { MapPin, Briefcase, GraduationCap, Heart, ChevronLeft, ChevronRight } from "lucide-react";
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
  const [currentIndex, setCurrentIndex] = useState(0);

  const handlePrev = () => {
    setCurrentIndex((prev) => (prev === 0 ? profiles.length - 1 : prev - 1));
  };

  const handleNext = () => {
    setCurrentIndex((prev) => (prev === profiles.length - 1 ? 0 : prev + 1));
  };

  const progressPercentage = ((currentIndex + 1) / profiles.length) * 100;

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
        
        {/* Mobile Carousel View */}
        <div className="block sm:hidden">
          <div className="relative overflow-hidden">
            <div 
              className="flex transition-transform duration-300 ease-in-out"
              style={{ transform: `translateX(-${currentIndex * 100}%)` }}
            >
              {profiles.map((profile, index) => (
                <div
                  key={profile.id}
                  className="w-full flex-shrink-0 px-2"
                >
                  <div className="bg-card rounded-2xl overflow-hidden shadow-lg">
                    <div className="relative aspect-[3/4] overflow-hidden">
                      <img
                        src={profile.image}
                        alt={profile.name}
                        className="w-full h-full object-cover"
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
                </div>
              ))}
            </div>
          </div>
          
          {/* Progress Bar */}
          <div className="mt-4 mx-2">
            <div className="h-1 bg-gray-200 rounded-full overflow-hidden">
              <div 
                className="h-full bg-primary transition-all duration-300 ease-in-out rounded-full"
                style={{ width: `${progressPercentage}%` }}
              />
            </div>
          </div>
          
          {/* Navigation Arrows */}
          <div className="flex justify-center items-center gap-4 mt-4">
            <button
              onClick={handlePrev}
              className="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition-colors"
              aria-label="Previous profile"
            >
              <ChevronLeft className="h-5 w-5 text-gray-600" />
            </button>
            <button
              onClick={handleNext}
              className="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition-colors"
              aria-label="Next profile"
            >
              <ChevronRight className="h-5 w-5 text-gray-600" />
            </button>
          </div>
        </div>

        {/* Desktop Grid View */}
        <div className="hidden sm:grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
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
