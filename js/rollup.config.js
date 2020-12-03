import resolve from '@rollup/plugin-node-resolve';
import babel from '@rollup/plugin-babel';
import json from '@rollup/plugin-json';
import commonjs from '@rollup/plugin-commonjs';
import globals from 'rollup-plugin-node-globals';
import { terser } from 'rollup-plugin-terser';
import copy from 'rollup-plugin-copy';
import analyze from 'rollup-plugin-analyzer';

export default {
    input: './src/boot.js',
    output: {
        file: './build/rawb-search-dashboard-boot.js',
        format: 'iife',
        sourcemap: true,
    },
    plugins: [
        json(),
        resolve({
            browser: true,
        }),
        commonjs({
            include: 'node_modules/**',
        }),
        babel({ babelHelpers: 'bundled' }),
        globals(),
        //        copy({
        //            targets: [
        //                { src: 'assets/**/*', dest: './build/assets' }
        //            ]
        //        }),
        (process.env.NODE_ENV === 'production' && terser()),
        (process.env.ANALYZE === 'true' && analyze({ summaryOnly: true })),
    ],
    watch: {
        exclude: 'node_modules/**',
    },
};
