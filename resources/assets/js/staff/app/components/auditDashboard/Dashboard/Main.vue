<template>
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="block block-rounded">
                    <div class="block-header">
                        <h3 class="block-title">Audit Tracker</h3>
                        <div class="col-md-auto col-xs-12 my-auto" v-show="complianceManager">
                            <select class="form-control text-center" v-model="filter" @change="filterStaff(1)">
                                <option value="0" disabled>List of Clinical Staff</option>
                                <option v-for="(user, key) in clinical" :key="key" :value="user.id">
                                    {{ user.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-auto col-xs-12 float-right">
                            <button class="btn btn-light" style="background-color:transparent; border: 0px;" @click="reload(tab)">
                                <i class="si si-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content pt-2 pb-4">
                        <div class="table-responsive">
                            <table class="table table-hover table-vcenter table-striped table-bordered js-appear-enabled animated fadeIn" >
                                <thead class="thead-light" v-if="datatable.data.length">
                                    <tr>
                                        <th>Audit</th>
                                        <th class="text-center">Weight</th>
                                        <th class="text-center">Score Achieved</th>
                                        <th class="text-center">Max Score</th>
                                        <th class="text-center">Completion Date</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(audit, key) in datatable.data" :key="key">
                                        <td>
                                            <router-link :to="{ path: '/api/compliance-staff/checkout/upload/get/' + audit.filename }" target="_blank">
                                                {{ audit.audit.display_name }}
                                            </router-link>
                                        </td>
                                        <td class="text-center">{{ audit.audit.weight }}%</td>
                                        <td class="text-center" v-if="audit.score == null" >Awaiting</td>
                                        <td class="text-center" v-else>{{ audit.score }}</td>
                                        <td class="text-center">{{ audit.audit.max_score }}</td>
                                        <td class="text-center">{{ audit.created_at }}</td>
                                        <td class="text-center" v-if="audit.score >= 75" :class="{ passed: audit.score >= 75 }">PASSED</td>
                                        <td class="text-center" v-else :class="{ failed: audit.score < 75 }">FAILED</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <loading />
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
import Figures from "./components/Main";
import Pagination from "../../layout/tables/Pagination"
import Loading from "../../layout/tables/Loading"

export default {
    computed: {
        complianceManager: function () {
            return this.$store.state.user.compliance_manager == 1 ? true : false;
        },
    },
    data: function () {
        return {
            routePrefix: "/api/compliance-staff/dashboard/",
            clinical: {},
            datatable: {
                data: {},
                current_page: 1,
                per_page: 15,
                last_page: 0,
                total: 1,
            },
            filter: 0,
            tab: 0,
            time_range: "daily",
            loaded: true,
        }
    },
    components: {
        Figures,
        Pagination,
        Loading,
    },
    watch: {
        time_range: function (newVal) {
            this.reload(this.tab);
        },
        filter: function (val) {
            this.show(1);
        },
    },
    mounted() {
        this.getClinicalStaff();
        if (this.$route.query.page) {
            this.datatable.current_page = this.$route.query.page;
        }
        if (this.$route.query.filter) {
           this.filter = this.$route.query.filter;
        }
        this.show(this.datatable.current_page, this.filter);
    },
    methods: {
        reload(tab) {
            this.loaded = false;
            setTimeout(() => {
                this.loaded = true;
            }, 200);
        },
        getClinicalStaff() {
            axios
            .get(this.routePrefix + "clinical")
            .then((response) => {this.clinical = response.data})
            .catch((error) => {console.log(error), console.log(this.$state)})
        },
        show(page, filter) {
            var route = this.routePrefix + "tracker/?";
            route += "page=" + page;
            if (this.filter) {
                route += "&filter=" + this.filter;
            }
            this.loaded = false
            this.$router
            .push({
                query: {
                    page:  page,
                    filter: this.filter
                },
            })
            .catch((err) => {});
            axios.get(route)
            .then((response) => {this.datatable = response.data})
            .catch((error) => {
                this.$root.notification(error.response.data.message, "error");
            })
            .then(() => {
                this.loaded = true;
            })
        },
        filterStaff(page) {
            this.$router.push({
                query: {
                    filter: this.filter,
                    page: page,
                },
            })
            .catch((err) => {});
            this.show(page, this.filter);
        },
        changePage(current_page) {
            if (current_page <= this.datatable.last_page && current_page > 0) {
                this.datatable.current_page = current_page;
                this.show(current_page);
            }
        },
    },
}
</script>
<style lang="scss" scoped>
.passed {
    color: #82b54b;
    font-weight: 700;
}
.failed {
    color: #e04f1a;
    font-weight: 700;
}
</style>