import ProjectList from "../components/ProjectList.tsx";
import {useProjects} from "../hooks/useProjects.ts";

const ProjectsPage = () => {
    const {
        data,
        fetchNextPage,
        hasNextPage,
        isFetchingNextPage,
        isLoading,
    } = useProjects();

    const projects = data?.pages.flatMap(page => page.data) ?? [];

    if (isLoading) return (
        <div className="bg-gray-50 p-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            {Array.from({ length: 6 }).map((_, i) => (
                <div key={i} className="bg-white rounded-xl p-5 animate-pulse space-y-3">
                    <div className="h-4 bg-gray-200 rounded w-3/4" />
                    <div className="h-3 bg-gray-200 rounded w-1/2" />
                    <div className="h-3 bg-gray-200 rounded w-full" />
                </div>
            ))}
        </div>
    );

    return (
        <div>
            <ProjectList projects={projects} />

            <div className="flex justify-center p-4">
                {hasNextPage && (
                    <button onClick={() => fetchNextPage()}
                            disabled={isFetchingNextPage}
                            className="px-4 py-2 bg-blue-500 text-white rounded">
                        {isFetchingNextPage ? 'Loading...' : 'Load More'}
                        </button>
                )}
            </div>
        </div>
    );
};

export default ProjectsPage;
