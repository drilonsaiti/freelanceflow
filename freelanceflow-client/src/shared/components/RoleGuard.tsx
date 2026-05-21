import type {UserRole} from "../types/user-role.ts";
import {useAuthStore} from "../../features/auth/stores/auth.store.ts";

interface RoleGuardProps {
    allowedRoles: UserRole[];
    children: React.ReactNode;
    fallback?: React.ReactNode;
}


function RoleGuard({
    allowedRoles,
    children,
    fallback = null,
                   }: RoleGuardProps) {
    const { user } = useAuthStore();

    const hasAccess = user && allowedRoles.includes(user.role.toLowerCase() as UserRole);

    if (!hasAccess) {
        return <>{fallback}</>
    }

    return <>{children}</>;
}

export default RoleGuard;
