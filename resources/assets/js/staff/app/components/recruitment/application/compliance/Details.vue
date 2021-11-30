<template>
    <div class="mt-5">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title"> Please select appropriate compliance item to view or input details</h3>
            </div>
            <div class="block-content">
                <div class="row justify-content-center py-3">
                    <div class="col-sm-10 col-md-8">
                        <div class="form-group">
                            <label for="block-form7-username">Select compliance item</label>
                            <select name="complinace_item" class="form-control selectpicker" v-model="filter" @change="show">
                                <option disabled>Compliance items</option>
                                <option v-for="(compliance, key) in completed_complinace" :key="key" :value="compliance.id">{{ compliance.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block block-rounded" v-show="filter == 1">
            <div class="block-header block-header-default">
                <h3 class="block-title">Referee Details</h3>
            </div>
            <div class="block-content">
                <div class="row justify-content-center py-sm-3 py-md-4">
                    <div class="col-sm-12 col-md-11" v-for="(referee, key) in references" :key="key + 1">
                        <div class="form-row">
                            <div class="form-group col-md-4 col-12">
                                <label for="block-form-username">Name</label>
                                <input name="referee_name" type="text" class="form-control float-right" v-model="referee.name"/>
                            </div>
                            <div class="form-group col-md-4 col-12">
                                <label for="block-form-username">Email</label>
                                <input name="email" type="text" class="form-control float-right" v-model="referee.email"/>
                            </div>
                            <div class="form-group col-md-4 col-12">
                                <label for="block-form-username">Contact Number</label>
                                <input name="email" type="text" class="form-control float-right" v-model="referee.mobile"/>
                            </div>
                        </div>
                    </div>            
                </div>
            </div>
        </div>
        <div class="block block-rounded" v-show="filter == 2">
            <div class="block-header block-header-default">
                <h3 class="block-title">Induction Attendance Details</h3>
            </div>
            <div class="block-content">
                <div class="row justify-content-center py-sm-3 py-md-4">
                    <div class="col-sm-12 col-md-11">
                        <div class="table-responsive">
                            <table class="table table-hover table-vcenter table-bordered table-striped js-appear-enabled animated fadeIn">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Location</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Attended</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    <tr v-for="(induction, key) in event.induction" :key="key + 1">
                                        <td style="text-transform:capitalize;">{{ induction.event.location }}</td>
                                        <td>{{ induction.event.date }}</td>
                                        <td>{{ induction.event.time }}</td>
                                        <td>{{ induction.attendance | AttendanceConfirmation }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>       
            </div>
        </div>
        <div class="block block-rounded" v-show="filter == 3">
            <div class="block-header block-header-default">
                <h3 class="block-title">Training Attendance Details</h3>
            </div>
            <div class="block-content">
                <div class="row justify-content-center py-sm-3 py-md-4">
                    <div class="col-sm-12 col-md-11">
                        <div class="table-responsive">
                            <table class="table table-hover table-vcenter table-bordered table-striped js-appear-enabled animated fadeIn">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Agenda</th>
                                        <th>Location</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Attended</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    <tr v-for="(training, key) in event.training" :key="key + 1">
                                        <td>{{ training.event.agenda }}</td>
                                        <td style="text-transform:capitalize;">{{ training.event.location }}</td>
                                        <td>{{ training.event.date }}</td>
                                        <td>{{ training.event.time }}</td>
                                        <td>{{ training.attendance | AttendanceConfirmation }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>            
                </div>
            </div>
        </div>
        <div class="block block-rounded" v-show="filter == 4">
            <div class="block-header block-header-default">
                <h3 class="block-title">DBS Check Details</h3>
                <div class="block-options">
                    <button type="submit" class="btn btn-sm btn-primary" @click="store" v-if="complianceLength == 0">
                        <i class="fa fa-check"></i> Save
                    </button>
                </div>
            </div>
            <div class="block-content">
                <div class="row justify-content-center py-sm-3 py-md-4">
                    <div class="col-sm-12 col-md-11" v-if="complianceLength == 0">
                        <div class="form-row">
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">DBS Number</label>
                                <input name="issue_date" type="text" class="form-control float-right" v-model="request.dbs_number"/>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">Issue Date</label>
                                <input name="issue_date" type="date" class="form-control float-right" v-model="request.issue_date"/>
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">Date Checked</label>
                                <input name="date_checked" type="date" class="form-control float-right" v-model="request.date_checked"/>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">Is it Online?</label>
                                <select name="online" class="form-control float-right" v-model="request.online">
                                    <option selected disabled>Is it online</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-11" v-else v-for="(compliance, key) in compliance" :key="key + 1">
                        <div class="form-row">
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">DBS Number</label>
                                <input name="issue_date" type="text" class="form-control float-right" v-model="compliance.dbs_number"/>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">Issue Date</label>
                                <input name="issue_date" type="date" class="form-control float-right" v-model="compliance.issue_date"/>
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">Date Checked</label>
                                <input name="date_checked" type="date" class="form-control float-right" v-model="compliance.date_checked"/>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">Is it Online?</label>
                                <select name="online" class="form-control float-right" v-model="compliance.online">
                                    <option selected disabled>Is it online</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12 text-right">
                                <button type="submit" class="btn btn-sm btn-success" @click="update(compliance)" v-show="complianceLength > 0">
                                    <i class="fa fa-save"></i> Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block block-rounded" v-show="filter == 5">
            <div class="block-header block-header-default">
                <h3 class="block-title">Nurse Details</h3>
            </div>
            <div class="block-content">
                <div class="row justify-content-center py-sm-3 py-md-4">
                    <div class="col-sm-12 col-md-11">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="block-form-username">Nurse Pin Number</label>
                                <input name="nurse_pin_number" type="text" class="form-control" v-show="applicant.nurse_pin_number != null" v-model="applicant.nurse_pin_number"/>
                                <p v-show="applicant.nurse_pin_number == null">Nurse Pin Number has yet to be provided (This should be provided during the interview)</p>
                            </div>
                        </div>
                    </div>            
                </div>
            </div>
        </div>
         <div class="block block-rounded" v-show="filter == 6">
            <div class="block-header block-header-default">
                <h3 class="block-title">Passport, Visa & Birth Certificate Details</h3>
                <div class="block-options">
                    <button type="submit" class="btn btn-sm btn-primary" @click="store" v-if="complianceLength == 0">
                        <i class="fa fa-check"></i> Save
                    </button>
                </div>
            </div>
            <div class="block-content">
                <div class="row justify-content-center py-sm-3 py-md-4">
                    <div class="col-sm-12 col-md-11" v-if="complianceLength == 0">
                        <div class="form-row">
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">Passport Number</label>
                                <input name="passport_number" class="form-control float-right" v-model="request.passport_number"/>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">Passport Expiry Date</label>
                                <input name="passport_expiry" type="date" class="form-control float-right" v-model="request.passport_expiry"/>
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">Visa Number</label>
                                <input name="visa_number" class="form-control float-right" v-model="request.visa_number"/>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">Visa Type</label>
                                <select name="visa_type" class="form-control float-right" v-model="request.visa_type">
                                    <option selected disabled>Select visa type</option>
                                    <option value="1">Work</option>
                                    <option value="2">Student</option>
                                    <option value="3">Limited Leave</option>
                                    <option value="4">Indefinite Leave</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">Allowed Hours <span v-if="request.visa_type == 2" style="color:red; font-size:12px;"> (Limited to 20 hours per week) </span></label>
                                <input name="allowed_hours" class="form-control float-right" v-model="request.hours"/>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">Visa Expiry Date</label>
                                <input name="allowed_hours" type="date" class="form-control float-right" v-model="request.visa_expiry"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-11" v-else v-for="(compliance, key) in compliance" :key="key + 1">
                        <div class="form-row">
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">Passport Number</label>
                                <input name="passport_number" class="form-control float-right" v-model="compliance.passport_number"/>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">Passport Expiry Date</label>
                                <input name="passport_expiry" type="date" class="form-control float-right" v-model="compliance.passport_expiry"/>
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">Visa Number</label>
                                <input name="visa_number" class="form-control float-right" v-model="compliance.visa_number"/>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">Visa Type</label>
                                <select name="visa_type" class="form-control float-right" v-model="compliance.visa_type">
                                    <option selected disabled>Select visa type</option>
                                    <option value="1">Work</option>
                                    <option value="2">Student</option>
                                    <option value="3">Limited Leave</option>
                                    <option value="4">Indefinite Leave</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">Allowed Hours <span v-if="compliance.visa_type == 2" style="color:red; font-size:12px;"> (Limited to 20 hours per week) </span></label>
                                <input name="allowed_hours" class="form-control float-right" v-model="compliance.hours"/>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="block-form-username">Visa Expiry Date</label>
                                <input name="allowed_hours" type="date" class="form-control float-right" v-model="compliance.visa_expiry"/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12 text-right">
                                <button type="submit" class="btn btn-sm btn-success" @click="update(compliance)" v-show="complianceLength > 0">
                                    <i class="fa fa-save"></i> Update
                                </button>
                            </div>
                        </div>
                    </div>       
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
import Upload from "./Upload";

export default {
    computed: {
        applicant: function() {
            return this.$parent.applicant;
        },
        documentId: function () {
            return this.$route.params.document;
        },
        complianceLength: function () {
            return _.size(this.compliance);
        },
    },
    components: {
        Upload,
    },
    data: function () {
        return {
            routePrefix: "/api/recruitment/compliance/details/",
            completed_complinace: {},
            request: {},
            compliance: {},
            references: {},
            event: {
                induction: {},
                training: {},
            },
            filter: {},
            loaded: false,
            edit: false,
            disabled: false,
            newDetails: false,
        };
    },
    mounted() {
        this.getDocuments();
        this.getReferences();
        this.getInduction();
        this.getTraining();
        this.show();
    },
    methods: {
        show() {
        axios.get(this.routePrefix + this.$route.params.id + "/" + this.filter)
            .then((response) => {
                this.compliance = response.data;
            });
        },
        getDocuments() {
        axios
            .get(this.routePrefix + "docs/" + this.$route.params.id)
            .then((response) => {
                this.completed_complinace = response.data;
            })
            .catch((error) => {
                console.log(error);
            });
        },
        getReferences() {
        axios
            .get(this.routePrefix + "referees/" + this.$route.params.id)
            .then((response) => {
                this.references = response.data;
            })
            .catch((error) => {
                console.log(error);
            })
        },
        getInduction() {
        axios
            .get(this.routePrefix + "induction/" + this.$route.params.id)
            .then((response) => {this.event.induction = response.data})
            .catch((error) => console.log(error))
        },
        getTraining() {
        axios
            .get(this.routePrefix + "training/" + this.$route.params.id)
            .then((response) => {this.event.training = response.data})
            .catch((error) => console.log(error))
        },
        store() {
        axios
            .post(this.routePrefix + this.$route.params.id + "/" + this.filter, this.request)
            .then(response => {
                this.newDetails = false;
                this.$root.notification(response.data.message, "success");
            })
            .catch(error => {
                this.$root.notification(error.response.data.message, "error");
            })
            .then(() => {
                this.show();
            })
        },
        update(compliance) {
        axios
            .patch(this.routePrefix + "update/" + this.filter + "/" + this.$route.params.id, compliance)
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
    },
};
</script>