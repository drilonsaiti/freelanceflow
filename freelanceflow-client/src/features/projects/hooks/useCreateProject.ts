import {useMutation, useQueryClient} from "@tanstack/react-query";
import {projectsApi} from "../../../infrastructure/api/projcets.api.ts";

export const useCreateProject = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: projectsApi.create,
        onSuccess: () => {
            queryClient.invalidateQueries({queryKey: ['projects']});
        }
    })
};
