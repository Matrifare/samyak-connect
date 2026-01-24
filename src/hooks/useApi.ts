import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import apiService, { Profile, Stats, SearchFilters, PaginatedResponse, Religion, Caste, City, MembershipPlan, LoginResponse } from '@/services/api';

// Featured Profiles
export function useFeaturedProfiles(limit: number = 8) {
  return useQuery<Profile[]>({
    queryKey: ['featuredProfiles', limit],
    queryFn: () => apiService.getFeaturedProfiles(limit),
    staleTime: 5 * 60 * 1000,
  });
}

// Stats
export function useStats() {
  return useQuery<Stats | null>({
    queryKey: ['stats'],
    queryFn: () => apiService.getStats(),
    staleTime: 5 * 60 * 1000,
  });
}

// Search Profiles
export function useSearchProfiles(
  filters: SearchFilters,
  page: number = 1,
  perPage: number = 20
) {
  return useQuery<PaginatedResponse<Profile>>({
    queryKey: ['searchProfiles', filters, page, perPage],
    queryFn: () => apiService.searchProfiles(filters, page, perPage),
    staleTime: 2 * 60 * 1000,
  });
}

// Single Profile
export function useProfile(matriId: string | undefined) {
  return useQuery<Profile | null>({
    queryKey: ['profile', matriId],
    queryFn: () => (matriId ? apiService.getProfile(matriId) : null),
    enabled: !!matriId,
    staleTime: 5 * 60 * 1000,
  });
}

// Religions
export function useReligions() {
  return useQuery<Religion[]>({
    queryKey: ['religions'],
    queryFn: () => apiService.getReligions(),
    staleTime: 30 * 60 * 1000, // Cache for 30 minutes
  });
}

// Castes
export function useCastes(religionId?: number) {
  return useQuery<Caste[]>({
    queryKey: ['castes', religionId],
    queryFn: () => apiService.getCastes(religionId),
    staleTime: 30 * 60 * 1000,
  });
}

// Cities
export function useCities() {
  return useQuery<City[]>({
    queryKey: ['cities'],
    queryFn: () => apiService.getCities(),
    staleTime: 30 * 60 * 1000,
  });
}

// Membership Plans
export function useMembershipPlans() {
  return useQuery<MembershipPlan[]>({
    queryKey: ['membershipPlans'],
    queryFn: () => apiService.getMembershipPlans(),
    staleTime: 30 * 60 * 1000,
  });
}

// User Stats
export function useUserStats(matriId: string | undefined, email?: string) {
  return useQuery({
    queryKey: ['userStats', matriId, email],
    queryFn: () => (matriId ? apiService.getUserStats(matriId, email) : null),
    enabled: !!matriId,
    staleTime: 2 * 60 * 1000,
  });
}

// Bookmarks/Shortlist
export function useBookmarks(matriId: string | undefined) {
  return useQuery<Profile[]>({
    queryKey: ['bookmarks', matriId],
    queryFn: () => (matriId ? apiService.getBookmarks(matriId) : []),
    enabled: !!matriId,
    staleTime: 2 * 60 * 1000,
  });
}

// Success Stories
export function useSuccessStories() {
  return useQuery({
    queryKey: ['successStories'],
    queryFn: () => apiService.getSuccessStories(),
    staleTime: 30 * 60 * 1000,
  });
}

// Login Mutation
export function useLogin() {
  const queryClient = useQueryClient();
  
  return useMutation({
    mutationFn: ({ username, password }: { username: string; password: string }) =>
      apiService.login(username, password),
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['userStats'] });
      queryClient.invalidateQueries({ queryKey: ['bookmarks'] });
    },
  });
}

// Logout Mutation
export function useLogout() {
  const queryClient = useQueryClient();
  
  return useMutation({
    mutationFn: () => apiService.logout(),
    onSuccess: () => {
      queryClient.clear();
    },
  });
}

// Add Bookmark Mutation
export function useAddBookmark() {
  const queryClient = useQueryClient();
  
  return useMutation({
    mutationFn: ({ fromId, toId }: { fromId: string; toId: string }) =>
      apiService.addBookmark(fromId, toId),
    onSuccess: (_, { fromId }) => {
      queryClient.invalidateQueries({ queryKey: ['bookmarks', fromId] });
    },
  });
}

// Remove Bookmark Mutation
export function useRemoveBookmark() {
  const queryClient = useQueryClient();
  
  return useMutation({
    mutationFn: ({ fromId, toId }: { fromId: string; toId: string }) =>
      apiService.removeBookmark(fromId, toId),
    onSuccess: (_, { fromId }) => {
      queryClient.invalidateQueries({ queryKey: ['bookmarks', fromId] });
    },
  });
}

// Send Interest Mutation
export function useSendInterest() {
  return useMutation({
    mutationFn: ({ fromId, toId }: { fromId: string; toId: string }) =>
      apiService.sendInterest(fromId, toId),
  });
}

// Record Profile View Mutation
export function useRecordProfileView() {
  return useMutation({
    mutationFn: ({ viewerId, profileId }: { viewerId: string; profileId: string }) =>
      apiService.recordProfileView(viewerId, profileId),
  });
}
