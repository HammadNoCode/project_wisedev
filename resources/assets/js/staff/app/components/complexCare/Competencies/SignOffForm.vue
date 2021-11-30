<template>
    <div class="content">
        <div class="row mb-3 mt-3">
            <div class="col-md-auto col-12 my-auto">
                <h4 class="h4 mb-2">Complex Sign Off Form</h4>
            </div>
        </div>
        <form id="competencies" enctype="multipart/form-data" @submit.prevent="submitForm">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="block block-rounded">
                        <div class="block-content p-sm-2 p-md-3 p-lg-4 p-xl-5">
                            <h3 class="alert-heading font-size-h5 my-2">Read Me</h3>
                            <div class="row mb-lg-5 mb-md-3 my-auto">
                                <div class="col-12 col-lg-9">
                                    <p class="mb-1">Please use Microsoft Lens to convert your hand written competency sign off forms to a .pdf.</p>
                                    <p class="mb-1">If this app isn't already installed on you mobile or tablet please click the icon on the right.</p>
                                    <p class="mb-1">Here is a <b><a href="https://support.microsoft.com/en-us/office/microsoft-lens-for-ios-fbdca5f4-1b1b-4391-a931-dc1c2582397b" target="_blank">how-to-use guide</a></b>. That explains everything you need to know.</p>
                                </div>
                                <div class="col-12 col-lg-3 my-auto">
                                    <p class="text-center mb-2">
                                        <a href="https://apps.apple.com/gb/app/microsoft-office-lens-pdf-scsn/id975925059" target="_blank">
                                            <button class="btn" type="button">
                                                <img src="/images/external-logos/Microsoft-Lens-Logo.png" alt="" style="width:40%;">
                                            </button>
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group d-none d-lg-block">
                                <div class="form-row">
                                    <div class="col-md-6 col-12">
                                        <label for="nursename">Nurse Name</label>
                                        <input class="form-control" type="text" name="nursename" v-model="form_data.nurse">                                        
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label for="staffname">Staff Name</label>
                                        <input class="form-control" type="text" name="staffname" v-model="form_data.staff">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-block d-lg-none">
                                <label for="nursename">Nurse Name</label>
                                <input class="form-control" type="text" name="nursename" v-model="form_data.nurse">
                            </div>
                            <div class="form-group d-block d-lg-none">
                                <label for="staffname">Staff Name</label>
                                <input class="form-control" type="text" name="staffname" v-model="form_data.staff">
                            </div>
                            <div class="form-group">
                                <label for="fileupload">Upload</label>
                                <input class="form-control mb-4" id="file" type="file" ref="file" enctype="multipart/form-data" multiple :key="fileInput">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" style="width:100%" :disabled="isActive">{{ button }}</button>
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
    data () {
        return {
            routePrefix: "/api/complex-care/",
            form_data: {
                nusrse: '',
                staff: '',
            },
            fileInput: 0,
            button: 'Submit',
            isActive: false,
        }
    },
    methods: {
        submitForm() {
            if (!this.form_data.nurse || !this.form_data.staff) {
                return this.$root.notification("Please make sure you have filled out all fields", "error");
            }
            // De-activate submit button
            this.isActive = true;
            this.button = "Submitting";

            // Handles a change on the file upload
            this.upload = this.$refs.file.files;

            // Initialize the form data
            let formData = new FormData();
            formData.append('nurse', this.form_data.nurse);
            formData.append('staff', this.form_data.staff);

            // Check a file has been chosen
            for (var count = 0; count < this.upload.length; count++) {
                // Add the form data
                formData.append("files[]", this.upload[count]);
            }
            // Post data
            axios.post(this.routePrefix + "submit", formData,
            {
                header: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                this.isActive = false
                this.button = 'Submit'
                this.$root.notification(response.data.message, "success");
                this.resetForm();
            })
            .catch(error => {
                this.$root.notification(error.response.data.message, "error");
                this.isActive = false
                this.button = 'Submit'
            })
        },
        resetForm() {
            Object.assign(this.$data, this.$options.data.call(this));
            this.fileInput++;
        }
    }
}
</script>