import PostsRepository from "@/lib/repository/posts-repository";
import {CategoryResult, type PostResult, type RedirectResult} from "./types";
import TaxonomyRepository from "@/lib/repository/taxonomy-repository";

export async function getDataBySlugs(slugs: string[]) {

    // for next.config.js trailingSlash
    // https://nextjs.org/docs/app/api-reference/next-config-js/trailingSlash
    const currentPath = `/${slugs.map((slug) => encodeURIComponent(slug)).join("/")}`;
    const currentPaths = [currentPath, `${currentPath}/`];

    //------------------------------------------------
    // post
    //------------------------------------------------
    if (slugs?.length > 1) {

        //------------------------------------------------
        // permalink structure set to trailing post id
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

    //------------------------------------------------
    // page
    //------------------------------------------------
    const page = await PostsRepository.getPageByPath(slugs);
    if (page) {
        return page satisfies PostResult
    }

    //------------------------------------------------
    // category
    //------------------------------------------------
    const slug = slugs[slugs.length -1];
    if(slug){
        const term = await TaxonomyRepository.getTermBySlug(slug);
        if (term) {
            const url = new URL(term.link);
            if (!currentPaths.includes(url.pathname)) {

                // prevent duplicate content
                return {
                    to: url.pathname
                } satisfies RedirectResult
            }

            return term satisfies CategoryResult;
        }
    }

    //------------------------------------------------
    // nothing found
    //------------------------------------------------
    return null;
}

