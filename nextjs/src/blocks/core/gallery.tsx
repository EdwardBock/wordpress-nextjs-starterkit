import Image from "next/image";
import {ImageSize} from "@/blocks/core/image";
import Gallery from "@/components/Gallery/Gallery";


type Props = {
    attrs: {
        ids: number[]
    }
    innerBlocks: {
        attrs: {
            id: number
            sizeSlug: string
            linkDestination: string
            src: ImageSize
            sizes: ImageSize[]
            alt: string
            caption: string
        }
    }[]
}

export default function BlockCoreGallery(
    {
        innerBlocks,
    }: Props
) {

    return (
        <Gallery items={innerBlocks.map(image => {
            const {id, src, alt} = image.attrs;
            const [url, width, height] = src;
            return (
                <Image
                    style={{width: 600, height:"auto"}}
                    key={id}
                    src={url}
                    width={width}
                    height={height}
                    alt={alt}
                />
            )
        })}>
        </Gallery>
    )
}