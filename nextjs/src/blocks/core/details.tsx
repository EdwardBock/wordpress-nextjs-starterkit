import {parse} from "node-html-parser";
import Blocks, {Block} from "@/blocks/Blocks";

type Props = {
    innerHTML: string
    innerBlocks: Block[]
}

export default function BlockCoreDetails(
    {
        innerHTML,
        innerBlocks,
    }:Props
){
    const document = parse(innerHTML);
    const summary = document.querySelector("summary")?.innerText ?? "";
    return (
        <details className="content-layout">
            <summary>{summary}</summary>
            <Blocks content={innerBlocks} />
        </details>
    )
}