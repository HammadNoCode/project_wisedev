<template lang="pug">
.content
  .row
    .col-12.col-md-12.col-lg-6.col-xl.my-2
      | Callbacks
  .row
    .col-xs-12.col-md-4.js-appear-enabled.animated.fadeIn(
      data-toggle="appear",
      v-for="(block, title) in overview",
      :key="title"
    )
      a.block.block-rounded.text-center.block-fx-pop(
        href="javascript:void(0)",
        v-on:click="overviewFilter(title)"
      )
        .block-content.block-content-full.bg-primary.p-1
        .block-content.block-content-full
          .text-primary.font-w700.mt-3 {{ title.toUpperCase() }}
          .text-black.font-w700.my-3.display-4 {{ block }}
  .row.mb-2.justify-content-end
    .col-12.col-md-3.my-2
      .input-group
        .input-group-prepend
          .input-group-text From
        input.form-control(v-model="filter.from", type="date")
    .col-12.col-md-3.my-2
      .input-group
        .input-group-prepend
          .input-group-text To
        input.form-control(v-model="filter.to", type="date")

    .col-12.col-md-3.my-2
      .input-group
        .input-group-prepend
          .input-group-text Outcome
        select.form-control(v-model="filter['outcome']")
          option(value="0") All
          option(value="1") Pending
          option(value="2") Successful
          option(value="3") Not Interested
          option(value="4") Further Call Required
          option(value="5") Not Available
    .col-12.col-md-3.my-2(v-if="manager")
      .input-group
        .input-group-prepend
          .input-group-text User
        select.form-control(v-model="user", name="Staff")
          option(value="0") All Staff
          optgroup(v-for="department in departments", :label="department.name")
            option(v-for="user in department.staff", :value="user.id") {{ user.name }}
  .row
    .col
      .table-responsive(v-if="loaded && datatable.total > 0")
        table.table.table-hover.table-vcenter.table-borderless.table-striped.js-appear-enabled.animated.fadeIn
          tbody.bg-white
            th Call Title
            th Scheduled Time
            th User
            th Outcome
            th
            tr(v-for="(call, index) in datatable.data", :key="index")
              td {{ call.title }}

              td(
                :class="today.isAfter(call.scheduled) && call.outcome < 2 ? 'text-danger' : ''"
              )
                | {{ formatDate(call.scheduled) }}

              td {{ call.user.name }}

              td
                select.form-control(
                  v-model="call.outcome",
                  v-on:change="changeOutcome(call)"
                )
                  option(value="1") Pending
                  option(value="2") Successful
                  option(value="3") Not Interested
                  option(value="4") Further Call Required
                  option(value="5") Not Available
              td
                .float-right
                  router-link.btn.btn-secondary.my-2(:to="call.path")
                    | View
      div
        loading
  pagination
