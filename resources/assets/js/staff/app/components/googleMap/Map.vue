<template>
    <div>
        <!-- <div class="row">
            <div class="col-lg-4 col-12 py-1 ml-auto input-group">
                <div class="input-group-append">
                    <span class="input-group-text">Roles</span>
                </div>
                <select class="form-control text-center" name="time-range" v-model="filterBy" @change="filterMap()">
                    <optgroup label="Position">
                        <option value="all">All</option>
                        <option value="Healthcare Assistant">Healthcare Assistant</option>
                        <option value="Senior Healthcare Assistant">Senior Healthcare Assistant</option>
                        <option value="RGN">RGN</option>
                        <option value="RMN">RMN</option>
                        <option value="Support Worker">Support Worker</option>
                    </optgroup>
                </select>
            </div>
            <div class="col-lg-4 col-12 py-1 input-group">
                <div class="input-group-append">
                    <span class="input-group-text">Status</span>
                </div>
                <select class="form-control text-center" name="time-range" v-model="filter" @change="filterMap()">
                    <optgroup label="Status">
                        <option value="accepted">Accepted</option>
                        <option value="live">Live</option>
                    </optgroup>
                </select>
            </div>
            <div class="col-lg-3 col-12 input-group">
                <div class="input-group-append">
                    <span class="input-group-text">Radius</span>
                </div>
                <select name="" id="" class="form-control selectpicker" v-model="radius">
                    <option :value="0">None</option>
                    <option :value="6746">5 Miles</option>
                    <option :value="13492">10 Miles</option>
                    <option :value="20238">15 Miles</option>
                </select>
            </div>
        </div> -->
        <div class="row w-100 m-0">
            <div class="col-3">
                <div class="p-3">
                    <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
                        <div class="block-content block-content-full tab-content">
                            <div class="row">
                                <div class="col-12 py-2">
                                    <span class="h3">Filters</span>
                                </div>
                                <hr/>
                                <!-- <div class="col-12 py-2 input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Radius</span>
                                    </div>
                                    <select name="" id="" class="form-control selectpicker" v-model="radius">
                                        <option :value="0">None</option>
                                        <option :value="6746">5 Miles</option>
                                        <option :value="13492">10 Miles</option>
                                        <option :value="20238">15 Miles</option>
                                    </select>
                                </div> -->
                                <div class="col-12 py-2 input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Show</span>
                                    </div>
                                    <select class="form-control text-center" name="time-range" v-model="showMarkers">
                                        <optgroup label="markers">
                                            <option value="staff">Staff</option>
                                            <option value="carehome">Carehomes</option>
                                            <option value="both">Staff & Carehomes</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="col-12 py-2 input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Roles</span>
                                    </div>
                                    <select class="form-control text-center" name="time-range" v-model="filterBy" @change="filterMap()">
                                        <optgroup label="Position">
                                            <option value="all">All</option>
                                            <option value="Healthcare Assistant">Healthcare Assistant</option>
                                            <option value="Senior Healthcare Assistant">Senior Healthcare Assistant</option>
                                            <option value="RGN">RGN</option>
                                            <option value="RMN">RMN</option>
                                            <option value="Support Worker">Support Worker</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="col-12 py-2 input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Status</span>
                                    </div>
                                    <select class="form-control text-center" name="time-range" v-model="filter" @change="filterMap()">
                                        <optgroup label="Status">
                                            <option value="accepted">Accepted</option>
                                            <option value="live">Live</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="col-12 py-2">
                                    <img src="/images/map-markers/applicant-marker-red.png" /><span class="pr-md-5 pl-2">{{filterBy}}: {{applicantCounter}}</span>
                                </div>
                                <div class="col-12 py-2">
                                    <img src="/images/map-markers/carehome-marker.png" style="margin-bottom:5px;"/><span class="pl-2">Carehomes: {{carehomeCounter}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn" v-if="clientInfoWindowOpened == true">
                        <div class="block-content block-content-full tab-content">
                            <div class="row" v-if="activeCarehome.carehome">
                                <div class="col-12 py-2">
                                    <span class="block-title">Carehome Details</span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12 py-2">
                                    <div class="mb-1 font-w600">{{activeCarehome.carehome.name}}</div>
                                    <div class="mb-1">Rating: <b>{{activeCarehome.carehome.rating}}</b></div>
                                    <div class="mb-1">Mob: <b>{{activeCarehome.carehome.main_contact_number}}</b></div>
                                    <div class="mb-1">Street: <b>{{activeCarehome.carehome.address_1}}</b></div>
                                    <div class="mb-1">City: <b>{{activeCarehome.carehome.city}}</b></div>
                                    <div class="mb-1">Postcode: <b>{{activeCarehome.carehome.postal_code}}</b></div>
                                    <div class="mb-1">No. of beds: <b>{{activeCarehome.carehome.beds}}</b></div>
                                    <div class="mb-1">Website: <b>{{activeCarehome.carehome.website}}</b></div>
                                    <div class="mt-2">
                                        <router-link class="btn btn-sm btn-secondary w-100 text-center" :to="'/carehome/list/' + activeCarehome.location_id">
                                            View
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn" v-if="infoWindowOpened == true">
                        <div class="block-content block-content-full tab-content">
                            <div class="row" v-if="activeApplicant.application">
                                <div class="col-12 py-2">
                                    <span class="block-title">Staff Details</span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12 py-2">
                                    <div class="mb-1 font-w600">{{activeApplicant.application.first_name}} {{activeApplicant.application.last_name}}</div>
                                    <div class="mb-1">Position: <b>{{activeApplicant.application.position}}</b></div>
                                    <div class="mb-1">Mob: <b>{{activeApplicant.application.mobile}}</b></div>
                                    <div class="mb-1">Street: <b>{{activeApplicant.application.address_line_1}}</b></div>
                                    <div class="mb-1">City: <b>{{activeApplicant.application.city}}</b></div>
                                    <div class="mb-1">Postcode: <b>{{activeApplicant.application.postcode}}</b></div>
                                    <div class="mt-2">
                                        <router-link class="btn btn-sm btn-secondary w-100 text-center" :to="'/recruitment/applications/' + activeApplicant.application.id">
                                            View
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-9 p-0" v-if="loaded == true">
                <gmap-map :center="mapCenter" :zoom="8" class="map" 
                    :options='{
                        disableDefaultUI: false, 
                        zoomControl: true,
                    }'
                >
                    <gmap-info-window
                        :options="infoWindowOptions"
                        :position="infoWindowPosition"
                        :opened="infoWindowOpened"
                        @closeclick="handleInfoWindowClose"
                    >
                        <div class="info-window" v-if="activeApplicant.application">
                            <p class="mb-0">
                                <b>{{ activeApplicant.application.first_name }} {{ activeApplicant.application.last_name }}</b>
                            </p>
                        </div>
                    </gmap-info-window>
                    <gmap-info-window
                        :options="infoWindowOptions"
                        :position="clientInfoWindowPosition"
                        :opened="clientInfoWindowOpened"
                        @closeclick="clientHandleInfoWindowClose"
                    >
                        <div class="info-window" v-if="activeCarehome.carehome">
                            <p class="mb-0"><b>{{ activeCarehome.carehome.name }}</b></p>
                        </div>
                    </gmap-info-window>
                        <div v-if="showMarkers == 'staff' || showMarkers == 'both'">
                            <gmap-marker
                                v-for="(m, key) in applicants" :key="key"
                                :position="getPosition(m)"
                                :clickable="true"
                                :draggable="false"
                                @click="activeApplicant = m; infoWindowOpened = true;"
                                :icon="{ url: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAADKElEQVRIS6WU229MURTGv7XPmelMdVrqNsc1EpVoSyp90TGlIRLpFPHgUSQkxCU0ov+EEKRB4/LEmwei04oQKmbq8iCEuj8Iegmp0tG5nrOXnJkO0/bMmRH7be/1rfVbl703ocDq37J2lWLIvZLkepJicVou5EdI5a4Q3DE3GHpuF4LyGT9vb3ArUaWdCLvzaSTACuN8bExtXdLTE7fSWQLM4GpMuQWgsVCFabuU9+NR5yYriCVgIOC/mJt5JJnESDyBeMpIx3OpCirdLpQ5HX/5kjq07gf7Jic0BWD2XEj5NCv8Go1hJGZZfRoyu9SdKQJgFVg1eSZTAEMBfwcT9ppOZuYDkTHTOw6iI6qSuqLqBiVEyQ42cAIKSuZ5psHjdGbyYXlW6+o9kFvFFMBAi+8dQVSZok+jEcRSOsC0v+nRy3O5jvcaqg8SqN2tOrCooixjknijdYeW2wIGm/0JCKRTejf8AwyGKvRyf/htJNfxdn19hcMZ/0EELKucMW6SCS3Y67IF9Lf4UgJCzQW4ZKJi9eMPoxMqaKqbTonUyASARFLrDpUU36KfEcR0HQQcXPew70yu4/2G2sMMPlXqULGw3JM1vdaCoWpbQO6QfyVT6I/8AgwkWOGjetJ9WfUYJBL6TgYfA+Cc7yn7e12J27XO8CFbwJdmXx0J8VTATBz4Fo3he55rOtPtwqzsNZWQQuGVWme4zxZgGgdb/JcA7MoK0w8tlkTcSKWP3KqKGa6JD42AC95gaE/Bh2YKhrb55hgp8V4A5ZMdrPYSGFUcssp7rfdrUYBMFY1tyPS58CJu0zrDx62EeX/Tvu3VzsrozD4QL7UlMH34XjpcU3P1VfKfAOlWbW7cyszX7QDEvNXbFb6RT5O3gqzDYMB3ByQ2WAVg8J15wfBG2wQKNXgo4Ks1GM+EEEquVkppKIQ6b1fvy/8CjF/bswAm/vUWP+c/zyDrMLC5aZYwku9ZiOmZMzliOPSqBdeeDBfqQMEZ/IEE1rQS0UlzT0CrNxg6XSj4uLYYGcD19Y4hzf0CEuyNqiuop0cvxrPoCjKzWNMMAmud4ZvFBDc1vwGGczso6qpQagAAAABJRU5ErkJggg=='}"
                            />
                        </div>
                    <gmap-cluster>
                        <div v-if="showMarkers == 'carehome' || showMarkers == 'both'">
                            <gmap-marker
                                v-for="(c, key) in carehomes" :key="'A' + key"
                                :position="getPosition(c)"
                                :clickable="true"
                                :draggable="false"
                                @click="activeCarehome = c; clientInfoWindowOpened = true;"
                                :icon="{ url: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAACn0lEQVRIS7WWz08TURDHZ/a1LGWpKcaDgDEkoo0oXEAMGg9y8OBFMZbGE6AGYxPKxr+gfwFQEIwhBrkYA6m9eTIYDyZIe1DwRzWNMUbLQYMgpaU/9o3pNm136Q9LKO+yyZvZ+cx8Z96+RdjnhfscH0oCml66qg+YN+wE/AoCdHCA+lRCAsAqAfgFQu9G2DL/7aJru1iiRQFtPvkGAY0gCodLVUlcWRUYk9+1j84V8ssD2OZsLHCscRIJ7+xOPj5l/RpyzvfOK9r38gCnfPJDhji4u+Bpb87pwfvOMUdRQEoWQHxSLPhCs0s1dQfTz4KSINi1cmUrSDVUqllfZQwtewEQV9aiddQQPD4RS8XJAtreyLeB4XQpacqpQJ0yxIG37SOPdYDWRacfDay9EgBKJH0rXROdOsDpJWdEEJipEgAlwSMfutySXiKfTIC5ocrIUe406RrPiZY7xwQ9wC+TpiWwJwARLJ8ZU7PNpty6OExoUKHqin3/k5f86263und+YTjPJh6ty+5RnNPKObe+gpZXjohBEivSg2Q0vvXxwmStroKWF4N+g0WqyBQl1sJLny5Nn9UBrM9u3axqrH2ELCfTTh3KOQekcEj8/NsfuDYzqwM0zfRXi/WGkHjInBNzB6EcQPLX5u84mY4EL+84yalYJzwDduNB01NmFgtOZ6bx2oZqHZXNGCjrW9cDPbOezH7e1/Skt29KsEh3i0GKnQtlcxsS65H7X3pmh7Q++RfOnI1ZjdI4M1U5mMUE2tEtFDyleXItCjyaGP+cDN+D/90HmSBWb18vJxg1SmKDUGMENBoAWTofUggoroASjQPfiv1ABFkrS+kKNNbm50Mii4VtwOkqIe8gENQ7GTiEQCA/I/QmTWZPpqGFKtz3v4p/hhcHKFoI/aEAAAAASUVORK5CYII='}"
                            />
                        </div>
                    </gmap-cluster>
                    <!-- <gmap-circle
                        v-for="(r, key) in carehomes" :key="'B' + key"
                        :center="getPosition(r)"
                        :radius="radius"
                        :visible="true"
                        :options="{fillColor:'blue ',fillOpacity:0}"
                    ></gmap-circle> -->
                </gmap-map>
            </div>
            <div class="col-9 py-3" v-else>
                <loading/>
            </div>
        </div>
    </div>
