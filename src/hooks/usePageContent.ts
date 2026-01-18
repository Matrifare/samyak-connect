import { useState, useEffect } from "react";

export interface PageContent {
  id: string;
  slug: string;
  page_name: string;
  seo_title: string;
  seo_description: string;
  seo_keywords: string;
  content: {
    heading?: string;
    subheading?: string;
    body?: string;
  };
  is_published: boolean;
}

const defaultPages: PageContent[] = [
  {
    id: "1",
    slug: "success-stories",
    page_name: "Success Stories",
    seo_title: "Success Stories - Samyak Matrimony",
    seo_description: "Read inspiring success stories of couples who found love on Samyak Matrimony",
    seo_keywords: "success stories, matrimony, wedding, couples",
    content: {
      heading: "Success Stories",
      subheading: "Real couples, real love stories. Read how our members found their perfect life partners.",
      body: "",
    },
    is_published: true,
  },
  {
    id: "2",
    slug: "about-us",
    page_name: "About Us",
    seo_title: "About Us - Samyak Matrimony",
    seo_description: "Learn about Samyak Matrimony - trusted Buddhist matrimonial service",
    seo_keywords: "about, matrimony, buddhist, wedding service",
    content: {
      heading: "About Us",
      subheading: "Samyak Matrimony is the most trusted Buddhist matrimonial service, dedicated to bringing families together.",
      body: "At Samyak Matrimony, we believe that finding a life partner is one of the most important decisions in life. Our mission is to help Buddhist families across India find compatible matches that share the same values, traditions, and cultural understanding.\n\nFounded with the vision of serving the Buddhist community, we have grown to become the largest and most trusted platform for Buddhist matrimonial services.",
    },
    is_published: true,
  },
  {
    id: "3",
    slug: "contact-us",
    page_name: "Contact Us",
    seo_title: "Contact Us - Samyak Matrimony",
    seo_description: "Get in touch with Samyak Matrimony for queries or support",
    seo_keywords: "contact, support, help, matrimony",
    content: {
      heading: "Contact Us",
      subheading: "We'd love to hear from you. Get in touch with us for any queries or support.",
      body: "",
    },
    is_published: true,
  },
  {
    id: "4",
    slug: "privacy-policy",
    page_name: "Privacy Policy",
    seo_title: "Privacy Policy - Samyak Matrimony",
    seo_description: "Read our privacy policy to understand how we protect your data",
    seo_keywords: "privacy, policy, data protection",
    content: {
      heading: "Privacy Policy",
      subheading: "Last updated: January 2025",
      body: "We collect information you provide directly to us, including your name, email address, phone number, date of birth, photographs, and other profile information.\n\nWe use the information we collect to provide, maintain, and improve our services, to process transactions and send related information.\n\nWe do not share your personal information with third parties except as described in this policy.",
    },
    is_published: true,
  },
  {
    id: "5",
    slug: "terms-conditions",
    page_name: "Terms & Conditions",
    seo_title: "Terms & Conditions - Samyak Matrimony",
    seo_description: "Read our terms and conditions for using Samyak Matrimony services",
    seo_keywords: "terms, conditions, rules, agreement",
    content: {
      heading: "Terms & Conditions",
      subheading: "Last updated: January 2025",
      body: "By accessing and using Samyak Matrimony, you accept and agree to be bound by these Terms and Conditions.\n\nYou must be at least 18 years old (21 for males, 18 for females as per Indian law) to register on our platform.\n\nYou are responsible for maintaining the confidentiality of your account credentials.",
    },
    is_published: true,
  },
  {
    id: "6",
    slug: "faq",
    page_name: "FAQ",
    seo_title: "Frequently Asked Questions - Samyak Matrimony",
    seo_description: "Find answers to common questions about Samyak Matrimony",
    seo_keywords: "faq, questions, help, support",
    content: {
      heading: "Frequently Asked Questions",
      subheading: "Find answers to commonly asked questions about Samyak Matrimony",
      body: "",
    },
    is_published: true,
  },
  {
    id: "7",
    slug: "refund-policy",
    page_name: "Refund Policy",
    seo_title: "Refund Policy - Samyak Matrimony",
    seo_description: "Learn about our refund policy for premium memberships",
    seo_keywords: "refund, policy, payment, membership",
    content: {
      heading: "Refund Policy",
      subheading: "Last updated: January 2025",
      body: "Refunds may be requested within 7 days of purchase if you have not used any premium features.\n\nTo request a refund, please contact our support team at support@samyakmatrimony.com with your registered email, transaction ID, and reason for refund.\n\nOnce approved, refunds will be processed within 7-10 business days.",
    },
    is_published: true,
  },
];

const STORAGE_KEY = "samyak_page_content";

export const usePageContent = () => {
  const [pages, setPages] = useState<PageContent[]>([]);

  useEffect(() => {
    const stored = localStorage.getItem(STORAGE_KEY);
    if (stored) {
      try {
        const parsed = JSON.parse(stored);
        // Merge with defaults to ensure content field exists
        const merged = defaultPages.map((defaultPage) => {
          const storedPage = parsed.find((p: PageContent) => p.id === defaultPage.id);
          if (storedPage) {
            return {
              ...defaultPage,
              ...storedPage,
              content: { ...defaultPage.content, ...storedPage.content },
            };
          }
          return defaultPage;
        });
        setPages(merged);
      } catch {
        setPages(defaultPages);
      }
    } else {
      setPages(defaultPages);
    }
  }, []);

  const getPageContent = (slug: string): PageContent => {
    const page = pages.find((p) => p.slug === slug);
    return page || defaultPages.find((p) => p.slug === slug) || defaultPages[0];
  };

  const updatePageContent = (updatedPage: PageContent) => {
    const updatedPages = pages.map((p) =>
      p.id === updatedPage.id ? updatedPage : p
    );
    setPages(updatedPages);
    localStorage.setItem(STORAGE_KEY, JSON.stringify(updatedPages));
  };

  const resetToDefaults = () => {
    setPages(defaultPages);
    localStorage.setItem(STORAGE_KEY, JSON.stringify(defaultPages));
  };

  return { pages, getPageContent, updatePageContent, resetToDefaults, defaultPages };
};
