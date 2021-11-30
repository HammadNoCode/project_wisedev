require("./bootstrap");
// IMPORT => Core
import Vue from "vue";
import router from "./router";
import store from "./store";
import "./filters";
import "./packages";


// => Packages
import moment from "moment";
// import VueSignature from "vue-signature-pad";
// Vue.use(VueSignature);

import vueSignature from "vue-signature";
Vue.use(vueSignature);


// => Layout
const Sidebar = require("./components/layout/Sidebar.vue").default;
const Navbar = require("./components/layout/Navbar.vue").default;
const Footnote = require("./components/layout/Footnote.vue").default;
// VUE app
router.beforeEach((to, from, next) => {
	store.dispatch('showUser').then(() => {
		next();
	})
})

const app = new Vue({
	el: "#app",
	store,
	router,
	components: {
		sidebar: Sidebar,
		navbar: Navbar,
		footnote: Footnote,
	},
	created() {
		this.init();
	},
	methods: {
		init() {
			store.dispatch('showCallUsers');
		},
		notification(message, type) {
			var options = {
				theme: "bubble",
				position: "top-right",
				duration: 5000,
			};
			if (type === "error") {
				this.$toasted.error(message, options);
			} else {
				this.$toasted.success(message, options);
			}
		},
		difference_percentage(num1, num2) {
			if (num1 > 0 && num2 > 0) {
				return ((num1 / num2) * 100 - 100).toFixed();
			}
			return null;
		},
		format_number(val) {
			return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		},
		format_percentage(val) {
			return val.toFixed(2);
		},
		format_date(date) {
      return moment(date).format("DD/MM/YYYY");
    },
	},
});
