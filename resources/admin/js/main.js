import { createApp } from "vue";
import App from "./App.vue";
import router from "./routes";
import menuFix from "./admin-menu-fix";

createApp(App).use(router).mount("#wpvueplugin-admin-app");

menuFix("wpvueplugin-admin-app");
