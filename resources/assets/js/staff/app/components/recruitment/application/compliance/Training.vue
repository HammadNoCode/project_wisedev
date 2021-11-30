<template>
    <div>
        <div class="row py-3">
            <div class="col-12">
                <div class="alert alert-info alert-dismissable" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <p class="mb-0">Make sure before any issue date or renewal dates have been inputted the checkbox to the left is checked</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="progress push mb-3" style="border-radius: 5rem">
                    <div
                        class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                        role="progressbar"
                        aria-valuenow="100"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        :style="{ width: progress + '%' }"
                        style="border-radius: 5rem"
                    >
                        <span class="font-size-sm font-w600">{{ progress }}%</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12 text-right">
                <button class="btn btn-success" @click="autoFillRenewal">Auto Fill Renewal</button>
            </div>
        </div>
        <div class="block block-rounded block-fx-pop mt-2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive" v-if="loaded">
                        <table class="table table-hover table-vcenter table-borderless table-striped js-appear-enabled animated fadeIn">
                            <thead class="thead-light">
                                <tr>
                                    <th>Training Course</th>
                                    <th class="text-center">Required</th>
                                    <th class="text-center">Checked</th>
                                    <th>Issue Date</th>
                                    <th>Renewal Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr v-for="(training, key) in documents.data" v-bind:key="key">
                                    <td :class="{expired: Date.now() > new Date(training.renewal_date) || training.renewal_date == null}">
                                        {{ training.name }}
                                    </td>
                                    <td>{{ training.required | isRequired }}</td>
                                    <td>
                                        <input type="checkbox" class="form-control" size="lg" v-model="training.checked" @click="toggleCheckbox(training.id, key)"/>
                                    </td>
                                    <td>
                                        <input name="Issue date" type="date" class="form-control" v-model="training.issue_date" @change="update(training)"/>
                                    </td>
                                    <td>
                                        <input name="Renewal date" type="date" class="form-control" v-model="training.renewal_date" @change="update(training)"/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <upload />
        </div>
    </div>
</template>
<script type="text/javascript">
import Upload from "./Upload";

export default {
    computed: {
        applicant: function () {
            return this.$parent.applicant;
        },
        DocumentsCount: function () {
            return _.size(this.documents.data);
        },
        progress: function (data) {
            var checked = 0;
            var trainingData = data;
            var newData = trainingData.documents.data;
            Object.keys(newData).forEach((doc) => {
                checked += newData[doc].checked;
            });
            var percent = (100 / newData.length) * checked;
            return percent.toFixed(2);
        },
    },
    components: {
        Upload,
    },
    data: function () {
        return {
            routePrefix: "/api/recruitment/compliance/",
            documents: {
                data: {},
            },
            images: {
                data: {},
            },
            loaded: false,
            edit: false,
            disabled: false,
        };
    },
    mounted() {
        this.show();
        this.getDocuments();
    },
    methods: {
        show() {
            axios.get("/api/recruitment/compliance/upload/training/" + this.$route.params.id)
            .then((response) => {
                this.images.data = response.data;
            })
            .then(() => {
                this.loaded = true;
            })
            .catch((error) => {
                console.log(error);
            });
        },
        getDocuments() {
            axios.get(this.routePrefix + "training/" + this.$route.params.id)
            .then((response) => {
                this.documents.data = response.data;
            })
            .then(() => {
                this.loaded = true;
            });
        },
        toggleCheckbox(id, key) {
            if (this.documents.data[key].checked == true) {
                this.destroy(id);
            } else {
                this.store(id);
            }
        },
        store(id) {
            axios.post(this.routePrefix + this.$route.params.id + "/" + id, this.documents, this.applicant)
            .then((response) => {
                this.success = true;
                this.$root.notification(response.data.message, "success");
            })
            .catch((error) => {
                this.message = "Oops, an error occurred!";
                this.$root.notification(error.response.data.message, "error");
            });
        },
        update(document) {
            axios.patch(this.routePrefix + this.$route.params.id + "/" + document.id, document)
            .then((response) => {
                this.$root.notification(response.data.message, "success");
            })
            .catch((error) => {
                this.$root.notification(error.response.data.message, "error");
            })
            .then(() => {
                this.getDocuments();
            });
        },
        destroy(id) {
            axios.delete(this.routePrefix + this.$route.params.id + "/" + id)
            .then((response) => {
                this.$root.notification(response.data.mesaage, "success");
            })
            .catch((error) => {
                this.$root.notification(error.response.data.message, "error");
            })
            .then(() => {
                this.getDocuments();
            });
        },
        autoFillRenewal() {
            axios.get(this.routePrefix + "renewals/" + this.$route.params.id)
            .then(response => {
                this.$root.notification(response.data.message, "success")
            })
            .then(() => {
                this.getDocuments();
            })
        }
    },
};
</script>
<style lang="scss">
.expired {
  color: rgb(224, 79, 26);
}
</style>
