<template>
    <div>
        <div class="col-12 py-2">
            <div class="input-group">
                <div class="input-group-append">
                    <span class="input-group-text">Application Status</span>
                </div>
                <select class="form-control selectpicker" v-model="filters.status">
                    <option value="all">All</option>
                    <option v-for="(status, key) in statuses" :key="key">
                        {{ status }}
                    </option>
                </select>
            </div>
        </div>
        <div class="col-12 py-2">
            <div class="input-group">
                <div class="input-group-append">
                    <span class="input-group-text">Branch</span>
                </div>
                <select class="form-control selectpicker" v-model="filters.branch">
                    <option value="all">All</option>
                    <option v-for="(branch, key) in branches" :key="key + 1">
                        {{ branch }}
                    </option>
                </select>
            </div>
        </div>
        <div class="col-12 py-2">
            <div class="input-group">
                <div class="input-group-append">
                    <span class="input-group-text">Role</span>
                </div>
                <select class="form-control selectpicker" v-model="filters.role">
                    <option value="all">All</option>
                    <option v-for="(role, key) in roles" :key="key + 2">
                        {{ role }}
                    </option>
                </select>
            </div>
        </div>
        <div class="col-12 py-2">
            <div class="input-group">
                <div class="input-group-append">
                    <span class="input-group-text">Message Template's</span>
                </div>

                    <select class="form-control selectpicker" v-model="SelectedClass"><option v-for="author in temp" :value="author.id">{{author.template_name}}</option></select>

            </div>
        </div>
        <div class="col-12 py-2">
            <div class="form-group">
                                    <textarea
                                        type="text"
                                        name="Message"
                                        class="form-control"
                                        rows="5"
                                        placeholder="Please write massage here..."
                                        v-model="filters.section"
                                    ></textarea>
            </div>
        </div>
    </div>
</template>
<script>
import { ValidationProvider, ValidationObserver, extend } from "vee-validate";
import { required } from "vee-validate/dist/rules";
extend("required", {
    ...required,
    message: "{_field_} field is required",
});
export default {

    data: function () {
        return {
            temp:{},
            section:'',
            SelectedClass:'',
        }
    },

    computed: {
        filters: {
            get() {
                return this.$store.state.sms.filters;
            },
            set(newVal) {
                return (this.$store.state.sms.filters = newVal);
            },
        },
        statuses: function () {
            return this.$store.state.sms.statuses;
        },
        branches: function () {
            return this.$store.state.sms.branches;
        },
        roles: function () {
            return this.$store.state.sms.roles;
        },

    },

    watch:{
        SelectedClass: function(value){
            axios.post("/api/recruitment/communication/get_dp", {
                id:this.SelectedClass,
            })     .then((response)=>{
                this.filters.section = response.data.t_description;
            })
                .catch(error => {
                    this.$root.notification(error.response.data.message, "error");
                });
        }


    },
    mounted(){

        this.getTemp();

    },


    methods: {
        getTemp:function(){

            axios.get("/api/recruitment/communication/gt_temp")
                .then((response)=>{
                    this.temp = response.data;
                })
                .catch(error => {
                    this.$root.notification(error.response.data.message, "error");
                });

        },


    },


};


</script>
