import { motion } from 'framer-motion';
import { Star, Users, Heart } from 'lucide-react';

const TrustIndicators = () => {
  const indicators = [
    {
      icon: <Star className="w-6 h-6 fill-yellow-500 text-yellow-500" />,
      title: "#1 Buddhist Matrimony Service",
    },
    {
      icon: (
        <div className="flex gap-0.5">
          {[...Array(5)].map((_, i) => (
            <Star key={i} className="w-4 h-4 fill-yellow-500 text-yellow-500" />
          ))}
        </div>
      ),
      title: "4.8★ Ratings by 50,000+ users",
    },
    {
      icon: <Heart className="w-6 h-6 fill-accent text-accent" />,
      title: "10,000+ Success Stories",
    },
  ];

  return (
    <div className="bg-foreground text-background py-6 overflow-hidden">
      <div className="relative">
        {/* Infinite scroll animation */}
        <motion.div
          className="flex gap-12 md:gap-20 whitespace-nowrap"
          animate={{
            x: [0, -1000],
          }}
          transition={{
            x: {
              repeat: Infinity,
              repeatType: "loop",
              duration: 30,
              ease: "linear",
            },
          }}
        >
          {/* Repeat indicators 3 times for seamless loop */}
          {[...Array(3)].map((_, repeatIndex) => (
            <div key={repeatIndex} className="flex gap-12 md:gap-20">
              {indicators.map((indicator, index) => (
                <div
                  key={`${repeatIndex}-${index}`}
                  className="flex items-center gap-3 px-6"
                >
                  <div className="flex-shrink-0">{indicator.icon}</div>
                  <span className="font-semibold text-sm md:text-base">
                    {indicator.title}
                  </span>
                  {index < indicators.length - 1 && (
                    <div className="h-8 w-px bg-background/30 ml-6" />
                  )}
                </div>
              ))}
            </div>
          ))}
        </motion.div>
      </div>
    </div>
  );
};

export default TrustIndicators;
