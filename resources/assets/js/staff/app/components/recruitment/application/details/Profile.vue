<template>
    <div>
        <div class="row">
            <div class="col-lg-8 col-12">
                <upload/>
            </div>
            <div class="col-lg-4 col-12">
                <div class="block block-rounded text-center my-3">
                    <div class="block-header block-header-default">
                        <h5 class="h5 my-auto py-2">Uploaded Photo</h5>
                    </div> 
                    <div class="block-content block-content-full">
                        <div class="row">
                            <div class="col-12" v-if="pictureCount > 0">
                                <div class="options-container w-100" v-for="(picture, key) in picture" :key="key">
                                    <div class="options-item block block-rounded mb-0">
                                        <div class="text-center">
                                            <img class="img-avatar img-avatar-thumb mb" v-bind:src="'/api/recruitment/applications/about-me/upload/get/' + applicant.id + '/' + picture.filename">
                                        </div>
                                    </div>
                                    <div class="options-overlay rounded-lg">
                                        <div class="options-overlay-content">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-light mt-4" @click="destroy(picture.id)">
                                                    <i class="fa fa-trash text-danger "></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" v-else>
                                <div class="text-center mt-3">
                                    <i class="fas fa-user-alt fa-5x"></i> <br> <br>
                                    <span class="h6">No photo uploaded</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <about-me/>
            </div>
        </div>
    </div>
</template>
<script>
import Upload from "./Upload";
import ProfilePicture from "./Picture";
import AboutMe from "./AboutMe";

export default {
    computed: {
        applicant: function () {
            return this.$parent.applicant;
        },
        pictureCount: function () {
            return _.size(this.picture);
        },
    },
    data: function () {
        return {
            routePrefix: "/api/recruitment/applications/about-me/",
            branches: {},
            data: {},
            picture: {},
            edit: false,
            disabled: false,
        };
    },
    components: {
        Upload,
        ProfilePicture,
        AboutMe,
    },
    mounted() {
        this.showProfilePicture();
    },
    methods: {
        showProfilePicture() {
        axios
            .get(this.routePrefix + "upload/picture/" + this.$route.params.id)
            .then((response) => {this.picture = response.data})
            .then(() => {this.loaded = true})
        },
        destroy(id) {
        axios
            .delete(this.routePrefix + "upload/profile-picture/" + id)
            .then(response => {this.$root.notification(response.data.message, "success")})
            .catch(error => {this.$root.notification(error.response.data.message, "error")})
            .then(() => {
                this.showProfilePicture()
            });
        },
    }
}
</script>
<style lang="scss" scoped>
.img-avatar {
    display: block !important;
    width: 165px;
    height: 165px;
    border-radius: 50%;
    margin-left: auto;
    margin-right: auto;
}
</style>