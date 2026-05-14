import {httpClient} from "./axios.instance.ts";
import {useAuthStore} from "../../features/auth/stores/auth.store.ts";


httpClient.interceptors.request.use((config) => {
        const token = useAuthStore.getState().token;

        if (token) {
            config.headers.Authorization = `Bearer ${token}`
        }

        return config;
    },
    (error) => Promise.reject(error)
);

httpClient.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401 && window.location.pathname !== '/login') {
            useAuthStore.getState().clearAuth();
            window.location.href = '/login';
        }

        return Promise.reject(error);
    }
);
