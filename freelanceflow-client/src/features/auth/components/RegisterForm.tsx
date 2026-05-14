import {useForm} from "react-hook-form";
import {type RegisterFormData, registerSchema} from "../schemas/auth.schema.ts";
import {zodResolver} from "@hookform/resolvers/zod";
import {useRegister} from "../hooks/useRegister.ts";

function LoginForm() {
    const {register, handleSubmit, formState: {errors}} = useForm<RegisterFormData>({
        resolver: zodResolver(registerSchema)
    });

    const registerMutation = useRegister();

    const onSubmit = (data: RegisterFormData) => {
        registerMutation.mutate(data);
    }

    return (

        <form onSubmit={handleSubmit(onSubmit)} className="flex flex-col  mt-8 space-y-6">
            <div className="flex flex-col space-y-4">
                <div className="flex flex-col space-y-1">
                    <label htmlFor="name" className="text-sm font-medium text-slate-700">
                        Name
                    </label>
                    <input id="name" type="text" {...register('name')}
                           className="px-3 py-2.5 text-sm text-slate-900 rounded-md bg-white w-full outline-1 -outline-offset-1 outline-slate-300 focus:outline-offset-2 focus:outline-blue-600"
                           placeholder="Name"/>
                    {errors.name && (
                        <p className="text-xs text-red-500">{errors.name.message}</p>
                    )}
                </div>
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
                    <input type="password" {...register('password')}
                           className="px-3 py-2.5 text-sm text-slate-900 rounded-md bg-white w-full outline-1 -outline-offset-1 outline-slate-300 focus:outline-offset-2 focus:outline-blue-600"
                           placeholder="Password"/>
                    {errors.password && (
                        <p className="text-xs text-red-500">{errors.password.message}</p>
                    )}
                </div>
                <div className="flex flex-col space-y-1">
                    <label htmlFor="password_confirmation" className="text-sm font-medium text-slate-700">
                        Password confirmation
                    </label>
                <input id="password_confirmation" type="password" {...register('password_confirmation')}
                       className="px-3 py-2.5 text-sm text-slate-900 rounded-md bg-white w-full outline-1 -outline-offset-1 outline-slate-300 focus:outline-offset-2 focus:outline-blue-600"
                       placeholder="Password confirmation"/>
                    {errors.password_confirmation && (
                        <p className="text-xs text-red-500">{errors.password_confirmation.message}</p>
                    )}
                </div>

                <div className="flex flex-col space-y-1">
                    <label
                        htmlFor="role"
                        className="text-sm font-medium text-slate-700"
                    >
                        Role
                    </label>

                    <select
                        id="role"
                        {...register('role')}
                        className="rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="freelancer">
                            Freelancer
                        </option>

                        <option value="client">
                            Client
                        </option>
                    </select>

                    {errors.role && (
                        <p className="text-xs text-red-500">
                            {errors.role.message}
                        </p>
                    )}
                </div>
            </div>

            <button type="submit"
                    className="text-white bg-black p-2 rounded self-center cursor-pointer selft-center">Register
            </button>
        </form>

    );
}

export default LoginForm;
