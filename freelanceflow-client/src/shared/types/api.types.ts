export interface ApiResponse<T> {
    data: T;
    message: string;
}

export interface ApiError {
    message: string;
    error: Record<string, string[]>;
}

export interface PaginatedResponse<T> extends ApiResponse<T[]> {
    meta: {
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    }
}
