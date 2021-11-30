<template>
  <div>
    <div class="row py-3">
      <div class="col-12">
        <div class="alert alert-info alert-dismissable" role="alert">
          <button
            type="button"
            class="close"
            data-dismiss="alert"
            aria-label="Close"
          >
            <span aria-hidden="true">×</span>
          </button>
          <p class="mb-0">
            Make sure before any issue date or renewal dates have been inputted
            the checkbox to the left is <b>checked</b>
          </p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="progress push mb-3" style="border-radius: 5rem">
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
    <div class="block block-rounded block-fx-pop mt-2">
      <div class="row">
        <div class="col-lg-12">
          <div class="table-responsive" v-if="loaded">
            <table
              class="
                table table-hover table-vcenter table-borderless table-striped
                js-appear-enabled
                animated
                fadeIn
              "
            >
              <thead class="thead-light">
                <tr>
                  <th>Document Name</th>
                  <th class="text-center">Required</th>
                  <th class="text-center">Checked</th>
                  <th>Issue Date</th>
                  <th>Renewal Date</th>
                </tr>
              </thead>
              <tbody class="bg-white">
                <tr v-for="(document, key) in documents.data" v-bind:key="key">
                  <td :class="{ expired: document.checked == false }">
                    {{ document.name }}
                  </td>
                  <td class="text-center">
                    {{ document.required | isRequired }}
                  </td>
                  <td>
                    <input
                      type="checkbox"
                      class="form-control"
                      size="lg"
                      v-model="document.checked"
                      @click="toggleCheckbox(document.id, key)"
                    />
                  </td>
                  <td>
                    <input
                      name="issue date"
                      type="date"
                      class="form-control"
                      v-model="document.issue_date"
                      @change="update(document)"
                    />
                  </td>
                  <td>
                    <input
                      name="renewal date"
                      type="date"
                      class="form-control"
                      v-model="document.renewal_date"
                      @change="update(document)"
                    />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-4">
      <upload />
    </div>
  </div>
</template>
<script type="text/javascript">
import Upload from "./Upload";

export default {
  components: {
    Upload,
  },
  data: function () {
    return {
      routePrefix: "/api/recruitment/compliance/",
      documents: {
        data: {},
      },
      images: {
        data: {},
      },
      file: "",
      loaded: false,
      edit: false,
      disabled: false,
    };
  },
  computed: {
    applicant: function () {
      return this.$parent.applicant;
    },
    DocumentsCount: function () {
      return _.size(this.documents.data);
    },
    progress: function (data) {
      var checked = 0;
      var documentData = data;
      var newData = documentData.documents.data;
      Object.keys(newData).forEach((doc) => {
        checked += newData[doc].checked;
      });
      var percent = (100 / newData.length) * checked;
      return percent.toFixed(2);
    },
    noImages: function () {
      return _.size(this.images) === 0 ? true : false;
    },
  },
  mounted() {
    this.show();
    this.getDocuments();
  },
  methods: {
    show() {
      axios
        .get(
          "/api/recruitment/compliance/upload/document/" + this.$route.params.id
        )
        .then((response) => {
          this.images.data = response.data;
          console.log(this.images.data);
        })
        .then(() => {
          this.loaded = true;
          console.log(this.loaded);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getDocuments() {
      axios
        .get(this.routePrefix + this.$route.params.id)
        .then((response) => {
          this.documents.data = response.data;
        })
        .then(() => {
          this.loaded = true;
        });
    },
    toggleCheckbox(id, key) {
      if (this.documents.data[key].checked == true) {
        this.destroy(id);
      } else {
        this.store(id);
      }
    },
    store(id) {
      axios
        .post(
          this.routePrefix + this.$route.params.id + "/" + id,
          this.documents,
          this.applicant
        )
        .then((response) => {
          this.success = true;
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        });
    },
    update(document) {
      axios
        .patch(
          this.routePrefix + this.$route.params.id + "/" + document.id,
          document
        )
        .then((response) => {
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        })
        .then(() => {
          this.getDocuments();
        });
    },
    destroy(id) {
      axios
        .delete(this.routePrefix + this.$route.params.id + "/" + id)
        .then((response) => {
          this.$root.notification(response.data.mesaage, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        })
        .then(() => {
          this.getDocuments();
        });
    },
    onFileSelected(event) {
      console.log(event.target.files[0]);
      this.file = event.target.files[0];
    },
    onUpload(event) {
      event.preventDefault();
      let currentObj = this;

      const config = {
        headers: { "content-type": "multipart/form-data" },
      };

      let formData = new FormData();
      formData.append("file", this.file);

      axios
        .post("upload", formData, config)
        .then(function (response) {
          currentObj.success = response.data.success;
        })
        .catch(function (error) {
          currentObj.output = error;
        });
    },
  },
};
</script>
<style lang="scss">
.expired {
  color: rgb(224, 79, 26);
}
</style>
