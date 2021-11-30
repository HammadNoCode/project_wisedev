<template>
    <div class="content">
        <div class="row my-3">
            <div class="col-12 my-auto">
                <h4 class="h4 mb-2">Compliance Hub</h4>
            </div>
        </div>
        <div class="block block-rounded mt-sm-3 mt-md-4">
            <div class="block-header block-header-default">
                <h3 class="block-title">Create Compliance Document Form</h3>
                <div class="block-options my-auto">
                    <button type="button" class="btn btn btn-primary" @click="newCreate = true" v-show="newCreate == false">
                        <i class="fa fa-plus mr-1"></i> Show Form
                    </button>
                    <button type="button" class="btn btn btn-danger" @click="newCreate = false" v-show="newCreate == true">
                        <i class="fa fa-plus mr-1"></i> Hide Form
                    </button>
                </div>
            </div>
            <div class="block-content" v-show="newCreate == true">
                <div class="row justify-content-center py-sm-3 py-md-4">
                    <div class="col-sm-10 col-md-8">
                        <div class="form-group">
                            <label for="block-form5-username">Compliance Type</label>
                            <select
                                class="form-control selectpicker"
                                v-model="document.type"
                            >
                                <option value="0" selected disabled>Select Type</option>
                                <option value="1">Document</option>
                                <option value="2">Training</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="block-form5-username">Position</label>
                            <select
                                class="form-control selectpicker"
                                v-model="document.position"
                            >
                                <option value="0" selected disabled>Select Type</option>
                                <option value="Healthcare Assistant">Healthcare Assistant</option>
                                <option value="Senior Healthcare Assistant">Senior Healthcare Assistant</option>
                                <option value="RGN">RGN</option>
                                <option value="RMN">RMN</option>
                              <!--  <option value="Support Worker">Support Worker</option> -->
                            </select>
                        </div>
                        <div class="form-row" v-show="document.type == 1">
                            <div class="form-group col-12">
                                <label for="block-form5-password">Document Name</label>
                                <input name="name" type="text" class="form-control" v-model="document.name"/>
                            </div>
                            <div class="form-group col-12">
                                <label for="block-form5-password">Document Required</label>
                                <select class="form-control selectpicker" v-model="document.required">
                                    <option selected disabled>Required</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row" v-show="document.type == 2">
                            <div class="form-group col-12">
                                <label for="block-form5-password">Training Name</label>
                                <input name="name" type="text" class="form-control" v-model="document.name"/>
                            </div>
                            <div class="form-group col-12">
                                <label for="block-form5-password">Training Required</label>
                                <select class="form-control selectpicker" v-model="document.required">
                                    <option selected disabled>Required</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content block-content-full block-content-sm bg-body-light" v-show="newCreate == true">
                <div class="row">
                    <div class="col-12 text-right">
                        <button type="button" class="btn btn-success" @click="store">
                            <i class="fa fa-plus"></i> Create
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
                    <div class="block-content block-content-full tab-content">
                        <div class="row mb-4">
                            <div class="col-md-6 col-12 my-auto">
                                 <h3 class="block-title">Current Compliance Document List</h3>
                            </div>
                            <div class="col-md-6 col-12 input-group ml-auto" >
                                <select class="form-control" v-model="filter" @change="filterCompliance(1)">
                                    <option value="0" disabled>Filter by Type</option>
                                    <option value="all">All</option>
                                    <option value="1">Document</option>
                                    <option value="2">Training</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive" v-if="loaded">
                                    <table class="table table-hover table-vcenter table-bordered table-striped js-appear-enabled animated fadeIn">
                                        <thead class="thead-light" v-if="datatable.data.length">
                                            <tr>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Required</th>
                                            <th></th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white">
                                            <tr v-for="(document, key) in datatable.data" v-bind:key="key">
                                                <td v-if="edit == document.id">
                                                    <input
                                                    name="name"
                                                    type="text"
                                                    class="form-control"
                                                    v-model="document.name"
                                                    />
                                                </td>
                                                <td v-else>{{ document.name }}</td>
                                                <td v-if="edit == document.id">
                                                    <select
                                                        name="type"
                                                        class="form-control"
                                                        v-model="document.type"
                                                    >
                                                        <option selected disabled>Document Type?</option>
                                                        <option value="1">Dcoument</option>
                                                        <option value="2">Training</option>
                                                    </select>
                                                </td>
                                                <td v-else>{{ document.type | docType }}</td>
                                                <td v-if="edit == document.id">
                                                    <select
                                                        class="form-control selectpicker"
                                                        v-model="document.required"
                                                    >
                                                        <option selected disabled>Required ?</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </td>
                                                <td v-else>{{ document.required | isRequired }}</td>
                                                <td class="text-center">
                                                    <button
                                                        type="button"
                                                        name="button"
                                                        class="btn btn-sm btn-outline-secondary my-auto mr-2"
                                                        @click="edit = document.id"
                                                        v-show="!edit"
                                                    >
                                                        <i class="fas fa-edit fa-lg"></i>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        name="button"
                                                        class="btn btn-sm btn-outline-success my-auto mr-2"
                                                        @click="update(document)"
                                                        v-show="edit"
                                                        >
                                                        <i class="far fa-save fa-lg"></i>
                                                    </button>
                                                    <button
                                                        class="btn btn-danger btn-sm float-right my-auto"
                                                        type="button"
                                                        name="button"
                                                        v-on:click="destroyAttendee(document.id)"
                                                        v-show="!edit"
                                                    >
                                                        <i class="fas fa-trash"></i>
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
import Pagination from "../layout/tables/Pagination.vue";
import Loading from "../layout/tables/Loading.vue";

