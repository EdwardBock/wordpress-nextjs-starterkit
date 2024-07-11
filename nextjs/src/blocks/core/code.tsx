import {parse} from "node-html-parser";

type Props = {
    innerHTML: string
}

export default function BlockCoreCode(
    {
        innerHTML,
    }:Props
){

    const documentPre =  parse(innerHTML);
    const documentCode = parse(documentPre.querySelector("pre")?.innerText ?? "");
    const text = documentCode?.innerText ?? "";

    return (
        <pre className="content-layout">
            <code>{text}</code>
        </pre>
    )
}