</template>
<script>
import "date-input-polyfill";
import moment from "moment";
import Pagination from "../layout/tables/Pagination.vue";
import Loading from "../layout/tables/Loading.vue";
export default {
  data: function () {
    return {
      routePrefix: "/api/call-schedule",
      mainTitle: "Call Schedule",
      loaded: false,
      today: moment(),
      filter: {},
      overdue: false,
    };
  },
  computed: {
    manager() {
      return Boolean(Number(this.$store.state.user.manager)) || false;
    },
    departments() {
      return this.$store.state.callUsers || [];
    },
    datatable: {
      get() {
        return this.$store.state.calls.results;
      },
      set(val) {
        this.$store.commit("calls/storeCallsQueryResults", val);
      },
    },
    page: {
      get() {
        return this.datatable.current_page || 1;
      },
      set(val) {
        return (this.datatable.current_page = val);
      },
    },
    user: {
      get() {
        return this.$store.state.calls.filters.user;
      },
      set(val) {
        this.$store.commit("calls/storeCallsUserFilter", val);
        this.index(1);
        this.overviewBlocks();
      },
    },
    overview: {
      get() {
        return this.$store.state.calls.overview;
      },
      set(val) {
        this.$store.commit("calls/storeCallsOverview", val);
      },
    },
  },
  watch: {
    filter: {
      deep: true,
      handler(val) {
        if (val.to) {
          this.$store.commit("calls/storeCallsToFilter", val.to);
        }
        if (val.from) {
          this.$store.commit("calls/storeCallsFromFilter", val.from);
        }
        if (val.outcome) {
          this.$store.commit("calls/storeCallsOutcomeFilter", val.outcome);
        }
        if (val.user) {
          this.$store.commit("calls/storeCallsUserFilter", val.user);
        }

        this.index(1);
      },
    },
  },
  components: {
    Pagination,
    Loading,
  },
  mounted() {
    this.filter = this.$store.state.calls.filters;
    this.init();
  },
  methods: {
    init() {
      this.$route.query.user &&
        this.$store.commit(
          "calls/storeCallsUserFilter",
          Number(this.$route.query.user)
        );
      this.$route.query.outcome &&
        this.$store.commit(
          "calls/storeCallsOutcomeFilter",
          Number(this.$route.query.outcome)
        );
      this.dateRange();

      if (_.size(this.departments) > 0) {
        if (_.size(this.datatable.data) == 0) {
          this.index(1);
        }
      }

      this.overviewBlocks();
      this.pushQuery();
      this.loaded = true;
    },
    index(page) {
      this.loaded = false;
      var route = this.routePrefix;
      var staff_ids = [];

      this.departments.map(function (department) {
        department.staff.map(function (user) {
          staff_ids.push(user.id);
        });
      });

      route += "?page=" + page;
      route += "&outcome=" + this.filter.outcome;
      if (!this.overdue) {
        route += "&from=" + this.filter.from;
        route += "&to=" + this.filter.to;
      } else {
        route += "&overdue=true";
        this.overdue = false;
      }

      route += this.manager ? "&user=" + this.user : "&user=0";
      axios
        .post(route, {
          user_id: this.$store.state.user.id,
          staff_array: staff_ids,
        })
        .then((response) => {
          this.datatable = response.data;
          this.pushQuery();
        })
        .then(() => {
          this.loaded = true;
        });
    },
    overviewBlocks() {
      var route = this.routePrefix + "/overview",
        staff_ids = [];
      this.departments.map(function (department) {
        department.staff.map(function (user) {
          staff_ids.push(user.id);
        });
      });
      route += this.manager ? "?user=" + this.user : "?user=0";
      axios
        .post(route, {
          staff_array: staff_ids,
        })
        .then((response) => {
          this.overview = response.data;
        })
        .then(() => {
          this.loaded = true;
        });
    },
    overviewFilter(title) {
      switch (title.toLowerCase()) {
        case "today":
          this.filter = {
            outcome: 1,
            from: this.today.format("YYYY-MM-DD"),
            to: this.today.format("YYYY-MM-DD"),
          };

          break;
        case "tomorrow":
          this.filter = {
            outcome: 1,
            from: this.today.clone().add(1, "days").format("YYYY-MM-DD"),
            to: this.today.clone().add(1, "days").format("YYYY-MM-DD"),
          };

          break;
        default:
          this.overdue = true;
          this.filter = {
            outcome: 1,
            from: "0000-00-00",
            to: this.today.clone().format("YYYY-MM-DD"),
          };
          break;
      }
    },
    changeOutcome(call) {
      if (Number(call.outcome) > 3) {
        this.captureDate(call);
      } else {
        this.update(call);
      }

      this.overviewBlocks();
    },
    captureDate(call) {
      this.$swal
        .fire({
          title: "Set a date for the next call?",
          icon: "question",
          html: '<input id="swal-input1" class="swal2-input" type="datetime-local">',
          preConfirm: () => {
            return document.getElementById("swal-input1").value;
          },
          showCancelButton: true,
          confirmButtonColor: "#39AEAC",
          cancelButtonColor: "#495057",
          confirmButtonText: "Submit",
        })
        .then((result) => {
          if (result.dismiss) {
            this.index(this.page);
          } else {
            call.nextCall = result.value;
            this.update(call);
            this.overviewBlocks();
          }
        });
    },
    update(call) {
      axios
        .patch(this.routePrefix + "/" + call.id, call)
        .then((response) => {
          this.index(this.page);
          this.$root.notification(response.data.message, "success");
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        });
    },
    pushQuery() {
      this.$router
        .push({
          query: {
            outcome: this.filter.outcome,
            from: this.filter.from,
            to: this.filter.to,
            user: this.user,
          },
        })
        .catch(() => {});
    },
    changePage(current_page) {
      if (current_page <= this.datatable.last_page && current_page > 0) {
        this.index(current_page);
      }
    },
    formatDate(date) {
      return moment(date).format("DD/MM/YYYY h:mma");
    },
    dateRange() {
      var weekStart = this.today.clone().startOf("week").format("YYYY-MM-DD"),
        weekEnd = this.today.clone().endOf("week").format("YYYY-MM-DD");

      if (this.$route.query.from) {
        this.filter.from = this.$route.query.from;
      } else {
        this.filter.from = weekStart;
      }
      if (this.$route.query.to) {
        this.filter.to = this.$route.query.to;
      } else {
        this.filter.to = weekEnd;
      }
    },
  },
};
</script>
<style>
date-input-polyfill {
  z-index: 1000000 !important;
}
</style>
