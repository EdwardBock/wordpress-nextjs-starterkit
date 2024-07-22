import PostsRepository from "@/lib/repository/posts-repository";
import {notFound} from "next/navigation";
import Blocks from "@/blocks/Blocks";
import Destinations from "@/lib/destinations";
import UsersRepository from "@/lib/repository/users-repository";
import Link from "next/link";
import TaxonomyRepository from "@/lib/repository/taxonomy-repository";

type Props = {
    id: number
}
export default async function PostContainer(
    {
        id
    }: Props
){

    const post = await PostsRepository.getPostById(id, "post");

    if(post == null) {
        notFound();
    }

    const authorId = post?.author
    const author = authorId ? await UsersRepository.getUserById(authorId) : null;

    const categories = await TaxonomyRepository.getTermsByPost(id);

    const content = post?.content.headless_blocks ? post?.content.headless_blocks : [];

    return (
        <div>
            <h1>{post?.title?.rendered}</h1>
            <Blocks content={content} />
            <p>Autor: <Link href={Destinations.author({slug: author?.slug ?? ""})}>{author?.name}</Link></p>
            <p>Categories: {categories.map(term => {
                return <Link
                    key={term.id}
                    href={Destinations.term({term: term.slug, taxonomy: "categories"})}
                >{term.name}</Link>
            })}</p>
        </div>
    )
}