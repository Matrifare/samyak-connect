import { Crown, Gem, Medal, Star } from "lucide-react";
import { cn } from "@/lib/utils";

interface MembershipBadgeProps {
  plan: 'free' | 'silver' | 'gold' | 'platinum';
  size?: 'sm' | 'md' | 'lg';
  showLabel?: boolean;
}

const MembershipBadge = ({ plan, size = 'md', showLabel = true }: MembershipBadgeProps) => {
  const config = {
    free: {
      icon: Star,
      label: 'Free',
      className: 'bg-slate-100 text-slate-600 border-slate-200',
      iconColor: 'text-slate-500',
    },
    silver: {
      icon: Medal,
      label: 'Silver',
      className: 'bg-gray-100 text-gray-700 border-gray-300',
      iconColor: 'text-gray-500',
    },
    gold: {
      icon: Crown,
      label: 'Gold',
      className: 'bg-amber-50 text-amber-700 border-amber-300',
      iconColor: 'text-amber-500',
    },
    platinum: {
      icon: Gem,
      label: 'Platinum',
      className: 'bg-violet-50 text-violet-700 border-violet-300',
      iconColor: 'text-violet-500',
    },
  };

  const sizeClasses = {
    sm: 'px-2 py-1 text-xs gap-1',
    md: 'px-3 py-1.5 text-sm gap-1.5',
    lg: 'px-4 py-2 text-base gap-2',
  };

  const iconSizes = {
    sm: 'w-3 h-3',
    md: 'w-4 h-4',
    lg: 'w-5 h-5',
  };

  const { icon: Icon, label, className, iconColor } = config[plan];

  return (
    <span 
      className={cn(
        "inline-flex items-center font-medium rounded-full border",
        className,
        sizeClasses[size]
      )}
    >
      <Icon className={cn(iconSizes[size], iconColor)} />
      {showLabel && <span>{label}</span>}
    </span>
  );
};

export default MembershipBadge;
