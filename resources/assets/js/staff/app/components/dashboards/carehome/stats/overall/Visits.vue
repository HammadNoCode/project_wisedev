<template>
    <div>
        <div class="pb-3">
            <div class="row">
                <div class="col-12">
                    <h4 class="mb-0">Visits Tracker</h4>
                </div>
            </div>
        </div>
        <div>
            <div class="row gutters-tiny push js-appear-enabled animated fadeIn" data-toggle="appear">
                <div class="col-12 col-md-6 col-lg-3">
                    <a class="block block-rounded text-center">
                    <div class="block-content block-content-full p-1 bg-primary"></div>
                        <div class="block-content block-content-full d-flex justify-content-center align-items-center">
                            <div class="my-3">
                                <h2 class="text-black" style="font-size:30px;" v-if="visits.data">{{visits.data[0]}}</h2>
                                <div class="font-w600 mt-3 text-uppercase text-black">Lancashire</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a class="block block-rounded text-center">
                    <div class="block-content block-content-full p-1 bg-danger"></div>
                        <div class="block-content block-content-full d-flex justify-content-center align-items-center">
                            <div class="my-3">
                                <h2 class="text-black" style="font-size:30px;" v-if="visits.data">{{visits.data[1]}}</h2>
                                <div class="font-w600 mt-3 text-uppercase text-black">Warrington</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a class="block block-rounded text-center">
                    <div class="block-content block-content-full p-1 bg-success"></div>
                        <div class="block-content block-content-full d-flex justify-content-center align-items-center">
                            <div class="my-3">
                                <h2 class="text-black" style="font-size:30px;" v-if="visits.data">{{visits.data[2]}}</h2>
                                <div class="font-w600 mt-3 text-uppercase text-black">Crewe</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a class="block block-rounded text-center">
                    <div class="block-content block-content-full p-1 bg-info"></div>
                        <div class="block-content block-content-full d-flex justify-content-center align-items-center">
                            <div class="my-3">
                                <h2 class="text-black" style="font-size:30px;" v-if="visits.data">{{visits.data[3]}}</h2>
                                <div class="font-w600 mt-3 text-uppercase text-black">Liverpool</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a class="block block-rounded text-center">
                        <div class="block-content block-content-full p-1 bg-info"></div>
                        <div class="block-content block-content-full d-flex justify-content-center align-items-center">
                            <div class="my-3">
                                <h2 class="text-black" style="font-size:30px;" v-if="visits.data">{{visits.data[3]}}</h2>
                                <div class="font-w600 mt-3 text-uppercase text-black">Manchester</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a class="block block-rounded text-center">
                        <div class="block-content block-content-full p-1 bg-info"></div>
                        <div class="block-content block-content-full d-flex justify-content-center align-items-center">
                            <div class="my-3">
                                <h2 class="text-black" style="font-size:30px;" v-if="visits.data">{{visits.data[3]}}</h2>
                                <div class="font-w600 mt-3 text-uppercase text-black">Leeds</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a class="block block-rounded text-center">
                        <div class="block-content block-content-full p-1 bg-info"></div>
                        <div class="block-content block-content-full d-flex justify-content-center align-items-center">
                            <div class="my-3">
                                <h2 class="text-black" style="font-size:30px;" v-if="visits.data">{{visits.data[3]}}</h2>
                                <div class="font-w600 mt-3 text-uppercase text-black">Shrewsbury</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a class="block block-rounded text-center">
                        <div class="block-content block-content-full p-1 bg-info"></div>
                        <div class="block-content block-content-full d-flex justify-content-center align-items-center">
                            <div class="my-3">
                                <h2 class="text-black" style="font-size:30px;" v-if="visits.data">{{visits.data[3]}}</h2>
                                <div class="font-w600 mt-3 text-uppercase text-black">Chester</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a class="block block-rounded text-center">
                        <div class="block-content block-content-full p-1 bg-info"></div>
                        <div class="block-content block-content-full d-flex justify-content-center align-items-center">
                            <div class="my-3">
                                <h2 class="text-black" style="font-size:30px;" v-if="visits.data">{{visits.data[3]}}</h2>
                                <div class="font-w600 mt-3 text-uppercase text-black">Permanent</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a class="block block-rounded text-center">
                        <div class="block-content block-content-full p-1 bg-info"></div>
                        <div class="block-content block-content-full d-flex justify-content-center align-items-center">
                            <div class="my-3">
                                <h2 class="text-black" style="font-size:30px;" v-if="visits.data">{{visits.data[3]}}</h2>
                                <div class="font-w600 mt-3 text-uppercase text-black">Complex Care</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a class="block block-rounded text-center">
                        <div class="block-content block-content-full p-1 bg-info"></div>
                        <div class="block-content block-content-full d-flex justify-content-center align-items-center">
                            <div class="my-3">
                                <h2 class="text-black" style="font-size:30px;" v-if="visits.data">{{visits.data[3]}}</h2>
                                <div class="font-w600 mt-3 text-uppercase text-black">Head Office</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            routePrefix: "/api/carehome/dashboard/stats/",
            visits: {},
            timer: '',
        }
    },
    computed: {
        branch: function() {
            return this.$parent.branch;
        },
        time_range: function() {
            return this.$parent.time_range;
        }
    },
    created() {
        setInterval(this.showVisits, 60000)
    },
    mounted() {
        this.showVisits()
    },
    methods: {
        showVisits() {
            axios.get(this.routePrefix + "visits?branch=" + this.branch + "&period=" + this.time_range)
            .then(response => {
                this.visits = response.data;
            })
            .catch(error => {})
        }
    }
}
</script>
