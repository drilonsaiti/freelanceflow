import type {Project} from "../types/project.types.ts";
import ProjectCard from "./ProjectCard.tsx";

type ProjectListProps = {
    projects: Project[] | undefined;
};

const ProjectList = ({projects}: ProjectListProps) => {
    return (
        <div className="bg-gray-50 p-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            {projects?.map(project => (
                <ProjectCard key={project.id} {...project} />
            ))}

        </div>
    );
};

export default ProjectList;
