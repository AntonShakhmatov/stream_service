import { createApp, h } from "vue";
import { createInertiaApp, Link } from "@inertiajs/vue3";
import { autoAnimatePlugin } from "@formkit/auto-animate/vue";
import Toast, { POSITION } from "vue-toastification";

import "vue-toastification/dist/index.css";
// @ts-ignore
import { ZiggyVue } from "ziggy-js";
import { AuthenticatedLayout, GuestLayout } from "./Layouts";
import { Notification } from "./components";
import {
  i18nVue,
  loadTranslations,
} from "./plugins/laravel-vue-i18n";
import { can } from "./plugins/can";
import { PageProps } from "./types/page";

const appName = "Mycamstars admin";

const lang = document.documentElement.lang
  ? document.documentElement.lang.replace("-", "_")
  : "en";

const app = createInertiaApp({
  title: (title) => {
    const titleElement = document.querySelector("title");

    if (titleElement && !titleElement.hasAttribute("inertia")) {
      titleElement.remove();
    }

    return title ? `${title} - ${appName}` : appName;
  },
  progress: { color: "#4B5563" },
  resolve: async (name) => {
    // @ts-ignore
    const pages = import.meta.glob("./Pages/**/*.vue");
    const page = (await pages[`./Pages/${name}.vue`]()).default;

    if (page.layout === undefined) {
      if (name.startsWith("Auth/")) {
        page.layout = GuestLayout;
      } else {
        page.layout = AuthenticatedLayout;
      }
    }

    return page;
  },
  setup({ el, App, props, plugin }) {
    loadTranslations(
      `/lang/${(props.initialPage.props.auth as PageProps["auth"])?.user?.locale ?? lang}/mycustomadmin.json`,
      (translations: JSON) => {
        return createApp({ render: () => h(App, props) })
          .use(plugin)
          .use(Toast, {
            transition: "Vue-Toastification__fade",
            rootComponent: Notification,
            position: POSITION.BOTTOM_RIGHT,
          })
          .use(i18nVue, {
            resolve: (lang: string) => {
              return translations;
            },
          })
          .use(autoAnimatePlugin)
          .use(ZiggyVue)
          .component("Link", Link)
          .directive("can", can)
          .mount(el);
      }
    );
  },
});

// Экспорт по умолчанию
export default app;
