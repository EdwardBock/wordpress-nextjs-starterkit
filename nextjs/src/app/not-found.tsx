import PostsRepository from "@/lib/repository/posts-repository";
import Link from "next/link";

export default async function NotFoundPage(){
    const posts = await PostsRepository.getPosts();
    return (
        <div>
            <h1>Nothing found</h1>
            <p>What about this?</p>
            <ul>
                {posts?.data?.map(post => {
                    return (
                        <li key={post.id}><Link href={post.path}>{post.title?.rendered}</Link></li>
                    )
                })}
            </ul>
        </div>
    )
}