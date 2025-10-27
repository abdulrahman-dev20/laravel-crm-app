import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    // KRITIS: TAMBAHKAN BLOK INI UNTUK LINGKUNGAN SAIL/DOCKER
    server: {
        host: "0.0.0.0", // Mendengarkan dari semua host
        hmr: {
            host: "localhost", // Atau IP Docker Anda jika diperlukan, tetapi localhost biasanya berhasil
        },
        port: 5173,
    },
});
