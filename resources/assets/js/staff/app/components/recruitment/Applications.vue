<template>
  <div class="content">
    <div class="row my-3">
      <div class="col-lg-10 col-8 my-auto">
        <h3 class="mb-0">Applications</h3>
      </div>
      <div class="col-lg-1 col-2">
        <button
          class="btn btn-primary float-right"
          v-show="showFilters == false"
          @click="showFilters = true"
        >
          <i class="fa fa-plus"></i> Show
        </button>
        <button
          class="btn btn-danger float-right"
          v-show="showFilters == true"
          @click="showFilters = false"
        >
          <i class="fa fa-minus"></i> Hide
        </button>
      </div>
      <div class="col-lg-1 col-2 my-auto ml-auto">
        <button class="btn btn-dark float-right" @click="create">
          <i class="fas fa-pencil-alt"></i> New
        </button>
      </div>
    </div>
    <div class="row py-2" v-show="showFilters == true">
      <div class="col-12 input-group">
        <div class="input-group-append">
          <span id="basic-addon1" class="input-group-text">
            <i class="fa fa-fw fa-search"></i>
          </span>
        </div>
        <input
          type="text"
          class="form-control"
          v-model="search"
          :placeholder="'Search...'"
        />
      </div>
    </div>
    <div class="row py-2" v-show="showFilters == true">
      <div class="col-md-4 col-12 py-1 my-auto input-group">
        <div class="input-group-append">
          <span class="input-group-text">Status</span>
        </div>
        <select
          class="form-control selectpicker"
          v-model="filter"
          @change="filterApplications(1)"
        >
          <option value selected disabled>Status's</option>
          <option value="all">All</option>
          <option value="Application">Application</option>
          <option value="Screening">Screening</option>
          <option value="Interview">Interview</option>
          <option value="Offered">Offered</option>
          <option value="Onboarding">Onboarding</option>
          <option value="Active">Active</option>
          <option value="Leaver">Leaver</option>
          <option value="Pipeline">Pipeline</option>
          <option value="incomplete">Incomplete</option>
          <option value="contacted">Contacted</option>
          <option value="completed">Completed</option>
          <option value="live">Live</option>
        </select>
      </div>
        <div class="col-md-4 col-12 py-1 my-auto input-group" >
            <div class="input-group-append">
                <span class="input-group-text">Sub Status</span>
            </div>
            <select
                class="form-control selectpicker"
                v-model="statusSub"
                @change="filterApplications(1)"
            >
                <option value selected disabled>Sub Status</option>
                <option value="all">All</option>
                <option
                    class="optionpicker"
                    v-for="data in subStatus"
                    v-bind:key="data.id"
                    :value="data.id"
                >
                    {{ data.sub_status_name }}
                </option>
            </select>
        </div>
      <div class="col-md-4 col-12 py-1 my-auto input-group">
        <div class="input-group-append">
          <span class="input-group-text">Branches</span>
        </div>
        <select
          class="form-control selectpicker"
          v-model="filterBranch"
          @change="filterApplications(1)"
        >
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
      <div class="col-md-4 col-12 py-1 my-auto input-group">
        <div class="input-group-append">
          <span class="input-group-text">Sort</span>
        </div>
        <select
          class="form-control selectpicker py-1"
          v-model="sort"
          @change="filterApplications(datatable.current_page)"
        >
          <option value selected disabled>Sort By</option>
          <option value="newest">Newest</option>
          <option value="oldest">Oldest</option>
        </select>
      </div>
    </div>
    <div class="row" v-show="showFilters == true">
      <div class="col-md-4 col-12 py-1 my-auto input-group">
        <div class="input-group-append">
          <span class="input-group-text">Positions</span>
        </div>
        <select
          class="form-control selectpicker py-1"
          v-model="position"
          @change="filterApplications(1)"
        >
          <option value selected disabled>Posiitons</option>
          <option value="all">All</option>
          <option value="RGN">RGN</option>
          <option value="RMN">RMN</option>
          <option value="Healthcare Assistant">Healthcare Assistant</option>
          <option value="Senior Healthcare Assistant">
            Senior Healthcare Assistant
          </option>
          <option value="Support Worker">Support Worker</option>
        </select>
      </div>
      <div class="col-md-4 col-12 py-1 my-auto input-group">
        <div class="input-group-append">
          <span class="input-group-text">Source</span>
        </div>
        <select
          class="form-control selectpicker"
          v-model="source"
          @change="filterApplications(1)"
        >
          <option v-for="(source, key) in sources" :key="key" :value="source">
            {{ source }}
          </option>
        </select>
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
          <div class="block-content block-content-full tab-content">
            <div class="row">
              <div class="col-12">
                <div class="table-responsive" v-if="loaded">
                  <table
                    class="
                      table
                      table-hover
                      table-vcenter
                      table-bordered
                      table-striped
                      js-appear-enabled
                      animated
                      fadeIn
                    "
                  >
                    <thead class="thead-light" v-if="datatable.data.length">
                      <tr>
                        <th class="d-table-cell d-lg-none">Applicant</th>
                        <th class="d-none d-lg-table-cell">Position</th>
                        <th class="d-none d-lg-table-cell">Applicant</th>
                        <th class="d-none d-lg-table-cell">Interview</th>
                        <th class="d-none d-lg-table-cell">References</th>
                        <th class="d-none d-lg-table-cell">Branch</th>
                        <th class="d-none d-lg-table-cell">Completed</th>
                        <th class="d-none d-lg-table-cell text-center">
                          Status
                        </th>
                          <th class="d-none d-lg-table-cell text-center">
                             Sub Status
                          </th>
                        <th class="d-none d-lg-table-cell"></th>
                      </tr>
                    </thead>
                    <tbody class="bg-white">
                      <tr v-for="(applicant, key) in datatable.data" :key="key">
                        <td class="d-table-cell d-lg-none">
                          <div class="my-2">
                            <h5>
                              {{
                                applicant.first_name + " " + applicant.last_name
                              }}
                            </h5>
                          </div>
                          <div class="my-2">
                            <p>{{ applicant.position }}</p>
                          </div>
                          <div
                            class="my-2"
                            v-if="
                              applicant.declaration == null &&
                              applicant.phoned == 1
                            "
                          >
                            <p class="text-success font-w700">Phoned</p>
                          </div>
                          <div
                            class="my-2 d-none d-lg-table-cell"
                            v-if="applicant.references == 'Received'"
                            :class="{
                              received: applicant.references == 'Received',
                            }"
                          >
                            <p>{{ applicant.references }}</p>
                          </div>
                          <div
                            class="my-2"
                            v-if="applicant.references !== 'Received'"
                          >
                            <p>{{ applicant.references }}</p>
                          </div>
                          <div class="my-2">
                            <p v-if="applicant.branch_id == null">
                              Not Assigned
                            </p>
                            <p v-if="applicant.branch_id == 1">Lancashire</p>
                            <p v-if="applicant.branch_id == 2">Warrington</p>
                            <p v-if="applicant.branch_id == 3">Crewe
                            </p>
                            <p v-if="applicant.branch_id == 4">Liverpool
                            </p>
                              <p v-if="applicant.branch_id == 5">Manchester
                              </p>
                              <p v-if="applicant.branch_id == 6">Leeds
                              </p>
                              <p v-if="applicant.branch_id == 7">Shrewsbury
                              </p>
                              <p v-if="applicant.branch_id == 8">Chester
                              </p>
                              <p v-if="applicant.branch_id == 9">Permanent
                              </p>
                              <p v-if="applicant.branch_id == 10">Complex Care
                              </p>
                              <p v-if="applicant.branch_id == 11">Head Office

                              </p>
                          </div>
                          <div class="my-2">
                            <div
                              v-if="
                                applicant.status == 0 ||
                                (applicant.status == null &&
                                  applicant.declaration != null)
                              "
                            >
                              <button class="btn btn-sty btn-sm">
                                <i class="fas fa-minus mr-1"></i> Pending
                              </button>
                            </div>
                            <div
                              v-if="
                                applicant.status == 1 &&
                                applicant.hired != 1 &&
                                applicant.declaration != null
                              "
                            >
                              <button class="btn btn-success btn-sty btn-sm">
                                <i class="fas fa-check mr-1"></i> Accepted
                              </button>
                            </div>
                            <div
                              v-if="
                                applicant.status == 2 &&
                                applicant.hired != 1 &&
                                applicant.declaration != null
                              "
                            >
                              <button class="btn btn-danger btn-sty btn-sm">
                                <i class="fas fa-times mr-1"></i> Rejected
                              </button>
                            </div>
                            <div
                              v-if="
                                applicant.status == 3 &&
                                applicant.hired != 1 &&
                                applicant.declaration != null
                              "
                            >
                              <button class="btn btn-primary btn-sty btn-sm">
                                <i class="fas fa-minus mr-1"></i> Inexperienced
                              </button>
                            </div>
                            <div
                              v-if="
                                applicant.status == 4 &&
                                applicant.hired != 1 &&
                                applicant.declaration != null
                              "
                            >
                              <button class="btn btn-secondary btn-sty btn-sm">
                                <i class="fas fa-times mr-1"></i> Not Yet
                              </button>
                            </div>
                            <div
                              v-if="
                                applicant.status == 5 &&
                                applicant.hired != 1 &&
                                applicant.declaration != null
                              "
                            >
                              <button class="btn btn-info btn-sty btn-sm">
                                <i class="fas fa-archive mr-1"></i> Archived
                              </button>
                            </div>
                            <div
                              v-if="
                                applicant.hired == 1 &&
                                applicant.declaration != null
                              "
                            >
                              <button class="btn btn-success btn-sty btn-sm">
                                <i class="fas fa-check-double mr-1"></i>
                                <b>Live</b>
                              </button>
                            </div>
                            <div
                              v-if="
                                applicant.declaration == null &&
                                applicant.contacted == 0
                              "
                            >
                              <div v-if="applicant.experience == 0">
                                <button class="btn btn-dark btn-sty btn-sm">
                                  <i class="fas fa-exclamation mr-1"></i>
                                  <b>Incomplete</b>
                                </button>
                              </div>
                              <div v-else>
                                <button class="btn btn-success btn-sty btn-sm">
                                  <i class="fas fa-exclamation mr-1"></i>
                                  <b>Incomplete</b>
                                </button>
                              </div>
                            </div>
                            <div
                              v-if="
                                applicant.declaration == null &&
                                applicant.contacted == 1
                              "
                            >
                              <button class="btn btn-dark btn-sty btn-sm">
                                <i class="fas fa-paper-plane mr-1"></i>
                                <b>Contacted</b>
                              </button>
                            </div>
                          </div>
                          <div class="my-2">
                            <div class="btn-group">
                              <router-link
                                class="btn btn-outline-secondary btn-sm"
                                :to="
                                  '/recruitment/applications/' + applicant.id
                                "
                              >
                                <i class="fa fa-folder-open"></i> View
                              </router-link>
                            </div>
                          </div>
                        </td>
                        <td class="d-none d-lg-table-cell">
                          {{ applicant.position }}
                        </td>
                        <td class="d-none d-lg-table-cell">
                          {{ applicant.first_name + " " + applicant.last_name }}
                        </td>
                        <td
                          class="d-none d-lg-table-cell"
                          v-if="
                            applicant.declaration == null &&
                            applicant.phoned == 1
                          "
                        >
                          <div class="text-success font-w700">Phoned</div>
                        </td>
                        <td
                          class="d-none d-lg-table-cell"
                          v-else
                          :class="{
                            not_contacted:
                              applicant.interview_id == 'Not Contacted',
                            contacted: applicant.interview_id == 'Contacted',
                            planned: applicant.interview_id == 'Planned',
                            completed: applicant.interview_id == 'Completed',
                            successful: applicant.interview_id == 'Successful',
                            no_show: applicant.interview_id == 'No Show',
                            rejected: applicant.interview_id == 'Unsuccessful',
                          }"
                        >
                          {{ applicant.interview_id }}
                        </td>
                        <td
                          class="d-none d-lg-table-cell"
                          v-if="applicant.references == 'Received'"
                          :class="{
                            received: applicant.references == 'Received',
                          }"
                        >
                          {{ applicant.references }}
                        </td>
                        <td
                          class="d-none d-lg-table-cell"
                          v-if="applicant.references !== 'Received'"
                        >
                          {{ applicant.references }}
                        </td>
                        <td class="d-none d-lg-table-cell">
                          <div v-if="applicant.branch_id == null">
                            Not Assigned
                          </div>
                          <div v-if="applicant.branch_id == 1">Lancashire
                          </div>
                          <div v-if="applicant.branch_id == 2">Warrington
                          </div>
                          <div v-if="applicant.branch_id == 3">Crewe
                          </div>
                          <div v-if="applicant.branch_id == 4">Liverpool
                            </div>
                            <div v-if="applicant.branch_id == 5">Manchester
                            </div>
                            <div v-if="applicant.branch_id == 6">Leeds
                            </div>
                            <div v-if="applicant.branch_id == 7">Shrewsbury
                            </div>
                            <div v-if="applicant.branch_id == 8">Chester
                            </div>
                            <div v-if="applicant.branch_id == 9">Permanent
                            </div>
                            <div v-if="applicant.branch_id == 10">Complex Care
                            </div>
                            <div v-if="applicant.branch_id == 11">Head Office
                            </div>
                        </td>
                        <td class="d-none d-lg-table-cell">
                          {{ applicant.completed_at }}
                        </td>
                        <td class="d-none d-lg-table-cell text-center">
                          <div
                            v-if="
                              applicant.status == 0 ||
                              (applicant.status == null &&
                                applicant.declaration != null)
                            "
                          >
                            <button class="btn btn-primary btn-sty btn-sm">
                              <i class="fas fa-minus mr-1"></i> Application


                            </button>
                          </div>
                          <div
                            v-if="
                              applicant.status == 1 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                          >
                            <button class="btn btn-primary btn-sty btn-sm">
                              <i class="fas fa-check mr-1"></i> Screening

                            </button>
                          </div>
                          <div
                            v-if="
                              applicant.status == 2 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                          >
                            <button class="btn btn-primary btn-sty btn-sm">
                              <i class="fas fa-minus mr-1"></i> Interview


                            </button>
                          </div>
                          <div
                            v-if="
                              applicant.status == 3 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                          >
                            <button class="btn btn-primary btn-sty btn-sm">
                              <i class="fas fa-minus mr-1"></i> Offered


                            </button>
                          </div>
                          <div
                            v-if="
                              applicant.status == 4 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                          >
                            <button class="btn btn-secondary btn-sty btn-sm">
                              <i class="fas fa-check mr-1"></i> Onboarding


                            </button>
                          </div>
                          <div
                            v-if="
                              applicant.status == 5 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                          >
                            <button class="btn btn-info btn-sty btn-sm">
                              <i class="fas fa-archive mr-1"></i> Active

                            </button>
                          </div>
                          <div
                            v-if="
                              applicant.status == 6 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                          >
                            <button class="btn btn-danger btn-sty btn-sm">
                              <i class="fas fa-times mr-1"></i> Leaver


                            </button>
                          </div>
                            <div
                                v-if="
                              applicant.status == 7 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                            >
                                <button class="btn btn-danger btn-sty btn-sm">
                                    <i class="fas fa-blind mr-1"></i> Pipeline



                                </button>
                            </div>
                          <div
                            v-if="
                              applicant.hired == 1 &&
                              applicant.declaration != null
                            "
                          >
                            <button class="btn btn-success btn-sty btn-sm">
                              <i class="fas fa-check-double mr-1"></i>
                              <b>Live</b>
                            </button>
                          </div>
                          <div
                            v-if="
                              applicant.declaration == null &&
                              applicant.contacted == 0
                            "
                          >
                            <div v-if="applicant.experience == 0">
                              <button class="btn btn-dark btn-sty btn-sm">
                                <i class="fas fa-exclamation mr-1"></i>
                                <b>Incomplete</b>
                              </button>
                            </div>
                            <div v-else>
                              <button class="btn btn-success btn-sty btn-sm">
                                <i class="fas fa-exclamation mr-1"></i>
                                <b>Incomplete</b>
                              </button>
                            </div>
                          </div>
                          <div
                            v-if="
                              applicant.declaration == null &&
                              applicant.contacted == 1
                            "
                          >
                            <button class="btn btn-dark btn-sty btn-sm">
                              <i class="fas fa-paper-plane mr-1"></i>
                              <b>Contacted</b>
                            </button>
                          </div>
                        </td>
                          <td class="d-none d-lg-table-cell text-center">
                              <div
                                  v-if="
                              applicant.sub_status == 1 ||
                              (applicant.status == null &&
                                applicant.declaration != null)
                            "
                              >
                                  <button class="btn btn-sty btn-sm">
                                      <i class="fas fa-minus mr-1"></i> New


                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 10 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-warning btn-sty btn-sm">
                                      <i class="fas fa-minus mr-1"></i> Awaiting contact

                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 11 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-success btn-sty btn-sm">
                                      <i class="fas fa-check mr-1"></i> Reviewing

                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 12 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-times mr-1"></i> Rejected - not suitable


                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 13 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-primary btn-sty btn-sm">
                                      <i class="fas fa-minus mr-1"></i> Rejected - Inexperienced


                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 14 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-secondary btn-sty btn-sm">
                                      <i class="fas fa-times mr-1"></i> Rejected - no contact


                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 15 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-info btn-sty btn-sm">
                                      <i class="fas fa-archive mr-1"></i> Rejected - role no longer available

                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 16 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Withdrawn  - package or benefits


                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 17 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Withdrawn - role



                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 18 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-info btn-sty btn-sm">
                                      <i class="fas fa-check mr-1"></i> Awaiting screening
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 19 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-warning btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Longlisted
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 20 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-success btn-sty btn-sm">
                                      <i class="fas fa-check mr-1"></i> Shortlisted
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 21 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-warning btn-sty btn-sm">
                                      <i class="fas fa-minus mr-1"></i> Awaiting feedback from manager
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 22 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Rejected - not suitable

                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 24 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Rejected - Inexperienced
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 25 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Rejected - no contact

                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 26 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Rejected - role no longer available
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 27 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Withdrawn  - package or benefits
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 28 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Withdrawn - role
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 29 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-warning btn-sty btn-sm">
                                      <i class="fas fa-minus mr-1"></i> Awaiting schedule
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 30 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-success btn-sty btn-sm">
                                      <i class="fas fa-check mr-1"></i> Scheduled
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 31 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-warning btn-sty btn-sm">
                                      <i class="fas fa-minus mr-1"></i> Awaiting feedback from manager
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 32 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Rejected - not suitable

                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 33 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Rejected - Inexperienced

                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 34 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Rejected - no contact

                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 35 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Rejected - role no longer available

                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 36 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Withdrawn  - package or benefits
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 37 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Withdrawn - no reason provided
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 38 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-info btn-sty btn-sm">
                                      <i class="fas fa fa-blind mr-1"></i> Made
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 39 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-success btn-sty btn-sm">
                                      <i class="fas fa-check mr-1"></i> Accepted
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 40 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Withdrawn - another offer
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 41 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Withdrawn - compensation and benefits
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 42 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Rejected - role no longer available
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 43 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-info btn-sty btn-sm">
                                      <i class="fas fa-minus mr-1"></i> Vetting

                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 44 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-info btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Training booked
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 45 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-success btn-sty btn-sm">
                                      <i class="fas fa-check mr-1"></i> Training complete
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 46 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-info btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Induction booked
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 47 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-success btn-sty btn-sm">
                                      <i class="fas fa-check mr-1"></i> Induction complete
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 48 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Rejected - compliance
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 49 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Rejected - no contact
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 50 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Rejected - role no longer availabe
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 51 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Withdrawn  - package or benefits
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 52 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Withdrawn - no reason provided
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 53 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-info btn-sty btn-sm">
                                      <i class="fas fa-minus mr-1"></i> Awaiting shifts
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 54 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-success btn-sty btn-sm">
                                      <i class="fas fa-check mr-1"></i> Active worker
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 55 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Not working
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 56 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Leaving
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 57 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-success btn-sty btn-sm">
                                      <i class="fas fa-check mr-1"></i> Rehire
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 58 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-danger btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Do not hire
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.sub_status == 59 &&
                              applicant.hired != 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-info btn-sty btn-sm">
                                      <i class="fas fa-blind mr-1"></i> Nurture
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.hired == 1 &&
                              applicant.declaration != null
                            "
                              >
                                  <button class="btn btn-success btn-sty btn-sm">
                                      <i class="fas fa-check-double mr-1"></i>
                                      <b>Live</b>
                                  </button>
                              </div>
                              <div
                                  v-if="
                              applicant.declaration == null &&
                              applicant.contacted == 0
                            "
                              >
                                  <div v-if="applicant.experience == 0">
                                      <button class="btn btn-dark btn-sty btn-sm">
                                          <i class="fas fa-exclamation mr-1"></i>
                                          <b>Incomplete</b>
                                      </button>
                                  </div>
                                  <div v-else>
                                      <button class="btn btn-success btn-sty btn-sm">
                                          <i class="fas fa-exclamation mr-1"></i>
                                          <b>Incomplete</b>
                                      </button>
                                  </div>
                              </div>
                              <div
                                  v-if="
                              applicant.declaration == null &&
                              applicant.contacted == 1
                            "
                              >
                                  <button class="btn btn-dark btn-sty btn-sm">
                                      <i class="fas fa-paper-plane mr-1"></i>
                                      <b>Contacted</b>
                                  </button>
                              </div>
                          </td>
                        <td class="d-none d-lg-table-cell text-center btn-td">
                          <div class="btn-group">
                            <router-link
                              class="btn btn-outline-secondary btn-sm"
                              :to="'/recruitment/applications/' + applicant.id"
                            >
                              <i class="fa fa-folder-open"></i> View
                            </router-link>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div>
                  <loading />
                </div>
              </div>
            </div>
          </div>
          <div
            class="
              block-content block-content-full block-content-sm
              bg-body-light
            "
          >
            <div>
              <pagination />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script type="text/javascript">
