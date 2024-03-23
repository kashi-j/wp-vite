import { defineConfig } from "vite";
import liveReload from "vite-plugin-live-reload";
import sassGlobImports from "vite-plugin-sass-glob-import";
import path from "path";

const themePath = "http://localhost:10195/wp-content/themes/wp-vite";
const assets =
  process.env.NODE_ENV === "development"
    ? themePath + "/public/"
    : themePath + "/dist/";

export default defineConfig({
  plugins: [
    liveReload([__dirname + "/**/*.php", __dirname + "/**/*.hbs"]),
    sassGlobImports(),
  ],
  root: "",
  base: process.env.NODE_ENV === "development" ? "./" : "/dist/",
  build: {
    outDir: path.resolve(__dirname, "./dist"),
    emptyOutDir: true,
    manifest: true,
    target: "es2018",
    rollupOptions: {
      input: {
        main: path.resolve(__dirname + "/main.js"),
      },
      output: {
        entryFileNames: `assets/[name].js`,
        chunkFileNames: `assets/[name].js`,
        assetFileNames: ({ name }) => {
          if (/\.( gif|jpeg|jpg|png|svg|webp| )$/.test(name ?? "")) {
            return "assets/images/[name].[ext]";
          }
          if (/\.css$/.test(name ?? "")) {
            return "assets/css/[name].[ext]";
          }
          if (/\.js$/.test(name ?? "")) {
            return "assets/js/[name].[ext]";
          }
          return "assets/[name].[ext]";
        },
      },
    },
    assetsInlineLimit: 0,
    minify: true,
    write: true,
  },
  server: {
    cors: true,
    strictPort: true,
    port: 3006,
    https: false,
    watch: {
      usePolling: true,
    },
    hmr: {
      host: "localhost",
      interval: 2000,
    },
  },
  // logLevel: 'error',
  clearScreen: true,
  css: {
    devSourcemap: true,
    preprocessorOptions: {
      scss: {
        additionalData: `$base-dir: '` + assets + `';`,
        // additionalData: `
        //   $base-dir: '` +
        //     assets +
        //     `';
        //   $public-dir: '` +
        //     public_assets +
        //     `';
        // `,
        sourceMap: true,
      },
    },
  },
});
