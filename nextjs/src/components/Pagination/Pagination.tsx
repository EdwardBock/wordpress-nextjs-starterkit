import Link from "next/link";
import styles from './Pagination.module.css';

type Props = {
    currentPage: number
    pages: number
    basePath: string
}

export default function Pagination(
    {
        currentPage,
        pages,
        basePath,
    }: Props
) {

    const items = [
        currentPage - 2,
        currentPage - 1,
        currentPage,
        currentPage + 1,
        currentPage + 2,
    ]

    return (
        <nav className={styles.pagination}>
            {items.map(page => {
                if(page < 1 || page > pages){
                    return null;
                }
                return (
                    <Link
                        key={page}
                        href={`${basePath}${page}`}
                        data-is-current={page === currentPage}
                    >
                        {page}
                    </Link>
                )
            })}
        </nav>
    )
}