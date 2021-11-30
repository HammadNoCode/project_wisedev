<template>
    <div>
        <div class="row">
            <div class="col-12">
                <form action="be_blocks_forms.html" data-bitwarden-watching="1" id="audit_upload">
                    <div class="block">
                        <div class="block-content">
                            <div class="row justify-content-center py-2">
                                <div class="col-sm-10 col-md-9">
                                    <div class="form-group">
                                        <input
                                            id="file"
                                            class="form-control"
                                            type="file"
                                            ref="file"
                                            enctype="multipart/form-data"
                                            multiple
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-sm bg-body-light">
                            <div class="row">
                                <div class="col-12">
                                    <button type="reset" class="text-left btn btn-danger btn-sm">
                                        <i class="fas fa-history pr-1"></i>Reset
                                    </button>
                                    <button type="button" class="float-right btn btn-success btn-sm" @click="store">
                                        <i class="fa fa-check"></i> Create
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data: function() {
        return {
            routePrefix: "/api/compliance-staff/procedure/",
            file: {},
        }
    },
    methods: {
        store() {
            this.upload = this.$refs.file.files;
            let formData = new FormData();
            for (var count = 0; count < this.upload.length; count++) {
                formData.append("files[]", this.upload[count],);
            }
        axios
            .post(this.routePrefix + "file",
            formData,
                {
                    headers: {
                    "Content-Type": "multipart/form-data",
                    },
                })
            .then((response) => {
                this.$root.notification("Image uploaded", "success");
                console.log("passed");
            })
            .catch((error) => {
                this.$root.notification(error.response.data.message, "error")
                })
            .then(() => {
                this.$parent.show();
                this.$parent.newProcedure = false;
            });
        },
    }
}
</script>