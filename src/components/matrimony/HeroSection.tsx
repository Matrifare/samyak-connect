import { Search } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import heroBg from "@/assets/hero-bg.jpg";

const HeroSection = () => {
  return (
    <section className="relative min-h-[70vh] flex items-center justify-center overflow-hidden">
      {/* Background Image */}
      <div 
        className="absolute inset-0 bg-cover bg-center bg-no-repeat"
        style={{ backgroundImage: `url(${heroBg})` }}
      />
      
      {/* Gradient Overlay */}
      <div className="absolute inset-0 bg-gradient-hero" />
      
      {/* Floating Elements */}
      <div className="absolute top-20 left-10 w-20 h-20 rounded-full bg-primary/20 blur-xl animate-float" />
      <div className="absolute bottom-32 right-20 w-32 h-32 rounded-full bg-secondary/20 blur-xl animate-float" style={{ animationDelay: "2s" }} />
      <div className="absolute top-40 right-10 w-16 h-16 rounded-full bg-accent/30 blur-lg animate-float" style={{ animationDelay: "4s" }} />
      
      {/* Content */}
      <div className="relative z-10 container mx-auto px-4 text-center text-white">
        <h1 className="text-4xl md:text-5xl lg:text-6xl font-serif font-bold mb-4 animate-fade-up">
          Find Your Perfect
          <span className="block text-accent mt-2">Buddhist Life Partner</span>
        </h1>
        <p className="text-lg md:text-xl text-white/90 max-w-2xl mx-auto mb-8 animate-fade-up" style={{ animationDelay: "0.2s" }}>
          Join thousands of Buddhist singles who have found their soulmate through Samyak Matrimony
        </p>
        
        {/* Search Box */}
        <div className="max-w-7xl mx-auto glass rounded-2xl p-4 md:p-6 animate-fade-up" style={{ animationDelay: "0.4s" }}>
          {/* Single Row on Desktop, Grid on Mobile */}
          <div className="grid grid-cols-2 lg:grid-cols-7 gap-3 items-end">
            <div className="text-left">
              <label className="block text-xs font-medium text-foreground mb-1.5">I'm looking for</label>
              <Select defaultValue="bride">
                <SelectTrigger className="w-full bg-white h-9 text-gray-800 border-0">
                  <SelectValue placeholder="Select" />
                </SelectTrigger>
                <SelectContent className="bg-white z-50">
                  <SelectItem value="bride">Bride</SelectItem>
                  <SelectItem value="groom">Groom</SelectItem>
                </SelectContent>
              </Select>
            </div>
            
            <div className="text-left">
              <label className="block text-xs font-medium text-foreground mb-1.5">Age From</label>
              <Select defaultValue="21">
                <SelectTrigger className="w-full bg-white h-9 text-gray-800 border-0">
                  <SelectValue placeholder="Min" />
                </SelectTrigger>
                <SelectContent className="bg-white z-50">
                  {Array.from({ length: 43 }, (_, i) => i + 18).map((age) => (
                    <SelectItem key={age} value={age.toString()}>{age} yrs</SelectItem>
                  ))}
                </SelectContent>
              </Select>
            </div>
            
            <div className="text-left">
              <label className="block text-xs font-medium text-foreground mb-1.5">Age To</label>
              <Select defaultValue="30">
                <SelectTrigger className="w-full bg-white h-9 text-gray-800 border-0">
                  <SelectValue placeholder="Max" />
                </SelectTrigger>
                <SelectContent className="bg-white z-50">
                  {Array.from({ length: 43 }, (_, i) => i + 18).map((age) => (
                    <SelectItem key={age} value={age.toString()}>{age} yrs</SelectItem>
                  ))}
                </SelectContent>
              </Select>
            </div>
            
            <div className="text-left">
              <label className="block text-xs font-medium text-foreground mb-1.5">Religion</label>
              <Select defaultValue="buddhist">
                <SelectTrigger className="w-full bg-white h-9 text-gray-800 border-0">
                  <SelectValue placeholder="Select" />
                </SelectTrigger>
                <SelectContent className="bg-white z-50">
                  <SelectItem value="any">Any</SelectItem>
                  <SelectItem value="buddhist">Buddhist</SelectItem>
                  <SelectItem value="hindu">Hindu</SelectItem>
                  <SelectItem value="christian">Christian</SelectItem>
                  <SelectItem value="muslim">Muslim</SelectItem>
                  <SelectItem value="sikh">Sikh</SelectItem>
                  <SelectItem value="jain">Jain</SelectItem>
                  <SelectItem value="other">Other</SelectItem>
                </SelectContent>
              </Select>
            </div>

            <div className="text-left">
              <label className="block text-xs font-medium text-foreground mb-1.5">Marital Status</label>
              <Select defaultValue="any">
                <SelectTrigger className="w-full bg-white h-9 text-gray-800 border-0">
                  <SelectValue placeholder="Select" />
                </SelectTrigger>
                <SelectContent className="bg-white z-50">
                  <SelectItem value="any">Any</SelectItem>
                  <SelectItem value="never_married">Never Married</SelectItem>
                  <SelectItem value="divorced">Divorced</SelectItem>
                  <SelectItem value="widowed">Widowed</SelectItem>
                  <SelectItem value="awaiting_divorce">Awaiting Divorce</SelectItem>
                </SelectContent>
              </Select>
            </div>
            
            <div className="text-left">
              <label className="block text-xs font-medium text-foreground mb-1.5">Education</label>
              <Select defaultValue="any">
                <SelectTrigger className="w-full bg-white h-9 text-gray-800 border-0">
                  <SelectValue placeholder="Select" />
                </SelectTrigger>
                <SelectContent className="bg-white z-50">
                  <SelectItem value="any">Any</SelectItem>
                  <SelectItem value="doctorate">Doctorate</SelectItem>
                  <SelectItem value="masters">Masters</SelectItem>
                  <SelectItem value="bachelors">Bachelors</SelectItem>
                  <SelectItem value="diploma">Diploma</SelectItem>
                  <SelectItem value="high_school">High School</SelectItem>
                  <SelectItem value="other">Other</SelectItem>
                </SelectContent>
              </Select>
            </div>
            
            <div className="flex items-end col-span-2 lg:col-span-1">
              <Button className="w-full bg-gradient-primary hover:opacity-90 h-9 gap-2 pulse-glow">
                <Search className="h-4 w-4" />
                Search
              </Button>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default HeroSection;
