<template>
    <div class="row pt-4">
        <div class="col-lg-6 col-12">
            <div class="block block-rounded block-fx-pop">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Document Upload</h3>
                    <div class="block-options">
                        <button
                        type="button"
                        @click="store"
                        class="btn btn-success btn-sm mt-1"
                        >
                        <i class="mr-1 fa fa-plus"></i> Upload
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <select v-model="image.document_id" class="form-control selectpicker mb-3">
                        <option selected disabled>Select document</option>
                        <option
                            class="optionpicker"
                            v-for="document in documents.data"
                            v-bind:key="document.id"
                            :value="document.id"
                        >
                            {{ document.name }}
                        </option>
                    </select>
                    <div class="form-group">
                        <input
                            id="file"
                            class="form-control mb-4"
                            type="file"
                            ref="file"
                            enctype="multipart/form-data"
                            multiple
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="block block-rounded block-fx-pop">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Uploaded Documents</h3>
                </div>
                <div class="block-content">
                    <div v-if="applicant.resume_url" class="row">
                        <div  class="col-11">
                            <a :href="'/' + applicant.resume_url" target="_blank" class="mb-2">
                                <i class="fas fa-file-download fa-xl mr-2 mb-3" onclick="myFunction()"></i> Resume
                            </a>
                        </div>
                        <div class="col-1 my-auto">
                            <p>Default</p>
                        </div>
                    </div>
                    <div v-else class="row">
                        <div class="col-11">
                                <i class="fas fa-file-download fa-xl mr-2 mb-3" ></i> Upload Resume
                        </div>
                        <div class="col-1 my-auto">
                            <p>Default</p>
                        </div>
                    </div>
                    <div v-for="(image, key) in images" :key="key" class="last-child">
                        <div class="row">
                            <div class="col-11">
                               <!-- <a :href="'/api/recruitment/compliance/upload/get/' + image.filename" target="_blank" class="mb-2">
                                    <i class="fas fa-file-download fa-xl mr-2 mb-3"></i>{{ image.name }}
                                </a> -->
                                 <a :href="'/public/attachment/app_comp_files/' + image.filename" target="_blank" class="mb-2">
                                    <i class="fas fa-file-download fa-xl mr-2 mb-3" onclick="myFunction()"></i>{{ image.name }}
                                </a>
                            </div>
                            <div class="col-1 my-auto">
                                <button type="button" class="btn btn-sm" @click="destroy(image.id)">
                                    <i class="fas fa-times text-danger"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {

    mounted(){

        this.show();
        },

    computed: {
        documents: function () {
            return this.$parent.documents;
        },
        applicantID: function () {
            return this.$parent.applicant.id;
        },
        images: function () {
            return this.$parent.images.data;
        },
        noImages: function () {
            return _.size(this.images) === 0 ? true : false;
        },
    },
    data() {
        return {
            routePrefix: "/api/recruitment/compliance/upload/",
            image: {},
            applicant:{},
            disabled: false,
            newImage: false,
        };
    },
    methods: {
        myFunction: function () {
            window.open( "_blank");
        },

        show() {
            axios.get("/api/recruitment/applications/" + this.$route.params.id)
                .then((response) => {
                    this.applicant = response.data;
                });
        },
        store() {
        this.disabled = true;
        this.upload = this.$refs.file.files;
        let formData = new FormData();
        for (var count = 0; count < this.upload.length; count++) {
            formData.append("files[]", this.upload[count]);
        }
        axios
            .post(
            this.routePrefix +
                "image/" +
                this.applicantID +
                "/" +
                this.image.document_id,
            formData,
            {
                headers: {
                "Content-Type": "multipart/form-data",
                },
            }
            )
            .then((response) => {
            this.$parent.show();
            this.$root.notification(response.data.message, "success");
            })
            .catch((error) => {
                this.$root.notification(error.response.data.message, "error");
            })
            .then(() => {
                this.disabled = false;
            });
        },
        destroy(id) {
        axios
            .delete(this.routePrefix + "delete/" + id)
            .then(response => {this.$root.notification(response.data.message, "success")})
            .catch(error => {this.$root.notification(error.response.data.message, "error")})
            .then(() => {this.$parent.show()})
        },
    },
};
</script>
<style lang="scss">
#file {
    height: 50px;
    padding: 0.55rem;
}
.last-child:not(:last-child) {
    margin-bottom: 0.5rem;
}
.last-child:last-child {
    margin-bottom: 1.5rem;
}
</style>
