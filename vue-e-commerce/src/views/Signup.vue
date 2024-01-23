<template>
	<div class="common-layout container">
		<el-header>
			<h1>Sign up</h1>
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
					<el-form-item label="Username">
						<el-input
							v-model="form.username"
							size="large"
							placeholder="Username"
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
						@click="signUp"
						type="primary"
						:loading="isLoading"
					>
						Sign up
					</el-button>
				</el-form>
			</div>
		</el-container>
	</div>
</template>

<script lang="ts">
import { ElNotification } from "element-plus";
import { signup } from "../http/requests";
import { SignupData } from "../http/DTOs/signupData";
import { defineComponent, reactive, ref } from "vue";
import { useRouter } from "vue-router";

export default defineComponent({
	name: "Signup",
	setup() {
		const form = reactive({
			email: "",
			username: "",
			password: "",
		});
		const usernameErrorMessage = ref("");
		const emailErrorMessage = ref("");
		const passwordErrorMessage = ref("");
		const isLoading = ref(false);
		const router = useRouter();

		const signUp = async (): Promise<void> => {
			isLoading.value = true;
			const signUpData = {
				username: form.username,
				email: form.email,
				password: form.password,
			} as SignupData;

			try {
				await signup(signUpData);
				ElNotification({
					title: "Account created",
					message: "You signed up successfully",
					type: "success",
				});
				router.push({
					name: "Login",
				});
			} catch (error: any) {
				handleErrors(error.response.data.errors);
			} finally {
				isLoading.value = false;
			}
		};

		const handleErrors = (data: any): void => {
			clearErrors();
			Object.keys(data).forEach((key) => {
				switch (key) {
					case "username":
						data["username"].forEach((errorMessage: string) => {
							usernameErrorMessage.value += errorMessage + "\n";
						});
						break;
					case "email":
						data["email"].forEach((errorMessage: string) => {
							emailErrorMessage.value += errorMessage + "\n";
						});
						break;

					case "password":
						data["password"].forEach((errorMessage: string) => {
							passwordErrorMessage.value += errorMessage + "\n";
						});
						break;
				}
			});

			errorSignup();
		};

		const clearErrors = (): void => {
			usernameErrorMessage.value = "";
			emailErrorMessage.value = "";
			passwordErrorMessage.value = "";
		};

		const errorSignup = (): void => {
			if (usernameErrorMessage.value) {
				ElNotification({
					title: "Username",
					message: usernameErrorMessage.value,
					type: "error",
				});
			}
			if (emailErrorMessage.value) {
				ElNotification({
					title: "Email",
					message: emailErrorMessage.value,
					type: "error",
				});
			}
			if (passwordErrorMessage.value) {
				ElNotification({
					title: "Password",
					message: passwordErrorMessage.value,
					type: "error",
				});
			}
		};

		return {
			form,
			usernameErrorMessage,
			emailErrorMessage,
			passwordErrorMessage,
			isLoading,
			errorSignup,
			clearErrors,
			handleErrors,
			signUp,
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
