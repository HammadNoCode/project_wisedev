<template>
    <div>
        <div class="row mt-3">
            <div class="col-lg-4 col-12">
                <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
                    <div class="block-content block-content-full tab-content">
                        <div class="row">
                            <div class="col-12 py-2">
                                <h2 class="text-center mb-1">{{carehome.main_contact_number}}</h2>
                            </div>
                            <div class="col-12 py-2">
                                <a class="btn w-100 text-white" style="background-color:#750288" :href="'tel:' + carehome.main_contact_number" @click="createRecord(carehome.location_id)">CALL <i class="fas fa-phone pl-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
                    <div class="block-content block-content-full tab-content">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-0">Call Counter</h5>
                            </div>
                        </div>
                        <hr>
                        <div class="row py-3">
                            <div class="col-12">
                                <h1 class="mb-0 text-center" style="font-size: 80px">{{datatable.data.length}}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-12">
                <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn" v-for="(record, key) in datatable.data" :key="key">
                    <div class="block-content block-content-full tab-content">
                        <div class="row">
                            <div class="col-12 py-1">
                                <div class="pb-3">
                                    <div class="row">
                                        <div class="col-md-8 col-12 my-auto">
                                            <h5 class="mb-3">Call recorded at <b>{{record.created_at}}</b> by <b>{{record.staff_id}}</b></h5>
                                        </div>
                                        <div class="col-md-4 col-12 my-auto text-right">
                                            <button type="button" class="btn btn-sm btn-secondary mb-3" v-show="editRecord !== record.id" @click="editRecord = record.id">
                                                <i class="far fa-edit pr-1"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-success btn-sm mx-1" v-show="editRecord === record.id" @click="updateRecord(record)">
                                                <i class="far fa-save pr-1"></i>Save
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-lg-4 col-12">
                                            <label class="text-muted text-sm">Spoke To</label>
                                            <input type="text" class="form-control" :disabled="editRecord !== record.id" v-model="record.spoke_to">
                                        </div>
                                        <div class="col-lg-4 col-12">
                                            <label class="text-muted text-sm">Position</label>
                                            <input type="text" class="form-control" :disabled="editRecord !== record.id" v-model="record.position">
                                        </div>
                                        <div class="col-lg-4 col-12">
                                            <label class="text-muted text-sm">Decision Maker</label>
                                            <select class="form-control" :disabled="editRecord !== record.id" v-model="record.decision_maker">
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row pt-1">
                                        <div class="col-12">
                                            <label class="text-muted text-sm">Notes</label>
                                            <textarea type="text" class="form-control" rows="3" :disabled="editRecord !== record.id" v-model="record.notes"></textarea>
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
export default {
    computed: {
        carehome: function() {
            return this.$parent.carehome
        }
    },
    data() {
        return {
            routePrefix: "/api/carehome/call-history/",
            edit: false,
            datatable: {
                data: {},
                current_page: 1,
                per_page: 15,
                last_page: 0,
                total: 1,
            },
            call: {},
            editRecord: {},
        }
    },
    mounted() {
        this.readCallRecords()
    },
    methods: {
        createRecord(id) {
            axios.post(this.routePrefix + id)
            .then(response => {
                this.$root.notification(response.data.message, "success");
            })
            .catch(error => {
                this.$root.notification(error.response.data.message, "error");
            })
            .then(() => {
                this.readCallRecords();
            });
        },
        readCallRecords() {
            axios.get(this.routePrefix + this.$route.params.id)
            .then(response => {
                this.datatable = response.data
            })
            .catch(error => {
                console.log(error);
            })
        },
        updateRecord(record) {
            axios.patch(this.routePrefix + "update/" + record.id, record)
            .then(response => {
                this.$root.notification(response.data.message, "success");
            })
            .catch(error => {
                this.$root.notification(error.response.data.message, "error");
            })
            .then(() => {
                this.readCallRecords();
                this.editRecord = {};
            })
        }
    }
}
</script>