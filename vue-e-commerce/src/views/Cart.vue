<template>
	<div class="common-layout container">
		<el-container>
			<el-header><h1>Cart</h1></el-header>
			<el-main>
				<div class="items-container">
					<div
						class="flex item-container"
						v-for="cartItem in cartProducts"
						:key="cartItem.cartProduct.id"
					>
						<div class="flex-1">
							<img
								:src="cartItem.cartProduct.product?.image_url"
								class="image"
								style="
									max-width: 100%;
									max-height: 100%;
									cursor: pointer;
								"
								@click="
									() => {
										showProductPage(
											cartItem.cartProduct?.product?.id
										);
									}
								"
							/>
						</div>
						<div class="flex-2 align-left">
							<div class="align-middle flex">
								{{ cartItem.cartProduct.product?.title }}
							</div>
							<div>
								<div>
									<b>Size:</b>
									{{ cartItem.cartProduct.size?.size }}
								</div>
								<div>
									<b>Color:</b>
									{{ cartItem.cartProduct.color?.color }}
								</div>
							</div>
						</div>
						<div class="flex-2 align-middle flex justify-center">
							<div class="flex flex-1" style="height: 32px">
								<div
									class="flex-1 border border-radius-left cursor-pointer align-middle flex justify-center"
									@click="
										async () => {
											await decrementProductFromCart(
												cartItem.cartProduct.id
											);
										}
									"
								>
									<b>-</b>
								</div>
								<div
									class="flex-2 border align-middle flex justify-center"
								>
									<b> {{ cartItem.quantity }}</b>
								</div>
								<div
									class="flex-1 border border-radius-right cursor-pointer align-middle flex justify-center"
									@click="
										async () => {
											await incrementProductInCart(
												cartItem.cartProduct?.product
													?.id,
												cartItem.cartProduct.color?.id,
												cartItem.cartProduct.size?.id
											);
										}
									"
								>
									<b>+</b>
								</div>
							</div>
						</div>
						<div class="flex-1 align-middle flex justify-center">
							<div
								style="
									width: fit-content;
									height: fit-content;
									background-color: red;
									border-radius: 4px;
									cursor: pointer;
									padding: 4px;
								"
								@click="
									async () => {
										await removeProductFromCart(
											cartItem.cartProduct
										);
									}
								"
							>
								<el-icon
									style="vertical-align: middle"
									:size="42"
									color="white"
								>
									<Delete />
								</el-icon>
							</div>
						</div>
					</div>
				</div>
			</el-main>
		</el-container>
	</div>
</template>

<script lang="ts">
import { ElNotification } from "element-plus";
import { addToCart, removeFromCart } from "../http/requests";
import { defineComponent, onMounted, ref } from "vue";
import store from "../store";
import { useRouter } from "vue-router";
import { CartDTO } from "../http/DTOs/cartDTO";
import { CartProductDTO } from "../http/DTOs/cartProductDTO";

