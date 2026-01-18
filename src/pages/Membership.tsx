import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { Shield, Clock, Headphones, Eye, Phone, MessageCircle, Mail, Users, Check, X, Sparkles, Star, Zap, Loader2 } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { supabase } from "@/integrations/supabase/client";
import { cn } from "@/lib/utils";

interface MembershipPlan {
  id: string;
  name: string;
  slug: string;
  duration: string;
  duration_months: number;
  category: string;
  view_contacts: number;
  send_messages: number;
  price: number;
  icon: string;
  color: string;
  bg_color: string;
  border_color: string;
  is_popular: boolean;
  is_active: boolean;
}

interface PlanFeature {
  name: string;
  online: string | boolean;
  elite: string | boolean;
}

const comparisonFeatures: PlanFeature[] = [
  { name: 'Service Type', online: 'Self-Assisted', elite: 'Dedicated Manager' },
  { name: 'Profile Matching', online: 'Algorithm Based', elite: 'Personal Matchmaking' },
  { name: 'Profile Verification', online: 'Basic Verification', elite: 'Premium Verification' },
  { name: 'Support', online: 'Email Support', elite: '24/7 Priority Support' },
  { name: 'Profile Boost', online: 'Monthly', elite: 'Weekly' },
  { name: 'Background Check', online: false, elite: true },
  { name: 'Relationship Manager', online: false, elite: true },
  { name: 'Meeting Arrangement', online: false, elite: true },
  { name: 'Video Introduction', online: false, elite: true },
  { name: 'Profile Highlighting', online: 'Standard', elite: 'Premium Spotlight' },
  { name: 'Search Priority', online: 'Normal', elite: 'Top Results' },
  { name: 'Photo Privacy', online: 'Basic', elite: 'Advanced Controls' },
];

const membershipFeatures = [
  { icon: 'contact', label: 'View Contact Details' },
  { icon: 'phone', label: 'View Mobile Number' },
  { icon: 'chat', label: 'Chat online members' },
  { icon: 'message', label: 'Send Messages / SMS' },
];

