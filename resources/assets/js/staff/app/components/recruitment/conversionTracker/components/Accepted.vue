<template>
  <div class="py-2">
    <div class="bg-light p-3">
      <div class="row">
        <div class="col-md col-sm-12">
          <h3 class="block-title">Accepted Conversion</h3>
        </div>
      </div>
    </div>
    <div class="js-appear-enabled animated fadeIn" data-toggle="appear">
      <a
        class="block block-rounded height-600"
        href="javascript:void(0)"
        :class="{ 'block-mode-loading': !loaded }"
      >
        <div
          class="
            block-content block-content-full
            height-600
            d-flex
            align-items-center
            justify-content-between
          "
        >
          <div class="mx-auto py-3">
            <h2 class="mb-0">
              {{ data.d }}
              <span class="text-muted" style="font-size: 14px">Days</span>
              {{ data.h }}
              <span class="text-muted" style="font-size: 14px">Hours</span>
            </h2>
          </div>
        </div>
      </a>
    </div>
  </div>
</template>
<script>
export default {
  computed: {
    data: function () {
      return this.$store.state.conversion.conversions.accepted;
    },
  },
  data: function () {
    return {
      loaded: false,
    };
  },
  mounted() {
    this.getConversionTime();
  },
  methods: {
    async getConversionTime() {
      await this.$store
        .dispatch("conversion/getAcceptedStatusConversionTime")
        .then((res) => {
          this.loaded = true;
        });
    },
  },
};
</script>