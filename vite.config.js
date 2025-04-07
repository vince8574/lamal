import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import dotenv from 'dotenv';
import tailwindcss from '@tailwindcss/vite'
dotenv.config();

const extendedViteDevServerOptions = {}

if (process.env.GITPOD_VITE_URL) {
    extendedViteDevServerOptions.hmr = {
        protocol: 'wss',
        host: new URL(process.env.GITPOD_VITE_URL).hostname,
        clientPort: 443
    }
} else if (process.env.KDA_FQDN) {
    extendedViteDevServerOptions.hmr = {
        host: process.env.KDA_FQDN,
    }
}

console.log(extendedViteDevServerOptions)


export default defineConfig({
    server: {
        //https: true,
        cors: true,
        ...extendedViteDevServerOptions
    },

    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
