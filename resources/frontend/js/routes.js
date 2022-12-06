import { createWebHashHistory, createRouter } from "vue-router";
import Home from "./pages/Home.vue";
import About from "./pages/About.vue";

const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
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
