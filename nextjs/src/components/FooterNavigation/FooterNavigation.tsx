import {PropsWithChildren} from "react";
import styles from "./FooterNavigation.module.css";

export default function FooterNavigation(
    {
        children
    }: PropsWithChildren
){
    return (
        <nav className={`${styles.nav} content-layout`}>
            {children}
        </nav>
    )
}