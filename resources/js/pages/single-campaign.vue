<template>
  <div>
    <section class="content-detail">
      <div class="container ct-main-detail">
        <div class="row rw-main-detail">
          <div class="col-md-7 col-detail-left-1">
            <img class="banner-detail-donation" v-lazy="program.image_url" alt="image" />
            <div class="ic-float-wrapper">
              <span class="icon fa" :class="program.cat_icon"></span>
            </div>
            <div class="wrapper-detail-banner">
              <div class="rw-ctn-banner">
                <div class="wrapp-mitra-name-head">
                  <h3 class="mitra-name-head">YS</h3>
                </div>
                <div class="col-ctn-banner col-ctn-banner-left">
                  <p class="banner-fundraiser">Fundraiser</p>
                  <h5 class="fundraiser-name-banner">
                    <skeleton-box v-if="loading.program" />
                    <template v-else>{{ program.regional }}</template>
                  </h5>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-5 col-detail-right-1 body-campaign" ref="body">
            <div v-show="donationForm == ''" class="wrapper-detail-right donation-flow-1 pl-5">
              <h5 class="category-name">
                <skeleton-box v-if="loading.program" :min-width="10" :max-width="30" />
                <template v-else>{{ program.category }}</template>
              </h5>

              <template v-if="loading.program">
                <skeleton-box height="1.5em" />
                <skeleton-box height="1.5em" class="mt-2" />
                <skeleton-box class="mt-4" :min-width="15" :max-width="50" />
              </template>

              <template v-else>
                <h3 class="program-name">{{ program.title }}</h3>
                <p class="cabang">
                  <i class="fa fa-map-marker mr-2"></i>
                  {{ program.location }}
                </p>
              </template>

              <div class="mt-4" v-if="loading.program">
                <skeleton-box />
                <skeleton-box class="mt-2" />
              </div>
              <template v-else>
                <template v-if="program.max_time">
                  <div class="wrapper-value">
                    <p class="percent">{{ program.progress }}%</p>
                    <p class="value-idr">{{ program.nominal | currency }}</p>
                  </div>

                  <div class="progress">
                    <div
                      class="progress-bar"
                      role="progressbar"
                      :aria-valuenow="program.progress"
                      aria-valuemin="0"
                      aria-valuemax="100"
                      :style="{ width: `${program.progress}%` }"
                    ></div>
                  </div>

                  <div class="wrapper-time">
                    <p class="time-left">
                      <i
                        :class="
                          program.completed == 1 ? 'text-success' : '' 
                        "
                        class="fa fa-hourglass-half"
                      ></i>
                      <template v-if="program.completed == 1">
                        <span class="text-success">Completed</span>
                      </template>
                      <template v-else>
                        {{
                        program.max_time | timeLeft
                        }}
                      </template>
                    </p>
                    <p v-show="program.progress > 0" class="status-project">Collected</p>
                  </div>
                </template>

                <div class="single-new-format" v-else>
                  <div>
                    <p>Total Donasi</p>
                    <h4 class="heading">{{program.totalNominal|currency}}</h4>
                  </div>
                  <div>
                    <p>Total Donatur</p>
                    <h4 class="heading">{{program.totalDonatur}}</h4>
                  </div>
                </div>

                <div v-if="program.completed == 0" class="button-wrapp-btm">
                  <button
                    type="button"
                    class="btn btn-success btn-donasi"
                    @click="setDonationForm('nominal')"
                  >Donasi Sekarang</button>
                  <button
                    type="button"
                    class="btn btn-outline-success btn-fundraiser" data-toggle="modal" data-target="#modal-target"
                  >Jadi Fundraiser?</button>
                </div>
              </template>
            </div>

            <DonationForm
              v-if="program.completed == 0"
              v-show="donationForm !== ''"
              v-on:back="resetDonationForm()"
              :campaign-id="program.id"
              :title="program.title"
              :regional="program.regional"
            />
          </div>

          <div class="col-md-7 col-detail-left-2">
            <ul class="nav nav-tabs nav-tabs-detail" id="myTab" role="tablist">
              <li class="nav-item nav-tabs-item">
                <a
                  class="nav-link active"
                  id="detail-tab"
                  data-toggle="tab"
                  href="#detail"
                  role="tab"
                  aria-controls="detail"
                  aria-selected="true"
                >Detail Kegiatan</a>
              </li>
              <li class="nav-item nav-tabs-item">
                <a
                  class="nav-link"
                  id="info-tab"
                  data-toggle="tab"
                  href="#info"
                  role="tab"
                  aria-controls="info"
                  aria-selected="false"
                >Informasi Terbaru</a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <template v-if="loading.program">
                <skeleton-box />
                <skeleton-box />
                <skeleton-box />
                <skeleton-box />
              </template>
              <div
                v-else
                class="tab-pane fade show active"
                id="detail"
                role="tabpanel"
                aria-labelledby="detail-tab"
                v-html="program.content"
              ></div>
              <div class="tab-pane fade" id="info" role="tabpanel" aria-labelledby="info-tab">
                <div class="card card-informasi" v-for="info in infos" :key="info.id">
                  <div class="card-header">
                    <h4 class="card-title">{{ info.title }}</h4>
                    <label class="times">
                      <i class="fa fa-hourglass-half mr-2"></i>
                      {{ info.created_at }} |
                      {{ info.author }}
                    </label>
                  </div>
                  <div class="card-body">
                    <!-- <img class="banner-informasi" v-lazy="program.image_url" alt="image" /> -->
                    <div class="detai-informasi" v-html="info.content"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-5 col-detail-right-2 sidebar-campaign" ref="sidebar">
            <div class="wrapper-detail-right-2 pl-5 sidebar-content">
              <ul class="nav nav-tabs nav-tabs-detail nav-tabs-detail-2" id="myTab" role="tablist">
                <li class="nav-item nav-tabs-item">
                  <a
                    class="nav-link active"
                    id="donatur-tab"
                    data-toggle="tab"
                    href="#donatur"
                    role="tab"
                    aria-controls="donatur"
                    aria-selected="true"
                  >Donatur</a>
                </li>
                <li class="nav-item nav-tabs-item">
                  <a
                    class="nav-link"
                    id="fundraiser-tab"
                    data-toggle="tab"
                    href="#fundraiser"
                    role="tab"
                    aria-controls="fundraiser"
                    aria-selected="false"
                  >Fundraiser</a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div
                  class="tab-pane fade show active"
                  id="donatur"
                  role="tabpanel"
                  aria-labelledby="donatur-tab"
                >
                  <ul class="list-group">
                    <template v-if="donations.length > 0">
                      <li v-for="donation in donations" :key="donation.id" class="list-group-item">
                        <div class="row rw-donate">
                          <div class="col-md-6 col-donate-left">
                            <h5 class="donatur-name">{{ donation.alias }}</h5>
                            <p class="date-donate">
                              {{
                              donation.created_at
                              | formatDate
                              }}
                            </p>
                          </div>
                          <div class="col-md-6 col-donate-right">
                            <h3 class="donate-count">
                              {{
                              donation.nominal
                              | currency
                              }}
                            </h3>
                          </div>
                        </div>
                        <p class="donate-desc mb-0">{{ donation.message }}</p>
                      </li>
                    </template>
                    <template v-else>
                      <li class="list-group-item">
                        <p>Jadi yang pertama melakukan Donasi</p>
                      </li>
                    </template>
                  </ul>
                </div>
                <div
                  class="tab-pane fade"
                  id="fundraiser"
                  role="tabpanel"
                  aria-labelledby="fundraiser-tab"
                >
                  <ul class="list-group">
                    <li v-for="user in users" :key="user.id" class="list-group-item">
                      <div class="rw-fdn">
                        <img class="ic-ys-fnd" src="/images/ys-1.svg" alt />
                        <div class="wrapp-2-col">
                          <div class="wrapp-fnd">
                            <h5 class="fnd-name">{{ user.name }}</h5>
                            <p class="fnd-lct">
                              <i class="fa fa-map-marker"></i>
                              {{ user.regional }}
                            </p>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <SuccessStory />

    <Footer />

    <div class="modal fade" id="modal-target" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content custom-modal-content">
          <div class="modal-header border-0 p-1">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body pb-4">
            <div class="item-input">
              <form action="#">
              <h5 class="modal-title title-text mb-4">Tentukan Target Donasi Anda</h5>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text rp-ic p-0 mr-2">Rp.</span>
                </div>
                <input type="number" class="form-control input-value-donasi">
              </div>
              <div class="custom-control custom-checkbox name-check mb-5">
                <input type="checkbox" class="custom-control-input" id="customCheck1">
                <label class="custom-control-label lable-name" for="customCheck1">Tampilkan Sebagai “Hamba Allah”</label>
              </div>
              <div class="wp-btn">
                <button class="btn btn-target btn-success" type="submit">Set Target Donasi</button>  
              </div>
            </form>
            </div>
            <!-- SETELAH SET TARGET -->
            <!-- <div class="item-share">
              <img src="/images/ic-star.svg">
              <h4 class="txt-selamat">Selamat!</h4>
              <p class="txt-desc-share">Anda telah ikut ambil bagian menjadi <span>Fundraisher</span> dari <span>Program Bangun Panti Tina Netra Cerdas Bangsa..</span></p>
              <ul class="list-share">
                <li><a href="#"><i class="fa fa-facebook"></i> Facebook</a></li>
                <li><a href="#"><i class="fa fa-instagram"></i> Instagram</a></li>
                <li><a href="#"><i class="fa fa-twitter"></i> Twitter</a></li>
              </ul>
              <p class="txt-share">Jangan lupa bagikan ke teman dan kerabat anda. Berbagi bersama menjalin kasih.</p>
              <button class="btn btn-account-saya">Account Saya</button>
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
import SuccessStory from "~/components/SuccessStory.vue";
import Footer from "~/components/Footer.vue";
import DonationForm from "~/components/DonationForm.vue";
import SkeletonBox from "~/components/SkeletonBox.vue";

