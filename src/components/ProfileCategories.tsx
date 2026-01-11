import { motion } from 'framer-motion';
import { GraduationCap, Briefcase, Stethoscope, MapPin, Globe, Users } from 'lucide-react';
import { Card } from '@/components/ui/card';

const categories = [
  { icon: GraduationCap, title: "Engineers", count: "2,450", color: "text-blue-500" },
  { icon: Briefcase, title: "IT Professionals", count: "1,820", color: "text-purple-500" },
  { icon: Stethoscope, title: "Doctors", count: "980", color: "text-red-500" },
  { icon: GraduationCap, title: "MBA Graduates", count: "1,340", color: "text-green-500" },
  { icon: MapPin, title: "Mumbai", count: "5,600", color: "text-orange-500" },
  { icon: MapPin, title: "Delhi NCR", count: "4,200", color: "text-pink-500" },
  { icon: MapPin, title: "Pune", count: "3,100", color: "text-teal-500" },
  { icon: Globe, title: "NRI / Abroad", count: "1,200", color: "text-indigo-500" },
];

const ProfileCategories = () => {
  return (
    <section className="py-20 bg-muted/30">
      <div className="container mx-auto px-4">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <h2 className="text-4xl md:text-5xl font-bold mb-4">
            Browse by <span className="gradient-text">Preference</span>
          </h2>
          <p className="text-xl text-muted-foreground max-w-2xl mx-auto">
            Find your perfect match from our diverse community of verified profiles
          </p>
        </motion.div>

        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          {categories.map((category, index) => {
            const Icon = category.icon;
            return (
              <motion.div
                key={category.title}
                initial={{ opacity: 0, scale: 0.9 }}
                whileInView={{ opacity: 1, scale: 1 }}
                viewport={{ once: true }}
                transition={{ delay: index * 0.05 }}
              >
                <Card className="p-6 hover-lift cursor-pointer group bg-card/80 backdrop-blur-sm border-2 hover:border-primary/50 transition-all">
                  <div className="flex flex-col items-center text-center">
                    <div className="w-16 h-16 rounded-full bg-muted/50 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                      <Icon className={`w-8 h-8 ${category.color}`} />
                    </div>
                    
                    <h3 className="font-bold text-lg mb-2 group-hover:text-primary transition-colors">
                      {category.title}
                    </h3>
                    
                    <div className="flex items-center gap-2 text-muted-foreground">
                      <Users className="w-4 h-4" />
                      <span className="text-sm font-medium">{category.count} profiles</span>
                    </div>
                  </div>
                </Card>
              </motion.div>
            );
          })}
        </div>
      </div>
    </section>
  );
};

export default ProfileCategories;
