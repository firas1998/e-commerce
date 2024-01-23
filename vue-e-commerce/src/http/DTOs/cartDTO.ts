import { CartProductDTO } from "./cartProductDTO";
import { ProductDTO } from "./productDTO";

export interface CartDTO {
	id?: number;
	products?: CartProductDTO[];
}
