import { Check, X } from "lucide-react";
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
      <table className="w-full border-collapse">
        <thead>
          <tr className="border-b">
            <th className="text-left py-4 px-4 font-semibold text-foreground">Features</th>
            <th className="text-center py-4 px-4 min-w-[100px]">
              <div className="flex flex-col items-center gap-1">
                <span className="font-semibold text-foreground text-sm">Silver</span>
                <span className="text-xs text-muted-foreground">3 Months</span>
                <span className="text-sm font-bold text-primary">₹2,500</span>
              </div>
            </th>
            <th className="text-center py-4 px-4 min-w-[100px]">
              <div className="flex flex-col items-center gap-1">
                <span className="font-semibold text-foreground text-sm">Gold</span>
                <span className="text-xs text-muted-foreground">6 Months</span>
                <span className="text-sm font-bold text-primary">₹3,500</span>
              </div>
            </th>
            <th className="text-center py-4 px-4 min-w-[100px] bg-primary/5 rounded-t-lg">
              <div className="flex flex-col items-center gap-1">
                <span className="font-semibold text-primary text-sm">Premium</span>
                <span className="text-xs bg-primary text-white px-2 py-0.5 rounded-full">Popular</span>
                <span className="text-xs text-muted-foreground">12 Months</span>
                <span className="text-sm font-bold text-primary">₹5,000</span>
              </div>
            </th>
            <th className="text-center py-4 px-4 min-w-[100px]">
              <div className="flex flex-col items-center gap-1">
                <span className="font-semibold text-foreground text-sm">Elite Silver</span>
                <span className="text-xs text-muted-foreground">4 Months</span>
                <span className="text-sm font-bold text-primary">₹4,000</span>
              </div>
            </th>
            <th className="text-center py-4 px-4 min-w-[100px]">
              <div className="flex flex-col items-center gap-1">
                <span className="font-semibold text-foreground text-sm">Elite Gold</span>
                <span className="text-xs text-muted-foreground">8 Months</span>
                <span className="text-sm font-bold text-primary">₹6,500</span>
              </div>
            </th>
            <th className="text-center py-4 px-4 min-w-[100px]">
              <div className="flex flex-col items-center gap-1">
                <span className="font-semibold text-foreground text-sm">Elite Premium</span>
                <span className="text-xs text-muted-foreground">12 Months</span>
                <span className="text-sm font-bold text-primary">₹9,000</span>
              </div>
            </th>
          </tr>
        </thead>
        <tbody>
          {comparisonFeatures.map((feature, index) => (
            <tr 
              key={feature.name}
              className={cn(
                "border-b transition-colors hover:bg-muted/50",
                index % 2 === 0 && "bg-muted/20"
              )}
            >
              <td className="py-4 px-4 text-sm text-foreground font-medium">
                {feature.name}
              </td>
              <td className="text-center py-4 px-4">
                {renderValue(feature.silver)}
              </td>
              <td className="text-center py-4 px-4">
                {renderValue(feature.gold)}
              </td>
              <td className="text-center py-4 px-4 bg-primary/5">
                {renderValue(feature.premium)}
              </td>
              <td className="text-center py-4 px-4">
                {renderValue(feature.eliteSilver)}
              </td>
              <td className="text-center py-4 px-4">
                {renderValue(feature.eliteGold)}
              </td>
              <td className="text-center py-4 px-4">
                {renderValue(feature.elitePremium)}
              </td>
            </tr>
          ))}
        </tbody>
        <tfoot>
          <tr>
            <td className="py-6 px-4"></td>
            <td className="text-center py-6 px-4">
              <button 
                onClick={() => onSelectPlan('silver')}
                className="px-3 py-2 text-xs border border-primary text-primary rounded-lg hover:bg-primary/5 transition-colors font-medium"
              >
                Choose
              </button>
            </td>
            <td className="text-center py-6 px-4">
              <button 
                onClick={() => onSelectPlan('gold')}
                className="px-3 py-2 text-xs border border-primary text-primary rounded-lg hover:bg-primary/5 transition-colors font-medium"
              >
                Choose
              </button>
            </td>
            <td className="text-center py-6 px-4 bg-primary/5 rounded-b-lg">
              <button 
                onClick={() => onSelectPlan('premium')}
                className="px-3 py-2 text-xs bg-gradient-primary text-white rounded-lg hover:opacity-90 transition-opacity font-medium"
              >
                Choose
              </button>
            </td>
            <td className="text-center py-6 px-4">
              <button 
                onClick={() => onSelectPlan('elite-silver')}
                className="px-3 py-2 text-xs border border-primary text-primary rounded-lg hover:bg-primary/5 transition-colors font-medium"
              >
                Choose
              </button>
            </td>
            <td className="text-center py-6 px-4">
              <button 
                onClick={() => onSelectPlan('elite-gold')}
                className="px-3 py-2 text-xs border border-primary text-primary rounded-lg hover:bg-primary/5 transition-colors font-medium"
              >
                Choose
              </button>
            </td>
            <td className="text-center py-6 px-4">
              <button 
                onClick={() => onSelectPlan('elite-premium')}
                className="px-3 py-2 text-xs border border-violet-500 text-violet-600 rounded-lg hover:bg-violet-50 transition-colors font-medium"
              >
                Choose
              </button>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  );
};

export default ComparisonTable;
