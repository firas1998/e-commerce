<template>
	<el-card
		:body-style="{ padding: '14px', cursor: 'pointer' }"
		shadow="hover"
		@click="() => showProductPage(product)"
	>
		<img :src="product?.image_url" class="image" style="max-width: 100%" />
		<div style="padding: 14px">
			<div class="bottom">
				<el-row :gutter="10" justify="space-between" align="middle">
					<el-col :span="18">
						<div class="align-left">
							<el-text class="mx-1">
								{{ product?.title }}
							</el-text>
						</div>
					</el-col>
					<el-col :span="6">
						<div class="align-right">
							<el-text class="mx-1" size="large" tag="b">
								{{ product?.price }}€
							</el-text>
						</div>
					</el-col>
				</el-row>
			</div>
		</div>
	</el-card>
</template>

<script lang="ts">
import { ProductDTO } from "../http/DTOs/productDTO";
import { defineComponent } from "vue";
import { useRouter } from "vue-router";

export default defineComponent({
	name: "Product",
	props: {
		product: {
			type: Object as () => ProductDTO,
			required: true,
		},
	},
	setup(props) {
		const router = useRouter();
		const showProductPage = (product: ProductDTO) => {
			router.push({
				path: `/product/${product.id}`,
			});
		};

		return {
			showProductPage,
		};
	},
});
</script>

<style scoped>
.align-left {
	text-align: left;
}
.align-right {
	text-align: right;
}
</style>
