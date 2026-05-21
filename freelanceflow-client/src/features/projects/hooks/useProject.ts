import {useQuery} from "@tanstack/react-query";
import {projectsApi} from "../../../infrastructure/api/projcets.api.ts";

export const useProject = (ulid: string) => {
    return useQuery({
        queryKey: ['project',ulid],
        queryFn: () => projectsApi.getById(ulid)
            .then(res => res.data.data),
        enabled: !!ulid,
    })
};
