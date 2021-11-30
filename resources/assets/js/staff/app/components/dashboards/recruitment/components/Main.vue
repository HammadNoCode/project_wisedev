<template>
    <div>
        <div v-if="$parent.loaded">
            <div>
                <div v-if="model == 'application'">
                    <div v-show="tableQuery == 'stats'">
                        <ApplicationStats />
                    </div>
                    <div class="d-none d-md-block">
                        <div v-show="tableQuery == 'bar'">
                            <BarChart />
                        </div>
                        <div v-show="tableQuery == 'pie'">
                            <PieChart />
                        </div>
                        <div v-show="tableQuery == 'stacked'">
                            <div class="block-content js-appear-enabled animated fadeIn">
                                <div class="py-5">
                                    <h1 class="text-center text-muted">No data found</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="model == 'interview'">
                    <div v-show="tableQuery == 'stats'">
                        <InterviewStats />
                        <div class="d-none d-md-block">
                            <BarChart />
                        </div>
                    </div>
                    <div class="d-none d-md-block">
                        <div v-if="manager" v-show="tableQuery == 'stacked'">
                            <StackedBar />
                        </div>
                    </div>
                </div>
                <div v-if="model == 'reference'">
                    <ReferenceStats />
                    <div class="d-none d-md-block">
                        <BarChart />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ApplicationStats from "./other/Application";
import InterviewStats from "./other/Interview";
import ReferenceStats from "./other/Reference";
import BarChart from "./graphs/Bar";
import PieChart from "./graphs/Pie";
import StackedBar from "./graphs/StackedBar";

