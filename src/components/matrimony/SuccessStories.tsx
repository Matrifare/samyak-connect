import { Quote } from "lucide-react";
import { Button } from "@/components/ui/button";
import couple1 from "@/assets/couple-1.jpg";
import couple2 from "@/assets/couple-2.jpg";
import couple3 from "@/assets/couple-3.jpg";

const stories = [
  {
    id: 1,
    names: "Priya & Rahul",
    location: "Mumbai",
    date: "Married in 2024",
    quote: "We found each other on Samyak Matrimony and knew instantly that we were meant to be. Thank you for helping us find our soulmate!",
    image: couple1
  },
  {
    id: 2,
    names: "Sneha & Amit",
    location: "Pune",
    date: "Married in 2024",
    quote: "The platform made it so easy to connect with like-minded Buddhist singles. We are grateful for this beautiful journey together.",
    image: couple2
  },
  {
    id: 3,
    names: "Anjali & Vikram",
    location: "Nagpur",
    date: "Married in 2023",
    quote: "From the first message to our wedding day, Samyak Matrimony was with us every step of the way. Highly recommended!",
    image: couple3
  },
];

const SuccessStories = () => {
  return (
    <section className="py-20">
      <div className="container mx-auto px-4">
        <div className="text-center mb-12">
          <h2 className="text-3xl md:text-4xl font-serif font-bold gradient-text mb-4">
            Success Stories
          </h2>
          <p className="text-muted-foreground max-w-2xl mx-auto">
            Real couples who found their happily ever after through Samyak Matrimony
          </p>
        </div>
        
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {stories.map((story, index) => (
            <div
              key={story.id}
              className="glass rounded-2xl overflow-hidden hover-lift animate-fade-up"
              style={{ animationDelay: `${index * 0.1}s` }}
            >
              <div className="aspect-square overflow-hidden">
                <img
                  src={story.image}
                  alt={story.names}
                  className="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                />
              </div>
              
              <div className="p-6">
                <Quote className="h-8 w-8 text-primary/30 mb-4" />
                <p className="text-muted-foreground italic mb-4 line-clamp-3">
                  "{story.quote}"
                </p>
                <div className="border-t border-border pt-4">
                  <h4 className="font-serif font-bold text-lg text-foreground">
                    {story.names}
                  </h4>
                  <p className="text-sm text-muted-foreground">
                    {story.location} • {story.date}
                  </p>
                </div>
              </div>
            </div>
          ))}
        </div>
        
        <div className="text-center mt-12">
          <Button variant="outline" size="lg" className="border-primary text-primary hover:bg-primary hover:text-white">
            Read More Stories
          </Button>
        </div>
      </div>
    </section>
  );
};

export default SuccessStories;
