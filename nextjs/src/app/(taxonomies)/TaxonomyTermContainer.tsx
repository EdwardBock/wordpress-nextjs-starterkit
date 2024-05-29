import {TaxonomyRepository} from "@/lib/repository/taxonomy-repository";
import {notFound} from "next/navigation";
import {PostsRepository} from "@/lib/repository/posts-repository";
import Link from "next/link";

type Props = {
    taxonomy: string
    term: string
}

export default async function TaxonomyTermContainer(
    {
        taxonomy,
        term: slug,
    }: Props
) {

    const taxonomyRepo = TaxonomyRepository();
    const term = await taxonomyRepo.getTermBySlug(slug, taxonomy);

    if (!term) notFound();

    const postsRepo = PostsRepository();

    const posts = await postsRepo.getPosts(taxonomy == "categories" ? {categories: String(term.id)} : {tags: String(term.id)});

    return (
        <div>
            <h1>All Posts in {taxonomy}/{term.name}</h1>
            <ul>
                {posts?.data?.map(post => {
                    return (
                        <li key={post.id}>
                            <Link href={post.path}>
                                {post.title?.rendered ?? ""}
                            </Link>
                        </li>
                    )
                })}
            </ul>
        </div>
    )
}