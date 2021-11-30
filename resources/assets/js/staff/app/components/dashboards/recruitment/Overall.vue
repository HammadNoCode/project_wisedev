<template>
    <div>
        <div class="content">
            <div class="d-none d-md-block">
                <div class="row my-3">
                    <div class="col-12 col-lg">
                        <h3 class="my-auto">Recruitment Dashboard</h3>
                    </div>
                    <div class="col-12 col-lg-auto">
                        <div role="group" aria-label="Other" class="btn-group mx-2">
                            <button class="btn btn-light" @click="model = 'application'" :class="model == 'application' ? 'active' : null"><i class="far fa-file-word pr-1"></i> Applications</button>
                            <button class="btn btn-light" @click="model = 'interview'"  :class="model == 'interview' ? 'active' : null"><i class="fas fa-user-alt pr-1"></i> Interviews</button>
                            <button class="btn btn-light" @click="model = 'reference'"  :class="model == 'reference' ? 'active' : null"><i class="fas fa-users pr-1"></i> References</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-block d-md-none">
                <div class="row my-3">
                    <div class="col-12 col-lg">
                        <h3 class="my-auto">Overall Dashboard</h3>
                    </div>
                </div>
                <div class="row py-1">
                    <div class="col-12 py-1">
                        <div role="group" aria-label="Other" class="btn-group btn-block">
                            <button class="btn btn-light" @click="model = 'application'" :class="model == 'application' ? 'active' : null"><i class="far fa-file-word pr-1"></i> Applications</button>
                            <button class="btn btn-light" @click="model = 'interview'"  :class="model == 'interview' ? 'active' : null"><i class="fas fa-user-alt pr-1"></i> Interviews</button>
                        </div>
                    </div>
                </div>
                <div class="row py-1">
                    <div class="col-12 py-1">
                        <div role="group" aria-label="Other" class="btn-group btn-block">
                            <button class="btn btn-light" @click="model = 'reference'"  :class="model == 'reference' ? 'active' : null"><i class="fas fa-users pr-1"></i> References</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row py-3">
                <div class="col-md-3 col-12 py-1 my-auto ml-auto">
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text">Branch</span>
                        </div>
                        <select class="form-control text-center" v-model="filter">
                            <optgroup label="Branches">
                                <option value="all">All</option>
                                <option
                                    class="optionpicker"
                                    v-for="branch in branches"
                                    v-bind:key="branch.id"
                                    :value="branch.id"
                                >
                                    {{ branch.name }}
                                </option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-12 py-1">
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
                            <optgroup label="other">
                                <option value="all-time">All Time</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                  <div class="col-md-3 col-12 py-1">
                              <div class="input-group">
                                      <label for="example-datepicker">Choose a date</label>
                                      <b-form-datepicker ref="datepicker" id="example-datepicker" v-model="beginDate" class="mb-2" ></b-form-datepicker>
                              </div>
                </div>
                <div class="col-md-3 col-12 py-1" v-if="model != 'reference'">
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text">Show</span>
                        </div>
                        <select class="form-control text-center" name="time-range" v-model="tableQuery" v-if="model == 'application'">
                            <optgroup label="Charts">
                                <option value="stats">Stats</option>
                                <option value="bar">Bar Chart</option>
                                <option value="pie">Pie Chart</option>
                            </optgroup>
                        </select>
                        <select class="form-control text-center" name="time-range" v-model="tableQuery" v-if="model == 'interview'">
                            <optgroup label="Charts">
                                <option value="stats">Stats</option>
                                <option value="stacked" v-show="manager">Stacked Chart</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="col-md-auto col-12 py-1 my-auto">
                    <button class="btn btn-light" style="border: 0px;" @click="reload(tab)">
                        <i class="si si-refresh"></i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mb-4" v-if="loaded">
                        <Main />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Main from "./components/Main";
import moment from "moment";
import DateRangePicker from 'vue2-daterange-picker';
//you need to import the CSS manually
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css';

export default {
    computed: {
        userBranch: function () {
            return this.$store.state.user.branch_id;
        },
        manager: function () {
            return this.$store.state.user.manager == 1 ? true : false;
        },
    },
    components: {
        Main,
        DateRangePicker,
    },
    data: () => ({
        routePrefix: "/api/dashboard/overall/",
        tab: 0,
        time_range: "daily",
        filter: "all",
        model: "application",
        tableQuery: "stats",
        bar_table: "count",
        bar_query: "application",
        stacked_table: "breakdown",
        stacked_query: "interview",
        pie_table: "application",
        pie_query: "source",
        branches: {},
        dateRange:{
            startDate: null,
            endDate: null
        },
        opens:"center",
        minDate:null,
        maxDate:null,
        singleDatePicker:false,
        timePicker:false,
        timePicker24Hour:true,
        loaded: true,
        showWeekNumbers:false,
        showDropdowns:false,
        autoApply:false,
        linkedCalendars:true,
        value:'',
        key:'',
        beginDate:"",

    }),

    watch: {
        beginDate: function(newVal) {
            this.reload(this.tab);
        },
        time_range: function (newVal) {
            this.reload(this.tab);
        },
        filter: function (newVal) {
            this.reload(this.tab);
        },
        model: function (newVal) {
            this.loaded = false;
            setTimeout(() => {
                this.loaded = true;
            }, 200);
        },
    },
    mounted() {
        this.getBranches();

    },
    methods: {
        reload(tab) {
            this.loaded = false;
            setTimeout(() => {
                this.loaded = true;
            }, 200);
        },
        getBranches() {
        axios
            .get("/api/management/staff/branches/")
            .then((response) => {
                this.branches = response.data;
                if (this.filter == 0) {
                    this.filter = this.userBranch;
                }
            });
        },
    },
};
</script>

<style scoped>
.font400 {
  font-weight: 400;
}

@media (min-width: 1200px) {
  #page-container.main-content-narrow > #page-header .content-header,
  #page-container.main-content-narrow > #page-header .content,
  #page-container.main-content-narrow > #main-container .content,
  #page-container.main-content-narrow > #page-footer .content {
    max-width: 100%;
  }
}

.btn {
  transition: none;
}

.form-control.form-control-alt {
    color: #000;
    border-color: transparent;
    background-color: transparent;
    transition: none;
    font-size: 15px;
    font-weight: 600;
    border-bottom: 1px solid #000;
    border-radius: 0px !important;
}

#action{
    background-color: transparent;
    color: #000;
    border-bottom: 1px solid black !important;
    border: none;
    border-radius: 0px;
}
</style>
