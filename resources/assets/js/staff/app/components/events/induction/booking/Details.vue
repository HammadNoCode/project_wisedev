<template>
    <div>
        <form>
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Event Details</h3>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center py-sm-3 py-md-4">
                        <div class="col-sm-10 col-md-10">
                            <div class="form-row">
                                <div class="form-group col-md-4 col-12">
                                    <label for="block-form7-username">Type</label>
                                    <select name="type" class="form-control selectpicker" v-model="event.type">
                                        <option selected disabled>Select Event Type</option>
                                        <option value="1">Induction</option>
                                        <option value="2">Training</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label for="block-form7-password">Attendee Type</label>
                                    <select name="attendee_type" class="form-control selectpicker" v-model="event.attendee_type">
                                        <option value="0" selected disabled>
                                        Select Event Type
                                        </option>
                                        <option value="1">Applicant & Staff</option>
                                        <option value="2">Applicant</option>
                                        <option value="3">Staff</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 col-12">
                                  <label for="block-form7-password">Agenda</label>
                                  <input name="agenda" class="form-control selectpicker" placeholder="E.g. Health & Safety" v-model="event.agenda" />
                                </div>
                            </div>
                            <div class="form-row mt-2">
                                <div class="form-group col-md-6 col-12">
                                    <label for="block-form7-password">Date</label>
                                    <input type="date" name="date" :min="todaysDate" class="form-control" v-model="event.date"/>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label for="block-form7-password">Time</label>
                                    <input type="time" name="time" class="form-control" v-model="event.time"/>
                                </div>
                            </div>
                            <div class="form-row mt-2">
                                <div class="form-group col-md-4 col-12">
                                    <label for="block-form7-password">Address</label>
                                    <input type="text" name="address" class="form-control" v-model="event.address"/>
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label for="block-form7-password">City</label>
                                    <select name="location" class="form-control selectpicker" v-model="event.location">
                                        <option selected disabled>Select Event location</option>
                                        <option value="blackburn">Blackburn</option>
                                        <option value="liverpool">Liverpool</option>
                                        <option value="warrington">Warrington</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label for="block-form7-password">Postcode</label>
                                    <input type="text" name="postcode" class="form-control" v-model="event.postcode"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light text-right">
                    <button type="button" class="btn btn-success" @click="update">
                        <i class="fa fa-save mr-1"></i> Save
                    </button>
                </div>
            </div>
        </form>
     </div>
</template>
<script>
import moment from "moment";

export default {
  computed: {
    event: function () {
      return this.$parent.event;
    },
    todaysDate: function () {
      return moment().format("YYYY-MM-DD");
    },
    loaded: function () {
      return this.$parent.loaded;
    },
  },
  data: function () {
    return {
      routePrefix: "/api/events/induction/booking/",
      newEvent: {},
      disabled: false,
    };
  },
  methods: {
    update() {
      this.disabled = true;
      axios
        .patch(this.routePrefix + this.event.id, this.event)
        .then((response) => {
          this.disabled = false;
          this.$parent.showEvent();
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        })
        .then((response) => {
          this.disabled = false;
        });
    },
    getBranches() {
      axios.get(this.routePrefix + "branch").then((response) => {
        this.applicant = response.data;
      });
    },
  },
};
</script>
