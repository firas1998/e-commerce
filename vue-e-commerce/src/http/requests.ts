/* eslint-disable @typescript-eslint/no-explicit-any */
/* eslint-disable @typescript-eslint/explicit-module-boundary-types */
import store from "@/store";
import axios, { AxiosError, AxiosResponse, Method } from "axios";
import { Credentials } from "./DTOs/credentials";
import { SignupData } from "./DTOs/signupData";
import { User } from "./DTOs/userDTO";
import { Constants } from "../Constants";
import { CartDTO } from "./DTOs/cartDTO";
import { AddProductDTO } from "./DTOs/addProduct";
import { removeProductDTO } from "./DTOs/removeProduct";
import { ProductDTO } from "./DTOs/productDTO";
import { ProductPaginationDTO } from "./DTOs/productPaginationDTO";
import { ElNotification } from "element-plus";

export async function login(credentials: Credentials) {
	const response = await request({
		method: "POST",
		endpoint: Constants.LOGIN_ENDPOINT,
		auth: false,
		data: credentials,
	});
	localStorage.setItem(Constants.JWT_KEY, response.data.access_token);
	store.commit("setAuthenticatedTrue");
	return response.data;
}

export async function signup(signupData: SignupData) {
	const response = await request({
		method: "POST",
		endpoint: Constants.SIGNUP_ENDPOINT,
		auth: false,
		data: signupData,
	});
	console.log(response.data);
	return response.data;
}

export async function logout() {
	const response = await request({
		method: "GET",
		endpoint: Constants.LOGOUT_ENDPOINT,
		auth: true,
	});
	localStorage.removeItem(Constants.JWT_KEY);
	store.commit("setAuthenticatedFalse");
	return response.data;
}

export async function refresh() {
	const response = await request({
		method: "GET",
		endpoint: Constants.REFRESH_ENDPOINT,
		auth: true,
	});
	localStorage.setItem(Constants.JWT_KEY, response.data.access_token);
	return response.data;
}

export async function me(): Promise<User> {
	const response = await request({
		method: "GET",
		endpoint: Constants.ME_ENDPOINT,
		auth: true,
	});

	return response.data;
}

export async function getUserCart(): Promise<CartDTO> {
	const response = await request({
		method: "GET",
		endpoint: Constants.USER_CART,
		auth: true,
	});

	store.commit("setUserCart", { cart: response.data });
	return response.data;
}

export async function addToCart(dto: AddProductDTO): Promise<CartDTO> {
	const response = await request({
		method: "PUT",
		endpoint: Constants.ADD_TO_CART,
		auth: true,
		data: dto,
	});

	store.commit("setUserCart", { cart: response.data });
	return response.data;
}

export async function removeFromCart(dto: removeProductDTO): Promise<CartDTO> {
	const response = await request({
		method: "PUT",
		endpoint: Constants.REMOVE_FROM_CART,
		auth: true,
		data: dto,
	});

	store.commit("setUserCart", { cart: response.data });
	return response.data;
}

export async function getAllProducts(
	pageUrl?: string
): Promise<ProductPaginationDTO> {
	const response = await request({
		method: "GET",
		link: pageUrl,
		endpoint: Constants.ALL_PRODUCTS,
		auth: false,
	});
	return response.data;
}

export async function getProductById(id: number): Promise<ProductDTO> {
	const response = await request({
		method: "GET",
		endpoint: Constants.PRODUCT_BY_ID(id),
		auth: false,
	});

	return response.data;
}

async function request(requestData: {
	method: Method;
	auth: boolean;
	endpoint?: string;
	link?: string;
	data?: any;
}): Promise<AxiosResponse<any>> {
	if (!requestData.endpoint && !requestData.link) {
		throw Error("Either endpoint or link should be given");
	}
	const url = `${process.env.VUE_APP_API_URL}/${requestData.endpoint}`;
	const headers = {
		Accept: "application/json",
		Authorization: requestData.auth
			? `Bearer ${localStorage.getItem(Constants.JWT_KEY)}`
			: undefined,
	};
	let resp: AxiosResponse<any>;
	try {
		resp = await axios.request({
			method: requestData.method,
			url: requestData.link ?? url,
			headers: headers,
			data: requestData.data,
		});
	} catch (error: any) {
		console.log(error);
		if (error.response.status === 401) {
			if (store.state.authenticated) {
				ElNotification({
					title: "Session expired",
					message:
						"Your session has expired, please login again to continue shopping",
					type: "error",
				});
				store.commit("setAuthenticatedFalse");
			}
		}
		throw error;
	}

	return resp;
}
