<template>
  <div class="modal fade" id="pass" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form @submit.prevent="updatePassword" @keydown="pwdForm.onKeydown($event)">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="password">Password saat ini</label>
              <input
                type="password"
                v-model="pwdForm.password"
                class="form-control"
                :class="{ 'is-invalid': form.errors.has('password') }"
              />
              <has-error :form="form" field="password"></has-error>
            </div>
            <div class="form-group">
              <label for="password">Password baru</label>
              <input
                type="password"
                v-model="pwdForm.new_password"
                class="form-control"
                :class="{ 'is-invalid': form.errors.has('new_password') }"
              />
              <has-error :form="form" field="new_password"></has-error>
            </div>
            <div class="form-group">
              <label for="password">Konfirmasi password baru</label>
              <input
                type="password"
                class="form-control"
                v-model="pwdForm.new_password_confirmation"
                :class="{ 'is-invalid': form.errors.has('new_password_confirmation') }"
              />
              <has-error :form="form" field="new_password_confirmation"></has-error>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-save" type="submit" :disabled="pwdLoading">
              <span v-show="!pwdLoading">Simpan</span>
              <div v-show="pwdLoading" class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import Axios from "axios";
import { mapGetters } from "vuex";
import { Form, HasError, AlertError } from "vform";

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

export default {
  name: "UpdatePasswordForm",
  data: () => ({
    form: new Form({
      password: "",
      new_password: "",
      new_password_confirmation: "",
    }),
  }),
  methods: {
    async updatePassword() {
      this.pwdLoading = true;
      await this.form
        .post(`/api/user/${this.userId}/update-password`)
        .then(({ data }) => {
          this.$store.dispatch("auth/fetchUser");
          this.$notify({
            group: "all",
            type: "success",
            title: "Berhasil menyimpan data",
            text: "Berhasil merubah password",
          });
        })
        .catch((err) => {
          this.$notify({
            group: "all",
            type: "error",
            title: "Terjadi kesalaham",
            text: "Gagal merubah password",
          });
        })
        .finally(() => (this.pwdLoading = false));
    },
  },
};
</script>

<style>
</style>