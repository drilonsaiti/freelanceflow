import {useForm} from "react-hook-form";
import {type LoginFormData, loginSchema} from "../schemas/auth.schema.ts";
import {zodResolver} from "@hookform/resolvers/zod";
import {useLogin} from "../hooks/useLogin.ts";
import {getApiErrorMessage} from "../../../shared/utils/errors.utils.ts";

function LoginForm() {
    const {register, handleSubmit, formState: {errors}} = useForm<LoginFormData>({
        resolver: zodResolver(loginSchema)
    });

    const loginMutation = useLogin();

    const onSubmit = (data: LoginFormData) => {
        loginMutation.mutate(data);
    }


    return (

        <form onSubmit={handleSubmit(onSubmit)} className="flex flex-col  mt-8 space-y-6">
            <div className="flex flex-col space-y-4">
                <div className="flex flex-col space-y-1">
                    <label htmlFor="email" className="text-sm font-medium text-slate-700">
                        Email
                    </label>
                    <input id="email" type="email" {...register('email')}
                           className="px-3 py-2.5 text-sm text-slate-900 rounded-md bg-white w-full outline-1 -outline-offset-1 outline-slate-300 focus:outline-offset-2 focus:outline-blue-600"
                           placeholder="Email"/>
                    {errors.email && (
                        <p className="text-xs text-red-500">{errors.email.message}</p>
                    )}

                </div>
                <div className="flex flex-col space-y-1">
                    <label htmlFor="password" className="text-sm font-medium text-slate-700">
                        Password
                    </label>
                    <input id="password" type="password" {...register('password')}
                           className="px-3 py-2.5 text-sm text-slate-900 rounded-md bg-white w-full outline-1 -outline-offset-1 outline-slate-300 focus:outline-offset-2 focus:outline-blue-600"
                           placeholder="Password"/>
                    {errors.password && (
                        <p className="text-xs text-red-500">{errors.password.message}</p>
                    )}
                </div>

            </div>

            {loginMutation.isError && (
                <p className="text-sm text-red-600">
                    {getApiErrorMessage(loginMutation.error)}
                </p>
            )}

            <button type="submit"
                    disabled={loginMutation.isPending}
                    className="w-full rounded-xl bg-black px-4 py-3 text-sm font-medium text-white transition hover:opacity-90">
                {loginMutation.isPending ? 'Signing in...' : 'Sign in'}
            </button>

        </form>

    );
}

export default LoginForm;
