import { useState } from "react";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Badge } from "@/components/ui/badge";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { Search, MoreVertical, Eye, Edit, Ban, Trash2, CheckCircle } from "lucide-react";
import AdminLayout from "@/components/admin/AdminLayout";

const mockUsers = [
  {
    id: "SM1001",
    name: "Priya Sharma",
    email: "priya@example.com",
    gender: "Female",
    status: "approved",
    membership: "Premium",
    createdAt: "2024-01-15",
  },
  {
    id: "SM1002",
    name: "Rahul More",
    email: "rahul@example.com",
    gender: "Male",
    status: "pending",
    membership: "Free",
    createdAt: "2024-01-14",
  },
  {
    id: "SF1003",
    name: "Sneha Kamble",
    email: "sneha@example.com",
    gender: "Female",
    status: "approved",
    membership: "Premium",
    createdAt: "2024-01-13",
  },
  {
    id: "SM1004",
    name: "Amit Pawar",
    email: "amit@example.com",
    gender: "Male",
    status: "suspended",
    membership: "Free",
    createdAt: "2024-01-12",
  },
];

const getStatusBadge = (status: string) => {
  switch (status) {
    case "approved":
      return <Badge className="bg-green-500/20 text-green-400 border-0">Approved</Badge>;
    case "pending":
      return <Badge className="bg-amber-500/20 text-amber-400 border-0">Pending</Badge>;
    case "suspended":
      return <Badge className="bg-red-500/20 text-red-400 border-0">Suspended</Badge>;
    default:
      return <Badge variant="outline">{status}</Badge>;
  }
};

const AdminUsers = () => {
  const [searchQuery, setSearchQuery] = useState("");

  const filteredUsers = mockUsers.filter(
    (user) =>
      user.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
      user.email.toLowerCase().includes(searchQuery.toLowerCase()) ||
      user.id.toLowerCase().includes(searchQuery.toLowerCase())
  );

  return (
    <AdminLayout>
      <div className="p-6 space-y-6">
        {/* Header */}
        <div className="flex flex-col sm:flex-row justify-between gap-4">
          <div>
            <h1 className="text-2xl font-bold text-white">All Users</h1>
            <p className="text-slate-400">Manage all registered users</p>
          </div>
          <div className="relative w-full sm:w-64">
            <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
            <Input
              placeholder="Search users..."
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              className="pl-10 bg-slate-800 border-slate-700 text-white"
            />
          </div>
        </div>

        {/* Users Table */}
        <Card className="bg-slate-800/50 border-slate-700">
          <CardContent className="p-0">
            <Table>
              <TableHeader>
                <TableRow className="border-slate-700 hover:bg-transparent">
                  <TableHead className="text-slate-400">Matri ID</TableHead>
                  <TableHead className="text-slate-400">Name</TableHead>
                  <TableHead className="text-slate-400">Email</TableHead>
                  <TableHead className="text-slate-400">Gender</TableHead>
                  <TableHead className="text-slate-400">Status</TableHead>
                  <TableHead className="text-slate-400">Membership</TableHead>
                  <TableHead className="text-slate-400">Joined</TableHead>
                  <TableHead className="text-slate-400 text-right">Actions</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {filteredUsers.map((user) => (
                  <TableRow key={user.id} className="border-slate-700 hover:bg-slate-800/50">
                    <TableCell className="text-primary font-medium">{user.id}</TableCell>
                    <TableCell className="text-white">{user.name}</TableCell>
                    <TableCell className="text-slate-300">{user.email}</TableCell>
                    <TableCell className="text-slate-300">{user.gender}</TableCell>
                    <TableCell>{getStatusBadge(user.status)}</TableCell>
                    <TableCell>
                      <Badge
                        variant="outline"
                        className={
                          user.membership === "Premium"
                            ? "border-amber-500 text-amber-400"
                            : "border-slate-500 text-slate-400"
                        }
                      >
                        {user.membership}
                      </Badge>
                    </TableCell>
                    <TableCell className="text-slate-400">{user.createdAt}</TableCell>
                    <TableCell className="text-right">
                      <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                          <Button variant="ghost" size="icon" className="text-slate-400 hover:text-white">
                            <MoreVertical className="h-4 w-4" />
                          </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end" className="bg-slate-800 border-slate-700">
                          <DropdownMenuItem className="text-slate-300 hover:text-white focus:text-white focus:bg-slate-700">
                            <Eye className="mr-2 h-4 w-4" /> View Profile
                          </DropdownMenuItem>
                          <DropdownMenuItem className="text-slate-300 hover:text-white focus:text-white focus:bg-slate-700">
                            <Edit className="mr-2 h-4 w-4" /> Edit
                          </DropdownMenuItem>
                          <DropdownMenuItem className="text-slate-300 hover:text-white focus:text-white focus:bg-slate-700">
                            <CheckCircle className="mr-2 h-4 w-4" /> Approve
                          </DropdownMenuItem>
                          <DropdownMenuItem className="text-slate-300 hover:text-white focus:text-white focus:bg-slate-700">
                            <Ban className="mr-2 h-4 w-4" /> Suspend
                          </DropdownMenuItem>
                          <DropdownMenuItem className="text-red-400 hover:text-red-300 focus:text-red-300 focus:bg-slate-700">
                            <Trash2 className="mr-2 h-4 w-4" /> Delete
                          </DropdownMenuItem>
                        </DropdownMenuContent>
                      </DropdownMenu>
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </CardContent>
        </Card>
      </div>
    </AdminLayout>
  );
};

export default AdminUsers;