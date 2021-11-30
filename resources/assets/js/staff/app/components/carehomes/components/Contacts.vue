<template>
    <div>
        <div class="row mt-3">
            <div class="col-12 col-lg-4">
                <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
                    <div class="block-content block-content-full tab-content">
                        <div class="row">
                            <div class="col-12 my-auto">
                                <h5 class="mb-0">New Contact</h5>
                            </div>
                        </div>
                        <hr>
                        <div class="row py-2">
                            <div class="col-12 py-1">
                                <label for="first_name">First Name</label>
                                <input class="form-control" type="text" name="first_name" placeholder="" v-model="newContact.first_name" />
                            </div>
                            <div class="col-12 py-1">
                                <label for="last_name">Last Name</label>
                                <input class="form-control" type="text" name="last_name" placeholder="" v-model="newContact.last_name"/>
                            </div>
                            <div class="col-12 py-1">
                                <label>Contact No.</label>
                                <input class="form-control" type="text" name="contact_no" placeholder="" v-model="newContact.contact_no"/>
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col-12 my-auto">
                                <button class="btn btn-success w-100 float-right" @click="storeContact"><i class="far fa-save pr-1"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 py-1 col-lg-8">
                <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
                    <div class="block-content block-content-full tab-content">
                        <div class="row">
                            <div class="col-12 py-1">
                                <h5 class="mb-0">Key Contacts</h5>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-vcenter table-borderless table-striped js-appear-enabled animated fadeIn">
                                        <tbody>
                                            <tr v-for="(contact, key) in keyContacts" :key="key">
                                                <td>{{contact.first_name}} {{contact.last_name}}</td>
                                                <td>{{contact.contact_no}}</td>
                                                <td>
                                                    <div class="d-none d-md-block">
                                                        <a class="btn btn-success btn-sm text-white float-right">CALL <i class="fas fa-phone pl-1"></i></a>
                                                    </div>
                                                    <div class="d-block d-md-none">
                                                        <a class="btn btn-success btn-sm text-white float-right"><i class="fas fa-phone"></i></a>
                                                    </div>
                                                </td>
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
</template>
<script>
export default {
    data: function() {
        return {
            routePrefix: "/api/carehome/key-contacts/",
            loaded: true,
            newContact: {
                first_name: '',
                last_name: '',
                contact_no: '',
            },
            keyContacts: {},
        }
    },
    mounted() {
        this.showContacts()
    },
    methods: {
        storeContact() {
            axios.post(this.routePrefix + this.$route.params.id, this.newContact)
            .then(response => {
                this.$root.notification(response.data.message, "success")
            })
            .catch(error => {
                this.$root.notification(error.response.data.message, "error")
            })
            .then(() => {
                this.showContacts();
            })
        },
        showContacts() {
            axios.get(this.routePrefix + this.$route.params.id)
            .then(response => {
                this.keyContacts = response.data
            })
            .catch(() => {})
        }
    }
}
</script>