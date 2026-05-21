import {Link} from "react-router-dom";

const Sidebar = () => {
    return (
        <div className="bg-gray-200 h-full">
            <div className="flex flex-col h-full">
                <h1 className="text-2xl text-gray-900 p-2">FreelanceFLOW</h1>
                {/* Navigation Links*/}
                <Link to="/projects" className="text-gray-800 hover:bg-gray-300 p-2">Projects</Link>
            </div>

        </div>
    );
};

export default Sidebar;
