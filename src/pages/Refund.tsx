import Header from "@/components/matrimony/Header";
import Footer from "@/components/matrimony/Footer";
import { usePageContent } from "@/hooks/usePageContent";
import { CreditCard } from "lucide-react";

const Refund = () => {
  const { getPageContent } = usePageContent();
  const pageData = getPageContent("refund-policy");

  const paragraphs = pageData.content?.body?.split("\n\n").filter(Boolean) || [];

  return (
    <div className="min-h-screen bg-background">
      <Header />
      
      {/* Hero Section */}
      <section className="bg-gradient-to-br from-primary/10 to-secondary/10 py-16">
        <div className="container mx-auto px-4 text-center">
          <CreditCard className="h-12 w-12 text-primary mx-auto mb-4" />
          <h1 className="text-4xl md:text-5xl font-serif font-bold text-foreground mb-4">
            {pageData.content?.heading || pageData.page_name}
          </h1>
          <p className="text-muted-foreground">{pageData.content?.subheading}</p>
        </div>
      </section>

      {/* Content */}
      <section className="py-16">
        <div className="container mx-auto px-4 max-w-4xl">
          <div className="prose prose-lg max-w-none">
            {paragraphs.length > 0 ? (
              paragraphs.map((paragraph, index) => (
                <p key={index} className="text-muted-foreground mb-6">
                  {paragraph}
                </p>
              ))
            ) : (
              <>
                <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
                  1. Refund Eligibility
                </h2>
                <p className="text-muted-foreground mb-6">
                  Refunds may be requested within 7 days of purchase if you have not used any premium features.
                </p>

                <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
                  2. Refund Process
                </h2>
                <p className="text-muted-foreground mb-6">
                  To request a refund, please contact our support team with your registered email and transaction ID.
                </p>

                <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
                  3. Contact Us
                </h2>
                <div className="bg-muted/30 p-6 rounded-lg">
                  <p className="text-foreground">
                    <strong>Email:</strong> refunds@samyakmatrimony.com<br />
                    <strong>Phone:</strong> +91 98765 43210
                  </p>
                </div>
              </>
            )}
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Refund;
