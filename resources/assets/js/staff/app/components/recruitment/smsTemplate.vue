<template>
    <div class="content">
        <div class="row mb-3">
            <div class="col-xs-6 col-sm-6 col-md my-1">
                <h3 class="h3 font-w500 mt-2 mb-0">
                    SMS Template's
                </h3>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-xs-6 col-sm-6 col-md my-1 ">
                <form @submit.prevent="CreateTmp">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                          <span class="input-group-text">
                            Template Name
                          </span>
                            </div>
                            <input type="text" class="form-control" id="template_name"  v-model="fields.t_name" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                      <!--  <label for="template_description">Template Description</label> -->
                        <textarea class="form-control" id="template_description" rows="3" v-model="fields.text" placeholder="Enter Template Description..."></textarea>
                    </div>
                    <div class="text-right">
                    <button type="submit" class="btn btn-primary">Create New Template</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <table class="table table-vcenter table-borderless js-appear-enabled animated fadeIn">
                            <thead class="thead-light">
                            <tr>
                                <th>Template Name</th>
                                <th>Template Description</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 50px;"></th>
                                <th class="text-center" style="width: 50px;"></th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <tr v-for="dt in dt.user" v-bind:key="dt.id">
                                <td>{{ dt.template_name }} </td>
                                <td>
                                    <em>{{ dt.t_description }}</em>
                                </td>
                                <td>
                                    <em v-if="dt.deleted_at == '0'"> Active</em>
                                    <em v-else> Deactivated</em>

                                </td>
                                <td class="text-center">
                                    <div
                                        class="btn-group"
                                        v-if="dt.id !== usr.id || dt.manager === 1"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-alt-primary"
                                            data-original-title="Approve"
                                            v-on:click="activTemp(dt.id)"
                                        >
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div
                                        class="btn-group"
                                        v-if="dt.id !== usr.id || dt.manager === 1"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-danger"
                                            data-original-title="Approve"
                                            v-on:click="dtyAct(dt.id)"
                                        >
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="bg-light" v-show="dt.total_pages > 1">
                            <div class="row">
                                <div class="col">
                                    <div class="float-left">
                                        <div class="ml-4 mt-3 text">
                                            <small>
                                                Page {{ dt.current_page }} of
                                                {{ dt.total_pages }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="float-right">
                                        <div
                                            class="dataTables_paginate paging_full_numbers px-2"
                                            id="DataTables_Table_2_paginate"
                                        >
                                            <ul class="pagination">
                                                <li
                                                    class="paginate_button page-item"
                                                    v-for="i in dt.total_pages"
                                                    :key="i"
                                                    v-show="
                            i - dt.current_page <= 4 &&
                              i - dt.current_page >= -4
                          "
                                                >
                                                    <a
                                                        class="page-link mt-3 mr-2 btn btn-sm"
                                                        :class="{
                              active: dt.current_page == i,
                              'text-muted': dt.current_page != i,
                            }"
                                                        v-on:click.prevent="changePage(i)"
                                                    >{{ i }}</a>
                                                </li>
                                            </ul>
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
import Vue from 'vue'
import vSelect from 'vue-select'

Vue.component('v-select', vSelect)
export default {
    mounted(){

        this.loadAllTemp();


    },

    computed: {
        usr: function() {
            return this.$store.state.user;

        },
    },

    data: function(){
        return{
            ActiveStaff:[],
            fields:[],
            errors:[],
            active:{},
            success: false,
            selected:'',
            dt: {
                current_page: 1,
                items_per_page: 8,
                total_pages: 0,
                total_items: 0,
                user:[],
            }
        }
    },

    watch: {
        active: function(newVal) {
            this.assignData();
        }
    },

    methods:{
        loadAllTemp: function(){
            axios.get('/api/recruitment/smstemplate/gettmp')
                .then((response)=>{
                    this.errors="";
                    this.active = response.data;
                })
                .catch(function(error){
                });

        },

        testToast() {
            this.success = true;
            setTimeout(() => {
                this.success = false
            }, 3000)
        },

        CreateTmp: function(){

            axios.post("/api/recruitment/smstemplate/createNtemp", {
                t_name:this.fields.t_name,
                t_descp:this.fields.text,
            })

                .then((response)=>{
                    this.errors="";
                    this.fields.t_name="";
                    this.fields.text="";
                    this.loadAllTemp();
                    this.$root.notification(response.data.message, "success");
                  //  this.testToast();
                  //  this.closePopUp();

                })
                .catch(error => {
                    this.$root.notification(error.response.data.message, "error");
                });
                //.catch(error=>{
                //    if(error.response.status == 401) {
                //        this.errors = error.response.data.message;
                //    }

               // });

        },

        activTemp: function(id){
            axios.post("/api/recruitment/smstemplate/actvtmp/" + id)
                .then((response)=>{
                    this.loadAllTemp();
                    this.$root.notification(response.data.message, "success");

                })
                .catch(error => {
                    this.$root.notification(error.response.data.message, "error");
                });

        },
        dtyAct(id) {
            axios
                .delete("/api/recruitment/smstemplate/dty/" + id)
                .then(response => {
                    this.$root.notification(response.data.message, "success");
                    this.loadAllTemp();
                })
                .catch(error => {
                    this.$root.notification(error.response.data.message, "error");
                });
        },

        assignData() {
            if (this.active.length) {
                this.dt.user = this.active.slice(
                    (this.dt.current_page - 1) * this.dt.items_per_page,
                    this.dt.current_page * this.dt.items_per_page
                );
                this.dt.total_items = this.active.length;
                this.dt.total_pages = Math.ceil(
                    this.active.length / this.dt.items_per_page
                );
            }
        },
        changePage(current_page) {
            event.preventDefault();
            this.dt.current_page = current_page;
            this.assignData();
        },


        closePopUp() {

            setTimeout(function() {
                $('#modal-block-fadein').removeClass('show');
                $('.modal-backdrop').removeClass('show');

            }, 2000);


        },





    }

}
</script>