const Membership = () => {
  const navigate = useNavigate();
  const [category, setCategory] = useState<'online' | 'elite'>('online');
  const [plans, setPlans] = useState<MembershipPlan[]>([]);
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    const fetchPlans = async () => {
      const { data, error } = await supabase
        .from("membership_plans")
        .select("*")
        .eq("is_active", true)
        .order("sort_order", { ascending: true });

      if (!error && data) {
        setPlans(data);
      }
      setIsLoading(false);
    };

    fetchPlans();
  }, []);

  const currentPlans = plans.filter(p => p.category === category);

  const handleBuyNow = (planSlug: string) => {
    navigate(`/membership/upgrade?plan=${planSlug}`);
  };

  const getFeatureIcon = (iconName: string) => {
    switch (iconName) {
      case 'contact': return <Users className="w-5 h-5" />;
      case 'phone': return <Phone className="w-5 h-5" />;
      case 'chat': return <MessageCircle className="w-5 h-5" />;
      case 'message': return <Mail className="w-5 h-5" />;
      default: return <Eye className="w-5 h-5" />;
    }
  };

  return (
    <div className="min-h-screen bg-gradient-to-b from-background to-muted/30">
      {/* Hero Section */}
      <section className="relative bg-gradient-hero py-16 md:py-20 px-4 overflow-hidden">
        <div className="absolute inset-0 opacity-50" style={{
          backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`
        }}></div>
        <div className="container mx-auto text-center relative z-10">
          <div className="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 mb-6">
            <Sparkles className="w-4 h-4 text-yellow-300" />
            <span className="text-white/90 text-sm">Find Your Perfect Life Partner</span>
          </div>
          
          <h1 className="text-3xl md:text-5xl font-bold text-white mb-4">
            Membership Plans
          </h1>
          <p className="text-lg text-white/80 mb-10 max-w-2xl mx-auto">
            Choose the plan that fits your journey to finding love
          </p>

          {/* Category Toggle */}
          <div className="inline-flex bg-white/10 backdrop-blur-md rounded-2xl p-1.5 gap-1">
            <button 
              onClick={() => setCategory('online')}
              className={cn(
                "px-8 py-3 rounded-xl font-semibold transition-all duration-300 flex items-center gap-2",
                category === 'online' 
                  ? "bg-white text-primary shadow-lg" 
                  : "text-white/80 hover:text-white hover:bg-white/10"
              )}
            >
              <Zap className="w-4 h-4" />
              Online
            </button>
            <button 
              onClick={() => setCategory('elite')}
              className={cn(
                "px-8 py-3 rounded-xl font-semibold transition-all duration-300 flex items-center gap-2",
                category === 'elite' 
                  ? "bg-white text-primary shadow-lg" 
                  : "text-white/80 hover:text-white hover:bg-white/10"
              )}
            >
              <Star className="w-4 h-4" />
              Elite
            </button>
          </div>

          <p className="text-sm text-white/60 mt-4 max-w-md mx-auto">
            {category === 'online' 
              ? 'Self-assisted service with powerful tools to search and connect'
              : 'Personalized matchmaking with dedicated relationship manager'
            }
          </p>
        </div>
      </section>

      {/* Plans Cards */}
      <section className="py-12 md:py-16 px-4 -mt-8">
        <div className="container mx-auto max-w-6xl">
          {isLoading ? (
            <div className="flex items-center justify-center py-20">
              <Loader2 className="w-8 h-8 animate-spin text-primary" />
            </div>
          ) : currentPlans.length === 0 ? (
            <div className="text-center py-20 text-muted-foreground">
              No plans available at the moment.
            </div>
          ) : (
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
              {currentPlans.map((plan) => (
                <PlanCard key={plan.id} plan={plan} onBuyNow={handleBuyNow} />
              ))}
            </div>
          )}
        </div>
      </section>

      {/* Comparison Section */}
      <section className="py-12 md:py-16 px-4 bg-card">
        <div className="container mx-auto max-w-4xl">
          <div className="text-center mb-10">
            <h2 className="text-2xl md:text-3xl font-bold text-foreground mb-3">
              Online vs Elite Comparison
            </h2>
            <p className="text-muted-foreground">
              See what makes Elite membership special
            </p>
          </div>

          <div className="bg-background rounded-2xl shadow-xl border border-border overflow-hidden">
            {/* Header */}
            <div className="grid grid-cols-3 border-b border-border">
              <div className="p-4 md:p-6 font-semibold text-foreground">Features</div>
              <div className="p-4 md:p-6 text-center bg-blue-50/50 dark:bg-blue-950/20">
                <div className="flex items-center justify-center gap-2">
                  <Zap className="w-5 h-5 text-blue-600" />
                  <span className="font-semibold text-blue-700 dark:text-blue-400">Online</span>
                </div>
                <p className="text-xs text-muted-foreground mt-1">Self-Assisted</p>
              </div>
              <div className="p-4 md:p-6 text-center bg-purple-50/50 dark:bg-purple-950/20">
                <div className="flex items-center justify-center gap-2">
                  <Star className="w-5 h-5 text-purple-600" />
                  <span className="font-semibold text-purple-700 dark:text-purple-400">Elite</span>
                </div>
                <p className="text-xs text-muted-foreground mt-1">Personalized</p>
              </div>
            </div>

            {/* Comparison Rows */}
            <div className="divide-y divide-border">
              {comparisonFeatures.map((feature, index) => (
                <div 
                  key={feature.name}
                  className={cn(
                    "grid grid-cols-3 hover:bg-muted/30 transition-colors",
                    index % 2 === 0 && "bg-muted/10"
                  )}
                >
                  <div className="p-4 text-sm font-medium text-foreground">
                    {feature.name}
                  </div>
                  <div className="p-4 text-center bg-blue-50/30 dark:bg-blue-950/10">
                    {renderComparisonValue(feature.online)}
                  </div>
                  <div className="p-4 text-center bg-purple-50/30 dark:bg-purple-950/10">
                    {renderComparisonValue(feature.elite)}
                  </div>
                </div>
              ))}
            </div>

            {/* CTA Row */}
            <div className="grid grid-cols-3 border-t border-border bg-muted/20">
              <div className="p-4 md:p-6"></div>
              <div className="p-4 md:p-6 text-center bg-blue-50/30 dark:bg-blue-950/10">
                <Button 
                  variant="outline" 
                  className="border-blue-500 text-blue-600 hover:bg-blue-50"
                  onClick={() => setCategory('online')}
                >
                  View Online Plans
                </Button>
              </div>
              <div className="p-4 md:p-6 text-center bg-purple-50/30 dark:bg-purple-950/10">
                <Button 
                  className="bg-gradient-to-r from-purple-600 to-violet-600 hover:opacity-90 text-white"
                  onClick={() => setCategory('elite')}
                >
                  View Elite Plans
                </Button>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section className="py-12 px-4">
        <div className="container mx-auto max-w-5xl">
          <h2 className="text-xl md:text-2xl font-semibold text-center mb-8 text-foreground">
            All Paid Plans Include
          </h2>
          <div className="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            {membershipFeatures.map((feature, index) => (
              <div 
                key={index} 
                className="flex flex-col items-center text-center gap-3 p-4 rounded-xl bg-card border border-border hover:shadow-lg transition-shadow"
              >
                <div className="w-14 h-14 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                  {getFeatureIcon(feature.icon)}
                </div>
                <span className="text-sm font-medium text-foreground">{feature.label}</span>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Trust Badges */}
      <section className="py-12 px-4 bg-muted/30">
        <div className="container mx-auto">
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            <div className="flex items-center gap-4 justify-center p-4 rounded-xl bg-card border border-border">
              <div className="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                <Shield className="w-6 h-6 text-green-600" />
              </div>
              <div>
                <h4 className="font-semibold text-foreground">100% Secure</h4>
                <p className="text-sm text-muted-foreground">SSL encrypted</p>
              </div>
            </div>
            <div className="flex items-center gap-4 justify-center p-4 rounded-xl bg-card border border-border">
              <div className="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                <Clock className="w-6 h-6 text-blue-600" />
              </div>
              <div>
                <h4 className="font-semibold text-foreground">Instant Activation</h4>
                <p className="text-sm text-muted-foreground">Start immediately</p>
              </div>
            </div>
            <div className="flex items-center gap-4 justify-center p-4 rounded-xl bg-card border border-border">
              <div className="w-12 h-12 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                <Headphones className="w-6 h-6 text-orange-600" />
              </div>
              <div>
                <h4 className="font-semibold text-foreground">24/7 Support</h4>
                <p className="text-sm text-muted-foreground">Always available</p>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
};

// Plan Card Component
const PlanCard = ({ plan, onBuyNow }: { plan: MembershipPlan; onBuyNow: (slug: string) => void }) => (
  <div 
    className={cn(
      "relative rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 group",
      plan.is_popular && "ring-2 ring-primary shadow-xl scale-[1.02]"
    )}
  >
    {plan.is_popular && (
      <div className="absolute -top-1 left-1/2 -translate-x-1/2 z-10">
        <Badge className="bg-gradient-to-r from-primary to-pink-500 text-white px-4 py-1 rounded-full shadow-lg">
          <Star className="w-3 h-3 mr-1" />
          Most Popular
        </Badge>
      </div>
    )}
    
    {/* Card Header */}
    <div className={cn("p-6 pt-8", plan.bg_color, plan.color)}>
      <div className="text-center">
        <span className="text-4xl mb-2 block">{plan.icon}</span>
        <h3 className="text-xl font-bold">{plan.name}</h3>
        <p className="text-sm opacity-80">{plan.duration}</p>
      </div>
    </div>

    {/* Card Body */}
    <div className="bg-card p-6 border-x border-b border-border rounded-b-2xl">
      {/* Price */}
      <div className="text-center mb-6">
        <div className="flex items-baseline justify-center gap-1">
          <span className="text-3xl font-bold text-foreground">₹{plan.price.toLocaleString()}</span>
        </div>
        <p className="text-sm text-muted-foreground mt-1">One-time payment</p>
      </div>

      {/* Stats */}
      <div className="grid grid-cols-2 gap-4 mb-6">
        <div className="text-center p-3 rounded-xl bg-muted/50">
          <div className="text-2xl font-bold text-primary">{plan.view_contacts}</div>
          <div className="text-xs text-muted-foreground">View Contacts</div>
        </div>
        <div className="text-center p-3 rounded-xl bg-muted/50">
          <div className="text-2xl font-bold text-primary">{plan.send_messages}</div>
          <div className="text-xs text-muted-foreground">Messages</div>
        </div>
      </div>

      {/* Features */}
      <ul className="space-y-2 mb-6">
        <li className="flex items-center gap-2 text-sm text-muted-foreground">
          <Check className="w-4 h-4 text-green-500 flex-shrink-0" />
          View contact details
        </li>
        <li className="flex items-center gap-2 text-sm text-muted-foreground">
          <Check className="w-4 h-4 text-green-500 flex-shrink-0" />
          Chat with members
        </li>
        <li className="flex items-center gap-2 text-sm text-muted-foreground">
          <Check className="w-4 h-4 text-green-500 flex-shrink-0" />
          Send interest
        </li>
        {plan.category === 'elite' && (
          <li className="flex items-center gap-2 text-sm text-muted-foreground">
            <Check className="w-4 h-4 text-green-500 flex-shrink-0" />
            Dedicated relationship manager
          </li>
        )}
      </ul>

      {/* CTA */}
      <Button 
        className={cn(
          "w-full",
          plan.is_popular 
            ? "bg-gradient-to-r from-primary to-pink-500 hover:opacity-90" 
            : "bg-primary hover:bg-primary/90"
        )}
        size="lg"
        onClick={() => onBuyNow(plan.slug)}
      >
        Get Started
      </Button>
    </div>
  </div>
);

// Helper function to render comparison values
const renderComparisonValue = (value: string | boolean) => {
  if (typeof value === 'boolean') {
    return value ? (
      <Check className="w-5 h-5 text-green-500 mx-auto" />
    ) : (
      <X className="w-5 h-5 text-muted-foreground/40 mx-auto" />
    );
  }
  return <span className="text-sm font-medium text-foreground">{value}</span>;
};

export default Membership;
