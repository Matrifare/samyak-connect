import { useEffect } from "react";
import { Toaster } from "@/components/ui/toaster";
import { Toaster as Sonner } from "@/components/ui/sonner";
import { TooltipProvider } from "@/components/ui/tooltip";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { BrowserRouter, Routes, Route, useNavigate, useLocation } from "react-router-dom";
import { AuthProvider } from "@/contexts/AuthContext";
import Index from "./pages/Index";
import Login from "./pages/Login";
import Register from "./pages/Register";
import SearchResults from "./pages/SearchResults";
import Profile from "./pages/Profile";
import Contact from "./pages/Contact";
import NotFound from "./pages/NotFound";
import Dashboard from "./pages/Dashboard";
import ProfileEdit from "./pages/dashboard/ProfileEdit";
import Preferences from "./pages/dashboard/Preferences";
import Matches from "./pages/dashboard/Matches";
import Shortlisted from "./pages/dashboard/Shortlisted";
import Interests from "./pages/dashboard/Interests";
import Settings from "./pages/dashboard/Settings";
import DashboardSearch from "./pages/dashboard/Search";
import Photos from "./pages/dashboard/Photos";
import ProfileStatistics from "./pages/dashboard/ProfileStatistics";
import Membership from "./pages/Membership";
import MembershipCompare from "./pages/MembershipCompare";
import MembershipUpgrade from "./pages/MembershipUpgrade";
import MembershipSuccess from "./pages/MembershipSuccess";
import MembershipTransactions from "./pages/MembershipTransactions";

// Content Pages
import SuccessStories from "./pages/SuccessStories";
import About from "./pages/About";
import Privacy from "./pages/Privacy";
import Terms from "./pages/Terms";
import FAQ from "./pages/FAQ";
import Refund from "./pages/Refund";

// Admin Pages
import AdminLogin from "./pages/admin/AdminLogin";
import AdminDashboard from "./pages/admin/AdminDashboard";
import AdminUsers from "./pages/admin/AdminUsers";
import AdminApprovals from "./pages/admin/AdminApprovals";
import AdminReports from "./pages/admin/AdminReports";
import AdminSettings from "./pages/admin/AdminSettings";
import AdminContent from "./pages/admin/AdminContent";
import AdminBlogPosts from "./pages/admin/AdminBlogPosts";
import AdminBlogCategories from "./pages/admin/AdminBlogCategories";
import AdminBlogEditor from "./pages/admin/AdminBlogEditor";

// Blog Pages
import Blog from "./pages/Blog";
import BlogCategory from "./pages/BlogCategory";
import BlogPost from "./pages/BlogPost";

const queryClient = new QueryClient();

// Handle redirect from 404.html for SPA routing
const RedirectHandler = ({ children }: { children: React.ReactNode }) => {
  const navigate = useNavigate();
  const location = useLocation();

  useEffect(() => {
    const params = new URLSearchParams(location.search);
    const redirectPath = params.get('redirect');
    if (redirectPath && location.pathname === '/') {
      navigate(redirectPath, { replace: true });
    }
  }, [location, navigate]);

  return <>{children}</>;
};

const App = () => (
  <QueryClientProvider client={queryClient}>
    <TooltipProvider>
      <Toaster />
      <Sonner />
      <BrowserRouter>
        <AuthProvider>
          <RedirectHandler>
            <Routes>
              <Route path="/" element={<Index />} />
              <Route path="/login" element={<Login />} />
              <Route path="/register" element={<Register />} />
              <Route path="/search" element={<SearchResults />} />
              <Route path="/profile/:id" element={<Profile />} />
              <Route path="/contact" element={<Contact />} />
              <Route path="/dashboard" element={<Dashboard />} />
              <Route path="/dashboard/profile" element={<ProfileEdit />} />
              <Route path="/dashboard/photos" element={<Photos />} />
              <Route path="/dashboard/statistics" element={<ProfileStatistics />} />
              <Route path="/dashboard/search" element={<DashboardSearch />} />
              <Route path="/dashboard/preferences" element={<Preferences />} />
              <Route path="/dashboard/matches" element={<Matches />} />
              <Route path="/dashboard/shortlisted" element={<Shortlisted />} />
              <Route path="/dashboard/interests" element={<Interests />} />
              <Route path="/dashboard/settings" element={<Settings />} />
              <Route path="/membership" element={<Membership />} />
              <Route path="/membership/compare" element={<MembershipCompare />} />
              <Route path="/membership/upgrade" element={<MembershipUpgrade />} />
              <Route path="/membership/success" element={<MembershipSuccess />} />
              <Route path="/membership/transactions" element={<MembershipTransactions />} />
              
              {/* Content Pages */}
              <Route path="/success-stories" element={<SuccessStories />} />
              <Route path="/about" element={<About />} />
              <Route path="/privacy" element={<Privacy />} />
              <Route path="/terms" element={<Terms />} />
              <Route path="/faq" element={<FAQ />} />
              <Route path="/refund" element={<Refund />} />
              
{/* Blog Routes */}
              <Route path="/blog" element={<Blog />} />
              <Route path="/blog/category/:slug" element={<BlogCategory />} />
              <Route path="/blog/:slug" element={<BlogPost />} />

              {/* Admin Routes */}
              <Route path="/admin/login" element={<AdminLogin />} />
              <Route path="/admin" element={<AdminDashboard />} />
              <Route path="/admin/users" element={<AdminUsers />} />
              <Route path="/admin/approvals" element={<AdminApprovals />} />
              <Route path="/admin/reports" element={<AdminReports />} />
              <Route path="/admin/settings" element={<AdminSettings />} />
              <Route path="/admin/content" element={<AdminContent />} />
              <Route path="/admin/blog" element={<AdminBlogPosts />} />
              <Route path="/admin/blog/new" element={<AdminBlogEditor />} />
              <Route path="/admin/blog/edit/:id" element={<AdminBlogEditor />} />
              <Route path="/admin/blog/categories" element={<AdminBlogCategories />} />
              
              {/* ADD ALL CUSTOM ROUTES ABOVE THE CATCH-ALL "*" ROUTE */}
              <Route path="*" element={<NotFound />} />
            </Routes>
          </RedirectHandler>
        </AuthProvider>
      </BrowserRouter>
    </TooltipProvider>
  </QueryClientProvider>
);

export default App;