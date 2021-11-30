<template>
    <div class="content">
        <form action="be_blocks_forms.html" data-bitwarden-watching="1">
            <div class="block block-rounded m-md-5">
                <div class="block-header block-header-default">
                    <h3 class="h4 my-auto">Audit Upload Form</h3>
                    <p class="text-right my-auto"><router-link class="nav-main-link" :to="{ name: 'UploadTable' }">View uploaded files<i class="fas fa-arrow-right pl-2"></i></router-link></p>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center py-sm-3 py-md-5">
                        <div class="col-sm-10 col-md-8">
                            <div class="alert alert-success alert-dismissable" role="alert" v-show="upload == 1">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <p class="mb-0">Success! You're completed file has been uploaded!</p>
                            </div>
                            <div class="alert alert-danger alert-dismissable" role="alert" v-show="upload == 2">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <p class="mb-0">Please make sure you haven't left any fields blank!</p>
                            </div>
                            <div class="form-group">
                                <label for="block-form7-username">Please select the audit you are uploading</label>
                                <select class="form-control" v-model="file.audit_id">
                                    <option selected disabled>Select Audit</option>
                                    <option v-for="(audit, key) in audits" :key="key" :value="audit.id">{{ audit.display_name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="block-form7-password">Your Audit</label>
                                <input
                                    id="file"
                                    class="form-control"
                                    type="file"
                                    ref="file"
                                    enctype="multipart/form-data"
                                    multiple
                                />
                            </div>
                            <div class="form-group">
                                <div class="progress push" style="border-radius: 5rem; height: 10px;">
                                    <div
                                        class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        role="progressbar"
                                        aria-valuenow="100"
                                        aria-valuemin="0"
                                        aria-valuemax="100"
                                        :style="{ width: uploadPercentage + '%' }"
                                        style="border-radius: 5rem"
                                    >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <button type="reset" class="btn btn-danger text-left">
                                <i class="fas fa-history"></i> Reset
                            </button>
                        </div>
                        <div class="col-md-6 col-12 text-right">
                            <button type="button" class="btn btn-success" @click="store">
                                <i class="fa fa-check"></i> Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script>

export default {
    data: function() {
        return {
            routePrefix: "/api/compliance-staff/checkout/upload/",
            audits: {},
            file: {},
            upload: {},
            uploadPercentage: 0,
        }
    },
    mounted() {
        this.showAudits();
    },
    methods: {
        showAudits() {
        axios
            .get(this.routePrefix + "audits")
            .then((response) => {this.audits = response.data})
            .catch((error) => {Console.log(error)})
        },
        store() {
            this.upload = this.$refs.file.files;
            let formData = new FormData();
            for (var count = 0; count < this.upload.length; count++) {
                formData.append("files[]", this.upload[count]);
            }
        axios
            .post(this.routePrefix + "file/" + this.file.audit_id,
            formData,
                {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                    onUploadProgress: function( progressEvent ) {
                        this.uploadPercentage = parseInt( Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 ));
                    }.bind(this)
                })
            .then((response) => {
                this.$root.notification("Image uploaded", "success");
                console.log("passed");
                this.upload = 1
            })
            .catch((error) => {
                this.upload = 2
            })
            .then(() => {
                this.uploadPercentage = 0
            })
        },
    },
}
</script>