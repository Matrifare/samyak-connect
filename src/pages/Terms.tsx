import Header from "@/components/matrimony/Header";
import Footer from "@/components/matrimony/Footer";
import { usePageContent } from "@/hooks/usePageContent";
import { FileText } from "lucide-react";

const Terms = () => {
  const { getPageContent } = usePageContent();
  const pageData = getPageContent("terms-conditions");

  return (
    <div className="min-h-screen bg-background">
      <Header />
      
      {/* Hero Section */}
      <section className="bg-gradient-to-br from-primary/10 to-secondary/10 py-16">
        <div className="container mx-auto px-4 text-center">
          <FileText className="h-12 w-12 text-primary mx-auto mb-4" />
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
              1. Acceptance of Terms
            </h2>
            <p className="text-muted-foreground mb-6">
              By accessing and using Samyak Matrimony, you accept and agree to be bound by these Terms and 
              Conditions. If you do not agree to these terms, please do not use our services.
            </p>

            <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
              2. Eligibility
            </h2>
            <p className="text-muted-foreground mb-6">
              You must be at least 18 years old (21 for males, 18 for females as per Indian law) to register 
              on our platform. You must be legally single (unmarried, divorced, or widowed) to use our services.
            </p>

            <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
              3. User Accounts
            </h2>
            <p className="text-muted-foreground mb-6">
              You are responsible for maintaining the confidentiality of your account credentials. You agree 
              to provide accurate, current, and complete information during registration and to update such 
              information to keep it accurate.
            </p>

            <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
              4. Code of Conduct
            </h2>
            <p className="text-muted-foreground mb-6">
              Users must not post false, misleading, or offensive content. Harassment, abuse, or any form of 
              misconduct towards other users is strictly prohibited and may result in account termination.
            </p>

            <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
              5. Membership & Payments
            </h2>
            <p className="text-muted-foreground mb-6">
              Premium membership fees are non-refundable except as specified in our Refund Policy. We reserve 
              the right to change our pricing at any time with prior notice to existing members.
            </p>

            <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
              6. Limitation of Liability
            </h2>
            <p className="text-muted-foreground mb-6">
              Samyak Matrimony acts as a platform to connect individuals. We do not guarantee matches or 
              marriage outcomes. Users are responsible for verifying information and conducting due diligence.
            </p>

            <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
              7. Termination
            </h2>
            <p className="text-muted-foreground mb-6">
              We reserve the right to suspend or terminate accounts that violate these terms or engage in 
              fraudulent or harmful activities without prior notice.
            </p>
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Terms;
