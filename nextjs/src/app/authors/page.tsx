import {wpFetchUsers} from "@/lib/source/wp-rest";
import Link from "next/link";
import Image from "next/image";
import Destinations from "@/lib/destinations";

export default async function Authors_Page(){

    const users = await wpFetchUsers();

    return (
        <div>
            <h1>Authors</h1>
            <ul>
                {users?.data?.map(user => {
                    const avatarUrl = user.avatar_urls["96"]
                    return (
                        <li key={user.id}>
                            <Link href={Destinations.author({slug: user.slug})}>
                                {avatarUrl ?
                                    <>
                                        <Image
                                            src={avatarUrl}
                                            alt={""}
                                            width={96}
                                            height={96}
                                        />
                                        <br/>
                                    </>
                                    : null
                                }
                                {user.name}
                            </Link>
                        </li>
                    )
                })}
            </ul>
        </div>
    )
}