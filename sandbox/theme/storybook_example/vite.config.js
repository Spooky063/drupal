import { defineConfig } from "vite"
import twig from 'vite-plugin-twig-drupal'
import { join } from 'node:path'
import { resolve } from 'path'
import fg from 'fast-glob'

const entries = fg
  .sync([
    'src/components/**/*.{js,ts}',
    'src/components/**/*.css',
    '!src/components/**/*.stories.{js,ts}',
    'src/css/**/*.css'
  ])

export default defineConfig({
  plugins: [
    twig({
      namespaces: {
        'storybook_example': join(__dirname, 'src/components'),
      },
    }),
  ],
  resolve: {
    alias: {
      "@": resolve(__dirname, './src'),
      "@components": resolve(__dirname, './src/components'),
    }
  },
  publicDir: './public',
  build: {
    minify: 'esbuild',
    cssCodeSplit: true,
    outDir: 'dist',
    sourcemap: true,
    lib: {
      name: 'storybook_example',
      formats: ['es'],
      entry: entries,
      fileName: ''
    },
    rollupOptions: {
      input: {
        'css/app': resolve(__dirname, 'src/app.css'),
        'js/app': resolve(__dirname, 'src/app.js'),
      },
    }
  },
  server: {
    host: '0.0.0.0',
    open: false,
  },
})
