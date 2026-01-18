import { useState } from "react";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import AdminLayout from "@/components/admin/AdminLayout";
import { Card, CardContent } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import { toast } from "sonner";
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog";
import {
  Plus,
  Edit,
  Trash2,
  Tag,
  Save,
  X,
} from "lucide-react";
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
} from "@/components/ui/alert-dialog";
import { 
  getCategories, 
  createCategory, 
  updateCategory, 
  deleteCategory,
  getTags,
  createTag,
  deleteTag,
  generateSlug,
  BlogCategory,
  BlogTag 
} from "@/lib/blog";

const AdminBlogCategories = () => {
  const [editCategory, setEditCategory] = useState<BlogCategory | null>(null);
  const [newCategory, setNewCategory] = useState({ name: "", slug: "", description: "" });
  const [newTag, setNewTag] = useState({ name: "", slug: "" });
  const [isAddingCategory, setIsAddingCategory] = useState(false);
  const [isAddingTag, setIsAddingTag] = useState(false);
  const [deleteId, setDeleteId] = useState<{ type: "category" | "tag"; id: string } | null>(null);
  const queryClient = useQueryClient();

  const { data: categories, isLoading: loadingCategories } = useQuery({
    queryKey: ["blog-categories"],
    queryFn: getCategories,
  });

  const { data: tags, isLoading: loadingTags } = useQuery({
    queryKey: ["blog-tags"],
    queryFn: getTags,
  });

  const createCategoryMutation = useMutation({
    mutationFn: () => createCategory(newCategory),
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["blog-categories"] });
      toast.success("Category created");
      setIsAddingCategory(false);
      setNewCategory({ name: "", slug: "", description: "" });
    },
    onError: (error: Error) => toast.error(error.message),
  });

  const updateCategoryMutation = useMutation({
    mutationFn: () => editCategory ? updateCategory(editCategory.id, editCategory) : Promise.reject(),
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["blog-categories"] });
      toast.success("Category updated");
      setEditCategory(null);
    },
    onError: (error: Error) => toast.error(error.message),
  });

  const deleteCategoryMutation = useMutation({
    mutationFn: deleteCategory,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["blog-categories"] });
      toast.success("Category deleted");
      setDeleteId(null);
    },
    onError: (error: Error) => toast.error(error.message),
  });

  const createTagMutation = useMutation({
    mutationFn: () => createTag(newTag),
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["blog-tags"] });
      toast.success("Tag created");
      setIsAddingTag(false);
      setNewTag({ name: "", slug: "" });
    },
    onError: (error: Error) => toast.error(error.message),
  });

  const deleteTagMutation = useMutation({
    mutationFn: deleteTag,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["blog-tags"] });
      toast.success("Tag deleted");
      setDeleteId(null);
    },
    onError: (error: Error) => toast.error(error.message),
  });

  return (
    <AdminLayout>
      <div className="p-6 space-y-8">
        {/* Categories Section */}
        <div>
          <div className="flex items-center justify-between mb-4">
            <div>
              <h1 className="text-2xl font-bold text-white">Blog Categories</h1>
              <p className="text-slate-400">Organize your blog posts</p>
            </div>
            <Button onClick={() => setIsAddingCategory(true)}>
              <Plus className="h-4 w-4 mr-2" />
              Add Category
            </Button>
          </div>

          {loadingCategories ? (
            <div className="text-slate-400">Loading...</div>
          ) : (
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              {categories?.map((cat) => (
                <Card key={cat.id} className="bg-slate-800/50 border-slate-700">
                  <CardContent className="p-4">
                    <div className="flex items-start justify-between">
                      <div>
                        <h3 className="text-white font-medium">{cat.name}</h3>
                        <p className="text-xs text-slate-500">/{cat.slug}</p>
                        <p className="text-sm text-slate-400 mt-2 line-clamp-2">{cat.description}</p>
                      </div>
                      <div className="flex gap-1">
                        <Button size="sm" variant="ghost" onClick={() => setEditCategory(cat)}>
                          <Edit className="h-4 w-4 text-slate-400" />
                        </Button>
                        <Button size="sm" variant="ghost" onClick={() => setDeleteId({ type: "category", id: cat.id })}>
                          <Trash2 className="h-4 w-4 text-red-400" />
                        </Button>
                      </div>
                    </div>
                  </CardContent>
                </Card>
              ))}
            </div>
          )}
        </div>

        {/* Tags Section */}
        <div>
          <div className="flex items-center justify-between mb-4">
            <div>
              <h2 className="text-xl font-bold text-white">Tags</h2>
              <p className="text-slate-400">Add keywords to posts</p>
            </div>
            <Button onClick={() => setIsAddingTag(true)} variant="outline" className="border-slate-600 text-white">
              <Plus className="h-4 w-4 mr-2" />
              Add Tag
            </Button>
          </div>

          {loadingTags ? (
            <div className="text-slate-400">Loading...</div>
          ) : tags?.length === 0 ? (
            <p className="text-slate-500">No tags created yet.</p>
          ) : (
            <div className="flex flex-wrap gap-2">
              {tags?.map((tag) => (
                <div
                  key={tag.id}
                  className="flex items-center gap-2 bg-slate-800 border border-slate-700 rounded-full px-3 py-1"
                >
                  <Tag className="h-3 w-3 text-primary" />
                  <span className="text-sm text-white">{tag.name}</span>
                  <button
                    onClick={() => setDeleteId({ type: "tag", id: tag.id })}
                    className="text-slate-500 hover:text-red-400"
                  >
                    <X className="h-3 w-3" />
                  </button>
                </div>
              ))}
            </div>
          )}
        </div>

        {/* Add Category Dialog */}
        <Dialog open={isAddingCategory} onOpenChange={setIsAddingCategory}>
          <DialogContent className="bg-slate-900 border-slate-700">
            <DialogHeader>
              <DialogTitle className="text-white">Add Category</DialogTitle>
            </DialogHeader>
            <div className="space-y-4">
              <div>
                <Label className="text-slate-300">Name</Label>
                <Input
                  value={newCategory.name}
                  onChange={(e) => setNewCategory({ 
                    ...newCategory, 
                    name: e.target.value,
                    slug: generateSlug(e.target.value)
                  })}
                  className="bg-slate-800 border-slate-700 text-white"
                />
              </div>
              <div>
                <Label className="text-slate-300">Slug</Label>
                <Input
                  value={newCategory.slug}
                  onChange={(e) => setNewCategory({ ...newCategory, slug: e.target.value })}
                  className="bg-slate-800 border-slate-700 text-white"
                />
              </div>
              <div>
                <Label className="text-slate-300">Description</Label>
                <Textarea
                  value={newCategory.description}
                  onChange={(e) => setNewCategory({ ...newCategory, description: e.target.value })}
                  className="bg-slate-800 border-slate-700 text-white"
                  rows={3}
                />
              </div>
              <div className="flex gap-2 justify-end">
                <Button variant="outline" onClick={() => setIsAddingCategory(false)} className="border-slate-600 text-white">
                  Cancel
                </Button>
                <Button onClick={() => createCategoryMutation.mutate()}>
                  <Save className="h-4 w-4 mr-2" />
                  Save
                </Button>
              </div>
            </div>
          </DialogContent>
        </Dialog>

        {/* Edit Category Dialog */}
        <Dialog open={!!editCategory} onOpenChange={() => setEditCategory(null)}>
          <DialogContent className="bg-slate-900 border-slate-700">
            <DialogHeader>
              <DialogTitle className="text-white">Edit Category</DialogTitle>
            </DialogHeader>
            {editCategory && (
              <div className="space-y-4">
                <div>
                  <Label className="text-slate-300">Name</Label>
                  <Input
                    value={editCategory.name}
                    onChange={(e) => setEditCategory({ ...editCategory, name: e.target.value })}
                    className="bg-slate-800 border-slate-700 text-white"
                  />
                </div>
                <div>
                  <Label className="text-slate-300">Slug</Label>
                  <Input
                    value={editCategory.slug}
                    onChange={(e) => setEditCategory({ ...editCategory, slug: e.target.value })}
                    className="bg-slate-800 border-slate-700 text-white"
                  />
                </div>
                <div>
                  <Label className="text-slate-300">Description</Label>
                  <Textarea
                    value={editCategory.description || ""}
                    onChange={(e) => setEditCategory({ ...editCategory, description: e.target.value })}
                    className="bg-slate-800 border-slate-700 text-white"
                    rows={3}
                  />
                </div>
                <div className="flex gap-2 justify-end">
                  <Button variant="outline" onClick={() => setEditCategory(null)} className="border-slate-600 text-white">
                    Cancel
                  </Button>
                  <Button onClick={() => updateCategoryMutation.mutate()}>
                    <Save className="h-4 w-4 mr-2" />
                    Update
                  </Button>
                </div>
              </div>
            )}
          </DialogContent>
        </Dialog>

        {/* Add Tag Dialog */}
        <Dialog open={isAddingTag} onOpenChange={setIsAddingTag}>
          <DialogContent className="bg-slate-900 border-slate-700">
            <DialogHeader>
              <DialogTitle className="text-white">Add Tag</DialogTitle>
            </DialogHeader>
            <div className="space-y-4">
              <div>
                <Label className="text-slate-300">Name</Label>
                <Input
                  value={newTag.name}
                  onChange={(e) => setNewTag({ 
                    name: e.target.value,
                    slug: generateSlug(e.target.value)
                  })}
                  className="bg-slate-800 border-slate-700 text-white"
                />
              </div>
              <div>
                <Label className="text-slate-300">Slug</Label>
                <Input
                  value={newTag.slug}
                  onChange={(e) => setNewTag({ ...newTag, slug: e.target.value })}
                  className="bg-slate-800 border-slate-700 text-white"
                />
              </div>
              <div className="flex gap-2 justify-end">
                <Button variant="outline" onClick={() => setIsAddingTag(false)} className="border-slate-600 text-white">
                  Cancel
                </Button>
                <Button onClick={() => createTagMutation.mutate()}>
                  <Save className="h-4 w-4 mr-2" />
                  Save
                </Button>
              </div>
            </div>
          </DialogContent>
        </Dialog>

        {/* Delete Confirmation */}
        <AlertDialog open={!!deleteId} onOpenChange={() => setDeleteId(null)}>
          <AlertDialogContent className="bg-slate-900 border-slate-700">
            <AlertDialogHeader>
              <AlertDialogTitle className="text-white">
                Delete {deleteId?.type === "category" ? "Category" : "Tag"}
              </AlertDialogTitle>
              <AlertDialogDescription className="text-slate-400">
                Are you sure? This action cannot be undone.
              </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
              <AlertDialogCancel className="bg-slate-800 border-slate-700 text-white">Cancel</AlertDialogCancel>
              <AlertDialogAction
                className="bg-red-600 hover:bg-red-700"
                onClick={() => {
                  if (deleteId?.type === "category") {
                    deleteCategoryMutation.mutate(deleteId.id);
                  } else if (deleteId?.type === "tag") {
                    deleteTagMutation.mutate(deleteId.id);
                  }
                }}
              >
                Delete
              </AlertDialogAction>
            </AlertDialogFooter>
          </AlertDialogContent>
        </AlertDialog>
      </div>
    </AdminLayout>
  );
};

export default AdminBlogCategories;