import Pagination from "../layout/tables/Pagination.vue";
import Loading from "../layout/tables/Loading.vue";

export default {
  computed: {
    production: function () {
      return window.location.href.includes("cavalrycare.co.uk") ? true : false;
    },
    userBranch: function () {
      return this.$store.state.user.branch_id;
    },
  },
  data: function () {
    return {
      routePrefix: "/api/recruitment/applications/",
      statusSub:"all",
      search: "",
      filter: "all",
      filterBranch: "all",
      position: "all",
      sort: "newest",
      source: "All",

      datatable: {
        data: {},
        current_page: 1,
        per_page: 15,
        last_page: 0,
        total: 1,
      },
      sources: [
        "All",
        "Indeed",
        "Facebook",
        "LinkedIn",
        "Website",
        "Google",
        "Word of mouth",
        "Other",
      ],
      branches: {},
        subStatus:{},
      loaded: false,
      newApplicant: {},
      newAplication: false,
    //  disabled: false,
      showFilters: false,
    };
  },
  components: {
    Pagination,
    Loading,
  },
  watch: {

    filter: function (val) {
        axios.get("/api/recruitment/applications/sub_status_alph/" + this.filter ).then((response)=>{
            this.subStatus = response.data;
        })
      this.index(1);
    },
    search: function (val) {
      var search_check = this.search;
      setTimeout(() => {
        if (search_check == this.search) {
          this.index(1);
        }
      }, 500);
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
      if (this.$route.query.statusSub) {
          this.statusSub = this.$route.query.statusSub;
      }
    if (this.$route.query.filterBranch) {
      this.filterBranch = this.$route.query.filterBranch;
    }
    if (this.$route.query.position) {
      this.position = this.$route.query.position;
    }
    if (this.$route.query.sort) {
      this.sort = this.$route.query.sort;
    }
    if (this.$route.query.source) {
      this.source = this.$route.query.source;
    }
    this.index(this.datatable.current_page);
    this.getBranches();
  },

  methods: {
    index(page) {
      var route = this.routePrefix + "?";
      route += "page=" + page;
      if (this.search.length > 0) {
        route += "&search=" + this.search;
      }
      if (this.filter.length > 0) {
        route += "&filter=" + this.filter;
      }
        if (this.statusSub.length > 0) {
            route += "&statusSub=" + this.statusSub;
        }
      if (this.filterBranch) {
        route += "&filterBranch=" + this.filterBranch;
      }
      if (this.position) {
        route += "&position=" + this.position;
      }
      if (this.sort.length > 0) {
        route += "&sort=" + this.sort;
      }
      if (this.position) {
        route += "&source=" + this.source;
      }
      this.loaded = false;
      this.$router
        .push({
          query: {
            page: page,
            search: this.search,
            filter: this.filter,
            statusSub: this.statusSub,
            filterBranch: this.filterBranch,
            position: this.position,
            sort: this.sort,
            source: this.source,
          },
        })
        .catch((err) => {});
      axios
        .get(route)
        .then((response) => {
          this.datatable = response.data;
          // if (this.filterBranch == null) {
          //   this.filterBranch = this.userBranch;
          // }
        })
        .then(() => {
          this.loaded = true;
        });
    },
    filterApplications(page) {
      this.$router
        .push({
          query: {
            filter: this.filter,
            statusSub: this.statusSub,
            filterBranch: this.filterBranch,
            positon: this.position,
            source: this.source,
            page: page,
          },
        })
        .catch(() => {});
      this.index(
        page,
        this.filter,
        this.statusSub,
        this.filterBranch,
        this.position,
        this.sort,
        this.source
      );
    },
    changePage(current_page) {
      if (current_page <= this.datatable.last_page && current_page > 0) {
        this.datatable.current_page = current_page;
        this.index(current_page);
      }
    },
    create() {
      axios
        .post(this.routePrefix + "create")
        .then((response) => {
          this.$router.push("/recruitment/applications/" + response.data.id);
        })
        .catch((error) => {
          this.message = "Oops, an error occurred!";
        });
    },
    getBranches() {
      axios.get("/api/management/staff/branches/").then((response) => {
        this.branches = response.data;
        console.log(this.branches);
      });
    },
  },
};
</script>
<style lang="scss">
.not_contacted {
  color: #e04f1a;
  font-weight: 700;
}

.contacted {
  color: #e1b65a;
  font-weight: 700;
}

.planned {
  color: #3c90df;
  font-weight: 700;
}

.completed {
  color: #82b54b;
  font-weight: 700;
}

.successful {
  color: #82b54b;
  font-weight: 700;
}

.rejected {
  color: #e04f1a;
  font-weight: 700;
}

.no_show {
  color: #e04f1a;
  font-weight: 700;
}

.received {
  color: #82b54b;
  font-weight: 700;
}
.btn {
  transition: none;
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
