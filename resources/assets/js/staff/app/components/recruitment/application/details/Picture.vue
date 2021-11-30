<template>
    <div class="row mb-4">
        <div class="col-12" v-if="pictureCount > 0">
            <div class="options-container w-100" v-for="(picture, key) in picture" :key="key">
                <div class="options-item block block-rounded mb-0">
                    <div class="block-content text-center">
                        <img class="img-avatar img-avatar-thumb mb" v-bind:src="'/api/recruitment/applications/about/upload/get/' + applicant.id + '/' + picture.filename">
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
                <span class="h6">No picture uploaded yet</span>
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
            uploadPercentage: 0,
            newUpload: false,
        }
    },
    mounted() {
        this.show();
    },
    methods: {
        show() {
        axios
            .get(this.routePrefix + "picture/" + this.applicant.id)
            .then((response) => {this.picture = response.data})
            .then(() => {this.loaded = true})
        },
        destroy(id) {
        axios
            .delete(this.routePrefix + "profile-picture/" + id)
            .then(response => {this.$root.notification(response.data.message, "success")})
            .catch(error => {this.$root.notification(error.response.data.message, "error")})
            .then(() => {
                this.show()
            });
        },
    },
}
</script>