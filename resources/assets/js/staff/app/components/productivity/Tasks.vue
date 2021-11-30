<template>
  <div class="content">
    <div class="row">
      <div class="col-md py-3 d-md-flex align-items-md-center text-center">
        <div class="col-12 col-md d-md-flex align-items-md-center">
            <div class="py-4 py-md-0 text-center text-md-left js-appear-enabled animated fadeIn" data-toggle="appear">
                <h3 class="mb-2">Task List </h3>
            </div>
        </div>
      </div>
      <div class="col-md-auto col-12 my-auto" v-if="manager">
        <select
          class="form-control"
          v-model="staff"
          v-on:change="filterTasks(1)"
        >
          <option
            class="optionpicker"
            v-for="staff in users"
            v-bind:key="staff.id"
            :value="staff.id"
            >{{ staff.name }}</option
          >
        </select>
      </div>
    </div>
    <div>
      <div class="js-tasks">
        <ValidationObserver v-slot="{ handleSubmit }" ref="form">
          <form @submit.prevent="handleSubmit(store)">
            <div class="js-wizard-simple block block-rounded js-appear-enabled animated fadeIn">
              <div class="row block-content block-content-full">
                <div class="col-md-7 col-12">
                  <ValidationProvider :rules="{ required: true }" v-slot="v">
                    <div class="input-group mb-3 pt-3">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01"
                          >New Task</label
                        >
                      </div>
                      <input
                        class="form-control"
                        type="text"
                        name="Description"
                        placeholder="Description"
                        v-model="newTask.description"
                      />
                    </div>
                    <span class="text-danger">{{ v.errors[0] }}</span>
                  </ValidationProvider>
                </div>
                <div class="col-md-5 col-12 animated fadeIn">
                  <div class="input-group mb-3 pt-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01"
                        >Completion Date?</label
                      >
                    </div>
                    <input
                      type="date"
                      class="form-control"
                      name="Scheduled date"
                      v-model="newTask.scheduled_at"
                      :min="yesterday"
                    />
                  </div>
                </div>
                <div class="col-md-4 col-12 animated fadeIn">
                  <div class="input-group mb-3 pt-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01"
                        >Repeat?</label
                      >
                    </div>
                    <select
                      class="custom-select form-control"
                      id="inputGroupSelect01"
                      v-model="newTask.repeat"
                    >
                      <option value="1">Daily</option>
                      <option value="2">Weekly</option>
                      <option value="3">Monthly</option>
                      <option value="0">No</option>
                    </select>
                  </div>
                </div>
                <div
                  class="col-md-4 col-12 animated fadeIn"
                  v-if="manager"
                >
                  <div class="input-group mb-3 pt-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01"
                        >Assign Staff?</label
                      >
                    </div>
                    <select
                      class="custom-select form-control"
                      id="inputGroupSelect01"
                      v-model="newTask.staff_assigned"
                    >
                      <option
                        class="optionpicker"
                        v-for="staff in users"
                        v-bind:key="staff.id"
                        :value="staff.id"
                        >{{ staff.name }}</option
                      >
                    </select>
                  </div>
                </div>
                <div class="col-md-4 col-12 pt-3 pb-3">
                  <button
                    class="btn btn-outline-success"
                    type="submit"
                    name="button"
                  >
                    <i class="fa fa-check"></i> Save
                  </button>
                </div>
              </div>
            </div>
          </form>
        </ValidationObserver>
        <div v-for="(list, name) in tasks" :key="name">
          <div class="block-title font-w700 text-dark mt-4 mb-2">
            {{ name | capitalize }}
            <span
              class="js-task-badge badge badge-pill badge-light animated fadeIn"
            ></span>
            <span class="badge badge-secondary float-right">
              {{ name == "completed" ? list.total : list.data.length }}
            </span>
          </div>
          <div class="js-task-list" v-if="loaded">
            <div
              class="js-task block block-rounded block-fx-pop mb-2 animated fadeIn"
              v-for="(task, index) in list.data"
              :key="index"
            >
              <table class="table table-borderless table-vcenter mb-0">
                <tbody>
                  <tr>
                    <td class="text-center" width="20px">
                      <div
                        class="custom-control custom-checkbox custom-control-success d-inline-block"
                      >
                        <input
                          type="checkbox"
                          class="custom-control-input"
                          :id="'row_' + task.id"
                          :name="'row_' + task.id"
                          v-on:input="update(task.id, task.status)"
                          :value="task.status"
                          :checked="task.status == 1 ? true : false"
                        />
                        <label
                          class="custom-control-label"
                          :for="'row_' + task.id"
                        ></label>
                      </div>
                    </td>
                    <td v-if="task.status == 1" class="my-auto">
                      <del class="font-w600 mb-1 my-auto">{{
                        task.description | capitalize
                      }}</del>
                    </td>
                    <td v-else class="my-auto">
                      <p class="font-w600 mb-1 my-auto">
                        {{ task.description | capitalize }}
                      </p>
                    </td>
                    <td width="50px">
                      <h4
                        class="font-w600 mb-1"
                        v-if="task.repeat_occurance && task.status != 1"
                      >
                        <span class="badge badge-light">
                          <i class="far fa-clock mr-1"></i>
                          {{ task.repeat_occurance }}
                        </span>
                      </h4>
                    </td>
                    <td width="100px" v-if="task.status != 1">
                      <div v-if="task.scheduled_at != null">
                        <h4
                          class="font-w600 mb-1"
                          v-html="pastDue(task.scheduled_at)"
                        ></h4>
                      </div>
                    </td>
                    <td width="300px" v-if="task.status == 1">
                      <h4 class="font-w600 mb-1 float-right">
                        <span
                          class="badge badge-light"
                          v-if="task.scheduled_at != null"
                        >
                          <i class="far fa-calendar-alt mr-1"></i>
                          {{ task.scheduled_at | timestamp }}
                        </span>
                        <span class="badge badge-light">
                          <i class="far fa-check-circle mr-1"></i>
                          {{ task.updated_at | timestamp }}
                        </span>
                      </h4>
                    </td>
                    <td width="50px">
                      <h4 class="font-w600 mb-1">
                        <span class="badge badge-light">
                          <i class="fa fa-user mr-1"></i>
                          {{ task.user_id }}
                        </span>
                      </h4>
                    </td>
                    <td width="50px" v-if="task.status == 0">
                      <h4 class="font-w600 mb-0">
                        <a v-on:click="destroyAlert(task.id)">
                          <i class="fa fa-times" style="color:#e04f1a"></i>
                        </a>
                      </h4>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div
            class="js-task-list js-task block block-rounded block-fx-pop mb-2 animated fadeIn"
            v-if="name == 'completed' && list.total > 10"
          >
            <div class="row">
              <div class="col">
                <div class="float-left">
                  <div class="pl-3 pt-2 text-muted pb-2">
                    <small>
                      Page {{ list.current_page }} of
                      {{ list.last_page }}
                    </small>
                  </div>
                </div>
              </div>
              <div class="col" v-show="list.last_page > 1">
                <div class="float-right">
                  <div
                    class="dataTables_paginate paging_full_numbers mt-2 px-2"
                    id="DataTables_Table_2_paginate"
                  >
                    <ul class="pagination mb-2">
                      <li class="paginate_button page-item">
                        <a
                          class="page-link"
                          v-on:click.prevent="changePage(list.current_page - 1)"
                        >
                          <i class="fas fa-arrow-left"></i>
                        </a>
                      </li>
                      <li class="paginate_button page-item">
                        <a
                          class="page-link"
                          v-on:click.prevent="changePage(list.current_page + 1)"
                        >
                          <i class="fas fa-arrow-right"></i>
                        </a>
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
</template>
<script type="text/javascript">
import { extend } from "vee-validate";
import { required } from "vee-validate/dist/rules";
import moment from "moment";

