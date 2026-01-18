import { useState, useEffect } from "react";
import { MapPin, Phone, Mail, Clock, Send, MessageCircle, Facebook, Instagram, Twitter } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import Header from "@/components/matrimony/Header";
import Footer from "@/components/matrimony/Footer";
import { getSiteSettings, SiteSettings, defaultSettings } from "@/lib/siteSettings";

const Contact = () => {
  const [settings, setSettings] = useState<SiteSettings>(defaultSettings);
  const [loading, setLoading] = useState(true);
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    phone: "",
    subject: "",
    message: "",
  });

  useEffect(() => {
    const loadSettings = async () => {
      const data = await getSiteSettings();
      setSettings(data);
      setLoading(false);
    };
    loadSettings();
  }, []);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    console.log("Contact form submitted:", formData);
  };

  // Parse office hours into lines
  const officeHoursLines = settings.contact_office_hours.split("\n").filter(Boolean);

  // Clean WhatsApp number for URL
  const cleanWhatsApp = settings.whatsapp_number.replace(/\D/g, "");

  return (
    <div className="min-h-screen bg-gradient-to-b from-secondary/30 to-background">
      <Header />
      
      <main className="pt-24 pb-16">
        {/* Hero Section */}
        <section className="py-12 bg-gradient-primary text-white">
          <div className="container mx-auto px-4 text-center">
            <h1 className="text-3xl md:text-4xl font-serif font-bold mb-4">
              {settings.contact_page_title}
            </h1>
            <p className="text-lg text-white/90 max-w-2xl mx-auto">
              {settings.contact_page_subtitle}
            </p>
          </div>
        </section>

        <div className="container mx-auto px-4 py-12">
          <div className="grid lg:grid-cols-3 gap-8">
            {/* Contact Info Cards */}
            <div className="lg:col-span-1 space-y-6">
              {/* Office Address */}
              <div className="bg-card rounded-xl shadow-lg p-6 border border-border">
                <div className="flex items-start gap-4">
                  <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                    <MapPin className="h-6 w-6 text-primary" />
                  </div>
                  <div>
                    <h3 className="font-semibold text-lg mb-2">Office Address</h3>
                    <p className="text-muted-foreground text-sm whitespace-pre-line">
                      {settings.contact_office_address}
                    </p>
                  </div>
                </div>
              </div>

              {/* Phone Numbers */}
              <div className="bg-card rounded-xl shadow-lg p-6 border border-border">
                <div className="flex items-start gap-4">
                  <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                    <Phone className="h-6 w-6 text-primary" />
                  </div>
                  <div>
                    <h3 className="font-semibold text-lg mb-2">Phone Numbers</h3>
                    <div className="space-y-1 text-sm">
                      {settings.contact_phone && (
                        <p className="text-muted-foreground">
                          <a href={`tel:${settings.contact_phone.replace(/\s/g, "")}`} className="hover:text-primary">
                            {settings.contact_phone}
                          </a>
                        </p>
                      )}
                      {settings.contact_phone_2 && (
                        <p className="text-muted-foreground">
                          <a href={`tel:${settings.contact_phone_2.replace(/\s/g, "")}`} className="hover:text-primary">
                            {settings.contact_phone_2}
                          </a>
                        </p>
                      )}
                    </div>
                  </div>
                </div>
              </div>

              {/* Email */}
              <div className="bg-card rounded-xl shadow-lg p-6 border border-border">
                <div className="flex items-start gap-4">
                  <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                    <Mail className="h-6 w-6 text-primary" />
                  </div>
                  <div>
                    <h3 className="font-semibold text-lg mb-2">Email Address</h3>
                    <div className="space-y-1 text-sm">
                      {settings.contact_email && (
                        <p className="text-muted-foreground">
                          <a href={`mailto:${settings.contact_email}`} className="hover:text-primary">
                            {settings.contact_email}
                          </a>
                        </p>
                      )}
                      {settings.contact_email_2 && (
                        <p className="text-muted-foreground">
                          <a href={`mailto:${settings.contact_email_2}`} className="hover:text-primary">
                            {settings.contact_email_2}
                          </a>
                        </p>
                      )}
                    </div>
                  </div>
                </div>
              </div>

              {/* Office Hours */}
              <div className="bg-card rounded-xl shadow-lg p-6 border border-border">
                <div className="flex items-start gap-4">
                  <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                    <Clock className="h-6 w-6 text-primary" />
                  </div>
                  <div>
                    <h3 className="font-semibold text-lg mb-2">Office Hours</h3>
                    <div className="space-y-1 text-sm text-muted-foreground">
                      {officeHoursLines.map((line, idx) => (
                        <p key={idx}>{line}</p>
                      ))}
                    </div>
                  </div>
                </div>
              </div>

              {/* Social Media */}
              <div className="bg-card rounded-xl shadow-lg p-6 border border-border">
                <h3 className="font-semibold text-lg mb-4">Connect With Us</h3>
                <div className="flex gap-3">
                  {settings.facebook_url && (
                    <a
                      href={settings.facebook_url}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white hover:opacity-90 transition-opacity"
                    >
                      <Facebook className="h-5 w-5" />
                    </a>
                  )}
                  {settings.instagram_url && (
                    <a
                      href={settings.instagram_url}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 flex items-center justify-center text-white hover:opacity-90 transition-opacity"
                    >
                      <Instagram className="h-5 w-5" />
                    </a>
                  )}
                  {settings.twitter_url && (
                    <a
                      href={settings.twitter_url}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="w-10 h-10 rounded-full bg-sky-500 flex items-center justify-center text-white hover:opacity-90 transition-opacity"
                    >
                      <Twitter className="h-5 w-5" />
                    </a>
                  )}
                  {settings.whatsapp_number && (
                    <a
                      href={`https://wa.me/${cleanWhatsApp}`}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white hover:opacity-90 transition-opacity"
                    >
                      <MessageCircle className="h-5 w-5" />
                    </a>
                  )}
                </div>
              </div>
            </div>

            {/* Contact Form */}
            <div className="lg:col-span-2">
              <div className="bg-card rounded-xl shadow-lg p-8 border border-border">
                <h2 className="text-2xl font-serif font-bold mb-2">Send Us a Message</h2>
                <p className="text-muted-foreground mb-6">
                  Fill out the form below and we'll get back to you as soon as possible.
                </p>

                <form onSubmit={handleSubmit} className="space-y-6">
                  <div className="grid md:grid-cols-2 gap-6">
                    <div className="space-y-2">
                      <Label htmlFor="name">Full Name *</Label>
                      <Input
                        id="name"
                        placeholder="Enter your name"
                        value={formData.name}
                        onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                        required
                      />
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="email">Email Address *</Label>
                      <Input
                        id="email"
                        type="email"
                        placeholder="Enter your email"
                        value={formData.email}
                        onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                        required
                      />
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-6">
                    <div className="space-y-2">
                      <Label htmlFor="phone">Phone Number</Label>
                      <Input
                        id="phone"
                        placeholder="Enter your phone number"
                        value={formData.phone}
                        onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                      />
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="subject">Subject *</Label>
                      <Select
                        value={formData.subject}
                        onValueChange={(value) => setFormData({ ...formData, subject: value })}
                      >
                        <SelectTrigger>
                          <SelectValue placeholder="Select a subject" />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="general">General Inquiry</SelectItem>
                          <SelectItem value="registration">Registration Help</SelectItem>
                          <SelectItem value="profile">Profile Assistance</SelectItem>
                          <SelectItem value="payment">Payment Related</SelectItem>
                          <SelectItem value="complaint">Complaint</SelectItem>
                          <SelectItem value="other">Other</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                  </div>

                  <div className="space-y-2">
                    <Label htmlFor="message">Message *</Label>
                    <Textarea
                      id="message"
                      placeholder="Write your message here..."
                      rows={6}
                      value={formData.message}
                      onChange={(e) => setFormData({ ...formData, message: e.target.value })}
                      required
                    />
                  </div>

                  <Button type="submit" className="w-full bg-gradient-primary hover:opacity-90 h-12 text-lg gap-2">
                    <Send className="h-5 w-5" />
                    Send Message
                  </Button>
                </form>
              </div>

              {/* Map */}
              <div className="mt-8 bg-card rounded-xl shadow-lg p-4 border border-border">
                {settings.contact_map_embed ? (
                  <iframe
                    src={settings.contact_map_embed}
                    className="w-full h-64 rounded-lg"
                    allowFullScreen
                    loading="lazy"
                    referrerPolicy="no-referrer-when-downgrade"
                  />
                ) : (
                  <div className="bg-muted rounded-lg h-64 flex items-center justify-center">
                    <div className="text-center text-muted-foreground">
                      <MapPin className="h-12 w-12 mx-auto mb-2 opacity-50" />
                      <p>Google Map would be displayed here</p>
                    </div>
                  </div>
                )}
              </div>
            </div>
          </div>

          {/* FAQ Section */}
          <div className="mt-16">
            <h2 className="text-2xl font-serif font-bold text-center mb-8">Frequently Asked Questions</h2>
            <div className="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
              {[
                {
                  q: "How do I register on Samyak Matrimony?",
                  a: "Click on 'Register Free' button and fill in your details. It's a simple 3-step process.",
                },
                {
                  q: "Is registration free?",
                  a: "Yes, registration is completely free. You can create your profile and browse matches for free.",
                },
                {
                  q: "How can I upgrade to premium?",
                  a: "Login to your account and click on 'Upgrade to Premium' to see available plans.",
                },
                {
                  q: "How do I contact a profile?",
                  a: "You can express interest in a profile or upgrade to premium to view contact details.",
                },
              ].map((faq, index) => (
                <div key={index} className="bg-card rounded-lg p-6 border border-border">
                  <h4 className="font-semibold mb-2">{faq.q}</h4>
                  <p className="text-muted-foreground text-sm">{faq.a}</p>
                </div>
              ))}
            </div>
          </div>
        </div>
      </main>

      <Footer />
    </div>
  );
};

export default Contact;