import {
    getTermsRequest,
    GetTermsRequestArgs,
    isError,
    isParseError,
    responseAsCollection,
    responseAsEntity,
    termResponseSchema,
    logIssues
} from "@palasthotel/wp-rest";
import {
    GetHeadlessPostsRequestArgs, getPostsWithBlocksRequest,
    getPostWithBlocksRequest,
    getSettingsRequest,
    postWithBlocksResponseSchema,
    settingsResponseSchema,
    withHeadlessParam,
} from "@palasthotel/headless";
import config from "@/lib/config";

export async function wpFetchSettings(){
    const url = getSettingsRequest({
        baseUrl: config.wp.baseUrl,
    });

    const result = await fetch(url).then(responseAsEntity(settingsResponseSchema));

    if(isParseError(result)){
        result.errors.forEach(console.error);
        console.error(url);
        return null;
    }

    if(isError(result)){
        console.error(url);
        return null;
    }

    return result;
}

export async function wpFetchPostById(id: number, postType: string = "posts"){
    const url = getPostWithBlocksRequest({
        baseUrl:config.wp.baseUrl,
        id,
        type: postType,
    });

    const result = await fetch(url,{
        next: {
            revalidate: 60,
            tags: ['posts', `post(${id})`, `postType(${postType})`],
        }
    }).then(responseAsEntity(postWithBlocksResponseSchema));

    if(isParseError(result)){
        logIssues(result);
        console.error(url);
        return null;
    }

    if(isError(result)){
        console.error(url);
        return null;
    }

    return result;
}

export async function wpFetchPosts(
    args: Omit<GetHeadlessPostsRequestArgs, "baseUrl">
){
    const url = getPostsWithBlocksRequest({
        baseUrl: config.wp.baseUrl,
        ...args,
    });

    const result = await fetch(url, {
        next: {
            revalidate: 5 * 60,
            tags: ['posts', `postType(${args.type})`],
        }
    }).then(responseAsCollection(postWithBlocksResponseSchema.array()));

    if(isParseError(result)){
        logIssues(result);
        console.error(url);
        return null;
    }

    if(isError(result)){
        console.error(url);
        return null;
    }

    return result;
}

export async function wpFetchTerms(
    args: Omit<GetTermsRequestArgs, "baseUrl">,
) {
    const url = getTermsRequest({
        baseUrl: config.wp.baseUrl,
        per_page: 100,
        ...args,
    });

    const result = await fetch(
        withHeadlessParam(url),
        {
            next: {
                revalidate: 5 * 60,
                tags: ["terms", `terms-${args.taxonomy}`],
            }
        }
    ).then(responseAsCollection(termResponseSchema.array()));

    if (isParseError(result)) {
        logIssues(result);
        console.error(url);
        return null;
    }

    if (isError(result)) {
        console.error(url);
        return null;
    }

    return result;

}