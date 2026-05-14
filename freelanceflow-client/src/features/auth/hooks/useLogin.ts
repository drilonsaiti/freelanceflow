import {useAuthStore} from "../stores/auth.store.ts";
import {useMutation} from "@tanstack/react-query";
import {authApi} from "../../../infrastructure/api/auth.api.ts";

export const useLogin = () => {
    const { setAuth } = useAuthStore();

    return useMutation({
        mutationFn: authApi.login,
        onSuccess: ({data}) => {
            setAuth(data.data.data,data.data.token);
        }
    })
};



