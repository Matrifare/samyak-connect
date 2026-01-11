import { useNavigate } from "react-router-dom";
import { ArrowLeft } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Card } from "@/components/ui/card";
import ComparisonTable from "@/components/membership/ComparisonTable";

const MembershipCompare = () => {
  const navigate = useNavigate();

  const handleSelectPlan = (planId: string) => {
    if (planId === 'free') return;
    navigate(`/membership/upgrade?plan=${planId}&duration=monthly`);
  };

  return (
    <div className="min-h-screen bg-background">
      {/* Header */}
      <div className="bg-gradient-hero py-12 px-4">
        <div className="container mx-auto">
          <Button 
            variant="ghost" 
            className="text-white hover:bg-white/20 mb-4"
            onClick={() => navigate('/membership')}
          >
            <ArrowLeft className="w-4 h-4 mr-2" />
            Back to Plans
          </Button>
          
          <h1 className="text-3xl md:text-4xl font-bold text-white mb-2">
            Compare Membership Plans
          </h1>
          <p className="text-white/90 max-w-2xl">
            See all features side-by-side to choose the perfect plan for your journey
          </p>
        </div>
      </div>

      {/* Comparison Table */}
      <section className="py-12 px-4">
        <div className="container mx-auto">
          <Card className="p-6 overflow-hidden">
            <ComparisonTable onSelectPlan={handleSelectPlan} />
          </Card>
        </div>
      </section>

      {/* Benefits Section */}
      <section className="py-12 px-4 bg-muted/30">
        <div className="container mx-auto max-w-4xl">
          <h2 className="text-2xl font-bold text-center mb-8">Why Upgrade?</h2>
          
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <BenefitCard 
              emoji="👀"
              title="More Profile Views"
              description="See more profiles daily and increase your chances of finding the perfect match."
            />
            <BenefitCard 
              emoji="📞"
              title="Direct Contact"
              description="Access phone numbers and contact details directly without waiting."
            />
            <BenefitCard 
              emoji="💬"
              title="Unlimited Messaging"
              description="Send unlimited messages to potential matches without any restrictions."
            />
            <BenefitCard 
              emoji="⭐"
              title="Profile Highlight"
              description="Get your profile featured at the top of search results for more visibility."
            />
          </div>
        </div>
      </section>
    </div>
  );
};

const BenefitCard = ({ 
  emoji, 
  title, 
  description 
}: { 
  emoji: string; 
  title: string; 
  description: string; 
}) => (
  <div className="bg-card rounded-lg p-6 border flex gap-4 items-start">
    <span className="text-3xl">{emoji}</span>
    <div>
      <h3 className="font-semibold text-foreground mb-1">{title}</h3>
      <p className="text-sm text-muted-foreground">{description}</p>
    </div>
  </div>
);

export default MembershipCompare;
