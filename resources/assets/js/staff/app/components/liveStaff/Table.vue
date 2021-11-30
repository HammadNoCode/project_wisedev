<template>
    <div class="content">
        <div class="row py-3">
            <div class="col-12">
                <h3 class="mb-0">Live Staff Table</h3>
            </div>
        </div>
        <div class="row py-2">
            <div class="col-12 input-group">
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="fa fa-fw fa-search"></i>
                    </span>
                </div>
                <input type="text" class="form-control" v-model="search" :placeholder="'Search names...'"/>
            </div>
        </div>
        <div class="row py-2">
            <div class="col-lg-4 col-12 my-auto input-group">
                <div class="input-group-append">
                    <div class="input-group-text">Branch</div>
                </div>
                <select class="form-control selectpicker" v-model="filter">
                    <option value selected disabled>Filter by branches</option>
                    <option value="0" selected>All</option>
                    <option
                        class="optionpicker"
                        v-for="branch in branches"
                        v-bind:key="branch.id"
                        :value="branch.id"
                    >
                        {{ branch.name }}
                    </option>
                </select>
            </div>
            <div class="col-lg-4 col-12 my-auto input-group">
                <div class="input-group-append">
                    <div class="input-group-text">Activity</div>
                </div>
                <select class="form-control selectpicker" v-model="active" @change="filterClinicalStaff(datatable.current_page)">
                    <option value selected disabled>Activity</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div class="col-lg-4 col-12 my-auto input-group">
                <div class="input-group-append">
                    <div class="input-group-text">Sort</div>
                </div>
                <select class="form-control selectpicker" v-model="sort" @change="filterClinicalStaff(datatable.current_page)">
                    <option value selected disabled>Sort by</option>
                    <option value="newest">Newest</option>
                    <option value="oldest">Oldest</option>
                </select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
                    <div class="block-content block-content-full tab-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive" v-if="loaded">
                                    <table class="table table-bordered js-appear-enabled animated fadeIn">
                                        <thead class="thead-light" v-if="datatable.data.length">
                                        <tr>
                                            <!-- <th>ID</th> -->
                                            <th>Name</th>
                                            <th>Contact Info</th>
                                            <th>Latest Covid Info</th>
                                            <th>Vaccinated</th>
                                            <th>Hired By</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(staff, key) in datatable.data" :key="key">
                                                <td class="text-truncate">
                                                    <div class="my-2">
                                                        <i class="fas fa-circle fa-xl" :class="{ active: staff.active == true, inactive: staff.active == false }"></i> {{ staff.application.first_name }} {{ staff.application.last_name }} 
                                                    </div>
                                                </td>
                                                <td class="text-truncate">
                                                    <div class="my-2" v-if="staff.application.email">{{ staff.application.email }}</div>
                                                    <div class="my-2" v-if="staff.application.mobile">{{ staff.application.mobile }}</div>
                                                </td>
                                                <td class="text-truncate" v-if="staff.latest_test">
                                                    <div>
                                                        <div class="my-2" v-if="staff.latest_test.covid_result == 0"><span class="text-success">Negative</span></div>
                                                        <div class="my-2" v-else><span class="text-danger">Positive</span></div>
                                                        <div class="my-2" v-if="staff.latest_test.test_date">{{ formatDate(staff.latest_test.test_date) }}</div>
                                                        <div class="my-2" v-if="staff.latest_test.test_type != 'Other'">{{ staff.latest_test.test_type }}</div>
                                                        <div class="my-2" v-else>{{ staff.latest_test.type_of_other_test }}</div>
                                                    </div>
                                                </td>
                                                <td class="text-truncate" v-else>
                                                    <div class="my-2">No test submitted</div>
                                                </td>
                                                <td class="text-truncate">
                                                    <div class="my-2 text-success" v-if="staff.vaccination">Vaccinated</div>
                                                    <div class="my-2" v-if="staff.vaccination">{{ formatDate(staff.vaccination.vaccination_date) }}</div>
                                                    <div class="my-2 text-danger" v-else>Not Vaccinated</div>
                                                </td>
                                                <td class="text-truncate">
                                                    <div class="my-2" v-if="staff.hired_by == 0">No Data</div>
                                                    <div class="my-2" v-else>{{ staff.staff_name }}</div>
                                                </td>
                                                <td class="text-truncate">
                                                    <div class="my-2">
                                                        <b-form-checkbox v-model="staff.active" @change="updateActivity(staff)" switch>Active</b-form-checkbox>
                                                    </div>
                                                </td>
                                                <td class="text-center btn-td">
                                                    <div class="btn-group my-2">
                                                        <router-link class="btn btn-secondary btn-sm" :to="'/recruitment/applications/' + staff.application.id">
                                                            <i class="fas fa-eye"></i>
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
import moment from 'moment';
import Pagination from "../layout/tables/Pagination.vue";
import Loading from "../layout/tables/Loading.vue";

