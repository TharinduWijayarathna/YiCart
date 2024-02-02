import "./bootstrap";
import "../css/app.css";

import "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js";
import "https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js";
import "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js";
import "../src/assets/js/scripts.bundle.js";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import laravelPermissionToVuejs from "laravel-permission-to-vuejs";
import VueApexCharts from "vue3-apexcharts";

const appName = " M Mobile ";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(laravelPermissionToVuejs)
            .use(VueApexCharts)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
