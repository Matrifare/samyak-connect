// Static membership plan data - ready for future database integration

export interface PlanFeature {
  name: string;
  free: string | boolean;
  silver: string | boolean;
  gold: string | boolean;
  platinum: string | boolean;
}

export interface MembershipPlan {
  id: string;
  name: string;
  icon: string;
  color: string;
  description: string;
  prices: {
    monthly: number;
    quarterly: number;
    yearly: number;
  };
  features: {
    profileViews: string;
    contactAccess: string;
    messagingLimit: string;
    interestLimit: string;
    searchFilters: string;
    profileHighlight: boolean;
    prioritySupport: boolean;
    verifiedBadge: boolean;
  };
  popular?: boolean;
}

export const membershipPlans: MembershipPlan[] = [
  {
    id: 'free',
    name: 'Free',
    icon: '🆓',
    color: 'slate',
    description: 'Get started with basic features',
    prices: {
      monthly: 0,
      quarterly: 0,
      yearly: 0,
    },
    features: {
      profileViews: '10 / day',
      contactAccess: 'No',
      messagingLimit: '5 / day',
      interestLimit: '3 / day',
      searchFilters: 'Basic',
      profileHighlight: false,
      prioritySupport: false,
      verifiedBadge: false,
    },
  },
  {
    id: 'silver',
    name: 'Silver',
    icon: '🥈',
    color: 'gray',
    description: 'Perfect for serious searchers',
    prices: {
      monthly: 499,
      quarterly: 1299,
      yearly: 3999,
    },
    features: {
      profileViews: '50 / day',
      contactAccess: 'Limited',
      messagingLimit: '25 / day',
      interestLimit: '15 / day',
      searchFilters: 'Advanced',
      profileHighlight: false,
      prioritySupport: false,
      verifiedBadge: false,
    },
  },
  {
    id: 'gold',
    name: 'Gold',
    icon: '🥇',
    color: 'amber',
    description: 'Most popular choice for finding your match',
    prices: {
      monthly: 999,
      quarterly: 2499,
      yearly: 7999,
    },
    features: {
      profileViews: 'Unlimited',
      contactAccess: 'Full Access',
      messagingLimit: 'Unlimited',
      interestLimit: '50 / day',
      searchFilters: 'Premium',
      profileHighlight: true,
      prioritySupport: false,
      verifiedBadge: true,
    },
    popular: true,
  },
  {
    id: 'platinum',
    name: 'Platinum',
    icon: '💎',
    color: 'violet',
    description: 'Premium experience with exclusive benefits',
    prices: {
      monthly: 1999,
      quarterly: 4999,
      yearly: 14999,
    },
    features: {
      profileViews: 'Unlimited',
      contactAccess: 'Full Access',
      messagingLimit: 'Unlimited',
      interestLimit: 'Unlimited',
      searchFilters: 'Premium + AI Match',
      profileHighlight: true,
      prioritySupport: true,
      verifiedBadge: true,
    },
  },
];

export const comparisonFeatures: PlanFeature[] = [
  { name: 'Profile Views', free: '10/day', silver: '50/day', gold: 'Unlimited', platinum: 'Unlimited' },
  { name: 'Contact Details Access', free: false, silver: 'Limited', gold: true, platinum: true },
  { name: 'Send Messages', free: '5/day', silver: '25/day', gold: 'Unlimited', platinum: 'Unlimited' },
  { name: 'Send Interests', free: '3/day', silver: '15/day', gold: '50/day', platinum: 'Unlimited' },
  { name: 'Search Filters', free: 'Basic', silver: 'Advanced', gold: 'Premium', platinum: 'Premium + AI' },
  { name: 'Profile Highlighting', free: false, silver: false, gold: true, platinum: true },
  { name: 'Verified Badge', free: false, silver: false, gold: true, platinum: true },
  { name: 'Priority Support', free: false, silver: false, gold: false, platinum: true },
  { name: 'Relationship Manager', free: false, silver: false, gold: false, platinum: true },
  { name: 'Profile Boost', free: false, silver: '1x/month', gold: '3x/month', platinum: 'Weekly' },
  { name: 'Who Viewed Profile', free: false, silver: 'Last 5', gold: 'Last 30', platinum: 'All' },
  { name: 'Advanced Matchmaking', free: false, silver: false, gold: true, platinum: true },
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
    duration: '3 Months',
    amount: 2499,
    status: 'success',
    transactionId: 'TXN123456789',
    paymentMethod: 'Credit Card',
  },
  {
    id: '2',
    date: '2024-10-10',
    plan: 'Silver',
    duration: '3 Months',
    amount: 1299,
    status: 'success',
    transactionId: 'TXN987654321',
    paymentMethod: 'UPI',
  },
  {
    id: '3',
    date: '2024-07-15',
    plan: 'Gold',
    duration: '1 Month',
    amount: 999,
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
