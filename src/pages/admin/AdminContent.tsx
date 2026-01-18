import { useState, useEffect } from "react";
import AdminLayout from "@/components/admin/AdminLayout";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { Label } from "@/components/ui/label";
import { Switch } from "@/components/ui/switch";
import { Badge } from "@/components/ui/badge";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { toast } from "sonner";
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog";
import {
  Search,
  Save,
  X,
  Globe,
  Eye,
  EyeOff,
  RefreshCw,
  FileText,
} from "lucide-react";
import { usePageContent, PageContent } from "@/hooks/usePageContent";
import RichTextEditor from "@/components/admin/RichTextEditor";

const STORAGE_KEY = "samyak_page_content";

const AdminContent = () => {
  const [searchQuery, setSearchQuery] = useState("");
  const [pages, setPages] = useState<PageContent[]>([]);
  const [editingPage, setEditingPage] = useState<PageContent | null>(null);
  const [isDialogOpen, setIsDialogOpen] = useState(false);
  const [editMode, setEditMode] = useState<"seo" | "content">("seo");
  const [isLoading, setIsLoading] = useState(true);
  const { defaultPages } = usePageContent();

  // Load pages from localStorage or use defaults
  useEffect(() => {
    const stored = localStorage.getItem(STORAGE_KEY);
    if (stored) {
      try {
        const parsed = JSON.parse(stored);
        const merged = defaultPages.map((defaultPage) => {
          const storedPage = parsed.find((p: PageContent) => p.id === defaultPage.id);
          if (storedPage) {
            return {
              ...defaultPage,
              ...storedPage,
              content: { ...defaultPage.content, ...storedPage.content },
            };
          }
          return defaultPage;
        });
        setPages(merged);
      } catch {
        setPages(defaultPages);
      }
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

  const handleEditSEO = (page: PageContent) => {
    setEditingPage({ ...page });
    setEditMode("seo");
    setIsDialogOpen(true);
  };

  const handleEditContent = (page: PageContent) => {
    setEditingPage({ ...page });
    setEditMode("content");
    setIsDialogOpen(true);
  };

  const handleSave = () => {
    if (!editingPage) return;
    
    const updatedPages = pages.map((p) =>
      p.id === editingPage.id ? editingPage : p
    );
    savePages(updatedPages);
    toast.success(editMode === "seo" ? "SEO settings updated!" : "Page content updated!");
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
                    <p className="text-xs text-slate-400">Page Heading</p>
                    <p className="text-sm text-slate-300 truncate">
                      {page.content?.heading || "Not set"}
                    </p>
                  </div>
                  
                  {/* Action Buttons */}
                  <div className="flex flex-col gap-2 pt-2">
                    <div className="flex gap-2">
                      <Button
                        size="sm"
                        variant="outline"
                        onClick={() => handleEditSEO(page)}
                        className="flex-1 border-slate-500 bg-slate-700/50 text-white hover:bg-slate-600 hover:text-white"
                      >
                        <Globe className="h-4 w-4 mr-1" />
                        Edit SEO
                      </Button>
                      <Button
                        size="sm"
                        onClick={() => handleEditContent(page)}
                        className="flex-1 bg-blue-600 text-white hover:bg-blue-700"
                      >
                        <FileText className="h-4 w-4 mr-1" />
                        Edit Content
                      </Button>
                    </div>
                    <Button
                      size="sm"
                      variant="ghost"
                      onClick={() => togglePublish(page.id)}
                      className="w-full text-slate-300 hover:text-white hover:bg-slate-700"
                    >
                      {page.is_published ? (
                        <>
                          <EyeOff className="h-4 w-4 mr-1" />
                          Unpublish
                        </>
                      ) : (
                        <>
                          <Eye className="h-4 w-4 mr-1" />
                          Publish
                        </>
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
          <DialogContent className="bg-slate-900 border-slate-700 max-w-2xl max-h-[90vh] overflow-y-auto">
            <DialogHeader>
              <DialogTitle className="text-white flex items-center gap-2">
                {editMode === "seo" ? (
                  <>
                    <Globe className="h-5 w-5 text-primary" />
                    Edit SEO - {editingPage?.page_name}
                  </>
                ) : (
                  <>
                    <FileText className="h-5 w-5 text-blue-400" />
                    Edit Content - {editingPage?.page_name}
                  </>
                )}
              </DialogTitle>
            </DialogHeader>

            {editingPage && (
              <Tabs value={editMode} onValueChange={(v) => setEditMode(v as "seo" | "content")}>
                <TabsList className="grid w-full grid-cols-2 bg-slate-800">
                  <TabsTrigger value="seo" className="data-[state=active]:bg-primary">
                    <Globe className="h-4 w-4 mr-2" />
                    SEO Settings
                  </TabsTrigger>
                  <TabsTrigger value="content" className="data-[state=active]:bg-blue-600">
                    <FileText className="h-4 w-4 mr-2" />
                    Page Content
                  </TabsTrigger>
                </TabsList>

                <TabsContent value="seo" className="space-y-4 py-4">
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
                </TabsContent>

                <TabsContent value="content" className="space-y-4 py-4">
                  <div className="space-y-2">
                    <Label htmlFor="heading" className="text-slate-300">
                      Page Heading
                    </Label>
                    <Input
                      id="heading"
                      value={editingPage.content?.heading || ""}
                      onChange={(e) =>
                        setEditingPage({
                          ...editingPage,
                          content: { ...editingPage.content, heading: e.target.value },
                        })
                      }
                      placeholder="Main heading displayed on the page"
                      className="bg-slate-800 border-slate-700 text-white"
                    />
                  </div>

                  <div className="space-y-2">
                    <Label htmlFor="subheading" className="text-slate-300">
                      Subheading / Tagline
                    </Label>
                    <Textarea
                      id="subheading"
                      value={editingPage.content?.subheading || ""}
                      onChange={(e) =>
                        setEditingPage({
                          ...editingPage,
                          content: { ...editingPage.content, subheading: e.target.value },
                        })
                      }
                      placeholder="Short description shown below the heading"
                      className="bg-slate-800 border-slate-700 text-white resize-none"
                      rows={2}
                    />
                  </div>

                  <div className="space-y-2">
                    <Label className="text-slate-300">
                      Page Body Content
                    </Label>
                    <RichTextEditor
                      content={editingPage.content?.body || ""}
                      onChange={(html) =>
                        setEditingPage({
                          ...editingPage,
                          content: { ...editingPage.content, body: html },
                        })
                      }
                      placeholder="Main content of the page"
                    />
                    <p className="text-xs text-slate-500">
                      Use the toolbar to format text with headings, bold, lists, etc.
                    </p>
                  </div>
                </TabsContent>

                <div className="flex items-center justify-between pt-4 border-t border-slate-700">
                  <div className="flex items-center gap-2">
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
                  <div className="flex gap-3">
                    <Button
                      onClick={() => setIsDialogOpen(false)}
                      variant="outline"
                      className="border-slate-600 text-slate-300 hover:bg-slate-800"
                    >
                      <X className="h-4 w-4 mr-1" />
                      Cancel
                    </Button>
                    <Button onClick={handleSave}>
                      <Save className="h-4 w-4 mr-1" />
                      Save Changes
                    </Button>
                  </div>
                </div>
              </Tabs>
            )}
          </DialogContent>
        </Dialog>
      </div>
    </AdminLayout>
  );
};

export default AdminContent;
