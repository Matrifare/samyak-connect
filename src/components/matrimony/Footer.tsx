import { Link } from "react-router-dom";
import { Heart, Facebook, Twitter, Instagram, Youtube, Mail, Phone, MapPin } from "lucide-react";
import { useQuery } from "@tanstack/react-query";
import { getSiteSettings, defaultSettings } from "@/lib/siteSettings";

const Footer = () => {
  const { data: settings } = useQuery({
    queryKey: ["site-settings"],
    queryFn: getSiteSettings,
    staleTime: 1000 * 60 * 5, // Cache for 5 minutes
  });

  const s = settings || defaultSettings;

  return (
    <footer className="bg-foreground text-background py-16">
      <div className="container mx-auto px-4">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
          {/* Brand */}
          <div>
            <Link to="/" className="flex items-center gap-2 mb-6">
              <Heart className="h-8 w-8 text-primary fill-primary" />
              <span className="text-2xl font-serif font-bold">
                {s.site_name}
              </span>
            </Link>
            <p className="text-background/70 mb-6">
              {s.site_tagline}
            </p>
            <div className="flex gap-4">
              {s.facebook_url && (
                <a href={s.facebook_url} target="_blank" rel="noopener noreferrer" className="w-10 h-10 rounded-full bg-background/10 flex items-center justify-center hover:bg-primary transition-colors">
                  <Facebook className="h-5 w-5" />
                </a>
              )}
              {s.twitter_url && (
                <a href={s.twitter_url} target="_blank" rel="noopener noreferrer" className="w-10 h-10 rounded-full bg-background/10 flex items-center justify-center hover:bg-primary transition-colors">
                  <Twitter className="h-5 w-5" />
                </a>
              )}
              {s.instagram_url && (
                <a href={s.instagram_url} target="_blank" rel="noopener noreferrer" className="w-10 h-10 rounded-full bg-background/10 flex items-center justify-center hover:bg-primary transition-colors">
                  <Instagram className="h-5 w-5" />
                </a>
              )}
              {s.youtube_url && (
                <a href={s.youtube_url} target="_blank" rel="noopener noreferrer" className="w-10 h-10 rounded-full bg-background/10 flex items-center justify-center hover:bg-primary transition-colors">
                  <Youtube className="h-5 w-5" />
                </a>
              )}
              {!s.facebook_url && !s.twitter_url && !s.instagram_url && !s.youtube_url && (
                <>
                  <span className="w-10 h-10 rounded-full bg-background/10 flex items-center justify-center opacity-50">
                    <Facebook className="h-5 w-5" />
                  </span>
                  <span className="w-10 h-10 rounded-full bg-background/10 flex items-center justify-center opacity-50">
                    <Twitter className="h-5 w-5" />
                  </span>
                  <span className="w-10 h-10 rounded-full bg-background/10 flex items-center justify-center opacity-50">
                    <Instagram className="h-5 w-5" />
                  </span>
                  <span className="w-10 h-10 rounded-full bg-background/10 flex items-center justify-center opacity-50">
                    <Youtube className="h-5 w-5" />
                  </span>
                </>
              )}
            </div>
          </div>

          {/* Quick Links */}
          <div>
            <h4 className="text-lg font-serif font-bold mb-6">Quick Links</h4>
            <ul className="space-y-3">
              <li>
                <Link to="/search" className="text-background/70 hover:text-primary transition-colors">
                  Search Profiles
                </Link>
              </li>
              <li>
                <Link to="/success-stories" className="text-background/70 hover:text-primary transition-colors">
                  Success Stories
                </Link>
              </li>
              <li>
                <Link to="/blog" className="text-background/70 hover:text-primary transition-colors">
                  Blog
                </Link>
              </li>
              <li>
                <Link to="/about" className="text-background/70 hover:text-primary transition-colors">
                  About Us
                </Link>
              </li>
              <li>
                <Link to="/contact" className="text-background/70 hover:text-primary transition-colors">
                  Contact Us
                </Link>
              </li>
            </ul>
          </div>

          {/* Legal */}
          <div>
            <h4 className="text-lg font-serif font-bold mb-6">Legal</h4>
            <ul className="space-y-3">
              <li>
                <Link to="/privacy" className="text-background/70 hover:text-primary transition-colors">
                  Privacy Policy
                </Link>
              </li>
              <li>
                <Link to="/terms" className="text-background/70 hover:text-primary transition-colors">
                  Terms & Conditions
                </Link>
              </li>
              <li>
                <Link to="/faq" className="text-background/70 hover:text-primary transition-colors">
                  FAQ
                </Link>
              </li>
              <li>
                <Link to="/refund" className="text-background/70 hover:text-primary transition-colors">
                  Refund Policy
                </Link>
              </li>
            </ul>
          </div>

          {/* Contact */}
          <div>
            <h4 className="text-lg font-serif font-bold mb-6">Contact Us</h4>
            <ul className="space-y-4">
              <li className="flex items-start gap-3">
                <MapPin className="h-5 w-5 text-primary mt-0.5 shrink-0" />
                <span className="text-background/70">
                  {s.contact_address}
                </span>
              </li>
              <li className="flex items-center gap-3">
                <Phone className="h-5 w-5 text-primary shrink-0" />
                <span className="text-background/70">{s.contact_phone}</span>
              </li>
              <li className="flex items-center gap-3">
                <Mail className="h-5 w-5 text-primary shrink-0" />
                <span className="text-background/70">{s.contact_email}</span>
              </li>
            </ul>
          </div>
        </div>

        <div className="border-t border-background/10 mt-12 pt-8 text-center text-background/50">
          <p>&copy; {new Date().getFullYear()} {s.site_name}. All rights reserved.</p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
