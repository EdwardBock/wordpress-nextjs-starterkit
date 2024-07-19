/** @type {import('next').NextConfig} */
const nextConfig = {
    logging: {
      fetches: {
         fullUrl: true,
      }
    },
    images: {
        remotePatterns: [
            {
                protocol: 'http',
                hostname: 'localhost',
                port: '8080',
                pathname: '/wp-content/**',
            },
            {
                hostname: '**.gravatar.com',
            },
        ],
    },
    async redirects(){
        return [
            {
                source: "/archive",
                destination: "/archive/page/1",
                permanent: true,
            }
        ]
    }
};

export default nextConfig;
