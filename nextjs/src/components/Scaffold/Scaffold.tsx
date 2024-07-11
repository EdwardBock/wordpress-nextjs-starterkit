import {PropsWithChildren, ReactNode} from "react";
import styles from './Scaffold.module.css';

type Props = {
    header: ReactNode
    footer: ReactNode
}

export default function Scaffold(
    {
        header,
        children,
        footer,
    }: PropsWithChildren<Props>
){
    return (
        <div className={styles.scaffold}>
            <header className={styles.header}>
                {header}
            </header>

            {children}

            <footer className={styles.footer}>
                {footer}
            </footer>
        </div>
    )
}