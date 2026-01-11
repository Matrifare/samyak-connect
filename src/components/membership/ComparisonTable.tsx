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
            <th className="text-center py-4 px-4 min-w-[120px]">
              <div className="flex flex-col items-center gap-2">
                <span className="text-2xl">🆓</span>
                <span className="font-semibold text-foreground">Free</span>
                <span className="text-sm text-muted-foreground">₹0</span>
              </div>
            </th>
            <th className="text-center py-4 px-4 min-w-[120px]">
              <div className="flex flex-col items-center gap-2">
                <span className="text-2xl">🥈</span>
                <span className="font-semibold text-foreground">Silver</span>
                <span className="text-sm text-muted-foreground">₹499/mo</span>
              </div>
            </th>
            <th className="text-center py-4 px-4 min-w-[120px] bg-primary/5 rounded-t-lg">
              <div className="flex flex-col items-center gap-2">
                <span className="text-2xl">🥇</span>
                <span className="font-semibold text-primary">Gold</span>
                <span className="text-xs bg-primary text-white px-2 py-0.5 rounded-full">Popular</span>
                <span className="text-sm text-muted-foreground">₹999/mo</span>
              </div>
            </th>
            <th className="text-center py-4 px-4 min-w-[120px]">
              <div className="flex flex-col items-center gap-2">
                <span className="text-2xl">💎</span>
                <span className="font-semibold text-foreground">Platinum</span>
                <span className="text-sm text-muted-foreground">₹1999/mo</span>
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
                {renderValue(feature.free)}
              </td>
              <td className="text-center py-4 px-4">
                {renderValue(feature.silver)}
              </td>
              <td className="text-center py-4 px-4 bg-primary/5">
                {renderValue(feature.gold)}
              </td>
              <td className="text-center py-4 px-4">
                {renderValue(feature.platinum)}
              </td>
            </tr>
          ))}
        </tbody>
        <tfoot>
          <tr>
            <td className="py-6 px-4"></td>
            <td className="text-center py-6 px-4">
              <button 
                onClick={() => onSelectPlan('free')}
                className="text-sm text-primary hover:underline font-medium"
              >
                Current Plan
              </button>
            </td>
            <td className="text-center py-6 px-4">
              <button 
                onClick={() => onSelectPlan('silver')}
                className="px-4 py-2 text-sm border border-primary text-primary rounded-lg hover:bg-primary/5 transition-colors font-medium"
              >
                Choose Silver
              </button>
            </td>
            <td className="text-center py-6 px-4 bg-primary/5 rounded-b-lg">
              <button 
                onClick={() => onSelectPlan('gold')}
                className="px-4 py-2 text-sm bg-gradient-primary text-white rounded-lg hover:opacity-90 transition-opacity font-medium"
              >
                Choose Gold
              </button>
            </td>
            <td className="text-center py-6 px-4">
              <button 
                onClick={() => onSelectPlan('platinum')}
                className="px-4 py-2 text-sm border border-violet-500 text-violet-600 rounded-lg hover:bg-violet-50 transition-colors font-medium"
              >
                Choose Platinum
              </button>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  );
};

export default ComparisonTable;
