<template>
  <div class="content">
    <div class="row py-3">
      <div class="col-12">
        <h3 class="mb-0">Vaccination Evidence</h3>
      </div>
    </div>
    <div class="row">
      <div
        class="col-12 col-md-6 animated fadeIn p-3"
        v-for="(image, key) in vaccinations"
        :key="key"
      >
        <a
          class="
            img-link-zoom-in img-thumb img-lightbox
            block block-rounded
            text-center
            block-fx-pop
          "
          :class="{ 'block-mode-loading': !loaded }"
          :href="
            '/api/covid/vaccination/evidence/' +
            image.staff_id +
            '/' +
            image.filename
          "
        >
          <img
            class="img-fluid"
            :src="
              '/api/covid/vaccination/evidence/' +
              image.staff_id +
              '/' +
              image.filename
            "
          />
        </a>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  computed: {
    loaded: {
      get() {
        return this.$store.state.vaccination.loaded;
      },
      set(newVal) {
        return (this.$store.state.vaccination.loaded = newVal);
      },
    },
    vaccinations: function () {
      return this.$store.state.vaccination.vaccinations;
    },
  },
  mounted() {
    this.show();
  },
  methods: {
    async show() {
      await this.$store
        .dispatch("vaccination/showVaccination", {
          id: this.$route.params.id,
        })
        .then((res) => {
          this.loaded = true;
        });
    },
  },
};
</script>