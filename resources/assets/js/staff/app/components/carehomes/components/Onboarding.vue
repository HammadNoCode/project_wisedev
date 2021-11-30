<template>
  <div>
    <div class="row mt-3">
      <div class="col-lg-4 col-12">
        <div
          class="
            js-wizard-simple
            block block-rounded
            js-appear-enabled
            animated
            fadeIn
          "
        >
          <div class="block-content block-content-full tab-content">
            <div class="row">
              <div class="col-12">
                <h5 class="mb-0">Progress</h5>
              </div>
            </div>
            <hr />
            <div class="row py-3" v-if="stages[11]">
              <div class="col-12 d-none d-md-block">
                <div
                  class="progress push vertical mb-3 mx-auto"
                  style="height: 510px; width: 150px"
                >
                  <div
                    class="
                      progress-bar progress-bar-striped progress-bar-animated
                      bg-success
                    "
                    role="progressbar"
                    aria-valuenow="100"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    :style="{ height: progress + '%' }"
                    style="
                      width: 150px;
                      transition: height 0.6s ease !important;
                    "
                  >
                    <span class="font-size-sm font-w600">{{ progress }}%</span>
                  </div>
                </div>
              </div>
              <div class="col-12 d-block d-md-none">
                <div
                  class="progress push mb-3 mx-auto"
                  style="border-radius: 5rem"
                >
                  <div
                    class="
                      progress-bar progress-bar-striped progress-bar-animated
                      bg-success
                    "
                    role="progressbar"
                    aria-valuenow="100"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    :style="{ width: progress + '%' }"
                    style="border-radius: 5rem"
                  >
                    <span class="font-size-sm font-w600">{{ progress }}%</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8 col-12">
        <div
          class="
            js-wizard-simple
            block block-rounded
            js-appear-enabled
            animated
            fadeIn
          "
        >
          <div class="block-content block-content-full tab-content">
            <div class="row">
              <div class="col-12">
                <h5 class="mb-0">Onboarding Stages</h5>
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-12">
                <div class="row">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table
                        class="
                          table
                          table-hover
                          table-vcenter
                          table-borderless
                          table-striped
                          js-appear-enabled
                          animated
                          fadeIn
                        "
                      >
                        <tbody class="bg-white">
                          <tr v-for="(stage, key) in stages" :key="key">
                            <td>{{ stage.stage }}</td>
                            <td>
                              <input
                                type="checkbox"
                                size="lg"
                                v-model="stage.checked"
                                @click="toggleCheckbox(stage.id, key)"
                              />
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data: function () {
    return {
      routePrefix: "/api/carehome/onboarding/",
      stages: {
        checked: false,
      },
    };
  },
  computed: {
    progress: function (data) {
      var checked = 0;
      var stageData = data;
      var newData = stageData.stages;
      Object.keys(newData).forEach((stg) => {
        checked += newData[stg].checked;
      });
      if (newData[11].checked) {
        return 100.0;
      } else {
        var percent = (100 / newData.length) * checked;
        return percent.toFixed(2);
      }
    },
  },
  mounted() {
    this.showStages();
  },
  methods: {
    showStages() {
      axios
        .get(this.routePrefix + "stages/" + this.$route.params.id)
        .then((response) => {
          this.stages = response.data;
        })
        .catch(() => {});
    },
    toggleCheckbox(id, key) {
      if (this.stages[key].checked == true) {
        this.destroy(id);
      } else {
        this.store(id);
        if (id == "12") {
          this.createAgency();
        }
      }
    },
    store(id) {
      axios
        .post(
          this.routePrefix + this.$route.params.id + "/" + id,
          this.stages,
          this.$parent.carehome
        )
        .then((response) => {
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        });
    },
    destroy(id) {
      axios
        .delete(this.routePrefix + this.$route.params.id + "/" + id)
        .then((response) => {
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        });
    },
    createAgency() {
      axios.post("/api/carehome/agency", {
        id: this.$route.params.id,
        name: "Cavalry Healthcare",
      });
      this.loaded = true;
    },
  },
};
</script>
<style scoped>
.vertical {
  display: flex;
  align-items: flex-end;
}
</style>