import { ArrowRight, Heart } from "lucide-react";
import { Button } from "@/components/ui/button";

const CTASection = () => {
  return (
    <section className="py-20 relative overflow-hidden">
      {/* Animated Background */}
      <div className="absolute inset-0 animated-gradient opacity-90" />
      
      {/* Floating Elements */}
      <div className="absolute top-10 left-10 w-20 h-20 rounded-full bg-white/10 blur-xl animate-float" />
      <div className="absolute bottom-10 right-10 w-32 h-32 rounded-full bg-white/10 blur-xl animate-float" style={{ animationDelay: "3s" }} />
      
      <div className="container mx-auto px-4 relative z-10">
        <div className="text-center text-white">
          <Heart className="h-16 w-16 mx-auto mb-6 animate-float" />
          <h2 className="text-3xl md:text-4xl lg:text-5xl font-serif font-bold mb-4">
            Start Your Journey Today
          </h2>
          <p className="text-lg md:text-xl text-white/90 max-w-2xl mx-auto mb-8">
            Join thousands of Buddhist singles who have found their perfect life partner. 
            Registration is free and takes just a few minutes.
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button
              size="lg"
              className="bg-white text-primary hover:bg-white/90 gap-2 text-lg px-8 shimmer"
            >
              Register Free
              <ArrowRight className="h-5 w-5" />
            </Button>
            <Button
              size="lg"
              variant="outline"
              className="border-white text-white hover:bg-white/10 gap-2 text-lg px-8"
            >
              Learn More
            </Button>
          </div>
        </div>
      </div>
    </section>
  );
};

export default CTASection;
