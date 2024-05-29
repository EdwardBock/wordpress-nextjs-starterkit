import {TaxonomyRepository} from "@/lib/repository/taxonomy-repository";
import Link from "next/link";
import Destinations from "@/lib/destinations";

type Props = {
    taxonomy: string
}

export default async function TaxonomyContainer(
    {
        taxonomy
    }: Props
) {


    const taxonomyRepo = TaxonomyRepository();
    const terms = await taxonomyRepo.getTerms(taxonomy);

    return (
        <div>
            <h1>All Terms in Taxonomy {taxonomy}</h1>
            <ul>
                {terms?.data?.map(term => {
                    return (
                        <li key={term.id}><Link href={Destinations.term({taxonomy, term: term.slug})}>{term.name}</Link></li>
                    )
                })}
            </ul>
        </div>
    )
}