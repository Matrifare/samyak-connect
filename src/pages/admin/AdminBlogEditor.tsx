import { useState, useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import AdminLayout from "@/components/admin/AdminLayout";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import { Switch } from "@/components/ui/switch";
import { toast } from "sonner";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import { Checkbox } from "@/components/ui/checkbox";
import {
  ArrowLeft,
  Save,
  Eye,
  Image as ImageIcon,
  Globe,
  FileText,
  Upload,
} from "lucide-react";
import RichTextEditor from "@/components/admin/RichTextEditor";
import {
  getCategories,
  getTags,
  getPostById,
  createPost,
  updatePost,
  uploadBlogImage,
  generateSlug,
  BlogCategory,
  BlogTag,
} from "@/lib/blog";

const AdminBlogEditor = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const queryClient = useQueryClient();
  const isEditing = !!id;

  const [formData, setFormData] = useState({
    title: "",
    slug: "",
    excerpt: "",
    content: "",
    featured_image_url: "",
    seo_title: "",
    meta_description: "",
    canonical_url: "",
    status: "draft",
    category_id: "",
    author_name: "Admin",
  });
  const [selectedTags, setSelectedTags] = useState<string[]>([]);
  const [isUploading, setIsUploading] = useState(false);

  const { data: categories } = useQuery({
    queryKey: ["blog-categories"],
    queryFn: getCategories,
  });

  const { data: tags } = useQuery({
    queryKey: ["blog-tags"],
    queryFn: getTags,
  });

  const { data: existingPost } = useQuery({
    queryKey: ["blog-post", id],
    queryFn: () => getPostById(id!),
    enabled: isEditing,
  });

  useEffect(() => {
    if (existingPost) {
      setFormData({
        title: existingPost.title,
        slug: existingPost.slug,
        excerpt: existingPost.excerpt || "",
        content: existingPost.content || "",
        featured_image_url: existingPost.featured_image_url || "",
        seo_title: existingPost.seo_title || "",
        meta_description: existingPost.meta_description || "",
        canonical_url: existingPost.canonical_url || "",
        status: existingPost.status,
        category_id: existingPost.category_id || "",
        author_name: existingPost.author_name || "Admin",
      });
      setSelectedTags(existingPost.tags?.map((t) => t.id) || []);
    }
  }, [existingPost]);

  const saveMutation = useMutation({
    mutationFn: async () => {
      const postData = {
        ...formData,
        category_id: formData.category_id || undefined,
        published_at: formData.status === "published" ? new Date().toISOString() : undefined,
      };

      if (isEditing) {
        return updatePost(id!, postData, selectedTags);
      } else {
        return createPost(postData, selectedTags);
      }
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["admin-blog-posts"] });
      toast.success(isEditing ? "Post updated!" : "Post created!");
      navigate("/admin/blog");
    },
    onError: (error: Error) => {
      toast.error("Failed to save: " + error.message);
    },
  });

  const handleImageUpload = async (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (!file) return;

    setIsUploading(true);
    try {
      const path = `posts/${Date.now()}-${file.name}`;
      const url = await uploadBlogImage(file, path);
      setFormData({ ...formData, featured_image_url: url });
      toast.success("Image uploaded!");
    } catch (error: any) {
      toast.error("Upload failed: " + error.message);
    } finally {
      setIsUploading(false);
    }
  };

  const handleTitleChange = (title: string) => {
    setFormData({
      ...formData,
      title,
      slug: isEditing ? formData.slug : generateSlug(title),
      seo_title: formData.seo_title || title,
    });
  };

  return (
    <AdminLayout>
      <div className="p-6 space-y-6">
        {/* Header */}
        <div className="flex items-center justify-between">
          <div className="flex items-center gap-4">
            <Button variant="ghost" onClick={() => navigate("/admin/blog")} className="text-slate-400">
              <ArrowLeft className="h-4 w-4 mr-2" />
              Back
            </Button>
            <h1 className="text-2xl font-bold text-white">
              {isEditing ? "Edit Post" : "New Post"}
            </h1>
          </div>
          <div className="flex items-center gap-3">
            <Select
              value={formData.status}
              onValueChange={(value) => setFormData({ ...formData, status: value })}
            >
              <SelectTrigger className="w-32 bg-slate-800 border-slate-700 text-white">
                <SelectValue />
              </SelectTrigger>
              <SelectContent className="bg-slate-800 border-slate-700">
                <SelectItem value="draft">Draft</SelectItem>
                <SelectItem value="published">Published</SelectItem>
                <SelectItem value="scheduled">Scheduled</SelectItem>
              </SelectContent>
            </Select>
            <Button onClick={() => saveMutation.mutate()} disabled={saveMutation.isPending}>
              <Save className="h-4 w-4 mr-2" />
              {saveMutation.isPending ? "Saving..." : "Save"}
            </Button>
          </div>
        </div>

        {/* Editor */}
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
          {/* Main Content */}
          <div className="lg:col-span-2 space-y-6">
            <div className="bg-slate-800/50 border border-slate-700 rounded-lg p-6 space-y-4">
              <div>
                <Label className="text-slate-300">Title</Label>
                <Input
                  value={formData.title}
                  onChange={(e) => handleTitleChange(e.target.value)}
                  placeholder="Enter post title..."
                  className="bg-slate-800 border-slate-700 text-white text-lg"
                />
              </div>
              <div>
                <Label className="text-slate-300">Slug</Label>
                <div className="flex items-center gap-2">
                  <span className="text-slate-500">/blog/</span>
                  <Input
                    value={formData.slug}
                    onChange={(e) => setFormData({ ...formData, slug: e.target.value })}
                    className="bg-slate-800 border-slate-700 text-white"
                  />
                </div>
              </div>
              <div>
                <Label className="text-slate-300">Excerpt</Label>
                <Textarea
                  value={formData.excerpt}
                  onChange={(e) => setFormData({ ...formData, excerpt: e.target.value })}
                  placeholder="Brief description for listing pages..."
                  className="bg-slate-800 border-slate-700 text-white"
                  rows={3}
                />
              </div>
              <div>
                <Label className="text-slate-300">Content</Label>
                <RichTextEditor
                  content={formData.content}
                  onChange={(html) => setFormData({ ...formData, content: html })}
                />
              </div>
            </div>

            {/* SEO Settings */}
            <div className="bg-slate-800/50 border border-slate-700 rounded-lg p-6 space-y-4">
              <div className="flex items-center gap-2 mb-4">
                <Globe className="h-5 w-5 text-primary" />
                <h2 className="text-lg font-medium text-white">SEO Settings</h2>
              </div>
              <div>
                <Label className="text-slate-300">SEO Title</Label>
                <Input
                  value={formData.seo_title}
                  onChange={(e) => setFormData({ ...formData, seo_title: e.target.value })}
                  className="bg-slate-800 border-slate-700 text-white"
                />
                <p className="text-xs text-slate-500 mt-1">{formData.seo_title?.length || 0}/60</p>
              </div>
              <div>
                <Label className="text-slate-300">Meta Description</Label>
                <Textarea
                  value={formData.meta_description}
                  onChange={(e) => setFormData({ ...formData, meta_description: e.target.value })}
                  className="bg-slate-800 border-slate-700 text-white"
                  rows={3}
                />
                <p className="text-xs text-slate-500 mt-1">{formData.meta_description?.length || 0}/160</p>
              </div>
              <div>
                <Label className="text-slate-300">Canonical URL (optional)</Label>
                <Input
                  value={formData.canonical_url}
                  onChange={(e) => setFormData({ ...formData, canonical_url: e.target.value })}
                  placeholder="https://..."
                  className="bg-slate-800 border-slate-700 text-white"
                />
              </div>
            </div>
          </div>

          {/* Sidebar */}
          <div className="space-y-6">
            {/* Featured Image */}
            <div className="bg-slate-800/50 border border-slate-700 rounded-lg p-4">
              <Label className="text-slate-300 mb-3 block">Featured Image</Label>
              {formData.featured_image_url ? (
                <div className="relative">
                  <img
                    src={formData.featured_image_url}
                    alt="Featured"
                    className="w-full aspect-video object-cover rounded-lg"
                  />
                  <Button
                    size="sm"
                    variant="destructive"
                    className="absolute top-2 right-2"
                    onClick={() => setFormData({ ...formData, featured_image_url: "" })}
                  >
                    Remove
                  </Button>
                </div>
              ) : (
                <label className="flex flex-col items-center justify-center border-2 border-dashed border-slate-600 rounded-lg p-6 cursor-pointer hover:border-primary">
                  <Upload className="h-8 w-8 text-slate-500 mb-2" />
                  <span className="text-sm text-slate-400">
                    {isUploading ? "Uploading..." : "Click to upload"}
                  </span>
                  <input
                    type="file"
                    accept="image/*"
                    onChange={handleImageUpload}
                    className="hidden"
                    disabled={isUploading}
                  />
                </label>
              )}
            </div>

            {/* Category */}
            <div className="bg-slate-800/50 border border-slate-700 rounded-lg p-4">
              <Label className="text-slate-300 mb-3 block">Category</Label>
              <Select
                value={formData.category_id}
                onValueChange={(value) => setFormData({ ...formData, category_id: value })}
              >
                <SelectTrigger className="bg-slate-800 border-slate-700 text-white">
                  <SelectValue placeholder="Select category" />
                </SelectTrigger>
                <SelectContent className="bg-slate-800 border-slate-700">
                  {categories?.map((cat) => (
                    <SelectItem key={cat.id} value={cat.id}>
                      {cat.name}
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
            </div>

            {/* Tags */}
            <div className="bg-slate-800/50 border border-slate-700 rounded-lg p-4">
              <Label className="text-slate-300 mb-3 block">Tags</Label>
              <div className="space-y-2 max-h-48 overflow-y-auto">
                {tags?.map((tag) => (
                  <div key={tag.id} className="flex items-center gap-2">
                    <Checkbox
                      id={tag.id}
                      checked={selectedTags.includes(tag.id)}
                      onCheckedChange={(checked) => {
                        if (checked) {
                          setSelectedTags([...selectedTags, tag.id]);
                        } else {
                          setSelectedTags(selectedTags.filter((t) => t !== tag.id));
                        }
                      }}
                    />
                    <label htmlFor={tag.id} className="text-sm text-slate-300 cursor-pointer">
                      {tag.name}
                    </label>
                  </div>
                ))}
                {tags?.length === 0 && (
                  <p className="text-sm text-slate-500">No tags available</p>
                )}
              </div>
            </div>

            {/* Author */}
            <div className="bg-slate-800/50 border border-slate-700 rounded-lg p-4">
              <Label className="text-slate-300 mb-3 block">Author Name</Label>
              <Input
                value={formData.author_name}
                onChange={(e) => setFormData({ ...formData, author_name: e.target.value })}
                className="bg-slate-800 border-slate-700 text-white"
              />
            </div>
          </div>
        </div>
      </div>
    </AdminLayout>
  );
};

export default AdminBlogEditor;
