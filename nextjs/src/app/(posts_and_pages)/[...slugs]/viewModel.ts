import {PostsRepository} from "@/lib/repository/posts-repository";
import {type PostResult, type RedirectResult} from "./types";

export async function getBySlugs(slugs: string[]) {

    const postsRepo = PostsRepository();

    // for next.config.js trailingSlash
    // https://nextjs.org/docs/app/api-reference/next-config-js/trailingSlash
    const currentPath = `/${slugs.map(encodeURIComponent).join("/")}`;
    const currentPaths = [currentPath, `${currentPath}/`];

    if (slugs?.length == 2) {

        //------------------------------------------------
        // single post
        //------------------------------------------------
        const postSlug = slugs[slugs.length - 1];
        const id = Number(postSlug?.split("-").pop());
        if (!isNaN(id)) {
            const post = await postsRepo.getPostById(id);
            if (post) {

                if (!currentPaths.includes(post.path)) {
                    // prevent duplicate content
                    return {
                        path: post.path,
                    } satisfies RedirectResult
                }

                return {
                    id: post.id,
                    postType: post.type,
                } satisfies PostResult
            }
        }

    }

    //------------------------------------------------
    // page
    //------------------------------------------------
    const page = await postsRepo.getPageByPath(slugs);
    if (page != null) {
        return {
            id: page.id,
            postType: page.type,
        } satisfies PostResult
    }

    //------------------------------------------------
    // nothing found
    //------------------------------------------------
    return null;
}

