import { Heart, MessageCircle, Bookmark, Ban, Phone } from "lucide-react";
import { Button } from "@/components/ui/button";
import {
  Tooltip,
  TooltipContent,
  TooltipProvider,
  TooltipTrigger,
} from "@/components/ui/tooltip";
import { toast } from "sonner";

interface ProfileActionsProps {
  profileId: string;
  variant?: "card" | "full";
  className?: string;
}

const actions = [
  {
    id: "interest",
    label: "Send Interest",
    icon: Heart,
    color: "text-rose-500 hover:text-rose-600",
    bgHover: "hover:bg-rose-50 dark:hover:bg-rose-950/20",
  },
  {
    id: "message",
    label: "Send Message",
    icon: MessageCircle,
    color: "text-blue-500 hover:text-blue-600",
    bgHover: "hover:bg-blue-50 dark:hover:bg-blue-950/20",
  },
  {
    id: "bookmark",
    label: "Bookmark Profile",
    icon: Bookmark,
    color: "text-amber-500 hover:text-amber-600",
    bgHover: "hover:bg-amber-50 dark:hover:bg-amber-950/20",
  },
  {
    id: "contact",
    label: "View Contact",
    icon: Phone,
    color: "text-green-500 hover:text-green-600",
    bgHover: "hover:bg-green-50 dark:hover:bg-green-950/20",
  },
  {
    id: "block",
    label: "Block Profile",
    icon: Ban,
    color: "text-muted-foreground hover:text-destructive",
    bgHover: "hover:bg-destructive/10",
  },
];

const ProfileActions = ({ profileId, variant = "card", className = "" }: ProfileActionsProps) => {
  const handleAction = (action: string, label: string) => {
    toast.success(`${label} - Profile ${profileId}`, {
      description: "This is a demo action. No actual data is saved.",
    });
  };

  if (variant === "full") {
    return (
      <div className={`flex flex-wrap gap-2 ${className}`}>
        {actions.map((action) => (
          <Button
            key={action.id}
            variant="outline"
            size="sm"
            className={`gap-2 ${action.bgHover}`}
            onClick={() => handleAction(action.id, action.label)}
          >
            <action.icon className={`h-4 w-4 ${action.color}`} />
            <span className="hidden sm:inline">{action.label}</span>
          </Button>
        ))}
      </div>
    );
  }

  // Card variant - compact icons with tooltips
  return (
    <TooltipProvider delayDuration={100}>
      <div className={`flex items-center gap-1 ${className}`}>
        {actions.map((action) => (
          <Tooltip key={action.id}>
            <TooltipTrigger asChild>
              <Button
                variant="ghost"
                size="icon"
                className={`h-8 w-8 ${action.bgHover} transition-all`}
                onClick={(e) => {
                  e.preventDefault();
                  e.stopPropagation();
                  handleAction(action.id, action.label);
                }}
              >
                <action.icon className={`h-4 w-4 ${action.color}`} />
              </Button>
            </TooltipTrigger>
            <TooltipContent side="bottom" className="text-xs">
              {action.label}
            </TooltipContent>
          </Tooltip>
        ))}
      </div>
    </TooltipProvider>
  );
};

export default ProfileActions;
