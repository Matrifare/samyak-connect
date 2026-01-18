import Header from "@/components/matrimony/Header";
import Footer from "@/components/matrimony/Footer";
import { usePageContent } from "@/hooks/usePageContent";
import { FileText } from "lucide-react";

const Terms = () => {
  const { getPageContent } = usePageContent();
  const pageData = getPageContent("terms-conditions");

  const paragraphs = pageData.content?.body?.split("\n\n").filter(Boolean) || [];

  return (
    <div className="min-h-screen bg-background">
      <Header />
      
      {/* Hero Section */}
      <section className="bg-gradient-to-br from-primary/10 to-secondary/10 py-16">
        <div className="container mx-auto px-4 text-center">
          <FileText className="h-12 w-12 text-primary mx-auto mb-4" />
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
                  1. Acceptance of Terms
                </h2>
                <p className="text-muted-foreground mb-6">
                  By accessing and using Samyak Matrimony, you accept and agree to be bound by these Terms and Conditions.
                </p>

                <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
                  2. Eligibility
                </h2>
                <p className="text-muted-foreground mb-6">
                  You must be at least 18 years old (21 for males, 18 for females as per Indian law) to register on our platform.
                </p>

                <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
                  3. User Accounts
                </h2>
                <p className="text-muted-foreground mb-6">
                  You are responsible for maintaining the confidentiality of your account credentials.
                </p>
              </>
            )}
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Terms;
