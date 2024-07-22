import {wpFetchPostById, wpFetchPosts, wpFetchSettings, wpFetchTerms} from "@/lib/source/wp-rest";
import {buildHierarchy, Hierarchy} from "@palasthotel/wp-rest";

const TaxonomyRepository = {
    getTermBySlug,
    getTerms,
    getTermsByPost
}

export default TaxonomyRepository;

async function getTerms(taxonomy: string = "categories") {
    return await wpFetchTerms(
        {
            taxonomy,
        }
    );
}

async function getTermBySlug(slug: string, taxonomy: string = "categories") {
    const response = await wpFetchTerms(
        {
            slug,
            taxonomy,
        }
    );
    if (!response) return null;

    return response.data.find(t => t.slug == slug) ?? null;
}

async function getTermsByPost(id: number, taxonomy: string = "categories") {
    const terms = await wpFetchTerms({
        post: id,
        taxonomy,
    });
    return terms?.data ?? [];
}

