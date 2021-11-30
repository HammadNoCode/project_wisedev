<template>
  <div>
    <div class="row mb-4">
      <div class="col input-group">
        <div class="input-group-append">
          <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
        <input
          class="form-control"
          :placeholder="'Search...'"
          v-model="filter.search"
        />
      </div>
    </div>
    <div class="row mb-4">
      <div class="col-lg-4 input-group">
        <div class="input-group-append">
          <span class="input-group-text">Postion</span>
        </div>
        <select class="form-control selectpicker" v-model="filter.position">
          <option value selected disabled>Positions</option>
          <option value="all">All</option>
          <option value="Healthcare Assistant">Healthcare Assistant</option>
          <option value="Senior Healthcare Assistant">
            Senior Healthcare Assistant
          </option>
          <option value="RGN">RGN</option>
          <option value="RMN">RMN</option>
          <option value="Support Worker">Support Worker</option>
        </select>
      </div>
      <div class="col-lg-4 input-group">
        <div class="input-group-append">
          <span class="input-group-text">Branches</span>
        </div>
        <select class="form-control selectpicker" v-model="filter.branch">
          <option value selected disabled>Branches</option>
          <option value="all">All</option>
          <option
            class="optionpicker"
            v-for="branch in branches"
            :key="branch.id"
            :value="branch.id"
          >
            {{ branch.name }}
          </option>
        </select>
      </div>
      <div class="col-lg-4 input-group">
        <div class="input-group-append">
          <span class="input-group-text">Driver</span>
        </div>
        <select
          class="form-control selectpicker"
          name="driver"
          id="driver"
          v-model="filter.driver"
        >
          <option value="all">All</option>
          <option value="yes">Yes</option>
          <option value="no">No</option>
        </select>
      </div>
    </div>
    <div class="row pb-4">
      <div class="col-lg-4 input-group">
        <div class="input-group-append">
          <span class="input-group-text">Shift Type</span>
        </div>
        <select
          class="form-control selectpicker"
          name="shift"
          id="shift"
          v-model="filter.shift"
        >
          <option value="all">All</option>
          <option value="days">Days</option>
          <option value="nights">Nights</option>
          <option value="both">Both</option>
        </select>
      </div>
      <div class="col-lg-4 input-group">
        <div class="input-group-append">
          <span class="input-group-text">Score</span>
        </div>
        <select
          class="form-control selectpicker"
          name="score"
          id="score"
          v-model="filter.score"
        >
          <option value="all">All</option>
          <option value="0-4">0-4</option>
          <option value="5-7">5-7</option>
          <option value="8-10">8+</option>
        </select>
      </div>
      <div class="col-lg-4 input-group">
        <div class="input-group-append">
          <span class="input-group-text">Favourite</span>
        </div>
        <select
          class="form-control selectpicker"
          name="favourite"
          id="favourite"
          v-model="filter.favourite"
        >
          <option value="all">All</option>
          <option value="yes">Yes</option>
          <option value="no">No</option>
        </select>
      </div>
    </div>
    <div class="row pb-4">
      <div class="col-lg-4 input-group">
        <div class="input-group-append">
          <span class="input-group-text">Compliance</span>
        </div>
        <select
          class="form-control selectpicker"
          name="compliance"
          id="compliance"
          v-model="filter.compliance"
        >
          <option value="all">All</option>
          <option value="most">Most Compliant</option>
          <option value="least">Least Compliant</option>
        </select>
      </div>
      <div class="col-lg-4 input-group">
        <div class="input-group-append">
          <span class="input-group-text">Sort By</span>
        </div>
        <select
          class="form-control selectpicker"
          name="sort"
          id="sort"
          v-model="filter.sort"
        >
          <option value="newest">Newest</option>
          <option value="oldes">Oldest</option>
        </select>
      </div>
      <div class="col-lg-4 col-12 input-group">
        <div class="input-group-append">
          <span class="input-group-text">Hours/pw</span>
        </div>
        <select
          class="form-control selectpicker"
          name="hours/pw"
          id="hours/pw"
          v-model="filter.hourspw"
        >
          <option value="all">All</option>
          <option value="0-24">0-24</option>
          <option value="25-48">25-48</option>
          <option value="49+">48+</option>
        </select>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  computed: {
    filter: {
      get() {
        return this.$store.state.pipeline.filters;
      },
      set(newVal) {
        return (this.$store.state.pipeline.filters = newVal);
      },
    },
    position: {
      get() {
        return this.$store.state.pipeline.filters.position;
      },
      set(newVal) {
        return (this.$store.state.pipeline.filters.position = newVal);
      },
    },
    branches: function () {
      return this.$store.state.pipeline.branches;
    },
    datatable: function () {
      return this.$store.state.pipeline.datatable;
    },
  },
  watch: {
    filter: {
      deep: true,
      handler: function (val) {
        this.$store.dispatch("pipeline/getDatatable", {
          filters: this.filter,
          datatable: this.datatable,
        });
        this.$store.dispatch("pipeline/getStats", {
          filters: this.filter,
        });
      },
    },
  },
  mounted() {
    this.getBranches();
  },
  methods: {
    async getBranches() {
      await this.$store.dispatch("pipeline/getBranches", this.branches);
    },
  },
};
</script>