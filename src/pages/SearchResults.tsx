import { useState, useMemo } from "react";
import { Link, useSearchParams } from "react-router-dom";
import { Search, Filter, Grid, List, Eye, MapPin, Briefcase, GraduationCap, Crown, BadgeCheck, Heart, Loader2 } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import Header from "@/components/matrimony/Header";
import Footer from "@/components/matrimony/Footer";
import ProfileActions from "@/components/profile/ProfileActions";
import { useSearchProfiles, useReligions, useCities } from "@/hooks/useApi";
import apiService, { Profile, SearchFilters } from "@/services/api";
import defaultMale from "@/assets/default-male.jpg";
import defaultFemale from "@/assets/default-female.jpg";

const PROFILES_PER_PAGE = 12;

const SearchResults = () => {
  const [searchParams, setSearchParams] = useSearchParams();
  const [viewType, setViewType] = useState<"grid" | "list">("grid");
  const [showFilters, setShowFilters] = useState(false);
  const [currentPage, setCurrentPage] = useState(1);
  const [profileIdSearch, setProfileIdSearch] = useState("");

  // Build filters from URL params
  const filters: SearchFilters = useMemo(() => ({
    gender: searchParams.get('gender') || undefined,
    age_from: searchParams.get('age_from') || undefined,
    age_to: searchParams.get('age_to') || undefined,
    religion: searchParams.get('religion') || undefined,
    city: searchParams.get('city') || undefined,
    m_status: searchParams.get('m_status') || undefined,
    photo_search: searchParams.get('photo_search') === 'true',
  }), [searchParams]);

  // Fetch data
  const { data: searchResult, isLoading, error } = useSearchProfiles(filters, currentPage, PROFILES_PER_PAGE);
  const { data: religions = [] } = useReligions();
  const { data: cities = [] } = useCities();

  const profiles = searchResult?.data || [];
  const totalProfiles = searchResult?.pagination.total || 0;
  const totalPages = searchResult?.pagination.total_pages || 1;

  // Helper functions
  const getProfileImage = (profile: Profile) => {
    if (profile.photo1 && profile.photo1_approve === 'APPROVED') {
      return apiService.getPhotoUrl(profile.photo1);
    }
    return profile.gender === 'Bride' ? defaultFemale : defaultMale;
  };

  const getProfileName = (profile: Profile) => {
    return `${profile.firstname || ''} ${profile.lastname || ''}`.trim() || 'Profile';
  };

  const getAge = (profile: Profile) => {
    return apiService.calculateAge(profile.birthdate);
  };

  const formatHeight = (height: string | undefined) => {
    if (!height) return '';
    const parts = height.split('.');
    if (parts.length === 2) {
      return `${parts[0]}'${parts[1]}"`;
    }
    return height;
  };

  const handlePageChange = (page: number) => {
    setCurrentPage(page);
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  const handleFilterChange = (key: string, value: string) => {
    const newParams = new URLSearchParams(searchParams);
    if (value && value !== 'all') {
      newParams.set(key, value);
    } else {
      newParams.delete(key);
    }
    setSearchParams(newParams);
    setCurrentPage(1);
  };

  const applyFilters = () => {
    setShowFilters(false);
    setCurrentPage(1);
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
                  <Input 
                    placeholder="Search by Profile ID" 
                    className="pl-10"
                    value={profileIdSearch}
                    onChange={(e) => setProfileIdSearch(e.target.value)}
                    onKeyDown={(e) => {
                      if (e.key === 'Enter' && profileIdSearch) {
                        window.location.href = `/profile/${profileIdSearch}`;
                      }
                    }}
                  />
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
                  Found <strong className="text-primary">{totalProfiles}</strong> profiles
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
                  <Select 
                    value={filters.gender || 'all'}
                    onValueChange={(value) => handleFilterChange('gender', value)}
                  >
                    <SelectTrigger>
                      <SelectValue placeholder="Gender" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="all">All Genders</SelectItem>
                      <SelectItem value="Groom">Groom</SelectItem>
                      <SelectItem value="Bride">Bride</SelectItem>
                    </SelectContent>
                  </Select>

                  <Select 
                    value={filters.age_from || 'all'}
                    onValueChange={(value) => {
                      handleFilterChange('age_from', value);
                      if (value !== 'all') {
                        const ageTo = parseInt(value) + 5;
                        handleFilterChange('age_to', ageTo.toString());
                      }
                    }}
                  >
                    <SelectTrigger>
                      <SelectValue placeholder="Age" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="all">All Ages</SelectItem>
                      <SelectItem value="21">21-25 years</SelectItem>
                      <SelectItem value="26">26-30 years</SelectItem>
                      <SelectItem value="31">31-35 years</SelectItem>
                      <SelectItem value="36">36-40 years</SelectItem>
                      <SelectItem value="41">41+ years</SelectItem>
                    </SelectContent>
                  </Select>

                  <Select 
                    value={filters.religion || 'all'}
                    onValueChange={(value) => handleFilterChange('religion', value)}
                  >
                    <SelectTrigger>
                      <SelectValue placeholder="Religion" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="all">All Religions</SelectItem>
                      {religions.map((religion) => (
                        <SelectItem key={religion.religion_id} value={religion.religion_id.toString()}>
                          {religion.religion_name}
                        </SelectItem>
                      ))}
                    </SelectContent>
                  </Select>

                  <Select 
                    value={filters.city || 'all'}
                    onValueChange={(value) => handleFilterChange('city', value)}
                  >
                    <SelectTrigger>
                      <SelectValue placeholder="City" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="all">All Cities</SelectItem>
                      {cities.slice(0, 50).map((city) => (
                        <SelectItem key={city.city_id} value={city.city_id.toString()}>
                          {city.city_name}
                        </SelectItem>
                      ))}
                    </SelectContent>
                  </Select>

                  <Select 
                    value={filters.m_status || 'all'}
                    onValueChange={(value) => handleFilterChange('m_status', value)}
                  >
                    <SelectTrigger>
                      <SelectValue placeholder="Marital Status" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="all">All Status</SelectItem>
                      <SelectItem value="Never Married">Never Married</SelectItem>
                      <SelectItem value="Divorced">Divorced</SelectItem>
                      <SelectItem value="Widowed">Widowed</SelectItem>
                    </SelectContent>
                  </Select>

                  <Button className="bg-gradient-primary" onClick={applyFilters}>
                    Apply Filters
                  </Button>
                </div>
              </div>
            )}
          </div>

          {/* Loading State */}
          {isLoading && (
            <div className="flex justify-center items-center py-20">
              <Loader2 className="h-8 w-8 animate-spin text-primary" />
              <span className="ml-2 text-muted-foreground">Loading profiles...</span>
            </div>
          )}

          {/* Error State */}
          {error && (
            <div className="text-center py-20">
              <p className="text-destructive">Unable to load profiles. Please try again later.</p>
            </div>
          )}

          {/* No Results */}
          {!isLoading && !error && profiles.length === 0 && (
            <div className="text-center py-20">
              <p className="text-muted-foreground">No profiles found matching your criteria.</p>
              <Button 
                variant="outline" 
                className="mt-4"
                onClick={() => {
                  setSearchParams(new URLSearchParams());
                  setCurrentPage(1);
                }}
              >
                Clear Filters
              </Button>
            </div>
          )}

          {/* Results Grid/List */}
          {!isLoading && !error && profiles.length > 0 && (
            <>
              <div className={viewType === "list" ? "flex gap-6" : ""}>
                <div
                  className={
                    viewType === "grid"
                      ? "grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6"
                      : "flex flex-col gap-4 flex-1"
                  }
                >
                  {profiles.map((profile) => (
                    <div
                      key={profile.matri_id}
                      className={`bg-card rounded-xl shadow-lg border border-border overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 ${
                        viewType === "list" ? "flex flex-row" : "flex flex-col"
                      }`}
                    >
                      {/* Profile Image */}
                      <div className={`relative ${viewType === "list" ? "w-36 sm:w-44 md:w-48 flex-shrink-0 self-stretch" : "aspect-[3/4]"}`}>
                        <img
                          src={getProfileImage(profile)}
                          alt={getProfileName(profile)}
                          className={`w-full h-full object-cover object-top ${viewType === "list" ? "absolute inset-0" : ""}`}
                          onError={(e) => {
                            e.currentTarget.src = profile.gender === 'Bride' ? defaultFemale : defaultMale;
                          }}
                        />
                        {/* Status Icons */}
                        <div className={`absolute ${viewType === "list" ? "top-2 left-2" : "top-3 left-3"} flex gap-1.5`}>
                          {profile.fstatus === 'Featured' && (
                            <div className="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-gradient-to-r from-amber-500 to-orange-500 flex items-center justify-center shadow-md" title="Featured Member">
                              <Crown className="h-3 w-3 sm:h-3.5 sm:w-3.5 text-white" />
                            </div>
                          )}
                          {profile.status === 'Active' && (
                            <div className="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-green-500 flex items-center justify-center shadow-md" title="Active Profile">
                              <BadgeCheck className="h-3 w-3 sm:h-3.5 sm:w-3.5 text-white" />
                            </div>
                          )}
                        </div>
                        <div className="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-2 sm:p-3">
                          <span className="text-white text-xs font-medium">{profile.matri_id}</span>
                        </div>
                      </div>

                      {/* Profile Info */}
                      <div className={`p-3 sm:p-4 flex flex-col ${viewType === "list" ? "min-w-0 w-52 lg:w-56 flex-shrink-0" : "flex-1"}`}>
                        <div className="mb-2">
                          <h3 className="font-semibold text-sm sm:text-base text-foreground line-clamp-1">
                            {getProfileName(profile)}
                          </h3>
                          <p className="text-xs text-primary font-medium">{profile.matri_id}</p>
                        </div>

                        <div className={`space-y-1 text-sm text-muted-foreground mb-2 sm:mb-3 flex-1 ${viewType === "list" ? "text-xs sm:text-sm" : ""}`}>
                          <p className="font-medium text-foreground text-xs sm:text-sm">
                            {getAge(profile)} yrs{profile.height && `, ${formatHeight(profile.height)}`}
                          </p>
                          {profile.city_name && (
                            <p className="flex items-center gap-1 sm:gap-1.5 text-xs">
                              <MapPin className="h-3 w-3 sm:h-3.5 sm:w-3.5 flex-shrink-0" />
                              <span className="truncate">{profile.city_name}</span>
                            </p>
                          )}
                          {profile.edu_name && (
                            <p className="flex items-center gap-1 sm:gap-1.5 text-xs">
                              <GraduationCap className="h-3 w-3 sm:h-3.5 sm:w-3.5 flex-shrink-0" />
                              <span className="truncate">{profile.edu_name}</span>
                            </p>
                          )}
                          {profile.ocp_name && (
                            <p className="flex items-center gap-1 sm:gap-1.5 text-xs">
                              <Briefcase className="h-3 w-3 sm:h-3.5 sm:w-3.5 flex-shrink-0" />
                              <span className="truncate">{profile.ocp_name}</span>
                            </p>
                          )}
                          {profile.religion_name && (
                            <p className="text-xs text-muted-foreground/80 truncate">
                              {profile.religion_name}
                            </p>
                          )}
                        </div>

                        {/* Profile Actions */}
                        <div className="border-t pt-2 sm:pt-3 mt-auto">
                          <ProfileActions profileId={profile.matri_id} variant="card" className="justify-start" />
                          <Link to={`/profile/${profile.matri_id}`} className="block mt-2">
                            <Button size="sm" variant="outline" className="w-full gap-1 text-xs h-8 sm:h-9">
                              <Eye className="h-3 w-3 sm:h-3.5 sm:w-3.5" />
                              View Full Profile
                            </Button>
                          </Link>
                        </div>
                      </div>

                      {/* About Me Section - Only visible on desktop in list view */}
                      {viewType === "list" && profile.profile_text && (
                        <div className="hidden lg:flex flex-col p-4 border-l border-border flex-1 bg-muted/20">
                          <h4 className="text-sm font-semibold text-foreground mb-2">About Me</h4>
                          <p className="text-xs text-muted-foreground leading-relaxed line-clamp-5">
                            {profile.profile_text}
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
                          <p className="text-xs">📞 +91 9819886759</p>
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
                  {Array.from({ length: Math.min(totalPages, 5) }, (_, i) => {
                    let page = i + 1;
                    if (totalPages > 5) {
                      if (currentPage > 3) {
                        page = currentPage - 2 + i;
                      }
                      if (page > totalPages) {
                        page = totalPages - 4 + i;
                      }
                    }
                    return page;
                  }).filter(page => page > 0 && page <= totalPages).map((page) => (
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
                Showing {((currentPage - 1) * PROFILES_PER_PAGE) + 1}-{Math.min(currentPage * PROFILES_PER_PAGE, totalProfiles)} of {totalProfiles} profiles
              </p>
            </>
          )}
        </div>
      </main>

      <Footer />
    </div>
  );
};

export default SearchResults;
