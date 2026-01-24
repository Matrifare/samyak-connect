/**
 * API Service for fetching data from the matrimony backend
 * Connects to the Node.js API at m.samyakmatrimony.com
 */

const API_BASE_URL = 'https://m.samyakmatrimony.com/api';

export interface Profile {
  matri_id: string;
  index_id?: number;
  username?: string;
  firstname: string;
  lastname: string;
  gender: string;
  birthdate: string;
  height: string;
  education_level?: number;
  education_field?: number;
  edu_detail?: string;
  occupation?: number;
  city?: number;
  photo1?: string;
  photo1_approve?: string;
  age?: number;
  religion?: number;
  caste?: number;
  m_status?: string;
  profile_text?: string;
  fstatus?: string;
  status?: string;
  last_login?: string;
  reg_date?: string;
  // View fields
  religion_name?: string;
  caste_name?: string;
  city_name?: string;
  country_name?: string;
  edu_name?: string;
  ocp_name?: string;
  photo_protect?: string;
  photo_view_status?: string;
  profileby?: string;
}

export interface Stats {
  total_profiles: number;
  male_profiles: number;
  female_profiles: number;
  success_stories: number;
}

export interface SearchFilters {
  gender?: string;
  age_from?: string;
  age_to?: string;
  religion?: string;
  caste?: string;
  city?: string;
  m_status?: string;
  photo_search?: boolean;
  sort_by?: string;
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

export interface LoginResponse {
  token: string;
  matri_id: string;
}

export interface Religion {
  religion_id: number;
  religion_name: string;
}

export interface Caste {
  caste_id: number;
  caste_name: string;
  religion_id: number;
}

export interface City {
  city_id: number;
  city_name: string;
  state_id?: number;
}

export interface MembershipPlan {
  p_id: number;
  p_plan: string;
  p_price: number;
  p_duration: string;
  p_description?: string;
}

class ApiService {
  private baseUrl: string;
  private token: string | null = null;

  constructor(baseUrl: string = API_BASE_URL) {
    this.baseUrl = baseUrl;
    this.token = localStorage.getItem('auth_token');
  }

  private getHeaders(): HeadersInit {
    const headers: HeadersInit = {
      'Content-Type': 'application/json',
    };
    if (this.token) {
      headers['Authorization'] = `Bearer ${this.token}`;
    }
    return headers;
  }

  setToken(token: string) {
    this.token = token;
    localStorage.setItem('auth_token', token);
  }

  clearToken() {
    this.token = null;
    localStorage.removeItem('auth_token');
  }

  // Authentication
  async login(username: string, password: string): Promise<LoginResponse | null> {
    try {
      const response = await fetch(`${this.baseUrl}/login`, {
        method: 'POST',
        headers: this.getHeaders(),
        credentials: 'include',
        body: JSON.stringify({ username, password }),
      });
      
      if (response.ok) {
        const data = await response.json();
        this.setToken(data.token);
        return data;
      }
      return null;
    } catch (error) {
      console.error('Login error:', error);
      return null;
    }
  }

  async logout(): Promise<void> {
    try {
      await fetch(`${this.baseUrl}/logout`, {
        method: 'POST',
        headers: this.getHeaders(),
        credentials: 'include',
      });
    } catch (error) {
      console.error('Logout error:', error);
    }
    this.clearToken();
  }

  // Featured Profiles
  async getFeaturedProfiles(limit: number = 8): Promise<Profile[]> {
    try {
      const response = await fetch(
        `${this.baseUrl}/showmoreprofiles/featuredprofiles?limit=${limit}&orderby=index_id&order=DESC`,
        {
          headers: this.getHeaders(),
          credentials: 'include',
        }
      );
      if (response.ok) {
        return await response.json();
      }
      return [];
    } catch (error) {
      console.error('Error fetching featured profiles:', error);
      return [];
    }
  }

