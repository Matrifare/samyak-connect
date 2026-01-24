import { Users, Heart, UserCheck, Trophy, Loader2 } from "lucide-react";
import { useStats } from "@/hooks/useApi";

const StatsSection = () => {
  const { data: statsData, isLoading } = useStats();

  const formatNumber = (num: number | undefined) => {
    if (!num) return '0';
    if (num >= 1000) {
      return `${(num / 1000).toFixed(1).replace(/\.0$/, '')}K+`;
    }
    return `${num}+`;
  };

  const stats = [
    { 
      icon: Users, 
      value: isLoading ? '...' : formatNumber(statsData?.total_profiles), 
      label: "Total Profiles", 
      color: "text-primary" 
    },
    { 
      icon: UserCheck, 
      value: isLoading ? '...' : formatNumber(statsData?.male_profiles), 
      label: "Male Profiles", 
      color: "text-secondary" 
    },
    { 
      icon: Heart, 
      value: isLoading ? '...' : formatNumber(statsData?.female_profiles), 
      label: "Female Profiles", 
      color: "text-accent-foreground" 
    },
    { 
      icon: Trophy, 
      value: isLoading ? '...' : formatNumber(statsData?.success_stories), 
      label: "Success Stories", 
      color: "text-success" 
    },
  ];

  return (
    <section className="py-16 bg-muted/50">
      <div className="container mx-auto px-4">
        <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
          {stats.map((stat, index) => (
            <div
              key={index}
              className="text-center glass rounded-2xl p-6 hover-lift animate-fade-up"
              style={{ animationDelay: `${index * 0.1}s` }}
            >
              <div className={`inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary/10 mb-4`}>
                {isLoading ? (
                  <Loader2 className="h-8 w-8 animate-spin text-primary" />
                ) : (
                  <stat.icon className={`h-8 w-8 ${stat.color}`} />
                )}
              </div>
              <div className="text-3xl md:text-4xl font-serif font-bold gradient-text mb-2">
                {stat.value}
              </div>
              <div className="text-muted-foreground font-medium">
                {stat.label}
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default StatsSection;
