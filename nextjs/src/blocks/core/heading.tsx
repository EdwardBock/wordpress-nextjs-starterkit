import parse from "html-react-parser";

type Props = {
    innerHTML: string
    attrs?: {
        level?: number
    }
}

export default function BlockCoreHeading(
    {
        innerHTML,
    }: Props
){
    return parse(innerHTML);
}