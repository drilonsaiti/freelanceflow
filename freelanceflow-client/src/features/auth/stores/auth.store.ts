import type {AuthState, User} from "../types/auth.types.ts";
import { create } from 'zustand';
import { persist } from 'zustand/middleware';


interface AuthStore extends AuthState {
    setAuth: (user: User,token: string) => void;
    clearAuth: () => void;
}

export const useAuthStore = create<AuthStore>()(
    persist(
        (set) => ({
            user: null,
            token: null,
            isAuthenticated: false,
            setAuth: (user, token) =>
                set({ user, token, isAuthenticated: true }),
            clearAuth: () =>
                set({ user: null, token: null, isAuthenticated: false }),
        }),
        {
            name: 'auth-storage',
        }
    )
);
