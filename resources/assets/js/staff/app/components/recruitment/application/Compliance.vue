<template>
    <div>
        <div class="d-none d-md-block">
            <div class="row my-2">
                <div class="col-12">
                    <div role="group" aria-label="1" class="btn-group btn-block">
                        <button :class="{ active: tab == 'document' }" @click="tab = 'document'" class="btn btn-light" >
                            <i class="fas fa-check-square pr-2"></i>Document
                        </button>
                        <button :class="{ active: tab == 'training' }" @click="tab = 'training'" class="btn btn-light" >
                            <i class="fas fa-check-square pr-2"></i>Training
                        </button>
                        <button :class="{ active: tab == 'details' }" @click="tab = 'details'" class="btn btn-light" >
                            <i class="far fa-file-alt pr-2"></i>Details
                        </button>
                        <button :class="{ active: tab == 'notes' }" @click="tab = 'notes'" class="btn btn-light" >
                            <i class="fas fa-pencil-alt pr-2"></i>Notes
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-block d-md-none">
            <div class="row py-1">
                <div class="col-12 py-1">
                    <div role="group" aria-label="1" class="btn-group btn-block">
                        <button :class="{ active: tab == 'document' }" @click="tab = 'document'" class="btn btn-light" >
                            <i class="fas fa-check-square pr-2"></i>Document
                        </button>
                        <button :class="{ active: tab == 'training' }" @click="tab = 'training'" class="btn btn-light" >
                            <i class="fas fa-check-square pr-2"></i>Training
                        </button>
                    </div>
                </div>
            </div>
            <div class="row py-1">
                <div class="col-12 py-1">
                    <div role="group" aria-label="1" class="btn-group btn-block">
                        <button :class="{ active: tab == 'details' }" @click="tab = 'details'" class="btn btn-light" >
                            <i class="far fa-file-alt pr-2"></i>Details
                        </button>
                        <button :class="{ active: tab == 'notes' }" @click="tab = 'notes'" class="btn btn-light" >
                            <i class="fas fa-pencil-alt pr-2"></i>Notes
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="tab == 'document'">
            <document />
        </div>
        <div v-if="tab == 'training'">
            <training />
        </div>
        <div v-if="tab == 'details'">
            <all-details />
        </div>
        <div v-if="tab == 'notes'">
            <notes />
        </div>
    </div>
</template>
<script>
import Document from "./compliance/Document";
import Training from "./compliance/Training";
import AllDetails from "./compliance/Details";
import Notes from "./compliance/Notes";

export default {
    components: {
        Document,
        Training,
        AllDetails,
        Notes,
    },
    computed: {
        applicant: function () {
            return this.$parent.applicant;
        },
        employment: function () {
            return this.$parent.employment;
        },
        currentTab: function () {
            return this.$parent.currentTab;
        },
    },
  data: function () {
        return {
            tab: "document",
            edit: false,
            disabled: false,
        };
  },
    methods: {
        update(applicant) {
            this.$refs.update.update(applicant);
        },
    },
};
</script>
<style scoped>
.btn-light:hover {
    color: #212529;
    background-color: #e1effe;
    border-color: #e1effe;
}
button {
  border-bottom-left-radius: 0px !important;
  border-bottom-right-radius: 0px !important;
}
</style>
