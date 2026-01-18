import { Check, X, Zap, Star } from "lucide-react";
import { comparisonFeatures } from "@/data/membershipPlans";
import { cn } from "@/lib/utils";

interface ComparisonTableProps {
  onSelectPlan: (planId: string) => void;
}

const ComparisonTable = ({ onSelectPlan }: ComparisonTableProps) => {
  const renderValue = (value: string | boolean) => {
    if (typeof value === 'boolean') {
      return value ? (
        <Check className="w-5 h-5 text-green-500 mx-auto" />
      ) : (
        <X className="w-5 h-5 text-muted-foreground/40 mx-auto" />
      );
    }
    return <span className="text-sm font-medium">{value}</span>;
  };

  return (
    <div className="overflow-x-auto">
      <div className="bg-background rounded-2xl shadow-xl border border-border overflow-hidden min-w-[600px]">
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
                {renderValue(feature.online)}
              </div>
              <div className="p-4 text-center bg-purple-50/30 dark:bg-purple-950/10">
                {renderValue(feature.elite)}
              </div>
            </div>
          ))}
        </div>

        {/* CTA Row */}
        <div className="grid grid-cols-3 border-t border-border bg-muted/20">
          <div className="p-4 md:p-6"></div>
          <div className="p-4 md:p-6 text-center bg-blue-50/30 dark:bg-blue-950/10">
            <button 
              onClick={() => onSelectPlan('gold')}
              className="px-4 py-2 text-sm border border-blue-500 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors font-medium"
            >
              Choose Online
            </button>
          </div>
          <div className="p-4 md:p-6 text-center bg-purple-50/30 dark:bg-purple-950/10">
            <button 
              onClick={() => onSelectPlan('elite-gold')}
              className="px-4 py-2 text-sm bg-gradient-to-r from-purple-600 to-violet-600 text-white rounded-lg hover:opacity-90 transition-opacity font-medium"
            >
              Choose Elite
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ComparisonTable;
