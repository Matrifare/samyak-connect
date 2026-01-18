import { useQuery } from "@tanstack/react-query";
import { Link } from "react-router-dom";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Folder, TrendingUp, Calendar } from "lucide-react";
import { getCategories, getPosts, BlogCategory, BlogPost } from "@/lib/blog";
import { format } from "date-fns";

const BlogSidebar = () => {
  const { data: categories } = useQuery({
    queryKey: ["blog-categories"],
    queryFn: getCategories,
  });

  const { data: topPosts } = useQuery({
    queryKey: ["top-rated-posts"],
    queryFn: async () => {
      const posts = await getPosts();
      // Sort by view_count descending, take top 5
      return posts
        .sort((a, b) => (b.view_count || 0) - (a.view_count || 0))
        .slice(0, 5);
    },
  });

  return (
    <aside className="space-y-6">
      {/* Categories */}
      <Card className="bg-card border-border">
        <CardHeader className="pb-3">
          <CardTitle className="text-lg font-serif flex items-center gap-2">
            <Folder className="h-5 w-5 text-primary" />
            Categories
          </CardTitle>
        </CardHeader>
        <CardContent className="pt-0">
          {categories && categories.length > 0 ? (
            <ul className="space-y-2">
              {categories.map((category) => (
                <li key={category.id}>
                  <Link
                    to={`/blog/category/${category.slug}`}
                    className="flex items-center justify-between py-2 px-3 rounded-lg hover:bg-muted transition-colors group"
                  >
                    <span className="text-foreground group-hover:text-primary transition-colors">
                      {category.name}
                    </span>
                    <Badge variant="secondary" className="text-xs">
                      {category.post_count || 0}
                    </Badge>
                  </Link>
                </li>
              ))}
            </ul>
          ) : (
            <p className="text-muted-foreground text-sm">No categories yet</p>
          )}
        </CardContent>
      </Card>

      {/* Top Rated Posts */}
      <Card className="bg-card border-border">
        <CardHeader className="pb-3">
          <CardTitle className="text-lg font-serif flex items-center gap-2">
            <TrendingUp className="h-5 w-5 text-primary" />
            Popular Posts
          </CardTitle>
        </CardHeader>
        <CardContent className="pt-0">
          {topPosts && topPosts.length > 0 ? (
            <ul className="space-y-4">
              {topPosts.map((post, index) => (
                <li key={post.id}>
                  <Link
                    to={`/blog/${post.slug}`}
                    className="flex gap-3 group"
                  >
                    {post.featured_image_url ? (
                      <img
                        src={post.featured_image_url}
                        alt=""
                        className="w-16 h-16 object-cover rounded-lg flex-shrink-0"
                      />
                    ) : (
                      <div className="w-16 h-16 bg-muted rounded-lg flex-shrink-0 flex items-center justify-center">
                        <span className="text-2xl font-bold text-muted-foreground">
                          {index + 1}
                        </span>
                      </div>
                    )}
                    <div className="flex-1 min-w-0">
                      <h4 className="text-sm font-medium text-foreground line-clamp-2 group-hover:text-primary transition-colors">
                        {post.title}
                      </h4>
                      {post.published_at && (
                        <div className="flex items-center gap-1 mt-1 text-xs text-muted-foreground">
                          <Calendar className="h-3 w-3" />
                          {format(new Date(post.published_at), "MMM d, yyyy")}
                        </div>
                      )}
                    </div>
                  </Link>
                </li>
              ))}
            </ul>
          ) : (
            <p className="text-muted-foreground text-sm">No posts yet</p>
          )}
        </CardContent>
      </Card>
    </aside>
  );
};

export default BlogSidebar;
