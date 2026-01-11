import { motion } from 'framer-motion';
import { Quote } from 'lucide-react';

const FounderQuote = () => {
  return (
    <section className="py-20 bg-gradient-to-br from-primary/5 via-accent/5 to-secondary/5">
      <div className="container mx-auto px-4">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.6 }}
          className="max-w-4xl mx-auto text-center"
        >
          <Quote className="w-16 h-16 text-primary mx-auto mb-6 opacity-50" />
          
          <blockquote className="text-2xl md:text-3xl font-serif text-foreground leading-relaxed mb-8">
            "At Samyakmatrimony, it is our life's mission to use technology for good and 
            bring meaningful relationships to the Buddhist community, guided by the principles 
            of compassion, understanding, and shared values."
          </blockquote>
          
          <div className="flex items-center justify-center gap-4">
            <div className="w-16 h-16 rounded-full bg-gradient-primary flex items-center justify-center text-white font-bold text-xl">
              SM
            </div>
            <div className="text-left">
              <div className="font-bold text-lg text-foreground">Founder</div>
              <div className="text-sm text-muted-foreground">Samyakmatrimony</div>
            </div>
          </div>
        </motion.div>
      </div>
    </section>
  );
};

export default FounderQuote;
