<template>
	<div class="home">
		<el-row v-for="(productRow, index) in products" :key="index">
			<el-col
				v-for="product in productRow"
				:key="product.id"
				:xl="8"
				:lg="8"
				:md="12"
				:sm="12"
				:xs="24"
			>
				<div class="product-container">
					<Product :product="product" />
				</div>
			</el-col>
		</el-row>
	</div>
	<div class="pagination">
		<el-pagination
			:page-size="productsData.per_page"
			layout="prev, pager, next"
			:total="productsData.total"
			:page-count="productsData.last_page"
			:current-page="productsData.current_page"
			@prev-click="
				async () => await loadAllProducts(productsData.prev_page_url)
			"
			@next-click="
				async () => await loadAllProducts(productsData.next_page_url)
			"
			@update:current-page="getProductsDataByPage"
		/>
	</div>
</template>

<script lang="ts">
import { getAllProducts } from "../http/requests";
import { ElNotification } from "element-plus";
import { Link, ProductPaginationDTO } from "../http/DTOs/productPaginationDTO";
import Product from "@/components/Product.vue";
import { ProductDTO } from "../http/DTOs/productDTO";
import { defineComponent, onMounted, ref } from "vue";
import { useRouter } from "vue-router";

export default defineComponent({
	name: "Home",
	components: {
		Product,
	},
	setup() {
		const productsData = ref<ProductPaginationDTO>({
			data: [],
		});
		const products = ref<ProductDTO[][]>([]);
		const router = useRouter();

		onMounted(async () => {
			await loadAllProducts();

			window.onresize = () => {
				prepareProductDataForPresentation();
			};
		});

		const getProductsDataByPage = async (page: number): Promise<void> => {
			console.log(productsData.value.links?.length);
			productsData.value.links?.every(async (link: Link) => {
				if (Number(link.label) === page) {
					await getAllProducts(link.url);
					return true;
				}

				return false;
			});
		};

		const loadAllProducts = async (pageUrl?: string): Promise<void> => {
			try {
				productsData.value = await getAllProducts(pageUrl);
				prepareProductDataForPresentation();
			} catch (error) {
				ElNotification({
					title: "Error",
					message: "Oops, something went wrong",
					type: "error",
				});
			}
		};

		const prepareProductDataForPresentation = (): void => {
			products.value = [];
			let productsRow: ProductDTO[] = [];
			for (
				let index = 0;
				index < productsData.value.data!.length;
				index++
			) {
				const element = productsData.value.data![index];
				productsRow.push(element);
				if (productsRow.length === getRowSize()) {
					products.value.push(productsRow);
					productsRow = [];
				}
			}
		};

		const getRowSize = (): number => {
			if (!innerWidth) {
				return 3;
			}
			if (innerWidth > 1200) {
				return 3;
			} else if (innerWidth > 768) {
				return 2;
			} else {
				return 1;
			}
		};

		return {
			productsData,
			products,
			getRowSize,
			prepareProductDataForPresentation,
			loadAllProducts,
			getProductsDataByPage,
		};
	},
});
</script>
<style scoped>
.home {
	width: 90%;
	margin: 0 auto;
	max-height: 800px;
	overflow: scroll;
}

.product-container {
	padding: 16px;
}

.pagination {
	width: fit-content;
	margin: 0 auto;
}
</style>