  // Stats - using register count
  async getStats(): Promise<Stats | null> {
    try {
      const response = await fetch(`${this.baseUrl}/stats`, {
        headers: this.getHeaders(),
      });
      if (response.ok) {
        return await response.json();
      }
      
      // Fallback: fetch counts from register
      const maleResponse = await fetch(
        `${this.baseUrl}/register/multisearch-view?gender=Groom&limit=1`,
        { headers: this.getHeaders() }
      );
      const femaleResponse = await fetch(
        `${this.baseUrl}/register/multisearch-view?gender=Bride&limit=1`,
        { headers: this.getHeaders() }
      );
      
      const maleData = await maleResponse.json();
      const femaleData = await femaleResponse.json();
      
      return {
        total_profiles: (maleData.count || 0) + (femaleData.count || 0),
        male_profiles: maleData.count || 0,
        female_profiles: femaleData.count || 0,
        success_stories: 500, // Default value, can be fetched from success_story table
      };
    } catch (error) {
      console.error('Error fetching stats:', error);
      return null;
    }
  }

  // Search Profiles
  async searchProfiles(
    filters: SearchFilters,
    page: number = 1,
    perPage: number = 20
  ): Promise<PaginatedResponse<Profile>> {
    try {
      const params = new URLSearchParams({
        page: page.toString(),
        limit: perPage.toString(),
      });

      Object.entries(filters).forEach(([key, value]) => {
        if (value !== undefined && value !== null && value !== '') {
          params.append(key, value.toString());
        }
      });

      const response = await fetch(
        `${this.baseUrl}/register/multisearch-view?${params}`,
        {
          headers: this.getHeaders(),
          credentials: 'include',
        }
      );
      
      if (response.ok) {
        const result = await response.json();
        // API returns { count, rows }
        return {
          data: result.rows || [],
          pagination: {
            total: result.count || 0,
            page,
            per_page: perPage,
            total_pages: Math.ceil((result.count || 0) / perPage),
          },
        };
      }
      throw new Error('Failed to search profiles');
    } catch (error) {
      console.error('Error searching profiles:', error);
      return {
        data: [],
        pagination: { total: 0, page: 1, per_page: perPage, total_pages: 0 },
      };
    }
  }

  // Get Single Profile
  async getProfile(matriId: string): Promise<Profile | null> {
    try {
      const response = await fetch(
        `${this.baseUrl}/register/findByMatriId/${matriId}`,
        {
          headers: this.getHeaders(),
          credentials: 'include',
        }
      );
      if (response.ok) {
        const data = await response.json();
        return Array.isArray(data) ? data[0] : data;
      }
      return null;
    } catch (error) {
      console.error('Error fetching profile:', error);
      return null;
    }
  }

  // Get Religions
  async getReligions(): Promise<Religion[]> {
    try {
      const response = await fetch(`${this.baseUrl}/religion/approved`, {
        headers: this.getHeaders(),
      });
      if (response.ok) {
        return await response.json();
      }
      return [];
    } catch (error) {
      console.error('Error fetching religions:', error);
      return [];
    }
  }

  // Get Castes by Religion
  async getCastes(religionId?: number): Promise<Caste[]> {
    try {
      const url = religionId
        ? `${this.baseUrl}/cast/query?religion_id=${religionId}`
        : `${this.baseUrl}/cast/query`;
      const response = await fetch(url, {
        headers: this.getHeaders(),
      });
      if (response.ok) {
        return await response.json();
      }
      return [];
    } catch (error) {
      console.error('Error fetching castes:', error);
      return [];
    }
  }

  // Get Cities
  async getCities(): Promise<City[]> {
    try {
      const response = await fetch(`${this.baseUrl}/city/approved`, {
        headers: this.getHeaders(),
      });
      if (response.ok) {
        return await response.json();
      }
      return [];
    } catch (error) {
      console.error('Error fetching cities:', error);
      return [];
    }
  }

  // Get Membership Plans
  async getMembershipPlans(): Promise<MembershipPlan[]> {
    try {
      const response = await fetch(`${this.baseUrl}/membershipplan/query`, {
        headers: this.getHeaders(),
      });
      if (response.ok) {
        return await response.json();
      }
      return [];
    } catch (error) {
      console.error('Error fetching membership plans:', error);
      return [];
    }
  }

