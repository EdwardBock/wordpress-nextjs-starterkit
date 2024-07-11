import styles from './Columns.module.css';
import {CSSProperties, PropsWithChildren} from "react";

type Props = {
    columns: number
    isStackedMobile?: boolean
    className?: string
}

export default function Columns(
    {
        columns,
        isStackedMobile = true,
        children,
        className,
    }: PropsWithChildren<Props>
){
    return (
        <div
            className={`${styles.columns} ${className}`}
            data-is-stacked-mobile={isStackedMobile}
            style={{
                "--_columns": columns,
            } as CSSProperties}
        >
            {children}
        </div>
    )
}