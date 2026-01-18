import { useState, useEffect } from "react";
import AdminLayout from "@/components/admin/AdminLayout";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { Label } from "@/components/ui/label";
import { Switch } from "@/components/ui/switch";
import { Badge } from "@/components/ui/badge";
import { toast } from "sonner";
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog";
import {
  Search,
  Edit,
  Save,
  X,
  Globe,
  Eye,
  EyeOff,
  RefreshCw,
} from "lucide-react";

interface PageContent {
  id: string;
  slug: string;
  page_name: string;
  seo_title: string;
  seo_description: string;
  seo_keywords: string;
  is_published: boolean;
}

// Default pages data (stored locally until database is set up)
const defaultPages: PageContent[] = [
  {
    id: "1",
    slug: "success-stories",
    page_name: "Success Stories",
    seo_title: "Success Stories - Samyak Matrimony",
    seo_description: "Read inspiring success stories of couples who found love on Samyak Matrimony",
    seo_keywords: "success stories, matrimony, wedding, couples",
    is_published: true,
  },
  {
    id: "2",
    slug: "about-us",
    page_name: "About Us",
    seo_title: "About Us - Samyak Matrimony",
    seo_description: "Learn about Samyak Matrimony - trusted Buddhist matrimonial service",
    seo_keywords: "about, matrimony, buddhist, wedding service",
    is_published: true,
  },
  {
    id: "3",
    slug: "contact-us",
    page_name: "Contact Us",
    seo_title: "Contact Us - Samyak Matrimony",
    seo_description: "Get in touch with Samyak Matrimony for queries or support",
    seo_keywords: "contact, support, help, matrimony",
    is_published: true,
  },
  {
    id: "4",
    slug: "privacy-policy",
    page_name: "Privacy Policy",
    seo_title: "Privacy Policy - Samyak Matrimony",
    seo_description: "Read our privacy policy to understand how we protect your data",
    seo_keywords: "privacy, policy, data protection",
    is_published: true,
  },
  {
    id: "5",
    slug: "terms-conditions",
    page_name: "Terms & Conditions",
    seo_title: "Terms & Conditions - Samyak Matrimony",
    seo_description: "Read our terms and conditions for using Samyak Matrimony services",
    seo_keywords: "terms, conditions, rules, agreement",
    is_published: true,
  },
  {
    id: "6",
    slug: "faq",
    page_name: "FAQ",
    seo_title: "Frequently Asked Questions - Samyak Matrimony",
    seo_description: "Find answers to common questions about Samyak Matrimony",
    seo_keywords: "faq, questions, help, support",
    is_published: true,
  },
  {
    id: "7",
    slug: "refund-policy",
    page_name: "Refund Policy",
    seo_title: "Refund Policy - Samyak Matrimony",
    seo_description: "Learn about our refund policy for premium memberships",
    seo_keywords: "refund, policy, payment, membership",
    is_published: true,
  },
];

const STORAGE_KEY = "samyak_page_content";

