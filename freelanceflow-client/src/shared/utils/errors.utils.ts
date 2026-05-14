import {AxiosError} from "axios";
import type {ApiError} from "../types/api.types.ts";

export const getApiErrorMessage = (error: unknown): string => {
    if (error instanceof AxiosError) {
        const data = error.response?.data as ApiError;
        return data?.message ?? 'Something went wrong. Please try again later.'
    }

    return 'An unexpected error occurred. Please try again later.'
}
