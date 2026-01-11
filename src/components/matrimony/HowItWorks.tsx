import { UserPlus, Search, Heart, MessageCircle } from "lucide-react";

const steps = [
  {
    icon: UserPlus,
    title: "Register Free",
    description: "Create your profile in just a few minutes with your basic details and preferences.",
    step: "01"
  },
  {
    icon: Search,
    title: "Search Matches",
    description: "Browse through thousands of verified Buddhist profiles using our advanced search filters.",
    step: "02"
  },
  {
    icon: Heart,
    title: "Send Interest",
    description: "Express your interest to profiles you like and wait for them to accept.",
    step: "03"
  },
  {
    icon: MessageCircle,
    title: "Connect & Chat",
    description: "Once interest is accepted, start chatting and take the relationship forward.",
    step: "04"
  },
];

const HowItWorks = () => {
  return (
    <section className="py-20 bg-muted/30">
      <div className="container mx-auto px-4">
        <div className="text-center mb-12">
          <h2 className="text-3xl md:text-4xl font-serif font-bold gradient-text mb-4">
            How It Works
          </h2>
          <p className="text-muted-foreground max-w-2xl mx-auto">
            Find your perfect match in 4 simple steps
          </p>
        </div>
        
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          {steps.map((step, index) => (
            <div
              key={index}
              className="relative text-center animate-fade-up"
              style={{ animationDelay: `${index * 0.1}s` }}
            >
              {/* Connector Line */}
              {index < steps.length - 1 && (
                <div className="hidden lg:block absolute top-16 left-1/2 w-full h-0.5 bg-gradient-to-r from-primary to-secondary" />
              )}
              
              <div className="relative z-10">
                <div className="inline-flex items-center justify-center w-32 h-32 rounded-full glass mb-6 hover-scale">
                  <div className="absolute -top-2 -right-2 w-10 h-10 rounded-full bg-gradient-primary flex items-center justify-center text-white font-bold text-sm">
                    {step.step}
                  </div>
                  <step.icon className="h-12 w-12 text-primary" />
                </div>
                
                <h3 className="text-xl font-serif font-bold mb-3 text-foreground">
                  {step.title}
                </h3>
                <p className="text-muted-foreground">
                  {step.description}
                </p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default HowItWorks;
