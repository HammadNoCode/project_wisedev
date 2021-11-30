<template>
    <div class="content">
        <div class="row mt-2 p-lg-5">
            <div class="col-12">
                <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn" v-for="(group, key) in datatable" :key="key">
                    <div class="block-content block-content-full tab-content">
                        <div class="row">
                            <div class="col-12 my-auto">
                                <span class="h5">{{ group.name }}</span>
                            </div>
                        </div>
                        <div class="row pt-lg-4">
                            <div class="col-12">
                                <div class="table-responsive" v-if="loaded">
                                    <table class="table table-hover table-vcenter table-striped table-bordered js-appear-enabled animated fadeIn">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Audit Name</th>
                                                <th v-show="complianceManager" class="text-center">Items</th>
                                                <th class="text-center">Last Updated</th>
                                                <th style="width: 125px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(audit, key) in group.audits" :key="key">
                                                <td>
                                                    <router-link :to="{ path: '/compliance/upload-table/' + audit.id }" class="nav-link">
                                                        <i class="fas fa-folder-open pr-2"></i>{{ audit.display_name }}
                                                    </router-link>
                                                </td>
                                                <td v-show="complianceManager" class="text-center">{{ audit.completed_audits.length }}</td>
                                                <td class="text-center">{{ audit.updated_at }}</td>
                                                <td class="text-center" style="width: 125px;">
                                                    <button class="btn btn-sm btn-info p-2">
                                                        <router-link :to="{ path: '/compliance/upload-table/' + audit.id }" class="text-white">
                                                            View Items
                                                        </router-link>
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
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
import UploadForm from "./Upload/Form.vue"
import Pagination from "../../layout/tables/Pagination.vue";
import Loading from "../../layout/tables/Loading.vue";

export default {
    computed: {
        complianceManager: function () {
            return this.$store.state.user.compliance_manager == 1 ? true : false;
        },
    },
    data: function() {
        return {
            routePrefix: "/api/compliance-staff/checkout/",
            file: {},
            datatable: {
                data: {},
                current_page: 1,
                per_page: 10,
                last_page: 0,
                total: 1,
            },
            clinical: {},
            filter: "all",
            uploadFile: false,
            loaded: false,
        }
    },
    components: {
        UploadForm,
        Pagination,
        Loading,
    },
    watch: {
        filter: function(val) {
            this.show(1);
        }
    },
    mounted() {
        if (this.$route.query.page) {
            this.datatable.current_page = this.$route.query.page;
        }
        if (this.$route.query.filter) {
            this.filter = this.$route.query.filter;
        }
        this.show(this.datatable.current_page, this.filter);
        this.get_clinical();
    },
    methods: {
        show(page, filter) {
            var route = this.routePrefix + "?";
            route += "page=" + page;
            if (this.filter) {
                route += "&filter=" + this.filter;
            }
            this.loaded = false;
            this.$router.push({
                query: {
                    page: page,
                    filter: this.filter,
                },
            })
            .catch((error) => {})
            axios
                .get(route)
                .then((response) => {this.datatable = response.data})
                .then(() => {this.loaded = true})
        },
        filterFiles(page) {
            this.$router.push({
                query: {
                    filter: this.filter,
                    page: page,
                },
            });
            this.show(page, this.filter);
        },
        changePage(current_page) {
            if (current_page <= this.datatable.last_page && current_page > 0) {
                this.datatable.current_page = current_page;
                this.show(current_page);
            }
        },
        get_clinical() {
            axios
            .get("/api/compliance-staff/clinical")
            .then((response) => {this.clinical = response.data})
            .catch((error) => {})
        },
    }
}
</script>