import CreateProjectForm from "../components/CreateProjectForm.tsx";

function CreateProjectPage() {
    return (
        <div className="form-container bg-gray-50 px-8">
            <div className="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
                <div className="p-6 rounded bg-white border-slate-300 shadow-xs">
                    <h1 className="text-slate-900 text-center text-3xl font-bold">Create Project</h1>
                    <CreateProjectForm />
                </div>
            </div>
        </div>
    );
}

export default CreateProjectPage;
