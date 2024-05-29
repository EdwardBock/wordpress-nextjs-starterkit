import Image from "next/image";

export type ImageSize = [
    url: string,
    width: number,
    height: number,
    crop: boolean,
]

type Props = {
    attrs: {
        id: number,
        sizeSlug: string,
        linkDestination: string,
        src: ImageSize,
        sizes: ImageSize[]
        align?: string,
        alt?: string,
        caption?: string,
        width?: number
        height?: number
    }
}

export default function BlockCoreImage(
    {
        attrs,
    }: Props
){

    const [url, width, height] = attrs.src

    return (
        <figure>
            <Image
                src={url}
                width={width}
                height={height}
                alt={attrs.alt ?? ""}
            />
        </figure>
    )
}