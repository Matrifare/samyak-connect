import { ReactNode } from "react";
import AdminSidebar from "./AdminSidebar";
import AdminGuard from "./AdminGuard";

interface AdminLayoutProps {
  children: ReactNode;
}

const AdminLayout = ({ children }: AdminLayoutProps) => {
  return (
    <AdminGuard>
      <div className="flex min-h-screen bg-slate-950">
        <AdminSidebar />
        <main className="flex-1 overflow-auto">
          {children}
        </main>
      </div>
    </AdminGuard>
  );
};

export default AdminLayout;