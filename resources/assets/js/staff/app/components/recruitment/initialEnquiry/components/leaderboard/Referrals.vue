<template>
  <div>
    <div class="row py-3">
      <div class="col-12">
        <div class="table-responsive">
          <table
            class="
              table table-hover table-bordered table-striped
              js-appear-enabled
              animated
              fadeIn
            "
          >
            <thead class="thead-light">
              <tr>
                <th>Username</th>
                <th>Referrals</th>
              </tr>
            </thead>
            <tbody class="bg-white">
              <tr v-for="(data, key) in leaderboard" :key="key">
                <td>{{ data.username }}</td>
                <td>{{ data.referral_count }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template> 
<script>
export default {
  computed: {
    leaderboard: function () {
      return this.$store.state.invites.leaderboard;
    },
  },
  mounted() {
    this.getLeaderboard();
  },
  methods: {
    async getLeaderboard() {
      await this.$store.dispatch("invites/getReferralsLeaderboard");
    },
  },
};
</script>