<template>
  <div class="content">
    <div class="row my-3">
      <div class="col-12">
        <h3 class="mb-0 my-2">{{ carehome.name | capitalize }}</h3>
      </div>
    </div>
    <div class="d-block d-md-none">
      <div class="row py-1">
        <div class="col-12 py-1">
          <div role="group" aria-label="1" class="btn-group btn-block">
            <button
              :class="{ active: tab == 'profile' }"
              @click="tab = 'profile'"
              class="btn btn-light"
            >
              <i class="far fa-user-circle pr-1"></i> Profile
            </button>
          </div>
        </div>
      </div>
      <div class="row py-1">
        <div class="col-12 py-1">
          <div role="group" aria-label="1" class="btn-group btn-block">
            <button
              :class="{ active: tab == 'contacts' }"
              @click="tab = 'contacts'"
              class="btn btn-light"
            >
              <i class="far fa-address-book pr-1"></i> Key Contacts
            </button>
            <button
              :class="{ active: tab == 'calls' }"
              @click="tab = 'calls'"
              class="btn btn-light"
            >
              <i class="fas fa-phone pr-1"></i> Calls
            </button>
          </div>
        </div>
      </div>
      <div class="row py-1">
        <div class="col-12 py-1">
          <div role="group" aria-label="1" class="btn-group btn-block">
            <button
              :class="{ active: tab == 'onboarding' }"
              @click="tab = 'onboarding'"
              class="btn btn-light"
            >
              <i class="fas fa-check-square pr-1"></i> Onboarding
            </button>
            <button
              :class="{ active: tab == 'notes' }"
              @click="tab = 'notes'"
              class="btn btn-light"
            >
              <i class="fas fa-pencil-alt pr-1"></i> Notes
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="row py-3 d-none d-md-block">
      <div class="col-12">
        <div role="group" aria-label="1" class="btn-group btn-block">
          <button
            :class="{ active: tab == 'profile' }"
            @click="tab = 'profile'"
            class="btn btn-light"
          >
            <i class="far fa-user-circle pr-1"></i> Profile
          </button>
          <button
            :class="{ active: tab == 'contacts' }"
            @click="tab = 'contacts'"
            class="btn btn-light"
          >
            <i class="far fa-address-book pr-1"></i> Key Contacts
          </button>
          <button
            :class="{ active: tab == 'calls' }"
            @click="tab = 'calls'"
            class="btn btn-light"
          >
            <i class="fas fa-phone pr-1"></i> Calls
          </button>
          <button
            :class="{ active: tab == 'onboarding' }"
            @click="tab = 'onboarding'"
            class="btn btn-light"
          >
            <i class="fas fa-check-square pr-1"></i> Onboarding
          </button>
          <button
            :class="{ active: tab == 'notes' }"
            @click="tab = 'notes'"
            class="btn btn-light"
          >
            <i class="fas fa-pencil-alt pr-1"></i> Notes
          </button>
        </div>
      </div>
    </div>
    <div v-if="tab == 'profile'">
      <profile />
    </div>
    <div v-if="tab == 'contacts'">
      <contacts />
    </div>
    <div v-if="tab == 'calls'">
      <calls />
    </div>
    <div v-if="tab == 'onboarding'">
      <onboarding />
    </div>
    <div v-if="tab == 'notes'">
      <notes />
    </div>
  </div>
</template>
<script>
import Profile from "./components/Profile";
import Contacts from "./components/Contacts";
import Calls from "./components/CallHistory";
import Onboarding from "./components/Onboarding";
import Notes from "./components/Notes";

export default {
  components: {
    Profile,
    Contacts,
    Calls,
    Onboarding,
    Notes,
  },
  data: function () {
    return {
      routePrefix: "/api/carehome/",
      tab: "profile",
      carehome: {},
      edit: false,
      disabled: false,
    };
  },
  mounted() {
    this.showCarehome();
  },
  methods: {
    showCarehome() {
      axios
        .get("/api/carehome/detail/" + this.$route.params.id)
        .then((response) => {
          this.carehome = response.data;
        })
        .catch((error) => {});
    },
  },
};
</script>
<style scoped>
button {
  border-bottom-left-radius: 0px !important;
  border-bottom-right-radius: 0px !important;
}
.btn-light:hover {
  color: #212529;
  background-color: #e1effe;
  border-color: #e1effe;
}
</style>