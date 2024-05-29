import {PostsRepository} from "@/lib/repository/posts-repository";
import {notFound} from "next/navigation";
import Blocks from "@/blocks/Blocks";

type Props = {
    id: number
}
export default async function PostContainer(
    {
        id
    }: Props
){

    const post = await PostsRepository().getPostById(id, "post");

    if(post == null) {
        notFound();
    }

    const content = post.content.headless_blocks ? post.content.headless_blocks : [];

    return (
        <div>
            <h1>{post.title?.rendered}</h1>
            <Blocks content={content} />
        </div>
    )
}