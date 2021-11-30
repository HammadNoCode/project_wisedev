<template>
    <div class="content">
        <div class="row mb-3 mt-3">
            <div class="col-md-auto col-12 my-auto">
                <h4 class="h4 mb-2">Uploaded Competency Forms</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
                    <div class="block-content block-content-full tab-content">
                        <div class="row mb-4">
                            <div class="col-md-6 col-12 ml-auto">
                                <select class="form-control selectpicker" v-model="filter" @change="filterLogs(datatable.current_page)">
                                    <option value selected disabled>Sort By</option>
                                    <option value="newest">Newest</option>
                                    <option value="oldest">Oldest</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive" v-if="loaded">
                                    <table class="table table-hover table-bordered table-striped js-appear-enabled animated fadeIn">
                                        <thead class="thead-light" v-if="datatable.data.length">
                                            <tr>
                                                <th>Name</th>
                                                <th>Contact Info</th>
                                                <th class="text-center">Retrieval Count</th>
                                                <th class="text-center">Last Visited</th>
                                                <th class="text-center">Progress</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white">
                                            <tr v-for="(log, key) in datatable.data" :key="key + 1">
                                                <td class="text-truncate">
                                                    <div class="my-2" v-if="log.application">{{ log.application.first_name }} {{ log.application.last_name }}</div>
                                                </td>
                                                <td class="text-truncate">
                                                    <div class="my-2" v-if="log.application">Email: {{ log.application.email }}</div>
                                                    <div class="my-2" v-if="log.application">Mobile: {{ log.application.mobile }}</div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="my-2">{{ log.retrievals }}</div>
                                                </td>
                                                <td class="text-center"> 
                                                    <div class="my-2">{{ log.updated_at }}</div>
                                                </td>
                                                <td class="text-center" v-if="log.application">
                                                    <div class="my-2" v-if="log.application.skills == null && log.completed == 0">Stage 1</div>
                                                    <div class="my-2" v-else>Stage 2</div>
                                                </td>
                                                <td class="text-center btn-td">
                                                    <div class="btn-group my-2">
                                                        <router-link class="btn btn-secondary btn-sm" :to="'/recruitment/applications/' + log.applicant_id">
                                                            <i class="far fa-file-alt mr-1"></i> Application
                                                        </router-link>
                                                    </div>
                                                </td>
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
import Loading from "../layout/tables/Loading";
import Pagination from "../layout/tables/Pagination";

export default {
    data: function() {
        return {
            routePrefix: "/api/recruitment/retrievals/",
            datatable: {
                data: {},
                current_page: 1,
                per_page: 15,
                last_page: 0,
                total: 1,
            },
            filter: "newest",
            search: "",
            loaded: false,
        }
    },
    components: {
        Loading,
        Pagination,
    },
    watch: {
        filter: function(val) {
            this.show(1)
        }    
    },
    mounted() {
        if (this.$route.query.page) {
            this.datatable.current_page = this.$route.query.page;
        }
        if (this.$route.query.search) {
            this.search = this.$route.query.search;
        }
        if (this.$route.query.filter) {
            this.filter = this.$route.query.filter;
        }
        this.show(this.datatable.current_page, this.filter);
    },
    methods: {
        show(page) {
            var route = this.routePrefix + "?";
            route += "page=" + page;
            if (this.search.length > 0) {
                route += "&search=" + this.search;
            }
            if (this.filter.length > 0) {
                route += "&filter=" + this.filter;
            }
            (this.loaded = false),
            this.$router
            .push({
                query: {
                    page: page,
                    search: this.search,
                    filter: this.filter,
                },
            })
            .catch((err) => {});
            axios
            .get(route)
            .then((response) => {
                this.datatable = response.data
            })
            .then(() => {
                this.loaded = true;
            });
        },
        filterLogs(page) {
            this.$router.push({
                query: {
                    filter: this.filter,
                    page: page,
                },
            })
            .catch((error) => {
                console.log(error)
            })
            this.show(page, this.filter);
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