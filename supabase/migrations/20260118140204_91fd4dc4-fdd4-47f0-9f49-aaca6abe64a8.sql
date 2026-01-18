-- Create profiles table for user profiles
CREATE TABLE public.profiles (
  id UUID NOT NULL DEFAULT gen_random_uuid() PRIMARY KEY,
  matri_id TEXT NOT NULL UNIQUE,
  email TEXT,
  phone TEXT,
  password_hash TEXT,
  
  -- Personal Info
  first_name TEXT NOT NULL,
  last_name TEXT,
  gender TEXT NOT NULL CHECK (gender IN ('male', 'female')),
  date_of_birth DATE,
  age INTEGER,
  height TEXT,
  weight TEXT,
  blood_group TEXT,
  complexion TEXT,
  body_type TEXT,
  physical_status TEXT DEFAULT 'Normal',
  
  -- Religion & Caste
  religion TEXT DEFAULT 'Buddhist',
  caste TEXT,
  sub_caste TEXT,
  gotra TEXT,
  
  -- Education & Career
  education TEXT,
  education_detail TEXT,
  occupation TEXT,
  occupation_detail TEXT,
  employer_name TEXT,
  annual_income TEXT,
  
  -- Family
  father_name TEXT,
  father_occupation TEXT,
  mother_name TEXT,
  mother_occupation TEXT,
  family_type TEXT,
  family_status TEXT,
  family_values TEXT,
  brothers INTEGER DEFAULT 0,
  sisters INTEGER DEFAULT 0,
  brothers_married INTEGER DEFAULT 0,
  sisters_married INTEGER DEFAULT 0,
  
  -- Location
  country TEXT DEFAULT 'India',
  state TEXT,
  city TEXT,
  native_place TEXT,
  
  -- Lifestyle
  marital_status TEXT DEFAULT 'Never Married',
  diet TEXT,
  smoking TEXT DEFAULT 'No',
  drinking TEXT DEFAULT 'No',
  
  -- About
  about_me TEXT,
  partner_expectations TEXT,
  hobbies TEXT,
  
  -- Profile Photo
  photo_url TEXT,
  
  -- Membership
  membership_plan_id UUID REFERENCES public.membership_plans(id),
  membership_start_date TIMESTAMP WITH TIME ZONE,
  membership_end_date TIMESTAMP WITH TIME ZONE,
  contacts_used INTEGER DEFAULT 0,
  messages_used INTEGER DEFAULT 0,
  
  -- Status
  status TEXT DEFAULT 'pending' CHECK (status IN ('pending', 'active', 'suspended', 'deleted')),
  is_verified BOOLEAN DEFAULT false,
  is_premium BOOLEAN DEFAULT false,
  profile_completion INTEGER DEFAULT 0,
  
  -- Timestamps
  created_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT now(),
  updated_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT now(),
  last_login TIMESTAMP WITH TIME ZONE
);

-- Enable RLS
ALTER TABLE public.profiles ENABLE ROW LEVEL SECURITY;

-- Anyone can view active profiles (for search)
CREATE POLICY "Anyone can view active profiles"
ON public.profiles
FOR SELECT
USING (status = 'active');

-- Admin full access (temporary - should be restricted later)
CREATE POLICY "Admin full access profiles"
ON public.profiles
FOR ALL
USING (true)
WITH CHECK (true);

-- Create updated_at trigger
CREATE TRIGGER update_profiles_updated_at
BEFORE UPDATE ON public.profiles
FOR EACH ROW
EXECUTE FUNCTION public.update_updated_at_column();

-- Create function to generate matri_id
CREATE OR REPLACE FUNCTION public.generate_matri_id()
RETURNS TRIGGER AS $$
DECLARE
  prefix TEXT;
  seq_num INTEGER;
  new_id TEXT;
BEGIN
  -- Use gender-based prefix
  IF NEW.gender = 'male' THEN
    prefix := 'SM';
  ELSE
    prefix := 'SF';
  END IF;
  
  -- Get next sequence number
  SELECT COALESCE(MAX(CAST(SUBSTRING(matri_id FROM 3) AS INTEGER)), 10000) + 1
  INTO seq_num
  FROM public.profiles
  WHERE matri_id LIKE prefix || '%';
  
  NEW.matri_id := prefix || seq_num::TEXT;
  RETURN NEW;
END;
$$ LANGUAGE plpgsql SET search_path = public;

-- Create trigger for auto matri_id generation (only if not provided)
CREATE TRIGGER generate_matri_id_trigger
BEFORE INSERT ON public.profiles
FOR EACH ROW
WHEN (NEW.matri_id IS NULL OR NEW.matri_id = '')
EXECUTE FUNCTION public.generate_matri_id();