export default {
    components: {
        ApplicationStats,
        InterviewStats,
        ReferenceStats,
        BarChart,
        PieChart,
        StackedBar,
    },
    computed: {
        manager: function () {
            return this.$store.state.user.manager == 1 ? true : false;
        },
        model: function () {
            return this.$parent.model;
        },
        time_range: function () {
            return this.$parent.time_range;
        },
        filter: function () {
            return this.$parent.filter;
        },
        bar_label: function () {
            return this.$parent.bar_query;
        },
        stacked_label: function () {
            return this.$parent.stacked_query;
        },
        tableQuery: function () {
            return this.$parent.tableQuery;
        },
        begin_date: function() {
            return this.$parent.beginDate;

        },
        bar_table: {
            get: function () {
                return this.$parent.bar_table;
            },
            set: function (newValue) {
                this.$parent.bar_table = newValue;
            },
        },
        bar_query: {
            get: function () {
                return this.$parent.model;
            },
            set: function (newValue) {
                this.$parent.model = newValue;
            },
        },
        stacked_table: {
            get: function () {
                return this.$parent.stacked_table;
            },
            set: function (newValue) {
                this.$parent.stacked_table = newValue;
            },
        },
        stacked_query: {
            get: function () {
                return this.$parent.stacked_query;
            },
            set: function (newValue) {
                this.$parent.stacked_query = newValue;
            },
        },
        pie_label: function () {
            return this.$parent.pie_query
                ? this.$parent.pie_query.replace(/[_-]/g, " ")
                : "";
            },
        pie_table: {
            get: function () {
                return this.$parent.pie_table;
            },
            set: function (newValue) {
                this.$parent.pie_table = newValue;
            },
        },
        pie_query: {
            get: function () {
                return this.$parent.pie_query;
            },
            set: function (newValue) {
                this.$parent.pie_query = newValue;
            },
        },
        this_pretty: function () {
            switch (this.time_range) {
                case "daily":
                return "TODAY";
                case "weekly":
                return "THIS WEEK";
                case "monthly":
                return "THIS MONTH";
                default:
                return this.$parent.time_range;
            }
        },
        last_pretty: function () {
            switch (this.time_range) {
                case "daily":
                return "YESTERDAY";
                case "weekly":
                return "LAST WEEK";
                case "monthly":
                return "LAST MONTH";
                default:
                return this.$parent.time_range;
            }
        },
    },
    data: () => ({
        routePrefix: "/api/dashboard/overall/",
        count: {
            total: {
                this: null,
                last: null,
                difference: null,
            },
            incomplete: {
                this: null,
                last: null,
                difference: null,
            },
            pending: {
                this: null,
                last: null,
                difference: null,
            },
            accepted: {
                this: null,
                last: null,
                difference: null,
            },
            rejected: {
                this: null,
                last: null,
                difference: null,
            },
            awaiting: {
                this: null,
                last: null,
                difference: null,
            },
            incomplete: {
                this: null,
                last: null,
                difference: null,
            },
            inexperienced: {
                this: null,
                last: null,
                difference: null,
            },
            not_yet: {
                this: null,
                last: null,
                difference: null,
            },
            archived: {
                this: null,
                last: null,
                difference: null,
            },
            live: {
                this: null,
                last: null,
                difference: null,
            },
            planned: {
                this: null,
                last: null,
                difference: null,
            },
            completed: {
                this: null,
                last: null,
                difference: null,
            },
            percent: {
                this: null,
                last: null,
                difference: null,
            },
            hire_rate: {
                this: null,
                last: null,
                difference: null,
            },
            completion_rate: {
                this: null,
                last: null,
                difference: null,
            },
        },
        bar_chart: true,
        stack_chart: true,
        pie_chart: true,
        graphs: {
        responsive: [
            {
            breakpoint: 2600,
            options: {
                chart: {
                height: "700",
                width: "1200",
                },
                dataLabels: {
                style: {
                    fontSize: "10px",
                    colors: ["#304758"],
                },
                },
            },
            },
            {
            breakpoint: 2000,
            options: {
                chart: {
                height: "700",
                width: "1000",
                },
                dataLabels: {
                style: {
                    fontSize: "10px",
                    colors: ["#304758"],
                },
                },
            },
            },
            {
            breakpoint: 1440,
            options: {
                chart: {
                height: "650",
                width: "850",
                },
                dataLabels: {
                style: {
                    fontSize: "10px",
                    colors: ["#304758"],
                },
                },
            },
            },
            {
            breakpoint: 1240,
            options: {
                chart: {
                height: "500",
                width: "650",
                },
                dataLabels: {
                style: {
                    fontSize: "10px",
                    colors: ["#304758"],
                },
                },
            },
            },
            {
            breakpoint: 990,
            options: {
                chart: {
                height: "500",
                width: "650",
                },
                dataLabels: {
                style: {
                    fontSize: "10px",
                    colors: ["#304758"],
                },
                },
            },
            },
            {
            breakpoint: 700,
            options: {
                chart: {
                height: "500",
                width: "450",
                },
                dataLabels: {
                style: {
                    fontSize: "10px",
                    colors: ["#304758"],
                },
                },
            },
            },
            {
            breakpoint: 500,
            options: {
                chart: {
                height: "400",
                width: "325",
                },
                dataLabels: {
                style: {
                    fontSize: "10px",
                    colors: ["#304758"],
                },
                },
            },
            },
        ],
        },
  }),
    mounted() {
        this.init_dash();
    },
    methods: {
        init_dash() {
            this.getStats();
        },
        getStats() {
            let one = this.routePrefix + this.model  + "/" + this.time_range + "/" + this.filter + "/simple/total"
            let two = this.routePrefix + this.model +'/' + this.time_range + "/" + this.filter + "/simple/pending"
            let three = this.routePrefix + this.model + '/' + this.time_range + "/" + this.filter + "/simple/accepted"
            let four = this.routePrefix + this.model  + '/' + this.time_range + "/" + this.filter + "/simple/rejected"
            let five = this.routePrefix + this.model + '/' + this.time_range + "/" + this.filter + "/simple/awaiting"
            let six = this.routePrefix + this.model + '/' + this.time_range + "/" + this.filter + "/simple/inexperienced"
            let seven = this.routePrefix + this.model  + '/' + this.time_range + "/" + this.filter + "/simple/not_yet"
            let eight = this.routePrefix + this.model  + '/' + this.time_range + "/" + this.filter + "/simple/archived"
            let nine = this.routePrefix + this.model + '/' + this.time_range + "/" + this.filter + "/simple/live"
            let ten = this.routePrefix + this.model + '/' + this.time_range + "/" + this.filter + "/simple/incomplete"
            let eleven = this.routePrefix + this.model + '/' + this.time_range + "/" + this.filter + "/simple/planned"
            let twelve = this.routePrefix + this.model + '/' + this.time_range + "/" + this.filter + "/simple/completed"
            const requestOne = axios.get(one);
            const requestTwo = axios.get(two);
            const requestThree = axios.get(three);
            const requestFour = axios.get(four);
            const requestFive = axios.get(five);
            const requestSix = axios.get(six);
            const requestSeven = axios.get(seven);
            const requestEight = axios.get(eight);
            const requestNine = axios.get(nine);
            const requestTen = axios.get(ten);
            const requestEleven = axios.get(eleven);
            const requestTwelve = axios.get(twelve);

            axios.all([requestOne, requestTwo, requestThree, requestFour, requestFive, requestSix, requestSeven, requestEight, requestNine, requestTen, requestEleven, requestTwelve]).then(axios.spread((...responses) => {
                this.showTotal(responses[0]);
                this.showPending(responses[1]);
                this.showAccepted(responses[2]);
                this.showRejected(responses[3]);
                this.showAwaiting(responses[4]);
                this.showInexperienced(responses[5]);
                this.showNotYet(responses[6]);
                this.showArchived(responses[7]);
                this.showLive(responses[8]);
                this.showIncomplete(responses[9]);
                this.showPlanned(responses[10]);
                this.showCompleted(responses[11]);
            })).catch(errors => {
                // react on errors
            })
        },
        showTotal(response) {
            this.count.total.difference = this.$root.difference_percentage(response.data.this, response.data.last);
            this.count.total.this = response.data.this;
            this.count.total.last = response.data.last;
        },
        showPending(response) {
            this.count.pending.difference = this.$root.difference_percentage(response.data.this, response.data.last);
            this.count.pending.this = response.data.this;
            this.count.pending.last = response.data.last;
        },
        showAccepted(response) {
            console.log(response.data);
            this.count.accepted.difference = this.$root.difference_percentage(response.data.this, response.data.last);
            this.count.accepted.this = response.data.this;
            this.count.accepted.last = response.data.last;
        },
        showRejected(response) {
            this.count.rejected.difference = this.$root.difference_percentage(response.data.this, response.data.last);
            this.count.rejected.this = response.data.this;
            this.count.rejected.last = response.data.last;
        },
        showAwaiting(response){
            this.count.awaiting.difference = this.$root.difference_percentage(response.data.this, response.data.last);
            this.count.awaiting.this = response.data.this;
            this.count.awaiting.last = response.data.last;
        },
        showInexperienced(response){
            this.count.inexperienced.difference = this.$root.difference_percentage(response.data.this, response.data.last);
            this.count.inexperienced.this = response.data.this;
            this.count.inexperienced.last = response.data.last;
        },
        showNotYet(response){
            this.count.not_yet.difference = this.$root.difference_percentage(response.data.this, response.data.last);
            this.count.not_yet.this = response.data.this;
            this.count.not_yet.last = response.data.last;
        },
        showArchived(response){
            this.count.archived.difference = this.$root.difference_percentage(response.data.this, response.data.last);
            this.count.archived.this = response.data.this;
            this.count.archived.last = response.data.last;
        },
        showLive(response){
            this.count.live.difference = this.$root.difference_percentage(response.data.this, response.data.last);
            this.count.live.this = response.data.this;
            this.count.live.last = response.data.last;
        },
        showIncomplete(response){
            this.count.incomplete.difference = this.$root.difference_percentage(response.data.this, response.data.last);
            this.count.incomplete.this = response.data.this;
            this.count.incomplete.last = response.data.last;
        },
        showPlanned(response){
            this.count.planned.difference = this.$root.difference_percentage(response.data.this, response.data.last);
            this.count.planned.this = response.data.this;
            this.count.planned.last = response.data.last;
        },
        showCompleted(response){
            this.count.completed.difference = this.$root.difference_percentage(response.data.this, response.data.last);
            this.count.completed.this = response.data.this;
            this.count.completed.last = response.data.last;
        },
        update_pie() {
            if (this.pie_query) {
                this.pie_chart = false;
                setTimeout(() => {
                this.pie_chart = true;
                }, 200);
            }
        },
    },
};
</script>

<style lang="scss">
@media (min-width: 2460px) {
  .col-xxl-8 {
    width: 66.66% !important;
    padding-left: 15px;
    padding-right: 15px;
  }
}
@media (min-width: 2460px) {
  .col-xxl-4 {
    width: 33.33% !important;
    padding-left: 15px;
    padding-right: 15px;
  }
}
@media (max-width: 2459px) {
  .col-xxl-8 {
    width: 100% !important;
    padding-left: 15px;
    padding-right: 15px;
  }
}
@media (max-width: 2459px) {
  .col-xxl-4 {
    width: 100% !important;
    padding-left: 15px;
    padding-right: 15px;
  }
}
</style>
