/**
 * API Service for fetching data from the matrimony backend
 */

const API_BASE_URL = 'https://m.samyakmatrimony.com/api';

export interface Profile {
  matri_id: string;
  username: string;
  gender: string;
  birthdate: string;
  height: string;
  education: string;
  occupation: string;
  city: string;
  photo1: string;
  age: number;
  religion_name: string;
  caste_name: string;
  city_name: string;
}

export interface Stats {
  total_profiles: number;
  male_profiles: number;
  female_profiles: number;
  success_stories: number;
}

export interface SearchFilters {
  gender?: string;
  age_from?: number;
  age_to?: number;
  religion?: string;
  caste?: string;
  city?: string;
  m_status?: string;
}

export interface PaginatedResponse<T> {
  data: T[];
  pagination: {
    total: number;
    page: number;
    per_page: number;
    total_pages: number;
  };
}

class ApiService {
  private baseUrl: string;

  constructor(baseUrl: string = API_BASE_URL) {
    this.baseUrl = baseUrl;
  }

  async getFeaturedProfiles(limit: number = 8): Promise<Profile[]> {
    try {
      const response = await fetch(
        `${this.baseUrl}/profiles.php?action=featured&limit=${limit}`
      );
      const result = await response.json();
      if (result.success) {
        return result.data;
      }
      throw new Error(result.error || 'Failed to fetch profiles');
    } catch (error) {
      console.error('Error fetching featured profiles:', error);
      return [];
    }
  }

  async getStats(): Promise<Stats | null> {
    try {
      const response = await fetch(
        `${this.baseUrl}/profiles.php?action=stats`
      );
      const result = await response.json();
      if (result.success) {
        return result.data;
      }
      throw new Error(result.error || 'Failed to fetch stats');
    } catch (error) {
      console.error('Error fetching stats:', error);
      return null;
    }
  }

  async searchProfiles(
    filters: SearchFilters,
    page: number = 1,
    perPage: number = 20
  ): Promise<PaginatedResponse<Profile>> {
    try {
      const params = new URLSearchParams({
        action: 'search',
        page: page.toString(),
        per_page: perPage.toString(),
      });

      Object.entries(filters).forEach(([key, value]) => {
        if (value !== undefined && value !== null && value !== '') {
          params.append(key, value.toString());
        }
      });

      const response = await fetch(`${this.baseUrl}/profiles.php?${params}`);
      const result = await response.json();
      
      if (result.success) {
        return {
          data: result.data,
          pagination: result.pagination,
        };
      }
      throw new Error(result.error || 'Failed to search profiles');
    } catch (error) {
      console.error('Error searching profiles:', error);
      return {
        data: [],
        pagination: { total: 0, page: 1, per_page: perPage, total_pages: 0 },
      };
    }
  }

  async getProfile(matriId: string): Promise<Profile | null> {
    try {
      const response = await fetch(
        `${this.baseUrl}/profiles.php?action=profile&id=${matriId}`
      );
      const result = await response.json();
      if (result.success) {
        return result.data;
      }
      throw new Error(result.error || 'Failed to fetch profile');
    } catch (error) {
      console.error('Error fetching profile:', error);
      return null;
    }
  }

  getPhotoUrl(photo: string | null): string {
    if (!photo) {
      return 'https://via.placeholder.com/300x400?text=No+Photo';
    }
    // Assuming photos are stored in uploads folder
    return `https://m.samyakmatrimony.com/uploads/photos/${photo}`;
  }
}

export const apiService = new ApiService();
export default apiService;