import moment from "moment";

export default {
  name: "Donasi",

  metaInfo() {
    return { title: "Kampanye" };
  },

  components: { DonationForm, SuccessStory, Footer, SkeletonBox },

  data: () => ({
    users: [],
    loading: {
      program: true,
      donations: true,
      info: true,
    },
    donations: [],
    infos: [],
    program: {
      id: null,
      author: null,
      title: null,
      content: null,
      regional: null,
      location: null,
      image_url: null,
      video_url: null,
      max_time: null,
      nominal: 0,
      completed: null,
      category: null,
      cat_icon: null,
      progress: null,
      created_at: null,
    },
  }),

  computed: {
    donationForm() {
      return this.$store.getters["general/donationForm"];
    },
  },

  mounted() {
    this.fetchData().then(() => {
      this.fetchProgress();
      this.fetchDonatur();
    });
  },

  methods: {
    async fetchData() {
      return await Axios.get(`/api/campaigns/${this.$route.params.slug}`)
        .then((response) => {
          if (response.data.length <= 0) this.$router.push({ name: "404" });

          response.data.map((item) => {
            const donations = item.donations;

            const verifiedDonation = donations.filter(
              (donation) => donation.is_verified === 1
            );

            const nominal = verifiedDonation.map(
              (donation) => donation.nominal
            );

            const userId = verifiedDonation.map((donation) => donation.user_id);
            const totalDonaturObj = userId.reduce((map, val) => {
              map[val] = (map[val] || 0) + 1;
              return map;
            }, {});
            const totalDonatur = Object.keys(totalDonaturObj).length || 0;

            let totalNominal = 0;
            if (nominal.length > 0)
              totalNominal = nominal.reduce(
                (acc, val) => parseInt(acc) + parseInt(val)
              );

            const progress =
              (parseInt(totalNominal) / parseInt(item.max_nominal)) * 100;

            const is_expired = moment().isAfter(moment(item.max_time));

            if (is_expired) this.$router.push({ name: "home" });

            this.program.id = item.id;
            this.program.author = item.admin !== null ? item.admin.name : "-";
            this.program.regional =
              item.regional !== null ? item.regional.name : "-";
            this.program.title = item.title;
            this.program.content = item.content;
            this.program.location = item.location;
            this.program.image_url = `../storage/admin/${item.cover_image_url}`;
            this.program.video_url = item.video_url;
            this.program.max_time = item.max_time;
            this.program.nominal = item.max_nominal;
            this.program.totalNominal = totalNominal;
            this.program.totalDonatur = totalDonatur;
            this.program.category = item.category.category;
            this.program.cat_icon = item.category.icon;
            this.program.progress = Math.ceil(progress);
            this.program.created_at = item.created_at;
            this.program.completed = item.is_complete;
          });
        })
        .catch(() => {})
        .finally(() => (this.loading.program = false));
    },

    async fetchProgress() {
      return await Axios.get(`/api/campaigns/${this.program.id}/progress`)
        .then((response) => {
          this.infos = response.data.map((item) => {
            return {
              id: item.id,
              author: item.author.name || "",
              title: item.title,
              content: item.content,
              created_at: moment(item.created_at).format("DD-MM-YYYY"),
            };
          });
        })
        .catch(() => {})
        .finally(() => (this.loading.info = false));
    },

    async fetchDonatur() {
      return await Axios.get(`/api/donations/campaign/${this.program.id}`)
        .then((response) => {
          this.donations = response.data.map((item) => {
            let username;

            if (item.user === null) {
              username = item.admin.name;
            } else {
              username = item.user.name;
            }

            return {
              id: item.id,
              nominal: item.nominal,
              message: item.message,
              username: username,
              alias: item.alias,
              created_at: item.created_at,
            };
          });
        })
        .catch(() => {})
        .finally(() => (this.loading.donations = false));
    },

    setDonationForm(form) {
      this.$store.dispatch("general/setDonationForm", form);
    },

    resetDonationForm() {
      this.$store.dispatch("general/resetDonationForm");
    },
  },
};
</script>

<style src="../../css/single-campaign.css"></style>
<style scoped src="../../css/mobile.css">