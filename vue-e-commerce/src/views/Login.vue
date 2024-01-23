<template>
	<div class="common-layout container">
		<el-header>
			<h1>Login</h1>
		</el-header>
		<el-container>
			<div class="form">
				<el-form
					:model="form"
					label-position="right"
					label-width="auto"
				>
					<el-form-item label="Email">
						<el-input
							v-model="form.email"
							size="large"
							placeholder="Email"
						/>
					</el-form-item>
					<el-form-item label="Password">
						<el-input
							v-model="form.password"
							type="password"
							placeholder="Password"
							show-password
							size="large"
						/>
					</el-form-item>
					<el-button
						@click="attemptLogin"
						type="primary"
						:loading="isLoading"
					>
						Login
					</el-button>
				</el-form>
			</div>
		</el-container>
	</div>
</template>

<script lang="ts">
import { ElNotification } from "element-plus";
import { Credentials } from "../http/DTOs/credentials";
import { getUserCart, login } from "../http/requests";
import { defineComponent, reactive, ref } from "vue";
import { useRouter } from "vue-router";

export default defineComponent({
	name: "Login",
	setup() {
		const form = reactive({
			email: "",
			password: "",
		});
		const isLoading = ref(false);
		const router = useRouter();

		const attemptLogin = async (): Promise<void> => {
			isLoading.value = true;
			const credentials = {
				email: form.email,
				password: form.password,
			} as Credentials;

			try {
				await login(credentials);
				await getUserCart();
				router.push({ path: "/" });
			} catch (error) {
				errorLogin();
			} finally {
				isLoading.value = false;
			}
		};

		const errorLogin = () => {
			ElNotification({
				title: "Error",
				message: "Incorrect username or password",
				type: "error",
			});
		};

		return {
			form,
			isLoading,
			errorLogin,
			attemptLogin,
		};
	},
});
</script>
<style scoped>
.container {
	align-content: center;
	margin-top: 32px;
}

.form {
	width: 30%;
	margin-left: auto;
	margin-right: auto;
	margin-top: 5em;
	border: 2px solid black;
	border-radius: 16px;
	padding: 24px;
	align-content: center;
	box-shadow: 8px 8px;
}
</style>