  // User Stats
  async getUserStats(matriId: string, email?: string): Promise<any> {
    try {
      const url = email
        ? `${this.baseUrl}/stats/user/${matriId}?email=${encodeURIComponent(email)}`
        : `${this.baseUrl}/stats/user/${matriId}`;
      const response = await fetch(url, {
        headers: this.getHeaders(),
        credentials: 'include',
      });
      if (response.ok) {
        return await response.json();
      }
      return null;
    } catch (error) {
      console.error('Error fetching user stats:', error);
      return null;
    }
  }

  // Shortlist/Bookmark
  async getBookmarks(matriId: string): Promise<Profile[]> {
    try {
      const response = await fetch(
        `${this.baseUrl}/showmoreprofiles/shortlisted?matri_id=${matriId}`,
        {
          headers: this.getHeaders(),
          credentials: 'include',
        }
      );
      if (response.ok) {
        return await response.json();
      }
      return [];
    } catch (error) {
      console.error('Error fetching bookmarks:', error);
      return [];
    }
  }

  async addBookmark(fromId: string, toId: string): Promise<boolean> {
    try {
      const response = await fetch(`${this.baseUrl}/showmoreprofiles/addBookmark`, {
        method: 'POST',
        headers: this.getHeaders(),
        credentials: 'include',
        body: JSON.stringify({ from_id: fromId, to_id: toId }),
      });
      return response.ok;
    } catch (error) {
      console.error('Error adding bookmark:', error);
      return false;
    }
  }

  async removeBookmark(fromId: string, toId: string): Promise<boolean> {
    try {
      const response = await fetch(`${this.baseUrl}/showmoreprofiles/deleteBookmark`, {
        method: 'DELETE',
        headers: this.getHeaders(),
        credentials: 'include',
        body: JSON.stringify({ from_id: fromId, to_id: toId }),
      });
      return response.ok;
    } catch (error) {
      console.error('Error removing bookmark:', error);
      return false;
    }
  }

  // Express Interest
  async sendInterest(fromId: string, toId: string): Promise<boolean> {
    try {
      const response = await fetch(`${this.baseUrl}/expressinterest`, {
        method: 'POST',
        headers: this.getHeaders(),
        credentials: 'include',
        body: JSON.stringify({ from_id: fromId, to_id: toId }),
      });
      return response.ok;
    } catch (error) {
      console.error('Error sending interest:', error);
      return false;
    }
  }

  // Profile View Tracking
  async recordProfileView(viewerId: string, profileId: string): Promise<boolean> {
    try {
      const response = await fetch(`${this.baseUrl}/showmoreprofiles/addWhoViewedMyProfile`, {
        method: 'POST',
        headers: this.getHeaders(),
        credentials: 'include',
        body: JSON.stringify({ my_id: profileId, viewed_member_id: viewerId }),
      });
      return response.ok;
    } catch (error) {
      console.error('Error recording profile view:', error);
      return false;
    }
  }

  // Get Success Stories
  async getSuccessStories(): Promise<any[]> {
    try {
      const response = await fetch(`${this.baseUrl}/showmoreprofiles/success_story`, {
        headers: this.getHeaders(),
      });
      if (response.ok) {
        return await response.json();
      }
      return [];
    } catch (error) {
      console.error('Error fetching success stories:', error);
      return [];
    }
  }

  // Photo URL helper
  getPhotoUrl(photo: string | null, watermark: boolean = true): string {
    if (!photo) {
      return 'https://via.placeholder.com/300x400?text=No+Photo';
    }
    // Watermarked photos are in uploads/photos/watermark/
    if (watermark) {
      return `https://m.samyakmatrimony.com/uploads/photos/watermark/${photo}`;
    }
    return `https://m.samyakmatrimony.com/uploads/photos/${photo}`;
  }

  // Calculate age from birthdate
  calculateAge(birthdate: string): number {
    if (!birthdate) return 0;
    const today = new Date();
    const birth = new Date(birthdate);
    let age = today.getFullYear() - birth.getFullYear();
    const monthDiff = today.getMonth() - birth.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
      age--;
    }
    return age;
  }
}

export const apiService = new ApiService();
export default apiService;
