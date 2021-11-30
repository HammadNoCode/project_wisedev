<template>
    <div class="content">
        <div class="row mb-3 mt-3">
            <div class="col-md-auto col-12 my-auto">
                <h3 class="h3 mb-2">Create an IT Support Ticket</h3>
            </div>
        </div>
        <form id="ITForm" @submit.prevent="submitTicket">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="block block-rounded">
                        <div class="block-content p-sm-2 p-md-3 p-lg-4 p-xl-5">
                            <div class="form-group d-none d-lg-block">
                                <div class="form-row">
                                    <div class="col-12 col-lg-6">
                                        <label for="staffname">Full Name</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            name="staffname"
                                            placeholder="Wade Wilson"
                                            v-model="form_data.name"
                                        />
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="staffname">Email Address</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            name="staffemail"
                                            placeholder="example@warrantywise.co.uk"
                                            v-model="form_data.email"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-none d-lg-block">
                                <div class="form-row">
                                    <div class="col-12 col-lg-6">
                                        <label for="staffname">Phone Number</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            name="staffphone"
                                            placeholder="07123456789"
                                            v-model="form_data.phone"
                                        />
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="issue">What is the nature of your ticket?</label>
                                        <select
                                            class="form-control selectpicker"
                                            name="issue"
                                            v-model="form_data.issue"
                                        >
                                            <option selected disabled value="0">Reasons</option>
                                            <option value="System Bug">System Bug</option>
                                            <option value="Request a new feature">
                                                Request a new feature
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-none d-lg-block">
                                <div class="form-row">
                                    <div class="col-12">
                                        <!--    <label for="uploadpicture">Upload Picture</label> -->
                                        <div class="custom-file">
                                            <!-- MOST IMPORTANT - SEE "ref" AND "@change" PROPERTIES -->
                                            <!--  <input type="file" class="custom-file-input" id="customFile"
                                                     ref="file" @change="handleFileObject()">
                                              <label class="custom-file-label text-left" for="customFile">{{ fileName }}</label> -->
                                            <label for="Upload Picture">Upload Picture</label>
                                            <input  id="file" class="form-control" type="file" ref="file" enctype="multipart/form-data" @change="handleFileObject()"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-block d-lg-none">
                                <label for="fullname">Full Name</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    name="fullname"
                                    placeholder="Jon Jones"
                                    v-model="form_data.name"
                                />
                            </div>
                            <div class="form-group d-block d-lg-none">
                                <label for="staffemail">Email Address</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    name="staffemail"
                                    placeholder="example@cavalrycare.co.uk"
                                    v-model="form_data.email"
                                />
                            </div>
                            <div class="form-group d-block d-lg-none">
                                <label for="staffphone">Phone Number</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    name="staffphone"
                                    placeholder="07123456789"
                                    v-model="form_data.phone"
                                />
                            </div>
                            <div class="form-group d-block d-lg-none">
                                <label for="issue">What is the nature of your ticket?</label>
                                <select
                                    class="form-control selectpicker"
                                    name="issue"
                                    v-model="form_data.issue"
                                >
                                    <option selected disabled value="0">Reasons</option>
                                    <option value="System Bug">System Bug</option>
                                    <option value="Request a new feature">
                                        Request a new feature
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="details">Give details about yout ticket</label>
                                <textarea
                                    class="form-control"
                                    name="details"
                                    rows="5"
                                    v-model="form_data.details"
                                ></textarea>
                            </div>
                            <div class="form-group">
                                <button
                                    class="btn btn-success text-center text-white"
                                    type="submit"
                                    style="width: 100%"
                                    :diabled="isActive"
                                >
                                    {{ button }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
export default {
    data() {
        return {
            routePrefix: "/api/cdata",
            form_data: {
                name: "",
                email: "",
                phone: "",
                issue: 0,
                details: "",
            },
            file: null,
            fileName: null,
            //avatarName:null,
            button: "Submit",
            isActive: false,
        };
    },
    methods: {
        submitTicket() {
            this.button = "Submitting";
            this.isActive = true;
            let fdata = new FormData();
            fdata.append('file', this.file);
            fdata.append("name", this.form_data.name);
            fdata.append("email", this.form_data.email);
            fdata.append("phone", this.form_data.phone);
            fdata.append("issue", this.form_data.issue);
            fdata.append("details", this.form_data.details);
            fdata.append("data_parse", "1");
            axios
                .post(this.routePrefix, fdata, {
                    headers: {
                        'undefined': 'multipart/form-data'
                    }
                })
                .then((response) => {
                    this.$root.notification(response.data.message, "success");
                    this.resetFields();
                    this.button = "Submit";
                    this.isActive = false;
                })
                .catch((error) => {
                    this.$root.notification(error.response.data.message, "error");
                    this.button = "Submit";
                    this.isActive = false;
                });
        },
        handleFileObject() {
            this.file = this.$refs.file.files[0]
            this.fileName = this.file.name

        },
        resetFields() {
            Object.assign(this.$data, this.$options.data.call(this));
        },

    },
};
</script>
