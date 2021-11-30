
        <template>
  <div class="content">
    <div class="row">
      <div class="col-12">
        <h3>Offboarding Form</h3>
      </div>
    </div>
    <div class="block block-rounded">
      <div class="block-content">
        <ValidationObserver v-slot="{ handleSubmit }">
          <form @submit.prevent="handleSubmit(submit)">
            <div class="form-row py-2">
              <div class="col">
                <div class="form-group">
                  <ValidationProvider rules="required" v-slot="{ errors }">
                    <label>Full Name</label>
                    <input
                      type="text"
                      name="Full name"
                      class="form-control"
                      v-model="formData.full_name"
                    />
                    <p class="text-danger">{{ errors[0] }}</p>
                  </ValidationProvider>
                </div>
              </div>
            </div>
            <div class="form-row py-2">
              <div class="col">
                <div class="form-group">
                  <ValidationProvider rules="required" v-slot="{ errors }">
                    <label>End of Employment</label>
                    <input
                      type="date"
                      class="form-control"
                      name="End of employment"
                      v-model="formData.employment_end"
                    />
                    <p class="text-danger">{{ errors[0] }}</p>
                  </ValidationProvider>
                </div>
              </div>
            </div>
            <div class="form-row py-2">
              <div class="col">
                <div class="form-group">
                  <ValidationProvider rules="required" v-slot="{ errors }">
                    <label>Access Fob Returned</label>
                    <br />
                    <input
                      type="radio"
                      id="css"
                      name="Access fob returned"
                      :value="'Yes'"
                      v-model="formData.fob_returned"
                    />
                    <label for="css">Yes</label><br />
                    <input
                      type="radio"
                      id="javascript"
                      name="Access fob returned"
                      :value="'No'"
                      v-model="formData.fob_returned"
                    />
                    <label for="javascript">No</label>
                    <p class="text-dager">{{ errors[0] }}</p>
                  </ValidationProvider>
                </div>
              </div>
            </div>
            <div class="form-row py-2">
              <div class="col">
                <div class="form-group">
                  <ValidationProvider rules="required" v-slot="{ errors }">
                    <label>Reason For Leaving</label>
                    <br />
                    <input
                      type="radio"
                      id="css"
                      name="Reason for leaving"
                      :value="'Resignation'"
                      v-model="formData.reason_for_leaving"
                    />
                    <label for="css">Resignation</label><br />
                    <input
                      type="radio"
                      id="javascript"
                      name="Reason for leaving"
                      :value="'Dismissal'"
                      v-model="formData.reason_for_leaving"
                    />
                    <label for="javascript">Dismissal</label>
                    <p class="text-dager">{{ errors[0] }}</p>
                  </ValidationProvider>
                </div>
              </div>
            </div>
            <div class="form-row py-2">
              <div class="col">
                <div class="form-group">
                  <ValidationProvider rules="required" v-slot="{ errors }">
                    <label>Give a brief explination</label>
                    <textarea
                      type="text"
                      class="form-control"
                      rows="5"
                      v-model="formData.explination"
                    />
                    <p class="text-dager">{{ errors[0] }}</p>
                  </ValidationProvider>
                </div>
              </div>
            </div>
            <div class="form-row py-2">
              <div class="col">
                <div class="form-group">
                  <button class="btn btn-success w-100">Submit</button>
                </div>
              </div>
            </div>
          </form>
        </ValidationObserver>
      </div>
    </div>
  </div>
</template>
<script>
import { ValidationProvider, ValidationObserver, extend } from "vee-validate";
import { required } from "vee-validate/dist/rules";
extend("required", {
  ...required,
  message: "{_field_} field is required",
});

export default {
  computes: {},
  data: function () {
    return {
      formData: {
        full_name: "",
        employment_end: "",
        fob_returned: "",
        reason_for_leaving: "",
        explination: "",
      },
    };
  },
  methods: {
    submit() {
      axios
        .post("/api/staff-offboarding", {
          formData: this.formData,
        })
        .then((res) => {
          this.formData = "";
        });
    },
  },
};
</script>
      </div>
    </div>
  </div>
</template>