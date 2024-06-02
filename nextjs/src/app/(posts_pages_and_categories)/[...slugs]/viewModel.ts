import PostsRepository from "@/lib/repository/posts-repository";
import {CategoryResult, type PostResult, type RedirectResult} from "./types";
import TaxonomyRepository from "@/lib/repository/taxonomy-repository";

export async function getBySlugs(slugs: string[]) {

    // for next.config.js trailingSlash
    // https://nextjs.org/docs/app/api-reference/next-config-js/trailingSlash
    const currentPath = `/${slugs.map(encodeURIComponent).join("/")}`;
    const currentPaths = [currentPath, `${currentPath}/`];

    if (slugs?.length == 2) {

        //------------------------------------------------
        // single post with id at the end
        //------------------------------------------------
        const postSlug = slugs[slugs.length - 1];
        const id = Number(postSlug?.split("-").pop());
        if (!isNaN(id)) {
            const post = await PostsRepository.getPostById(id);
            if (post) {

                if (!currentPaths.includes(post.path)) {
                    // prevent duplicate content
                    return {
                        to: post.path
                    } satisfies RedirectResult
                }

                return post satisfies PostResult;
            }
        }

    }

    if (slugs.length == 1) {
        //------------------------------------------------
        // category
        //------------------------------------------------
        const term = await TaxonomyRepository.getTermBySlug(slugs[0]);
        if (term != null) {
            return term satisfies CategoryResult;
        }
    }

    //------------------------------------------------
    // page
    //------------------------------------------------
    const page = await PostsRepository.getPageByPath(slugs);
    if (page != null) {
        return page satisfies PostResult
    }

    //------------------------------------------------
    // nothing found
    //------------------------------------------------
    return null;
}

