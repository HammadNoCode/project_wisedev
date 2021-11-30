<template>
    <div class="content">
        <div class="row pt-sm-3 pt-md-4">
            <div class="col-12">
                <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
                    <div class="block-content block-content-full tab-content">
                        <div class="row mb-4">
                            <div class="col-md-9 col-12 my-auto">
                                <span class="h4">Pulse Staff Records</span>
                            </div>
                            <div class="col-md-3 col-12 my-auto">
                                <select
                                    class="form-control selectpicker"
                                    v-model="filter"
                                    @change="filterPulse(1)"
                                >
                                    <option value selected disabled>Filter duplicate</option>
                                    <option value="all">All</option>
                                    <option value="0">Duplicate</option>
                                    <option value="1">New</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive" v-if="loaded">
                                    <table class="table table-hover table-vcenter table-bordered table-striped js-appear-enabled animated fadeIn">
                                        <thead class="thead-light" v-if="datatable.data.length">
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Contact No</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white">
                                            <tr v-for="(staff, key) in datatable.data" :key="key">
                                                <td :class="{ duplicate: staff.application != null }">{{ staff.unique_id }}</td>
                                                <td :class="{ duplicate: staff.application != null }">{{ staff.first_name }} {{ staff.last_name }}</td>
                                                <td :class="{ duplicate: staff.application != null }">{{ staff.email }}</td>
                                                <td :class="{ duplicate: staff.application != null }">{{ staff.contact_no }}</td>
                                                <td :class="{ duplicate: staff.application != null }" class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm" @click="destroy(staff.id)">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
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
import Pagination from "../layout/tables/Pagination";
import Loading from "../layout/tables/Loading";

export default {
    data: function() {
        return {
            routePrefix: "/api/pulse-records/",
            datatable: {
                data: {},
                current_page: 1,
                per_page: 15,
                last_page: 0,
                total: 1,
            },
            filter: "all",
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
        if (this.$route.query.filter) {
            this.filter = this.$route.query.filter;
        }
        this.show(this.datatable.current_page, this.filter);
    },
    methods: {
        show(page, filter) {
            var route = this.routePrefix + "?";
            route += "page=" + page;
            if (this.filter) {
                route += "&filter=" + this.filter;
            }
            this.loaded = false;
            this.$router
                .push({
                    query: {
                        page: page,
                        filter: this.filter
                    },
                })
                .catch((error) => {
                    console.log(error)
                });
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
                this.show(current_page);
            }
        },
        filterPulse(page) {
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
        destroy(id) {
            axios
            .delete(this.routePrefix + id)
            .then((response) => {
                this.$root.notification(response.data.message, "success");
            })
            .catch((error) => {
                this.$root.notification(error.response.data.message, "error");
            })
            .then(() => {
                this.show()
            })
        }
    }
}
</script>
<style lang="scss" scoped>
    .duplicate {
        border-color: #FFC3C3;
        background-color: #FFC3C3;
    }
</style>