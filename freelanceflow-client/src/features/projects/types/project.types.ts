export type ProjectStatus = "draft" | "open" | "in_progress" | "completed" | "cancelled";
export interface Project {
    id: string;
    title: string;
    description: string;
    budget: {
        min: number | null;
        max: number | null;
    };
    status: {
        value: ProjectStatus;
        label: string;
    };
    visibility: {
        value: string;
        label: string;
    };
    category: string;
    required_skills: string[];
    deadline: Date | null;
    client: {
        id: string;
        name: string;
    };
    created_at: string;
}