</template>
<script>
import GmapCluster from 'vue2-google-maps/dist/components/cluster';
import Loading from "../layout/tables/Loading";
export default {
    data: function () {
        return {
            routePrefix: "/api/map/",
            applicants: [],
            carehomes: [],
            infoWindowOptions: {
                pixelOffset: {
                    width: 0,
                    height: -35,
                },
            },
            activeApplicant: {},
            activeCarehome: {},
            infoWindowOpened: false,
            clientInfoWindowOpened: false,
            filter: "live",
            filterBy: "all",
            radius: 0,
            showMarkers: 'staff',
            loaded: false,
        };
    },
    components: {
        GmapCluster,
        Loading,
    },
    computed: {
        carehomeCounter() {
            return this.carehomes.length;
        },
        applicantCounter() {
            return this.applicants.length;
        },
        mapCenter() {
            if (!this.applicants.length) {
                return {
                    lat: 53.40366,
                    lng: -2.99272,
                };
            }
            return {
                lat: parseFloat(this.applicants[0].lat),
                lng: parseFloat(this.applicants[0].lng),
            };
        },
        infoWindowPosition() {
            return {
                lat: parseFloat(this.activeApplicant.lat),
                lng: parseFloat(this.activeApplicant.lng),
            };
        },
        clientInfoWindowPosition() {
            return {
                lat: parseFloat(this.activeCarehome.lat),
                lng: parseFloat(this.activeCarehome.lng),
            };
        },
    },
    watch: {
        filter: function (val) {
            this.index();
        },
    },
    mounted() {
        if (this.$route.query.filter) {
            this.filter = this.$route.query.filter;
        }
        if (this.$route.query.filterBy) {
            this.filterBy = this.$route.query.filterBy;
        }
        this.index(this.filter, this.filterBy);
        this.show();
    },
    methods: {
        index(filter, filterBy) {
        var route = this.routePrefix + "applicant?";
        if (this.filter.length > 0) {
            route += "&filter=" + this.filter;
        }
        if (this.filterBy) {
            route += "&filterBy=" + this.filterBy;
        }
        this.loaded = false;
        this.$router
            .push({
                query: {
                    filter: this.filter,
                    filterBy: this.filterBy,
                },
            })
            .catch((err) => {});
        axios
            .get(route)
            .then((response) => {
                this.applicants = response.data;
                this.loaded = true
            })
            .catch((error) => {
                console.error(error);
            });
        },
        show() {
        axios
            .get(this.routePrefix + "carehome")
            .then((response) => {
                this.carehomes = response.data;
                this.loading = true;
            })
            .catch((error) => {
                console.error(error);
            });
        },
        filterMap() {
            this.$router.push({
                query: {
                    filter: this.filter,
                    filterBy: this.filterBy,
                },
            })
            .catch(error => {});
            this.index(this.filter, this.filterBy);
        },
        getPosition(m) {
            return {
                lat: parseFloat(m.lat),
                lng: parseFloat(m.lng),
            };
        },
        getPosition(c) {
            return {
                lat: parseFloat(c.lat),
                lng: parseFloat(c.lng),
            };
        },
        handleMarkerClicked(m) {
            this.activeApplicant = m;
            this.infoWindowOpened = true;
        },
        handleInfoWindowClose() {
            this.activeApplicant = {};
            this.infoWindowOpened = false;
        },
        handleClientClicked(c) {
            this.activeCarehome = c;
            this.clientInfoWindowOpened = true;
        },
        clientHandleInfoWindowClose() {
            this.activeCarehome = {};
            this.clientInfoWindowOpened = false;
        },
    },
};
</script>
<style scoped>
.form-control.form-control-alt {
    color: #000;
    border-color: transparent;
    background-color: transparent;
    transition: none;
    font-size: 15px;
    font-weight: 600;
    border-bottom: 1px solid #000;
    border-radius: 0px !important;
}

@media screen and (max-width: 1440px){
    .map {
        width: 100%;
        height: 700px;
    }
}

@media screen and (min-width: 1441px){
    .map {
        width: 100%;
        height: 93vh;
    }
}
</style>