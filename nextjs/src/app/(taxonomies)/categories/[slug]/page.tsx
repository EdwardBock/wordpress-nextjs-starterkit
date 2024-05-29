import TaxonomyTermContainer from "@/app/(taxonomies)/TaxonomyTermContainer";

type Props = {
    params: {
        slug: string
    }
}

export default async function CategoryPage(
    {
        params: {
            slug
        }
    }: Props
){
    return (
        <TaxonomyTermContainer taxonomy="categories" term={slug} />
    )
}