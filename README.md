# WordPress with️ Next.js Starterkit

Unlock the full potential of your WordPress site with this comprehensive integration of WordPress template hierarchy into Next.js routes. This cutting-edge solution leverages the power of the Next.js app router, ensuring a seamless and efficient experience for developers and users alike.

## In short and sweet

- `nextjs/` contains the **nextjs** source code
- `wordpress/` contains all **wordpress** related code
    - `wp-content/` contains plugins and themes
    - `wp.ini` some php configuration
- `proxy/` contains **nginx** configuration for single domain setup (optional)
- `docker-compose.yml` spin up wordpress and nginx

## Getting started

```shell
docker compose up -d

cd nextjs
npm i 
npm run dev

```

Goto [localhost:8081](http://localhost:8081/) for the WordPress installation.

Goto [localhost:3000](http://localhost:3000/) for the Next.js application.

Goto [localhost:8080](http://localhost:8081/) for both Next.js and WordPress depending on the url path.

**Important:** After WordPress installation you need to change the permalink settings to:

-  **Permalink Structure:** `/%category%/%postname%-%post_id%/`
- **Category base:** `.`
- **Tag base:** `tags`

This aligns the WordPress permalink structures with the Next.js routes.

## Key Features

- **Gutenberg Block Editor:** Each Block is represented by its own React Component, ensuring **safe content rendering without using dangerouslySetInnerHTML** for post content
- **Full Integration:** Full WordPress template hierarchy integration into Next.js.
- **Optimized URL Structure:** Creates search engine optimized URLs for better visibility.


## Liked it?

[!["Buy Me A Coffee"](https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png)](https://www.buymeacoffee.com/edwardbock)