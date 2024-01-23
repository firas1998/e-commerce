<template>
	<el-menu
		class=""
		mode="horizontal"
		:ellipsis="false"
		@select="handleSelect"
	>
		<el-menu-item index="0">
			<h2>Store</h2>
		</el-menu-item>
		<div class="flex-grow" />
		<el-menu-item v-if="!loggedIn" index="1">
			<b>Login</b>
		</el-menu-item>
		<el-menu-item v-if="!loggedIn" index="2">
			<b>Sign up</b>
		</el-menu-item>
		<el-menu-item v-if="loggedIn" index="3">
			<el-button type="primary">
				<el-icon style="vertical-align: middle">
					<ShoppingCart />
				</el-icon>
			</el-button>
		</el-menu-item>
		<el-menu-item v-if="loggedIn" index="4">
			<b>Logout</b>
		</el-menu-item>
	</el-menu>
</template>

<script lang="ts">
import { User } from "../http/DTOs/userDTO";
import { logout, me } from "../http/requests";
import store from "../store";
import { defineComponent, ref } from "vue";
import { useRouter } from "vue-router";

export default defineComponent({
	name: "NavBar",
	computed: {
		loggedIn: () => {
			return store.state.authenticated;
		},
		cartItemsCount: () => {
			return store.state.userCart.products?.length;
		},
	},
	setup() {
		const username = ref("");
		const authenticated = ref(false);
		const activeIndex = ref("1");
		const router = useRouter();

		const handleSelect = async (key: string, keyPath: string[]) => {
			switch (key) {
				case "0":
					router.push({ path: "/" });
					break;
				case "1":
					router.push({ path: "/login" });
					break;
				case "2":
					router.push({ path: "/signup" });
					break;
				case "3":
					router.push({ path: "/cart" });
					break;
				case "4":
					await handleLogout();
					break;

				default:
					break;
			}
		};

		const isAuthenticated = async (): Promise<void> => {
			let user: User;
			if (store.state.authenticated) {
				try {
					user = await me();
					username.value = user.username ? user.username : "";
					authenticated.value = true;
				} catch (error: any) {
					store.commit("setAuthenticatedFalse");
					authenticated.value = false;
					console.log(error.response.data);
				}
			}
		};

		const handleLogout = async (): Promise<void> => {
			try {
				await logout();
				router.push({ path: "/login" });
			} catch (error: any) {
				console.log(error.response.data);
			}
		};

		return {
			username,
			authenticated,
			activeIndex,
			handleSelect,
			isAuthenticated,
			handleLogout,
		};
	},
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
	margin: 40px 0 0;
}

.flex-grow {
	flex-grow: 1;
}

.button-container {
	display: flex;
	gap: 8px;
}
</style>
