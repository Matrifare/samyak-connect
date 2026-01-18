import { supabase } from "@/integrations/supabase/client";

export interface BlogCategory {
  id: string;
  name: string;
  slug: string;
  description: string | null;
  thumbnail_url: string | null;
  post_count: number;
  created_at: string;
  updated_at: string;
}

export interface BlogTag {
  id: string;
  name: string;
  slug: string;
  created_at: string;
}

export interface BlogPost {
  id: string;
  title: string;
  slug: string;
  excerpt: string | null;
  content: string | null;
  featured_image_url: string | null;
  seo_title: string | null;
  meta_description: string | null;
  canonical_url: string | null;
  status: "draft" | "published" | "scheduled";
  category_id: string | null;
  author_email: string | null;
  author_name: string;
  view_count: number;
  published_at: string | null;
  scheduled_at: string | null;
  created_at: string;
  updated_at: string;
  category?: BlogCategory;
  tags?: BlogTag[];
}

// Categories
export const getCategories = async (): Promise<BlogCategory[]> => {
  const { data, error } = await supabase
    .from("blog_categories")
    .select("*")
    .order("name");
  if (error) throw error;
  return (data || []) as BlogCategory[];
};

export const createCategory = async (category: { name: string; slug: string; description?: string; thumbnail_url?: string }) => {
  const { data, error } = await supabase
    .from("blog_categories")
    .insert([category])
    .select()
    .single();
  if (error) throw error;
  return data;
};

export const updateCategory = async (id: string, category: { name?: string; slug?: string; description?: string; thumbnail_url?: string }) => {
  const { data, error } = await supabase
    .from("blog_categories")
    .update(category)
    .eq("id", id)
    .select()
    .single();
  if (error) throw error;
  return data;
};

export const deleteCategory = async (id: string) => {
  const { error } = await supabase
    .from("blog_categories")
    .delete()
    .eq("id", id);
  if (error) throw error;
};

// Tags
export const getTags = async (): Promise<BlogTag[]> => {
  const { data, error } = await supabase
    .from("blog_tags")
    .select("*")
    .order("name");
  if (error) throw error;
  return (data || []) as BlogTag[];
};

export const createTag = async (tag: { name: string; slug: string }) => {
  const { data, error } = await supabase
    .from("blog_tags")
    .insert([tag])
    .select()
    .single();
  if (error) throw error;
  return data;
};

export const deleteTag = async (id: string) => {
  const { error } = await supabase
    .from("blog_tags")
    .delete()
    .eq("id", id);
  if (error) throw error;
};

// Posts - Admin (all statuses)
export const getAdminPosts = async (): Promise<BlogPost[]> => {
  const { data, error } = await supabase
    .from("blog_posts")
    .select(`*, category:blog_categories(*)`)
    .order("created_at", { ascending: false });

  if (error) throw error;
  return (data || []) as BlogPost[];
};

// Posts - Public (published only)
export const getPosts = async (): Promise<BlogPost[]> => {
  const { data, error } = await supabase
    .from("blog_posts")
    .select(`*, category:blog_categories(*)`)
    .eq("status", "published")
    .order("published_at", { ascending: false });

  if (error) throw error;
  return (data || []) as BlogPost[];
};

export const getPostBySlug = async (slug: string): Promise<BlogPost | null> => {
  const { data, error } = await supabase
    .from("blog_posts")
    .select(`*, category:blog_categories(*)`)
    .eq("slug", slug)
    .eq("status", "published")
    .maybeSingle();
  if (error) throw error;
  
  if (data) {
    const { data: tagData } = await supabase
      .from("blog_post_tags")
      .select("tag:blog_tags(*)")
      .eq("post_id", data.id);
    
    return {
      ...data,
      tags: tagData?.map((t: any) => t.tag) || []
    } as BlogPost;
  }
  
  return null;
};

