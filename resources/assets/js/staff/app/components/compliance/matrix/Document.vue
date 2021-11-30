<template>
    <div>
        <div class="row my-3">
            <div class="col-12">
                <h4 class="mb-0">Compliance Matrix</h4>
            </div>
        </div>
        <div class="row py-2">
            <div class="col-12 input-group">
                <div class="input-group-append">
                    <span id="basic-addon1" class="input-group-text">
                        <i class="fa fa-fw fa-search"></i>
                    </span>
                </div>
                <input type="text" class="form-control" v-model="search" :placeholder="'Applicant or Staff name...'" />
            </div>
        </div>
        <div class="row py-2">
            <div class="col-lg-4 col-md-6 col-12 input-group">
                <div class="input-group-append">
                    <span id="basic-addon1" class="input-group-text">
                        Status
                    </span>
                </div>
                <select name="status" class="form-control selectpicker" v-model="filter" @change="filterMatrix(1)">
                    <option selected disabled>Status filter</option>
                    <option value="all">All</option>
                    <option value="pending">Pending</option>
                    <option value="accepted">Accepted</option>
                    <option value="live">Live</option>
                </select>
            </div>
            <div class="col-lg-4 col-md-6 col-12 input-group">
                <div class="input-group-append">
                    <span id="basic-addon1" class="input-group-text">
                        Branch
                    </span>
                </div>
                <select name="status" class="form-control selectpicker" v-model="sort" @change="filterMatrix(datatable.current_page)">
                    <option selected disabled>Select branch</option>
                    <option value="all">All</option>
                    <option class="optionpicker" v-for="branch in branches" :key="branch.id" :value="branch.id">
                        {{ branch.name }}
                    </option>
                </select>
            </div>
            <div class="col-lg-4 col-md-6 col-12 input-group">
                <div class="input-group-append">
                    <span id="basic-addon1" class="input-group-text">
                        Positions
                    </span>
                </div>
                <select name="status" class="form-control selectpicker" v-model="position" @change="filterMatrix(1)">
                    <option value selected disabled>Posiitons</option>
                    <option value="all">All</option>
                    <option value="RGN">RGN</option>
                    <option value="RMN">RMN</option>
                    <option value="Healthcare Assistant">Healthcare Assistant</option>
                    <option value="Senior Healthcare Assistant">Senior Healthcare Assistant</option>
                    <option value="Support Worker">Support Worker</option>
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
                    <div class="block-content block-content-full tab-content">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive" v-if="loaded">
                                    <table class="table table-hover table-vcenter table-bordered table-striped js-appear-enabled animated fadeIn">
                                        <thead class="thead-light" v-if="datatable.data.length">
                                            <tr>
                                                <th style="width:205px">Names</th>
                                                <th class="text-center" v-if="documents[0]">{{ documents[0].name }}</th>
                                                <th class="text-center" v-if="documents[1]">{{ documents[1].name }}</th>
                                                <th class="text-center" v-if="documents[2]">{{ documents[2].name }}</th>
                                                <th class="text-center" v-if="documents[3]">{{ documents[3].name }}</th>
                                                <th class="text-center" v-if="documents[5]">Right-to-Work</th>
                                                <th class="text-center" v-if="documents[4]">{{ documents[4].name }}</th>
                                                <th class="text-center" v-if="documents[27]">{{ documents[27].name }}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white">
                                            <tr v-for="(applicant, key) in datatable.data" :key="key">
                                                <td>{{ applicant.first_name }} {{ applicant.last_name }}</td>
                                                <td class="text-center">
                                                    <div v-if="applicant.completed_two_reference_count == '0'"><i class="fas fa-times fa-lg text-danger"></i></div>
                                                    <div v-if="applicant.completed_two_reference_count == '1'"><i class="fas fa-check fa-lg text-success"></i></div>
                                                </td>
                                                <td class="text-center">
                                                    <div v-if="applicant.completed_induction_attendance_count == '0'"><i class="fas fa-times fa-lg text-danger"></i></div>
                                                    <div v-if="applicant.completed_induction_attendance_count == '1'"><i class="fas fa-check fa-lg text-success"></i></div>
                                                </td>
                                                <td class="text-center">
                                                    <div v-if="applicant.completed_mandatory_training_count == '0'"><i class="fas fa-times fa-lg text-danger"></i></div>
                                                    <div v-if="applicant.completed_mandatory_training_count == '1'"><i class="fas fa-check fa-lg text-success"></i></div>
                                                </td>
                                                <td class="text-center">
                                                    <div v-if="applicant.completed_dbs_check_count == '0'"><i class="fas fa-times fa-lg text-danger"></i></div>
                                                    <div v-if="applicant.completed_dbs_check_count == '1'"><i class="fas fa-check fa-lg text-success"></i></div>
                                                </td>
                                                <td class="text-center">
                                                    <div v-if="applicant.completed_right_to_work_count == '0'"><i class="fas fa-times fa-lg text-danger"></i></div>
                                                    <div v-if="applicant.completed_right_to_work_count == '1'"><i class="fas fa-check fa-lg text-success"></i></div>
                                                </td>
                                                <td class="text-center">
                                                    <div v-show="applicant.completed_nurse_pin_count == '0' && applicant.position === ha"><i class="fas fa-ban fa-lg text-dark"></i></div>
                                                    <div v-show="applicant.completed_nurse_pin_count == '1' && applicant.position === ha"><i class="fas fa-ban fa-lg text-dark"></i></div>
                                                    <div v-show="applicant.completed_nurse_pin_count == '0' && applicant.position === sha"><i class="fas fa-ban fa-lg text-dark"></i></div>
                                                    <div v-show="applicant.completed_nurse_pin_count == '1' && applicant.position === sha"><i class="fas fa-ban fa-lg text-dark"></i></div>
                                                    <div v-show="applicant.completed_nurse_pin_count == '0' && applicant.position === sw"><i class="fas fa-ban fa-lg text-dark"></i></div>
                                                    <div v-show="applicant.completed_nurse_pin_count == '1' && applicant.position === sw"><i class="fas fa-ban fa-lg text-dark"></i></div>
                                                    <div v-show="applicant.completed_nurse_pin_count == '0' && applicant.position === 'RGN'"><i class="fas fa-times fa-lg text-danger"></i></div>
                                                    <div v-show="applicant.completed_nurse_pin_count == '1' && applicant.position === 'RGN'"><i class="fas fa-check fa-lg text-success"></i></div>
                                                    <div v-show="applicant.completed_nurse_pin_count == '0' && applicant.position === 'RMN'"><i class="fas fa-times fa-lg text-danger"></i></div>
                                                    <div v-show="applicant.completed_nurse_pin_count == '1' && applicant.position === 'RMN'"><i class="fas fa-check fa-lg text-success"></i></div>
                                                </td>
                                                <td class="text-center">
                                                    <div v-if="applicant.completed_proof_of_address_count == '0'"><i class="fas fa-times fa-lg text-danger"></i></div>
                                                    <div v-if="applicant.completed_proof_of_address_count == '1'"><i class="fas fa-check fa-lg text-success"></i></div>
                                                </td>
                                                <td class="text-center btn-td">
                                                    <div class="btn-group">
                                                        <router-link class="btn btn-outline-dark btn-sm" :to="'/recruitment/applications/' + applicant.id + '/compliance'">
                                                            GO
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
import Pagination from "../../layout/tables/Pagination.vue";
import Loading from "../../layout/tables/Loading";

