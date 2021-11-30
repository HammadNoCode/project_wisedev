<template>
    <div class="row">
        <div class="col-12">
            <div class="block block-rounded my-3">
                <div class="block-header block-header-default">
                    <h5 class="my-auto py-2">Profile Picture Upload Form</h5>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center py-3">
                        <div class="col-10">
                            <div class="form-group">
                                <label for="block-form7-password">Select the image you want to upload</label>
                                <input id="file" class="form-control" type="file" ref="file" enctype="multipart/form-data" multiple/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light">
                    <div class="row">
                        <div class="col-12 text-right">
                            <button type="button" class="btn btn-success" @click="store">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    computed: {
        applicant: function () {
            return this.$parent.applicant;
        },
        pictureCount: function () {
            return _.size(this.picture);
        },
    },
    data: function() {
        return {
            routePrefix: "/api/recruitment/applications/about-me/upload/",
            file: {},
            picture: {},
            upload: {},
            uploadPercentage: 0,
        }
    },
    methods: {
        store() {
            this.upload = this.$refs.file.files;
            let formData = new FormData();
            for (var count = 0; count < this.upload.length; count++) {
                formData.append("files[]", this.upload[count]);
            }
        axios
            .post(this.routePrefix + "image/" + this.applicant.id,
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
            .then(() => {
                this.$parent.showProfilePicture()
            })
        },
    },
}
</script>
