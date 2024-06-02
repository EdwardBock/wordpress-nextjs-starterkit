import UsersRepository from "@/lib/repository/users-repository";
import {notFound} from "next/navigation";
import PostsRepository from "@/lib/repository/posts-repository";
import Link from "next/link";

type Props = {
    params: {
        author: string
    }
}

export default async function Author_Page(
    {
        params: {
            author
        }
    }: Props
){

    const user = await UsersRepository.getUserBySlug(author);

    if(!user){
        notFound();
    }

    const posts = await PostsRepository.getPosts({
        author: `${user.id}`,
    })

    return (
        <div>
            <h1>Author: {user.name}</h1>
            <ul>
                {posts?.data?.map(post => {
                    return (
                        <li key={post.id}>
                            <Link href={post.path}>{post.title?.rendered}</Link>
                        </li>
                    )
                })}
            </ul>
        </div>
    )
}