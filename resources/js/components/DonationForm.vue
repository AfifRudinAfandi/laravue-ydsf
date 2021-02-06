<template>
  <div class="wrapper-detail-right donation-flow-2 pl-5">
    <ul class="nav nav-tabs tabs-flow">
      <li class="nav-item item-tab-flow">
        <a
          :class="{ active: donationForm == 'nominal' }"
          class="nav-link link-tab-flow"
          id="home-tab"
          aria-controls="home"
          aria-selected="true"
        >01</a>
      </li>
      <li class="nav-item item-tab-flow">
        <a
          :class="{ active: donationForm == 'profil' }"
          class="nav-link link-tab-flow"
          id="profile-tab"
          aria-controls="profile"
          aria-selected="false"
        >02</a>
      </li>
      <li class="nav-item item-tab-flow">
        <a
          :class="{ active: donationForm == 'checkout' }"
          class="nav-link link-tab-flow"
          id="contact-tab"
          aria-controls="contact"
          aria-selected="false"
        >03</a>
      </li>
    </ul>

    <div class="tab-content">
      <div
        :class="{ active: donationForm == 'nominal' }"
        class="tab-pane"
        id="home"
        role="tabpanel"
        aria-labelledby="home-tab"
      >
        <div class="wrapper-btn-back">
          <button type="button" class="btn btn-link btn-back-donasi" @click="$emit('back')">
            <i class="fa fa-angle-left"></i>
            Back
          </button>
          <h4 class="title-nominal">Nominal Donasi</h4>
        </div>
        <div class="input-group" style="margin-bottom: 32px;">
          <div class="input-group-prepend">
            <span class="input-group-text rp-ic">Rp.</span>
          </div>
          <input type="number" v-model="nominal" class="form-control input-value-donasi" />
        </div>
        <div class="wrapper-value">
          <p
            class="value-donasi-sugess"
            :class="{ 'sugess-2': btn[0] }"
            @click="selectNominal(0)"
          >Rp. 50.000</p>
          <p
            class="value-donasi-sugess"
            :class="{ 'sugess-2': btn[1] }"
            @click="selectNominal(1)"
          >Rp. 100.000</p>
          <p
            class="value-donasi-sugess sugges-2"
            :class="{ 'sugess-2': btn[2] }"
            @click="selectNominal(2)"
          >Rp. 500.000</p>
        </div>
        <div class="wrapper-button d-flex flex-row">
          <button
            type="button"
            class="btn btn-item btn-success btn-next"
            :disabled="nominal <= 0"
            @click="setDonationForm('profil')"
          >Lanjut</button>
        </div>
      </div>

      <div
        :class="{ active: donationForm == 'profil' }"
        class="tab-pane"
        id="profile"
        role="tabpanel"
        aria-labelledby="profile-tab"
      >
        <div class="tab-content" id="myTabContent">
          <div class="wrapper-btn-back">
            <button type="button" class="btn btn-link btn-back-donasi" @click.prevent="reset">
              <i class="fa fa-angle-left"></i>
              Cancel
            </button>
            <h4 class="title-nominal">{{ !user ? 'Pilih Jenis Login' : 'Donasi' }}</h4>
          </div>
          <div class="tab-pane fade show active form-donation" id="phone" role="tabpanel">
            <div v-show="loading" class="wrapper-loading">
              <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
              </div>
              <p>{{ loadingLabel }}</p>
            </div>

            <form
              class="form-donasi-flow"
              @submit.prevent="!user ? checkForm : donasi"
              @keydown="form.onKeydown($event)"
            >
              <div
                v-show="errors.length"
                class="alert alert-warning alert-dismissible fade show error-badge"
                role="alert"
              >
                <ul class="item">
                  <li v-for="error in errors" :key="error">{{ error }}</li>
                </ul>
                <button type="button" class="close" @click="errors = []">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="form-group" v-if="!user">
                <label class="label-nama">Phone Number*</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text label-nomor">+62</span>
                  </div>
                  <input
                    type="tel"
                    v-model="phone"
                    class="form-control custom-input tel-number"
                    placeholder="812XXXXXX"
                    required
                  />
                </div>
              </div>

              <div class="form-group" v-if="!hideName">
                <label class="label-nama">Name*</label>
                <input v-model="alias" type="text" class="form-control custom-input" required />
              </div>

              <div class="custom-control custom-checkbox mb-4">
                <input
                  v-model="hideName"
                  type="checkbox"
                  class="custom-control-input"
                  id="tampilkan-sebagai"
                  @click="toggleAnonim"
                />
                <label
                  class="custom-control-label label-nama"
                  for="tampilkan-sebagai"
                >Tampilkan Sebagai Anonim</label>
              </div>

              <div class="form-group">
                <label class="label-nama" for="exampleFormControlTextarea1">Tuliskan Pesan</label>
                <textarea
                  v-model="form.message"
                  class="form-control custom-input"
                  id="exampleFormControlTextarea1"
                  rows="3"
                ></textarea>
              </div>

              <p>
                Anda akan melakukan donasi sebesar
                <strong>{{ nominal | currency }}</strong>,
                <a href="#" @click.prevent="setDonationForm('nominal')">Ubah Nominal</a>
              </p>

              <div id="recaptcha-container"></div>

              <div class="wrapper-button-ctr">
                <button
                  v-if="!user"
                  class="btn btn-success donasi-sekarang"
                  data-target="#otp"
                  type="button"
                  @click="checkForm"
                  :disabled="phone == '' || alias == ''"
                >Donasi Sekarang</button>

                <button
                  v-else
                  type="submit"
                  class="btn btn-success donasi-sekarang"
                  @click="donasi"
                  :disabled="alias == ''"
                >Donasi Sekarang</button>

                <template v-if="!user">
                  <h4 class="loginby-title text-center">Sign in with :</h4>
                  <div class="wrapper-btn-sign">
                    <template v-if="facebookLogin">
                      <social-login provider="facebook">
                        <button type="button" class="btn btn-facebook">
                          <i class="fa fa-facebook-f"></i>
                          <span>Facebook</span>
                        </button>
                      </social-login>
                    </template>
                    <template v-if="googleLogin">
                      <social-login provider="google">
                        <button type="button" class="btn btn-google">
                          <i class="fa fa-google"></i>
                          <span>Google</span>
                        </button>
                      </social-login>
                    </template>
                  </div>
                </template>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div
        :class="{ active: donationForm == 'checkout' }"
        class="tab-pane"
        id="contact"
        role="tabpanel"
        aria-labelledby="contact-tab"
      >
        <div class="detail-detail-donasi">
          <div class="detail-header">
            <h5 class="detail-title" id="detail-donasi-label">Detail Donation</h5>
          </div>
          <div class="detail-body">
            <p class="desc-nomor">Pilih jenis bank dan motode penyaluran donasi.</p>
            <div class="card card-detail-donasi">
              <div class="card-header">
                <p class="judul">Program Donasi</p>
                <h5 class="program-donasi-card">{{ title }}</h5>
                <p class="cabang mb-2">
                  <i class="fa fa-map-marker"></i>
                  {{ regional }}
                </p>
              </div>
              <div class="card-body">
                <p class="judul-nama">Nama Donatur</p>
                <p class="nama-donatur">{{ alias }}</p>
                <p class="judul-nama">Nominal</p>
                <p class="nominal-donasi">{{ nominal | currency }},-</p>
                <p class="judul-nama">Nomor Virtual Account</p>
                <p class="jumlah-transfer">{{ virtualAccount }}</p>
              </div>
            </div>
            <div class="card card-detail-donasi">
              <div class="card-header">
                <p class="title-info-rekening">Informasi Rekening Tujuan</p>
              </div>
              <div class="card-body">
                <div class="wrapp-row">
                  <img class="ic-btm-bca" src="/images/bni.png" alt="bank-logo" />
                  <div class="wrapp-col-btm">
                    <p class="title-no-rek">No. Rekening</p>
                    <p class="no-rek">0883.815.589</p>
                    <p class="nama-yayasan">An. Yayasan Dana Sosial Al-Falah</p>
                  </div>
                </div>
                <p class="btm-red-1">Segera selesaikan pembayaran donasi sebelum</p>
                <p class="btm-red-2">{{ expiredPayment }}</p>
              </div>
            </div>
            <div class="text-center">
              <button @click="reset" class="btn btn-success donasi-sekarang">Selesai</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" data-backdrop="static" id="otp" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-verifikasi">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Verifikasi</h5>
            <button type="button" class="close" @click.prevent="closeModal" aria-label="Close">
              <span aria-hidden="true"></span>
            </button>
          </div>
          <div class="modal-body">
            <p class="desc-nomor">
              Masukkan kode verifikasi yang telah dikirimkan ke
              <span
                class="phone-number"
              >+62-{{ phone }}</span>
            </p>
            <a class="ubah-nomor" href="#" @click.prevent="closeModal">
              <i class="fa fa-pencil"></i> Ubah nomor HP
            </a>
            <form class="digit-group" @submit.prevent="verif">
              <security-code v-model="code" :length="6"></security-code>

              <p class="belum-terima">Belum menerima kode?</p>
              <a class="kirim-ulang" href="#" @click.prevent="sendSMS">Kirim Ulang Kode</a>

              <button type="submit" class="btn btn-success btn-salurkan">Verifikasi</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SocialLogin from "~/components/auth/SocialLogin";
