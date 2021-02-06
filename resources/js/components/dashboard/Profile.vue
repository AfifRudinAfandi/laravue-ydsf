<template>
  <section class="profile">
    <form @submit.prevent="updateProfile" @keydown="form.onKeydown($event)">
      <collapse :selected="true" class="d-block">
        <div slot="collapse-header">
          <h5>Profile</h5>
          <i class="fa fa-angle-down"></i>
        </div>
        <div slot="collapse-body">
          <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input
              type="text"
              name="name"
              class="form-control"
              v-model="form.name"
              :class="{ 'is-invalid': form.errors.has('name') }"/>
              <has-error :form="form" field="name"></has-error>
          </div>
          <div class="form-group">
            <label for="city">Kota</label>
            <v-select
              v-model="form.city"
              :options="cities"
              :class="{ 'is-invalid': form.errors.has('city') }"
            />
          </div>
          <div class="form-group">
            <label for="address">Alamat</label>
            <textarea
              name="address"
              class="form-control mt-1"
              v-model="form.address"
              :class="{ 'is-invalid': form.errors.has('address') }"
            ></textarea>
            <has-error :form="form" field="address"></has-error>
          </div>
          <div class="form-group">
            <label for="phone">No. Hp/Telf</label>
            <input
              type="tel"
              name="phone"
              class="form-control"
              v-model="form.phone"
              :class="{ 'is-invalid': form.errors.has('phone') }"
            />
            <has-error :form="form" field="phone"></has-error>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input
              type="email"
              name="email"
              class="form-control"
              v-model="form.email"
              :class="{ 'is-invalid': form.errors.has('email') }"
            />
            <has-error :form="form" field="email"></has-error>
            <span class="text-danger mt-2" v-if="confirmationEmail"
              >Email not verified</span
            >
          </div>
        </div>
      </collapse>
      <collapse :selected="true" class="d-block">
        <div slot="collapse-header">
          <h5>Connected Account</h5>
          <i class="fa fa-angle-down"></i>
        </div>
        <div slot="collapse-body">
          <p>Social Media</p>
          <div class="wp-social-account border-bottom pb-2 mb-3">
              <p class="mb-0 social-account"><i class="fa fa-facebook-square"></i> Facebook</p>
              <button type="button" class="btn btn-outline-success ml-auto rounded-pill pr-4 pl-4">Connected</button>
          </div>
          <div class="wp-social-account border-bottom pb-2 mb-3">
              <p class="mb-0 social-account"><i class="fa fa-instagram"></i> Instagram</p>
              <button type="button" class="btn btn-outline-secondary ml-auto rounded-pill pr-4 pl-4">Not Connected</button>
          </div>
          <div class="wp-social-account border-bottom pb-2 mb-3">
              <p class="mb-0 social-account"><i class="fa fa-google"></i> Google</p>
              <button type="button" class="btn btn-outline-danger ml-auto rounded-pill pr-4 pl-4">Disconnect</button>
          </div>
        </div>
      </collapse>
      <collapse :selected="true" class="d-block">
        <div slot="collapse-header">
          <h5>Password and Security</h5>
          <i class="fa fa-angle-down"></i>
        </div>
        <div slot="collapse-body">
          <button
            type="button"
            class="btn form-control btn-outline-secondary"
            data-toggle="modal"
            data-target="#pass"
          >
            Update Password
          </button>
        </div>
      </collapse>
      <div class="pull-right">
        <button class="btn btn-save" type="submit" :disabled="form.busy">
          <span v-show="!form.busy">Simpan</span>
          <div
            v-show="form.busy"
            class="spinner-border spinner-border-sm"
            role="status"
          >
            <span class="sr-only">Loading...</span>
          </div>
        </button>
      </div>
    </form>

    <div class="modal fade" id="pass" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form
            @submit.prevent="updatePassword"
            @keydown="pwdForm.onKeydown($event)"
          >
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                Update Password
              </h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="password">
                  Password saat ini
                  <br />(Biarkan kosong jika belum membuat password)
                </label>
                <input
                  type="password"
                  v-model="pwdForm.password"
                  class="form-control"
                  :class="{ 'is-invalid': pwdForm.errors.has('password') }"
                />
                <has-error :form="pwdForm" field="password"></has-error>
              </div>
              <div class="form-group">
                <label for="password">Password baru</label>
                <input
                  type="password"
                  v-model="pwdForm.new_password"
                  class="form-control"
                  :class="{ 'is-invalid': pwdForm.errors.has('new_password') }"
                />
                <has-error :form="pwdForm" field="new_password"></has-error>
              </div>
              <div class="form-group">
                <label for="password">Konfirmasi password baru</label>
                <input
                  type="password"
                  class="form-control"
                  v-model="pwdForm.new_password_confirmation"
                  :class="{
                    'is-invalid': pwdForm.errors.has(
                      'new_password_confirmation'
                    ),
                  }"
                />
                <has-error
                  :form="pwdForm"
                  field="new_password_confirmation"
                ></has-error>
              </div>
            </div>
            <div class="modal-footer">
              <button
                class="btn btn-save"
                type="submit"
                :disabled="pwdForm.busy"
              >
                <span v-show="!pwdForm.busy">Simpan</span>
                <div
                  v-show="pwdForm.busy"
                  class="spinner-border spinner-border-sm"
                  role="status"
                >
                  <span class="sr-only">Loading...</span>
                </div>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import Vue from "vue";
