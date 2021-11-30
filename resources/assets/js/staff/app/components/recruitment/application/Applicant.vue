<template>
    <div>
        <div class="row my-2 d-block d-md-none">
            <div class="col-12">
                <div role="group" aria-label="1" class="btn-group btn-block">
                    <button 
                        :class="{ active: tab == 'application' }"
                        @click="tab = 'application'"
                        class="btn btn-light" 
                    >
                        <i class="far fa-file-alt pr-2"></i>Application
                    </button>
                    <button 
                        :class="{ active: tab == 'employment' }"
                        @click="tab = 'employment'"
                        class="btn btn-light" 
                    >
                        <i class="fas fa-history pr-2"></i>Employment History
                    </button>
                </div>
            </div>
            <div class="col-12">
                <div role="group" aria-label="1" class="btn-group btn-block">
                    <button 
                        :class="{ active: tab == 'notes' }"
                        @click="tab = 'notes'"
                        class="btn btn-light" 
                    >
                        <i class="fas fa-pencil-alt pr-2"></i>Notes
                    </button>
                    <button 
                        :class="{ active: tab == 'profile' }"
                        @click="tab = 'profile'"
                        class="btn btn-light" 
                    >
                        <i class="far fa-user-circle pr-2"></i>Profile
                    </button>
                </div>
            </div>
        </div>
        <div class="row my-2 d-none d-md-block">
            <div class="col-12">
                <div role="group" aria-label="1" class="btn-group btn-block">
                    <button 
                        :class="{ active: tab == 'application' }"
                        @click="tab = 'application'"
                        class="btn btn-light" 
                    >
                        <i class="far fa-file-alt pr-2"></i>Application
                    </button>
                    <button 
                        :class="{ active: tab == 'employment' }"
                        @click="tab = 'employment'"
                        class="btn btn-light" 
                    >
                        <i class="fas fa-history pr-2"></i>Employment History
                    </button>
                    <button 
                        :class="{ active: tab == 'notes' }"
                        @click="tab = 'notes'"
                        class="btn btn-light" 
                    >
                        <i class="fas fa-pencil-alt pr-1"></i>Notes
                    </button>
                    <button 
                        :class="{ active: tab == 'profile' }"
                        @click="tab = 'profile'"
                        class="btn btn-light" 
                    >
                        <i class="far fa-user-circle pr-2"></i>Profile
                    </button>
                </div>
            </div>
        </div>
        <div v-if="tab == 'application'">
            <application />
        </div>
        <div v-if="tab == 'profile'">
            <profile />
        </div>
        <div v-if="tab == 'employment'">
            <employment />
        </div>
        <div v-if="tab == 'notes'">
            <notes />
        </div>
    </div>
</template>
<script>
import Application from "./details/Application";
import Profile from "./details/Profile";
import Employment from "./details/Employment";
import Notes from "./details/Notes";

export default {
    components: {
        Application,
        Profile,
        Employment,
        Notes,
    },
    computed: {
        applicant: function() {
            return this.$parent.applicant;
        },
        employment: function() {
            return this.$parent.employment;
        },
        currentTab: function() {
            return this.$parent.currentTab;
        }
    },
    data: function() {
        return {
            tab: "application",
            edit: false,
            disabled: false
        };
    },
    methods: {
        update(applicant) {
            this.$refs.update.update(applicant);
        }
    }
};
</script>
<style scoped>
button {
    border-bottom-left-radius: 0px !important;
    border-bottom-right-radius: 0px !important;
}
.btn-light:hover {
    color: #212529;
    background-color: #e1effe;
    border-color: #e1effe;
}
</style>
