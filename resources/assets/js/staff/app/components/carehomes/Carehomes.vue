<template>
  <div class="content">
    <div class="row py-3">
      <div class="col-md-8 col-12 my-auto">
        <h3 class="mb-0">Carehomes</h3>
      </div>
      <div class="col-md-4 col-12 my-auto">
        <button
          class="btn btn-primary float-right"
          v-show="showFilters == false"
          @click="showFilters = true"
        >
          <i class="fas fa-plus pr-1"></i> Show Filters
        </button>
        <button
          class="btn btn-danger float-right"
          v-show="showFilters == true"
          @click="showFilters = false"
        >
          <i class="fas fa-times pr-1"></i> Hide Filters
        </button>
      </div>
    </div>
    <div v-show="showFilters == true">
      <div class="row py-2">
        <div class="col-lg-4 col-12 my-auto input-group py-1">
          <div class="input-group-append">
            <span id="basic-addon1" class="input-group-text">Favourited</span>
          </div>
          <select name="bed filter" class="form-control" v-model="favourited">
            <option disabled selected>Favourited</option>
            <option value="all">All</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
          </select>
        </div>
        <div class="col-lg-8 ml-auto my-auto input-group py-1">
          <div class="input-group-append">
            <span id="basic-addon1" class="input-group-text">
              <i class="fa fa-fw fa-search"></i>
            </span>
          </div>
          <input
            type="text"
            class="form-control"
            v-model="search"
            :placeholder="'Search name or region...'"
          />
        </div>
      </div>
      <div class="row py-2">
        <div class="col-lg-4 col-12 my-auto input-group py-1">
          <div class="input-group-append">
            <span id="basic-addon1" class="input-group-text"> Ratings </span>
          </div>
          <select name="rating filter" class="form-control" v-model="filter">
            <option disabled selected>Ratings</option>
            <option value="all">All</option>
            <option
              v-for="(rating, key) in ratings"
              :key="key"
              :value="rating.rating"
            >
              {{ rating.rating }}
            </option>
          </select>
        </div>
        <div class="col-lg-4 col-12 my-auto input-group py-1">
          <div class="input-group-append">
            <span id="basic-addon1" class="input-group-text"> Beds </span>
          </div>
          <select name="bed filter" class="form-control" v-model="range">
            <option disabled selected>Beds Range</option>
            <option value="all">All</option>
            <option value="0-20">0-20</option>
            <option value="21-40">21-40</option>
            <option value="41">41+</option>
          </select>
        </div>
        <div class="col-lg-4 col-12 my-auto input-group py-1">
          <div class="input-group-append">
            <span id="basic-addon1" class="input-group-text"> Branch </span>
          </div>
          <select name="bed filter" class="form-control" v-model="branch">
            <option disabled selected>Branches</option>
            <option value="all">All</option>
            <option value="1">lancashire</option>
            <option value="2">warrington</option>
            <option value="3">Crewe</option>
            <option value="4">liverpool</option>
            <option value="5">manchester</option>
              <option value="6">leeds</option>
              <option value="7">shrewsbury</option>
              <option value="8">chester</option>
              <option value="9">permanent</option>
              <option value="10">complex care</option>
              <option value="11">head office</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row py-3">
      <div class="col-12">
        <div
          class="
            js-wizard-simple
            block block-rounded
            js-appear-enabled
            animated
            fadeIn
          "
        >
          <div
            class="
              block-content block-content-full
              tab-content
              table-responsive
            "
            v-if="loaded"
          >
            <table class="table table-bordered table->stripped table-vcenter">
              <thead class="thead-light" v-if="datatable.data.length">
                <tr>
                  <th class="d-table-cell d-lg-none">Carehomes</th>
                  <th class="d-none d-lg-table-cell">Name</th>
                  <th class="d-none d-lg-table-cell">Contact No.</th>
                  <th class="d-none d-lg-table-cell">Region</th>
                  <th class="d-none d-lg-table-cell text-center">Rating</th>
                  <th class="d-none d-lg-table-cell text-center">Favourited</th>
                  <th class="d-none d-lg-table-cell"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(carehome, key) in datatable.data" :key="key">
                  <td class="d-table-cell d-lg-none">
                    <div class="my-2">
                      <h5>{{ carehome.name }}</h5>
                    </div>
                    <div class="my-2">
                      <p>Contact No: {{ carehome.main_contact_number }}</p>
                    </div>
                    <div class="my-2">
                      <p>Region: {{ carehome.region }}</p>
                    </div>
                    <div class="my-2">
                      <p>{{ carehome.agency_status }}</p>
                    </div>
                    <div class="my-2">
                      <p>{{ carehome.status }}</p>
                    </div>
                    <div class="my-2">
                      <button
                        v-show="carehome.favourited == 1"
                        type="button"
                        class="btn"
                        :class="{ favourited: carehome.favourited == 1 }"
                        @click="update(carehome.id, { favourited: 0 })"
                      >
                        <i class="fas fa-star fa-2x"></i>
                      </button>
                      <button
                        v-show="carehome.favourited == 0"
                        type="button"
                        class="btn"
                        @click="update(carehome.id, { favourited: 1 })"
                      >
                        <i class="fas fa-star fa-2x"></i>
                      </button>
                    </div>
                    <div class="my-2">
                      <p>
                        Rating:
                        <span
                          :class="{
                            outstanding: carehome.rating == 'Outstanding',
                            good: carehome.rating == 'Good',
                            improvement:
                              carehome.rating == 'Requires improvement',
                            inadequate: carehome.rating == 'Inadequate',
                          }"
                          >{{ carehome.rating }}</span
                        >
                      </p>
                    </div>
                    <div class="my-2">
                      <p>Beds: {{ carehome.beds }}</p>
                    </div>
                    <div class="my-2">
                      <router-link
                        class="btn btn-secondary"
                        :to="'/carehome/list/' + carehome.location_id"
                      >
                        View
                      </router-link>
                    </div>
                  </td>
                  <td class="d-none d-lg-table-cell">{{ carehome.name }}</td>
                  <td class="d-none d-lg-table-cell">
                    {{ carehome.main_contact_number }}
                  </td>
                  <td class="d-none d-lg-table-cell">{{ carehome.region }}</td>
                  <td
                    class="d-none d-lg-table-cell text-center"
                    :class="{
                      outstanding: carehome.rating == 'Outstanding',
                      good: carehome.rating == 'Good',
                      improvement: carehome.rating == 'Requires improvement',
                      inadequate: carehome.rating == 'Inadequate',
                    }"
                  >
                    {{ carehome.rating }}
                  </td>
                  <td
                    class="text-center d-none d-lg-table-cell"
                    v-if="carehome.favourited == 1"
                  >
                    <button
                      type="button"
                      class="btn"
                      :class="{ favourited: carehome.favourited == 1 }"
                      @click="update(carehome.id, { favourited: 0 })"
                    >
                      <i class="fas fa-star fa-2x"></i>
                    </button>
                  </td>
                  <td class="text-center d-none d-lg-table-cell" v-else>
                    <button
                      type="button"
                      class="btn"
                      @click="update(carehome.id, { favourited: 1 })"
                    >
                      <i class="fas fa-star fa-2x"></i>
                    </button>
                  </td>
                  <td class="d-none d-lg-table-cell text-center">
                    <router-link
                      class="btn btn-sm btn-secondary"
                      :to="'/carehome/list/' + carehome.location_id"
                    >
                      View
                    </router-link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div>
            <loading />
          </div>
          <div
            class="
              block-content block-content-full block-content-sm
              bg-body-light
            "
          >
            <pagination />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Pagination from "../layout/tables/Pagination";
