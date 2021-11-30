<template>
    <div>
        <div class="row mb-3">
            <div class="col-xs-6 col-sm-6 col-md m-1">
                <h3 class="block-title">
                    <span class="font-w700">Attendance Form</span>
                    <span class="text-muted">|</span>
                    <span class="font-w700 text-muted">Booking</span>
                </h3>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col-12 form-group">
                    <div class="block block-rounded mt-sm-3 mt-md-4">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Book Attendee into Event</h3>
                            <div class="block-options my-auto">
                                <button type="button" class="btn btn btn-primary" @click="newAttendee = true" v-show="newAttendee == false">
                                    <i class="fa fa-plus mr-1"></i> Show Form
                                </button>
                                <button type="button" class="btn btn btn-danger" @click="newAttendee = false" v-show="newAttendee == true">
                                    <i class="fa fa-plus mr-1"></i> Hide Form
                                </button>
                            </div>
                        </div>
                        <div class="block-content" v-show="newAttendee == true">
                            <div class="row justify-content-center py-sm-3 py-md-4">
                                <div class="col-sm-10 col-md-8">
                                    <div class="alert alert-success alert-dismissable" role="alert" v-show="event.expired == null">
                                        <p class="mb-0 text-center"><span class="h6">This event is still open.</span></p>
                                    </div>
                                    <div class="alert alert-danger alert-dismissable" role="alert" v-show="event.expired == 1">
                                        <p class="mb-0 text-center"><span class="h6">This event has now expired.</span> <br> Staff and applicant can no longer be booked into this event</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="block-form5-username">Attendee Type</label>
                                        <select class="form-control selectpicker" v-model="attendee.attendee_type">
                                            <option value="0" selected disabled>Select Applicant</option>
                                            <option v-if="event.attendee_type == 1 || event.attendee_type == 2" value="1">Applicants</option>
                                            <option v-if="event.attendee_type == 1 || event.attendee_type == 3" value="2">Staff</option>
                                        </select>
                                    </div>
                                    <div class="form-row" v-show="attendee.attendee_type == 1">
                                        <div class="form-group col-12">
                                            <label for="block-form5-password">Applicant Name</label>
                                            <select class="form-control selectpicker" v-model="attendee.attendee_id">
                                                <option value="0" selected disabled>Select Applicant</option>
                                                <option class="optionpicker" v-for="applicant in applicant" :key="applicant.id" :value="applicant.id" >
                                                    {{ applicant.first_name }} {{ applicant.last_name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row" v-show="attendee.attendee_type == 2">
                                        <div class="form-group col-12">
                                            <label for="block-form5-password">Staff Name</label>
                                            <select class="form-control selectpicker" v-model="attendee.attendee_id">
                                                <option value="0" selected disabled>Select Staff</option>
                                                <option class="optionpicker" v-for="staff in staff" :key="staff.id" :value="staff.id">
                                                    {{ staff.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-sm bg-body-light" v-show="newAttendee == true">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <button type="button" class="btn btn-success" @click="store">
                                        <i class="fa fa-plus"></i> Book Attendee
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
                        <div class="block-content block-content-full tab-content">
                            <div class="row mb-4">
                                <div class="col-md-3 col-12 my-auto">
                                    <span class="h5">Booking List</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive" v-if="loaded">
                                        <table class="table table-hover table-vcenter table-borderless table-striped js-appear-enabled animated fadeIn">
                                            <thead class="thead-light" v-if="datatable.data.length">
                                                <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Contact No</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Attendance</th>
                                                <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white">
                                                <tr v-for="(attendee, key) in datatable.data" v-bind:key="key">
                                                    <td v-if="attendee.staff == null">
                                                        {{ attendee.application.first_name }} {{ attendee.application.last_name }}
                                                    </td>
                                                    <td v-else>
                                                        {{ attendee.staff.name }}
                                                    </td>
                                                    <td v-if="attendee.staff == null">
                                                        {{ attendee.application.email }}
                                                    </td>
                                                    <td v-else>
                                                        {{ attendee.staff.email }}
                                                    </td>
                                                    <td v-if="attendee.staff == null"> 
                                                        {{ attendee.application.mobile }}
                                                    </td>
                                                    <td v-else> 
                                                        No Record
                                                    </td>
                                                    <td>{{ attendee.attendee_type }}</td>
                                                    <td v-if="attendee.status == null">
                                                        <span class="p text-info"><b>Awaiting Response</b></span>
                                                    </td>
                                                    <td v-if="attendee.status == 1">
                                                        <span class="p text-success"><b>Confirmed Attendance</b></span>
                                                    </td>
                                                    <td v-if="attendee.status == 2">
                                                        <span class="p text-danger"><b>Cannot Attend</b></span>
                                                    </td>
                                                    <td>
                                                        <select
                                                            class="form-control selectpicker"
                                                            style="border-bottom: 0px !important; border: 1px solid #d4dcec !important;"
                                                            v-model="attendee.attendance"
                                                            @change="updateAttendance(attendee)"
                                                        >
                                                            <option disabled selected>Confirm Attendance</option>
                                                            <option value="1">Yes</option>
                                                            <option value="2">No</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="col-md-auto">
                                                            <button
                                                                class="btn btn-danger btn-sm float-right"
                                                                type="button"
                                                                name="button"
                                                                @click="destroy(attendee.id)"
                                                            >
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                        <div class="col-md-auto" v-if="attendee.status == null" hidden>
                                                            <button
                                                                class="btn btn-success btn-sm mr-4 float-right"
                                                                type="btn"
                                                                name="button"
                                                                @click="update(attendee)"
                                                            >
                                                                <i class="fas fa-check mr-1"></i>Confirm Attendence
                                                            </button>
                                                        </div>
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
    </div>
</template>
<script>
import Pagination from "../../../layout/tables/Pagination";
import Loading from "../../../layout/tables/Loading";

export default {
    computed: {
        event: function () {
            return this.$parent.event;
        },
        AttendeeCount: function () {
            return _.size(this.attendee);
        },
    },
    data: function () {
        return {
            model: "booking",
            routePrefix: "/api/events/training/attendee/",
            datatable: {
                data: {},
                current_page: 1,
                per_page: 15,
                last_page: 0,
                total: 1,
            },
            attendee: {},
            applicant: {},
            staff: {},
            newAttendee: false,
            loaded: false,
            disabled: false,
        };
    },
    components: {
        Pagination,
        Loading,
    },
    mounted() {
        if (this.$route.query.page) {
            this.datatable.current_page = this.$route.query.page;
        }
        this.show(this.datatable.current_page);
        this.getApplicant();
        this.getStaff();
    },
    methods: {
        store() {
        axios
            .post(this.routePrefix + this.event.id, this.attendee)
            .then((response) => {
                this.success = true;
                this.$root.notification(response.data.message, "success");
            })
            .catch((error) => {
                this.message = "Oops, an error occurred!";
                this.$root.notification(error.response.data.message, "error");
            })
            .then(() => {
                this.show();
            });
        },
        show(page) {
        var route = this.routePrefix + "all/" + this.$route.params.id + "/?";
        route += "page=" + page;
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
                this.datatable = response.data
            })
            .then(() => {
                this.loaded = true;
            });
        },
        changePage(current_page) {
            if (current_page <= this.datatable.last_page && current_page > 0) {
                this.datatable.current_page = current_page;
                this.show(current_page);
            }
        },
        destroy(id) {
        axios
            .delete(this.routePrefix + id)
            .then((response) => {
                this.$root.notification(response.data.message, "success");
            })
            .catch((error) => {
                this.$root.notification(error.response.data.message, "error");
            })
            .then(() => {
                this.show();
            });
        },
        update(attendee) {
        this.edit = false;
        axios
            .patch(this.routePrefix + attendee.id, attendee)
            .then((response) => {
                this.$root.notification(response.data.message, "success");
            })
            .catch((error) => {
                this.$root.notification(error.response.data.message, "error");
            })
            .then(() => {
                this.show();
            });
        },
        updateAttendance(attendee) {
        axios
            .patch(this.routePrefix + "confirm/" + attendee.id, attendee)
            .then((response) => {
                this.$root.notification(response.data.message, "success");
            })
            .catch((error) => {
                notification(error.response.data.message, "error");
            })
            .then(() => {
                this.show();
            });
        },
        getApplicant() {
            axios.get(this.routePrefix + "applicant").then((response) => {
                this.applicant = response.data;
            });
        },
        getStaff() {
            axios.get(this.routePrefix + "staff").then((response) => {
                this.staff = response.data;
            });
        },
    },
};
</script>
<style scoped>
.btn-sty {
  width: 40px;
  padding: 6px !important;
}
</style>