import { useState } from "react";
import { Link } from "react-router-dom";
import { Camera, ImagePlus, Trash2, Star } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { toast } from "@/hooks/use-toast";
import DashboardSidebar from "@/components/dashboard/DashboardSidebar";
import DashboardHeader from "@/components/dashboard/DashboardHeader";
import defaultMale from "@/assets/default-male.jpg";
import defaultFemale from "@/assets/default-female.jpg";

const userData = {
  name: "Rahul More",
  profileId: "NX1235",
  avatar: defaultMale,
};

// Mock photos (ready for backend/storage integration)
const mockPhotos = [
  { id: "p1", src: defaultMale, isPrimary: true },
  { id: "p2", src: defaultFemale, isPrimary: false },
  { id: "p3", src: defaultFemale, isPrimary: false },
  { id: "p4", src: defaultFemale, isPrimary: false },
];

const Photos = () => {
  const [sidebarOpen, setSidebarOpen] = useState(false);

  const handleMockUpload = () => {
    toast({
      title: "Upload (mock)",
      description: "This is UI-only. Hook this button to file upload + storage later.",
    });
  };

  const handleMockDelete = () => {
    toast({
      title: "Delete (mock)",
      description: "This is UI-only. Hook this to delete logic later.",
      variant: "destructive",
    });
  };

  const handleMockSetPrimary = () => {
    toast({
      title: "Set Primary (mock)",
      description: "This is UI-only. Hook this to primary photo update later.",
    });
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-secondary/30 via-background to-secondary/20">
      <DashboardSidebar isOpen={sidebarOpen} onClose={() => setSidebarOpen(false)} />

      <div className="lg:pl-64">
        <DashboardHeader onMenuClick={() => setSidebarOpen(true)} user={userData} />

        <main className="p-4 md:p-6 lg:p-8">
          <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
              <h1 className="text-2xl md:text-3xl font-bold text-foreground">Manage Photos</h1>
              <p className="text-muted-foreground mt-1">
                Add, remove, and set your primary profile photo (UI-only)
              </p>
            </div>
            <div className="flex gap-3">
              <Link to="/dashboard">
                <Button variant="outline">Back to Dashboard</Button>
              </Link>
              <Button className="bg-gradient-primary" onClick={handleMockUpload}>
                <ImagePlus className="h-4 w-4 mr-2" />
                Upload Photo
              </Button>
            </div>
          </div>

          <Card className="mb-6">
            <CardHeader>
              <CardTitle className="flex items-center gap-2">
                <Camera className="h-5 w-5 text-primary" />
                Photo Guidelines
              </CardTitle>
              <CardDescription>
                Keep photos clear and respectful. Avoid group photos for primary image.
              </CardDescription>
            </CardHeader>
            <CardContent className="flex flex-wrap gap-2">
              <Badge variant="secondary">Max 10 photos</Badge>
              <Badge variant="secondary">JPG/PNG only</Badge>
              <Badge variant="secondary">Primary photo required</Badge>
            </CardContent>
          </Card>

          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {mockPhotos.map((photo) => (
              <Card key={photo.id} className="overflow-hidden">
                <div className="relative">
                  <img
                    src={photo.src}
                    alt={photo.isPrimary ? "Primary profile photo" : "Profile photo"}
                    className="w-full h-56 object-cover"
                    loading="lazy"
                  />
                  {photo.isPrimary && (
                    <div className="absolute top-3 left-3">
                      <Badge className="bg-gradient-primary text-white border-0">
                        <Star className="h-3 w-3 mr-1" />
                        Primary
                      </Badge>
                    </div>
                  )}
                </div>

                <CardContent className="p-4 flex gap-2">
                  <Button
                    variant="outline"
                    className="flex-1"
                    onClick={handleMockSetPrimary}
                    disabled={photo.isPrimary}
                  >
                    Set Primary
                  </Button>
                  <Button
                    variant="outline"
                    className="text-destructive hover:text-destructive flex-none"
                    onClick={handleMockDelete}
                  >
                    <Trash2 className="h-4 w-4" />
                  </Button>
                </CardContent>
              </Card>
            ))}

            {/* Add new card */}
            <Card className="border-dashed">
              <CardContent className="p-6 h-full flex flex-col items-center justify-center text-center">
                <div className="h-12 w-12 rounded-xl bg-primary/10 flex items-center justify-center mb-3">
                  <ImagePlus className="h-6 w-6 text-primary" />
                </div>
                <p className="font-semibold">Add more photos</p>
                <p className="text-sm text-muted-foreground mt-1">
                  Increase profile visibility with more photos
                </p>
                <Button variant="outline" className="mt-4" onClick={handleMockUpload}>
                  Upload
                </Button>
              </CardContent>
            </Card>
          </div>
        </main>
      </div>
    </div>
  );
};

export default Photos;
