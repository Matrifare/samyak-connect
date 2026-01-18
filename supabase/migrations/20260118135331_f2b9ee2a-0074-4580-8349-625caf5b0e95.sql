-- Create updated_at function first
CREATE OR REPLACE FUNCTION public.update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
  NEW.updated_at = now();
  RETURN NEW;
END;
$$ LANGUAGE plpgsql SET search_path = public;

-- Create membership_plans table
CREATE TABLE public.membership_plans (
  id UUID NOT NULL DEFAULT gen_random_uuid() PRIMARY KEY,
  name TEXT NOT NULL,
  slug TEXT NOT NULL UNIQUE,
  duration TEXT NOT NULL,
  duration_months INTEGER NOT NULL,
  category TEXT NOT NULL CHECK (category IN ('online', 'elite')),
  view_contacts INTEGER NOT NULL DEFAULT 50,
  send_messages INTEGER NOT NULL DEFAULT 400,
  price DECIMAL(10,2) NOT NULL,
  icon TEXT DEFAULT '💎',
  color TEXT DEFAULT 'text-gray-800',
  bg_color TEXT DEFAULT 'bg-gradient-to-br from-gray-100 to-gray-200',
  border_color TEXT DEFAULT 'border-gray-300',
  is_popular BOOLEAN DEFAULT false,
  is_active BOOLEAN DEFAULT true,
  sort_order INTEGER DEFAULT 0,
  created_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT now(),
  updated_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT now()
);

-- Enable RLS
ALTER TABLE public.membership_plans ENABLE ROW LEVEL SECURITY;

-- Allow anyone to read active plans (public facing)
CREATE POLICY "Anyone can view active membership plans"
ON public.membership_plans
FOR SELECT
USING (is_active = true);

-- Admin can manage all plans (for now using a simple true policy - should be updated with proper auth)
CREATE POLICY "Admin full access membership plans"
ON public.membership_plans
FOR ALL
USING (true)
WITH CHECK (true);

-- Create updated_at trigger
CREATE TRIGGER update_membership_plans_updated_at
BEFORE UPDATE ON public.membership_plans
FOR EACH ROW
EXECUTE FUNCTION public.update_updated_at_column();