import { ColorDTO } from "./colorDTO";
import { ProductDTO } from "./productDTO";
import { SizeDTO } from "./sizeDTO";

export interface CartProductDTO {
	id?: number;
	product?: ProductDTO;
	size?: SizeDTO;
	color?: ColorDTO;
}
