import { useNavigate } from "react-router-dom";
import { ArrowLeft, Download, CheckCircle, XCircle, Clock, Filter } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { transactionHistory, Transaction } from "@/data/membershipPlans";
import { cn } from "@/lib/utils";

const MembershipTransactions = () => {
  const navigate = useNavigate();

  const statusConfig = {
    success: {
      icon: CheckCircle,
      label: 'Success',
      className: 'bg-green-100 text-green-700 border-green-200',
      iconColor: 'text-green-500',
    },
    failed: {
      icon: XCircle,
      label: 'Failed',
      className: 'bg-red-100 text-red-700 border-red-200',
      iconColor: 'text-red-500',
    },
    pending: {
      icon: Clock,
      label: 'Pending',
      className: 'bg-amber-100 text-amber-700 border-amber-200',
      iconColor: 'text-amber-500',
    },
  };

  // Calculate total spent
  const totalSpent = transactionHistory
    .filter(t => t.status === 'success')
    .reduce((sum, t) => sum + t.amount, 0);

  return (
    <div className="min-h-screen bg-background">
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
          
          <h1 className="text-2xl md:text-3xl font-bold text-white mb-2">
            Transaction History
          </h1>
          <p className="text-white/90">
            View all your membership payments and invoices
          </p>
        </div>
      </div>

      <div className="container mx-auto py-8 px-4 max-w-4xl">
        {/* Summary Cards */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
          <Card>
            <CardContent className="pt-6">
              <p className="text-sm text-muted-foreground">Total Transactions</p>
              <p className="text-3xl font-bold text-foreground">{transactionHistory.length}</p>
            </CardContent>
          </Card>
          <Card>
            <CardContent className="pt-6">
              <p className="text-sm text-muted-foreground">Successful Payments</p>
              <p className="text-3xl font-bold text-green-600">
                {transactionHistory.filter(t => t.status === 'success').length}
              </p>
            </CardContent>
          </Card>
          <Card>
            <CardContent className="pt-6">
              <p className="text-sm text-muted-foreground">Total Spent</p>
              <p className="text-3xl font-bold text-primary">₹{totalSpent.toLocaleString()}</p>
            </CardContent>
          </Card>
        </div>

        {/* Transactions List */}
        <Card>
          <CardHeader className="flex flex-row items-center justify-between">
            <div>
              <CardTitle>All Transactions</CardTitle>
              <CardDescription>Your payment history with us</CardDescription>
            </div>
            <Button variant="outline" size="sm">
              <Filter className="w-4 h-4 mr-2" />
              Filter
            </Button>
          </CardHeader>
          <CardContent>
            <div className="space-y-4">
              {transactionHistory.map((transaction) => (
                <TransactionItem 
                  key={transaction.id} 
                  transaction={transaction}
                  statusConfig={statusConfig}
                />
              ))}
            </div>

            {transactionHistory.length === 0 && (
              <div className="text-center py-12 text-muted-foreground">
                <p>No transactions yet</p>
              </div>
            )}
          </CardContent>
        </Card>
      </div>
    </div>
  );
};

const TransactionItem = ({ 
  transaction, 
  statusConfig 
}: { 
  transaction: Transaction;
  statusConfig: Record<string, { icon: any; label: string; className: string; iconColor: string }>;
}) => {
  const config = statusConfig[transaction.status];
  const StatusIcon = config.icon;

  return (
    <div className="flex flex-col md:flex-row md:items-center justify-between p-4 border rounded-lg hover:bg-muted/50 transition-colors gap-4">
      <div className="flex items-start gap-4">
        <div className={cn("p-2 rounded-full", config.className)}>
          <StatusIcon className={cn("w-5 h-5", config.iconColor)} />
        </div>
        <div>
          <div className="flex items-center gap-2 mb-1">
            <span className="font-semibold text-foreground">{transaction.plan} Plan</span>
            <Badge variant="outline" className="text-xs">
              {transaction.duration}
            </Badge>
          </div>
          <div className="text-sm text-muted-foreground space-y-0.5">
            <p>Transaction ID: <span className="font-mono">{transaction.transactionId}</span></p>
            <p>{new Date(transaction.date).toLocaleDateString('en-IN', {
              day: 'numeric',
              month: 'long',
              year: 'numeric',
            })} • {transaction.paymentMethod}</p>
          </div>
        </div>
      </div>

      <div className="flex items-center gap-4 ml-12 md:ml-0">
        <div className="text-right">
          <p className={cn(
            "text-lg font-semibold",
            transaction.status === 'success' ? "text-green-600" : 
            transaction.status === 'failed' ? "text-red-600" : "text-amber-600"
          )}>
            ₹{transaction.amount.toLocaleString()}
          </p>
          <Badge className={config.className}>{config.label}</Badge>
        </div>
        
        {transaction.status === 'success' && (
          <Button 
            variant="ghost" 
            size="icon"
            onClick={() => alert('Invoice download will be implemented with backend integration')}
          >
            <Download className="w-4 h-4" />
          </Button>
        )}
      </div>
    </div>
  );
};

export default MembershipTransactions;
