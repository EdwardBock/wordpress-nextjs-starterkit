import {parse} from "node-html-parser";

type Props = {
    innerHTML: string
    attrs?: {
        className?: string
    }
}

export default function BlockCoreButton(
    {
        innerHTML,
        attrs: {
            className = ""
        } = {}
    }: Props
){
    const document =  parse(innerHTML);

    const a = document.querySelector("a");

    const href = a?.getAttribute("href") ?? "#";
    return <a href={href} className={className}>{a?.textContent}</a>
}