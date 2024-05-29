import Blocks, {Block} from "@/blocks/Blocks";

type Props = {
    innerBlocks: Block[]
}

export default function BlockCoreButtons(
    {
        innerBlocks
    }: Props
){
    return <div>
        <Blocks content={innerBlocks ?? []} />
    </div>;
}