<template>
    <div>
        <div v-if="branch == 'all'">
            <div class="row" v-if="chart == 'stats'">
                <div class="col-12 mb-1">
                    <visits/>
                </div>
                <div class="col-12 mb-1">
                    <merchandise/>
                </div>
                <div class="col-12">
                    <calls/>
                </div>
            </div>
            <div class="row" v-if="chart == 'pie'">
                <div class="col-12 py-1">
                    <pie/>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="row">
                <div class="col-12 py-1">
                    <overall/>
                </div>
                <div class="col-12 py-1">
                    <pie/>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Pie from "./charts/Pie";
import Visits from "./stats/overall/Visits"
import Merchandise from "./stats/overall/Merchandise"
import Calls from "./stats/overall/Calls"
import Overall from "./stats/branch/Overall"
export default {
    data() {
        return {

        }
    },
    components: {
        Pie,
        Visits,
        Merchandise,
        Calls,
        Overall
    },
    computed: {
        branch: function() {
            return this.$parent.branch;
        },
        time_range: function() {
            return this.$parent.time_range;
        },
        chart: function() {
            return this.$parent.chart;
        }
    }
}
</script>