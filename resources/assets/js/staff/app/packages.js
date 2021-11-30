import Vue from "vue";
import vueCalendar from "vue2-simple-calendar";
import Toasted from "vue-toasted";
import { ValidationProvider, ValidationObserver } from "vee-validate";
import BootstrapVue from "bootstrap-vue";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

import * as VueGoogleMaps from 'vue2-google-maps';
// import { GmapMarker } from 'vue2-google-maps/src/components/marker';
Vue.use(BootstrapVue);
Vue.use(VueSweetalert2);
Vue.use(Toasted, {
  iconPack: "fontawesome",
});
Vue.use(vueCalendar, {
  // configuration goes here.
});
Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyBdwDVYeELQ4eB5COg-TQqvtD_PEykKTyE',
    libraries: 'places', // This is required if you use the Autocomplete plugin
    // OR: libraries: 'places,drawing'
    // OR: libraries: 'places,drawing,visualization'
    // (as you require)

    //// If you want to set the version, you can do so:
    v: '3.26',
  },

  //// If you intend to programmatically custom event listener code
  //// (e.g. `this.$refs.gmap.$on('zoom_changed', someFunc)`)
  //// instead of going through Vue templates (e.g. `<GmapMap @zoom_changed="someFunc">`)
  //// you might need to turn this on.
  // autobindAllEvents: false,

  //// If you want to manually install components, e.g.
  //// import {GmapMarker} from 'vue2-google-maps/src/components/marker'
  //// Vue.component('GmapMarker', GmapMarker)
  //// then disable the following:
  installComponents: true,
})

Vue.component("ValidationProvider", ValidationProvider);
Vue.component("ValidationObserver", ValidationObserver);
Vue.component('google-map', VueGoogleMaps.Map);
Vue.component('ground-overlay', VueGoogleMaps.MapElementFactory({
  mappedProps: {
    'opacity': {}
  },
  props: {
    'source': { type: String },
    'bounds': { type: Object },
  },
  events: ['click', 'dblclick'],
  name: 'groundOverlay',
  ctr: () => google.maps.GroundOverlay,
  ctrArgs: (options, { source, bounds }) => [source, bounds, options],
}));
// Vue.component('GmapMarker', GmapMarker)
