import { useEffect, useState } from "react";
import { useNavigate, useSearchParams } from "react-router-dom";
import { CheckCircle2, Download, Home, Receipt } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import confetti from "@/lib/confetti";

const MembershipSuccess = () => {
  const navigate = useNavigate();
  const [searchParams] = useSearchParams();
  const [showContent, setShowContent] = useState(false);

  const transactionId = searchParams.get('txn') || 'TXN' + Date.now();

  // Mock transaction details - ready for database integration
  const transaction = {
    id: transactionId,
    plan: 'Gold',
    duration: '3 Months',
    amount: 2499,
    date: new Date().toLocaleDateString('en-IN', {
      day: 'numeric',
      month: 'long',
      year: 'numeric',
    }),
    time: new Date().toLocaleTimeString('en-IN', {
      hour: '2-digit',
      minute: '2-digit',
    }),
    paymentMethod: 'Credit Card',
    expiryDate: new Date(Date.now() + 90 * 24 * 60 * 60 * 1000).toLocaleDateString('en-IN', {
      day: 'numeric',
      month: 'long',
      year: 'numeric',
    }),
  };

  useEffect(() => {
    // Trigger confetti animation
    confetti();
    
    // Show content with delay for animation
    setTimeout(() => setShowContent(true), 300);
  }, []);

  return (
    <div className="min-h-screen bg-gradient-to-b from-green-50 to-background flex items-center justify-center p-4">
      <div className={`max-w-md w-full transition-all duration-500 ${showContent ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'}`}>
        {/* Success Icon */}
        <div className="text-center mb-8">
          <div className="inline-flex items-center justify-center w-24 h-24 rounded-full bg-green-100 mb-4 animate-bounce">
            <CheckCircle2 className="w-14 h-14 text-green-500" />
          </div>
          <h1 className="text-3xl font-bold text-foreground mb-2">Payment Successful!</h1>
          <p className="text-muted-foreground">
            Your {transaction.plan} membership is now active
          </p>
        </div>

        {/* Transaction Details Card */}
        <Card className="overflow-hidden">
          <div className="bg-gradient-primary p-4 text-white text-center">
            <p className="text-sm opacity-90">Transaction ID</p>
            <p className="font-mono font-semibold">{transaction.id}</p>
          </div>

          <CardContent className="pt-6 space-y-4">
            <div className="grid grid-cols-2 gap-4 text-sm">
              <div>
                <p className="text-muted-foreground">Plan</p>
                <p className="font-semibold">{transaction.plan}</p>
              </div>
              <div>
                <p className="text-muted-foreground">Duration</p>
                <p className="font-semibold">{transaction.duration}</p>
              </div>
              <div>
                <p className="text-muted-foreground">Amount Paid</p>
                <p className="font-semibold text-green-600">₹{transaction.amount.toLocaleString()}</p>
              </div>
              <div>
                <p className="text-muted-foreground">Payment Method</p>
                <p className="font-semibold">{transaction.paymentMethod}</p>
              </div>
              <div>
                <p className="text-muted-foreground">Date</p>
                <p className="font-semibold">{transaction.date}</p>
              </div>
              <div>
                <p className="text-muted-foreground">Time</p>
                <p className="font-semibold">{transaction.time}</p>
              </div>
            </div>

            <Separator />

            <div className="bg-amber-50 dark:bg-amber-950/30 rounded-lg p-4 border border-amber-200 dark:border-amber-800">
              <p className="text-sm text-amber-800 dark:text-amber-200">
                ✨ Your membership is valid until <strong>{transaction.expiryDate}</strong>
              </p>
            </div>

            <div className="space-y-3 pt-2">
              <Button 
                variant="outline" 
                className="w-full"
                onClick={() => {
                  // Mock invoice download
                  alert('Invoice download will be implemented with backend integration');
                }}
              >
                <Download className="w-4 h-4 mr-2" />
                Download Invoice
              </Button>

              <Button 
                variant="outline" 
                className="w-full"
                onClick={() => navigate('/membership/transactions')}
              >
                <Receipt className="w-4 h-4 mr-2" />
                View All Transactions
              </Button>

              <Button 
                className="w-full bg-gradient-primary hover:opacity-90"
                onClick={() => navigate('/dashboard')}
              >
                <Home className="w-4 h-4 mr-2" />
                Go to Dashboard
              </Button>
            </div>
          </CardContent>
        </Card>

        <p className="text-center text-sm text-muted-foreground mt-6">
          A confirmation email has been sent to your registered email address.
        </p>
      </div>
    </div>
  );
};

export default MembershipSuccess;
