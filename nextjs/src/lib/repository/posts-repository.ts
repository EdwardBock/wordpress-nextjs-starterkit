import {wpFetchPostById, wpFetchPosts, wpFetchSettings} from "@/lib/source/wp-rest";
import {buildHierarchy, Hierarchy} from "@palasthotel/wp-rest";
import {GetHeadlessPostsRequestArgs} from "@palasthotel/headless";

const postTypeMapping: { [key: string]: string } = {
    "post": "posts",
    "page": "pages",
}

export function PostsRepository(){

    async function getPostById(id: number, postType: string = "post"){
        const response = await wpFetchPostById(
            id,
            postTypeMapping?.[postType] ?? postType
        );
        if(!response) return null;

        return await hydrate(response);
    }

    async function getFrontPage(){
        const settings = await wpFetchSettings();
        const pageId = settings?.page_on_front;

        if (pageId == null || pageId <= 0) return null;

        return getPostById(pageId, "page");
    }

    async function getPageByPath(pathSegments: string[]){
        const result = await wpFetchPosts({
            slug: pathSegments.join(","),
            type: "pages",
        });

        if(!result) return null;

        const hierarchy = buildHierarchy(
            result.data,
            (page) => {
                return page.id
            },
            (page) => {
                return page.parent ? page.parent : false;
            },
        );

        const page = findPageInHierarchy(hierarchy, pathSegments);

        return page ? await hydrate(page) : null;

    }

    async function getPosts(args: Pick<GetHeadlessPostsRequestArgs, "tags" | "categories" | "page" | "per_page"> = {}){
        // TODO: hydrate
        const response = await wpFetchPosts(args);

        if(!response) return null;

        return {
            ...response,
            data: await Promise.all(response?.data.map(hydrate)),
        }
    }

    return {
        getPosts,
        getPostById,
        getFrontPage,
        getPageByPath,
    }
}

async function hydrate<T extends {link: string}>(post:T){
    const url = new URL(post.link);

    return {
        ...post,
        path: url.pathname,
    };
}

function findPageInHierarchy<T extends {slug: string}>(list: Hierarchy<T>[], slugs: string[]){
    const remainingSlugs = [...slugs];
    const slug = remainingSlugs.shift() ?? "";
    const candidate = list.find(h => h.item.slug == slug);
    if (candidate == undefined) {
        return false;
    }
    if (remainingSlugs.length > 0) {
        return findPageInHierarchy(candidate.children, remainingSlugs);
    }
    return candidate.item;
}