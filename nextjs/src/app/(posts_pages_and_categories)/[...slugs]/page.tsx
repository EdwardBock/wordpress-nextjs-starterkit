import {isCategoryResult, isPostResult, isRedirectResult} from "./types";
import {notFound, redirect} from "next/navigation";
import PostContainer from "./PostContainer";
import PageContainer from "./PageContainer";
import {getDataBySlugs} from "./viewModel";
import TaxonomyTermContainer from "@/app/(taxonomies)/TaxonomyTermContainer";
import {Metadata} from "next";

type Props = {
    params: {
        slugs: string[]
    }
}
export async function generateMetadata(
    {
        params: {
            slugs,
        }
    }: Props
): Promise<Metadata> {
    const data = await getDataBySlugs(slugs);

    if(isPostResult(data)){
        return {
            title: data.title?.rendered,
            description: data.excerpt?.rendered,
        }
    }

    if(isCategoryResult(data)){

        return {
            title: data.name,
            description: data.description,
        }
    }

    return {}
}

export default async function Page(
    {
        params: {
            slugs
        }
    }: Props
){
    const data = await getDataBySlugs(slugs);

    if(isRedirectResult(data)){
        redirect(data.to);
    }

    if(isPostResult(data)){
        return data.type == "post" ? <PostContainer id={data.id} /> : <PageContainer id={data.id} />;
    }

    if(isCategoryResult(data)){
        return <TaxonomyTermContainer taxonomy="categories" term={data.slug} />
    }

    notFound();
}

export const revalidate = 300;

export async function generateStaticParams(){
    // TODO: build with x latest posts from env
    return [];
}