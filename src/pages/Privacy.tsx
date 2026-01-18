import Header from "@/components/matrimony/Header";
import Footer from "@/components/matrimony/Footer";
import { usePageContent } from "@/hooks/usePageContent";
import { Shield } from "lucide-react";

const Privacy = () => {
  const { getPageContent } = usePageContent();
  const pageData = getPageContent("privacy-policy");

  return (
    <div className="min-h-screen bg-background">
      <Header />
      
      {/* Hero Section */}
      <section className="bg-gradient-to-br from-primary/10 to-secondary/10 py-16">
        <div className="container mx-auto px-4 text-center">
          <Shield className="h-12 w-12 text-primary mx-auto mb-4" />
          <h1 className="text-4xl md:text-5xl font-serif font-bold text-foreground mb-4">
            {pageData.page_name}
          </h1>
          <p className="text-muted-foreground">Last updated: January 2025</p>
        </div>
      </section>

      {/* Content */}
      <section className="py-16">
        <div className="container mx-auto px-4 max-w-4xl">
          <div className="prose prose-lg max-w-none">
            <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
              1. Information We Collect
            </h2>
            <p className="text-muted-foreground mb-6">
              We collect information you provide directly to us, including your name, email address, phone number, 
              date of birth, photographs, and other profile information. We also collect information about your 
              preferences and partner requirements.
            </p>

            <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
              2. How We Use Your Information
            </h2>
            <p className="text-muted-foreground mb-6">
              We use the information we collect to provide, maintain, and improve our services, to process 
              transactions and send related information, to send you technical notices and support messages, 
              and to respond to your comments and questions.
            </p>

            <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
              3. Information Sharing
            </h2>
            <p className="text-muted-foreground mb-6">
              We do not share your personal information with third parties except as described in this policy. 
              We may share information with your consent, to comply with laws, to protect your rights, or to 
              fulfill business obligations.
            </p>

            <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
              4. Data Security
            </h2>
            <p className="text-muted-foreground mb-6">
              We take reasonable measures to help protect information about you from loss, theft, misuse, 
              unauthorized access, disclosure, alteration, and destruction. All data is encrypted and stored 
              securely on our servers.
            </p>

            <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
              5. Your Rights
            </h2>
            <p className="text-muted-foreground mb-6">
              You have the right to access, update, or delete your personal information at any time. You can 
              do this through your account settings or by contacting our support team.
            </p>

            <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
              6. Contact Us
            </h2>
            <p className="text-muted-foreground mb-6">
              If you have any questions about this Privacy Policy, please contact us at privacy@samyakmatrimony.com 
              or through our contact page.
            </p>
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Privacy;
