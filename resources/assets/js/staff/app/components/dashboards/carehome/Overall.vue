<template>
    <div class="content">
        <div class="row my-3">
            <div class="col-12 col-lg">
                <h3 class="my-auto">Carehome Dashboard</h3>
            </div>
            <div class="col-12 col-lg-auto">
                <div role="group" aria-label="All" class="btn-group mx-2">
                    <button class="btn btn-light" @click="branch = 'all'" :class="branch == 'all' ? 'active' : null">All</button>
                </div>
                <div role="group" aria-label="Other" class="btn-group mx-2">
                    <button class="btn btn-light" @click="branch = '1'" :class="branch == '1' ? 'active' : null">Lancashire</button>
                    <button class="btn btn-light" @click="branch = '2'" :class="branch == '2' ? 'active' : null">Warrington</button>
                    <button class="btn btn-light" @click="branch = '3'" :class="branch == '3' ? 'active' : null">Crewe</button>
                    <button class="btn btn-light" @click="branch = '4'" :class="branch == '4' ? 'active' : null">Liverpool</button>
                    <button class="btn btn-light" @click="branch = '5'" :class="branch == '5' ? 'active' : null">Manchester</button>
                    <button class="btn btn-light" @click="branch = '6'" :class="branch == '6' ? 'active' : null">Leeds</button>
                    <button class="btn btn-light" @click="branch = '7'" :class="branch == '7' ? 'active' : null">Shrewsbury</button>
                    <button class="btn btn-light" @click="branch = '8'" :class="branch == '8' ? 'active' : null">Chester</button>
                    <button class="btn btn-light" @click="branch = '9'" :class="branch == '9' ? 'active' : null">Permanent</button>
                    <button class="btn btn-light" @click="branch = '10'" :class="branch == '10' ? 'active' : null">Complex Care</button>
                    <button class="btn btn-light" @click="branch = '11'" :class="branch == '11' ? 'active' : null">Head Office</button>
                </div>
            </div>
        </div>
        <div class="row py-2">
            <div class="col-lg-3 col-12 py-1 ml-auto">
                <div class="input-group">
                    <div class="input-group-append">
                        <span class="input-group-text">Period</span>
                    </div>
                    <select class="form-control text-center" name="time-range" v-model="time_range">
                        <optgroup label="Rolling">
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </optgroup>
                        <optgroup label="To Date">
                            <option value="week-to-date">Week</option>
                            <option value="month-to-date">Month</option>
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-12 py-1" v-show="branch == 'all'">
                <div class="input-group">
                    <div class="input-group-append">
                        <span class="input-group-text">Chart</span>
                    </div>
                    <select class="form-control text-center" name="time-range" v-model="chart">
                        <option value="stats">Stats</option>
                        <option value="pie">Pie Chart</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-auto col-12 py-1 my-auto">
                <button class="btn btn-light" @click="reload">
                    <i class="si si-refresh"></i>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12" v-if="loaded">
                <Main/>
            </div>
        </div>
    </div>
</template>
<script>
import Main from "./Main"
export default {
    data() {
        return {
            branch: "all",
            time_range: "daily",
            chart: "stats",
            loaded: true,
        }
    },
    components: {
        Main,
    },
    watch: {
        branch: function (newVal) {
            this.loaded = false;
            setTimeout(() => {
                this.loaded = true;
            }, 200);
        },
        time_range: function (newVal) {
            this.loaded = false;
            setTimeout(() => {
                this.loaded = true;
            }, 200);
        },
    },
    methods: {
        reload() {
            this.loaded = false;
            setTimeout(() => {
                this.loaded = true;
            }, 200);
        },
    }

}
</script>
