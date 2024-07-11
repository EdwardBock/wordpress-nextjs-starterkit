# WordPress ♥️ Next.js Starterkit

Unlock the full potential of your WordPress site with this comprehensive integration of WordPress template hierarchy into Next.js routes. This cutting-edge solution leverages the power of the Next.js app router, ensuring a seamless and efficient experience for developers and users alike.

## In short and sweet

- `nextjs/` contains the **nextjs** source code
- `proxy/` contains **nginx** configuration for single domain setup (optional)
- `wordpress/` contains all **wordpress** related code
    - `/wp-content` contains plugins and themes
    - `wp.ini` some php configuration
- `docker-compose.yml` spin up wordpress and nginx

## Getting started

```shell
docker compose up -d

cd nextjs
npm i 
npm run dev

```

Goto [localhost:8081](http://localhost:8081/) for the wordpress installation.

Goto [localhost:3000](http://localhost:3000/) for the next.js application.

Goto [localhost:8080](http://localhost:8081/) for both next.js and wordpress depending on the url path.

## Key Features

- **Gutenberg:** Every Block is represented by it's own React Component. No more dangerouslySetInnerHTML of the post content.
- **Full Integration:** Full WordPress template hierarchy integration into Next.js.
- **Optimized URL Structure:** Creates search engine optimized URLs for better visibility.
