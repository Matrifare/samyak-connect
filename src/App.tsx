import { Toaster } from "@/components/ui/toaster";
import { Toaster as Sonner } from "@/components/ui/sonner";
import { TooltipProvider } from "@/components/ui/tooltip";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { BrowserRouter, Routes, Route } from "react-router-dom";
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
import Membership from "./pages/Membership";
import MembershipCompare from "./pages/MembershipCompare";
import MembershipUpgrade from "./pages/MembershipUpgrade";
import MembershipSuccess from "./pages/MembershipSuccess";
import MembershipTransactions from "./pages/MembershipTransactions";

const queryClient = new QueryClient();

const App = () => (
  <QueryClientProvider client={queryClient}>
    <TooltipProvider>
      <Toaster />
      <Sonner />
      <BrowserRouter>
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
          {/* ADD ALL CUSTOM ROUTES ABOVE THE CATCH-ALL "*" ROUTE */}
          <Route path="*" element={<NotFound />} />
        </Routes>
      </BrowserRouter>
    </TooltipProvider>
  </QueryClientProvider>
);

export default App;
