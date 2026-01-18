import Header from "@/components/matrimony/Header";
import Footer from "@/components/matrimony/Footer";
import { usePageContent } from "@/hooks/usePageContent";
import { CreditCard } from "lucide-react";

const Refund = () => {
  const { getPageContent } = usePageContent();
  const pageData = getPageContent("refund-policy");

  return (
    <div className="min-h-screen bg-background">
      <Header />
      
      {/* Hero Section */}
      <section className="bg-gradient-to-br from-primary/10 to-secondary/10 py-16">
        <div className="container mx-auto px-4 text-center">
          <CreditCard className="h-12 w-12 text-primary mx-auto mb-4" />
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
              1. Refund Eligibility
            </h2>
            <p className="text-muted-foreground mb-6">
              Refunds may be requested within 7 days of purchase if you have not used any premium features. 
              Once you have viewed contact details or sent messages using premium features, the subscription 
              is considered used and is not eligible for a refund.
            </p>

            <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
              2. Refund Process
            </h2>
            <p className="text-muted-foreground mb-6">
              To request a refund, please contact our support team at support@samyakmatrimony.com with your 
              registered email, transaction ID, and reason for refund. Our team will review your request 
              within 3-5 business days.
            </p>

            <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
              3. Refund Timeline
            </h2>
            <p className="text-muted-foreground mb-6">
              Once approved, refunds will be processed within 7-10 business days. The amount will be credited 
              to the original payment method used during purchase.
            </p>

            <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
              4. Non-Refundable Cases
            </h2>
            <ul className="list-disc pl-6 text-muted-foreground mb-6 space-y-2">
              <li>Subscriptions older than 7 days from purchase date</li>
              <li>Accounts that have used premium features (viewed contacts, sent messages)</li>
              <li>Accounts suspended or terminated for policy violations</li>
              <li>Promotional or discounted memberships</li>
              <li>Partial refunds for unused duration of subscription</li>
            </ul>

            <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
              5. Cancellation
            </h2>
            <p className="text-muted-foreground mb-6">
              You can cancel your subscription at any time from your account settings. Upon cancellation, 
              you will continue to have access to premium features until the end of your current billing 
              period. No refund will be provided for the remaining period.
            </p>

            <h2 className="text-2xl font-serif font-bold text-foreground mb-4">
              6. Contact Us
            </h2>
            <p className="text-muted-foreground mb-6">
              For any refund-related queries, please contact us at:
            </p>
            <div className="bg-muted/30 p-6 rounded-lg">
              <p className="text-foreground">
                <strong>Email:</strong> refunds@samyakmatrimony.com<br />
                <strong>Phone:</strong> +91 98765 43210<br />
                <strong>Working Hours:</strong> Mon-Sat, 10 AM - 6 PM IST
              </p>
            </div>
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Refund;
