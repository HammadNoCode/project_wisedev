<template>
    <div>
        <div class="row mt-3">
            <div class="col-lg-4 col-12">
                <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
                    <div class="block-content block-content-full tab-content">
                        <div class="row py-1">
                            <div class="col-12 my-auto">
                                <h5 class="mb-0">Create Note</h5>
                            </div>
                        </div>
                        <hr>
                        <div class="row py-2">
                            <div class="col-12">
                                <textarea type="text" name="note" rows="5" class="form-control" placeholder="Type note here ..." v-model="carehome.note"/>
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-12 ml-auto">
                                <button type="button" class="btn btn-sm btn-primary float-right" @click="createNote">
                                    <i class="fa fa-fw fa-check"></i> Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-12">
                <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
                    <div class="block-content block-content-full tab-content">
                        <div class="row py-2">
                            <div class="col-md-10 col-12 my-auto">
                                <h5 class="mb-0">Notes</h5>
                            </div>
                        </div>
                        <hr>
                        <div class="row" v-if="datatable.data.length > 0">
                            <div class="col-12">
                                <div class="py-2 px-2 my-2 bg-light" v-for="(note, key) in datatable.data" :key="key">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="mb-0">
                                                <span class="text-primary">{{ note.staff_id }}</span>
                                                <small class="ml-1">on</small>
                                                <small class="ml-1">{{ note.created_at }}</small>
                                            </h6>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" name="button" class="btn btn-sm" @click="destroy(note.id)">
                                                <i class="fas fa-trash-alt text-danger"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="mb-0">{{ note.notes }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-5" v-else>
                            <h4 class="text-center text-muted mb-0">No notes found</h4>
                        </div>
                    </div>
                    <pagination/>
                </div>  
            </div>
        </div>
    </div>
</template>
<script>
import Pagination from '../../layout/tables/Pagination';
export default {
    data: function () {
        return {
            routePrefix: "/api/carehome/notes/",
            carehome: {},
            datatable: {
                data: {},
                current_page: 1,
                per_page: 15,
                last_page: 0,
                total: 1,
            },
            edit: false,
            disabled: false,
        };
    },
    components: {
        Pagination,
    },
    mounted() {
        if (this.$route.query.page) {
            this.datatable.current_page = this.$route.query.page;
        }
        this.readNotes(this.datatable.current_page);
    },
    methods: {
        createNote() {
            axios.post(this.routePrefix + this.$route.params.id, this.carehome)
            .then(response => {
                this.$root.notification(response.data.message, "success");
            })
            .then(response => {
                this.readNotes()
            })
            .catch(error => {
                this.$root.notification(error.response.data.message, "error");
            })
        },
        readNotes(page) {
            var route = this.routePrefix + this.$route.params.id + "/?";
            route += "page=" + page;
            this.$router.push({
                query: {
                    page: page,
                }
            })
            .catch((err) => {});
            axios.get(route)
            .then(response => {
                this.datatable = response.data
            })
            .catch(error => {
                console.log(error)
            })
        },
        changePage(current_page) {
            if (current_page <= this.datatable.last_page && current_page > 0) {
                this.datatable.current_page = current_page;
                this.readNotes(current_page);
            }
        },
        destroy(id) {
            axios.delete(this.routePrefix + id)
            .then(response => {
                this.$root.notification(response.data.message, "success");
            })
            .catch(error => {
                this.$root.notification(error.response.data.message, "error");
            })
            .then(() => {
                this.readNotes();
            });
        },
    }
}
</script>