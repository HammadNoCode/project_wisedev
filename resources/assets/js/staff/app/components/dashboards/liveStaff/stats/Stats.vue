<template>
    <div>
        <div class="row pt-3" v-if="loaded">
            <div class="col-12 col-lg-4 js-appear-enabled animated fadeIn">
                <a id="daily-count" class="block block-link-pop text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="my-3">
                            <div class="display-4 font-w700 text-black">
                                {{ count.ha.current }}
                            </div>
                            <div class="mt-2 text-uppercase text-muted">
                                Healthcare Assistant
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-4 js-appear-enabled animated fadeIn">
                <a id="daily-count" class="block block-link-pop text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="my-3">
                            <div class="display-4 font-w700 text-black">
                                {{ count.sha.current }}
                            </div>
                            <div class="mt-2 text-uppercase text-muted">
                                Senior HA
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-4 js-appear-enabled animated fadeIn">
                <a id="daily-count" class="block block-link-pop text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="my-3">
                            <div class="display-4 font-w700 text-black">
                                {{ count.rgn.current }}
                            </div>
                            <div class="mt-2 text-uppercase text-muted">RGN</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-4 js-appear-enabled animated fadeIn">
                <a id="daily-count" class="block block-link-pop text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="my-3">
                            <div class="display-4 font-w700 text-black">
                                {{ count.rmn.current }}
                            </div>
                            <div class="mt-2 text-uppercase text-muted">RMN</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-4 js-appear-enabled animated fadeIn">
                <a id="daily-count" class="block block-link-pop text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="my-3">
                            <div class="display-4 font-w700 text-black">
                                {{ count.sw.current }}
                            </div>
                            <div class="mt-2 text-uppercase text-muted">
                                Support Worker
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-4 js-appear-enabled animated fadeIn">
                <a id="daily-completionRate" class="block block-link-pop text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="my-3">
                            <div class="display-4 font-w700 text-black">
                                <div :class="count.hire_rate.current > 0 ? 'text-success' : 'text-danger'">
                                    {{ count.hire_rate.current }}
                                    <span v-if="count.hire_rate.current !== null">%</span>
                                    <span v-if="count.hire_rate.current === null" style="visibility: hidden">%</span>
                                </div>
                            </div>
                            <div class="mt-2 text-uppercase text-muted">
                                Hire Rate
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
     </div>
</template>
<script>
export default {
    data: () => ({
        routePrefix: "/api/dashboard/live-staff/",
        branches: {},
        model: "clinical",
        loaded: true,
        count: {
        ha: {
            current: null,
            last: null,
        },
        sha: {
            current: null,
            last: null,
        },
        rgn: {
            current: null,
            last: null,
        },
        rmn: {
            current: null,
            last: null,
        },
        sw: {
            current: null,
            last: null,
        },
        hire_rate: {
            current: null,
            last: null,
            difference: null,
        },
        },
    }),
    computed: {
        branch: function() {
            return this.$parent.branch;
        }
    },
    mounted() {
        this.init_dash();
    },
    methods: {
        init_dash() {
            this.getHA();
            this.getSHA();
            this.getRGN();
            this.getRMN();
            this.getSW();
            this.getHireRate();
        },
        getHA() {
        axios
            .get(this.routePrefix + this.model + "/" + this.branch + "/simple/ha")
            .then((response) => {
                this.count.ha.current = response.data.current;
                this.count.ha.last = response.data.last;
            });
        },
        getSHA() {
        axios
            .get(this.routePrefix + this.model + "/" + this.branch + "/simple/sha")
            .then((response) => {
                this.count.sha.current = response.data.current;
                this.count.sha.last = response.data.last;
            });
        },
        getRGN() {
        axios
            .get(this.routePrefix + this.model + "/" + this.branch + "/simple/rgn")
            .then((response) => {
                this.count.rgn.current = response.data.current;
                this.count.rgn.last = response.data.last;
            });
        },
        getRMN() {
        axios
            .get(this.routePrefix + this.model + "/" + this.branch + "/simple/rmn")
            .then((response) => {
                this.count.rmn.current = response.data.current;
                this.count.rmn.last = response.data.last;
            });
        },
        getSW() {
        axios
            .get(this.routePrefix + this.model + "/" + this.branch + "/simple/sw")
            .then((response) => {
                this.count.sw.current = response.data.current;
                this.count.sw.last = response.data.last;
            });
        },
        getHireRate() {
        axios
            .get(this.routePrefix + this.model + "/" + this.branch + "/simple/hire_rate")
            .then((response) => {
                this.count.hire_rate.current = response.data.current;
            });
        },
    },
};
</script>

<style scoped>
.font400 {
  font-weight: 400;
}

.bg-black-75 {
  background-color: hsl(219, 75%, 33%, 95%) !important;
}

.content-full {
  width: 100%;
  margin: 0 auto;
  padding: 1rem 3rem 1px;
  overflow-x: visible;
}

@media (min-width: 1200px) {
  #page-container.main-content-narrow > #page-header .content-header,
  #page-container.main-content-narrow > #page-header .content,
  #page-container.main-content-narrow > #main-container .content,
  #page-container.main-content-narrow > #page-footer .content {
    max-width: 100%;
  }
}

.bg-image {
  background-image: url("/media/photos/photo18@2x.jpg");
  background-repeat: no-repeat;
}

.btn {
  transition: none;
}

.btn-light:not(:disabled):not(.disabled):active,
.btn-light:not(:disabled):not(.disabled).active,
.show > .btn-light.dropdown-toggle {
  color: #ffffff;
  /* background-color: #0f2f6a; */
  background-color: transparent;
  border-color: transparent;
  border-bottom: 3px solid #e1b65a !important;
  border-radius: 0px !important;
  border-top: 0px !important;
  border-left: 0px !important;
  border-right: 0px !important;
  font-size: 20px;
  font-weight: 700;
}

.btn-light:not(:disabled):not(.disabled):active:focus,
.btn-light:not(:disabled):not(.disabled).active:focus,
.show > .btn-light.dropdown-toggle:focus {
  box-shadow: none !important;
}

.btn-light {
  color: #ffffff;
  background-color: transparent;
  border-color: transparent;
}

.bg-paleblue {
  background-color: #6392e9;
}
</style>