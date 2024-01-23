<template>
	<div class="common-layout container">
		<el-container>
			<el-aside width="400px">
				<div class="">
					<img
						:src="product.image_url"
						class="image"
						style="max-width: 100%"
					/>
				</div>
			</el-aside>
			<el-container>
				<el-header>
					<div class="align-left">
						<h2>
							{{ product.title }}
						</h2>
					</div>
				</el-header>
				<el-main>
					<div class="flex">
						<div class="align-left flex-1">
							<h4>
								{{ product.description }}
							</h4>
							<div class="margin-b-4">
								<el-select
									v-model="selectedSizeId"
									class="m-2"
									placeholder="Size"
									size="large"
									style="width: 240px"
								>
									<el-option
										v-for="size in product.sizes"
										:key="size.id"
										:label="size.size"
										:value="size.id"
									/>
								</el-select>
							</div>
							<div class="margin-b-6">
								<el-select
									v-model="selectedColorId"
									class="m-2"
									placeholder="Color"
									size="large"
									style="width: 240px"
								>
									<el-option
										v-for="color in product.colors"
										:key="color.id"
										:label="color.color"
										:value="color.id"
									/>
								</el-select>
							</div>
							<div>
								<el-button
									@click="addProductToCart"
									type="primary"
									:loading="isLoading"
								>
									Add to cart
								</el-button>
							</div>
						</div>
						<div class="flex-1"></div>
					</div>
				</el-main>
			</el-container>
		</el-container>
	</div>
</template>

<script lang="ts">
import { ElNotification } from "element-plus";
import { addToCart, getProductById } from "../http/requests";
import { defineComponent, onMounted, reactive, ref } from "vue";
import { ProductDTO } from "../http/DTOs/productDTO";
import store from "../store";
import { useRouter } from "vue-router";

export default defineComponent({
	name: "ProductDetails",
	props: {
		productId: {
			type: Number,
			required: true,
		},
	},
	setup(props) {
		const product = ref<ProductDTO>({});
		const selectedSizeId = ref<number>();
		const selectedColorId = ref<number>();
		const isLoading = ref<boolean>(false);
		const router = useRouter();

		onMounted(async () => {
			await getProduct(props.productId);
		});

		const getProduct = async (productId?: number): Promise<void> => {
			try {
				product.value = await getProductById(productId!);
				console.log(product.value);
			} catch (error) {
				ElNotification({
					title: "Error",
					message: "Oops, something went wrong",
					type: "error",
				});
			}
		};

		const addProductToCart = async () => {
			if (!store.state.authenticated) {
				router.push({ path: "/login" });
				return;
			}
			try {
				await addToCart({
					product_id: props.productId,
					color_id: selectedColorId.value,
					size_id: selectedSizeId.value,
				});
				selectedSizeId.value = undefined;
				selectedColorId.value = undefined;
				ElNotification({
					title: "Added to cart",
					message: "Product was added to your cart",
					type: "success",
				});
			} catch (error) {
				ElNotification({
					title: "Error",
					message: "Oops, something went wrong",
					type: "error",
				});
			}
		};

		return {
			product,
			selectedColorId,
			selectedSizeId,
			isLoading,
			addProductToCart,
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
}

.border {
	border: 1px solid black;
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
.margin-b-4 {
	margin-bottom: 16px;
}
.margin-b-6 {
	margin-bottom: 24px;
}
</style>
