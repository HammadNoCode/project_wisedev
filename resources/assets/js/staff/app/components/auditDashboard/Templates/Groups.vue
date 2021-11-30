<template>
    <div>
        <div class="row mb-3" v-if="complianceManager">
            <div class="col-12">
                <button class="btn btn-success btn-sm float-right" v-show="!newGroup" @click="newGroup = true">Show Create Group Form</button>
                <button class="btn btn-danger btn-sm float-right" v-show="newGroup" @click="newGroup = false">Hide</button>
                <button class="btn btn-success btn-sm float-right mr-4" v-show="!newTemplate && groupCount > 0" @click="newTemplate = true">Show Upload Template Form</button>
                <button class="btn btn-danger btn-sm float-right mr-4" v-show="newTemplate && groupCount > 0" @click="newTemplate = false">Hide</button>
            </div>
        </div>
        <div class="row" v-if="newGroup == true"> 
            <div class="col-12">
                <create/>
            </div>
        </div>
        <div class="row" v-if="newTemplate == true">
            <div class="col-12">
                <upload/>
            </div>
        </div>
        <form action="be_blocks_forms.html" data-bitwarden-watching="1">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="h4 my-auto">Audits</h3>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center py-3">
                        <div class="col-md-7 col-12 mb-2">
                            <div class="form-group">
                                <label for="block-form7-username">Please select an audit group to access the audit templates</label>
                                <select class="form-control" v-model="filter" @change="filterAudits(1)">
                                    <option value="all" disabled>Select Audit</option>
                                    <option v-for="(group, key) in groups" :key="key" :value="group.id">{{ group.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-12 my-auto" v-show="complianceManager">
                            <div class="form-group text-right mb-0">
                                <button type="button" class="btn btn-danger btn-sm form-control" @click="destroyAlert(filter)">Delete Group</button>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-9">
                            <div class="form-group">
                                <div class="table-responsive" v-if="templateCount > 0">
                                    <table class="table table-hover table-vcenter table-striped table-bordered js-appear-enabled animated fadeIn" >
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th class="text-center">Weight</th>
                                                <th class="text-center">Max Score</th>
                                                <th v-show="complianceManager"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(audit, key) in audits" :key="key">
                                                <td>
                                                    <a :href="'/api/compliance-staff/template/upload/get/' + audit.filename" target="_blank">
                                                       {{ audit.display_name }}
                                                    </a>
                                                </td>
                                                <td class="text-center">{{ audit.weight }}%</td>
                                                <td class="text-center">{{ audit.max_score }}</td>
                                                <td class="text-center" v-show="complianceManager">
                                                    <button type="button" class="btn btn-danger btn-sm" @click="destroyAuditAlert(audit.id)">Delete</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div v-else class="text-center p-5">
                                    <span class="h4">No audits have yet been uploaded for this group</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
import Create from "./Groups/Create";
import Upload from "./Audits/Upload";

export default {
    computed: {
        complianceManager: function () {
            return this.$store.state.user.compliance_manager == 1 ? true : false;
        },
        groupCount: function () {
            return _.size(this.groups);
        },
        templateCount: function () {
            return _.size(this.audits);
        },
    },
    data: function() {
        return {
            routePrefix: "/api/compliance-staff/template/",
            filter: "all",
            audits: {},
            templates: {},
            template: {},
            groups: {},
            newTemplate: false,
            newGroup: false,
        }
    },
    components: {
        Create,
        Upload,
    },
    watch: {
        filter: function(val) {
            this.show(1);
        }
    },
    mounted() {
        if (this.$route.query.filter) {
            this.filter = this.$route.query.filter;
        }
        this.show(this.filter);
        this.showGroups();
    },
    methods: {
        showGroups() {
        axios
            .get(this.routePrefix + "group/get")
            .then((response) => {this.groups = response.data})
            .then(() => {this.loaded = true})
            .catch((error) => {console.log(error)});
        },
        show(filter) {
            var route = this.routePrefix + "group/" + "?";
            route += "filter=" + this.filter;
            this.$router.push({
                query: {
                    filter: this.filter,
                },
            })
            .catch((error) => {})
            axios
                .get(route)
                .then((response) => {this.audits = response.data})
        },
        filterAudits() {
            this.$router.push({
                query: {
                    filter: this.filter,
                },
            });
            this.show(this.filter);
        },
        destroyAlert(id) {
        this.$swal
            .fire({
                title: "Delete Audit Group",
                text: "Are you sure you would like to delete this audit group?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#39AEAC",
                cancelButtonColor: "#495057",
                confirmButtonText: "Yes",
            })
            .then((result) => {
                if (result.value) {this.destroy(id)}
            });
        },
        destroy(filter) {
        axios
            .delete(this.routePrefix + "group/" + filter)
            .then(response => {this.$root.notification(response.data.message, "success")})
            .catch(error => {this.$root.notification(error.response.data.message, "error")})
            .then(() => {this.showGroups()})
            .then(() => {this.show()})
        },
        destroyAuditAlert(id) {
        this.$swal
            .fire({
                title: "Soft Delete Audit",
                text: "Are you sure you would like to soft delete this audit?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#39AEAC",
                cancelButtonColor: "#495057",
                confirmButtonText: "Yes",
            })
            .then((result) => {
                if (result.value) {this.destroyAudit(id)}
            });
        },
        destroyAudit(id) {
        axios
            .delete(this.routePrefix + "audit/" + id)
            .then(response => {this.$root.notification(response.data.message, "success")})
            .catch(error => {this.$root.notification(error.response.data.message, "error")})
            .then(() => {this.showGroups()})
            .then(() => {this.show()})
        },
        clear(id) {
            axios
            .delete(this.routePrefix + "group/clear/" + id)
            .then((response) => {this.$root.notification(response.data.message, "success")})
            .catch((error) => {this.$root.notification(error.response.data.message, "error")})
            .then(() => {this.showGroups()});
        }
    },
}
</script>
<style scoped>
.btn-sm, .btn-group-sm > .btn {
    width: 150px !important;
}
</style>