import { Form } from "vform";
import SecurityCode from "~/components/SecurityCode";

import { mapGetters } from "vuex";
import firebase from "firebase";
import Axios from "axios";
import $ from "jquery";
import moment from "moment";

export default {
  name: "DonationForm",

  components: { SocialLogin, Form, SecurityCode },

  props: ["campaignId", "title", "regional"],

  data: () => ({
    hideName: false,
    code: "",
    loading: false,
    loadingLabel: "",
    btn: [true, true, true],
    errors: [],
    show: {
      nominal: true,
      profile: false,
      checkout: false,
    },
    form: new Form({
      user_id: "",
      campaign_id: "",
      nominal: "",
      alias: "",
      message: "",
    }),
  }),

  computed: {
    nominal: {
      get() {
        return this.$store.getters["general/nominal"];
      },
      set(val) {
        this.$store.dispatch("general/updateNominal", val);
      },
    },
    alias: {
      get() {
        return this.$store.getters["general/alias"];
      },
      set(alias) {
        this.$store.dispatch("general/updateAlias", alias);
      },
    },
    virtualAccount: {
      get() {
        return this.$store.getters["general/virtualAccount"];
      },
      set(va) {
        this.$store.dispatch("general/setVA", va);
      },
    },
    phone: {
      get() {
        return this.$store.getters["general/phone"];
      },
      set(val) {
        this.$store.dispatch("general/updatePhone", val);
      },
    },
    ...mapGetters({
      user: "auth/user",
      googleLogin: "auth/googleLogin",
      facebookLogin: "auth/facebookLogin",
      donationForm: "general/donationForm",
      expiredPayment: "general/expiredPayment",
    }),
  },

  mounted() {
    const self = this;
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier(
      "recaptcha-container",
      { size: "invisible" }
    );

    window.recaptchaVerifier.render().then((widgetId) => {
      window.recaptchaWidgetId = widgetId;
    });
  },

  methods: {
    checkForm: function (e) {
      this.errors = [];

      if (!this.phone) {
        this.errors.push("Masukan nomor telepon");
      }

      if (!this.alias) {
        this.errors.push("Nama harus diisi");
      }

      if (this.alias && this.phone) {
        this.sendSMS();
      }

      e.preventDefault();
    },

    sendSMS() {
      var self = this;
      this.loading = true;
      this.loadingLabel = "Mengirim SMS kode verifikasi...";
      const appVerifier = window.recaptchaVerifier;
      firebase
        .auth()
        .signInWithPhoneNumber(`+62${this.phone}`, appVerifier)
        .then(function (confirmationResult) {
          self.code = "";
          $("#otp").modal("show");
          window.confirmationResult = confirmationResult;
        })
        .catch(function (error) {
          self.loading = false;
          this.$notify({
            group: "all",
            type: "error",
            title: "Gagal mengirim SMS",
            text:
              "Terjadi kesalahan saat mengirim kode, Coba beberapa saat lagi",
          });
        });
    },

    completeVerif(v) {
      this.code = v;
      this.verif();
    },

    verif() {
      var self = this;
      this.loadingLabel = "Melakukan verifikasi kode...";
      $("#otp").modal("hide");
      confirmationResult
        .confirm(this.code)
        .then(function (result) {
          Axios.post("/api/phone-auth", { phone: self.phone })
            .then((response) => {
              self.login();
            })
            .catch((err) => {
              self.loading = false;
            });
        })
        .catch(function (error) {
          self.loading = false;
          this.$notify({
            group: "all",
            type: "warn",
            title: "Gagal memverifikasi Kode",
            text: "Pastikan anda memasukan kode yang valid",
          });
        });
    },

    async login() {
      this.loadingLabel = "Memverifikasi pengguna...";

      let user;
      await Axios.post("/api/login", {
        email: this.phone.toString(),
        password: this.phone.toString(),
      })
        .then((res) => {
          this.$store.dispatch("auth/saveToken", {
            token: res.data.token,
          });
          this.$store.dispatch("auth/updateUser", {
            user: res.data.user,
          });

          this.donasi();
        })
        .catch((err) => {
          this.$notify({
            group: "all",
            type: "warn",
            title: "Gagal memverifikasi pengguna",
            text: "Terjadi kesalahan saat melakukan verifikasi pengguna",
          });
        })
        .finally(() => (this.loading = false));
    },

    async donasi() {
      if (!this.alias) {
        this.errors = [];
        this.errors.push("Nama harus diisi");
      } else {
        this.loading = true;
        this.loadingLabel = "Proses donasi, Tunggu sebentar...";

        this.form.nominal = this.nominal;
        this.form.user_id = this.user.id;
        this.form.alias = this.alias;
        this.form.campaign_id = this.campaignId;

        await this.form
          .post("/api/donations/create")
          .then(({ data }) => {
            console.log(data.payload);
            if (data.error) {
              this.$notify({
                group: "all",
                type: "error",
                title: "Gagal membuat pembayaran",
                text: "Maaf, Terjadi kesalahan saat membuat pembayaran (002)",
              });
            } else {
              this.$store.dispatch("general/setExpiredPayment");
              this.virtualAccount = data.payload.va || "";

              this.$notify({
                group: "all",
                type: "success",
                title: "Berhasil melakukan donasi",
                text: "Selesaikan pembayaran untuk menyelesaikan proses donasi",
              });

              this.$store.dispatch("general/setDonationForm", "checkout");
            }
          })
          .catch((err) => {
            this.$notify({
              group: "all",
              type: "error",
              title: "Gagal melakukan donasi",
              text: "Maaf, Terjadi kesalahan saat melakukan donasi",
            });
          })
          .finally(() => (this.loading = false));
      }
    },

    toggleAnonim() {
      this.hideName = !this.hideName;
      this.alias = this.hideName == true ? "Anonim" : "";
    },

    selectNominal(i) {
      const value = [50000, 100000, 500000];

      this.nominal = value[i];
    },

    setDonationForm(form) {
      this.$store.dispatch("general/setDonationForm", form);
    },

    reset() {
      this.hideName = false;

      this.form = new Form({
        user_id: "",
        campaign_id: "",
        nominal: "",
        alias: "",
        pesan: "",
      });

      this.$store.dispatch("general/resetDonationForm");
    },

    closeModal() {
      this.loading = false;
      $("#otp").modal("hide");
    },
  },
};
</script>

<style src="../../css/donation-form.css"></style>
<style scoped src="../../css/mobile.css">
