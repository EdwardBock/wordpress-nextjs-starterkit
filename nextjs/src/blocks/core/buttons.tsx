import Blocks, {Block} from "@/blocks/Blocks";

type Props = {
    innerBlocks: Block[]
}

export default function BlockCoreButtons(
    {
        innerBlocks
    }: Props
){
    return <div className="content-layout">
        <Blocks content={innerBlocks ?? []} />
    </div>;
}