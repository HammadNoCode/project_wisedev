<template>
  <div>
    <div class="row">
      <div class="col-lg-6">
        <invite-conversion-chart />
      </div>
      <div class="col-lg-6">
        <conversion-time-chart />
      </div>
    </div>
  </div>
</template>
<script>
import InviteConversionChart from "./charts/pie/InviteConversion.vue";
import ConversionTimeChart from "./charts/pie/ConversionTime.vue";

export default {
  components: {
    InviteConversionChart,
    ConversionTimeChart,
  },
  data() {
    return {};
  },
};
</script>