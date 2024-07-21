import {z} from "zod";

const configSchema = z.object({
    db: z.object({
        host: z.string(),
        user: z.string(),
        password: z.string(),
        database: z.string(),
    }),
    wp: z.object({
        baseUrl: z.string().url(),
        secretToken: z.string(),
        application: z.object({
            username: z.string(),
            password: z.string(),
        })
    }),
});

const config = configSchema.parse({
    db: {
        host: process.env.DB_HOST,
        user: process.env.DB_USER,
        password: process.env.DB_PASSWORD,
        database: process.env.DB_DATABASE,
    },
    wp: {
        baseUrl: process.env.WP_BASE_URL,
        secretToken: process.env.SECRET_TOKEN,
        application: {
            username: process.env.WP_APP_USERNAME,
            password: process.env.WP_APP_PASSWORD,
        }
    }
});

export default config;