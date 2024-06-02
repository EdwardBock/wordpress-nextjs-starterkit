import type {Metadata} from "next";
import {Inter} from "next/font/google";
import "./globals.css";
import {PropsWithChildren} from "react";

const inter = Inter({subsets: ["latin"]});

export const metadata: Metadata = {
    title: "WordPress + Next.js Startkit",
    description: "Get up to speed in minutes",
};

export default function RootLayout({children}: PropsWithChildren) {
    return (
        <html lang="en">
        <body className={inter.className}>{children}</body>
        </html>
    );
}
