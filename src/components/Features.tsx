import { motion } from 'framer-motion';
import { Shield, MessageCircle, Lock } from 'lucide-react';

const Features = () => {
  const features = [
    {
      icon: <Shield className="w-16 h-16" />,
      title: "100% Verified Profiles",
      description: "Get matched with verified Buddhist singles. Every profile is authenticated for your safety and peace of mind."
    },
    {
      icon: <MessageCircle className="w-16 h-16" />,
      title: "Premium Matchmaking",
      description: "Experience personalized matchmaking with advanced AI-powered algorithms that understand your preferences and values."
    },
    {
      icon: <Lock className="w-16 h-16" />,
      title: "Privacy & Security First",
      description: "Your data is encrypted and protected. Control visibility and share information only when you're comfortable."
    }
  ];

  return (
    <section className="py-20 bg-gradient-to-b from-background to-muted/30">
      <div className="container mx-auto px-4">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <h2 className="text-4xl md:text-5xl font-bold mb-4">
            The Samyakmatrimony Experience
          </h2>
        </motion.div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
          {features.map((feature, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: index * 0.2 }}
              className="bg-card p-8 rounded-3xl hover:shadow-2xl transition-all border border-border"
            >
              <div className="flex justify-center mb-6 text-primary">
                {feature.icon}
              </div>
              <h3 className="text-2xl font-bold mb-4 text-center">{feature.title}</h3>
              <p className="text-muted-foreground leading-relaxed text-center">
                {feature.description}
              </p>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default Features;
