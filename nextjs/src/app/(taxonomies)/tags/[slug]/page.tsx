import TaxonomyTermContainer from "@/app/(taxonomies)/TaxonomyTermContainer";

type Props = {
    params: {
        slug: string
    }
}

export default async function TermPage(
    {
        params: {
            slug
        }
    }: Props
){
    return (
        <TaxonomyTermContainer taxonomy="tags" term={slug} />
    )
}