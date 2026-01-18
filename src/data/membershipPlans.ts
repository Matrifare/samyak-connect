// Static membership plan data - ready for future database integration

export interface PlanFeature {
  name: string;
  online: string | boolean;
  elite: string | boolean;
}

export interface MembershipPlan {
  id: string;
  name: string;
  duration: string;
  durationMonths: number;
  color: string;
  bgColor: string;
  borderColor: string;
  viewContacts: number;
  sendMessages: number;
  price: number;
  category: 'online' | 'elite';
  popular?: boolean;
  icon: string;
}

export const onlinePlans: MembershipPlan[] = [
  {
    id: 'silver',
    name: 'Silver',
    duration: '3 Months',
    durationMonths: 3,
    color: 'text-amber-800',
    bgColor: 'bg-gradient-to-br from-amber-100 to-amber-200',
    borderColor: 'border-amber-300',
    viewContacts: 50,
    sendMessages: 400,
    price: 2500,
    category: 'online',
    icon: '🥈',
  },
  {
    id: 'gold',
    name: 'Gold',
    duration: '6 Months',
    durationMonths: 6,
    color: 'text-yellow-800',
    bgColor: 'bg-gradient-to-br from-yellow-200 to-amber-300',
    borderColor: 'border-yellow-400',
    viewContacts: 100,
    sendMessages: 500,
    price: 3500,
    category: 'online',
    popular: true,
    icon: '🥇',
  },
  {
    id: 'premium',
    name: 'Premium',
    duration: '12 Months',
    durationMonths: 12,
    color: 'text-emerald-800',
    bgColor: 'bg-gradient-to-br from-emerald-200 to-teal-300',
    borderColor: 'border-emerald-400',
    viewContacts: 120,
    sendMessages: 600,
    price: 5000,
    category: 'online',
    icon: '💎',
  },
];

export const elitePlans: MembershipPlan[] = [
  {
    id: 'elite-silver',
    name: 'Elite Silver',
    duration: '4 Months',
    durationMonths: 4,
    color: 'text-slate-800',
    bgColor: 'bg-gradient-to-br from-slate-200 to-slate-300',
    borderColor: 'border-slate-400',
    viewContacts: 75,
    sendMessages: 600,
    price: 4000,
    category: 'elite',
    icon: '⚡',
  },
  {
    id: 'elite-gold',
    name: 'Elite Gold',
    duration: '8 Months',
    durationMonths: 8,
    color: 'text-orange-800',
    bgColor: 'bg-gradient-to-br from-orange-200 to-rose-300',
    borderColor: 'border-orange-400',
    viewContacts: 150,
    sendMessages: 800,
    price: 6500,
    category: 'elite',
    popular: true,
    icon: '👑',
  },
  {
    id: 'elite-premium',
    name: 'Elite Premium',
    duration: '12 Months',
    durationMonths: 12,
    color: 'text-purple-800',
    bgColor: 'bg-gradient-to-br from-purple-200 to-violet-300',
    borderColor: 'border-purple-400',
    viewContacts: 200,
    sendMessages: 1000,
    price: 9000,
    category: 'elite',
    icon: '💫',
  },
];

export const membershipFeatures = [
  { icon: 'contact', label: 'View Contact Details', description: 'Access phone numbers and emails' },
  { icon: 'phone', label: 'View Mobile Number', description: 'Direct phone access' },
  { icon: 'chat', label: 'Chat online members', description: 'Live chat with matches' },
  { icon: 'message', label: 'Send Messages / SMS', description: 'Unlimited messaging' },
];

export const comparisonFeatures: PlanFeature[] = [
  { name: 'Service Type', online: 'Self-Assisted', elite: 'Dedicated Manager' },
  { name: 'Profile Matching', online: 'Algorithm Based', elite: 'Personal Matchmaking' },
  { name: 'Profile Verification', online: 'Basic Verification', elite: 'Premium Verification' },
  { name: 'Support', online: 'Email Support', elite: '24/7 Priority Support' },
  { name: 'Profile Boost', online: 'Monthly', elite: 'Weekly' },
  { name: 'Background Check', online: false, elite: true },
  { name: 'Relationship Manager', online: false, elite: true },
  { name: 'Meeting Arrangement', online: false, elite: true },
  { name: 'Video Introduction', online: false, elite: true },
  { name: 'Profile Highlighting', online: 'Standard', elite: 'Premium Spotlight' },
  { name: 'Search Priority', online: 'Normal', elite: 'Top Results' },
  { name: 'Photo Privacy', online: 'Basic', elite: 'Advanced Controls' },
];

// Mock current user membership - for UI display
export const currentMembership = {
  plan: 'free',
  planName: 'Free',
  startDate: '2025-01-01',
  expiryDate: null,
  autoRenew: false,
};

// Mock transaction history
export interface Transaction {
  id: string;
  date: string;
  plan: string;
  duration: string;
  amount: number;
  status: 'success' | 'failed' | 'pending';
  transactionId: string;
  paymentMethod: string;
}

export const transactionHistory: Transaction[] = [
  {
    id: '1',
    date: '2025-01-10',
    plan: 'Gold',
    duration: '6 Months',
    amount: 3500,
    status: 'success',
    transactionId: 'TXN123456789',
    paymentMethod: 'Credit Card',
  },
  {
    id: '2',
    date: '2024-10-10',
    plan: 'Silver',
    duration: '3 Months',
    amount: 2500,
    status: 'success',
    transactionId: 'TXN987654321',
    paymentMethod: 'UPI',
  },
  {
    id: '3',
    date: '2024-07-15',
    plan: 'Premium',
    duration: '12 Months',
    amount: 5000,
    status: 'failed',
    transactionId: 'TXN456789123',
    paymentMethod: 'Debit Card',
  },
];

export const paymentMethods = [
  { id: 'card', name: 'Credit / Debit Card', icon: '💳' },
  { id: 'upi', name: 'UPI Payment', icon: '📱' },
  { id: 'netbanking', name: 'Net Banking', icon: '🏦' },
  { id: 'wallet', name: 'Digital Wallet', icon: '👛' },
];
