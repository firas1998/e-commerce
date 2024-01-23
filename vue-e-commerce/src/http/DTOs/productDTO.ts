import { ColorDTO } from "./colorDTO";
import { SizeDTO } from "./sizeDTO";

export interface ProductDTO {
	id?: number;
	image_url?: string;
	title?: string;
	description?: string;
	price?: number;
	sizes?: SizeDTO[];
	colors?: ColorDTO[];
	created_at?: string;
	updated_at?: string;
}
