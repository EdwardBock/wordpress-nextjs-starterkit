import Blocks, {Block} from "@/blocks/Blocks";

type Props = {
    innerHTML: string
    attrs?: {
        className?: string
        ordered?: boolean
        backgroundColor?: string
        textColor?: string
    }
    innerBlocks?: Block[]
    innerContent?: []
}

export default function BlockCoreList(
    {
        innerBlocks,
    }: Props
){

    return (
        <ul>
            <Blocks content={innerBlocks ?? []} />
        </ul>
    )
}