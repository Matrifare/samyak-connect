// Static membership plan data - ready for future database integration

export interface PlanFeature {
  name: string;
  free: string | boolean;
  silver: string | boolean;
  gold: string | boolean;
  premium: string | boolean;
  eliteSilver: string | boolean;
  eliteGold: string | boolean;
  elitePremium: string | boolean;
}

export interface MembershipPlan {
  id: string;
  name: string;
  duration: string;
  durationMonths: number;
  color: string;
  bgColor: string;
  viewContacts: number;
  sendMessages: number;
  price: number;
  category: 'online' | 'personalized';
  popular?: boolean;
}

export const onlinePlans: MembershipPlan[] = [
  {
    id: 'silver',
    name: 'Silver',
    duration: '3 Months',
    durationMonths: 3,
    color: 'text-gray-800',
    bgColor: 'bg-gradient-to-r from-yellow-300 to-yellow-400',
    viewContacts: 50,
    sendMessages: 400,
    price: 2500,
    category: 'online',
  },
  {
    id: 'gold',
    name: 'Gold',
    duration: '6 Months',
    durationMonths: 6,
    color: 'text-gray-800',
    bgColor: 'bg-gradient-to-r from-cyan-300 to-cyan-400',
    viewContacts: 100,
    sendMessages: 500,
    price: 3500,
    category: 'online',
  },
  {
    id: 'premium',
    name: 'Premium',
    duration: '12 Months',
    durationMonths: 12,
    color: 'text-white',
    bgColor: 'bg-gradient-to-r from-green-400 to-green-500',
    viewContacts: 120,
    sendMessages: 600,
    price: 5000,
    category: 'online',
    popular: true,
  },
  {
    id: 'elite-silver',
    name: 'Elite Silver',
    duration: '4 Months',
    durationMonths: 4,
    color: 'text-gray-800',
    bgColor: 'bg-gradient-to-r from-lime-300 to-lime-400',
    viewContacts: 75,
    sendMessages: 600,
    price: 4000,
    category: 'online',
  },
  {
    id: 'elite-gold',
    name: 'Elite Gold',
    duration: '8 Months',
    durationMonths: 8,
    color: 'text-gray-800',
    bgColor: 'bg-gradient-to-r from-lime-300 to-lime-400',
    viewContacts: 150,
    sendMessages: 800,
    price: 6500,
    category: 'online',
  },
  {
    id: 'elite-premium',
    name: 'Elite Premium',
    duration: '12 Months',
    durationMonths: 12,
    color: 'text-white',
    bgColor: 'bg-gradient-to-r from-teal-400 to-teal-500',
    viewContacts: 200,
    sendMessages: 1000,
    price: 9000,
    category: 'online',
  },
];

export const personalizedPlans: MembershipPlan[] = [
  {
    id: 'personalized-silver',
    name: 'Silver',
    duration: '3 Months',
    durationMonths: 3,
    color: 'text-gray-800',
    bgColor: 'bg-gradient-to-r from-yellow-300 to-yellow-400',
    viewContacts: 75,
    sendMessages: 500,
    price: 15000,
    category: 'personalized',
  },
  {
    id: 'personalized-gold',
    name: 'Gold',
    duration: '6 Months',
    durationMonths: 6,
    color: 'text-gray-800',
    bgColor: 'bg-gradient-to-r from-cyan-300 to-cyan-400',
    viewContacts: 150,
    sendMessages: 750,
    price: 25000,
    category: 'personalized',
    popular: true,
  },
  {
    id: 'personalized-premium',
    name: 'Premium',
    duration: '12 Months',
    durationMonths: 12,
    color: 'text-white',
    bgColor: 'bg-gradient-to-r from-green-400 to-green-500',
    viewContacts: 250,
    sendMessages: 1000,
    price: 40000,
    category: 'personalized',
  },
];

export const membershipFeatures = [
  { icon: 'contact', label: 'View Contact Details', description: 'Access phone numbers and emails' },
  { icon: 'phone', label: 'View Mobile Number', description: 'Direct phone access' },
  { icon: 'chat', label: 'Chat online members', description: 'Live chat with matches' },
  { icon: 'message', label: 'Send Messages / SMS', description: 'Unlimited messaging' },
];

export const comparisonFeatures: PlanFeature[] = [
  { name: 'Profile Views', free: '10/day', silver: '50/day', gold: '100/day', premium: '120/day', eliteSilver: '75/day', eliteGold: '150/day', elitePremium: '200/day' },
  { name: 'Contact Details Access', free: false, silver: '50', gold: '100', premium: '120', eliteSilver: '75', eliteGold: '150', elitePremium: '200' },
  { name: 'Send Messages', free: '5/day', silver: '400', gold: '500', premium: '600', eliteSilver: '600', eliteGold: '800', elitePremium: '1000' },
  { name: 'Send Interests', free: '3/day', silver: '15/day', gold: '50/day', premium: 'Unlimited', eliteSilver: '50/day', eliteGold: 'Unlimited', elitePremium: 'Unlimited' },
  { name: 'Search Filters', free: 'Basic', silver: 'Advanced', gold: 'Premium', premium: 'Premium', eliteSilver: 'Premium', eliteGold: 'Premium + AI', elitePremium: 'Premium + AI' },
  { name: 'Profile Highlighting', free: false, silver: false, gold: true, premium: true, eliteSilver: true, eliteGold: true, elitePremium: true },
  { name: 'Verified Badge', free: false, silver: false, gold: true, premium: true, eliteSilver: true, eliteGold: true, elitePremium: true },
  { name: 'Priority Support', free: false, silver: false, gold: false, premium: true, eliteSilver: false, eliteGold: true, elitePremium: true },
  { name: 'Relationship Manager', free: false, silver: false, gold: false, premium: false, eliteSilver: false, eliteGold: false, elitePremium: true },
  { name: 'Profile Boost', free: false, silver: '1x/month', gold: '3x/month', premium: 'Weekly', eliteSilver: '2x/month', eliteGold: 'Weekly', elitePremium: 'Daily' },
  { name: 'Who Viewed Profile', free: false, silver: 'Last 5', gold: 'Last 30', premium: 'All', eliteSilver: 'Last 15', eliteGold: 'All', elitePremium: 'All' },
  { name: 'Advanced Matchmaking', free: false, silver: false, gold: true, premium: true, eliteSilver: true, eliteGold: true, elitePremium: true },
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
