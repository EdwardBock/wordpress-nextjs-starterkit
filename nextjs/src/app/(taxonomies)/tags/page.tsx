import TaxonomyContainer from "@/app/(taxonomies)/TaxonomyContainer";
import {Metadata} from "next";

export async function generateMetadata(): Promise<Metadata> {

    return {}
}

export default async function TagsPage(){
    return (
        <TaxonomyContainer taxonomy={"tags"} />
    )
}