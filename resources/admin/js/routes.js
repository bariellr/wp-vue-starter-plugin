import { createWebHashHistory, createRouter } from "vue-router";
import Settings from "./pages/Settings.vue";
import About from "./pages/About.vue";

const routes = [
    {
        path: "/",
        name: "Settings",
        component: Settings,
        props: true,
    },
    {
        path: "/about",
        name: "About",
        component: About,
        props: true,
    },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

export default router;
