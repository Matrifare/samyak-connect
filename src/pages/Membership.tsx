import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { ArrowRight, Shield, Clock, Headphones, Eye, Phone, MessageCircle, Mail, Users } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Tabs, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { onlinePlans, personalizedPlans, membershipFeatures, MembershipPlan } from "@/data/membershipPlans";
import { cn } from "@/lib/utils";

const Membership = () => {
  const navigate = useNavigate();
  const [category, setCategory] = useState<'online' | 'personalized'>('online');

  const currentPlans = category === 'online' ? onlinePlans : personalizedPlans;

  const handleBuyNow = (planId: string) => {
    navigate(`/membership/upgrade?plan=${planId}`);
  };

  const getFeatureIcon = (iconName: string) => {
    switch (iconName) {
      case 'contact': return <Users className="w-6 h-6" />;
      case 'phone': return <Phone className="w-6 h-6" />;
      case 'chat': return <MessageCircle className="w-6 h-6" />;
      case 'message': return <Mail className="w-6 h-6" />;
      default: return <Eye className="w-6 h-6" />;
    }
  };

  return (
    <div className="min-h-screen bg-background">
      {/* Hero Section */}
      <section className="relative bg-gradient-hero py-12 md:py-16 px-4">
        <div className="container mx-auto text-center relative z-10">
          <h1 className="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">
            Membership Plans
          </h1>
          <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
            Choose the perfect plan to find your life partner
          </p>

          {/* Category Tabs */}
          <div className="inline-flex">
            <Tabs value={category} onValueChange={(v) => setCategory(v as typeof category)}>
              <TabsList className="bg-white/10 backdrop-blur-sm p-1 rounded-full">
                <TabsTrigger 
                  value="online" 
                  className="px-6 py-2.5 rounded-full data-[state=active]:bg-primary data-[state=active]:text-white transition-all"
                >
                  Online
                </TabsTrigger>
                <TabsTrigger 
                  value="personalized" 
                  className="px-6 py-2.5 rounded-full data-[state=active]:bg-muted data-[state=active]:text-foreground transition-all"
                >
                  Personalized
                </TabsTrigger>
              </TabsList>
            </Tabs>
          </div>

          <p className="text-sm text-white/70 mt-4">
            {category === 'online' 
              ? 'All online services are self-assisted. Search, Shortlist and Send Interest.'
              : 'Get dedicated relationship manager assistance for your match search.'
            }
          </p>
        </div>
      </section>

      {/* Plans Table */}
      <section className="py-8 md:py-12 px-4 -mt-4">
        <div className="container mx-auto max-w-5xl">
          <div className="bg-card rounded-2xl shadow-xl overflow-hidden border border-border">
            {/* Desktop Table View */}
            <div className="hidden md:block overflow-x-auto">
              <table className="w-full">
                <thead>
                  <tr className="border-b border-border">
                    <th className="text-left py-4 px-4 font-semibold text-foreground w-[180px]">Plan</th>
                    <th className="text-center py-4 px-4 font-semibold text-foreground">
                      <div className="flex flex-col items-center">
                        <span className="text-muted-foreground text-xs font-normal">View</span>
                        <span>Contacts</span>
                      </div>
                    </th>
                    <th className="text-center py-4 px-4 font-semibold text-foreground">
                      <div className="flex flex-col items-center">
                        <span className="text-muted-foreground text-xs font-normal">Send Message</span>
                        <span>Messages</span>
                      </div>
                    </th>
                    <th className="text-center py-4 px-4 font-semibold text-foreground w-[160px]">
                      <div className="flex flex-col items-center">
                        <span className="text-muted-foreground text-xs font-normal">FINAL PRICE</span>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  {currentPlans.map((plan, index) => (
                    <PlanRow key={plan.id} plan={plan} onBuyNow={handleBuyNow} isLast={index === currentPlans.length - 1} />
                  ))}
                </tbody>
              </table>
            </div>

            {/* Mobile Card View */}
            <div className="md:hidden divide-y divide-border">
              {currentPlans.map((plan) => (
                <PlanCard key={plan.id} plan={plan} onBuyNow={handleBuyNow} />
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section className="py-12 px-4 bg-muted/30">
        <div className="container mx-auto max-w-5xl">
          <h2 className="text-xl md:text-2xl font-semibold text-center mb-8 text-foreground">
            Features of Paid Membership
          </h2>
          <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
            {membershipFeatures.map((feature, index) => (
              <div key={index} className="flex flex-col items-center text-center gap-3">
                <div className="w-16 h-16 rounded-full border-2 border-primary/30 flex items-center justify-center text-primary">
                  {getFeatureIcon(feature.icon)}
                </div>
                <span className="text-sm font-medium text-foreground">{feature.label}</span>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Trust Badges */}
      <section className="py-12 px-4">
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
      <section className="py-12 px-4 bg-muted/20">
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

          <div className="text-center mt-8">
            <Link to="/membership/compare">
              <Button variant="link" className="text-primary">
                Compare all features in detail
                <ArrowRight className="w-4 h-4 ml-2" />
              </Button>
            </Link>
          </div>
        </div>
      </section>
    </div>
  );
};

// Desktop Row Component
const PlanRow = ({ plan, onBuyNow, isLast }: { plan: MembershipPlan; onBuyNow: (id: string) => void; isLast: boolean }) => (
  <tr className={cn("border-b border-border transition-colors hover:bg-muted/30", isLast && "border-b-0")}>
    <td className="py-3 px-4">
      <div className={cn("px-4 py-3 rounded-lg", plan.bgColor, plan.color)}>
        <div className="font-bold text-base">{plan.name}</div>
        <div className="text-sm opacity-90">{plan.duration}</div>
      </div>
    </td>
    <td className="text-center py-3 px-4">
      <div className="text-2xl font-bold text-primary">{plan.viewContacts}</div>
      <div className="text-xs text-muted-foreground">Contacts</div>
    </td>
    <td className="text-center py-3 px-4">
      <div className="text-2xl font-bold text-primary">{plan.sendMessages}</div>
      <div className="text-xs text-muted-foreground">Messages</div>
    </td>
    <td className="text-center py-3 px-4">
      <div className="flex flex-col items-center gap-2">
        <div className="text-xl font-bold text-foreground">₹ {plan.price.toLocaleString()}</div>
        <Button 
          size="sm" 
          onClick={() => onBuyNow(plan.id)}
          className="bg-primary hover:bg-primary/90 text-white px-6"
        >
          Buy Now
        </Button>
      </div>
    </td>
  </tr>
);

// Mobile Card Component
const PlanCard = ({ plan, onBuyNow }: { plan: MembershipPlan; onBuyNow: (id: string) => void }) => (
  <div className="p-4">
    <div className="flex items-center gap-4 mb-4">
      <div className={cn("px-4 py-2 rounded-lg flex-1", plan.bgColor, plan.color)}>
        <div className="font-bold">{plan.name}</div>
        <div className="text-sm opacity-90">{plan.duration}</div>
      </div>
      <div className="text-right">
        <div className="text-lg font-bold text-foreground">₹ {plan.price.toLocaleString()}</div>
      </div>
    </div>
    
    <div className="flex items-center justify-between mb-4">
      <div className="text-center flex-1">
        <div className="text-xl font-bold text-primary">{plan.viewContacts}</div>
        <div className="text-xs text-muted-foreground">View Contacts</div>
      </div>
      <div className="w-px h-8 bg-border"></div>
      <div className="text-center flex-1">
        <div className="text-xl font-bold text-primary">{plan.sendMessages}</div>
        <div className="text-xs text-muted-foreground">Send Messages</div>
      </div>
    </div>
    
    <Button 
      className="w-full bg-primary hover:bg-primary/90"
      onClick={() => onBuyNow(plan.id)}
    >
      Buy Now
    </Button>
  </div>
);

const FaqItem = ({ question, answer }: { question: string; answer: string }) => (
  <div className="border rounded-lg p-4 bg-card">
    <h4 className="font-semibold text-foreground mb-2">{question}</h4>
    <p className="text-sm text-muted-foreground">{answer}</p>
  </div>
);

export default Membership;
