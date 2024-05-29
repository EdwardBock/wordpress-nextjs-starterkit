
function post({category, postSlug, postId}:{category: string, postSlug: string, postId: number}){
    return `/${category}/${postSlug}-${postId}`;
}

function term({taxonomy, term}:{taxonomy: string, term: string}){
    return `/${taxonomy}/${term}`;
}

function categories(){
    return  "/categories";
}

function category({category}:{category: string}){
    return term({taxonomy: "categories", term: category});
}

function tags(){
    return `/tags`;
}

function tag({tag}: {tag: string}){
    return term({taxonomy: "tags", term: tag});
}

const Destinations = {
    post,
    term,
    categories,
    category,
    tags,
    tag,
}

export default Destinations;