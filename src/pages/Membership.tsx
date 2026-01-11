import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { ArrowRight, Shield, Clock, Headphones } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Tabs, TabsList, TabsTrigger } from "@/components/ui/tabs";
import PlanCard from "@/components/membership/PlanCard";
import { membershipPlans, currentMembership } from "@/data/membershipPlans";

const Membership = () => {
  const navigate = useNavigate();
  const [duration, setDuration] = useState<'monthly' | 'quarterly' | 'yearly'>('monthly');

  const handleSelectPlan = (planId: string) => {
    if (planId === 'free') return;
    navigate(`/membership/upgrade?plan=${planId}&duration=${duration}`);
  };

  const savingsPercentage = {
    monthly: 0,
    quarterly: 15,
    yearly: 35,
  };

  return (
    <div className="min-h-screen bg-background">
      {/* Hero Section */}
      <section className="relative bg-gradient-hero py-20 px-4">
        <div className="container mx-auto text-center relative z-10">
          <h1 className="text-4xl md:text-5xl font-bold text-white mb-4">
            Find Your Perfect Match Faster
          </h1>
          <p className="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
            Upgrade your membership to unlock premium features and connect with more profiles
          </p>

          {/* Duration Selector */}
          <div className="inline-flex flex-col items-center gap-3">
            <Tabs value={duration} onValueChange={(v) => setDuration(v as typeof duration)}>
              <TabsList className="bg-white/20 backdrop-blur-sm">
                <TabsTrigger value="monthly" className="data-[state=active]:bg-white data-[state=active]:text-primary">
                  Monthly
                </TabsTrigger>
                <TabsTrigger value="quarterly" className="data-[state=active]:bg-white data-[state=active]:text-primary">
                  Quarterly
                  <span className="ml-2 text-xs bg-green-500 text-white px-1.5 py-0.5 rounded">-15%</span>
                </TabsTrigger>
                <TabsTrigger value="yearly" className="data-[state=active]:bg-white data-[state=active]:text-primary">
                  Yearly
                  <span className="ml-2 text-xs bg-green-500 text-white px-1.5 py-0.5 rounded">-35%</span>
                </TabsTrigger>
              </TabsList>
            </Tabs>
            
            {savingsPercentage[duration] > 0 && (
              <p className="text-white/80 text-sm">
                🎉 You save {savingsPercentage[duration]}% with {duration} billing
              </p>
            )}
          </div>
        </div>
      </section>

      {/* Plans Grid */}
      <section className="py-16 px-4 -mt-8">
        <div className="container mx-auto">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
            {membershipPlans.map((plan) => (
              <PlanCard
                key={plan.id}
                plan={plan}
                duration={duration}
                isCurrentPlan={plan.id === currentMembership.plan}
                onSelect={handleSelectPlan}
              />
            ))}
          </div>

          {/* Compare Plans Link */}
          <div className="text-center mt-12">
            <Link to="/membership/compare">
              <Button variant="link" className="text-primary">
                Compare all features in detail
                <ArrowRight className="w-4 h-4 ml-2" />
              </Button>
            </Link>
          </div>
        </div>
      </section>

      {/* Trust Badges */}
      <section className="py-12 px-4 bg-muted/30">
        <div className="container mx-auto">
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
            <div className="flex items-center gap-4 justify-center">
              <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                <Shield className="w-6 h-6 text-primary" />
              </div>
              <div>
                <h4 className="font-semibold text-foreground">100% Secure</h4>
                <p className="text-sm text-muted-foreground">SSL encrypted payments</p>
              </div>
            </div>
            <div className="flex items-center gap-4 justify-center">
              <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                <Clock className="w-6 h-6 text-primary" />
              </div>
              <div>
                <h4 className="font-semibold text-foreground">Instant Activation</h4>
                <p className="text-sm text-muted-foreground">Features unlock immediately</p>
              </div>
            </div>
            <div className="flex items-center gap-4 justify-center">
              <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                <Headphones className="w-6 h-6 text-primary" />
              </div>
              <div>
                <h4 className="font-semibold text-foreground">24/7 Support</h4>
                <p className="text-sm text-muted-foreground">Help when you need it</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* FAQ Preview */}
      <section className="py-16 px-4">
        <div className="container mx-auto max-w-3xl">
          <h2 className="text-2xl font-bold text-center mb-8">Frequently Asked Questions</h2>
          
          <div className="space-y-4">
            <FaqItem 
              question="Can I upgrade my plan anytime?"
              answer="Yes! You can upgrade your plan at any time. The difference in price will be prorated based on your remaining subscription period."
            />
            <FaqItem 
              question="What payment methods are accepted?"
              answer="We accept all major credit/debit cards, UPI, net banking, and popular digital wallets for your convenience."
            />
            <FaqItem 
              question="Can I cancel my subscription?"
              answer="Yes, you can cancel your subscription anytime. Your premium features will remain active until the end of your billing period."
            />
          </div>
        </div>
      </section>
    </div>
  );
};

const FaqItem = ({ question, answer }: { question: string; answer: string }) => (
  <div className="border rounded-lg p-4">
    <h4 className="font-semibold text-foreground mb-2">{question}</h4>
    <p className="text-sm text-muted-foreground">{answer}</p>
  </div>
);

export default Membership;