export default {
    data: function () {
        return {
            routePrefix: "/api/clinical/",
            search: "",
            filter: 0,
            active: 1,
            sort: "newest",
            datatable: {
                data: {},
                current_page: 1,
                per_page: 15,
                last_page: 0,
                total: 1,
            },
            show: 1,
            branches: {},
            loaded: false,
            disabled: false,
			today: moment(),
        };
    },
    components: {
        Loading,
        Pagination,
    },
    computed: {
        testResult: function() {
            var result = this.datatable.data[0].latest_test.covid_result;
            return result;
        }
    },
    watch: {
        filter: function (val) {
            this.index(1);
        },
        model: function (newVal) {
            this.loaded = false;
            setTimeout(() => {
                this.loaded = true;
            }, 200);
        },
        search: function (val) {
        var search_check = this.search;
            setTimeout(() => {
                if (search_check == this.search) {
                    this.index(1);
                }
            }, 500);
        },
    },
    mounted() {
        this.index();
        this.getBranches();
    },
    methods: {
        index() {
            var route = this.routePrefix + "?";
            route += "page=" + this.datatable.current_page;
            if (this.search.length > 0) {
                route += "&search=" + this.search;
            }
            if (this.filter) {
                route += "&filter=" + this.filter;
            }
            if (this.active) {
                route += "&active=" + this.active;
            }
            if (this.sort.length > 0) {
                route += "&sort=" + this.sort;
            }
            this.loaded = false;
            this.$router.push({
                query: {
                    page: this.datatable.data,
                    search: this.search,
                    filter: this.filter,
                    active: this.active,
                    sort: this.sort,
                },
            })
            .catch((err) => {});
            axios.get(route)
            .then((response) => {
                this.datatable = response.data;
            })
            .then(() => {
                this.loaded = true;
            });
        },
        filterClinicalStaff(page) {
            this.$router.push({
                query: {
                    filter: this.filter,
                    active: this.active,
                    page: this.datatable.current_page,
                },
            });
            this.index(page, this.filter, this.sort);
        },
        changePage(current_page) {
            if (current_page <= this.datatable.last_page && current_page > 0) {
                this.datatable.current_page = current_page;
                this.index(current_page);
            }
        },
        getBranches() {
            axios.get("/api/branches")
            .then((response) => {
                this.branches = response.data;
            });
        },
        updateActivity(staff) {
            axios.patch(this.routePrefix + staff.id, staff)
            .then(response => {
                this.$root.notification(response.data.message, "success");
                this.index();
            })
            .catch(error => {
                this.$root.notification(error.response.data.message, "error");
            })
        },
        reload(tab) {
            this.loaded = false;
            setTimeout(() => {
                this.loaded = true;
            }, 200);
        },
        formatDate(date) {
			return moment(date).format('DD/MM/YYYY');
        },
    },
};
</script>
<style scoped>
.active {
    color: green;
}
.inactive {
    color: red;
}
</style>
