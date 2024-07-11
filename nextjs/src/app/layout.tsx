import type {Metadata} from "next";
import {Inter} from "next/font/google";
import {PropsWithChildren} from "react";
import Link from "next/link";
import {wpFetchMenu} from "@/lib/source/wp-rest";

import "./globals.css";
import MainNavigation from "@/components/MainNavigation/MainNavigation";
import FooterNavigation from "@/components/FooterNavigation/FooterNavigation";
import Scaffold from "@/components/Scaffold/Scaffold";

const inter = Inter({subsets: ["latin"]});

export const metadata: Metadata = {
    title: "WordPress + Next.js Starter Kit",
    description: "Get up to speed in minutes",
};

export default async function RootLayout({children}: PropsWithChildren) {

    const [mainMenuResult, footerMenuResult] = await Promise.allSettled([
        wpFetchMenu("main"),
        wpFetchMenu("footer"),
    ]);

    const mainMenu = mainMenuResult.status == "fulfilled" ? mainMenuResult.value : null;
    const footerMenu = footerMenuResult.status == "fulfilled" ? footerMenuResult.value : null;

    return (
        <html lang="en">
        <body className={inter.className}>
        <Scaffold
            header={
                <MainNavigation>
                    <Link href="/">Home</Link>
                    {mainMenu?.map((item, index) => {
                        return (
                            <Link key={`${index}-${item.url}`} href={item.url}>{item.title}</Link>
                        )
                    })}
                </MainNavigation>
            }
            footer={
                <FooterNavigation>
                    {footerMenu?.map((item, index) => {
                        return (
                            <Link key={`${index}-${item.url}`} href={item.url}>{item.title}</Link>
                        )
                    })}
                </FooterNavigation>
            }
        >
            {children}
        </Scaffold>
        </body>
        </html>
    );
}