import Loading from "../layout/tables/Loading";
export default {
  computed: {
    user_account() {
      return this.$store.state.user;
    },
  },
  data() {
    return {
      routePrefix: "/api/carehome/detail/",
      datatable: {
        data: {},
        current_page: 1,
        per_page: 15,
        last_page: 0,
        total: 1,
      },
      ratings: {},
      filter: "all",
      range: "all",
      search: "",
      branch: "all",
      favourited: "all",
      loaded: false,
      showFilters: false,
    };
  },
  components: {
    Pagination,
    Loading,
  },
  watch: {
    search: function (val) {
      var search_check = this.search;
      setTimeout(() => {
        if (search_check == this.search) {
          this.index(1);
        }
      }, 500);
    },
    filter: function (val) {
      this.index(1);
    },
    range: function (val) {
      this.index(1);
    },
    branch: function (val) {
      this.index(1);
    },
    favourited: function (val) {
      this.index(1);
    },
  },
  mounted() {
    if (this.$route.query.page) {
      this.datatable.current_page = this.$route.query.page;
    }
    if (this.$route.query.search) {
      this.search = this.$route.query.search;
    }
    if (this.$route.query.filter) {
      this.filter = this.$route.query.filter;
    }
    if (this.$route.query.range) {
      this.range = this.$route.query.range;
    }
    if (this.$route.query.branch) {
      this.branch = this.$route.query.branch;
    }
    if (this.$route.query.favourited) {
      this.favourited = this.$route.query.favourited;
    }
    this.index(
      this.datatable.current_page,
      this.filter,
      this.range,
      this.branch,
      this.favourited
    );
    this.getCarehomeRatings();
  },
  methods: {
    index(page) {
      var route = this.routePrefix + "?";
      route += "page=" + page;
      route += "&search=" + this.search;
      route += "&filter=" + this.filter;
      route += "&range=" + this.range;
      route += "&branch=" + this.branch;
      route += "&favourited=" + this.favourited;
      this.loaded = false;
      this.$router
        .push({
          query: {
            page: page,
            search: this.search,
            filter: this.filter,
            range: this.range,
            branch: this.branch,
            favourited: this.favourited,
          },
        })
        .catch((error) => {});
      axios
        .get(route)
        .then((response) => {
          this.datatable = response.data;
        })
        .then(() => {
          this.loaded = true;
        });
    },
    changePage(current_page) {
      if (current_page <= this.datatable.last_page && current_page > 0) {
        this.datatable.current_page = current_page;
        this.index(current_page);
      }
    },
    getCarehomeRatings() {
      axios
        .get(this.routePrefix + "ratings")
        .then((response) => {
          this.ratings = response.data;
        })
        .catch((error) => {});
    },
    update(id, data) {
      if (this.user_account.manager == 1) {
        axios
          .patch("/api/carehome/detail/" + id, {
            id: id,
            favourited: data,
          })
          .then((res) => {
            this.index(1);
          });
      }
    },
  },
};
</script>
<style scoped>
.outstanding,
.good {
  background-color: #77dd77;
}
.improvement {
  background-color: #ffb347;
}
.inadequate {
  background-color: #ff6961;
}
.favourited {
  color: gold;
}
</style>
