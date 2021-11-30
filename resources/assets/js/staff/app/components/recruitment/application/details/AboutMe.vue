<template>
    <div>
        <div class="block block-rounded my-3">
            <div class="block-header block-header-default">
                <h5 class="h5 my-auto py-2">About Me</h5>
            </div> 
            <div class="block-content block-content-full">
                <div class="row" >
                    <div class="col-12 form-group">
                        <textarea
                            type="text"
                            name="about"
                            rows="7"
                            class="form-control"
                            placeholder="About me ..."
                            v-model="profile.about_me"
                        />
                    </div>
                </div>
            </div>
            <div class="block-content block-content-full block-content-sm bg-body-light">
                <div class="row">
                    <div class="col-12 my-auto my-auto" v-if="applicant.about_me == null">
                        <button type="button" name="button" class="btn btn-success float-right" @click="store">
                            <i class="fa fa-save mr-1"></i>Save
                        </button>
                    </div>
                    <div class="col-12 my-auto my-auto" v-else>
                        <button type="button" name="button" class="btn btn-secondary float-right" @click="update(profile)">
                            <i class="fa fa-save mr-1"></i>Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ProfilePicture from "./Picture";
import Upload from "./Upload";

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
            profile: {},
            data: {},
            picture: {},
            edit: false,
            disabled: false,
        };
    },
    components: {
        ProfilePicture,
        Upload,
    },
    mounted() {
        this.show();
    },
    methods: {
        store() {
        axios
            .post(this.routePrefix + this.applicant.id, this.profile)
            .then(response => {this.$root.notification(response.data.message, "success")})
            .catch(error => {this.$root.notification(error.response.data.message, "error")})
            .then(() => this.edit = false)
        },
        show() {
        axios
            .get(this.routePrefix + "get/" + this.$route.params.id)
            .then(response => {this.profile = response.data})
            .catch(error => {this.message = "Oops, an error occurred!"})
        },
        update(profile) {
        axios
            .patch(this.routePrefix + this.applicant.id, this.profile)
            .then(response => {this.$root.notification(response.data.message, "success")})
            .catch(error => {this.$root.notification(error.response.data.message, "error")})
            .then(() => this.edit = false)
        },
    }
}
</script>