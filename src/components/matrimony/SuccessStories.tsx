import { useState } from "react";
import { Quote, ChevronLeft, ChevronRight } from "lucide-react";
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
  const [currentIndex, setCurrentIndex] = useState(0);

  const handlePrev = () => {
    setCurrentIndex((prev) => (prev === 0 ? stories.length - 1 : prev - 1));
  };

  const handleNext = () => {
    setCurrentIndex((prev) => (prev === stories.length - 1 ? 0 : prev + 1));
  };

  const progressPercentage = ((currentIndex + 1) / stories.length) * 100;

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
        
        {/* Mobile Carousel View - visible below md breakpoint (768px) */}
        <div className="md:hidden">
          <div className="relative overflow-hidden">
            <div 
              className="flex transition-transform duration-300 ease-in-out"
              style={{ transform: `translateX(-${currentIndex * 100}%)` }}
            >
              {stories.map((story) => (
                <div
                  key={story.id}
                  className="w-full flex-shrink-0 px-2"
                >
                  <div className="bg-card rounded-2xl overflow-hidden shadow-lg">
                    <div className="aspect-square overflow-hidden">
                      <img
                        src={story.image}
                        alt={story.names}
                        className="w-full h-full object-cover"
                      />
                    </div>
                    
                    <div className="p-6">
                      <Quote className="h-8 w-8 text-primary/30 mb-4" />
                      <p className="text-muted-foreground italic mb-4 line-clamp-4">
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
                </div>
              ))}
            </div>
          </div>
          
          {/* Progress Bar */}
          <div className="mt-4 mx-2">
            <div className="h-1 bg-muted rounded-full overflow-hidden">
              <div 
                className="h-full bg-primary transition-all duration-300 ease-in-out rounded-full"
                style={{ width: `${progressPercentage}%` }}
              />
            </div>
          </div>
          
          {/* Navigation Arrows */}
          <div className="flex justify-center items-center gap-4 mt-4">
            <button
              onClick={handlePrev}
              className="w-10 h-10 rounded-full border border-border flex items-center justify-center hover:bg-muted transition-colors"
              aria-label="Previous story"
            >
              <ChevronLeft className="h-5 w-5 text-muted-foreground" />
            </button>
            <button
              onClick={handleNext}
              className="w-10 h-10 rounded-full border border-border flex items-center justify-center hover:bg-muted transition-colors"
              aria-label="Next story"
            >
              <ChevronRight className="h-5 w-5 text-muted-foreground" />
            </button>
          </div>
        </div>
        
        {/* Desktop Grid View - visible at md breakpoint and above */}
        <div className="hidden md:grid md:grid-cols-3 gap-8">
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
