import { createStore } from "vuex";
import VuexPersistence from "vuex-persist";
import { CartDTO } from "../http/DTOs/cartDTO";

const vuexLocal = new VuexPersistence({
	storage: window.localStorage,
});

export default createStore<{ authenticated: boolean; userCart: CartDTO }>({
	state: {
		authenticated: false,
		userCart: { id: -1, products: [] },
	},
	mutations: {
		setAuthenticatedTrue: (state) => {
			console.log("auth true");
			state.authenticated = true;
		},
		setAuthenticatedFalse: (state) => {
			state.authenticated = false;
		},
		setUserCart: (state, payload: { cart: CartDTO }) => {
			console.log(payload.cart);
			state.userCart = payload.cart;
		},
	},
	actions: {},
	modules: {},
	plugins: [vuexLocal.plugin],
});
