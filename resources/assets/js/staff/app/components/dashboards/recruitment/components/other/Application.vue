<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-6 col-xl-4 js-appear-enabled animated fadeIn">
                        <a id="daily-count" class="block block-link-pop text-center" href="javascript:void(0)">
                            <b-popover target="daily-count" custom-class="text-center" triggers="hover" placement="bottom" >
                                {{ last }}: {{ count.total.last }}
                            </b-popover>
                            <div class="block-content block-content-full">
                                <div class="my-3">
                                    <div class="display-4 font-w700 text-black">
                                        {{ count.total.this }}
                                    </div>
                                    <div class="mt-2 text-uppercase text-muted">Total</div>
                                </div>
                                <div v-show="range == 'monthly'">
                                    <div class="font-size-h4 font-w700" :class="count.total.difference > 0 ? 'text-success' : 'text-danger'">
                                        <i class="fa mr-1" :class="count.total.difference > 0 ? 'fa-caret-up' : 'fa-caret-down'"></i>
                                        {{ count.total.difference }}%
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-4 js-appear-enabled animated fadeIn">
                        <a id="daily-pending" class="block block-link-pop text-center" href="javascript:void(0)">
                            <b-popover target="daily-pending" custom-class="text-center" triggers="hover" placement="bottom">
                                {{ last }}: {{ count.pending.last }}
                            </b-popover>
                            <div class="block-content block-content-full">
                                <div class="my-3">
                                    <div class="display-4 font-w700 text-black">
                                        {{ count.pending.this }}
                                    </div>
                                    <div class="mt-2 text-uppercase text-muted">
                                        Pending
                                    </div>
                                </div>
                                <div v-show="range == 'monthly'">
                                    <div class="font-size-h4 font-w700" :class="count.pending.difference > 0 ? 'text-success' : 'text-danger'">
                                        <i class="fa mr-1" :class="count.pending.difference > 0 ? 'fa-caret-up' : 'fa-caret-down'"></i>
                                        {{ count.pending.difference }}%
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-4 js-appear-enabled animated fadeIn">
                        <a id="daily-accepted" class="block block-link-pop text-center" href="javascript:void(0)">
                            <b-popover target="daily-accepted" custom-class="text-center" triggers="hover" placement="bottom">
                                {{ last }}: {{ count.accepted.last }}
                            </b-popover>
                            <div class="block-content block-content-full">
                                <div class="my-3">
                                    <div class="display-4 font-w700 text-black">
                                        {{ count.accepted.this }}
                                    </div>
                                    <div class="mt-2 text-uppercase text-muted">
                                        Accepted
                                    </div>
                                </div>
                                <div v-show="range == 'monthly'">
                                    <div class="font-size-h4 font-w700" :class="count.accepted.difference > 0 ? 'text-success' : 'text-danger'">
                                        <i class="fa mr-1" :class="count.accepted.difference > 0 ? 'fa-caret-up' : 'fa-caret-down'"></i>
                                        {{ count.accepted.difference }}%
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-4 js-appear-enabled animated fadeIn">
                        <a id="daily-rejected" class="block block-link-pop text-center" href="javascript:void(0)">
                            <b-popover target="daily-rejected" custom-class="text-center" triggers="hover" placement="bottom">
                                {{ last }}: {{ count.rejected.last }}
                            </b-popover>
                            <div class="block-content block-content-full">
                                <div class="my-3">
                                    <div class="display-4 font-w700 text-black">
                                        {{ count.rejected.this }}
                                    </div>
                                    <div class="mt-2 text-uppercase text-muted">
                                        Rejected
                                    </div>
                                </div>
                                <div v-show="range == 'monthly'">
                                    <div class="font-size-h4 font-w700" :class="count.rejected.difference > 0 ? 'text-success' : 'text-danger'">
                                        <i class="fa mr-1" :class="count.rejected.difference > 0 ? 'fa-caret-up' : 'fa-caret-down'"></i>
                                        {{ count.rejected.difference }}%
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-4 js-appear-enabled animated fadeIn">
                        <a id="daily-inexperienced" class="block block-link-pop text-center" href="javascript:void(0)">
                            <b-popover target="daily-inexperienced" custom-class="text-center" triggers="hover" placement="bottom">
                                {{ last }}: {{ count.inexperienced.last }}
                            </b-popover>
                            <div class="block-content block-content-full">
                                <div class="my-3">
                                    <div class="display-4 font-w700 text-black">
                                        {{ count.inexperienced.this }}
                                    </div>
                                    <div class="mt-2 text-uppercase text-muted">
                                        Inexperienced
                                    </div>
                                </div>
                                 <div v-show="range == 'monthly'">
                                    <div class="font-size-h4 font-w700" :class="count.inexperienced.difference > 0 ? 'text-success' : 'text-danger'">
                                        <i class="fa mr-1" :class="count.inexperienced.difference > 0 ? 'fa-caret-up' : 'fa-caret-down'"></i>
                                        {{ count.inexperienced.difference }}%
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-4 js-appear-enabled animated fadeIn">
                        <a id="daily-not_yet" class="block block-link-pop text-center" href="javascript:void(0)">
                            <b-popover target="daily-not_yet" custom-class="text-center" triggers="hover" placement="bottom">
                                {{ last }}: {{ count.not_yet.last }}
                            </b-popover>
                            <div class="block-content block-content-full">
                                <div class="my-3">
                                    <div class="display-4 font-w700 text-black">
                                        {{ count.not_yet.this }}
                                    </div>
                                    <div class="mt-2 text-uppercase text-muted">
                                        Not Yet
                                    </div>
                                </div>
                                <div v-show="range == 'monthly'">
                                    <div class="font-size-h4 font-w700" :class="count.not_yet.difference > 0 ? 'text-success' : 'text-danger'">
                                        <i class="fa mr-1" :class="count.not_yet.difference > 0 ? 'fa-caret-up' : 'fa-caret-down'"></i>
                                        {{ count.not_yet.difference }}%
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-4 js-appear-enabled animated fadeIn">
                        <a id="daily-archived" class="block block-link-pop text-center" href="javascript:void(0)">
                        <b-popover target="daily-archived" custom-class="text-center" triggers="hover" placement="bottom">
                            {{ last }}: {{ count.archived.last }}
                        </b-popover>
                            <div class="block-content block-content-full">
                                <div class="my-3">
                                    <div class="display-4 font-w700 text-black">
                                        {{ count.archived.this }}
                                    </div>
                                    <div class="mt-2 text-uppercase text-muted">
                                        Archived
                                    </div>
                                </div>
                                <div v-show="range == 'monthly'">
                                    <div class="font-size-h4 font-w700" :class="count.archived.difference > 0 ? 'text-success' : 'text-danger'">
                                        <i class="fa mr-1" :class="count.archived.difference > 0 ? 'fa-caret-up' : 'fa-caret-down'"></i>
                                        {{ count.archived.difference }}%
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-4 js-appear-enabled animated fadeIn">
                        <a id="daily-live" class="block block-link-pop text-center" href="javascript:void(0)">
                            <b-popover target="daily-live" custom-class="text-center" triggers="hover" placement="bottom">
                                {{ last }}: {{ count.live.last }}
                            </b-popover>
                            <div class="block-content block-content-full ribbon ribbon-success">
                                <div class="ribbon-box text-uppercase">NEW
                                </div>
                                <div class="my-3">
                                    <div class="display-4 font-w700 text-black">
                                        {{ count.live.this }}
                                    </div>
                                    <div class="mt-2 text-uppercase text-muted">
                                        Live
                                    </div>
                                </div>
                                <div v-show="range == 'monthly'">
                                    <div class="font-size-h4 font-w700" :class="count.live.difference > 0 ? 'text-success' : 'text-danger'">
                                        <i class="fa mr-1" :class="count.live.difference > 0 ? 'fa-caret-up' : 'fa-caret-down'"></i>
                                        {{ count.live.difference }}%
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-4 js-appear-enabled animated fadeIn">
                        <a id="daily-completionRate" class="block block-link-pop text-center" href="javascript:void(0)">
                            <b-popover target="daily-completionRate" custom-class="text-center" triggers="hover" placement="bottom">
                                {{ last }}: {{ lastCompletionRate }}%
                            </b-popover>
                            <div class="block-content block-content-full">
                                <div class="my-3">
                                    <div class="display-4 font-w700 text-black">
                                        <div :class="thisCompletionRate > 0 ? 'text-success' : 'text-danger'">
                                            <i class="fa mr-1" :class=" thisCompletionRate > 0 ? 'fa-caret-up' : 'fa-caret-down'" v-if="thisCompletionRate !== null"></i>
                                            {{ thisCompletionRate }}
                                            <span v-if="thisCompletionRate !== null">%</span>
                                            <span v-if="thisCompletionRate === null" style="visibility: hidden">%</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-uppercase text-muted">
                                        Conversion Rate
                                    </div>
                                </div>
                                <div v-show="range == 'monthly'">
                                    <div class="pb-4"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    computed: {
        count: function () {
            return this.$parent.count;
        },
        range: function () {
            return this.$parent.time_range;
        },
        last: function () {
            return this.$parent.last_pretty;
        },
        thisCompletionRate: function() {
            var percentage =  100 / (this.count.total.this + this.count.incomplete.this) * this.count.total.this;
            return percentage.toFixed(2);
        },
        lastCompletionRate: function() {
            var percentage = 100 / (this.count.total.last + this.count.incomplete.last) * this.count.total.last;
            return percentage.toFixed(2);
        }
    },
};
</script>
<style scoped>
</style>
