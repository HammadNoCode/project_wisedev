<template>
    <div class="content">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md my-auto">
                <div class="mt-2 mb-0">
                    <div class="h3" v-if="event.type == 1">
                        <span>Induction - </span><span class="text-muted" style="text-transform: capitalize;">{{ event.location }}</span>
                    </div>
                    <div class="h3" v-else>
                        <span>Training - </span><span class="text-muted" style="text-transform: capitalize;">{{ event.location }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-2">
            <div class="col-12">
                <div role="group" aria-label="1" class="btn-group btn-block">
                    <button 
                        :class="{ active: tab == 'event' }"
                        @click="tab = 'event'"
                        class="btn btn-light" 
                    >
                        <i class="far fa-calendar-alt pr-2"></i>Event
                    </button>
                    <button 
                        :class="{ active: tab == 'attendee' }"
                        @click="tab = 'attendee'"
                        class="btn btn-light" 
                    >
                    <i class="fas fa-list pr-2"></i>Attendees
                    </button>
                    <button
                        type="button"
                        class="btn btn-danger"
                        data-original-title="View"
                        v-on:click="destroyAlert(event.id)"
                        :disabled="edit"
                    >
                        <i class="fa fa-trash"></i> Cancel Event
                    </button>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <div v-if="tab === 'event'">
                    <event />
                </div>
                <div v-if="tab === 'attendee'">
                    <attendee />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Event from "./booking/Details";
import Attendee from "./booking/Attendee";

export default {
  computed: {
    production: function () {
      return window.location.href.includes("cavalrycare.co.uk") ? true : false;
    },
    currentTab: function () {
      return this.$route.params.tab || "event";
    },
  },
  data: function () {
    return {
      event: {
        attendees: {},
      },
      tab: "event",
      routePrefix: "/api/events/induction/booking/",
      edit: false,
      loaded: false,
    };
  },
  components: {
    Event,
    Attendee,
  },
  mounted: function () {
    this.showEvent();
  },
  methods: {
    showEvent() {
      this.loaded = false;
      axios
        .get(this.routePrefix + this.$route.params.id)
        .then((response) => {
          this.event = response.data;
        })
        .then(() => {
          this.loaded = true;
        });
    },
    destroyAlert(id) {
      this.$swal
        .fire({
          title: "Delete Event",
          text: "Are you sure you would like to delete this event?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#39AEAC",
          cancelButtonColor: "#495057",
          confirmButtonText: "Yes",
        })
        .then((result) => {
          if (result.value) {
            this.destroy(id);
          }
        });
    },
    destroy(id) {
      axios
        .delete(this.routePrefix + id)
        .then((response) => {
          this.$router.push("/events/induction/booking");
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        })
        .then(() => {
          this.routerPrefix;
        });
    },
  },
};
</script>
<style scoped>
.btn-light:hover {
    color: #212529;
    background-color: #e1effe;
    border-color: #e1effe;
}
</style>
