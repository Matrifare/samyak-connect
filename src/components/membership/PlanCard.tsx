import { Check, X } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { MembershipPlan } from "@/data/membershipPlans";
import { cn } from "@/lib/utils";

interface PlanCardProps {
  plan: MembershipPlan;
  duration: 'monthly' | 'quarterly' | 'yearly';
  isCurrentPlan?: boolean;
  onSelect: (planId: string) => void;
}

const PlanCard = ({ plan, duration, isCurrentPlan, onSelect }: PlanCardProps) => {
  const price = plan.prices[duration];
  const durationLabel = {
    monthly: '/month',
    quarterly: '/quarter',
    yearly: '/year',
  };

  const colorClasses = {
    slate: 'from-slate-400 to-slate-600',
    gray: 'from-gray-400 to-gray-500',
    amber: 'from-amber-400 to-amber-600',
    violet: 'from-violet-500 to-purple-600',
  };

  return (
    <Card 
      className={cn(
        "relative overflow-hidden transition-all duration-300 hover-lift",
        plan.popular && "ring-2 ring-primary shadow-lg scale-105",
        isCurrentPlan && "ring-2 ring-green-500"
      )}
    >
      {plan.popular && (
        <div className="absolute top-0 left-0 right-0 bg-gradient-primary text-white text-center py-1.5 text-sm font-semibold">
          ⭐ Most Popular
        </div>
      )}
      
      {isCurrentPlan && (
        <Badge className="absolute top-4 right-4 bg-green-500">Current Plan</Badge>
      )}

      <CardHeader className={cn("pt-8", plan.popular && "pt-12")}>
        <div className={cn(
          "w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mb-4 bg-gradient-to-br",
          colorClasses[plan.color as keyof typeof colorClasses]
        )}>
          {plan.icon}
        </div>
        <CardTitle className="text-2xl">{plan.name}</CardTitle>
        <CardDescription className="text-base">{plan.description}</CardDescription>
      </CardHeader>

      <CardContent className="space-y-6">
        <div className="flex items-baseline gap-1">
          <span className="text-4xl font-bold text-foreground">
            {price === 0 ? 'Free' : `₹${price.toLocaleString()}`}
          </span>
          {price > 0 && (
            <span className="text-muted-foreground">{durationLabel[duration]}</span>
          )}
        </div>

        <ul className="space-y-3">
          <FeatureItem label="Profile Views" value={plan.features.profileViews} />
          <FeatureItem label="Contact Access" value={plan.features.contactAccess} />
          <FeatureItem label="Messaging" value={plan.features.messagingLimit} />
          <FeatureItem label="Send Interests" value={plan.features.interestLimit} />
          <FeatureItem label="Search Filters" value={plan.features.searchFilters} />
          <FeatureItem label="Profile Highlight" value={plan.features.profileHighlight} isBoolean />
          <FeatureItem label="Priority Support" value={plan.features.prioritySupport} isBoolean />
          <FeatureItem label="Verified Badge" value={plan.features.verifiedBadge} isBoolean />
        </ul>
      </CardContent>

      <CardFooter>
        <Button 
          className={cn(
            "w-full",
            plan.popular ? "bg-gradient-primary hover:opacity-90" : "",
            isCurrentPlan && "bg-green-500 hover:bg-green-600"
          )}
          variant={plan.popular || isCurrentPlan ? "default" : "outline"}
          size="lg"
          onClick={() => onSelect(plan.id)}
          disabled={isCurrentPlan}
        >
          {isCurrentPlan ? 'Current Plan' : price === 0 ? 'Get Started' : 'Upgrade Now'}
        </Button>
      </CardFooter>
    </Card>
  );
};

const FeatureItem = ({ 
  label, 
  value, 
  isBoolean = false 
}: { 
  label: string; 
  value: string | boolean; 
  isBoolean?: boolean;
}) => {
  if (isBoolean) {
    return (
      <li className="flex items-center gap-3">
        {value ? (
          <Check className="w-5 h-5 text-green-500 flex-shrink-0" />
        ) : (
          <X className="w-5 h-5 text-muted-foreground/50 flex-shrink-0" />
        )}
        <span className={cn(
          "text-sm",
          value ? "text-foreground" : "text-muted-foreground"
        )}>
          {label}
        </span>
      </li>
    );
  }

  return (
    <li className="flex items-center gap-3">
      <Check className="w-5 h-5 text-green-500 flex-shrink-0" />
      <span className="text-sm text-foreground">
        {label}: <span className="font-medium">{value}</span>
      </span>
    </li>
  );
};

export default PlanCard;
