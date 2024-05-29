import {parse} from "node-html-parser";

type Props = {
    innerHTML: string
}

export default function BlockCorePullQuote(
    {
        innerHTML
    }: Props
){

    const document =  parse(innerHTML);
    const quote = document.querySelector("blockquote p")?.innerText ?? "";
    const cite = document.querySelector("cite")?.innerText ?? "";

    return (
        <blockquote>
            <p>{quote}</p>
            {cite != "" ? <cite>{cite}</cite> : null}
        </blockquote>
    );
}