<template>
  <div>
    <Navbar />

    <section class="hero-login">
      <div class="container">
        <div class="col-md-5">
          <h4 class="title-login">Login Account</h4>
          <p class="input-phone-title">Masukkan nomer HP yang terdaftar.</p>

          <div class="input-group input-g-phone">
            <div class="input-group-prepend input-g-append">
              <span class="input-group-text" id="basic-addon1">+62</span>
            </div>
            <input
              type="tel"
              v-model="phone"
              class="form-control"
              placeholder="812 XXX XXX XXX"
              aria-describedby="basic-addon1"
            />
          </div>

          <div id="recaptcha-container"></div>

          <p class="desc-req mt-4">
            * Pastikan no HP yang anda masukkan aktif dan dalam
            jangkauan anda.
          </p>
          <button
            @click="sendSMS"
            type="button"
            class="btn btn-link btn-next-login"
            :disabled="loading || phone == ''"
          >
            <span v-show="!loading">Selanjutnya</span>
            <div v-show="loading" class="spinner-border spinner-border-sm" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </button>

          <div class="wp-ak">
            <div class="col"></div>
            <p class="or">OR</p>
            <div class="col"></div>
          </div>

          <div class="wrapper-btn-sign">
            <template v-if="emailLogin">
              <button class="btn btn-facebook col" data-toggle="modal" data-target="#email-login">
                <i class="fa fa-envelope"></i>
                <span>Email</span>
              </button>
            </template>
            <template v-if="facebookLogin">
              <social-login provider="facebook" class="btn btn-facebook col">
                <i class="fa fa-facebook-f"></i>
                <span>Facebook</span>
              </social-login>
            </template>
            <template v-if="googleLogin">
              <social-login provider="google" class="btn btn-google col">
                <i class="fa fa-google"></i>
                <span>Google</span>
              </social-login>
            </template>
          </div>
        </div>
      </div>
      <div class="absolut">
        <div class="person-1">
          <img
            class="caracter-1 animated fadeInDown delay-1s"
            src="/images/ilustrasi1.png"
            alt
          />
        </div>
        <div class="person-2">
          <img
            class="caracter-2 animated fadeInDown delay-1s"
            src="/images/ilustrasi2.png"
            alt
          />
        </div>
        <div class="person-3">
          <img
            class="caracter-3 animated fadeInUp delay-1s"
            src="/images/ilustrasi3.png"
            alt
          />
        </div>
      </div>
    </section>

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
              >+62-{{ +phone }}</span>
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

    <div class="modal fade" id="email-login" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-verifikasi">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Login by Email</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"></span>
            </button>
          </div>
          <form @submit.prevent="loginByEmail" @keydown="loginForm.onKeydown($event)">
            <div class="modal-body">
              <div class="form-group">
                <label for="email">Email</label>
                <input
                  type="email"
                  name="email"
                  v-model="loginForm.email"
                  class="form-control"
                  :class="{ 'is-invalid': loginForm.errors.has('email') }"
                />
                <has-error :form="loginForm" field="email"></has-error>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input
                  type="password"
                  name="password"
                  v-model="loginForm.password"
                  class="form-control"
                  :class="{ 'is-invalid': loginForm.errors.has('password') }"
                />
                <has-error :form="loginForm" field="password"></has-error>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-save" type="submit" :disabled="loginForm.busy">
                <span v-show="!loginForm.busy">Login</span>
                <div v-show="loginForm.busy" class="spinner-border spinner-border-sm" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <Footer />
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import firebase from "firebase/app";
import SecurityCode from "~/components/SecurityCode";
import Axios from "axios";
import $ from "jquery";

import SocialLogin from "~/components/auth/SocialLogin";
import VButton from "~/components/auth/SubmitButton";
import Navbar from "~/components/Navbar.vue";
import Footer from "~/components/Footer.vue";

import { Form, HasError, AlertError } from "vform";

export default {
  components: {
    VButton,
    SocialLogin,
    Footer,
    Navbar,
    SecurityCode,
    HasError,
    AlertError,
  },

  layout: "auth",

  metaInfo() {
    return { title: "Login" };
  },

  data: () => ({
    phone: "",
    loading: false,
    code: "",
    loginForm: new Form({
      email: "",
      password: "",
    }),
  }),

  computed: mapGetters({
    user: "auth/user",
    emailLogin: "auth/emailLogin",
    facebookLogin: "auth/facebookLogin",
    googleLogin: "auth/googleLogin",
  }),

  mounted() {
    if (this.user) this.$router.push({ name: "home" });

    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier(
      "recaptcha-container"
    );

    recaptchaVerifier.render().then(function (widgetId) {
      window.recaptchaWidgetId = widgetId;
    });
  },

  methods: {
    sendSMS() {
      var self = this;

      this.code = "";
      this.loading = true;

      const appVerifier = window.recaptchaVerifier;
      firebase
        .auth()
        .signInWithPhoneNumber(`+62${+this.phone}`, appVerifier)
        .then(function (confirmationResult) {
          $("#otp").modal("show");
          window.confirmationResult = confirmationResult;
        })
        .catch(function (error) {
          self.loading = false;
          self.$notify({
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
      $("#otp").modal("hide");
      confirmationResult
        .confirm(this.code)
        .then(function (result) {
          Axios.post("/api/phone-auth", { phone: `+62${+self.phone}` })
            .then((response) => {
              self.loginByPhone();
            })
            .catch((err) => {
              self.loading = false;
            });
        })
        .catch(function (error) {
          self.loading = false;
          self.$notify({
            group: "all",
            type: "warn",
            title: "Gagal memverifikasi Kode",
            text: "Pastikan anda memasukan kode yang valid",
          });
        });
    },

    async loginByPhone() {
      let user;
      await Axios.post("/api/phone-login", {
        phone: `+62${+this.phone}`,
      })
        .then((res) => {
          this.$store.dispatch("auth/saveToken", {
            token: res.data.token,
          });
          this.$store.dispatch("auth/updateUser", {
            user: res.data.user,
          });
          this.loading = false;

          this.$router.push({ name: "home" });
        })
        .catch((err) => {
          this.loading = false;
          this.$notify({
            group: "all",
            type: "warn",
            title: "Gagal memverifikasi pengguna",
            text: "Terjadi kesalahan saat melakukan verifikasi pengguna",
          });
        });
    },

    async loginByEmail() {
      await this.loginForm
        .post("/api/login")
        .then(({ data }) => {
          $("#email-login").modal("hide");
          this.$store.dispatch("auth/saveToken", {
            token: data.token,
          });
          this.$store.dispatch("auth/updateUser", {
            user: data.user,
          });

          this.$router.push({ name: "home" });
        })
        .catch((err) => {
          this.$notify({
            group: "all",
            type: "warn",
            title: "Gagal memverifikasi pengguna",
            text: "Email atau password salah.",
          });
        });
    },
  },
};
</script>

<style src="../../../css/login.css"></style>
<style scoped src="../../../css/mobile.css">
