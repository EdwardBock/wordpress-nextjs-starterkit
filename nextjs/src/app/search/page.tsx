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



    return (
        <div>
            Search for "{q}"
        </div>
    )
}