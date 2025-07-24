import { z } from "zod";

export const signUpSchema = z.object({
    name: z.string().min(5),
    email: z.string().email(),
    password: z.string().min(5),
});

export const signInSchema = signUpSchema.omit({ name: true });

export const createCourseSchema = z.object({
    name: z.string().min(2),
    categoryId: z.number().min(1, { message: "Please select category" }),
    tagline: z.string().min(5),
    description: z.string().min(10),
    thumbnail: z.any().refine((file) => file?.name, {
        message: "Thumbnail is required",
    }),
});

export const updateCourseSchema = createCourseSchema.partial({
    thumbnail: true,
});

export const mutateContentSchema = z
    .object({
        title: z.string().min(5),
        type: z.enum(["text", "video", "pdf"], {
            errorMap: () => ({ message: "Required content type" }),
        }),
        youtubeId: z.string().optional(),
        text: z.string().optional(),
        pdf: z.any().optional(),
        quiz: z.any().optional(),
        course_id: z.number().or(z.string()).optional(), // Add course_id
        order: z.number().optional(), // Add order
    })
    .superRefine((val, ctx) => {
        const parseVideoId = z.string().min(4).safeParse(val.youtubeId);
        const parseText = z.string().min(4).safeParse(val.text);

        if (val.type === "video") {
            if (!parseVideoId.success) {
                console.log("masukk yeee video");

                ctx.addIssue({
                    code: z.ZodIssueCode.custom,
                    message: "Youtube ID is required",
                    path: ["youtubeId"],
                });
            }
        }

        if (val.type === "text") {
            if (!parseText.success) {
                console.log("masukk yeee text");
                ctx.addIssue({
                    code: z.ZodIssueCode.custom,
                    message: "Content Text is required",
                    path: ["text"],
                });
            }
        }

        if (val.type === "pdf") {
            if (!parseText.success) {
                ctx.addIssue({
                    code: z.ZodIssueCode.custom,
                    message: "Upload PDF is required",
                    path: ["pdf"],
                });
            }
        }
        
        if (val.type === "quiz") {
            if (!parseText.success) {
                ctx.addIssue({
                    code: z.ZodIssueCode.custom,
                    message: "Upload PDF is required",
                    path: ["pdf"],
                });
            }
        }
    });
