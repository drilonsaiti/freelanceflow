import {Outlet} from "react-router-dom";
import Sidebar from "./ui/Sidebar.tsx";
import Navbar from "./ui/Navbar.tsx";

function AppLayout() {
    return (
        <div className="flex min-h-screen">

            {/* Sidebar */}
            <aside className="w-60 bg-slate-900 text-white">
                <Sidebar />
            </aside>

            {/* Right side */}
            <div className="flex flex-1 flex-col">

                <header className="h-14 ">
                    <Navbar />
                </header>

                <main className="bg-gray-50 flex-1 ">
                    <Outlet />
                </main>

            </div>

        </div>
    );
}

export default AppLayout;
