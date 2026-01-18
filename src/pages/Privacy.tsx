import Header from "@/components/matrimony/Header";
import Footer from "@/components/matrimony/Footer";
import { usePageContent } from "@/hooks/usePageContent";
import { Shield } from "lucide-react";

const Privacy = () => {
  const { getPageContent } = usePageContent();
  const pageData = getPageContent("privacy-policy");

  const hasRichContent = pageData.content?.body?.includes("<");

  return (
    <div className="min-h-screen bg-background">
      <Header />
      
      {/* Hero Section */}
      <section className="bg-gradient-to-br from-primary/10 to-secondary/10 py-16">
        <div className="container mx-auto px-4 text-center">
          <Shield className="h-12 w-12 text-primary mx-auto mb-4" />
          <h1 className="text-4xl md:text-5xl font-serif font-bold text-foreground mb-4">
            {pageData.content?.heading || pageData.page_name}
          </h1>
          <p className="text-muted-foreground">{pageData.content?.subheading}</p>
        </div>
      </section>

      {/* Content */}
      <section className="py-16">
        <div className="container mx-auto px-4 max-w-4xl">
          {hasRichContent ? (
            <div 
              className="prose prose-lg max-w-none prose-headings:text-foreground prose-p:text-muted-foreground prose-strong:text-foreground prose-ul:text-muted-foreground prose-ol:text-muted-foreground prose-blockquote:text-muted-foreground prose-blockquote:border-primary"
              dangerouslySetInnerHTML={{ __html: pageData.content?.body || "" }}
            />
          ) : (
            <div className="prose prose-lg max-w-none">
              <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
                1. Information We Collect
              </h2>
              <p className="text-muted-foreground mb-6">
                We collect information you provide directly to us, including your name, email address, phone number, 
                date of birth, photographs, and other profile information.
              </p>

              <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
                2. How We Use Your Information
              </h2>
              <p className="text-muted-foreground mb-6">
                We use the information we collect to provide, maintain, and improve our services, to process 
                transactions and send related information.
              </p>

              <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
                3. Data Security
              </h2>
              <p className="text-muted-foreground mb-6">
                We take reasonable measures to help protect information about you from loss, theft, misuse, 
                unauthorized access, disclosure, alteration, and destruction.
              </p>

              <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
                4. Contact Us
              </h2>
              <p className="text-muted-foreground mb-6">
                If you have any questions about this Privacy Policy, please contact us at privacy@samyakmatrimony.com.
              </p>
            </div>
          )}
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Privacy;
