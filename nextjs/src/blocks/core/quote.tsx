import Blocks, {Block} from "@/blocks/Blocks";
import {parse} from "node-html-parser";

type Props = {
    innerBlocks: Block[],
    innerHTML: string
    innerContent: (string|null)[]
}

export default function BlockCoreQuote(
    {
        innerBlocks,
        innerHTML,
    }: Props
){

    const document =  parse(innerHTML);
    const citeContent = document.querySelector("cite")?.textContent ?? "";

    return (
        <blockquote>
            <Blocks content={innerBlocks} />
            {citeContent ? <cite>{citeContent}</cite> : null}
        </blockquote>
    );
}