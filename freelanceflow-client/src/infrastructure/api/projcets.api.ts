import {httpClient} from "../http/axios.instance.ts";
import type {ApiResponse, ProjectsResponse} from "../../shared/types/api.types.ts";
import type {Project} from "../../features/projects/types/project.types.ts";
import type {CreateProjectFormData} from "../../features/projects/schemas/project.schema.ts";

export const projectsApi = {
    getAll: (cursor?: string) =>
        httpClient.get<ProjectsResponse>('projects', {
            params: cursor ? { cursor } : {},
        }),
    getById: (ulid: string) => httpClient.get<ApiResponse<Project>>(`projects/${ulid}`),
    create: (data: CreateProjectFormData) => httpClient.post<ApiResponse<Project>>('projects',data),
    update: (ulid: string,data: Partial<CreateProjectFormData>) => httpClient.patch<ApiResponse<Project>>(`projects/${ulid}`,data),
}
