import { useQuery } from "@tanstack/react-query";
import { useParams, Link } from "react-router-dom";
import Header from "@/components/matrimony/Header";
import Footer from "@/components/matrimony/Footer";
import { Badge } from "@/components/ui/badge";
import { Calendar, ArrowLeft, ArrowRight, BookOpen } from "lucide-react";
import { getCategoryBySlug, getPostsByCategory, BlogPost, type BlogCategory as BlogCategoryType } from "@/lib/blog";
import { format } from "date-fns";

const BlogCategory = () => {
  const { slug } = useParams<{ slug: string }>();

  const { data: category, isLoading: loadingCategory } = useQuery({
    queryKey: ["blog-category", slug],
    queryFn: () => getCategoryBySlug(slug!),
    enabled: !!slug,
  });

  const { data: posts, isLoading: loadingPosts } = useQuery({
    queryKey: ["blog-category-posts", slug],
    queryFn: () => getPostsByCategory(slug!),
    enabled: !!slug,
  });

  if (loadingCategory) {
    return (
      <div className="min-h-screen bg-background">
        <Header />
        <div className="container mx-auto px-4 py-16 text-center">
          <p className="text-muted-foreground">Loading...</p>
        </div>
        <Footer />
      </div>
    );
  }

  if (!category) {
    return (
      <div className="min-h-screen bg-background">
        <Header />
        <div className="container mx-auto px-4 py-16 text-center">
          <h1 className="text-2xl font-bold text-foreground mb-4">Category Not Found</h1>
          <Link to="/blog" className="text-primary hover:underline">
            ← Back to Blog
          </Link>
        </div>
        <Footer />
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-background">
      <Header />

      {/* Hero Section */}
      <section className="bg-gradient-to-br from-primary/10 to-secondary/10 py-16">
        <div className="container mx-auto px-4">
          <Link to="/blog" className="inline-flex items-center gap-2 text-primary mb-6 hover:underline">
            <ArrowLeft className="h-4 w-4" />
            Back to Blog
          </Link>
          <h1 className="text-4xl md:text-5xl font-serif font-bold text-foreground mb-4">
            {category.name}
          </h1>
          <p className="text-lg text-muted-foreground max-w-2xl">
            {category.description}
          </p>
        </div>
      </section>

      {/* Posts Grid */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          {loadingPosts ? (
            <div className="text-center py-8 text-muted-foreground">Loading posts...</div>
          ) : posts?.length === 0 ? (
            <div className="text-center py-12">
              <BookOpen className="h-12 w-12 text-muted-foreground mx-auto mb-4" />
              <h3 className="text-lg font-medium text-foreground mb-2">No articles yet</h3>
              <p className="text-muted-foreground">
                Check back soon for new content in this category
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

export default BlogCategory;
