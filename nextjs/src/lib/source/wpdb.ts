import mysql from "mysql2/promise";
import wpCreate, {getOption} from "@public-function/wp";
import config from "@/lib/config";

const dbConfig = config.db;

const pool = mysql.createPool({
    host: dbConfig.host,
    user: dbConfig.user,
    database: dbConfig.database,
    password: dbConfig.password,
});

const wp = wpCreate({
    db: {
        client: pool,
        prefix: "wp_"
    }
});

export async function getPageOnFront(){
    const pageId = await getOption(wp, "page_on_front");
    if(pageId == null) return null;
    const intId = parseInt(pageId.value);
    return isNaN(intId) ? null : intId;
}