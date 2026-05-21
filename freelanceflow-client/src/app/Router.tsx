import {BrowserRouter, Route, Routes} from "react-router-dom";
import ProtectedRoute from "../shared/components/ProtectedRoute.tsx";
import LoginPage from "../features/auth/pages/LoginPage.tsx";
import RegisterPage from "../features/auth/pages/RegisterPage.tsx";
import RoleGuard from "../shared/components/RoleGuard.tsx";
import CreateProjectPage from "../features/projects/pages/CreateProjectPage.tsx";
import AppLayout from "../shared/components/AppLayout.tsx";
import ProjectsPage from "../features/projects/pages/ProjectsPage.tsx";
import ProjectDetailPage from "../features/projects/pages/ProjectDetailPage.tsx";

export const Router = () => (
    <BrowserRouter>
        <Routes>
            <Route path="/login" element={<LoginPage />} />
            <Route path="/register" element={<RegisterPage />} />
            <Route element={<ProtectedRoute />}>
                <Route element={<AppLayout />}>
                    <Route path="/projects" element={<ProjectsPage />} />
                    <Route path='/projects/create'
                           element={
                               <RoleGuard allowedRoles={['client']}>
                                   <CreateProjectPage />
                               </RoleGuard>
                           } />
                    <Route path="/projects/:id" element={<ProjectDetailPage />} />
                </Route>


            </Route>
        </Routes>
    </BrowserRouter>
);
