import parse from "html-react-parser";

type Props = {
    innerHTML: string
    attrs?: {
        backgroundColor?:string,
        textColor?:string,
        fontSize?:string,
        align?:string
    }
}

export default function BlockCoreParagraph(
    {
        innerHTML,
    }: Props
){
    return parse(innerHTML);
}