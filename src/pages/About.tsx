import Header from "@/components/matrimony/Header";
import Footer from "@/components/matrimony/Footer";
import { usePageContent } from "@/hooks/usePageContent";
import { Heart, Users, Shield, Award, CheckCircle } from "lucide-react";

const About = () => {
  const { getPageContent } = usePageContent();
  const pageData = getPageContent("about-us");

  const hasRichContent = pageData.content?.body?.includes("<");

  const features = [
    {
      icon: Users,
      title: "Large Community",
      description: "Connect with thousands of verified Buddhist profiles from across India.",
    },
    {
      icon: Shield,
      title: "100% Verified",
      description: "Every profile is manually verified to ensure authenticity and safety.",
    },
    {
      icon: Award,
      title: "15+ Years Experience",
      description: "Trusted by families for over 15 years in matchmaking excellence.",
    },
  ];

  const values = [
    "Committed to helping Buddhist families find perfect matches",
    "Maintaining highest standards of privacy and security",
    "Personalized matchmaking with cultural understanding",
    "Dedicated customer support throughout your journey",
    "Affordable premium plans for all families",
  ];

  return (
    <div className="min-h-screen bg-background">
      <Header />
      
      {/* Hero Section */}
      <section className="bg-gradient-to-br from-primary/10 to-secondary/10 py-20">
        <div className="container mx-auto px-4 text-center">
          <h1 className="text-4xl md:text-5xl font-serif font-bold text-foreground mb-4">
            {pageData.content?.heading || pageData.page_name}
          </h1>
          <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
            {pageData.content?.subheading}
          </p>
        </div>
      </section>

      {/* Mission Section */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
              <h2 className="text-3xl font-serif font-bold text-foreground mb-6">
                Our Mission
              </h2>
              {hasRichContent ? (
                <div 
                  className="prose prose-lg max-w-none prose-headings:text-foreground prose-p:text-muted-foreground prose-strong:text-foreground prose-ul:text-muted-foreground prose-ol:text-muted-foreground mb-6"
                  dangerouslySetInnerHTML={{ __html: pageData.content?.body || "" }}
                />
              ) : (
                <>
                  <p className="text-muted-foreground mb-6">
                    At Samyak Matrimony, we believe that finding a life partner is one of the most important decisions in life. 
                    Our mission is to help Buddhist families across India find compatible matches.
                  </p>
                  <p className="text-muted-foreground mb-6">
                    Founded with the vision of serving the Buddhist community, we have grown to become the largest and most 
                    trusted platform for Buddhist matrimonial services.
                  </p>
                </>
              )}
              <div className="space-y-3">
                {values.map((value, index) => (
                  <div key={index} className="flex items-start gap-3">
                    <CheckCircle className="h-5 w-5 text-primary mt-0.5 flex-shrink-0" />
                    <span className="text-foreground">{value}</span>
                  </div>
                ))}
              </div>
            </div>
            <div className="bg-gradient-to-br from-primary to-primary/80 rounded-2xl p-8 text-white">
              <Heart className="h-16 w-16 mb-6 fill-white/20" />
              <h3 className="text-2xl font-serif font-bold mb-4">
                Why Choose Us?
              </h3>
              <p className="text-white/80 mb-6">
                We understand the unique needs of the Buddhist community. Our platform is designed with cultural 
                sensitivity and respect for traditions that matter to you.
              </p>
              <div className="grid grid-cols-2 gap-4 text-center">
                <div className="bg-white/10 rounded-lg p-4">
                  <div className="text-3xl font-bold">15K+</div>
                  <div className="text-sm text-white/70">Active Profiles</div>
                </div>
                <div className="bg-white/10 rounded-lg p-4">
                  <div className="text-3xl font-bold">500+</div>
                  <div className="text-sm text-white/70">Happy Marriages</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section className="py-16 bg-muted/30">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl font-serif font-bold text-foreground text-center mb-12">
            What Makes Us Different
          </h2>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            {features.map((feature, index) => (
              <div
                key={index}
                className="bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-md transition-shadow"
              >
                <div className="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                  <feature.icon className="h-8 w-8 text-primary" />
                </div>
                <h3 className="text-xl font-serif font-bold text-foreground mb-2">
                  {feature.title}
                </h3>
                <p className="text-muted-foreground">{feature.description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default About;
