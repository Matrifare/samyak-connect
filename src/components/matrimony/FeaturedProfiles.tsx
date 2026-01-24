import { useState } from "react";
import { MapPin, Briefcase, GraduationCap, Heart, ChevronLeft, ChevronRight, Loader2 } from "lucide-react";
import { Button } from "@/components/ui/button";
import { useFeaturedProfiles } from "@/hooks/useApi";
import apiService, { Profile } from "@/services/api";
import defaultMale from "@/assets/default-male.jpg";
import defaultFemale from "@/assets/default-female.jpg";
import { Link } from "react-router-dom";

const FeaturedProfiles = () => {
  const [currentIndex, setCurrentIndex] = useState(0);
  const { data: profiles = [], isLoading, error } = useFeaturedProfiles(8);

  const handlePrev = () => {
    setCurrentIndex((prev) => (prev === 0 ? profiles.length - 1 : prev - 1));
  };

  const handleNext = () => {
    setCurrentIndex((prev) => (prev === profiles.length - 1 ? 0 : prev + 1));
  };

  const progressPercentage = profiles.length > 0 ? ((currentIndex + 1) / profiles.length) * 100 : 0;

  // Helper to get profile image
  const getProfileImage = (profile: Profile) => {
    if (profile.photo1 && profile.photo1_approve === 'APPROVED') {
      return apiService.getPhotoUrl(profile.photo1);
    }
    return profile.gender === 'Bride' ? defaultFemale : defaultMale;
  };

  // Helper to get profile name
  const getProfileName = (profile: Profile) => {
    return `${profile.firstname || ''} ${profile.lastname || ''}`.trim() || 'Profile';
  };

  // Helper to calculate age from birthdate
  const getAge = (profile: Profile) => {
    return apiService.calculateAge(profile.birthdate);
  };

  // Helper to format height
  const formatHeight = (height: string | undefined) => {
    if (!height) return '';
    // Height is stored as feet value like "5.4" meaning 5'4"
    const parts = height.split('.');
    if (parts.length === 2) {
      return `${parts[0]}'${parts[1]}"`;
    }
    return height;
  };

  if (isLoading) {
    return (
      <section className="py-20">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-serif font-bold gradient-text mb-4">
              Featured Profiles
            </h2>
          </div>
          <div className="flex justify-center items-center py-20">
            <Loader2 className="h-8 w-8 animate-spin text-primary" />
            <span className="ml-2 text-muted-foreground">Loading profiles...</span>
          </div>
        </div>
      </section>
    );
  }

  if (error || profiles.length === 0) {
    return (
      <section className="py-20">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-serif font-bold gradient-text mb-4">
              Featured Profiles
            </h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">
              {error ? 'Unable to load profiles. Please try again later.' : 'No featured profiles available at the moment.'}
            </p>
          </div>
        </div>
      </section>
    );
  }

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
        
        {/* Mobile Carousel View - visible below md breakpoint (768px) */}
        <div className="md:hidden">
          <div className="relative overflow-hidden">
            <div 
              className="flex transition-transform duration-300 ease-in-out"
              style={{ transform: `translateX(-${currentIndex * 100}%)` }}
            >
              {profiles.map((profile) => (
                <div
                  key={profile.matri_id}
                  className="w-full flex-shrink-0 px-2"
                >
                  <div className="bg-card rounded-2xl overflow-hidden shadow-lg">
                    <div className="relative aspect-[3/4] overflow-hidden">
                      <img
                        src={getProfileImage(profile)}
                        alt={getProfileName(profile)}
                        className="w-full h-full object-cover"
                        onError={(e) => {
                          e.currentTarget.src = profile.gender === 'Bride' ? defaultFemale : defaultMale;
                        }}
                      />
                      <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent" />
                      <div className="absolute bottom-4 left-4 right-4 text-white">
                        <h3 className="text-xl font-serif font-bold">{getProfileName(profile)}</h3>
                        <p className="text-white/80 text-sm">
                          {getAge(profile)} yrs{profile.height && `, ${formatHeight(profile.height)}`}
                        </p>
                      </div>
                      <div className="absolute top-3 left-3 bg-primary/90 text-primary-foreground text-xs px-2 py-1 rounded-full">
                        {profile.matri_id}
                      </div>
                    </div>
                    
                    <div className="p-4 space-y-3">
                      {profile.edu_name && (
                        <div className="flex items-center gap-2 text-sm text-muted-foreground">
                          <GraduationCap className="h-4 w-4 text-primary" />
                          <span>{profile.edu_name}</span>
                        </div>
                      )}
                      {profile.ocp_name && (
                        <div className="flex items-center gap-2 text-sm text-muted-foreground">
                          <Briefcase className="h-4 w-4 text-primary" />
                          <span>{profile.ocp_name}</span>
                        </div>
                      )}
                      {profile.city_name && (
                        <div className="flex items-center gap-2 text-sm text-muted-foreground">
                          <MapPin className="h-4 w-4 text-primary" />
                          <span>{profile.city_name}{profile.country_name && `, ${profile.country_name}`}</span>
                        </div>
                      )}
                      
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
            <div className="h-1 bg-muted rounded-full overflow-hidden">
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
              className="w-10 h-10 rounded-full border border-border flex items-center justify-center hover:bg-muted transition-colors"
              aria-label="Previous profile"
            >
              <ChevronLeft className="h-5 w-5 text-muted-foreground" />
            </button>
            <button
              onClick={handleNext}
              className="w-10 h-10 rounded-full border border-border flex items-center justify-center hover:bg-muted transition-colors"
              aria-label="Next profile"
            >
              <ChevronRight className="h-5 w-5 text-muted-foreground" />
            </button>
          </div>
        </div>

        {/* Desktop Grid View - visible at md breakpoint and above */}
        <div className="hidden md:grid md:grid-cols-2 lg:grid-cols-4 gap-6">
          {profiles.slice(0, 8).map((profile, index) => (
            <div
              key={profile.matri_id}
              className="glass rounded-2xl overflow-hidden hover-lift animate-fade-up group"
              style={{ animationDelay: `${index * 0.1}s` }}
            >
              <div className="relative aspect-[3/4] overflow-hidden">
                <img
                  src={getProfileImage(profile)}
                  alt={getProfileName(profile)}
                  className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                  onError={(e) => {
                    e.currentTarget.src = profile.gender === 'Bride' ? defaultFemale : defaultMale;
                  }}
                />
                <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent" />
                <div className="absolute bottom-4 left-4 right-4 text-white">
                  <h3 className="text-xl font-serif font-bold">{getProfileName(profile)}</h3>
                  <p className="text-white/80 text-sm">
                    {getAge(profile)} yrs{profile.height && `, ${formatHeight(profile.height)}`}
                  </p>
                </div>
                <div className="absolute top-3 left-3 bg-primary/90 text-primary-foreground text-xs px-2 py-1 rounded-full">
                  {profile.matri_id}
                </div>
              </div>
              
              <div className="p-4 space-y-3">
                {profile.edu_name && (
                  <div className="flex items-center gap-2 text-sm text-muted-foreground">
                    <GraduationCap className="h-4 w-4 text-primary" />
                    <span>{profile.edu_name}</span>
                  </div>
                )}
                {profile.ocp_name && (
                  <div className="flex items-center gap-2 text-sm text-muted-foreground">
                    <Briefcase className="h-4 w-4 text-primary" />
                    <span>{profile.ocp_name}</span>
                  </div>
                )}
                {profile.city_name && (
                  <div className="flex items-center gap-2 text-sm text-muted-foreground">
                    <MapPin className="h-4 w-4 text-primary" />
                    <span>{profile.city_name}{profile.country_name && `, ${profile.country_name}`}</span>
                  </div>
                )}
                
                <Button className="w-full bg-gradient-primary hover:opacity-90 gap-2 mt-4">
                  <Heart className="h-4 w-4" />
                  Send Interest
                </Button>
              </div>
            </div>
          ))}
        </div>
        
        <div className="text-center mt-12">
          <Link to="/search">
            <Button variant="outline" size="lg" className="border-primary text-primary hover:bg-primary hover:text-white">
              View All Profiles
            </Button>
          </Link>
        </div>
      </div>
    </section>
  );
};

export default FeaturedProfiles;
