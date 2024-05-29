import {wpFetchPostById, wpFetchPosts, wpFetchSettings, wpFetchTerms, wpFetchUsers} from "@/lib/source/wp-rest";
import {buildHierarchy, Hierarchy} from "@palasthotel/wp-rest";


export function UseresRepository() {

    async function getUserBySlug(slug: string){
        const response = await wpFetchUsers(
            {
                slug,
            }
        );

        return response?.data?.find(u => u.slug === slug);
    }

    return {
        getUserBySlug,
    }
}
