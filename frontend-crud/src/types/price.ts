export interface Price {
  based_price: string | number;
  discounted_price: string | number;
  discount_start_date?: Date | null | string;
  discount_end_date?: Date | null | string;
}
