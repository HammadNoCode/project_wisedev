<template>
    <div class="content">
        <div class="row my-3">
            <div class="col-12">
                <h3>Live Staff Profile Generator</h3>
            </div>
        </div>
        <div class="row my-3">
            <div class="col">
                <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
                    <div class="block-content tab-content pb-3">
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend">
                                        <span id="basic-addon1" class="input-group-text">Staff Name</span>
                                    </div>
                                    <input class="form-control" type="text" name="staff-search" v-model="search" :placeholder="'Wade Wilson'"/>
                                </div>
                            </div>
                            <div class="col-auto" v-if="selected_staff.length > 0">
                                <a :href="'/api/live-staff/pdf/' + selected_staff[0].id" target="_blank">
                                    <button type="button" name="button" class="btn btn-outline-secondary btn-block mb-3">
                                        <i class="fa fa-file-alt mr-1"></i> PDF
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="row my-3" v-if="search.length > 0">
                            <div class="col">
                                <table class="table table-vcenter table-bordered table-striped" v-if="loaded && live_staff.length">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(staff, key) in live_staff" :key="key">
                                            <td>{{ staff.id }}</td>
                                            <td>{{ staff.first_name }} {{ staff.last_name }}</td>
                                            <td><button class="btn btn-success" @click="selectStaff(staff.id)" :value="staff.id">Select</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-else>
                                    <h3 class="text-muted text-center py-3">No Staff Found</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-3" v-if="selected_staff.length > 0">
            <div class="col">
                <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
                    <div class="block-content tab-content pb-3">
                        <div class="bg-light" v-for="(staff, key) in selected_staff" :key="key + 1">
                            <div class="row">
                                <div class="col-12 desktop-padding mx-auto">
                                    <div class="bg-white m-5 p-5">
                                        <div class="row" >
                                            <div class="col-12">
                                                <div class="block-content text-center" v-if="staff.profile_picture">
                                                    <img class="img-avatar img-avatar-thumb mb" v-bind:src="'/api/recruitment/applications/about-me/upload/get/' + staff.profile_picture.applicant_id + '/' + staff.profile_picture.filename">
                                                </div>
                                                <div class="block-content text-center" v-else>
                                                    <img class="img-avatar img-avatar-thumb mb" src="/images/avatar/default.jpg" alt="default avatar">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-12 text-center">
                                                <h3 class="font-w800">{{ staff.first_name | capitalize }} {{ staff.last_name | capitalize }}</h3>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row" v-if="staff.about_me">
                                            <div class="col-12">
                                                <label class="h5 font-w800 mb-2"><b>About Me</b></label>
                                                <p>{{ staff.about_me.about_me }}</p>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row" v-if="staff.dbs_details">
                                            <div class="col-12">
                                                <label class="h5 font-w800 mb-2">DBS Details</label>
                                                <p class="mb-1">DBS Number: {{ staff.dbs_details.dbs_number }}</p>
                                                <p>Issue Date: {{ staff.dbs_details.issue_date }}</p>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-12">
                                                <label class="h5 font-w800 mb-3">Training Qualifications</label>
                                                <table class="table table-hover table-vcenter table-borderless js-appear-enabled animated fadeIn">
                                                    <thead>
                                                        <tr>
                                                            <th>Qualifications</th>
                                                            <th>Issue Date</th>
                                                            <th>Renewal Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(qualifications, key) in staff.training" :key="key">
                                                            <td>{{qualifications.compliance.name}}</td>
                                                            <td>{{qualifications.issue_date}}</td>
                                                            <td>{{qualifications.renewal_date}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { jsPDF } from "jspdf";
export default {
    data () {
        return {
            routePrefix: "/api/live-staff/",
            search: "",
            live_staff:  {},
            selected_staff: {},
            loaded: false,
        }
    },
    watch: {
        search(val) {
            this.showStaff();
        }
    },
    methods: {
        showStaff() {
            if(this.search.length > 0 ) {
                this.loaded = false;
                axios.get(this.routePrefix + 'name?staffName=' + this.search)
                .then(response => {
                    this.live_staff = response.data;
                })
                .then(() => {
                    this.loaded = true
                })
            }
        },
        selectStaff(id) {
            axios.get(this.routePrefix + id)
            .then(response => {
                this.selected_staff = response.data;
            })
            .then(() => {
                this.loaded = true;
                this.search = '';
            })
        }
    }
}
</script>
<style lang="scss" scoped>
.img-avatar {
    display: block !important;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    margin-left: auto;
    margin-right: auto;
}
@media screen and (min-width: 1700px) {
    .desktop-padding {
        padding-left: 8rem;
        padding-right: 8rem;
    }
}
</style>