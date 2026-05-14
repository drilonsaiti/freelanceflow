export interface User{
    id: string;
    name: string;
    email: string;
    role: 'freelancer' | 'client' | 'admin';
    create_at: string;
}

export interface AuthState {
    user: User | null;
    token: string | null;
    isAuthenticated: boolean;
}
