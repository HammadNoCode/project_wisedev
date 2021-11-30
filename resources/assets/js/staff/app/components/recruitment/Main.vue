<template>
  <div class="content">
    <div class="row mb-3">
      <div class="col-xs-12 col-sm-6 col-md my-1">
        <h2 class="h3 font-w500 mt-2 mb-0">
          <span
            >{{ applicant.first_name | capitalize }}
            {{ applicant.last_name | capitalize }}</span
          >
          <span class="text-muted">- {{ applicant.position }}</span>
        </h2>
      </div>
    </div>
    <div class="row my-4 d-none d-md-block">
      <div class="col-12">
        <div role="group" aria-label="1" class="btn-group btn-block">
          <button
            :class="{ active: tab == 'applicant' }"
            @click="tab = 'applicant'"
            class="btn btn-light"
          >
            <i class="far fa-file-alt pr-2"></i>Application
          </button>
          <button
            :class="{ active: tab == 'interviews' }"
            @click="tab = 'interviews'"
            class="btn btn-light"
          >
            <i class="fas fa-user-clock pr-2"></i>Interview
          </button>
            <button
                :class="{ active: tab == 'Communication' }"
                @click="tab = 'Communication'"
                class="btn btn-light"
            >
                <i class="fas fa-comments pr-2"></i>Communication
            </button>
          <button
            :class="{ active: tab == 'references' }"
            @click="tab = 'references'"
            class="btn btn-light"
          >
            <i class="fas fa-user-friends pr-2"></i>References
          </button>
          <button
            :class="{ active: tab == 'compliance' }"
            @click="tab = 'compliance'"
            class="btn btn-light"
          >
            <i class="fas fa-check-square pr-2"></i>Compliance
          </button>
          <button
            :class="{ active: tab == 'logs' }"
            @click="tab = 'logs'"
            class="btn btn-light"
          >
            <i class="fas fa-list pr-2"></i>Logs
          </button>

          <b-dropdown
            id="action"
            variant="primary"
            text="Status"
            style="outline: none"
          >
          <!--  <b-dropdown-item>
              <button
                type="button"
                class="btn btn-success btn-sm mt-1"
                data-original-title="View"
                v-on:click="updateStatus(applicant.id, { status: '0' })"
                :disabled="edit"
              >
                <i class="mr-1 fa fa-check"></i> Application
              </button>
            </b-dropdown-item> -->
              <b-dropdown id="dropdown-2" text="Application" variant="primary" class="m-md-3" >
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-sty btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '0' , sub_status:'1' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-minus mr-1"></i> New
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-warning btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '0' , sub_status:'10' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-minus mr-1"></i> Awaiting contact
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-success btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '0' , sub_status:'11' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-check mr-1"></i> Reviewing
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-danger btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '0' , sub_status:'12' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-times mr-1"></i> Rejected - not suitable
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-danger btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '0' , sub_status:'13' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-times mr-1"></i> Rejected - Inexperienced
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-danger btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '0' , sub_status:'14' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-times mr-1"></i> Rejected - no contact
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-danger btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '0' , sub_status:'15'})"
                      :disabled="edit">
                      <i class="mr-1 fa fa-times mr-1"></i> Rejected - role no longer available
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-danger btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '0' , sub_status:'16' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-times mr-1"></i> Withdrawn  - package or benefits
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-danger btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '0' , sub_status:'17' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-times mr-1"></i> Withdrawn - role
                  </button>
                  </b-dropdown-item>
              </b-dropdown>
       <!--     <b-dropdown-item>
              <button
                type="button"
                class="btn btn-danger btn-sm mt-1"
                data-original-title="View"
                v-on:click="updateStatus(applicant.id, { status: '1' })"
                :disabled="edit"
              >
                <i class="mr-1 fa fa-times mr-1"></i> Screening
              </button>
            </b-dropdown-item> -->
              <b-dropdown id="dropdown-2" text="Screening" variant="primary" class="m-md-3" >
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-info btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '1', sub_status:'18' })"
                      :disabled="edit">
                      <i class="fas fa-check mr-1"></i> Awaiting screening
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-warning btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '1', sub_status:'19' })"
                      :disabled="edit">
                      <i class="fas fa-blind mr-1"></i> Longlisted
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-success btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '1', sub_status:'20' })"
                      :disabled="edit">
                      <i class="fas fa-check mr-1"></i> Shortlisted
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-warning btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '1', sub_status:'21' })"
                      :disabled="edit">
                      <i class="mr-1 fas fa-minus mr-1"></i> Awaiting feedback from manager
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-danger btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '1', sub_status:'22' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-times mr-1"></i> Rejected - not suitable
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-danger btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '1', sub_status:'24' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-times mr-1"></i> Rejected - Inexperienced
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-danger btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '1', sub_status:'25' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-times mr-1"></i> Rejected - no contact
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-danger btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '1', sub_status:'26' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-times mr-1"></i> Rejected - role no longer available
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-danger btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '1', sub_status:'27' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-times mr-1"></i> Withdrawn  - package or benefits
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-danger btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '1', sub_status:'28' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-times mr-1"></i> Withdrawn - role
                  </button>
                  </b-dropdown-item>
              </b-dropdown>
          <!--  <b-dropdown-item>
              <button
                type="button"
                class="btn btn-danger btn-sm mt-1"
                data-original-title="View"
                v-on:click="updateStatus(applicant.id, { status: '2' })"
                :disabled="edit">
                <i class="mr-1 fa fa-times mr-1"></i> Interview
              </button>
            </b-dropdown-item> -->
              <b-dropdown id="dropdown-2" text="Interview" variant="primary" class="m-md-3" >
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-warning btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '2', sub_status:'29' })"
                      :disabled="edit">
                      <i class="mr-1 fas fa-minus mr-1"></i> Awaiting schedule
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-success btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '2', sub_status:'30' })"
                      :disabled="edit">
                      <i class="mr-1 fas fa-check mr-1"></i> Scheduled
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-warning btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '2', sub_status:'31' })"
                      :disabled="edit">
                      <i class="mr-1 fas fa-minus mr-1"></i> Awaiting feedback
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-danger btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '2', sub_status:'32' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-times mr-1"></i> Rejected - not suitable
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-danger btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '2', sub_status:'33' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-times mr-1"></i> Rejected - Inexperienced
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-danger btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '2', sub_status:'34' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-times mr-1"></i> Rejected - no contact
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-danger btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '2', sub_status:'35' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-times mr-1"></i> Rejected - role no longer available
                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-danger btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '2', sub_status:'36' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-times mr-1"></i> Withdrawn  - package or benefits

                  </button>
                  </b-dropdown-item>
                  <b-dropdown-item><button
                      type="button"
                      class="btn btn-danger btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '2', sub_status:'37' })"
                      :disabled="edit">
                      <i class="mr-1 fa fa-times mr-1"></i> Withdrawn - no reason provided
                  </button>
                  </b-dropdown-item>
              </b-dropdown>
              <!--    <b-dropdown-item>
                    <button
                      type="button"
                      class="btn btn-primary btn-sm mt-1"
                      data-original-title="View"
                      v-on:click="updateStatus(applicant.id, { status: '3' })"
                      :disabled="edit"
                    >
                      <i class="mr-1 fa fa-minus mr-1"></i> Offered

                    </button>
                  </b-dropdown-item> -->
                    <b-dropdown id="dropdown-2" text="Offered" variant="success" class="m-md-3" >
                        <b-dropdown-item><button
                            type="button"
                            class="btn btn-info btn-sm mt-1"
                            data-original-title="View"
                            v-on:click="updateStatus(applicant.id, { status: '3', sub_status:'38' })"
                            :disabled="edit">
                            <i class="mr-1 fa fa-blind mr-1"></i> Made
                        </button>
                        </b-dropdown-item>
                        <b-dropdown-item><button
                            type="button"
                            class="btn btn-success btn-sm mt-1"
                            data-original-title="View"
                            v-on:click="updateStatus(applicant.id, { status: '3', sub_status:'39' })"
                            :disabled="edit">
                            <i class="mr-1 fas fa-check mr-1"></i> Accepted
                        </button>
                        </b-dropdown-item>
                        <b-dropdown-item><button
                            type="button"
                            class="btn btn-danger btn-sm mt-1"
                            data-original-title="View"
                            v-on:click="updateStatus(applicant.id, { status: '2', sub_status:'40' })"
                            :disabled="edit">
                            <i class="mr-1 fa fa-times mr-1"></i> Withdrawn - another offer
                        </button>
                        </b-dropdown-item>
                        <b-dropdown-item><button
                            type="button"
                            class="btn btn-danger btn-sm mt-1"
                            data-original-title="View"
                            v-on:click="updateStatus(applicant.id, { status: '3', sub_status:'41' })"
                            :disabled="edit">
                            <i class="mr-1 fa fa-times mr-1"></i> Withdrawn - compensation and benefits
                        </button>
                        </b-dropdown-item>
                        <b-dropdown-item><button
                            type="button"
                            class="btn btn-danger btn-sm mt-1"
                            data-original-title="View"
                            v-on:click="updateStatus(applicant.id, { status: '3', sub_status:'42' })"
                            :disabled="edit">
                            <i class="mr-1 fa fa-times mr-1"></i> Rejected - role no longer available
                        </button>
                        </b-dropdown-item>
                    </b-dropdown>
              <!--  <b-dropdown-item>
                  <button
                    type="button"
                    class="btn btn-secondary btn-sm mt-1"
                    data-original-title="View"
                    v-on:click="updateStatus(applicant.id, { status: '4' })"
                    :disabled="edit"
                  >
                    <i class="mr-1 fa fa-times mr-1"></i> Onboarding

                  </button>
                </b-dropdown-item> -->
                  <b-dropdown id="dropdown-2" text="Onboarding" variant="secondary" class="m-md-3" >
                      <b-dropdown-item><button
                          type="button"
                          class="btn btn-info btn-sm mt-1"
                          data-original-title="View"
                          v-on:click="updateStatus(applicant.id, { status: '4' , sub_status:'43' })"
                          :disabled="edit">
                          <i class="mr-1 fa fa-minus mr-1"></i> Vetting
                      </button>
                      </b-dropdown-item>
                      <b-dropdown-item><button
                          type="button"
                          class="btn btn-info btn-sm mt-1"
                          data-original-title="View"
                          v-on:click="updateStatus(applicant.id, { status: '4', sub_status:'44' })"
                          :disabled="edit">
                          <i class="mr-1 fa fa-blind mr-1"></i> Training booked
                      </button>
                      </b-dropdown-item>
                      <b-dropdown-item><button
                          type="button"
                          class="btn btn-success btn-sm mt-1"
                          data-original-title="View"
                          v-on:click="updateStatus(applicant.id, { status: '4', sub_status:'45' })"
                          :disabled="edit">
                          <i class="mr-1 fa fa-check mr-1"></i> Training complete
                      </button>
                      </b-dropdown-item>
                      <b-dropdown-item><button
                          type="button"
                          class="btn btn-info btn-sm mt-1"
                          data-original-title="View"
                          v-on:click="updateStatus(applicant.id, { status: '4', sub_status:'46' })"
                          :disabled="edit">
                          <i class="mr-1 fa fa-times mr-1"></i> Induction booked
                      </button>
                      </b-dropdown-item>
                      <b-dropdown-item><button
                          type="button"
                          class="btn btn-success btn-sm mt-1"
                          data-original-title="View"
                          v-on:click="updateStatus(applicant.id, { status: '4', sub_status:'47' })"
                          :disabled="edit">
                          <i class="mr-1 fa fa-check mr-1"></i> Induction complete
                      </button>
                      </b-dropdown-item>
                      <b-dropdown-item><button
                          type="button"
                          class="btn btn-danger btn-sm mt-1"
                          data-original-title="View"
                          v-on:click="updateStatus(applicant.id, { status: '4', sub_status:'48' })"
                          :disabled="edit">
                          <i class="mr-1 fa fa-times mr-1"></i> Rejected - compliance
                      </button>
                      </b-dropdown-item>
                      <b-dropdown-item><button
                          type="button"
                          class="btn btn-danger btn-sm mt-1"
                          data-original-title="View"
                          v-on:click="updateStatus(applicant.id, { status: '4', sub_status:'49' })"
                          :disabled="edit">
                          <i class="mr-1 fa fa-times mr-1"></i> Rejected - no contact
                      </button>
                      </b-dropdown-item>
                      <b-dropdown-item><button
                          type="button"
                          class="btn btn-danger btn-sm mt-1"
                          data-original-title="View"
                          v-on:click="updateStatus(applicant.id, { status: '4', sub_status:'50' })"
                          :disabled="edit">
                          <i class="mr-1 fa fa-times mr-1"></i> Rejected - role no longer available
                      </button>
                      </b-dropdown-item>
                      <b-dropdown-item><button
                          type="button"
                          class="btn btn-danger btn-sm mt-1"
                          data-original-title="View"
                          v-on:click="updateStatus(applicant.id, { status: '4', sub_status:'51' })"
                          :disabled="edit">
                          <i class="mr-1 fa fa-times mr-1"></i> Withdrawn  - package or benefits
                      </button>
                      </b-dropdown-item>
                      <b-dropdown-item><button
                          type="button"
                          class="btn btn-danger btn-sm mt-1"
                          data-original-title="View"
                          v-on:click="updateStatus(applicant.id, { status: '4', sub_status:'52' })"
                          :disabled="edit">
                          <i class="mr-1 fa fa-times mr-1"></i> Withdrawn - no reason provided
                      </button>
                      </b-dropdown-item>
                  </b-dropdown>
              <!--     <b-dropdown-item>
                     <button
                       type="button"
                       class="btn btn-info btn-sm mt-1"
                       data-original-title="View"
                       v-on:click="updateStatus(applicant.id, { status: '5' })"
                       :disabled="edit"
                     >
                       <i class="mr-1 fas fa-archive"></i> Active
                     </button>
                   </b-dropdown-item> -->
                     <b-dropdown id="dropdown-2" text="Active" variant="info" class="m-md-3" >
                         <b-dropdown-item><button
                             type="button"
                             class="btn btn-info btn-sm mt-1"
                             data-original-title="View"
                             v-on:click="updateStatus(applicant.id, { status: '5', sub_status:'53' })"
                             :disabled="edit">
                             <i class="mr-1 fa fa-minus mr-1"></i> Awaiting shifts
                         </button>
                         </b-dropdown-item>
                         <b-dropdown-item><button
                             type="button"
                             class="btn btn-success btn-sm mt-1"
                             data-original-title="View"
                             v-on:click="updateStatus(applicant.id, { status: '5', sub_status:'54' })"
                             :disabled="edit">
                             <i class="mr-1 fa fa-check mr-1"></i> Active worker
                         </button>
                         </b-dropdown-item>
                         <b-dropdown-item><button
                             type="button"
                             class="btn btn-danger btn-sm mt-1"
                             data-original-title="View"
                             v-on:click="updateStatus(applicant.id, { status: '5', sub_status:'55' })"
                             :disabled="edit">
                             <i class="mr-1 fa fa-times mr-1"></i> Not working
                         </button>
                         </b-dropdown-item>
                         <b-dropdown-item><button
                             type="button"
                             class="btn btn-danger btn-sm mt-1"
                             data-original-title="View"
                             v-on:click="updateStatus(applicant.id, { status: '5', sub_status:'56' })"
                             :disabled="edit">
                             <i class="mr-1 fa fa-times mr-1"></i> Leaving
                         </button>
                         </b-dropdown-item>
                     </b-dropdown>
              <!--    <b-dropdown-item>
                      <button
                          type="button"
                          class="btn btn-info btn-sm mt-1"
                          data-original-title="View"
                          v-on:click="updateStatus(applicant.id, { status: '6' })"
                          :disabled="edit"
                      >
                          <i class="mr-1 fas fa-archive"></i> Leaver

                      </button>
                  </b-dropdown-item> -->
                  <b-dropdown id="dropdown-2" text="Leaver" variant="danger" class="m-md-3" >
                      <b-dropdown-item><button
                          type="button"
                          class="btn btn-success btn-sm mt-1"
                          data-original-title="View"
                          v-on:click="updateStatus(applicant.id, { status: '6', sub_status:'57' })"
                          :disabled="edit">
                          <i class="mr-1 fa fa-check mr-1"></i> Rehire

                      </button>
                      </b-dropdown-item>
                      <b-dropdown-item><button
                          type="button"
                          class="btn btn-danger btn-sm mt-1"
                          data-original-title="View"
                          v-on:click="updateStatus(applicant.id, { status: '6', sub_status:'58' })"
                          :disabled="edit">
                          <i class="mr-1 fa fa-times mr-1"></i> Do not rehire
                      </button>
                      </b-dropdown-item>
                  </b-dropdown>
              <!--   <b-dropdown-item>
                     <button
                         type="button"
                         class="btn btn-info btn-sm mt-1"
                         data-original-title="View"
                         v-on:click="updateStatus(applicant.id, { status: '7' })"
                         :disabled="edit"
                     >
                         <i class="mr-1 fas fa-archive"></i> Pipeline


                     </button>
                 </b-dropdown-item> -->
                 <b-dropdown id="dropdown-2" text="Pipeline" variant="info" class="m-md-3" >
                     <b-dropdown-item><button
                         type="button"
                         class="btn btn-info btn-sm mt-1"
                         data-original-title="View"
                         v-on:click="updateStatus(applicant.id, { status: '7', sub_status:'59' })"
                         :disabled="edit">
                         <i class="mr-1 fa fa-blind mr-1"></i> Nurture
                     </button>
                     </b-dropdown-item>
                 </b-dropdown>
               <b-dropdown-divider></b-dropdown-divider>
               <b-dropdown-item>
                 <button
                   type="button"
                   class="btn btn-danger btn-sm mt-1"
                   data-original-title="View"
                   v-on:click="destroyAlert(applicant.id)"
                   :disabled="edit"
                 >
                   <i class="mr-1 fa fa-trash"></i> Delete
                 </button>
               </b-dropdown-item>
               <b-dropdown-divider></b-dropdown-divider>
               <b-dropdown-item v-if="applicant.status == 3">
                 <button
                   type="button"
                   class="btn btn-success btn-sm mt-1"
                   data-original-title="View"
                   v-on:click="updateStatus(applicant.id, { hire: '1' })"
                   :disabled="edit"
                 >
                   <i class="mr-1 fas fa-check-double"></i>
                   <b>LIVE</b>
                 </button>
               </b-dropdown-item>
             </b-dropdown>
           </div>
         </div>
       </div>
       <div class="d-block d-md-none">
         <div class="row my-2">
           <div class="col-12 py-1">
             <div role="group" aria-label="1" class="btn-group btn-block">
               <button
                 :class="{ active: tab == 'applicant' }"
                 @click="tab = 'applicant'"
                 class="btn btn-light"
               >
                 <i class="far fa-file-alt pr-2"></i>Application
               </button>
               <button
                 :class="{ active: tab == 'interviews' }"
                 @click="tab = 'interviews'"
                 class="btn btn-light"
               >
                 <i class="fas fa-user-clock pr-2"></i>Interview
               </button>
                 <button
                     :class="{ active: tab == 'Communication' }"
                     @click="tab = 'Communication'"
                     class="btn btn-light"
                 >
                     <i class="fas fa-user-clock pr-2"></i>Communication
                 </button>

             </div>
           </div>
         </div>
         <div class="row my-2">
           <div class="col-12 py-1">
             <div role="group" aria-label="1" class="btn-group btn-block">
               <button
                 :class="{ active: tab == 'references' }"
                 @click="tab = 'references'"
                 class="btn btn-light"
               >
                 <i class="fas fa-user-friends pr-2"></i>Refer
               </button>
               <button
                 :class="{ active: tab == 'compliance' }"
                 @click="tab = 'compliance'"
                 class="btn btn-light"
               >
                 <i class="fas fa-check-square pr-2"></i>Compliance
               </button>
             </div>
           </div>
         </div>
         <div class="row my-2">
           <div class="col-12 py-1">
             <div role="group" aria-label="1" class="btn-group btn-block">
               <button
                 :class="{ active: tab == 'logs' }"
                 @click="tab = 'logs'"
                 class="btn btn-light"
               >
                 <i class="fas fa-list pr-2"></i>Logs
               </button>
               <b-dropdown
                 id="action"
                 variant="primary"
                 text="Actions"
                 style="outline: none"
               >
                 <b-dropdown-item>
                   <button
                     type="button"
                     class="btn btn-success btn-sm mt-1"
                     data-original-title="View"
                     v-on:click="updateStatus(applicant.id, { status: '1' })"
                     :disabled="edit"
                   >
                     <i class="mr-1 fa fa-check"></i> Accept
                   </button>
                 </b-dropdown-item>
                 <b-dropdown-item>
                   <button
                     type="button"
                     class="btn btn-danger btn-sm mt-1"
                     data-original-title="View"
                     v-on:click="updateStatus(applicant.id, { status: '2' })"
                     :disabled="edit"
                   >
                     <i class="mr-1 fa fa-times mr-1"></i> Reject
                   </button>
                 </b-dropdown-item>
                 <b-dropdown-item>
                   <button
                     type="button"
                     class="btn btn-danger btn-sm mt-1"
                     data-original-title="View"
                     v-on:click="updateStatus(applicant.id, { status: '6' })"
                     :disabled="edit"
                   >
                     <i class="mr-1 fa fa-times mr-1"></i> No Show
                   </button>
                 </b-dropdown-item>
                 <b-dropdown-divider></b-dropdown-divider>
                 <b-dropdown-item>
                   <button
                     type="button"
                     class="btn btn-primary btn-sm mt-1"
                     data-original-title="View"
                     v-on:click="updateStatus(applicant.id, { status: '3' })"
                     :disabled="edit"
                   >
                     <i class="mr-1 fa fa-minus mr-1"></i> Inexperienced
                   </button>
                 </b-dropdown-item>
                 <b-dropdown-item>
                   <button
                     type="button"
                     class="btn btn-secondary btn-sm mt-1"
                     data-original-title="View"
                     v-on:click="updateStatus(applicant.id, { status: '4' })"
                     :disabled="edit"
                   >
                     <i class="mr-1 fa fa-times mr-1"></i> Not Yet
                   </button>
                 </b-dropdown-item>
                 <b-dropdown-item>
                   <button
                     type="button"
                     class="btn btn-info btn-sm mt-1"
                     data-original-title="View"
                     v-on:click="updateStatus(applicant.id, { status: '5' })"
                     :disabled="edit"
                   >
                     <i class="mr-1 fas fa-archive"></i> Archive
                   </button>
                 </b-dropdown-item>
                 <b-dropdown-divider></b-dropdown-divider>
                 <b-dropdown-item>
                   <button
                     type="button"
                     class="btn btn-danger btn-sm mt-1"
                     data-original-title="View"
                     v-on:click="destroyAlert(applicant.id)"
                     :disabled="edit"
                   >
                     <i class="mr-1 fa fa-trash"></i> Delete
                   </button>
                 </b-dropdown-item>
                 <b-dropdown-divider></b-dropdown-divider>
                 <b-dropdown-item v-if="applicant.status == 3">
                   <button
                     type="button"
                     class="btn btn-success btn-sm mt-1"
                     data-original-title="View"
                     v-on:click="updateStatus(applicant.id, { hire: '1' })"
                     :disabled="edit"
                   >
                     <i class="mr-1 fas fa-check-double"></i>
                     <b>LIVE</b>
                   </button>
                 </b-dropdown-item>
               </b-dropdown>
             </div>
           </div>
         </div>
       </div>
       <div class="row">
         <div class="col">
           <div v-if="tab == 'applicant'">
             <applicant />
           </div>
           <div v-if="tab == 'interviews'">
             <interviews />
           </div>
           <div v-if="tab == 'Communication'">
             <Communication />
           </div>
             <div v-if="tab == 'references'">
                 <references />
             </div>
           <div v-if="tab == 'compliance'">
             <compliance />
           </div>
           <div v-if="tab == 'logs'">
             <logs />
           </div>
         </div>
       </div>
     </div>
   </template>
   <script>
   import Applicant from "./application/Applicant";
   import Interviews from "./application/Interviews";
   import Communication from "./application/Communication";
   import References from "./references/Main.vue";
   import Compliance from "./application/Compliance";
   import Logs from "./application/Logs";

   export default {
     computed: {
       production: function () {
         return window.location.href.includes("cavalrycare.co.uk") ? true : false;
       },
       currentTab: function () {
         return this.$route.params.tab || "applicant";
       },
     },
     data: function () {
       return {
         applicant: {},
         interviews: {},
         references: {},
         routePrefix: "/api/recruitment/applications/",
         employmentRoute: "/api/recruitment/employment/",
         tab: "applicant",
         edit: false,
         disabled: false,
           isDropdown2Visible: false,
       };
     },
     components: {
       Applicant,
       Interviews,
         Communication,
       References,
       Compliance,
       Logs,
     },
     mounted: function () {
       this.showApplication();
         this.$root.$on('bv::dropdown::show', bvEvent => {
             if(bvEvent.componentId === 'dropdown-2') {
                 this.isDropdown2Visible = true;
             }
         })
         this.$root.$on('bv::dropdown::hide', bvEvent => {
             if(bvEvent.componentId === 'dropdown-2') {
                 this.isDropdown2Visible = false;
             }
             if(this.isDropdown2Visible) {
                 bvEvent.preventDefault()
             }
         })


     },
     methods: {
       showApplication() {
         axios.get(this.routePrefix + this.$route.params.id).then((response) => {
           this.applicant = response.data;
         });
       },
       updateStatus(id, data) {
         axios
           .patch(this.routePrefix + "status/" + id, data)
           .then((response) => {
               console.log();
             this.$root.notification(response.data.message, "success");
           })
           .catch((err) => {
             this.$root.notification(error.response.data.message, "error");
           })
           .then(() => {
             this.showApplication();
           });
       },
       destroyAlert(id) {
         this.$swal
           .fire({
             title: "Delete Application",
             text: "Are you sure you would like to delete this application?",
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
             this.$router.push("/recruitment/applications");
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
   .btn-sm,
   .btn-group-sm > .btn {
     width: 150px !important;
   }
   .btn-light:hover {
     color: #212529;
     background-color: #e1effe;
     border-color: #e1effe;
   }
   </style>
