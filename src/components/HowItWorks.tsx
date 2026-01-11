import { motion } from 'framer-motion';
import { UserPlus, Filter, MessageCircleHeart, PartyPopper } from 'lucide-react';

const steps = [
  {
    icon: UserPlus,
    title: "Create Profile",
    description: "Sign up and create your detailed profile with photos and preferences in minutes"
  },
  {
    icon: Filter,
    title: "Search & Filter",
    description: "Use advanced filters to find matches that align with your values and preferences"
  },
  {
    icon: MessageCircleHeart,
    title: "Connect & Chat",
    description: "Express interest and start meaningful conversations with verified matches"
  },
  {
    icon: PartyPopper,
    title: "Find Your Match",
    description: "Build a connection and take the next step towards your happily ever after"
  }
];

const HowItWorks = () => {
  return (
    <section className="py-20 bg-gradient-to-b from-background via-muted/20 to-background relative overflow-hidden">
      {/* Decorative elements */}
      <div className="absolute inset-0 opacity-30">
        <div className="absolute top-1/4 left-0 w-64 h-64 bg-primary/10 rounded-full blur-3xl" />
        <div className="absolute bottom-1/4 right-0 w-64 h-64 bg-accent/10 rounded-full blur-3xl" />
      </div>

      <div className="container mx-auto px-4 relative z-10">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <h2 className="text-4xl md:text-5xl font-bold mb-4">
            How It <span className="gradient-text">Works</span>
          </h2>
          <p className="text-xl text-muted-foreground max-w-2xl mx-auto">
            Your journey to finding your life partner is just four simple steps away
          </p>
        </motion.div>

        <div className="max-w-5xl mx-auto">
          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8 relative">
            {/* Connection line - hidden on mobile */}
            <div className="hidden lg:block absolute top-24 left-0 right-0 h-1">
              <div className="h-full bg-gradient-to-r from-primary via-accent to-secondary rounded-full" />
            </div>

            {steps.map((step, index) => {
              const Icon = step.icon;
              return (
                <motion.div
                  key={step.title}
                  initial={{ opacity: 0, scale: 0.8 }}
                  whileInView={{ opacity: 1, scale: 1 }}
                  viewport={{ once: true }}
                  transition={{ delay: index * 0.2 }}
                  className="relative"
                >
                  <div className="flex flex-col items-center text-center">
                    {/* Step Number & Icon */}
                    <div className="relative mb-6">
                      <motion.div
                        initial={{ scale: 0 }}
                        whileInView={{ scale: 1 }}
                        viewport={{ once: true }}
                        transition={{ delay: index * 0.2 + 0.1 }}
                        className="w-24 h-24 rounded-full bg-gradient-primary flex items-center justify-center shadow-lg relative z-10 pulse-glow"
                      >
                        <Icon className="w-12 h-12 text-white" />
                      </motion.div>
                      
                      {/* Step number badge */}
                      <div className="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-accent text-white font-bold flex items-center justify-center text-sm shadow-lg z-20">
                        {index + 1}
                      </div>
                    </div>

                    {/* Step Content */}
                    <h3 className="text-xl font-bold mb-3">
                      {step.title}
                    </h3>
                    <p className="text-muted-foreground">
                      {step.description}
                    </p>
                  </div>
                </motion.div>
              );
            })}
          </div>
        </div>
      </div>
    </section>
  );
};

export default HowItWorks;
