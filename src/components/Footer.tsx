import { Heart, Facebook, Instagram, Youtube, Linkedin, Mail, Phone } from 'lucide-react';
import { Button } from '@/components/ui/button';

const Footer = () => {
  const currentYear = new Date().getFullYear();

  return (
    <footer className="bg-gradient-to-b from-muted to-muted/50 border-t">
      <div className="container mx-auto px-4 py-12">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
          {/* About Column */}
          <div>
            <div className="flex items-center gap-2 mb-4">
              <Heart className="w-6 h-6 text-primary fill-primary" />
              <h3 className="text-xl font-bold">Samyakmatrimony</h3>
            </div>
            <p className="text-muted-foreground mb-4 text-sm leading-relaxed">
              India's most trusted Buddhist matrimony platform connecting thousands of hearts for over 25 years.
            </p>
            <div className="flex gap-3">
              <Button size="icon" variant="outline" className="hover:bg-primary hover:text-white">
                <Facebook className="w-4 h-4" />
              </Button>
              <Button size="icon" variant="outline" className="hover:bg-primary hover:text-white">
                <Instagram className="w-4 h-4" />
              </Button>
              <Button size="icon" variant="outline" className="hover:bg-primary hover:text-white">
                <Youtube className="w-4 h-4" />
              </Button>
              <Button size="icon" variant="outline" className="hover:bg-primary hover:text-white">
                <Linkedin className="w-4 h-4" />
              </Button>
            </div>
          </div>

          {/* Quick Links */}
          <div>
            <h3 className="font-bold text-lg mb-4">Quick Links</h3>
            <ul className="space-y-2">
              {['Find Matches', 'Success Stories', 'Pricing Plans', 'FAQ', 'Contact Us', 'Blog'].map((link) => (
                <li key={link}>
                  <a href="#" className="text-muted-foreground hover:text-primary transition-colors text-sm">
                    {link}
                  </a>
                </li>
              ))}
            </ul>
          </div>

          {/* Categories */}
          <div>
            <h3 className="font-bold text-lg mb-4">Browse Profiles</h3>
            <ul className="space-y-2">
              {['By Education', 'By Location', 'By Profession', 'NRI Profiles', 'Special Categories', 'Premium Members'].map((link) => (
                <li key={link}>
                  <a href="#" className="text-muted-foreground hover:text-primary transition-colors text-sm">
                    {link}
                  </a>
                </li>
              ))}
            </ul>
          </div>

          {/* Contact & Apps */}
          <div>
            <h3 className="font-bold text-lg mb-4">Contact Us</h3>
            <ul className="space-y-3 mb-4">
              <li className="flex items-center gap-2 text-sm">
                <Phone className="w-4 h-4 text-primary flex-shrink-0" />
                <span className="text-muted-foreground">+91-79779-93616</span>
              </li>
              <li className="flex items-center gap-2 text-sm">
                <Phone className="w-4 h-4 text-primary flex-shrink-0" />
                <span className="text-muted-foreground">+91-98198-86759</span>
              </li>
              <li className="flex items-center gap-2 text-sm">
                <Mail className="w-4 h-4 text-primary flex-shrink-0" />
                <span className="text-muted-foreground">info@samyakmatrimony.com</span>
              </li>
            </ul>
            
            <div className="space-y-2">
              <p className="text-sm font-semibold mb-2">Download Our App</p>
              <Button variant="outline" className="w-full justify-start h-auto py-2 hover:bg-primary hover:text-white">
                <span className="text-sm">📱 App Store</span>
              </Button>
              <Button variant="outline" className="w-full justify-start h-auto py-2 hover:bg-primary hover:text-white">
                <span className="text-sm">🤖 Google Play</span>
              </Button>
            </div>
          </div>
        </div>

        {/* Bottom Bar */}
        <div className="border-t pt-8 mt-8">
          <div className="flex flex-col md:flex-row justify-between items-center gap-4">
            <p className="text-sm text-muted-foreground text-center md:text-left">
              © {currentYear} Samyakmatrimony.com | India's #1 Buddhist Matrimony. All rights reserved.
            </p>
            
            <div className="flex flex-wrap justify-center gap-4 text-sm text-muted-foreground">
              <a href="#" className="hover:text-primary transition-colors">Privacy Policy</a>
              <span>•</span>
              <a href="#" className="hover:text-primary transition-colors">Terms of Service</a>
              <span>•</span>
              <a href="#" className="hover:text-primary transition-colors">Cookie Policy</a>
            </div>
          </div>

          <div className="flex justify-center gap-4 mt-6 text-xs text-muted-foreground">
            <div className="flex items-center gap-2">
              <span className="text-success">🔒</span>
              <span>SSL Secure</span>
            </div>
            <div className="flex items-center gap-2">
              <span className="text-success">✓</span>
              <span>Verified Platform</span>
            </div>
            <div className="flex items-center gap-2">
              <span className="text-success">💳</span>
              <span>Secure Payments</span>
            </div>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
