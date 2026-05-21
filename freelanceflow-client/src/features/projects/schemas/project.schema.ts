import {z} from 'zod'
export const createProjectSchema = z.object({
    title: z.string().min(3,'Title is required').max(190),
    description: z.string().optional(),
    budgetMin: z.coerce.number().min(0).optional(),
    budgetMax: z.coerce.number().min(0).optional(),
    category: z.string().optional(),
    status: z.enum(['draft','open']),
    visibility: z.enum(['public','private','invite_only']),
    requiredSkills: z.array(z.string()).optional(),
    deadline: z.coerce.date().optional(),
});

export type CreateProjectFormData = z.input<typeof createProjectSchema>;
