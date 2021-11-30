<template>
    <div>
        <div class="row mt-5">
            <div class="col-12">
                <form action="be_blocks_forms.html" method="POST" data-bitwarden-watching="1">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Create Note</h3>
                        <div class="block-options">
                            <button type="button" class="btn btn-sm btn-primary float-right" @click="createNote">
                                <i class="fa fa-fw fa-check"></i> Save
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center py-1">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea type="text" name="note" rows="3" class="form-control" placeholder="Type note here ..." v-model="application.note"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Notes</h3>
                    </div>
                    <div class="block-content py-3">
                        <table class="table table-bordered table-vcenter" v-if="datatable.data.length">
                            <thead>
                                <tr>
                                    <th>Notes</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(notes, key) in datatable.data" :key="key">
                                    <td :width="100 / 2 + '%'">{{ notes.notes }}</td>
                                    <td :width="100 / 5 + '%'">{{ notes.staff_id }}</td>
                                    <td :width="100 / 5 + '%'">{{ notes.created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-else class="text-center py-5">
                            <h4 class="text-muted">No data found</h4>
                        </div>
                    </div>
                    <div class="block-content block-content-full block-content-sm bg-body-light">
                        <div>
                            <pagination />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Pagination from '../../../layout/tables/Pagination';
export default {
    data: function () {
        return {
            routePrefix: "/api/recruitment/notes/",
            application: {},
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
            axios.post(this.routePrefix + "create/" + this.$route.params.id, this.application)
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
            var route = this.routePrefix + "read/" + this.$route.params.id + "/?";
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
    }
}
</script>