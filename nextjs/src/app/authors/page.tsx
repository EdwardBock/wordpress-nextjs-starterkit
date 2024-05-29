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
                    return (
                        <li key={user.id}>
                            <Link href={Destinations.author({slug: user.slug})}>
                                <Image
                                    src={user.avatar_urls["96"]}
                                    alt={""}
                                    width={96}
                                    height={96}
                                />
                                <br/>
                                {user.name}
                            </Link>
                        </li>
                    )
                })}
            </ul>
        </div>
    )
}