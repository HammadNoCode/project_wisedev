<template>
    <div>
        <form action="be_blocks_forms.html" data-bitwarden-watching="1">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="h4 my-auto">Create Audit Group</h3>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center py-2">
                        <div class="col-sm-10 col-md-9">
                            <div class="form-group input-group inpug-group-lg">
                                <div class="input-group-prepend">
                                    <span id="basic-addon1" class="input-group-text mb-1">Group Name</span>
                                </div> 
                                <input class="form-control" type="text" v-model="group.name"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light">
                    <div class="row">
                        <div class="col-12">
                            <button type="reset" class="text-left btn btn-danger btn-sm">
                                <i class="fas fa-history pr-1"></i>Reset
                            </button>
                            <button type="button" class="float-right btn btn-success btn-sm" @click="store">
                                <i class="fa fa-check"></i> Create
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
export default {
    data: function() {
        return {
            routePrefix: "/api/compliance-staff/template/group/",
            group: {},
        }
    },
    methods: {
        store() {
            axios
            .post(this.routePrefix, this.group)
            .then(response => {
                this.success = true;
                this.$root.notification(response.data.message, "success");
            })
            .catch(error => {this.message = "Oops, an error occurred!";})
            .then(() => {
                this.$parent.showGroups();
                this.$parent.newGroup = false;
            });
        },
    }
}
</script>