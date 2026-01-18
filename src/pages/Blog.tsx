import { useState } from "react";
import { useQuery } from "@tanstack/react-query";
import { Link } from "react-router-dom";
import Header from "@/components/matrimony/Header";
import Footer from "@/components/matrimony/Footer";
import { Input } from "@/components/ui/input";
import { Badge } from "@/components/ui/badge";
import { Search, Calendar, ArrowRight, BookOpen } from "lucide-react";
import { getCategories, getPosts, searchPosts, BlogPost, BlogCategory } from "@/lib/blog";
import { format } from "date-fns";

const Blog = () => {
  const [searchQuery, setSearchQuery] = useState("");
  const [activeSearch, setActiveSearch] = useState("");

  const { data: categories, isLoading: loadingCategories } = useQuery({
    queryKey: ["blog-categories"],
    queryFn: getCategories,
  });

  const { data: posts, isLoading: loadingPosts } = useQuery({
    queryKey: ["blog-posts", activeSearch],
    queryFn: () => activeSearch ? searchPosts(activeSearch) : getPosts(),
  });

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    setActiveSearch(searchQuery);
  };

  const getCategoryImage = (slug: string) => {
    const images: Record<string, string> = {
      "marriage-tips": "https://images.unsplash.com/photo-1519741497674-611481863552?w=400",
      "wedding-tips-planning": "https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=400",
      "relationship-advice": "https://images.unsplash.com/photo-1516589178581-6cd7833ae3b2?w=400",
      "online-matrimony-guidance": "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=400",
      "matrimonial-profile-tips": "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400",
      "marriage-rituals-traditions": "https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=400",
      "community-culture": "https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=400",
      "success-stories": "https://images.unsplash.com/photo-1537633552985-df8429e8048b?w=400",
    };
    return images[slug] || "https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=400";
  };

  return (
    <div className="min-h-screen bg-background">
      <Header />

      {/* Hero Section */}
      <section className="bg-gradient-to-br from-primary/10 to-secondary/10 py-16">
        <div className="container mx-auto px-4 text-center">
          <BookOpen className="h-12 w-12 text-primary mx-auto mb-4" />
          <h1 className="text-4xl md:text-5xl font-serif font-bold text-foreground mb-4">
            Samyak Blog
          </h1>
          <p className="text-lg text-muted-foreground max-w-2xl mx-auto mb-8">
            Expert advice, tips, and stories about marriage, relationships, and finding your perfect match
          </p>
          
          {/* Search */}
          <form onSubmit={handleSearch} className="max-w-md mx-auto relative">
            <Search className="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-muted-foreground" />
            <Input
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              placeholder="Search articles..."
              className="pl-12 pr-4 py-6 text-lg rounded-full"
            />
          </form>
        </div>
      </section>

      {/* Categories Grid */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <h2 className="text-2xl font-serif font-bold text-foreground mb-8">
            Browse by Category
          </h2>
          
          {loadingCategories ? (
            <div className="text-center py-8 text-muted-foreground">Loading categories...</div>
          ) : (
            <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
              {categories?.map((category) => (
                <Link
                  key={category.id}
                  to={`/blog/category/${category.slug}`}
                  className="group relative overflow-hidden rounded-xl aspect-[4/3]"
                >
                  <img
                    src={category.thumbnail_url || getCategoryImage(category.slug)}
                    alt={category.name}
                    className="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent" />
                  <div className="absolute bottom-0 left-0 right-0 p-4">
                    <h3 className="text-white font-medium text-lg">{category.name}</h3>
                    <p className="text-white/70 text-sm line-clamp-2">{category.description}</p>
                  </div>
                </Link>
              ))}
            </div>
          )}
        </div>
      </section>

      {/* Latest Posts */}
      <section className="py-16 bg-muted/30">
        <div className="container mx-auto px-4">
          <div className="flex items-center justify-between mb-8">
            <h2 className="text-2xl font-serif font-bold text-foreground">
              {activeSearch ? `Search Results for "${activeSearch}"` : "Latest Articles"}
            </h2>
            {activeSearch && (
              <button
                onClick={() => { setActiveSearch(""); setSearchQuery(""); }}
                className="text-primary hover:underline"
              >
                Clear search
              </button>
            )}
          </div>

          {loadingPosts ? (
            <div className="text-center py-8 text-muted-foreground">Loading posts...</div>
          ) : posts?.length === 0 ? (
            <div className="text-center py-12">
              <BookOpen className="h-12 w-12 text-muted-foreground mx-auto mb-4" />
              <h3 className="text-lg font-medium text-foreground mb-2">No articles found</h3>
              <p className="text-muted-foreground">
                {activeSearch ? "Try a different search term" : "Check back soon for new content"}
              </p>
            </div>
          ) : (
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              {posts?.map((post) => (
                <article
                  key={post.id}
                  className="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow"
                >
                  <Link to={`/blog/${post.slug}`}>
                    {post.featured_image_url && (
                      <img
                        src={post.featured_image_url}
                        alt={post.title}
                        className="w-full aspect-video object-cover"
                      />
                    )}
                    <div className="p-5">
                      {post.category && (
                        <Badge variant="secondary" className="mb-2">
                          {post.category.name}
                        </Badge>
                      )}
                      <h3 className="text-lg font-serif font-bold text-foreground mb-2 line-clamp-2">
                        {post.title}
                      </h3>
                      <p className="text-muted-foreground text-sm mb-4 line-clamp-2">
                        {post.excerpt}
                      </p>
                      <div className="flex items-center justify-between text-sm">
                        <div className="flex items-center gap-1 text-muted-foreground">
                          <Calendar className="h-4 w-4" />
                          {post.published_at && format(new Date(post.published_at), "MMM d, yyyy")}
                        </div>
                        <span className="text-primary flex items-center gap-1 font-medium">
                          Read more <ArrowRight className="h-4 w-4" />
                        </span>
                      </div>
                    </div>
                  </Link>
                </article>
              ))}
            </div>
          )}
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Blog;
