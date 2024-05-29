"use client";

import {PropsWithChildren} from "react";
import styles from './Button.module.css';

type Props = {
    disabled?: boolean
    className?: string
    onClick?: () => void
}
export default function Button(
    {
        children,
        disabled = false,
        className,
        onClick,
    }: PropsWithChildren<Props>
){
    return (
        <button
            className={[styles.button, className].join(' ')}
            disabled={disabled}
            onClick={onClick}
        >
            {children}
        </button>
    )
}