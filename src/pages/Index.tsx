import Header from "@/components/matrimony/Header";
import HeroSection from "@/components/matrimony/HeroSection";
import StatsSection from "@/components/matrimony/StatsSection";
import FeaturedProfiles from "@/components/matrimony/FeaturedProfiles";
import HowItWorks from "@/components/matrimony/HowItWorks";
import SuccessStories from "@/components/matrimony/SuccessStories";
import CTASection from "@/components/matrimony/CTASection";
import Footer from "@/components/matrimony/Footer";

// Main landing page for Samyakmatrimony - React preview version
const Index = () => {
  return (
    <div className="min-h-screen">
      <Header />
      <main className="pt-16 md:pt-20">
        <HeroSection />
        <StatsSection />
        <FeaturedProfiles />
        <HowItWorks />
        <SuccessStories />
        <CTASection />
      </main>
      <Footer />
    </div>
  );
};

export default Index;
