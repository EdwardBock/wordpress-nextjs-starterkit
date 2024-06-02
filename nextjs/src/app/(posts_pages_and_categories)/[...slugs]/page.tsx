import {isCategoryResult, isPostResult, isRedirectResult} from "./types";
import {notFound, redirect} from "next/navigation";
import PostContainer from "./PostContainer";
import PageContainer from "./PageContainer";
import {getBySlugs} from "./viewModel";
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
){
    const data = await getBySlugs(slugs);

    if(isPostResult(data)){
        return {
            title: data.title?.rendered,
            description: data.excerpt?.rendered,
        } satisfies Metadata
    }

    if(isCategoryResult(data)){

        return {
            title: data.name,
            description: data.description,
        } satisfies Metadata
    }


    return {} satisfies Metadata
}

export default async function Page(
    {
        params: {
            slugs
        }
    }: Props
){
    const data = await getBySlugs(slugs);

    if(!data){
        notFound();
    }

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