const AdminContent = () => {
  const [searchQuery, setSearchQuery] = useState("");
  const [pages, setPages] = useState<PageContent[]>([]);
  const [editingPage, setEditingPage] = useState<PageContent | null>(null);
  const [isDialogOpen, setIsDialogOpen] = useState(false);
  const [isLoading, setIsLoading] = useState(true);

  // Load pages from localStorage or use defaults
  useEffect(() => {
    const stored = localStorage.getItem(STORAGE_KEY);
    if (stored) {
      setPages(JSON.parse(stored));
    } else {
      setPages(defaultPages);
      localStorage.setItem(STORAGE_KEY, JSON.stringify(defaultPages));
    }
    setIsLoading(false);
  }, []);

  // Save to localStorage whenever pages change
  const savePages = (updatedPages: PageContent[]) => {
    setPages(updatedPages);
    localStorage.setItem(STORAGE_KEY, JSON.stringify(updatedPages));
  };

  const filteredPages = pages.filter(
    (page) =>
      page.page_name.toLowerCase().includes(searchQuery.toLowerCase()) ||
      page.slug.toLowerCase().includes(searchQuery.toLowerCase())
  );

  const handleEdit = (page: PageContent) => {
    setEditingPage({ ...page });
    setIsDialogOpen(true);
  };

  const handleSave = () => {
    if (!editingPage) return;
    
    const updatedPages = pages.map((p) =>
      p.id === editingPage.id ? editingPage : p
    );
    savePages(updatedPages);
    toast.success("Page SEO updated successfully!");
    setIsDialogOpen(false);
    setEditingPage(null);
  };

  const togglePublish = (pageId: string) => {
    const updatedPages = pages.map((p) =>
      p.id === pageId ? { ...p, is_published: !p.is_published } : p
    );
    savePages(updatedPages);
    toast.success("Page status updated!");
  };

  const resetToDefaults = () => {
    savePages(defaultPages);
    toast.success("Pages reset to defaults!");
  };

  const getPageIcon = (slug: string) => {
    const icons: Record<string, string> = {
      "success-stories": "💕",
      "about-us": "ℹ️",
      "contact-us": "📞",
      "privacy-policy": "🔒",
      "terms-conditions": "📜",
      "faq": "❓",
      "refund-policy": "💰",
    };
    return icons[slug] || "📄";
  };

  return (
    <AdminLayout>
      <div className="p-6 space-y-6">
        {/* Header */}
        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <div>
            <h1 className="text-2xl font-bold text-white">Content Pages</h1>
            <p className="text-slate-400">Manage page content and SEO settings</p>
          </div>
          <Button
            variant="outline"
            onClick={resetToDefaults}
            className="border-slate-600 text-slate-300 hover:bg-slate-800"
          >
            <RefreshCw className="h-4 w-4 mr-2" />
            Reset to Defaults
          </Button>
        </div>

        {/* Search */}
        <div className="relative max-w-md">
          <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-slate-400" />
          <Input
            placeholder="Search pages..."
            value={searchQuery}
            onChange={(e) => setSearchQuery(e.target.value)}
            className="pl-10 bg-slate-800 border-slate-700 text-white placeholder:text-slate-500"
          />
        </div>

        {/* Pages Grid */}
        {isLoading ? (
          <div className="text-center py-8 text-slate-400">Loading pages...</div>
        ) : (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            {filteredPages.map((page) => (
              <Card
                key={page.id}
                className="bg-slate-800/50 border-slate-700 hover:border-slate-600 transition-colors"
              >
                <CardHeader className="pb-3">
                  <div className="flex items-start justify-between">
                    <div className="flex items-center gap-3">
                      <span className="text-2xl">{getPageIcon(page.slug)}</span>
                      <div>
                        <CardTitle className="text-white text-base">
                          {page.page_name}
                        </CardTitle>
                        <p className="text-xs text-slate-500 mt-1">/{page.slug}</p>
                      </div>
                    </div>
                    <Badge
                      variant={page.is_published ? "default" : "secondary"}
                      className={page.is_published ? "bg-green-600" : "bg-slate-600"}
                    >
                      {page.is_published ? "Published" : "Draft"}
                    </Badge>
                  </div>
                </CardHeader>
                <CardContent className="space-y-3">
                  <div className="space-y-1">
                    <p className="text-xs text-slate-400">SEO Title</p>
                    <p className="text-sm text-slate-300 truncate">
                      {page.seo_title || "Not set"}
                    </p>
                  </div>
                  <div className="space-y-1">
                    <p className="text-xs text-slate-400">SEO Description</p>
                    <p className="text-sm text-slate-300 line-clamp-2">
                      {page.seo_description || "Not set"}
                    </p>
                  </div>
                  <div className="flex items-center gap-2 pt-2">
                    <Button
                      size="sm"
                      variant="outline"
                      onClick={() => handleEdit(page)}
                      className="flex-1 border-slate-600 text-slate-300 hover:bg-slate-700"
                    >
                      <Edit className="h-4 w-4 mr-1" />
                      Edit SEO
                    </Button>
                    <Button
                      size="sm"
                      variant="ghost"
                      onClick={() => togglePublish(page.id)}
                      className="text-slate-400 hover:text-white"
                    >
                      {page.is_published ? (
                        <EyeOff className="h-4 w-4" />
                      ) : (
                        <Eye className="h-4 w-4" />
                      )}
                    </Button>
                  </div>
                </CardContent>
              </Card>
            ))}
          </div>
        )}

        {/* Edit Dialog */}
        <Dialog open={isDialogOpen} onOpenChange={setIsDialogOpen}>
          <DialogContent className="bg-slate-900 border-slate-700 max-w-lg">
            <DialogHeader>
              <DialogTitle className="text-white flex items-center gap-2">
                <Globe className="h-5 w-5 text-primary" />
                Edit SEO Settings - {editingPage?.page_name}
              </DialogTitle>
            </DialogHeader>

            {editingPage && (
              <div className="space-y-4 py-4">
                <div className="space-y-2">
                  <Label htmlFor="seo_title" className="text-slate-300">
                    SEO Title
                  </Label>
                  <Input
                    id="seo_title"
                    value={editingPage.seo_title}
                    onChange={(e) =>
                      setEditingPage({ ...editingPage, seo_title: e.target.value })
                    }
                    placeholder="Enter SEO title (60 characters recommended)"
                    className="bg-slate-800 border-slate-700 text-white"
                  />
                  <p className="text-xs text-slate-500">
                    {editingPage.seo_title?.length || 0}/60 characters
                  </p>
                </div>

                <div className="space-y-2">
                  <Label htmlFor="seo_description" className="text-slate-300">
                    SEO Description
                  </Label>
                  <Textarea
                    id="seo_description"
                    value={editingPage.seo_description}
                    onChange={(e) =>
                      setEditingPage({
                        ...editingPage,
                        seo_description: e.target.value,
                      })
                    }
                    placeholder="Enter meta description (160 characters recommended)"
                    className="bg-slate-800 border-slate-700 text-white resize-none"
                    rows={3}
                  />
                  <p className="text-xs text-slate-500">
                    {editingPage.seo_description?.length || 0}/160 characters
                  </p>
                </div>

                <div className="space-y-2">
                  <Label htmlFor="seo_keywords" className="text-slate-300">
                    SEO Keywords
                  </Label>
                  <Input
                    id="seo_keywords"
                    value={editingPage.seo_keywords}
                    onChange={(e) =>
                      setEditingPage({ ...editingPage, seo_keywords: e.target.value })
                    }
                    placeholder="keyword1, keyword2, keyword3"
                    className="bg-slate-800 border-slate-700 text-white"
                  />
                  <p className="text-xs text-slate-500">
                    Separate keywords with commas
                  </p>
                </div>

                <div className="flex items-center justify-between">
                  <Label htmlFor="is_published" className="text-slate-300">
                    Published
                  </Label>
                  <Switch
                    id="is_published"
                    checked={editingPage.is_published}
                    onCheckedChange={(checked) =>
                      setEditingPage({ ...editingPage, is_published: checked })
                    }
                  />
                </div>

                <div className="flex gap-3 pt-4">
                  <Button
                    onClick={() => setIsDialogOpen(false)}
                    variant="outline"
                    className="flex-1 border-slate-600 text-slate-300 hover:bg-slate-800"
                  >
                    <X className="h-4 w-4 mr-1" />
                    Cancel
                  </Button>
                  <Button onClick={handleSave} className="flex-1">
                    <Save className="h-4 w-4 mr-1" />
                    Save Changes
                  </Button>
                </div>
              </div>
            )}
          </DialogContent>
        </Dialog>
      </div>
    </AdminLayout>
  );
};

export default AdminContent;
