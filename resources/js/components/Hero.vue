<template>
  <section class="hero hero-home">
    <template v-if="!loading">
      <default-carousel v-if="heroImages.length <= 0" />
      <custom-carousel v-else :images="heroImages" />
    </template>
  </section>
</template>

<script>
import Vue from "vue";
import Axios from "axios";

import DefaultCarousel from "~/components/hero/DefaultCarousel";
import CustomCarousel from "~/components/hero/CustomCarousel";

Vue.component("default-carousel", DefaultCarousel);
Vue.component("custom-carousel", CustomCarousel);

export default {
  name: "Hero",
  data: () => ({
    heroImages: [],
    loading: true,
  }),
  mounted() {
    this.getHeroImages();
  },
  methods: {
    async getHeroImages() {
      await Axios.get("/api/get/hero-images")
        .then(({ data }) => {
          if (data.length > 0)
            this.$store.dispatch("general/updateNavColor", true);

          this.heroImages = data;
        })
        .catch((err) => console.log(err))
        .finally(() => (this.loading = false));
    },
  },
};
</script>

<style src="../../css/hero.css"></style>
<style scoped src="../../css/mobile.css">
