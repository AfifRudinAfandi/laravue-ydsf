<template>
  <div>
    <section class="hero-detail-mitra">
      <img class="thumbnail" v-lazy="mitra.image_url" alt="image" />
    </section>

    <div class="header-detail-mitra">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="wraper-logo-mitra">
              <div
                v-lazy-container="{
                  selector: 'img',
                  error: '/images/logo.png',
                  loading: '/images/img-loading.gif',
                }"
              >
                <img class="logo-mitra" data-src="mitra.logo_url" />
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <h4 class="mitra-name-head">
              <skeleton-box v-if="loading" height="1.6em" />
              <template v-else>{{ mitra.name }}</template>
            </h4>
            <p class="mitra-lokasi">
              <skeleton-box v-if="loading" />
              <template v-else>
                <i class="fa fa-map-marker mr-2"></i>
                {{ mitra.address }}
              </template>
            </p>
          </div>
          <div class="col-md-5">
            <div class="wrapper-program-dana">
              <div class="wrapp-dana">
                <h4 class="count">
                  <skeleton-box v-if="loading" />
                  <template v-else>{{ mitra.has }}</template>
                </h4>
                <p class="count-name">Program Terdanai</p>
              </div>
              <span class="decor-vertical"></span>
              <div class="wrapp-dana">
                <h4 class="count">
                  <skeleton-box v-if="loading" />
                  <template v-else>{{ mitra.hasnt }}</template>
                </h4>
                <p class="count-name">Program Belum Terdanai</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="program">
      <div class="container">
        <div class="wrapp-top-title">
          <div class="main-title">
            <h4 class="main-title-first">
              Fundraising
              <span>Programs</span>
            </h4>
            <p class="main-title-second">Every donation you have millions of benefits for others</p>
          </div>
        </div>

        <div class="row">
          <Program :url="url" />
        </div>
      </div>
    </section>

    <CardJoin />

    <Footer home="true" />
  </div>
</template>

<script>
import Axios from "axios";

import Program from "~/components/Program.vue";
import CardJoin from "~/components/CardJoin.vue";
import Footer from "~/components/Footer.vue";
import SkeletonBox from '~/components/SkeletonBox.vue'

export default {
  name: "DetailMitra",

  data: () => ({
    mitra: "",
    title: "",
    loading: true,
  }),

  metaInfo() {
    return { title: this.title };
  },

  components: {
    Program,
    CardJoin,
    Footer,
    SkeletonBox,
  },

  computed: {
    url() {
      return `/api/campaigns/${this.$route.params.id}/regional`;
    },
    items() {
      if (this.selectedCategories.length <= 0) return this.programs;

      return this.programs.filter((program) =>
        this.selectedCategories.includes(program.category_id)
      );
    },
  },

  mounted() {
    this.fetchMitra().then(() => {
      this.$store.dispatch("general/toggleLoading", false);
    });
  },

  methods: {
    async fetchMitra() {
      return await Axios.get(`/api/regionals/${this.$route.params.id}`)
        .then((res) => {
          res.data.map((mitra) => {
            this.title = mitra.name;
            this.mitra = {
              id: mitra.id,
              image_url: `/storage/admin/${mitra.image}`,
              logo_url: `/storage/admin/${mitra.logo}`,
              name: mitra.name,
              address: mitra.address,
              has: mitra.hasDonation,
              hasnt: mitra.hasntDonation,
            };
          });
        })
        .catch(() => {})
        .finally(() => this.loading = false)
    },
  },
};
</script>

<style src="../../css/detail-mitra.css"></style>
<style scoped src="../../css/mobile.css">
