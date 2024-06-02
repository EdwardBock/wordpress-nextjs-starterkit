import dynamic from "next/dynamic";
import {Suspense} from "react";

export type Block = {
    blockName: string | null
    innerBlocks?: Block[]
}

type Props = {
    content: Block[]
}

export default async function Blocks(
    {
        content,
    }: Props
) {

    return (
        <Suspense>
            {content.map(async (block, index) => {
                if (block.blockName == null) {
                    return null;
                }

                const BlockComponent = await getBlockByName(block.blockName);

                if (BlockComponent == null) {
                    return null;
                }

                return <BlockComponent
                    key={`${block.blockName}-${index}`}
                    {...block}
                />
            })}
        </Suspense>
    )
}

function NotFoundBlock({blockName}: { blockName: string }) {
    return <p>{blockName} not implemented yet!</p>
}

async function getBlockByName(blockName: string) {
    return dynamic(
        async () => {
            try {
                return await import(`./${blockName}.tsx`);
            } catch (e) {
                return () => NotFoundBlock({blockName});
            }
        }
    );
}


