<template>
  <div>
    <div
      class="row gutters-tiny push js-appear-enabled animated fadeIn mt-4"
      data-toggle="appear"
    >
      <div class="col-12 col-md-6 col-lg-4">
        <a class="block block-rounded text-center">
          <div
            class="block-content block-content-full p-1"
            :class="{
              blackburn: branch == 1,
              liverpool: branch == 2,
              warrington: branch == 3,
              crewe: branch == 4,
            }"
          ></div>
          <div
            class="
              block-content block-content-full
              d-flex
              justify-content-center
              align-items-center
            "
          >
            <div class="my-3">
              <span v-if="visits > 0">
                <h2 class="text-black" style="font-size: 30px" v-if="visits">
                  {{ visits }}
                </h2>
              </span>
              <span v-else>
                <h2 class="text-black" style="font-size: 30px">0</h2>
              </span>
              <div class="font-w600 mt-3 text-uppercase text-black">Visits</div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-12 col-md-6 col-lg-4">
        <a class="block block-rounded text-center">
          <div
            class="block-content block-content-full p-1"
            :class="{
              blackburn: branch == 1,
              liverpool: branch == 2,
              warrington: branch == 3,
              crewe: branch == 4,
            }"
          ></div>
          <div
            class="
              block-content block-content-full
              d-flex
              justify-content-center
              align-items-center
            "
          >
            <div class="my-3">
              <span v-if="merchandise > 0">
                <h2
                  class="text-black"
                  style="font-size: 30px"
                  v-if="merchandise"
                >
                  {{ merchandise }}
                </h2>
              </span>
              <span v-else>
                <h2 class="text-black" style="font-size: 30px">0</h2>
              </span>
              <div class="font-w600 mt-3 text-uppercase text-black">
                Merchandise
              </div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-12 col-md-6 col-lg-4">
        <a class="block block-rounded text-center">
          <div
            class="block-content block-content-full p-1"
            :class="{
              blackburn: branch == 1,
              liverpool: branch == 2,
              warrington: branch == 3,
              crewe: branch == 4,
              manchester: branch == 5,
            }"
          ></div>
          <div
            class="
              block-content block-content-full
              d-flex
              justify-content-center
              align-items-center
            "
          >
            <div class="my-3">
              <span v-if="calls > 0">
                <h2 class="text-black" style="font-size: 30px" v-if="calls">
                  {{ calls }}
                </h2>
              </span>
              <span v-else>
                <h2 class="text-black" style="font-size: 30px">0</h2>
              </span>
              <div class="font-w600 mt-3 text-uppercase text-black">Calls</div>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      routePrefix: "/api/carehome/dashboard/stats/",
      visits: 0,
      merchandise: 0,
      calls: 0,
    };
  },
  computed: {
    branch: function () {
      return this.$parent.branch;
    },
    time_range: function () {
      return this.$parent.time_range;
    },
  },
  created() {
    setInterval(this.init, 60000);
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.showVisits();
      this.showMerchandise();
      this.showCalls();
    },
    showVisits() {
      axios
        .get(
          this.routePrefix +
            "visits?branch=" +
            this.branch +
            "&period=" +
            this.time_range
        )
        .then((response) => {
          this.visits = response.data;
        })
        .catch((error) => {});
    },
    showMerchandise() {
      axios
        .get(
          this.routePrefix +
            "merchandise?branch=" +
            this.branch +
            "&period=" +
            this.time_range
        )
        .then((response) => {
          this.merchandise = response.data;
        })
        .catch((error) => {});
    },
    showCalls() {
      axios
        .get(
          this.routePrefix +
            "calls?branch=" +
            this.branch +
            "&period=" +
            this.time_range
        )
        .then((response) => {
          this.calls = response.data;
        })
        .catch((error) => {});
    },
  },
};
</script>
<style scoped>
.blackburn {
  background-color: #154191;
}
.liverpool {
  background-color: #e04f1a;
}
.warrington {
  background-color: #82b54b;
}
.crewe {
  background-color: #3c90df;
}
</style>
