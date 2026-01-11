import { Button } from '@/components/ui/button';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { motion } from 'framer-motion';
import heroBanner from '@/assets/hero-banner.jpg';
import { Heart, Search } from 'lucide-react';

const Hero = () => {
  return (
    <section id="home" className="relative min-h-[60vh] flex items-center justify-center overflow-hidden">
      {/* Full-width Hero Banner Background */}
      <div className="absolute inset-0">
        <img
          src={heroBanner}
          alt="Happy Buddhist couple"
          className="w-full h-full object-cover"
        />
        {/* Dark overlay for text readability */}
        <div className="absolute inset-0 bg-black/40" />
      </div>

      <div className="container mx-auto px-4 relative z-10 py-20">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          className="max-w-5xl mx-auto text-center"
        >
          {/* Main Headline */}
          <motion.h1
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.2 }}
            className="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-3 leading-tight drop-shadow-2xl"
          >
            Someone Somewhere is Dreaming of You
          </motion.h1>

          {/* Subheadline */}
          <motion.p
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.4 }}
            className="text-lg md:text-xl text-white/95 mb-12 font-medium drop-shadow-lg"
          >
            Find your perfect match in the Buddhist community
          </motion.p>

          {/* Search Bar */}
          <motion.div
            initial={{ opacity: 0, y: 40 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.6 }}
            className="backdrop-blur-xl bg-white/95 dark:bg-card/95 p-6 md:p-8 rounded-2xl shadow-2xl border border-white/40"
          >
            <div className="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
              {/* Looking For */}
              <div className="space-y-2">
                <label className="text-sm font-semibold text-foreground block text-left">
                  Looking for
                </label>
                <Select defaultValue="bride">
                  <SelectTrigger className="h-12 bg-background border-2 hover:border-primary/50 transition-colors">
                    <SelectValue placeholder="Select" />
                  </SelectTrigger>
                  <SelectContent className="bg-background z-50">
                    <SelectItem value="bride">Bride</SelectItem>
                    <SelectItem value="groom">Groom</SelectItem>
                  </SelectContent>
                </Select>
              </div>

              {/* Age Range */}
              <div className="space-y-2">
                <label className="text-sm font-semibold text-foreground block text-left">
                  Age
                </label>
                <div className="flex gap-2 items-center">
                  <Select defaultValue="18">
                    <SelectTrigger className="h-12 bg-background border-2 hover:border-primary/50 transition-colors">
                      <SelectValue placeholder="From" />
                    </SelectTrigger>
                    <SelectContent className="bg-background z-50">
                      {Array.from({ length: 48 }, (_, i) => i + 18).map((age) => (
                        <SelectItem key={age} value={age.toString()}>
                          {age}
                        </SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                  <span className="text-muted-foreground font-medium">to</span>
                  <Select defaultValue="35">
                    <SelectTrigger className="h-12 bg-background border-2 hover:border-primary/50 transition-colors">
                      <SelectValue placeholder="To" />
                    </SelectTrigger>
                    <SelectContent className="bg-background z-50">
                      {Array.from({ length: 48 }, (_, i) => i + 18).map((age) => (
                        <SelectItem key={age} value={age.toString()}>
                          {age}
                        </SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>
              </div>

              {/* Religion/Sect */}
              <div className="space-y-2">
                <label className="text-sm font-semibold text-foreground block text-left">
                  Buddhist Sect
                </label>
                <Select defaultValue="any">
                  <SelectTrigger className="h-12 bg-background border-2 hover:border-primary/50 transition-colors">
                    <SelectValue placeholder="Select" />
                  </SelectTrigger>
                  <SelectContent className="bg-background z-50">
                    <SelectItem value="any">Any</SelectItem>
                    <SelectItem value="theravada">Theravada</SelectItem>
                    <SelectItem value="mahayana">Mahayana</SelectItem>
                    <SelectItem value="vajrayana">Vajrayana</SelectItem>
                    <SelectItem value="zen">Zen</SelectItem>
                    <SelectItem value="tibetan">Tibetan</SelectItem>
                    <SelectItem value="ambedkarite">Ambedkarite</SelectItem>
                  </SelectContent>
                </Select>
              </div>

              {/* Search Button */}
              <Button 
                size="lg"
                className="h-12 bg-gradient-primary hover:opacity-90 text-white font-semibold shadow-lg hover:shadow-xl transition-all"
              >
                <Search className="w-5 h-5 mr-2" />
                Search Partner
              </Button>
            </div>
          </motion.div>
        </motion.div>
      </div>
    </section>
  );
};

export default Hero;
