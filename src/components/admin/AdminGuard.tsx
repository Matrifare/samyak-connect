import { ReactNode } from "react";

interface AdminGuardProps {
  children: ReactNode;
}

const AdminGuard = ({ children }: AdminGuardProps) => {
  // TEMPORARY: Auth disabled for testing - remove this in production!
  return <>{children}</>;
};

export default AdminGuard;