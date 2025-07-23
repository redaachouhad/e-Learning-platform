import "./assets/main.css";

import { createPinia } from "pinia";
import { createApp } from "vue";

import Toast from "vue-toastification";
import App from "./App.vue";
import router from "./router";
// Import the CSS or use your own!
import type { PluginOptions } from "vue-toastification";
import "vue-toastification/dist/index.css";

const pinia = createPinia();

const app = createApp(App);

app.use(pinia);
app.use(router);

const options: PluginOptions = {
  position: "top-right",
  timeout: 5000,
  closeOnClick: true,
  pauseOnFocusLoss: true,
  pauseOnHover: true,
  draggable: true,
  draggablePercent: 0.6,
  showCloseButtonOnHover: false,
  hideProgressBar: false,
  closeButton: "button",
  icon: true,
  rtl: false,
  transition: "Vue-Toastification__slideBlurred",
  maxToasts: 20,
  newestOnTop: true,
};

app.use(Toast, options);

app.mount("#app");
