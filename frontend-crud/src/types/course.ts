import type { Category } from "./category";
import type { Language } from "./language";
import type { Pricing } from "./pricing";
import type { Proficiency } from "./proficiency";
import type { User } from "./user";

export interface Course {
  id?: number;
  title: string;
  description: string;
  user_id?: number;
  category_id?: number;
  based_price: number;
  discounted_price: number | null;
  discount_start_date: string | null | Date;
  discount_end_date: string | null | Date;
  requirements?: string[];
  goals?: string[];
  created_at?: string | Date;
  updated_at?: string | Date;
  creator: User;
  category: Category;
  pricing: Pricing;
  proficiency: Proficiency;
  language: Language;
  enrolled_users_count: number | undefined;
  image_url?: string;
}
