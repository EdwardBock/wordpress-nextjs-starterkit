import {notFound} from "next/navigation";
import PostsRepository from "@/lib/repository/posts-repository";
import Link from "next/link";
import Pagination from "@/components/Pagination/Pagination";

type Props = {
    params: {
        page: string
    }
}

export default async function ArchivePage(
    {
        params: {
            page,
        }
    }: Props
) {

    const intPage = parseInt(page);
    if (isNaN(intPage) || intPage <= 0) {
        notFound();
    }

    const result = await PostsRepository.getPosts({
        per_page: 5,
        page: intPage,
    });

    if(result == null || result.data.length == 0) {
        notFound();
    }

    const posts = result.data;

    return (
        <div>
            <h1>Archive</h1>

            <ul>
                {posts.map(post => {
                    return (
                        <li key={post.id}>
                            <Link href={post.path}>{post.title?.rendered}</Link>
                        </li>
                    )
                })}
            </ul>

            <Pagination
                basePath="/archive/page/"
                currentPage={intPage}
                pages={result.totalPages}
            />

        </div>
    )
}