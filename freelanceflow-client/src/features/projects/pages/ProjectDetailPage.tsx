import ProjectDetail from "../components/ProjectDetail.tsx";
import {useParams} from "react-router-dom";
import {useAuthStore} from "../../auth/stores/auth.store.ts";
import {useProject} from "../hooks/useProject.ts";

const ProjectDetailPage = () => {
    const {id} = useParams<{id: string}>();
    const {data:project, isLoading, error} = useProject(id || "");
    const { user } = useAuthStore();
    if (isLoading) {
        return (
            <div className="p-6 max-w-3xl mx-auto animate-pulse space-y-4">
                <div className="h-6 bg-gray-200 rounded w-1/2"></div>
                <div className="h-4 bg-gray-200 rounded w-full"></div>
                <div className="h-4 bg-gray-200 rounded w-2/3"></div>
            </div>
        )
    }

    if (error || !project) {
        return (
            <div className="p-6 text-red-500">
                Failed to load project.
            </div>
        );
    }

    const isOwner = user?.id === project.client.id;
    const isFreelancer = user?.role.toLowerCase() === 'freelancer';


    return (
        <div>
            <ProjectDetail
                {...project}
                isOwner={isOwner}
                isFreelancer={isFreelancer}
            />
        </div>
    );
};

export default ProjectDetailPage;
