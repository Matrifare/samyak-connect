import { useState, useEffect } from "react";

interface PageContent {
  id: string;
  slug: string;
  page_name: string;
  seo_title: string;
  seo_description: string;
  seo_keywords: string;
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
    is_published: true,
  },
  {
    id: "2",
    slug: "about-us",
    page_name: "About Us",
    seo_title: "About Us - Samyak Matrimony",
    seo_description: "Learn about Samyak Matrimony - trusted Buddhist matrimonial service",
    seo_keywords: "about, matrimony, buddhist, wedding service",
    is_published: true,
  },
  {
    id: "3",
    slug: "contact-us",
    page_name: "Contact Us",
    seo_title: "Contact Us - Samyak Matrimony",
    seo_description: "Get in touch with Samyak Matrimony for queries or support",
    seo_keywords: "contact, support, help, matrimony",
    is_published: true,
  },
  {
    id: "4",
    slug: "privacy-policy",
    page_name: "Privacy Policy",
    seo_title: "Privacy Policy - Samyak Matrimony",
    seo_description: "Read our privacy policy to understand how we protect your data",
    seo_keywords: "privacy, policy, data protection",
    is_published: true,
  },
  {
    id: "5",
    slug: "terms-conditions",
    page_name: "Terms & Conditions",
    seo_title: "Terms & Conditions - Samyak Matrimony",
    seo_description: "Read our terms and conditions for using Samyak Matrimony services",
    seo_keywords: "terms, conditions, rules, agreement",
    is_published: true,
  },
  {
    id: "6",
    slug: "faq",
    page_name: "FAQ",
    seo_title: "Frequently Asked Questions - Samyak Matrimony",
    seo_description: "Find answers to common questions about Samyak Matrimony",
    seo_keywords: "faq, questions, help, support",
    is_published: true,
  },
  {
    id: "7",
    slug: "refund-policy",
    page_name: "Refund Policy",
    seo_title: "Refund Policy - Samyak Matrimony",
    seo_description: "Learn about our refund policy for premium memberships",
    seo_keywords: "refund, policy, payment, membership",
    is_published: true,
  },
];

const STORAGE_KEY = "samyak_page_content";

export const usePageContent = () => {
  const [pages, setPages] = useState<PageContent[]>([]);

  useEffect(() => {
    const stored = localStorage.getItem(STORAGE_KEY);
    if (stored) {
      setPages(JSON.parse(stored));
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

  return { pages, getPageContent, updatePageContent };
};
