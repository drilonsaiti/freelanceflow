import type {User} from "../../features/auth/types/auth.types.ts";
import type {LoginFormData, RegisterFormData} from "../../features/auth/schemas/auth.schema.ts";
import {httpClient} from "../http/axios.instance.ts";
import type {ApiResponse} from "../../shared/types/api.types.ts";

interface AuthResponse {
    token: string;
    data: User;
}

export const authApi = {
    login: (credentials: LoginFormData) => httpClient.post<ApiResponse<AuthResponse>>('auth/login',credentials),

    register: (credentials: RegisterFormData) => httpClient.post<ApiResponse<AuthResponse>>('auth/register',credentials),

    logout: () => httpClient.post('auth/logout'),
}
