<template>
    <div class="block block-rounded">
        <div class="block-content">
            <ValidationObserver v-slot="{ handleSubmit }">
                <form @submit.prevent="sendMsg">
                    <div class="form-row py-1">
                        <div class="col">
                            <h4 class="mb-0">Reference Invite Form</h4>
                        </div>
                    </div>
                    <hr />
                    <div class="form-row">
                        <div class="col-md-6 col">
                            <div class="form-group">
                                <label>Templates</label>
                                <ValidationProvider rules="required" v-slot="{ errors }" >
                                    <select class="form-control" v-model="SelectedClass"><option v-for="author in temp" :value="author.id">{{author.template_name}}</option></select>
                              <!--      <v-select :options="temp.map(data => ({label: data.template_name, value: data.t_description}))"
                                              v-model="blog.MDT"/> <p class="text-danger">{{ errors[0] }}</p> -->
                                </ValidationProvider>
                            </div>
                        </div>
                        <div class="col-md-6 col">
                            <div class="form-group">
                                <label>Telephone No.</label>
                                <ValidationProvider rules="required" v-slot="{ errors }">
                                    <input
                                        type="text"
                                        name="Telephone"
                                        class="form-control"
                                        v-model="applicant.mobile"
                                    />
                                    <p class="text-danger">{{ errors[0] }}</p>
                                </ValidationProvider>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 col">
                            <div class="form-group">
                                <label>Message</label>
                                <ValidationProvider rules="required" v-slot="{ errors }">

                                    <textarea
                                        type="text"
                                        name="Message"
                                        class="form-control"
                                        rows="5"
                                        v-model="section.t_description"
                                    ></textarea>
                                    <p class="text-danger">{{ errors[0] }}</p>
                                </ValidationProvider>
                            </div>
                        </div>

                    </div>
                    <div class="form-row py-3">
                        <div class="col">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-paper-plane pr-2"></i>Send Invite
                            </button>
                        </div>
                    </div>
                </form>
            </ValidationObserver>
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
name: "Communication.vue",
    mounted(){

        this.getTemp();

    },

    computed: {
        applicant: function () {
            return this.$parent.applicant;
        },
    },


        data: function () {
        return {
            current_id:this.$route.params.id,
            fields:{},
            temp:{},
            blog:{},
            section:'',
            SelectedClass:'',
        }
    },

    watch:{
        SelectedClass: function(value){
            axios.post("/api/recruitment/communication/get_dp", {
                id:this.SelectedClass,
            })     .then((response)=>{
                    this.section = response.data;

            })
                .catch(error => {
                    this.$root.notification(error.response.data.message, "error");
            });
}

    },

    methods:{

        getTemp:function(){

            axios.get("/api/recruitment/communication/gt_temp")
                .then((response)=>{
                    this.temp = response.data;
                })
                .catch(error => {
                    this.$root.notification(error.response.data.message, "error");
                });

        },



        sendMsg:function(){
            axios.post("/api/recruitment/communication/sendMsg", {
                number:this.applicant.mobile,
                msg:this.section.t_description,
            })
                .then((response)=>{
                    this.$root.notification(response.data.message, "success");

                })
                .catch(error => {
                    this.$root.notification(error.response.data.message, "error");
                });

           },


    }


}
</script>

<style scoped>

textarea {
    resize: both;
    overflow: auto;
}

</style>
