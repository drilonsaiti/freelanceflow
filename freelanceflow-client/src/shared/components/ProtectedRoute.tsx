import {useAuthStore} from "../../features/auth/stores/auth.store.ts";
import {Navigate, Outlet,} from "react-router-dom";

function ProtectedRoute() {
    const { isAuthenticated } = useAuthStore();

    if (!isAuthenticated) {
        return <Navigate to="/login" replace />;
    }
    return <Outlet />;
}

export default ProtectedRoute;
