import {z} from 'zod'

export const loginSchema = z.object({
    email: z.string().email('Invalid email address'),
    password: z.string().min(8,'Password is required')
});

export const registerSchema = z.object({
    name: z.string().min(2,'Name is required'),
    email: z.string().email('Invalid email address'),
    password: z.string().min(8,'Password is required'),
    password_confirmation: z.string().min(8,'Password confirmation is required'),
    role: z.enum(['freelancer','client']),
}).refine(data => data.password === data.password_confirmation, {
    message: 'Passwords do not match',
    path: ['password_confirmation'],
})

export type LoginFormData = z.infer<typeof loginSchema>;
export type RegisterFormData = z.infer<typeof registerSchema>;
