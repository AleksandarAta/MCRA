import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';


import { viteStaticCopy } from 'vite-plugin-static-copy';

import { normalizePath } from 'vite';
import path from 'node:path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
              {
                src: normalizePath(path.resolve(__dirname, 'vendor', 'tinymce', 'tinymce')),
                dest: normalizePath(path.resolve(__dirname, 'public'))
              },
            ]
          }),
    ],
});