extend("required", {
  ...required,
  message: "{_field_} is required",
});

export default {
  computed: {
    yesterday: function() {
      return moment()
        .subtract(1, "days")
        .format("YYYY-MM-DD");
    },
    manager: function() {
      return this.$store.state.user.manager == 1 ? true : false;
    },
    userId: function() {
      return this.$store.state.user.id;
    },
  },
  data: function() {
    return {
      routePrefix: "/api/productivity/tasks",
      users: {},
      staff: 0,
      tasks: {
        completed: {
          current_page: 1,
        },
      },
      completed: false,
      newTask: {
        description: null,
        scheduled_at: null,
        repeat: 0,
        option: {
          schedule: 0,
          staff_assigned: null,
        },
      },
      loaded: true,
    };
  },
  watch: {
    staff: function(val) {
      this.showTasks(1);
    },
  },
  mounted() {
    if (this.$route.query.staff) {
      this.staff = this.$route.query.staff;
    }
    this.showTasks(this.staff);
    this.showStaff();
  },
  filters: {
    timestamp: function(val) {
      return moment(val).format("DD-MM-YYYY");
    },
  },
  methods: {
    showStaff() {
      var route = this.routePrefix + "/staff";
      axios.get(route).then((response) => {
        this.users = response.data;
        if (this.staff == 0) {
          this.staff = this.userId;
        }
      });
    },
    showTasks() {
      this.$router
        .push({
          query: {
            staff: this.staff,
          },
        })
        .catch((err) => {});
      this.loaded = false;
      var route = this.routePrefix + "/" + this.staff;
      axios
        .get(route)
        .then((response) => {
          this.tasks = response.data;
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        })
        .then(() => {
          this.loaded = true;
        });
    },
    filterTasks() {
      this.$router.push({
        query: {
          staff: this.staff,
        },
      });
      this.showTasks(this.staff);
    },
    changePage(current_page) {
      event.preventDefault();
      if (current_page <= this.tasks.completed.last_page && current_page > 0) {
        this.tasks.completed.current_page = current_page;
        this.show(false);
      }
    },
    pastDue(val) {
      if (val !== null) {
        if (moment().isAfter(moment(val))) {
          return (
            '<span class="badge badge-danger"><i class="far fa-calendar-alt mr-1"></i>' +
            moment(val).format("DD-MM-YYYY") +
            "</span>"
          );
        }
        return (
          '<span class="badge badge-light"><i class="far fa-calendar-alt mr-1"></i>' +
          moment(val).format("DD-MM-YYYY") +
          "</span>"
        );
      }
      return val;
    },
    store() {
      axios
        .post(this.routePrefix, {
          description: this.newTask.description,
          scheduled_at: this.newTask.scheduled_at,
          repeat: this.newTask.repeat,
          staff_assigned: this.newTask.staff_assigned,
        })
        .then((response) => {
          this.showTasks();
          this.newTask = {
            description: null,
            scheduled_at: null,
            repeat: 0,
            option: { schedule: 0 },
            staff_assigned: null,
          };
        })
        .catch((error) => {
          this.$root.notification(error.response.data.message, "error");
        })
        .then(() => {
          this.$refs.form.reset();
        });
    },
    update(id, status) {
      status = status == 0 ? 1 : 0;
      axios
        .patch(this.routePrefix + "/" + id, {
          status: status,
        })
        .then((response) => {
          this.showTasks();
        })
        .catch((error) => {
          this.$root.notification(
            "You can only update tasks that are assigned to you",
            "error"
          );
        });
    },
    destroyAlert(id) {
      this.$swal
        .fire({
          title: "Delete Task",
          text:
            "Deleting the task will also delete the repeat tasks, are you sure you want to continue?",
          icon: "danger",
          showCancelButton: true,
          confirmButtonColor: "#e04f1a",
          cancelButtonColor: "#495057",
          confirmButtonText: "Delete",
        })
        .then((result) => {
          if (result.value) {
            this.destroy(id);
          }
        });
    },
    destroy(id) {
      axios
        .delete(this.routePrefix + "/" + id)
        .then((response) => {
          this.showTasks();
        })
        .catch((error) => {
          this.$root.notification(
            "You can only delete tasks that are assigned to you",
            "error"
          );
        });
    },
  },
};
</script>
<style lang="scss" scoped>
@media screen and (max-width: 759px) {
  .block-content {
    transition: opacity 0.25s ease-out;
    width: 100%;
    margin: 0 auto;
    padding: 0px !important;
    overflow-x: visible;
  }
}

.form-control.form-control-alt {
    color: #000;
    border-color: transparent;
    background-color: transparent;
    transition: none;
    font-size: 15px;
    font-weight: 600;
    border-bottom: 1px solid #000;
    border-radius: 0px !important;
}
</style>
