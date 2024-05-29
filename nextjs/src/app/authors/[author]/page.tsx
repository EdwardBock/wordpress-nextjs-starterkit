
type Props = {
    params: {
        author: string
    }
}

export default async function Author_Page(
    {
        params: {
            author
        }
    }: Props
){

    return (
        <div>
            Author: {author}
        </div>
    )
}