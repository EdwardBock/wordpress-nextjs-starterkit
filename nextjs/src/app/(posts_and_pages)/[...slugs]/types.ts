
const isObject = (data: any) => data != null && typeof data == "object";

export type PostResult = {
    id: number
    postType: string
}

export function isPostResult(data: any): data is PostResult {
    return isObject(data) && typeof data.id == "number" && typeof data.postType == "string";
}

export type RedirectResult = {
    path: string
}

export function isRedirectResult(data: any): data is RedirectResult {
    return isObject(data) && typeof data.path == "string" && Object.keys(data).length == 1;
}

