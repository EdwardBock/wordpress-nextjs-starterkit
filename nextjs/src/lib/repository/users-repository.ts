import {wpFetchUser, wpFetchUsers} from "@/lib/source/wp-rest";


const UsersRepository = {
    getUserBySlug,
    getUserById,
}

export default UsersRepository;

async function getUserBySlug(slug: string) {
    const response = await wpFetchUsers(
        {
            slug,
        }
    );

    return response?.data?.find(u => u.slug === slug);
}

async function getUserById(id: number) {
    return await wpFetchUser(id);
}
