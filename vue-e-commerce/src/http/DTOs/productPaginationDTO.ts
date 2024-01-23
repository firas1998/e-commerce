import { ProductDTO } from "./productDTO";

export type Link = { url?: string; label?: string; active?: boolean };

export interface ProductPaginationDTO {
	current_page?: number;
	data?: ProductDTO[];
	first_page_url?: string;
	from?: number;
	last_page?: number;
	last_page_url?: string;
	prev_page_url?: string;
	next_page_url?: string;
	per_page?: number;
	links?: Link[];
	total?: number;
}
