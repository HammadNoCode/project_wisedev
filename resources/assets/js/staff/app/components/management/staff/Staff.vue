<template>
  <div class="content">
    <div class="row mb-3">
      <div class="col-xs-6 col-sm-6 col-md my-1">
        <h3 class="h3 font-w500 mt-2 mb-0">
          Staff
        </h3>
      </div>
    </div>
    <div class="row mb-4">
      <div class="col">
        <div class="row">
          <div class="col">
            <table class="table table-vcenter table-borderless js-appear-enabled animated fadeIn">
              <thead class="thead-light">
                <tr>
                  <th>Name</th>
                  <th style="width: 30%;">Email</th>
                  <th v-if="administrator"></th>
                  <th>Department</th>
                  <th>Branch</th>
                  <th>Manager</th>
                  <th class="text-center" style="width: 100px;"></th>
                </tr>
              </thead>
              <tbody class="bg-white">
                <tr v-for="account in datatable.data" v-bind:key="account.id">
                  <td>{{ account.name }}</td>
                  <td>
                    <em>{{ account.email }}</em>
                  </td>
                  <td class="text-center" v-if="administrator">
                    <div
                      class="btn-group"
                      v-if="account.id !== user.id || account.management === 1"
                    >
                      <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-original-title="Approve"
                        v-on:click="loginAs(account.id)"
                      >
                        <i class="fa fa-fw fa-sign-in-alt"></i>
                      </button>
                    </div>
                  </td>
                  <td>
                    <select
                      name="department-select"
                      class="form-control"
                      v-model="account.department"
                      v-on:change="updateActive(account)"
                    >
                      <option
                        v-for="department in departments"
                        v-bind:key="department.id"
                        :value="department.id"
                      >{{ department.name }}</option>
                    </select>
                  </td>
                  <td>
                    <select
                      name="department-select"
                      class="form-control"
                      v-model="account.branch_id"
                      v-on:change="updateActive(account)"
                    >
                      <option value="0">Unassign</option>
                      <option
                        v-for="branch in branches"
                        v-bind:key="branch.id"
                        :value="branch.id"
                      >{{ branch.name }}</option>
                    </select>
                  </td>
                  <td>
                    <select
                      name="department-select"
                      class="form-control"
                      v-model="account.manager"
                      v-on:change="updateActive(account)"
                    >
                      <option value="0">No</option>
                      <option value="1">Yes</option>
                    </select>
                  </td>
                  <td class="text-center">
                    <div
                      class="btn-group"
                      v-if="account.id !== user.id || account.management === 1"
                    >
                      <button
                        type="button"
                        class="btn btn-danger"
                        data-original-title="Approve"
                        v-on:click="destoryActiveAlert(account.id)"
                      >
                        <i class="fa fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="bg-light" v-show="datatable.total_pages > 1">
              <div class="row">
                <div class="col">
                  <div class="float-left">
                    <div class="ml-4 mt-3 text">
                      <small>
                        Page {{ datatable.current_page }} of
                        {{ datatable.total_pages }}
                      </small>
                    </div>
                  </div>
                  <div class="float-right">
                    <div
                      class="dataTables_paginate paging_full_numbers px-2"
                      id="DataTables_Table_2_paginate"
                    >
                      <ul class="pagination">
                        <li
                          class="paginate_button page-item"
                          v-for="i in datatable.total_pages"
                          :key="i"
                          v-show="
                            i - datatable.current_page <= 4 &&
                              i - datatable.current_page >= -4
                          "
                        >
                          <a
                            class="page-link mt-3 mr-2 btn btn-sm"
                            :class="{
                              active: datatable.current_page == i,
                              'text-muted': datatable.current_page != i,
                            }"
                            v-on:click.prevent="changePage(i)"
                          >{{ i }}</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row" v-show="pending.length">
      <div class="col">
        <div class="block block-rounded block-bordered mb-3">
          <div class="block-content bg-muted">
            <div class="row">
              <div class="col">
                <h4 class="font-w700 text-white">Deactivated / Awaiting Activation</h4>
              </div>
              <div class="col mb-3"></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <table
              class="table table-vcenter table-borderless table-striped js-appear-enabled animated fadeIn"
            >
              <thead class="thead-light">
                <tr>
                  <th>Name</th>
                  <th style="width: 30%;">Email</th>
                  <th class="text-center" style="width: 100px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in pending" v-bind:key="user.id">
                  <td>{{ user.name }}</td>
                  <td>
                    <em>{{ user.email }}</em>
                  </td>
                  <td class="text-center">
                    <div class="btn-group">
                      <button
                        type="button"
                        class="btn"
                        data-original-title="Approve"
                        v-on:click="updatePending(user.id)"
                      >
                        <i class="fas fa-check text-success"></i>
                      </button>
                      <button
                        type="button"
                        class="btn"
                        data-original-title="Delete"
                        v-on:click="destroyPendingAlert(user.id)"
                      >
                        <i class="fas fa-trash text-danger"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  mounted() {
    this.showPending();
    this.showActive();
    this.showDepartments();
    this.showBranches();
  },
  computed: {
    user: function() {
      return this.$store.state.user;
    },
    administrator: function() {
      return Number(this.$store.state.user.administrator) === 1 ? true : false;
    }
  },
  data: function() {
    return {
      routePrefix: "/api/management/staff/",
      pending: {},
      active: {},
      departments: {},
      branches: {},
      search: "",
      datatable: {
        current_page: 1,
        items_per_page: 15,
        total_pages: 0,
        total_items: 0,
        data: {}
      }
    };
  },
  watch: {
    active: function(newVal) {

      this.assignData();
    }
  },
  methods: {
    showDepartments() {
      axios
        .get(this.routePrefix + "departments")
        .then(response => {
          this.departments = response.data;
        })
        .catch(error => {
          this.$root.notification(error.response.data.message, "error");
        });
    },
    showBranches() {
      axios
        .get(this.routePrefix + "branches")
        .then(response => {
          this.branches = response.data;
        })
        .catch(error => {
          this.$root.notification(error.response.data.message, "error");
        });
    },
    showPending() {
      axios
        .get(this.routePrefix + "awaiting")
        .then(response => {
          this.pending = response.data;
        })
        .catch(error => {
          this.$root.notification("Error (pending)", "error");
        });
    },
    updatePending(id) {
      axios
        .patch(this.routePrefix + "awaiting/" + id)
        .then(response => {
          this.$root.notification(response.data.message, "success");
          this.showPending();
          this.showActive();
        })
        .catch(error => {
          this.$root.notification("Error updating", "error");
        });
    },
    destroyPendingAlert(id) {
      this.$swal
        .fire({
          title: "Are you sure?",
          text: "Deleting the account cannot be undone.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#39AEAC",
          cancelButtonColor: "#495057",
          confirmButtonText: "Delete"
        })
        .then(result => {
          if (result.value) {
            this.destroyPending(id);
          }
        });
    },
    destroyPending(id) {
      axios
        .delete(this.routePrefix + "awaiting/" + id)
        .then(response => {
          this.$root.notification(response.data.message, "success");
          this.showActive();
          this.showPending();
        })
        .catch(error => {
          this.$root.notification(error.response.data.message, "error");
        });
    },
    showActive() {
      axios
        .get(this.routePrefix + "active")
        .then(response => {
          this.active = response.data;

        })
        .catch(error => {
          this.$root.notification("Error (active)", "error");
        });
    },
    updateActive(user) {
      axios
        .patch(this.routePrefix + "active/" + user.id, user)
        .then(response => {
          this.$root.notification(response.data.message, "success");
          this.showActive;
          if (user.id === this.user.id) {
            this.$root.read_user();
          }
        })
        .catch(error => {
          // this.$root.notification("Error updating", "error");
          this.$root.notification(error.response.data.message, "error");
        });
    },
    destroyActiveAlert(id) {
      this.$swal
        .fire({
          title: "Deactivate Account",
          text: "Are you sure you would like to deactivate this account?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#39AEAC",
          cancelButtonColor: "#495057",
          confirmButtonText: "Yes"
        })
        .then(result => {
          if (result.value) {
            this.destroyActive(id);
          }
        });
    },
    destroyActive(id) {
      axios
        .delete(this.routePrefix + "active/" + id)
        .then(response => {
          this.$root.notification(response.data.message, "success");
          this.showActive();
          this.showPending();
        })
        .catch(error => {
          this.$root.notification(error.response.data.message, "error");
        });
    },
    assignData() {
      if (this.active.length) {
        this.datatable.data = this.active.slice(
          (this.datatable.current_page - 1) * this.datatable.items_per_page,
          this.datatable.current_page * this.datatable.items_per_page
        );
        this.datatable.total_items = this.active.length;
        this.datatable.total_pages = Math.ceil(
          this.active.length / this.datatable.items_per_page
        );
      }
    },
    changePage(current_page) {

      event.preventDefault();
      this.datatable.current_page = current_page;
      this.assignData();
    },
    loginAs(id) {
      axios
        .get(this.routePrefix + "login/" + id)
        .then(response => {
          this.$root.notification(response.data.message, "success");
          setTimeout(() => {
            location.reload();
          }, 1000);
        })
        .catch(error => {
          this.$root.notification(error.response.data.message, "error");
        });
    }
  }
};
</script>
