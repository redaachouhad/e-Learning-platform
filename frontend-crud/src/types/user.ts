export interface User {
  id?: number;
  name?: string;
  email?: string;
  email_verified_at?: string | null;
  two_factor_secret?: string | null;
  two_factor_recovery_codes?: string | null;
  two_factor_confirmed_at?: string | null;
  created_at?: string;
  updated_at?: string;
  followings_count?: number;
  followers_count?: number;
  image_url?: string;
}