export default defineComponent({
	name: "Cart",
	setup() {
		const cart = ref<CartDTO>(store.state.userCart);
		const cartProducts = ref<
			{ quantity: number; cartProduct: CartProductDTO }[]
		>([]);
		const router = useRouter();

		onMounted(async () => {
			if (!store.state.authenticated) {
				router.push({ path: "/login" });
			}
			prepareDataFromPresentation();
		});

		const prepareDataFromPresentation = () => {
			cartProducts.value = [];
			for (let index = 0; index < cart.value.products!.length; index++) {
				const element = cart.value.products![index];
				const itemIndex = findItemInCart(element);
				if (itemIndex >= 0) {
					cartProducts.value[itemIndex].quantity += 1;
				} else {
					cartProducts.value.push({
						cartProduct: element,
						quantity: 1,
					});
				}
			}
		};

		const findItemInCart = (cartProduct: CartProductDTO) => {
			const index = cartProducts.value.findIndex(
				(item: { quantity: number; cartProduct: CartProductDTO }) => {
					return (
						item.cartProduct.product?.id ===
							cartProduct.product?.id &&
						item.cartProduct.color?.id === cartProduct.color?.id &&
						item.cartProduct.size?.id === cartProduct.size?.id
					);
				}
			);

			return index;
		};

		const findAllSimilarCartProducts = (cartProduct: CartProductDTO) => {
			const similarCartProductIds: number[] = [];
			console.log(cartProduct);
			for (let index = 0; index < cart.value.products!.length; index++) {
				const element = cart.value.products![index];
				console.log(element);
				if (
					element.product?.id === cartProduct.product?.id &&
					element.color?.id === cartProduct.color?.id &&
					element.size?.id === cartProduct.size?.id
				) {
					similarCartProductIds.push(element.id!);
				}
			}

			return similarCartProductIds;
		};

		const removeProductFromCart = async (
			cartProduct: CartProductDTO
		): Promise<void> => {
			const cartProductsIds = findAllSimilarCartProducts(cartProduct);
			console.log(cartProductsIds);
			for (let index = 0; index < cartProductsIds.length; index++) {
				const cartProductId = cartProductsIds[index];
				try {
					cart.value = await removeFromCart({
						cart_product_id: cartProductId,
					});
				} catch (error) {
					ElNotification({
						title: "Error",
						message: "Oops, something went wrong",
						type: "error",
					});
				}
			}
			prepareDataFromPresentation();
		};

		const decrementProductFromCart = async (
			cartProductId?: number
		): Promise<void> => {
			try {
				cart.value = await removeFromCart({
					cart_product_id: cartProductId,
				});
				prepareDataFromPresentation();
			} catch (error) {
				ElNotification({
					title: "Error",
					message: "Oops, something went wrong",
					type: "error",
				});
			}
		};

		const incrementProductInCart = async (
			productId?: number,
			colorId?: number,
			sizeId?: number
		) => {
			try {
				cart.value = await addToCart({
					product_id: productId,
					color_id: colorId,
					size_id: sizeId,
				});
				prepareDataFromPresentation();
			} catch (error) {
				ElNotification({
					title: "Error",
					message: "Oops, something went wrong",
					type: "error",
				});
			}
		};

		const showProductPage = (productId?: number) => {
			router.push({
				path: `/product/${productId}`,
			});
		};

		return {
			cart,
			cartProducts,
			removeProductFromCart,
			incrementProductInCart,
			decrementProductFromCart,
			showProductPage,
		};
	},
});
</script>
<style scoped>
.container {
	width: 80%;
	margin: 0 auto;
	margin-top: 16px;
	border: 2px solid black;
	border-radius: 16px;
	padding: 16px;
	box-shadow: 8px 8px;
	height: 800px;
}

.table-cell {
	display: table-cell;
}

.align-middle {
	align-items: center;
}

.justify-center {
	justify-content: center;
}

.align-center {
	text-align: center;
}

.items-container {
	border: 2px solid black;
	border-radius: 16px;
	padding: 16px;
	overflow: scroll;
	max-height: 650px;
}

.item-container {
	border: 2px solid black;
	border-radius: 16px;
	margin-bottom: 2px;
	padding: 8px;
	height: 100px;
}

.border {
	border: 1px solid black;
}

.border-radius-left {
	border-top-left-radius: 8px;
	border-bottom-left-radius: 8px;
}

.border-radius-right {
	border-top-right-radius: 8px;
	border-bottom-right-radius: 8px;
}

.cursor-pointer {
	cursor: pointer;
}

.align-left {
	text-align: left;
}

.flex {
	display: flex;
}

.flex-1 {
	flex: 1;
}

.flex-2 {
	flex: 2;
}

.margin-b-4 {
	margin-bottom: 16px;
}

.margin-b-6 {
	margin-bottom: 24px;
}
</style>
