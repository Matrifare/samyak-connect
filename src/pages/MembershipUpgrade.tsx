import { useState } from "react";
import { useNavigate, useSearchParams } from "react-router-dom";
import { ArrowLeft, Check, Lock, Tag, CreditCard, Smartphone, Building, Wallet } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import { Separator } from "@/components/ui/separator";
import { onlinePlans, personalizedPlans, paymentMethods, MembershipPlan } from "@/data/membershipPlans";
import { useToast } from "@/hooks/use-toast";
import { cn } from "@/lib/utils";

const allPlans = [...onlinePlans, ...personalizedPlans];

const MembershipUpgrade = () => {
  const navigate = useNavigate();
  const [searchParams] = useSearchParams();
  const { toast } = useToast();

  const planId = searchParams.get('plan') || 'gold';
  
  const [selectedPayment, setSelectedPayment] = useState('card');
  const [couponCode, setCouponCode] = useState('');
  const [couponApplied, setCouponApplied] = useState(false);

  const plan = allPlans.find(p => p.id === planId) || onlinePlans[1];
  const price = plan.price;
  const discount = couponApplied ? Math.round(price * 0.1) : 0;
  const total = price - discount;

  const handleApplyCoupon = () => {
    if (couponCode.toUpperCase() === 'FIRST10') {
      setCouponApplied(true);
      toast({
        title: "Coupon Applied!",
        description: "You got 10% off on your purchase.",
      });
    } else {
      toast({
        title: "Invalid Coupon",
        description: "Please enter a valid coupon code.",
        variant: "destructive",
      });
    }
  };

  const handleProceedPayment = () => {
    toast({
      title: "Processing Payment...",
      description: "Please wait while we process your payment.",
    });
    
    setTimeout(() => {
      navigate('/membership/success?txn=TXN' + Date.now());
    }, 1500);
  };

  const paymentIcons = {
    card: CreditCard,
    upi: Smartphone,
    netbanking: Building,
    wallet: Wallet,
  };

  return (
    <div className="min-h-screen bg-muted/30">
      {/* Header */}
      <div className="bg-gradient-hero py-8 px-4">
        <div className="container mx-auto">
          <Button 
            variant="ghost" 
            className="text-white hover:bg-white/20 mb-4"
            onClick={() => navigate('/membership')}
          >
            <ArrowLeft className="w-4 h-4 mr-2" />
            Back to Plans
          </Button>
          
          <h1 className="text-2xl md:text-3xl font-bold text-white">
            Complete Your Upgrade
          </h1>
        </div>
      </div>

      <div className="container mx-auto py-8 px-4">
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
          {/* Left - Payment Options */}
          <div className="lg:col-span-2 space-y-6">
            {/* Payment Method */}
            <Card>
              <CardHeader>
                <CardTitle className="text-lg">Payment Method</CardTitle>
                <CardDescription>Select your preferred payment option</CardDescription>
              </CardHeader>
              <CardContent>
                <RadioGroup 
                  value={selectedPayment} 
                  onValueChange={setSelectedPayment}
                  className="space-y-3"
                >
                  {paymentMethods.map((method) => {
                    const Icon = paymentIcons[method.id as keyof typeof paymentIcons];
                    return (
                      <Label
                        key={method.id}
                        htmlFor={method.id}
                        className={cn(
                          "flex items-center gap-4 p-4 border-2 rounded-lg cursor-pointer transition-all",
                          selectedPayment === method.id 
                            ? "border-primary bg-primary/5" 
                            : "border-border hover:border-primary/50"
                        )}
                      >
                        <RadioGroupItem value={method.id} id={method.id} />
                        <Icon className="w-5 h-5 text-muted-foreground" />
                        <span className="font-medium">{method.name}</span>
                      </Label>
                    );
                  })}
                </RadioGroup>
              </CardContent>
            </Card>

            {/* Coupon Code */}
            <Card>
              <CardHeader>
                <CardTitle className="text-lg flex items-center gap-2">
                  <Tag className="w-5 h-5" />
                  Have a Coupon?
                </CardTitle>
              </CardHeader>
              <CardContent>
                <div className="flex gap-3">
                  <Input 
                    placeholder="Enter coupon code"
                    value={couponCode}
                    onChange={(e) => setCouponCode(e.target.value)}
                    disabled={couponApplied}
                    className="uppercase"
                  />
                  <Button 
                    variant="outline" 
                    onClick={handleApplyCoupon}
                    disabled={couponApplied || !couponCode}
                  >
                    {couponApplied ? 'Applied' : 'Apply'}
                  </Button>
                </div>
                <p className="text-xs text-muted-foreground mt-2">
                  Try code "FIRST10" for 10% off
                </p>
              </CardContent>
            </Card>
          </div>

          {/* Right - Order Summary */}
          <div>
            <Card className="sticky top-4">
              <CardHeader className={cn("rounded-t-lg", plan.bgColor, plan.color)}>
                <CardTitle className="flex items-center gap-3">
                  <div>
                    <div className="text-xl font-bold">{plan.name} Plan</div>
                    <CardDescription className={cn("opacity-90", plan.color)}>{plan.duration}</CardDescription>
                  </div>
                </CardTitle>
              </CardHeader>
              <CardContent className="pt-6 space-y-4">
                {/* Features Preview */}
                <div className="space-y-2">
                  <p className="text-sm font-medium text-muted-foreground">Includes:</p>
                  <ul className="space-y-1.5 text-sm">
                    <li className="flex items-center gap-2">
                      <Check className="w-4 h-4 text-green-500" />
                      View {plan.viewContacts} contacts
                    </li>
                    <li className="flex items-center gap-2">
                      <Check className="w-4 h-4 text-green-500" />
                      Send {plan.sendMessages} messages
                    </li>
                    <li className="flex items-center gap-2">
                      <Check className="w-4 h-4 text-green-500" />
                      Valid for {plan.duration}
                    </li>
                    <li className="flex items-center gap-2">
                      <Check className="w-4 h-4 text-green-500" />
                      View contact details
                    </li>
                    <li className="flex items-center gap-2">
                      <Check className="w-4 h-4 text-green-500" />
                      Chat with online members
                    </li>
                  </ul>
                </div>

                <Separator />

                {/* Price Breakdown */}
                <div className="space-y-2">
                  <div className="flex justify-between text-sm">
                    <span className="text-muted-foreground">Plan Price</span>
                    <span>₹{price.toLocaleString()}</span>
                  </div>
                  {couponApplied && (
                    <div className="flex justify-between text-sm text-green-600">
                      <span>Coupon Discount</span>
                      <span>-₹{discount.toLocaleString()}</span>
                    </div>
                  )}
                  <Separator />
                  <div className="flex justify-between font-semibold text-lg">
                    <span>Total</span>
                    <span className="text-primary">₹{total.toLocaleString()}</span>
                  </div>
                </div>

                <Button 
                  className="w-full bg-gradient-primary hover:opacity-90"
                  size="lg"
                  onClick={handleProceedPayment}
                >
                  <Lock className="w-4 h-4 mr-2" />
                  Pay ₹{total.toLocaleString()}
                </Button>

                <p className="text-xs text-center text-muted-foreground">
                  🔒 Your payment is secured with 256-bit SSL encryption
                </p>
              </CardContent>
            </Card>
          </div>
        </div>
      </div>
    </div>
  );
};

export default MembershipUpgrade;
