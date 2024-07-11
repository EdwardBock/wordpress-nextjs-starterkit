import {PropsWithChildren} from "react";
import styles from "./MainNavigation.module.css";

export default function MainNavigation(
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