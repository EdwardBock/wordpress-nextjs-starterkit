import Blocks, {Block} from "@/blocks/Blocks";
import parse from "html-react-parser";

type Props = {
    innerBlocks: Block[]
    innerHTML?: string
}

export default function BlockCoreListItem(
    {
        innerHTML,
        innerBlocks,
    }: Props
){
    return (
        <li>
            {parse(innerHTML?.replace("</li>", "").replace("<li>", "").replace("\n", "") ?? '')}
            <Blocks content={innerBlocks ?? []} />
        </li>
    )
}