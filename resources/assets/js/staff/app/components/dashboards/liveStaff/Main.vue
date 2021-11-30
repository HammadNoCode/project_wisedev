<template>
    <div class="content">
        <div class="row my-3">
            <div class="col-12 my-auto">
                <h3 class="mb-0">Live Staff Dashboard</h3>
            </div>
        </div>
        <!-- <div class="row pb-3">
            <div class="col-lg-4 ml-auto my-auto">
                <div class="input-group">
                    <div class="input-group-append">
                        <div class="input-group-text">Branch</div>
                    </div>
                    <select class="form-control" v-model="branch">
                        <option value="0">All</option>
                        <option v-for="(branch, key) in branches" :key="key">{{branch.name}}</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-auto col-12 py-1 my-auto">
                <button class="btn btn-light" @click="reload">
                    <i class="si si-refresh"></i>
                </button>
            </div>
        </div> -->
        <stats />
        <span  class="d-none d-md-block">
            <bar />
        </span>
    </div>
</template>
<script>
import Bar from "./charts/Bar";
import Stats from "./stats/Stats";

export default {
    data() {
        return {
            branches: {},
            branch: 0, 
            loaded: true,
        }
    },
    watch: {
        branch: function (newVal) {
            this.loaded = false;
            setTimeout(() => {
                this.loaded = true;
            }, 200);
        },
    },
    mounted() {
        this.readBranches();
    },
    components: {
        Bar,
        Stats,
    },
    methods: {
        reload() {
            this.loaded = false;
            setTimeout(() => {
                this.loaded = true;
            }, 200);
        },
        readBranches() {
            axios.get("/api/branches")
            .then(response => {
                this.branches = response.data
            })
        },
    }
};
</script>