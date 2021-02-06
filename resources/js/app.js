import Vue from "vue";
import store from "~/store";
import router from "~/router";
import i18n from "~/plugins/i18n";
import App from "~/components/App";

import Notifications from "vue-notification";
import VueSocialSharing from "vue-social-sharing";

import "bootstrap";

import "~/plugins";
import "~/mixins";

Vue.use(VueSocialSharing);
Vue.use(Notifications);

Vue.config.productionTip = false;

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App,
});

// import { Workbox } from "workbox-window";

// if ("serviceWorker" in navigator) {
//   const wb = new Workbox("/service-worker.js");

//   wb.register();
// }
