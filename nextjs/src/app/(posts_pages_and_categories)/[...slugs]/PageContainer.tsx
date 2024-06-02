import PostsRepository from "@/lib/repository/posts-repository";
import {notFound} from "next/navigation";
import Blocks from "@/blocks/Blocks";

type Props = {
    id: number
}

export default async function PageContainer(
    {
        id
    }: Props
){
    const page = await PostsRepository.getPostById(id, "page");

    if(page == null) {
        notFound();
    }

    const content = page?.content.headless_blocks ? page?.content.headless_blocks : [];

    return (
        <div>
            <h1>{page?.title?.rendered}</h1>
            <Blocks content={content} />
        </div>
    )
}