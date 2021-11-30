<template>
    <div>
        <div class="row">
            <div class="col-12">
                <form action="be_blocks_forms.html" data-bitwarden-watching="1" id="audit_upload">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="h4 my-auto">Audit Upload Form</h3>
                        </div>
                        <div class="block-content">
                            <div class="row justify-content-center py-2">
                                <div class="col-sm-10 col-md-9">
                                    <div class="form-group input-group inpug-group-lg">
                                        <div class="input-group-prepend">
                                            <span id="basic-addon1" class="input-group-text mb-1">Select Audit Group</span>
                                        </div> 
                                        <select class="form-control selectpicker mb-1" v-model="template.group">
                                            <option selected disabled>Select a Template Type</option>
                                            <option v-for="(group, key) in groups" :key="key" :value="group.id">{{ group.name }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input
                                            id="file"
                                            class="form-control"
                                            type="file"
                                            ref="file"
                                            enctype="multipart/form-data"
                                            multiple
                                        />
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-1">
                                            <small>(Make sure only <b>numbers</b> are inputted in the fields below <b>(No other characters)</b>)</small>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group input-group inpug-group-lg">
                                                <div class="input-group-prepend">
                                                    <span id="basic-addon1" class="input-group-text">Input Audit Weight</span>
                                                </div> 
                                                <input class="form-control" type="text" v-model="template.weight"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group input-group inpug-group-lg">
                                                <div class="input-group-prepend">
                                                    <span id="basic-addon1" class="input-group-text">Audit Max Score</span>
                                                </div> 
                                                <input class="form-control" type="text" v-model="template.max_score"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-sm bg-body-light">
                            <div class="row">
                                <div class="col-12">
                                    <button type="reset" class="text-left btn btn-danger btn-sm">
                                        <i class="fas fa-history pr-1"></i>Reset
                                    </button>
                                    <button type="button" class="float-right btn btn-success btn-sm" @click="store">
                                        <i class="fa fa-check"></i> Create
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    computed: {
        groups: function() {
            return this.$parent.groups;
        },
    },
    data: function(){
        return {
            routePrefix: "/api/compliance-staff/template/upload/",
            template: {},
        }
    },
    methods: {
        store() {
            this.upload = this.$refs.file.files;
            let formData = new FormData();
            formData.append('weight' ,this.template.weight);
            formData.append('max_score' ,this.template.max_score);
            for (var count = 0; count < this.upload.length; count++) {
                formData.append("files[]", this.upload[count],);
            }
        axios
            .post(this.routePrefix + "image/" + this.template.group,
            formData,
                {
                    headers: {
                    "Content-Type": "multipart/form-data",
                    },
                })
            .then((response) => {
                this.$root.notification("Image uploaded", "success");
                console.log("passed");
            })
            .catch((error) => {
                this.$root.notification(error.response.data.message, "error")
                })
            .then(() => {
                this.$parent.show();
                this.$parent.newTemplate = false;
            });
        },
    }
}
</script>