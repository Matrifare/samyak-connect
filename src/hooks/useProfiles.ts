import { useQuery } from '@tanstack/react-query';
import apiService, { Profile, Stats, SearchFilters, PaginatedResponse } from '@/services/api';

export function useFeaturedProfiles(limit: number = 8) {
  return useQuery<Profile[]>({
    queryKey: ['featuredProfiles', limit],
    queryFn: () => apiService.getFeaturedProfiles(limit),
    staleTime: 5 * 60 * 1000, // 5 minutes
  });
}

export function useStats() {
  return useQuery<Stats | null>({
    queryKey: ['stats'],
    queryFn: () => apiService.getStats(),
    staleTime: 5 * 60 * 1000,
  });
}

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

export function useProfile(matriId: string | undefined) {
  return useQuery<Profile | null>({
    queryKey: ['profile', matriId],
    queryFn: () => (matriId ? apiService.getProfile(matriId) : null),
    enabled: !!matriId,
    staleTime: 5 * 60 * 1000,
  });
}
