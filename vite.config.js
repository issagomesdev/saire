import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        // host 0.0.0.0 e necessario para o Hot Module Replacement
        // funcionar quando o Vite roda dentro do container "node"
        // (docker-compose.yml). Nao afeta o uso fora do Docker: o
        // navegador continua acessando via localhost normalmente.
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost',
        },
    },
});
