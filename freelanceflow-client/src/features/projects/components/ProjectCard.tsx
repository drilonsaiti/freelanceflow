import type {Project, ProjectStatus} from "../types/project.types.ts";
import {AlarmClock, UserIcon, Wallet} from "lucide-react";
import {Link} from "react-router-dom";

const statusDot: Record<ProjectStatus, string> = {
    draft: "bg-gray-400",
    open: "bg-green-500",
    in_progress: "bg-blue-500 animate-pulse",
    completed: "bg-purple-500",
    cancelled: "bg-red-500",
};

const ProjectCard = ({
                         id,
                         title,
                         description,
                         status,
                         budget,
                         deadline,
                         client,
                         category,
                     }: Project) => {

    return (
        <div
            className="relative bg-white border border-gray-100 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col gap-4">

            <div className="absolute right-4 top-4">
                <span
                    className={`w-3 h-3 rounded-full block ${statusDot[status.value]}`}
                />
            </div>

            <div className="flex flex-col gap-1">
                <div className="flex items-center justify-between pr-6">
                    <h2 className="text-lg font-semibold text-gray-900 hover:underline line-clamp-1">
                        <Link to={`/projects/${id}`}>
                            {title}
                        </Link>
                    </h2>
                    <span className="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600">
                        {category}
                    </span>
                </div>

                <div className="flex items-center gap-2 text-sm text-gray-500">
                    <UserIcon size={16}/>
                    <span>{client.name}</span>
                </div>
            </div>

            <p className="text-sm text-gray-600 line-clamp-2">
                {description}
            </p>

            <div className="flex items-center justify-between text-sm text-gray-600 pt-2 border-t border-gray-100">

                <div className="flex items-center gap-2">
                    <Wallet className="h-4 w-4 text-gray-400"/>
                    <span>
                        {budget.min} - {budget.max}
                    </span>
                </div>

                <div className="flex items-center gap-2">
                    <AlarmClock className="h-4 w-4 text-gray-400"/>
                    <span>
                        {deadline ? deadline.toString() : "No date"}
                    </span>
                </div>
            </div>
        </div>
    );
};

export default ProjectCard;
