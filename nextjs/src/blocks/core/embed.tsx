import parse from "html-react-parser";

type Props = {
    innerHTML: string
    attrs?: Partial<{
        url:string
        type: string
        providerNameSlug: string
        responsive: boolean
        className: string
        isResolved: boolean
        resolvedHTML: string
    }>
}

export default function BlockCoreEmbed(
    {
        innerHTML,
        attrs: {
            url,
            className,
            resolvedHTML,
        } = {}
    }: Props
){
    return parse(resolvedHTML ?? "");
}