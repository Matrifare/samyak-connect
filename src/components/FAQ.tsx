import { motion } from 'framer-motion';
import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from '@/components/ui/accordion';

const FAQ = () => {
  const faqs = [
    {
      question: "Why is Samyakmatrimony better compared to other matrimonial websites?",
      answer: "Samyakmatrimony is India's premier Buddhist matrimony platform, exclusively dedicated to the Buddhist community. Unlike generic matrimonial sites, we offer verified profiles, personalized matchmaking within Buddhist traditions, and advanced search tools that help you find compatible partners who share your values and beliefs. Our focus on authenticity, safety, and meaningful connections makes us the trusted choice for Buddhist singles."
    },
    {
      question: "Is Samyakmatrimony a trustworthy matchmaking platform?",
      answer: "Yes, Samyakmatrimony is a highly trustworthy platform with rigorous profile verification, robust security measures, and thousands of success stories. We go beyond traditional matrimony sites by offering a modern, personalized approach specifically tailored for the Buddhist community, ensuring a safe and reliable experience in finding your life partner."
    },
    {
      question: "What is the difference between free membership vs paid membership?",
      answer: "Free Membership allows you to create a profile, browse other profiles, and send interests with basic search filters. Paid membership offers much more - you can initiate and respond to messages, access advanced search filters, get priority customer support, profile boosts, and contact information of interested members, making finding 'the one' significantly easier."
    },
    {
      question: "What additional benefits do I get as a Premium Member?",
      answer: "Premium members can initiate and respond to unlimited messages, access advanced search filters with detailed preferences, receive priority customer support, get profile boosts for increased visibility, and access contact information of interested members. These features dramatically increase your chances of finding your perfect match."
    },
    {
      question: "How can I contact other members on Samyakmatrimony?",
      answer: "With a premium membership, you can chat directly through our messaging system, make video calls on the app, and get contact details for interested members to take conversations forward on your preferred platform including WhatsApp."
    }
  ];

  return (
    <section className="py-20 bg-background">
      <div className="container mx-auto px-4">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.6 }}
          className="max-w-4xl mx-auto"
        >
          <h2 className="text-4xl md:text-5xl font-bold text-center mb-12">
            Frequently Asked Questions
          </h2>

          <Accordion type="single" collapsible className="space-y-4">
            {faqs.map((faq, index) => (
              <AccordionItem
                key={index}
                value={`item-${index}`}
                className="bg-card border border-border rounded-2xl px-6 hover:shadow-lg transition-all"
              >
                <AccordionTrigger className="text-left text-lg font-semibold py-6 hover:no-underline">
                  <span className="text-primary mr-4 font-bold">0{index + 1}</span>
                  {faq.question}
                </AccordionTrigger>
                <AccordionContent className="text-muted-foreground pb-6 leading-relaxed">
                  {faq.answer}
                </AccordionContent>
              </AccordionItem>
            ))}
          </Accordion>
        </motion.div>
      </div>
    </section>
  );
};

export default FAQ;
