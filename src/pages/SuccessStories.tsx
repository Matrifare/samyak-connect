import Header from "@/components/matrimony/Header";
import Footer from "@/components/matrimony/Footer";
import { usePageContent } from "@/hooks/usePageContent";
import { Heart, Quote } from "lucide-react";

const stories = [
  {
    id: 1,
    names: "Priya & Rahul",
    image: "https://images.unsplash.com/photo-1519741497674-611481863552?w=400",
    quote: "We found each other on Samyak Matrimony and knew instantly that we were meant to be. Thank you for making our dream come true!",
    marriedDate: "March 2024",
  },
  {
    id: 2,
    names: "Sneha & Amit",
    image: "https://images.unsplash.com/photo-1537633552985-df8429e8048b?w=400",
    quote: "After months of searching, we finally found our perfect match. The journey was beautiful and we are grateful forever.",
    marriedDate: "January 2024",
  },
  {
    id: 3,
    names: "Pooja & Vikram",
    image: "https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=400",
    quote: "Samyak Matrimony made our families meet and the rest is history. We couldn't be happier!",
    marriedDate: "December 2023",
  },
  {
    id: 4,
    names: "Anjali & Suresh",
    image: "https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=400",
    quote: "We were skeptical at first, but the platform helped us find true love. Our wedding was a dream come true.",
    marriedDate: "November 2023",
  },
];

const SuccessStories = () => {
  const { getPageContent } = usePageContent();
  const pageData = getPageContent("success-stories");

  return (
    <div className="min-h-screen bg-background">
      <Header />
      
      {/* Hero Section */}
      <section className="bg-gradient-to-br from-primary/10 to-secondary/10 py-20">
        <div className="container mx-auto px-4 text-center">
          <Heart className="h-12 w-12 text-primary mx-auto mb-4 fill-primary" />
          <h1 className="text-4xl md:text-5xl font-serif font-bold text-foreground mb-4">
            {pageData.page_name}
          </h1>
          <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
            Real couples, real love stories. Read how our members found their perfect life partners.
          </p>
        </div>
      </section>

      {/* Stories Grid */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
            {stories.map((story) => (
              <div
                key={story.id}
                className="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow"
              >
                <div className="aspect-video overflow-hidden">
                  <img
                    src={story.image}
                    alt={story.names}
                    className="w-full h-full object-cover"
                  />
                </div>
                <div className="p-6">
                  <div className="flex items-center gap-2 mb-4">
                    <Quote className="h-6 w-6 text-primary" />
                    <h3 className="text-xl font-serif font-bold text-foreground">
                      {story.names}
                    </h3>
                  </div>
                  <p className="text-muted-foreground italic mb-4">
                    "{story.quote}"
                  </p>
                  <p className="text-sm text-primary font-medium">
                    Married: {story.marriedDate}
                  </p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="bg-primary py-16">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-3xl font-serif font-bold text-white mb-4">
            Your Story Could Be Next
          </h2>
          <p className="text-white/80 mb-8 max-w-xl mx-auto">
            Join thousands of happy couples who found their perfect match on Samyak Matrimony.
          </p>
          <a
            href="/register"
            className="inline-block bg-white text-primary px-8 py-3 rounded-full font-medium hover:bg-white/90 transition-colors"
          >
            Register Free Now
          </a>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default SuccessStories;
