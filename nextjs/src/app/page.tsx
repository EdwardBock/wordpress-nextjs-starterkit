import {notFound} from "next/navigation";
import Blocks from "@/blocks/Blocks";
import {PostsRepository} from "@/lib/repository/posts-repository";

export default async function Home() {

    const page = await PostsRepository().getFrontPage();

    if (!page) notFound();

    const blocks = page?.content?.headless_blocks;

    return (
        <>
            <header>
                <h1>{page?.title?.rendered}</h1>
            </header>
            <main>
                <Blocks content={Array.isArray(blocks) ? blocks : []}/>
            </main>
        </>
    );
}
