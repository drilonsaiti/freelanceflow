import {type CreateProjectFormData, createProjectSchema} from "../schemas/project.schema.ts";
import {useForm} from "react-hook-form";
import {useCreateProject} from "../hooks/useCreateProject.ts";
import {zodResolver} from "@hookform/resolvers/zod";
import {useNavigate} from "react-router-dom";
import {getApiErrorMessage} from "../../../shared/utils/errors.utils.ts";

function CreateProjectForm() {
    const { register, handleSubmit, formState: { errors } } = useForm<CreateProjectFormData>({
        resolver: zodResolver(createProjectSchema),
    });
    const createProjectMutation = useCreateProject();
    const navigate = useNavigate();

    const onSubmit = (data: CreateProjectFormData) => {
        const payload = {
            ...data,
            requiredSkills: typeof data.requiredSkills === 'string'
                ? (data.requiredSkills as string).split(',').map(s => s.trim())
                : data.requiredSkills ?? [],
        };
        createProjectMutation.mutate(payload,{
            onSuccess: () => navigate('/projects')
        });
    }


    return (

        <form onSubmit={handleSubmit(onSubmit)} className="flex flex-col  mt-8 space-y-6">
            <div className="flex flex-col space-y-1">
                <label htmlFor="title" className="text-sm font-medium text-slate-700">
                    Title
                </label>
                <input id="title" type="text" className="px-3 py-2.5 text-sm text-slate-900 rounded-md bg-white w-full outline-1 -outline-offset-1 outline-slate-300 focus:outline-offset-2 focus:outline-blue-600"
                       {...register('title')}
                />
                {errors.title && (
                    <p className="text-xs text-red-500">{errors.title.message}</p>
                )}
            </div>

            <div className="flex flex-col space-y-1">
                <label htmlFor="description" className="text-sm font-medium text-slate-700">
                    Description
                </label>
                <input id="description" type="text" className="px-3 py-2.5 text-sm text-slate-900 rounded-md bg-white w-full outline-1 -outline-offset-1 outline-slate-300 focus:outline-offset-2 focus:outline-blue-600"
                       {...register('description')}
                />
                {errors.description && (
                    <p className="text-xs text-red-500">{errors.description.message}</p>
                )}
            </div>

            <div className="flex flex-col space-y-1">
                <label htmlFor="budgetMin" className="text-sm font-medium text-slate-700">
                    Budget min
                </label>
                <input id="budgetMin" type="number" min="0" className="px-3 py-2.5 text-sm text-slate-900 rounded-md bg-white w-full outline-1 -outline-offset-1 outline-slate-300 focus:outline-offset-2 focus:outline-blue-600"
                       {...register('budgetMin')}
                />
                {errors.budgetMin && (
                    <p className="text-xs text-red-500">{errors.budgetMin.message}</p>
                )}
            </div>

            <div className="flex flex-col space-y-1">
                <label htmlFor="budgetMax" className="text-sm font-medium text-slate-700">
                    Budget min
                </label>
                <input id="budgetMax" type="number" min="0" className="px-3 py-2.5 text-sm text-slate-900 rounded-md bg-white w-full outline-1 -outline-offset-1 outline-slate-300 focus:outline-offset-2 focus:outline-blue-600"
                       {...register('budgetMax')}
                />
                {errors.budgetMax && (
                    <p className="text-xs text-red-500">{errors.budgetMax.message}</p>
                )}
            </div>

            <div className="flex flex-col space-y-1">
                <label htmlFor="category" className="text-sm font-medium text-slate-700">
                    Category
                </label>
                <input id="category" type="text" min="0" className="px-3 py-2.5 text-sm text-slate-900 rounded-md bg-white w-full outline-1 -outline-offset-1 outline-slate-300 focus:outline-offset-2 focus:outline-blue-600"
                       {...register('category')}
                />
                {errors.category && (
                    <p className="text-xs text-red-500">{errors.category.message}</p>
                )}
            </div>

            <div className="flex flex-col space-y-1">
                <label
                    htmlFor="status"
                    className="text-sm font-medium text-slate-700"
                >
                    Status
                </label>

                <select
                    id="status"
                    {...register('status')}
                    className="rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100"
                >
                    <option value="draft">
                        Draft
                    </option>

                    <option value="open">
                        Open
                    </option>
                </select>

                {errors.status && (
                    <p className="text-xs text-red-500">
                        {errors.status.message}
                    </p>
                )}
            </div>

            <div className="flex flex-col space-y-1">
                <label
                    htmlFor="visibility"
                    className="text-sm font-medium text-slate-700"
                >
                    Visibility
                </label>

                <select
                    id="visibility"
                    {...register('visibility')}
                    className="rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100"
                >
                    <option value="public">
                        Public
                    </option>

                    <option value="private">
                        Private
                    </option>

                    <option value="invite_only">
                        Invite only
                    </option>
                </select>

                {errors.visibility && (
                    <p className="text-xs text-red-500">
                        {errors.visibility.message}
                    </p>
                )}
            </div>

            <div className="flex flex-col space-y-1">
                <label htmlFor="requiredSkills" className="text-sm font-medium text-slate-700">
                    Required skills
                </label>
                <input id="requiredSkills" type="text" min="0" className="px-3 py-2.5 text-sm text-slate-900 rounded-md bg-white w-full outline-1 -outline-offset-1 outline-slate-300 focus:outline-offset-2 focus:outline-blue-600"
                       {...register('requiredSkills')}
                />
                {errors.requiredSkills && (
                    <p className="text-xs text-red-500">{errors.requiredSkills.message}</p>
                )}
            </div>

            <div className="flex flex-col space-y-1">
                <label htmlFor="deadline" className="text-sm font-medium text-slate-700">
                    Deadline
                </label>
                <input id="deadline" type="date" min="0" className="px-3 py-2.5 text-sm text-slate-900 rounded-md bg-white w-full outline-1 -outline-offset-1 outline-slate-300 focus:outline-offset-2 focus:outline-blue-600"
                       {...register('deadline')}
                />
                {errors.deadline && (
                    <p className="text-xs text-red-500">{errors.deadline.message}</p>
                )}
            </div>

            {createProjectMutation.isError && (
                <p className="text-sm text-red-600">
                    {getApiErrorMessage(createProjectMutation.error)}
                </p>
            )}

            <button type="submit"
                    disabled={createProjectMutation.isPending}
                    className="w-full rounded-xl bg-black px-4 py-3 text-sm font-medium text-white transition hover:opacity-90">
                {createProjectMutation.isPending ? 'Saving...' : 'Save'}
            </button>

        </form>
    );
}

export default CreateProjectForm;
