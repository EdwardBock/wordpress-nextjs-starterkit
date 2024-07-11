"use client";

import {ReactNode, useState} from "react";
import styles from './Gallery.module.css';
import Button from "@/components/Button/Button";

type Props = {
    items: ReactNode[]
    className?: string
}

export default function Gallery(
    {
        items,
        className = ""
    }: Props
) {

    const [visibleItem, setVisibleItem] = useState(0);

    const lastItemIsVisible = visibleItem == items.length - 1;
    const firstItemIsVisible = visibleItem === 0;

    return (
        <div className={[styles.gallery, className].join(" ")}>
            <div className={styles.stage}>

                {items.map((item, index) => {
                    return (
                        <div
                            key={index}
                            className={[styles.item, index == visibleItem ? styles.visible : ""].join(" ")}
                        >
                            {item}
                        </div>
                    )
                })}
            </div>
            <div className={styles.controls}>
                <Button
                    disabled={firstItemIsVisible}
                    onClick={() => setVisibleItem(prev => Math.max(0, prev - 1))}
                >
                    ←
                </Button>
                <Button
                    disabled={lastItemIsVisible}
                    onClick={() => setVisibleItem(prev => Math.min(prev + 1, items.length - 1))}
                >
                    →
                </Button>
            </div>
        </div>
    )
}