import { useState, useEffect } from "react";
import { MessageCircle } from "lucide-react";
import { getSiteSettings } from "@/lib/siteSettings";

const WhatsAppButton = () => {
  const [whatsappNumber, setWhatsappNumber] = useState("");
  const [isHovered, setIsHovered] = useState(false);

  useEffect(() => {
    const loadSettings = async () => {
      const settings = await getSiteSettings();
      setWhatsappNumber(settings.whatsapp_number || "");
    };
    loadSettings();
  }, []);

  if (!whatsappNumber) return null;

  // Remove any non-numeric characters for the WhatsApp URL
  const cleanNumber = whatsappNumber.replace(/\D/g, "");
  const whatsappUrl = `https://wa.me/${cleanNumber}`;

  return (
    <a
      href={whatsappUrl}
      target="_blank"
      rel="noopener noreferrer"
      className="fixed bottom-6 right-6 z-50 flex items-center gap-2 bg-[#25D366] hover:bg-[#128C7E] text-white rounded-full shadow-lg transition-all duration-300 hover:scale-110"
      style={{
        padding: isHovered ? "12px 20px" : "14px",
      }}
      onMouseEnter={() => setIsHovered(true)}
      onMouseLeave={() => setIsHovered(false)}
      aria-label="Chat on WhatsApp"
    >
      <MessageCircle className="h-6 w-6" fill="currentColor" />
      {isHovered && (
        <span className="text-sm font-medium whitespace-nowrap">
          Chat with us
        </span>
      )}
    </a>
  );
};

export default WhatsAppButton;
