import { motion } from 'framer-motion';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';

const stories = [
  {
    id: 1,
    names: "Rahul & Priya",
    story: "Thank you Samyakmatrimony! I found my soulmate here. After chatting, we involved our families—now we're happily engaged and planning our Buddhist wedding!",
    image: "https://images.unsplash.com/photo-1606800052052-a08af7148866?w=800&auto=format&fit=crop&q=80"
  },
  {
    id: 2,
    names: "Amit & Sneha",
    story: "We met on Samyakmatrimony and found our perfect match. Thank you for helping me find my soulmate and begin this beautiful new chapter of life!",
    image: "https://images.unsplash.com/photo-1591604466107-ec97de577aff?w=800&auto=format&fit=crop&q=80"
  },
  {
    id: 3,
    names: "Vikram & Anjali",
    story: "Swipe, match, chat—our bond on Samyakmatrimony was instant. From shared Buddhist values to laughter and dreams, we just clicked. After meeting, we knew it was meant to be.",
    image: "https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=800&auto=format&fit=crop&q=80"
  },
  {
    id: 4,
    names: "Sanjay & Deepa",
    story: "Thanks to Samyakmatrimony, my life has truly settled. Grateful to have found my partner through this platform.",
    image: "https://images.unsplash.com/photo-1522673607200-164d1b6ce486?w=800&auto=format&fit=crop&q=80"
  }
];

const SuccessStories = () => {
  return (
    <section className="py-20 bg-background">
      <div className="container mx-auto px-4">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-12"
        >
          <h2 className="text-4xl md:text-5xl font-bold mb-4">
            Real Stories, True Connections
          </h2>
          <p className="text-muted-foreground text-lg max-w-2xl mx-auto mb-6">
            Discover how Samyakmatrimony has brought together couples through meaningful 
            connections and shared journeys. Your success story could be next!
          </p>
          <Button variant="link" className="text-primary text-lg">
            Know more →
          </Button>
        </motion.div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
          {stories.map((story, index) => (
            <motion.div
              key={story.id}
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: index * 0.1 }}
            >
              <Card className="overflow-hidden hover:shadow-xl transition-all border-2 hover:border-primary/30 group cursor-pointer">
                <div className="relative h-64 overflow-hidden">
                  <img
                    src={story.image}
                    alt={story.names}
                    className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent" />
                </div>
                <div className="p-6">
                  <h3 className="text-xl font-bold mb-3 text-primary">
                    {story.names}
                  </h3>
                  <p className="text-muted-foreground text-sm leading-relaxed line-clamp-4">
                    {story.story}
                  </p>
                </div>
              </Card>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default SuccessStories;
