import { CalendarDays, Crown, ArrowUpRight } from "lucide-react";
import { Link } from "react-router-dom";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Progress } from "@/components/ui/progress";
import MembershipBadge from "./MembershipBadge";
import { currentMembership } from "@/data/membershipPlans";

const DashboardMembershipCard = () => {
  // Mock usage data - ready for database integration
  const usage = {
    profileViews: { used: 7, limit: 10 },
    messages: { used: 3, limit: 5 },
    interests: { used: 2, limit: 3 },
  };

  return (
    <Card className="overflow-hidden">
      <CardHeader className="bg-gradient-to-r from-primary/10 to-secondary/10 pb-4">
        <div className="flex items-center justify-between">
          <div className="flex items-center gap-3">
            <div className="w-12 h-12 rounded-xl bg-gradient-primary flex items-center justify-center">
              <Crown className="w-6 h-6 text-white" />
            </div>
            <div>
              <CardTitle className="text-lg">Membership Status</CardTitle>
              <CardDescription>Your current plan benefits</CardDescription>
            </div>
          </div>
          <MembershipBadge plan={currentMembership.plan as 'free' | 'silver' | 'gold' | 'platinum'} size="lg" />
        </div>
      </CardHeader>

      <CardContent className="pt-6 space-y-6">
        {/* Usage Stats */}
        <div className="space-y-4">
          <h4 className="font-semibold text-sm text-muted-foreground uppercase tracking-wide">Today's Usage</h4>
          
          <div className="space-y-3">
            <UsageBar 
              label="Profile Views" 
              used={usage.profileViews.used} 
              limit={usage.profileViews.limit} 
            />
            <UsageBar 
              label="Messages Sent" 
              used={usage.messages.used} 
              limit={usage.messages.limit} 
            />
            <UsageBar 
              label="Interests Sent" 
              used={usage.interests.used} 
              limit={usage.interests.limit} 
            />
          </div>
        </div>

        {/* Plan Info */}
        {currentMembership.plan === 'free' ? (
          <div className="bg-amber-50 dark:bg-amber-950/30 rounded-lg p-4 border border-amber-200 dark:border-amber-800">
            <p className="text-sm text-amber-800 dark:text-amber-200 mb-3">
              ⚡ Upgrade to unlock unlimited profile views, messaging, and more premium features!
            </p>
            <Link to="/membership">
              <Button className="w-full bg-gradient-primary hover:opacity-90">
                Upgrade Now
                <ArrowUpRight className="w-4 h-4 ml-2" />
              </Button>
            </Link>
          </div>
        ) : (
          <div className="flex items-center gap-3 text-sm text-muted-foreground">
            <CalendarDays className="w-4 h-4" />
            <span>
              Expires: {currentMembership.expiryDate || 'Never'}
            </span>
          </div>
        )}

        {/* Quick Actions */}
        <div className="flex gap-3">
          <Link to="/membership" className="flex-1">
            <Button variant="outline" className="w-full">
              View Plans
            </Button>
          </Link>
          <Link to="/membership/transactions" className="flex-1">
            <Button variant="outline" className="w-full">
              Transactions
            </Button>
          </Link>
        </div>
      </CardContent>
    </Card>
  );
};

const UsageBar = ({ label, used, limit }: { label: string; used: number; limit: number }) => {
  const percentage = (used / limit) * 100;
  const isNearLimit = percentage >= 80;

  return (
    <div className="space-y-1.5">
      <div className="flex justify-between text-sm">
        <span className="text-foreground">{label}</span>
        <span className={isNearLimit ? "text-amber-600 font-medium" : "text-muted-foreground"}>
          {used} / {limit}
        </span>
      </div>
      <Progress 
        value={percentage} 
        className={`h-2 ${isNearLimit ? '[&>div]:bg-amber-500' : ''}`}
      />
    </div>
  );
};

export default DashboardMembershipCard;
