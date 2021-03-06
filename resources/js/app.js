require("./bootstrap");

import Vue from "vue";

import { App, plugin } from "@inertiajs/inertia-vue";
import PortalVue from "portal-vue";
import vuetify from "./vuetify";
import moment from "moment";

Vue.mixin({ methods: { route } });
Vue.use(PortalVue);
Vue.use(plugin);

Vue.prototype.$moment = moment;

const app = document.getElementById("app");

new Vue({
    vuetify,
    render: h =>
        h(App, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: name => require(`./Pages/${name}`).default
            }
        })
}).$mount(app);
