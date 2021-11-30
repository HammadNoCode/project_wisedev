<template>
    <div class="content">
        <div class="row p-lg-5">
            <div class="col-12">
                <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
                    <div class="block-content block-content-full tab-content">
                        <div class="row mb-4">
                            <div class="col-12 my-auto">
                                <span class="h5" v-if="datatable.data[0]">{{ audit }} / Viewers</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive" v-if="loaded">
                                    <table class="table table-hover table-vcenter table-striped table-bordered js-appear-enabled animated fadeIn" >
                                        <thead class="thead-light" v-if="datatable.data.length">
                                            <tr>
                                                <th>Viewer Name</th>
                                                <th>Last Read</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(viewer, key) in datatable.data" :key="key">
                                                <td>{{ viewer.viewer_id }}</td>
                                                <td>{{ viewer.updated_at }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    <loading />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full block-content-sm bg-body-light">
                        <div>
                            <pagination />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Pagination from "../../../layout/tables/Pagination.vue";
import Loading from "../../../layout/tables/Loading.vue";

export default {
    computed: {
        viewersCount: function () {
            return _.size(this.datatable.data);
        },
        audit: function () {
            return this.datatable.data[0].completed_audit_id;
        },
    },
    data: function () {
        return {
            routePrefix: "/api/compliance-staff/checkout/viewers/",
            datatable: {
                data: {},
                current_page: 1,
                per_page: 10,
                last_page: 0,
                total: 1,
            },
            loaded: false,
        }
    },
    components: {
        Pagination,
        Loading,
    },
    mounted() {
        if (this.$route.query.page) {
            this.datatable.current_page = this.$route.query.page;
        }
        this.show(this.datatable.current_page)
    },
    methods: {
        show(page) {
            var route = this.routePrefix + "file/" + this.$route.params.file + "?"
            route += "&page=" + page;
            this.loaded = false;
            this.$router.push({
                query: {
                    page: page,
                }
            })
            .catch((error) => {})
        axios
            .get(route)
            .then((response) => {this.datatable = response.data})
            .then(() => {this.loaded = true})
        },
        changePage(current_page) {
            if (current_page <= this.datatable.last_page && current_page > 0) {
                this.datatable.current_page = current_page;
                this.show(current_page);
            }
        },
    }
}
</script>