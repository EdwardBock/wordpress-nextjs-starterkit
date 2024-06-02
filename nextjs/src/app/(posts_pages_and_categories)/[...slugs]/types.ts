import PostsRepository from "@/lib/repository/posts-repository";
import TaxonomyRepository from "@/lib/repository/taxonomy-repository";

const isObject = (data: any) => data != null && typeof data == "object";

export type PostResult = NonNullable<Awaited<ReturnType<typeof PostsRepository.getPostById>>>

export function isPostResult(data: any): data is PostResult {
    return isObject(data) && typeof data.id == "number" && typeof data.type == "string";
}

export type RedirectResult = {
    to: string
}

export function isRedirectResult(data: any): data is RedirectResult {
    return isObject(data) && typeof data.to == "string" && Object.keys(data).length == 1;
}

export type CategoryResult = NonNullable<Awaited<ReturnType<typeof TaxonomyRepository.getTermBySlug>>>

export function isCategoryResult(data: any): data is CategoryResult {
    return isObject(data) && typeof data.id == "number" && typeof data.taxonomy == "string";
}