export default {
    data: function () {
        return {
            routePrefix: "/api/compliance/create/",
            datatable: {
                data: {},
                current_page: 1,
                per_page: 15,
                last_page: 0,
                total: 1,
            },
            document: {},
            filter: "all",
            newCreate: false,
            loaded: false,
            edit: false,
        };
    },
    components: {
        Pagination,
        Loading,
    },
    watch: {
        filter: function(val) {
            this.index(1);
        }
    },
    mounted() {
        if (this.$route.query.page) {
            this.datatable.current_page = this.$route.query.page;
        }
        if (this.$route.query.filter) {
            this.filter = this.$route.query.filter;
        }
        this.index(this.datatable.current_page, this.filter);
    },
    methods: {
        index(page) {
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
                    filter: this.filter,
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
        filterCompliance(page) {
            this.$router.push({
                query: {
                filter: this.filter,
                page: page,
                },
            });
            this.index(page, this.filter);
        },
        changePage(current_page) {
            if (current_page <= this.datatable.last_page && current_page > 0) {
                this.datatable.current_page = current_page;
                this.index(current_page);
            }
        },
        store() {
        axios
            .post(this.routePrefix + "new-document", this.document)
            .then((response) => {
                this.success = true;
                this.$root.notification(response.data.message, "success");
            })
            .catch((error) => {
                this.message = "Oops, an error occurred!";
                this.$root.notification(error.response.data.message, "error");
            })
            .then(() => {
                this.index();
            });
        },
        update(document){
            this.edit = false;
            axios
            .patch(this.routePrefix + "update/" + document.id, document)
            .then(response => {
                this.$root.notification(response.data.message, "success");
            })
            .catch(error => {
                this.$root.notification(error.response.data.message, "error");
            })
            .then(() => {
                this.index();
            });
        },
        destroyAttendee(id) {
        axios
            .delete(this.routePrefix + id)
            .then((response) => {
                this.$root.notification(response.data.message, "success");
            })
            .catch((error) => {
                this.$root.notification(error.response.data.message, "error");
            })
            .then(() => {
                this.index();
            });
        },
    },
};
</script>
