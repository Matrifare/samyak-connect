import Header from "@/components/matrimony/Header";
import Footer from "@/components/matrimony/Footer";
import { usePageContent } from "@/hooks/usePageContent";
import { HelpCircle } from "lucide-react";
import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from "@/components/ui/accordion";

const faqs = [
  {
    question: "How do I register on Samyak Matrimony?",
    answer: "Registration is free and easy. Click on the 'Register' button, fill in your basic details, verify your email/phone, and complete your profile. You can start searching for matches immediately after registration.",
  },
  {
    question: "Is my information safe and private?",
    answer: "Yes, we take your privacy very seriously. Your contact information is hidden until you choose to share it. We use industry-standard encryption to protect your data. You can control what information is visible on your profile.",
  },
  {
    question: "How are profiles verified?",
    answer: "We have a dedicated team that manually verifies profiles. We check photo authenticity, phone numbers, and email addresses. Premium members undergo additional verification for enhanced trust.",
  },
  {
    question: "What is included in the free membership?",
    answer: "Free members can create a profile, upload photos, search profiles, and send limited interests. To view contact details and send unlimited messages, you'll need to upgrade to a premium membership.",
  },
  {
    question: "How do I upgrade to premium membership?",
    answer: "Go to the Membership section in your dashboard and choose a plan that suits you. We offer monthly, quarterly, and annual plans. Payment can be made via credit/debit card, UPI, or net banking.",
  },
  {
    question: "Can I hide my profile temporarily?",
    answer: "Yes, you can hide your profile at any time from your account settings. Your profile will not appear in search results while hidden, but you can still browse other profiles.",
  },
  {
    question: "How do I delete my account?",
    answer: "You can delete your account from the Settings page in your dashboard. Please note that account deletion is permanent and all your data will be removed from our servers.",
  },
  {
    question: "What should I do if I find a fake profile?",
    answer: "Please report any suspicious or fake profiles using the 'Report' button on their profile. Our team will investigate and take appropriate action within 24-48 hours.",
  },
];

const FAQ = () => {
  const { getPageContent } = usePageContent();
  const pageData = getPageContent("faq");

  return (
    <div className="min-h-screen bg-background">
      <Header />
      
      {/* Hero Section */}
      <section className="bg-gradient-to-br from-primary/10 to-secondary/10 py-16">
        <div className="container mx-auto px-4 text-center">
          <HelpCircle className="h-12 w-12 text-primary mx-auto mb-4" />
          <h1 className="text-4xl md:text-5xl font-serif font-bold text-foreground mb-4">
            {pageData.page_name}
          </h1>
          <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
            Find answers to commonly asked questions about Samyak Matrimony
          </p>
        </div>
      </section>

      {/* FAQ Content */}
      <section className="py-16">
        <div className="container mx-auto px-4 max-w-3xl">
          <Accordion type="single" collapsible className="space-y-4">
            {faqs.map((faq, index) => (
              <AccordionItem
                key={index}
                value={`item-${index}`}
                className="bg-white rounded-lg border shadow-sm px-6"
              >
                <AccordionTrigger className="text-left font-medium text-foreground hover:no-underline">
                  {faq.question}
                </AccordionTrigger>
                <AccordionContent className="text-muted-foreground">
                  {faq.answer}
                </AccordionContent>
              </AccordionItem>
            ))}
          </Accordion>

          {/* Contact CTA */}
          <div className="mt-12 text-center p-8 bg-muted/30 rounded-2xl">
            <h3 className="text-xl font-serif font-bold text-foreground mb-2">
              Still have questions?
            </h3>
            <p className="text-muted-foreground mb-4">
              Can't find the answer you're looking for? Please contact our support team.
            </p>
            <a
              href="/contact"
              className="inline-block bg-primary text-white px-6 py-2 rounded-full hover:bg-primary/90 transition-colors"
            >
              Contact Us
            </a>
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default FAQ;
