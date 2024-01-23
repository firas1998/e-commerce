import { createRouter, createWebHashHistory, RouteRecordRaw } from "vue-router";
import Home from "../views/Home.vue";
import Login from "../views/Login.vue";
import Signup from "../views/Signup.vue";
import ProductDetails from "../views/ProductDetails.vue";
import Cart from "../views/Cart.vue";

const routes: Array<RouteRecordRaw> = [
	{
		path: "/",
		name: "store",
		component: Home,
	},
	{
		path: "/product/:productId",
		name: "product",
		component: ProductDetails,
		props: true,
	},
	{
		path: "/cart",
		name: "cart",
		component: Cart,
	},
	{
		path: "/login",
		name: "Login",
		component: Login,
	},
	{
		path: "/signup",
		name: "Signup",
		component: Signup,
	},
];

const router = createRouter({
	history: createWebHashHistory(),
	routes,
});

export default router;
