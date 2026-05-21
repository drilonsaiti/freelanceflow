import type {User} from "../../features/auth/types/auth.types.ts";
import type {LoginFormData, RegisterFormData} from "../../features/auth/schemas/auth.schema.ts";
import {httpClient} from "../http/axios.instance.ts";

interface AuthResponse {
    token: string;
    data: User;
    message: string;
}

export const authApi = {
    login: (credentials: LoginFormData) => httpClient.post<AuthResponse>('auth/login',credentials),

    register: (credentials: RegisterFormData) => httpClient.post<AuthResponse>('auth/register',credentials),

    logout: () => httpClient.post('auth/logout'),
}
