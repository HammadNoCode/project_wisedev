<template>
    <div class="content">
        <div class="row pl-xl-5 pr-xl-5 pt-lg-5">
            <div class="col-12">
                <div class="text-center">
                    <div class="alert alert-danger alert-dismissable" role="alert">
                        <span> <span class="h4" style="color:#74290e;">Warning - </span><br>These pdfs are NOT to be filled in... think of them as your reference library!</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="pl-xl-5 pr-xl-5 mt-4">
            <div class="block-header block-header-default">
                <div class="col-md-8 col-12">
                    <h3 class="h4 my-auto">Upload Procedures Form</h3>
                </div>
                <div class="col-md-4 col-12" v-show="complianceManager">
                    <button class="btn btn-success btn-sm float-right" v-show="!newProcedure" @click="newProcedure = true">Open</button>
                    <button class="btn btn-danger btn-sm float-right" v-show="newProcedure" @click="newProcedure = false">Hide</button>
                </div>
            </div>
        </div>
        <div class="pl-xl-5 pr-xl-5" v-if="newProcedure == true">
            <upload/>
        </div>
        <div class="pl-xl-5 pr-xl-5">
            <div class="row mt-4" v-if="procedures.length > 0">
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 text-center py-xl-3" v-for="(procedure, key) in procedures" :key="key">
                    <div class="align-items-center ">
                        <div class="options-container fx-overlay-zoom-out w-100">
                            <div class="options-item block block-rounded bg-white mb-0" style="height:170px!important;">
                                <div class="block-content text-center">
                                    <p class="mb-2 overflow-hidden">
                                        <i class="fa fa-fw fa-3x fa-file-alt text-black"></i>
                                    </p>
                                    <p class="font-w600 mb-0 pt-1" style="font-size:0.9rem;">
                                        {{ procedure.display_name }}
                                    </p>
                                </div>
                            </div>
                            <div class="options-overlay rounded-lg bg-white-50">
                                <div class="options-overlay-content">
                                    <div class="mb-3">
                                        <a class="btn btn-hero-info btn-sm" :href="'/api/compliance-staff/procedure/get/' + procedure.filename" target="_blank">
                                            <i class="fa fa-eye text-primary mr-1"></i> View
                                        </a>
                                    </div>
                                    <div class="btn-group" v-show="complianceManager">
                                        <a class="btn btn-sm btn-danger" type="button" @click="destroyAlert(procedure.id)">
                                            <i class="fa fa-trash text-light mx-auto"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5" v-else>
                <div class="col-12 text-center">
                    <span class="h5">No procedures have been uploaded yet</span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Upload from "./Upload/Main";

export default {
    computed: {
        complianceManager: function () {
            return this.$store.state.user.compliance_manager == 1 ? true : false;
        },
    },
    data: function () {
        return {
            routePrefix: "/api/compliance-staff/procedure/",
            procedures: {},
            newProcedure: false,
            loaded: false,
        }
    },
    components: {
        Upload,
    },
    mounted() {
        this.show();
    },
    methods: {
        show() {
            axios
            .get(this.routePrefix + "get")
            .then((response) => {this.procedures = response.data})
            .catch((error) => {Console.log(error)})
        },
        destroyAlert(id) {
        this.$swal
            .fire({
                title: "Delete Procedure",
                text: "Are you sure you would like to delete this procedure?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#39AEAC",
                cancelButtonColor: "#495057",
                confirmButtonText: "Yes",
            })
            .then((result) => {
                if (result.value) {this.destroy(id)}
            });
        },
        destroy(id) {
        axios
            .delete(this.routePrefix + id)
            .then(response => {this.$root.notification(response.data.message, "success")})
            .catch(error => {this.$root.notification(error.response.data.message, "error")})
            .then(() => {this.show()})
        },
    }
}
</script>