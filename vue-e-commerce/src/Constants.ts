export const Constants = {
	JWT_KEY: "JWT",
	LOGIN_ENDPOINT: "api/user/login",
	SIGNUP_ENDPOINT: "api/user/create",
	ME_ENDPOINT: "api/user/me",
	LOGOUT_ENDPOINT: "api/user/logout",
	REFRESH_ENDPOINT: "api/user/refresh",
	USER_CART: "api/cart",
	ADD_TO_CART: "api/cart/add",
	REMOVE_FROM_CART: "api/cart/remove",
	ALL_PRODUCTS: "api/products",
	PRODUCT_BY_ID: (id: number) => `api/product/${id}`,
};
