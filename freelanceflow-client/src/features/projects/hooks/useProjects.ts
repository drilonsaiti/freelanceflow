import {type InfiniteData, useInfiniteQuery} from "@tanstack/react-query";
import {projectsApi} from "../../../infrastructure/api/projcets.api.ts";
import type {ProjectsResponse} from "../../../shared/types/api.types.ts";

export const useProjects = () => {
    return useInfiniteQuery<
        ProjectsResponse,
        Error,
        InfiniteData<ProjectsResponse>,
        string[],
        string | undefined
    >({
        queryKey: ['projects'],

        queryFn: ({ pageParam }) =>
            projectsApi.getAll(pageParam).then(res => res.data),

        initialPageParam: undefined,

        getNextPageParam: (lastPage) => {
            return lastPage.next_cursor ?? undefined;
        },
    });
};
