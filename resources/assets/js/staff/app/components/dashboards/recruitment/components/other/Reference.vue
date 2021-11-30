<template>
    <div>
        <div class="row">
            <div class="col-12 col-md-6 col-xl-4 js-appear-enabled animated fadeIn">
                <a id="daily-awaiting" class="block block-link-pop text-center" href="javascript:void(0)">
                    <b-popover target="daily-awaiting" custom-class="text-center" triggers="hover" placement="bottom">
                        {{ last }}: {{ count.awaiting.last }}
                    </b-popover>
                    <div class="block-content block-content-full">
                        <div class="my-3">
                            <div class="display-4 font-w700 text-black">
                                {{ count.awaiting.this }}
                            </div>
                            <div class="mt-2 text-uppercase text-muted">
                                Awaiting
                            </div>
                        </div>
                        <div v-show="range == 'monthly'">
                            <div class="font-size-h4 font-w700" :class="count.awaiting.difference > 0 ? 'text-success' : 'text-danger'">
                                <i class="fa mr-1" :class="count.awaiting.difference > 0 ? 'fa-caret-up' : 'fa-caret-down'"></i>
                                {{ count.awaiting.difference }}%
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-6 col-xl-4 js-appear-enabled animated fadeIn">
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
            <div class="col-12 col-md-6 col-xl-4 js-appear-enabled animated fadeIn">
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
  },
};
</script>
