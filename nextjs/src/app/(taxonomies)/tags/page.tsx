import TaxonomyContainer from "@/app/(taxonomies)/TaxonomyContainer";

export default async function TagsPage(){
    return (
        <TaxonomyContainer taxonomy={"tags"} />
    )
}