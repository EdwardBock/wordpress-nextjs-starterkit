type Props = {
    searchParams: {
        q?: string
    }
}

export default async function Search_Page(
    {
        searchParams: {
            q = "",
        }
    }: Props
){

    console.debug(q);

    return (
        <div>
            Search
        </div>
    )
}