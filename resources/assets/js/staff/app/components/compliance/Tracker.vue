<template>
    <div class="content">
        <div class="row my-3">
            <div class="col-md-3 col-12 my-auto">
                <h4 class="mb-0">Tracker</h4>
            </div>
            <div class="col-md-3 col-12 input-group">
                <div class="input-group-append">
                    <span id="basic-addon1" class="input-group-text">
                        Status
                    </span>
                </div>
                <select class="form-control selectpicker" v-model="filterDocument" @change="filterTracker(1)">
                    <option value selected disabled>Document status</option>
                    <option value="0">All</option>
                    <option v-for="(compliance, key) in compliance_names" :key="key" :value="compliance.id">{{ compliance.name }}</option>
                </select>
            </div>
            <div class="col-md-3 col-12 input-group">
                <div class="input-group-append">
                    <span id="basic-addon1" class="input-group-text">
                        Status
                    </span>
                </div>
                <select class="form-control selectpicker" v-model="filter" @change="filterTracker(1)">
                    <option value selected disabled>Expiry status</option>
                    <option value="0">All</option>
                    <option value="1">Upcoming</option>
                    <option value="2">Expired</option>
                </select>
            </div>
            <div class="col-md-3 col-12 input-group ml-auto input-group">
                <div class="input-group-append">
                    <span id="basic-addon1" class="input-group-text">
                        Status
                    </span>
                </div>
                <select class="form-control selectpicker" v-model="sort" @change="filterTracker(datatable.current_page)">
                    <option value selected disabled>Document type</option>
                    <option value="0">All</option>
                    <option value="1">Document</option>
                    <option value="2">Induction</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
                    <div class="block-content block-content-full tab-content">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive" v-if="loaded">
                                    <table class="table table-hover table-vcenter table-bordered table-striped js-appear-enabled animated fadeIn">
                                        <thead class="thead-light" v-if="datatable.data.length">
                                            <tr>
                                                <th>Applicant Name</th>
                                                <th>Document Name</th>
                                                <th>Renewal Date</th>
                                                <th class="text-center">Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white">
                                            <tr v-for="(document, key) in datatable.data" :key="key + 1">
                                                <td>{{ document.first_name }} {{ document.last_name }}</td>
                                                <td>{{ document.document_name }}</td>
                                                <td>{{ document.renewal_date }}</td>
                                                <td v-if="document.expired == 0" class="text-center text-secondary">
                                                    <i class="fas fa-minus mr-1"></i> Imminent
                                                </td>
                                                <td v-else class="btn btn-outline-danger btn-sty btn-sm mt-1">
                                                    <i class="fas fa-times mr-1"></i> Expired
                                                </td>
                                                <td class="text-center btn-td">
                                                <div class="btn-group">
                                                    <router-link class="btn btn-outline-dark btn-sm" :to="'/recruitment/applications/' + document.applicant_id + '/compliance'">
                                                    GO <i class="fas fa-arrow-right"></i>
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
<script type="text/javascript">
import Pagination from "../layout/tables/Pagination.vue";
import Loading from "../layout/tables/Loading.vue";

export default {
    data: function () {
        return {
            routePrefix: "/api/compliance/tracker/",
            filter: "0",
            filterDocument: 0,
            sort: "0",
            datatable: {
                data: {},
                current_page: 1,
                per_page: 15,
                last_page: 0,
                total: 1,
            },
            compliance_names: {},
            loaded: false,
        };
    },
    components: {
        Pagination,
        Loading,
    },
    watch: {
        filter: function (val) {
            this.index(1);
        },
    },
    mounted() {
        if (this.$route.query.page) {
            this.datatable.current_page = this.$route.query.page;
        }
        if (this.$route.query.filter) {
            this.filter = this.$route.query.filter;
        }
        if (this.$route.query.filterDocument) {
            this.filterDocument = this.$route.query.filterDocument;
        }
        if (this.$route.query.sort) {
            this.sort = this.$route.query.sort;
        }
        this.index(this.datatable.current_page, this.filter, this.filterDocument, this.sort);
        this.getCompliance();
    },
    methods: {
        index(page, filter, filterDocument, sort) {
            var route = this.routePrefix + "?";
            route += "page=" + page;
            if (this.filter) {
                route += "&filter=" + this.filter;
            }
            if (this.filterDocument) {
                route += "&filterDocument=" + this.filterDocument;
            }
            if (this.sort) {
                route += "&sort=" + this.sort;
            }
        (this.loaded = false),
            this.$router
            .push({
                query: {
                page: page,
                filter: this.filter,
                filterDocument: this.filterDocument,
                sort: this.sort,
                },
            })
            .catch((err) => {});
        axios
            .get(route)
            .then((response) => {
                this.datatable = response.data;
            })
            .then(() => {
                this.loaded = true;
            });
        },
        filterTracker(page) {
            this.$router.push({
                query: {
                    filter: this.filter,
                    filterDocument: this.filterDocument,
                    page: page,
                },
            });
            this.index(page, this.filter, this.filterDocument, this.sort);
        },
        changePage(current_page) {
            if (current_page <= this.datatable.last_page && current_page > 0) {
                this.datatable.current_page = current_page;
                this.index(current_page);
            }
        },
        getCompliance()
        {
            axios
            .get(this.routePrefix + "names")
            .then((response) => {this.compliance_names = response.data})
            .catch((error) => console.log(error))
        }
    },
};
</script>