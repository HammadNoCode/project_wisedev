<template>
    <div class="content">
        <div>
        <div class="row mb-3">
            <div class="col-xs-6 col-sm-6 col-md my-1">
                <h3 class="h3 font-w500 mt-2 mb-0">
                    SMS Log
                </h3>
            </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <table class="table table-vcenter table-borderless js-appear-enabled animated fadeIn">
                            <thead class="thead-light">
                            <tr>
                                <th>Batch ID</th>
                                <th>Message</th>
                                <th>Reciepent</th>
                                <th>Status</th>

                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <tr v-for="dt in dt.user" v-bind:key="dt.cc">
                                <td>{{ dt.batch_id }} </td>
                                <td>
                                    <em>{{ dt.message }}</em>
                                </td>
                                <td class="text-center">
                                    <em>{{ dt.recipient }}</em>
                                </td>
                                <td>
                                    <em>{{ dt.status }}</em>
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
export default {
    mounted(){

        this.loadAllUsers();


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
            axios.get('/api/recruitment/smstemplate/getlog')
                .then((response)=>{
                    this.errors="";
                    this.active = response.data;

                })
                .catch(function(error){
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




    }

}
</script>
