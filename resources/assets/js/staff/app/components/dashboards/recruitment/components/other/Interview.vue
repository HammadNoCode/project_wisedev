<template>
    <div>
        <div class="row">
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
                                pending
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
                <a id="daily-planned" class="block block-link-pop text-center" href="javascript:void(0)">
                    <b-popover target="daily-planned" custom-class="text-center" triggers="hover" placement="bottom">
                        {{ last }}: {{ count.planned.last }}
                    </b-popover>
                    <div class="block-content block-content-full">
                        <div class="my-3">
                            <div class="display-4 font-w700 text-black">
                                {{ count.planned.this }}
                            </div>
                            <div class="mt-2 text-uppercase text-muted">
                                Planned
                            </div>
                        </div>
                        <div v-show="range == 'monthly'">
                            <div class="font-size-h4 font-w700" :class="count.planned.difference > 0 ? 'text-success' : 'text-danger'">
                                <i class="fa mr-1" :class="count.planned.difference > 0 ? 'fa-caret-up' : 'fa-caret-down'"></i>
                                {{ count.planned.difference }}%
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-4 js-appear-enabled animated fadeIn">
                <a id="daily-completed" class="block block-link-pop text-center" href="javascript:void(0)">
                    <b-popover target="daily-completed" custom-class="text-center" triggers="hover" placement="bottom">
                        {{ last }}: {{ count.completed.last }}
                    </b-popover>
                    <div class="block-content block-content-full">
                        <div class="my-3">
                            <div class="display-4 font-w700 text-black">
                                {{ count.completed.this }}
                            </div>
                            <div class="mt-2 text-uppercase text-muted">
                                Completed
                            </div>
                        </div>
                        <div v-show="range == 'monthly'">
                            <div class="font-size-h4 font-w700" :class="count.completed.difference > 0 ? 'text-success' : 'text-danger'">
                                <i class="fa mr-1" :class="count.completed.difference > 0 ? 'fa-caret-up' : 'fa-caret-down'"></i>
                                {{ count.completed.difference }}%
                            </div>
                        </div>
                    </div>
                </a>
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
        manager: function () {
            return this.$store.state.user.manager == 1 ? true : false;
        },
    },
};
</script>
