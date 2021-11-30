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
                            <div class="col-md-6 col-12 input-group" style="margin-left: auto">
                                <input type="text" class="form-control" v-model="search" :placeholder="'Search...'" />
                                <div class="input-group-append">
                                    <span id="basic-addon1" class="input-group-text" style="background-color:#ffffff;">
                                    <i class="fa fa-fw fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive" v-if="loaded">
                                    <table class="table table-hover table-vcenter table-bordered table-striped js-appear-enabled animated fadeIn">
                                        <thead class="thead-light" v-if="datatable.data.length">
                                            <tr>
                                                <th class="d-table-cell d-lg-none">Competency Form</th>
                                                <th class="d-none d-lg-table-cell">Nurse Name</th>
                                                <th class="d-none d-lg-table-cell">Staff Name</th>
                                                <th class="d-none d-lg-table-cell">Competency Form</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white">
                                            <tr v-for="(form, key) in datatable.data" :key="key">
                                                <td class="d-table-cell d-lg-none">
                                                    <div class="my-2">
                                                        {{ form.nurse_name }}
                                                    </div>
                                                    <div class="my-2">
                                                        {{ form.staff_name }}
                                                    </div>
                                                    <div class="my-2">
                                                        <div class="row">
                                                            <div class="col-auto px-1">
                                                                <router-link :to="{ path: routePrefix + 'pdf/' + form.staff_name + '/' + form.filename }" target="_blank">
                                                                    {{ form.displayname }}
                                                                </router-link>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="d-none d-lg-table-cell">{{ form.nurse_name }}</td>
                                                <td class="d-none d-lg-table-cell">{{ form.staff_name }}</td>
                                                <td class="d-none d-lg-table-cell">
                                                    <router-link :to="{ path: routePrefix + 'pdf/' + form.staff_name + '/' + form.filename }" target="_blank">
                                                        {{ form.displayname }}
                                                    </router-link>
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
import Pagination from "../../layout/tables/Pagination";
import Loading from "../../layout/tables/Loading";

export default {
    data () {
        return {
            routePrefix: "/api/complex-care/",
            search: "",
            datatable: {
                data: {},
                current_page: 1,
                per_page: 15,
                last_page: 0,
                total: 1,
            },
            loaded: true,
        }
    },
    components: {
        Pagination,
        Loading,
    },
    watch: {
        search: function(val) {
            var search_check = this.search;
            setTimeout(() => {
                if (search_check == this.search) {
                    this.showRecords(1);
                }
            }, 500);
        },
    },
    mounted() {
        if (this.$route.query.page) {
            this.datatable.current_page = this.$route.query.page;
        }
        if (this.$route.query.search) {
            this.search = this.$route.query.search
        }
        this.showRecords(this.datatable.current_page);
    },
    methods: {
        showRecords(page) {
            var route = this.routePrefix + 'read/?';
            route += "page=" + page;
            if (this.search.length > 0) {
                route += "&search=" + this.search;
            }
            (this.loaded = false),
            this.$router
            .push({
                query: {
                    page: page,
                    search: this.search,
                },
            })
            .catch((err) => {
                console.log(error)
            });
            axios.get(route)
            .then((response) => {
                this.datatable = response.data;
            })
            .then(() => {
                this.loaded = true;
            });
        },
        changePage(current_page) {
            if (current_page <= this.datatable.last_page && current_page > 0) {
                this.datatable.current_page = current_page;
                this.showRecords(current_page);
            }
        },
    }
}
</script>