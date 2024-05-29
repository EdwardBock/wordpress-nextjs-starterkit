import Blocks, {Block} from "@/blocks/Blocks";

type Props = {
    innerBlocks: Block[],
    innerContent: (string|null)[]
}

export default function BlockCoreQuote(
    {
        innerBlocks,
        innerContent,
    }: Props
){
    let citeContent = innerContent[innerContent.length - 1];

    if(citeContent != null && citeContent.includes("<cite>")){
       citeContent = citeContent
           .replace("<cite>","")
           .replace("</cite>", "")
           .replace("</blockquote>", "");
    } else {
        citeContent = null;
    }

    return (
        <blockquote>
            <Blocks content={innerBlocks} />
            {citeContent ? <cite>{citeContent}</cite> : null}
        </blockquote>
    );
}