export default {
    data: function () {
        return {
            routePrefix: "/api/compliance/matrix/document/",
            search: "",
            filter: "all",
            sort: "all",
            position: "all",
            datatable: {
                data: {},
                current_page: 1,
                per_page: 15,
                last_page: 0,
                total: 1,
            },
            ha: "Healthcare Assistant",
            sha: "Senior Healthcare Assistant",
            sw: "Support Worker",
            documents: {},
            branches: {},
            loaded: false,
        };
    },
    components: {
        Pagination,
        Loading,
    },
    watch: {
        filter: function(val) {
          this.index(1);
        },
        search: function(val) {
            var search_check = this.search;
            setTimeout(() => {
                if (search_check == this.search) {
                    this.index(1);
                }
            }, 500);
        },
    },
    mounted() {
        if (this.$route.query.page) {
            this.datatable.current_page = this.$route.query.page;
        }
        if (this.$route.query.filter) {
            this.filter = this.$route.query.filter;
        }
        if (this.$route.query.sort) {
            this.sort = this.$route.query.sort;
        }
        if (this.$route.query.position) {
            this.position = this.$route.query.position;
        }
        if (this.$route.query.search) {
            this.search = this.$route.query.search;
        }
        this.index(this.datatable.current_page, this.filter, this.sort, this.position);
        this.getDocuments();
        this.getBranches();
    },
    methods: {
        index(page, filter, sort, position) {
        var route = this.routePrefix + "?";
        route += "page=" + page;
        if (this.search.length > 0) {
            route += "&search=" + this.search;
        }
        if (this.filter) {
            route += "&filter=" + this.filter;
        }
        if (this.sort) {
            route += "&sort=" + this.sort;
        }
        if (this.position) {
            route += "&position=" + this.position;
        }
        this.loaded = false;
        this.$router
            .push({
                query: {
                    page: page,
                    search: this.search,
                    filter: this.filter,
                    sort: this.sort,
                    position: this.position,
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
        changePage(current_page) {
            if (current_page <= this.datatable.last_page && current_page > 0) {
                this.datatable.current_page = current_page;
                this.index(current_page);
            }
        },
        filterMatrix(page) {
            this.$router.push({
                query: {
                    filter: this.filter,
                    sort: this.sort,
                    position: this.position,
                    page: page,
                },
            })
            .catch((error) => {
                console.log(error)
            })
            this.index(page, this.filter, this.sort, this.position);
        },
        getDocuments() {
        axios
            .get(this.routePrefix + "documents")
            .then((response) => {
                this.documents = response.data;
            })
            .catch(() => {
                console.log(err);
            });
        },
        getBranches() {
        axios
            .get('/api/branches')
            .then((response) => {
                this.branches = response.data
            })
            .catch((error) => {
                console.log(error)
            })
        }
    },
};
</script>
