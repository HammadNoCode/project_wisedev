<template>
    <div class="content">
        <div class="row mb-3">
            <div class="col-xs-6 col-sm-6 col-md my-1">
                <h3 class="h3 font-w500 mt-2 mb-0">
                    Staff IP Access
                </h3>
            </div>
            <div class="col-xs-6 col-sm-6 col-md my-1 ">
            <div class="text-right">
                <a class="btn btn-sm btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-block-fadein">
                    Authorise IP
                </a>
            </div>
                <!-- Fade In Block Modal -->
                <div class="modal fade" id="modal-block-fadein" tabindex="-1" role="dialog" aria-labelledby="modal-block-fadein" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="block block-themed block-transparent mb-0">
                                <div class="block-header bg-primary-dark">
                                    <h3 class="block-title">Authorise IP</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                            <i class="fa fa-fw fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <div class="alert alert-danger" v-if="errors">{{errors}}</div>
                                    <div class="alert alert-success" v-if="success">IP address has been successfully authorized.</div>
                                    <form @submit.prevent="CreateIP">

                                        <div class="form-group">

                                            <label>Active Staff</label>
                                            <v-select :options="ActiveStaff.map(g => ({label: g.name, value: g.id}))"
                                                      v-model="fields.IdData"/>
                                          </div>
                                        <div class="form-group">
                                            <label>IP</label>
                                            <input class="form-control" type="text" placeholder="Enter IP" v-model="fields.IP"/>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" style="width: 100%;">Create</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Fade In Block Modal -->

                <!--      <b-button v-b-modal.modal-ip>Authorise IP</b-button>
                <b-modal id="modal-ip" centered title="Authorise IP Access" hide-footer="true" > -

                </b-modal> -->

            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <table class="table table-vcenter table-borderless js-appear-enabled animated fadeIn">
                            <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Last Login</th>
                                <th>User IP</th>
                                <th>IP Status</th>
                                <th class="text-center" style="width: 100px;"></th>
                                <th class="text-center" style="width: 100px;"></th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <tr v-for="dt in dt.user" v-bind:key="dt.cc">
                                <td>{{ dt.name }} </td>
                                <td>
                                    <em>{{ dt.ltlg }}</em>
                                </td>
                                <td>

                                    <input type="text" name="user_ip" v-model="dt.ip" style="width: 70%;">
                                    <button
                                        type="submit"
                                        class="btn btn-alt-primary"
                                        data-original-title="Approve"
                                        v-on:click="IpUpdate(dt.cc,dt.ip)"
                                        >
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
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
                                            v-on:click="ActId(dt.cc)"
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
                                            v-on:click="dtyAct(dt.cc)"
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

        this.loadAllUsers();
        this.getActiveUserName();

    },

    computed: {
        usr: function() {
            return this.$store.state.user;

        },
    },

   data: function(){
       return{
       routePrefix: "/api/management/staff/",
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
        loadAllUsers: function(){
            axios.get(this.routePrefix + "access/get_all")
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

        getActiveUserName: function(){
            axios.get(this.routePrefix + "active/")
                .then((response)=>{
                    this.ActiveStaff = response.data;

                })
                .catch(function(error){

                });

        },
        CreateIP: function(){

            axios.post(this.routePrefix + "access/create_authorise_ip", {
                id:this.fields.IdData,
                ip:this.fields.IP,
            })

                .then((response)=>{
                    this.errors="";
                    this.fields.IdData="";
                    this.fields.IP="";
                    this.loadAllUsers();
                    this.testToast();
                    this.closePopUp();

                })
                .catch(error=>{
                    if(error.response.status == 401) {
                        this.errors = error.response.data.message;
                    }

                });

        },

        IpUpdate: function(id, ip){
            axios.post(this.routePrefix + "access/get_all/ip_update/" + id, {
                user_ip:ip
            })
                .then((response)=>{
                    this.loadAllUsers();
                    this.$root.notification(response.data.message, "success");

                })
                .catch(error => {
                    this.$root.notification(error.response.data.message, "error");
                });

        },
        dtyAct(id) {
            axios
                .delete(this.routePrefix + "access/ip_delete/" + id)
                .then(response => {
                    this.$root.notification(response.data.message, "success");
                    this.loadAllUsers();
                })
                .catch(error => {
                    this.$root.notification(error.response.data.message, "error");
                });
        },
        ActId(id) {
            axios
                .patch(this.routePrefix + "access/ip_active/" + id)
                .then(response => {
                    this.$root.notification(response.data.message, "success");
                    this.loadAllUsers();
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
