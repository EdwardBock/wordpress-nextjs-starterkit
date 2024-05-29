import {isPostResult, isRedirectResult} from "./types";
import {notFound, redirect} from "next/navigation";
import PostContainer from "./PostContainer";
import PageContainer from "./PageContainer";
import {getBySlugs} from "./viewModel";

type Props = {
    params: {
        slugs: string[]
    }
}

export default async function Page(
    {
        params: {
            slugs
        }
    }: Props
){
    const data = await getBySlugs(slugs);

    if(isRedirectResult(data)){
        redirect(data.path);
    }

    if(isPostResult(data)){
        return data.postType == "post" ? <PostContainer id={data.id} /> : <PageContainer id={data.id} />;
    }

    notFound();
}