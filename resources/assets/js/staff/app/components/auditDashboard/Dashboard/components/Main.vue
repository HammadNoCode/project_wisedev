<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-4 js-appear-enabled animated fadeIn">
                        <a
                            id="all"
                            class="block block-link-pop text-center"
                            href="javascript:void(0)"
                        >
                        <b-popover
                            target="all"
                            custom-class="text-center"
                            triggers="hover"
                            placement="bottom"
                            :class="{ 'block-mode-loading': !loaded }"
                        >
                        </b-popover>
                        <div class="block-content block-content-full">
                            <div>
                                <div class="display-4 font-w700 text-black" v-if="loaded">
                                    1
                                </div>
                                <i class="fa fa-lg fa-circle-notch fa-spin" v-else></i>
                                <div class="mt-2 text-uppercase text-muted">Audit Forms</div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-md-4 js-appear-enabled animated fadeIn">
                        <a
                            id="all"
                            class="block block-link-pop text-center"
                            href="javascript:void(0)"
                        >
                        <b-popover
                            target="all"
                            custom-class="text-center"
                            triggers="hover"
                            placement="bottom"
                            :class="{ 'block-mode-loading': !loaded }"
                        >
                        </b-popover>
                        <div class="block-content block-content-full">
                            <div>
                                <div class="display-4 font-w700 text-black" v-if="loaded">
                                    2
                                </div>
                                <i class="fa fa-lg fa-circle-notch fa-spin" v-else></i>
                                <div class="mt-2 text-uppercase text-muted">Audit Forms</div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-md-4 js-appear-enabled animated fadeIn">
                        <a
                            id="all"
                            class="block block-link-pop text-center"
                            href="javascript:void(0)"
                        >
                        <b-popover
                            target="all"
                            custom-class="text-center"
                            triggers="hover"
                            placement="bottom"
                            :class="{ 'block-mode-loading': !loaded }"
                        >
                        </b-popover>
                        <div class="block-content block-content-full">
                            <div>
                                <div class="display-4 font-w700 text-black" v-if="loaded">
                                    3
                                </div>
                                <i class="fa fa-lg fa-circle-notch fa-spin" v-else></i>
                                <div class="mt-2 text-uppercase text-muted">Audit Forms</div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <!-- <div class="col-md-4 js-appear-enabled animated fadeIn">
                        <a
                            id="completed"
                            class="block block-link-pop text-center"
                            href="javascript:void(0)"
                        >
                        <b-popover
                            target="completed"
                            custom-class="text-center"
                            triggers="hover"
                            placement="bottom"
                            :class="{ 'block-mode-loading': !loaded }"
                        >
                            {{ last_pretty }}: {{ audit.completed.last }}
                        </b-popover>
                        <div class="block-content block-content-full">
                            <div>
                                <div class="display-4 font-w700 text-black">
                                    {{ audit.completed.current }}
                                </div>
                            <div class="mt-2 text-uppercase text-muted">Completed Audit</div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-md-4 js-appear-enabled animated fadeIn">
                        <a
                            id="completion_rate"
                            class="block block-link-pop text-center"
                            href="javascript:void(0)"
                        >
                        <b-popover
                            target="completion_rate"
                            custom-class="text-center"
                            triggers="hover"
                            placement="bottom"
                            :class="{ 'block-mode-loading': !loaded }"
                        >
                        </b-popover>
                        <div class="block-content block-content-full">
                            <div>
                                <div class="display-4 font-w700 text-black">
                                    {{ currentCompletionRate }} %
                                </div>
                            <div class="mt-2 text-uppercase text-muted">Completion Rate</div>
                            </div>
                        </div>
                        </a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    computed: {
        time_range: function () {
            return this.$parent.time_range;
        },
        filter: function () {
            return this.$parent.filter;
        },
        loaded: function () {
			return this.$parent.loaded;
        },
        this_pretty: function () {
            switch (this.time_range) {
                case "daily":
                    return "TODAY";
                case "weekly":
                    return "THIS WEEK";
                case "monthly":
                    return "THIS MONTH";
                default:
                    return this.$parent.time_range;
            }
        },
        last_pretty: function () {
            switch (this.time_range) {
                case "daily":
                    return "YESTERDAY";
                case "weekly":
                    return "LAST WEEK";
                case "monthly":
                    return "LAST MONTH";
                default:
                    return this.$parent.time_range;
            }
        },
        currentCompletionRate: function() {
            var percentage =  (this.audit.completed.current / this.audit.all) * 100;
            return percentage.toFixed(2);
        },
    },
    data: function () {
        return {
            routePrefix: "/api/compliance-staff/dashboard/",
            audit: {
                all: {},
                completed: {
                    current: null,
                    last: null,
                },
            },
        }
    },
    mounted() {
        this.init();
    },
    methods: {
        init() {
            this.show_all();
            this.show_completed();
        },
        show_all() {
            axios
            .get(this.routePrefix + "all")
            .then((response) => {this.audit.all = response.data})
            .catch(() => {})
        },
        show_completed() {
            axios
            .get(this.routePrefix + this.time_range + "/" + this.filter + "/completed")
            .then((response) => {
                this.audit.completed.current = response.data.current
                this.audit.completed.last = response.data.last
            })
            .catch(() => {})
        },

    }
}
</script>