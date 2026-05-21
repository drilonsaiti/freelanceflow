import {AlarmClock, UserIcon, Wallet} from "lucide-react";
import type {Project} from "../types/project.types.ts";

type ProjectDetailProps = Project & {
    isOwner: boolean;
    isFreelancer: boolean;
};

const ProjectDetail = ({
                           title,
                           description,
                           budget,
                           deadline,
                           client,
                           status,
                           required_skills,
                           isOwner,
                           isFreelancer,
                       }: ProjectDetailProps) => {

    return (
        <div className="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow-sm border border-gray-100 space-y-6">
            <div>
                <h1 className="text-2xl font-bold text-gray-900">
                    {title}
                </h1>
                <p className="text-gray-600 mt-2">
                    {description}
                </p>
            </div>

            <div className="grid grid-cols-2 gap-4 text-sm text-gray-700">
                <div className="flex items-center gap-2">
                    <Wallet className="h-4 w-4 text-gray-500"/>
                    <span>
                        {budget.min} - {budget.max}
                    </span>
                </div>
                <div className="flex items-center gap-2">
                    <AlarmClock className="w-4 h-4 text-gray-500" />
                    <span>{deadline ? deadline.toString() : "No date"}</span>
                </div>

                <div className="flex items-center gap-2">
                    <UserIcon className="w-4 h-4 text-gray-500" />
                    <span>{client.name}</span>
                </div>

                <div>
                    <span className="px-2 py-1 rounded-full bg-gray-100 text-gray-600 text-xs">
                        {status.label}
                    </span>
                </div>
            </div>

            <div>
                <h3 className="text-sm font-semibold text-gray-700 mb-2">
                    Required Skills
                </h3>

                <div className="flex flex-wrap gap-2">
                    {required_skills?.map((skill: string) => (
                        <span
                            key={skill}
                            className="px-2 py-1 bg-blue-50 text-blue-600 text-xs rounded-full"
                        >
                            {skill}
                        </span>
                    ))}
                </div>
            </div>

            <div className="flex justify-end gap-3 pt-4 border-t border-gray-100">

                {isOwner && (
                    <button className="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition">
                        Edit Project
                    </button>
                )}

                {isFreelancer && (
                    <button className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-500 transition">
                        Submit Proposal
                    </button>
                )}
            </div>

        </div>
    );
};

export default ProjectDetail;
