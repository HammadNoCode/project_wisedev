<template>
  <div>
    <div class="row pt-3">
      <div class="col-12 col-md-6">
        <a
          class="block block-rounded text-center"
          :class="{ 'block-mode-loading': !loaded }"
        >
          <div
            class="
              block-content block-content-full
              d-flex
              justify-content-center
              align-items-center
            "
          >
            <div class="my-3">
              <h2 class="text-black" style="font-size: 30px">
                {{ pipeline_hours }}
              </h2>
              <div class="font-w600 mt-3 text-uppercase text-black">
                {{ position_filter | capitalize }} Avaliable Hours (Pipeline)
              </div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-12 col-md-6">
        <a
          class="block block-rounded text-center"
          :class="{ 'block-mode-loading': !loaded }"
        >
          <div
            class="
              block-content block-content-full
              d-flex
              justify-content-center
              align-items-center
            "
          >
            <div class="my-3">
              <h2 class="text-black" style="font-size: 30px">NaN</h2>
              <div class="font-w600 mt-3 text-uppercase text-black">
                Hours Missing
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
    branch: function () {
      return this.$parent.branch;
    },
    position_filter: function () {
      return this.$store.state.reports.filter.position;
    },
    pipeline_hours: function () {
      return this.$store.state.reports.pipeline_hours;
    },
  },
  watch: {
    branch: function (newVal) {
      this.$store.dispatch("reports/getAvaliablePipelineHours", {
        branch: this.branch,
        position: this.position_filter,
      });
    },
    position_filter: function (newVal) {
      this.$store.dispatch("reports/getAvaliablePipelineHours", {
        branch: this.branch,
        position: this.position_filter,
      });
    },
  },
  data: function () {
    return {
      loaded: false,
    };
  },
  mounted() {
    this.getAvaliablePipelineHours();
  },
  methods: {
    async getAvaliablePipelineHours() {
      await this.$store.dispatch("reports/getAvaliablePipelineHours", {
        branch: this.branch,
        position: this.position_filter,
      });
      this.loaded = true;
    },
  },
};
</script>