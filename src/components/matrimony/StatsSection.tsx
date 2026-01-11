import { Users, Heart, UserCheck, Trophy } from "lucide-react";

const stats = [
  { icon: Users, value: "15,000+", label: "Total Profiles", color: "text-primary" },
  { icon: UserCheck, value: "8,500+", label: "Male Profiles", color: "text-secondary" },
  { icon: Heart, value: "6,500+", label: "Female Profiles", color: "text-accent-foreground" },
  { icon: Trophy, value: "500+", label: "Success Stories", color: "text-success" },
];

const StatsSection = () => {
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
                <stat.icon className={`h-8 w-8 ${stat.color}`} />
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