import Axios from "axios";
import vSelect from "vue-select";
import { mapGetters } from "vuex";
import { Form, HasError, AlertError } from "vform";
import Collapse from 'vue-collapse'

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component("v-select", vSelect);

export default {
  name: "Profile",

  components: {
      Collapse
  },
  data: () => ({
    confirmationEmail: 0,
    userId: "",
    oldPassword: "",
    cities: [],
    avatar: "",
    form: new Form({
      name: "",
      username: "",
      email: "",
      phone: "",
      address: "",
      city: "",
    }),
    pwdForm: new Form({
      password: "",
      new_password: "",
      new_password_confirmation: "",
    }),
  }),
  
  mounted() {
    const user = Object.assign({}, this.$store.getters["auth/user"]);
    const {
      id,
      name,
      username,
      email,
      city,
      phone,
      address,
      confirmation_email,
    } = user;

    this.userId = id;
    this.confirmationEmail = confirmation_email;
    this.form.name = name;
    this.form.city = city;
    this.form.username = username;
    this.form.email = email;
    this.form.phone = phone;
    this.form.address = address;

    this.getCities();
  },

  methods: {
    async updateProfile() {
      if (this.form.phone.charAt(0) != "+")
        this.form.phone = `+62${+this.form.phone}`;

      await this.form
        .post(`/api/user/${this.userId}/update-profile`)
        .then(({ data }) => {
          this.$store.dispatch("auth/fetchUser");

          this.$notify({
            group: "all",
            type: "success",
            title: "Berhasil menyimpan data",
            text: "Berhasil merubah data profil",
          });
        })
        .catch((err) => {
          this.$notify({
            group: "all",
            type: "error",
            title: "Terjadi kesalaham",
            text: "Gagal merubah data profil",
          });
        });
    },

    async updatePassword() {
      await this.pwdForm
        .post(`/api/user/${this.userId}/update-password`)
        .then(({ data }) => {
          this.$notify({
            group: "all",
            type: "success",
            title: "Berhasil menyimpan data",
            text: "Berhasil merubah password",
          });
          this.$router.go();
        })
        .catch((err) => {
          console.log(err);
          this.$notify({
            group: "all",
            type: "error",
            title: "Terjadi kesalaham",
            text: "Password saat ini salah",
          });
        });
    },

    async getCities() {
      await Axios.get("/id.json").then(({ data }) => {
        this.cities = data.map(({ name }) => name);
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.wp-social-account button{
  font-family: Lato;
  font-style: normal;
  font-weight: bold;
  font-size: 13px;
  line-height: 16px;
}
.social-account{
  font-family: Lato;
  font-style: normal;
  font-weight: bold;
  font-size: 13px;
  line-height: 16px;
  color: #2D386E;
  display: flex;
  flex-direction: row;
  align-items: center;
}
.social-account i{
  font-size: 24px;
  margin-right: 10px;
}
.wp-social-account{
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
}
.modal-footer {
  padding-top: 0;
  border-top: 0;
}
.modal .modal-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
  border: none;
  padding-top: 40px;
}
.modal-header .close {
  position: absolute;
  top: 0;
  right: 0;
  height: 32px;
  width: 32px;
  opacity: 1 !important;
  background-image: url("~/images/ic-close.svg");
}
.modal-header .close:hover {
  opacity: 100%;
}
.modal-header .close:focus {
  outline: none !important;
}
.modal-body{
  padding: 1rem 3rem;
}
.card-title {
  font-size: 24px;
  font-weight: bold;
  color: #024e9b;
  margin: 0px;
}
.collapse {
  border-radius: 8px;
  margin-bottom: 28px;}
.collapse-header {
    border-radius: 8px 8px 0px 0px;
    background-color: #F8F8FB;
    h5 {
      font-family: Lato;
      font-style: normal;
      font-weight: bold;
      font-size: 16px;
      line-height: 19px;
      color: #101428;
      margin-bottom: 0;
    }
  }
  .collapse-content {
    margin: 10px;
    .form-group {
      label {
        font-family: Lato;
        font-style: normal;
        font-weight: normal;
        font-size: 13px;
        line-height: 16px;
        color: #000000;
      }
      input{
        font-family: Lato;
        font-style: normal;
        font-weight: 500;
        font-size: 13px;
        line-height: 16px;
        /* identical to box height */
      }
      input::placeholder{
        color: #909AAD;
      }
    }
  }
.card {
  border-radius: 8px;
  border: 1px solid #e9ebef;
  margin-bottom: 48px;
  .card-header {
    border-radius: 8px 8px 0px 0px;
    background-color: #F8F8FB;
    padding: 10px 28px;
    h5 {
      font-family: Lato;
      font-style: normal;
      font-weight: bold;
      font-size: 16px;
      line-height: 19px;
      color: #101428;
      margin-bottom: 0;
    }
  }
  .card-body {
    margin: 10px;
    .form-group {
      margin-bottom: 24px;
      label {
        font-family: Lato;
        font-style: normal;
        font-weight: normal;
        font-size: 13px;
        line-height: 16px;
        color: #000000;
      }
      input{
        font-family: Lato;
        font-style: normal;
        font-weight: 500;
        font-size: 13px;
        line-height: 16px;
        /* identical to box height */
      }
      input::placeholder{
        color: #909AAD;
      }
    }
  }
}
.btn-save {
  padding: 12px 68px;
  border-radius: 80px;
  color: #fff;
  background-color: #48b349;
  font-size: 16px;
}
</style>
