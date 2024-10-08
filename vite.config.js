import { defineConfig } from "vite";
import symfonyPlugin from "vite-plugin-symfony";

/* if you're using React */
// import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        /* react(), // if you're using React */
        symfonyPlugin({
            stimulus: true
        }),
    ],
    build: {
        rollupOptions: {
            input: {
                theme: "./assets/theme/app.js"
            },
        }
    },
});