export const getPostById = async (id: string): Promise<BlogPost | null> => {
  const { data, error } = await supabase
    .from("blog_posts")
    .select(`*, category:blog_categories(*)`)
    .eq("id", id)
    .maybeSingle();
  if (error) throw error;
  
  if (data) {
    const { data: tagData } = await supabase
      .from("blog_post_tags")
      .select("tag:blog_tags(*)")
      .eq("post_id", data.id);
    
    return {
      ...data,
      tags: tagData?.map((t: any) => t.tag) || []
    } as BlogPost;
  }
  
  return null;
};

export const getCategoryBySlug = async (slug: string): Promise<BlogCategory | null> => {
  const { data, error } = await supabase
    .from("blog_categories")
    .select("*")
    .eq("slug", slug)
    .maybeSingle();
  if (error) throw error;
  return data as BlogCategory | null;
};

export const getPostsByCategory = async (categorySlug: string): Promise<BlogPost[]> => {
  const category = await getCategoryBySlug(categorySlug);
  if (!category) return [];

  const { data, error } = await supabase
    .from("blog_posts")
    .select(`*, category:blog_categories(*)`)
    .eq("category_id", category.id)
    .eq("status", "published")
    .order("published_at", { ascending: false });

  if (error) throw error;
  return (data || []) as BlogPost[];
};

export const createPost = async (
  post: { 
    title: string; 
    slug: string; 
    excerpt?: string; 
    content?: string; 
    featured_image_url?: string;
    seo_title?: string;
    meta_description?: string;
    canonical_url?: string;
    status?: string;
    category_id?: string;
    author_name?: string;
    published_at?: string;
  }, 
  tagIds: string[]
) => {
  const { data, error } = await supabase
    .from("blog_posts")
    .insert([post])
    .select()
    .single();
  if (error) throw error;

  if (tagIds.length > 0) {
    const tagInserts = tagIds.map((tagId) => ({
      post_id: data.id,
      tag_id: tagId,
    }));
    await supabase.from("blog_post_tags").insert(tagInserts);
  }

  return data;
};

export const updatePost = async (
  id: string, 
  post: { 
    title?: string; 
    slug?: string; 
    excerpt?: string; 
    content?: string; 
    featured_image_url?: string;
    seo_title?: string;
    meta_description?: string;
    canonical_url?: string;
    status?: string;
    category_id?: string;
    author_name?: string;
    published_at?: string;
  }, 
  tagIds: string[]
) => {
  const { data, error } = await supabase
    .from("blog_posts")
    .update(post)
    .eq("id", id)
    .select()
    .single();
  if (error) throw error;

  await supabase.from("blog_post_tags").delete().eq("post_id", id);
  
  if (tagIds.length > 0) {
    const tagInserts = tagIds.map((tagId) => ({
      post_id: id,
      tag_id: tagId,
    }));
    await supabase.from("blog_post_tags").insert(tagInserts);
  }

  return data;
};

export const deletePost = async (id: string) => {
  const { error } = await supabase
    .from("blog_posts")
    .delete()
    .eq("id", id);
  if (error) throw error;
};

// Image upload
export const uploadBlogImage = async (file: File, path: string): Promise<string> => {
  const { data, error } = await supabase.storage
    .from("blog-images")
    .upload(path, file, { upsert: true });

  if (error) throw error;

  const { data: urlData } = supabase.storage
    .from("blog-images")
    .getPublicUrl(data.path);

  return urlData.publicUrl;
};

// Generate slug from title
export const generateSlug = (title: string): string => {
  return title
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, "-")
    .replace(/^-+|-+$/g, "");
};

// Search posts
export const searchPosts = async (query: string): Promise<BlogPost[]> => {
  const { data, error } = await supabase
    .from("blog_posts")
    .select(`*, category:blog_categories(*)`)
    .eq("status", "published")
    .or(`title.ilike.%${query}%,excerpt.ilike.%${query}%`)
    .order("published_at", { ascending: false });

  if (error) throw error;
  return (data || []) as BlogPost[];
};
