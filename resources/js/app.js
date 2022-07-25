import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import VueSmoothScroll from "v-smooth-scroll";
import VueGtag from "vue-gtag";

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText ||
    "Key Manager";

createInertiaApp({
    title: (title) => `${title} - ${"Key Manager"}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VueGtag, {
                config: { id: "G-FGFW0JR6DV" },
            })
            .use(ZiggyVue, Ziggy)
            .use(VueSmoothScroll)
            .mount(el);
    },
});

InertiaProgress.init({ color: "#4B5563" });
