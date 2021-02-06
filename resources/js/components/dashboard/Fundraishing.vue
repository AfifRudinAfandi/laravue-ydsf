<template>
  <section id="dashboard-fundraishing">
    <div class="fundraishing-wrapper">
      <div class="card">
        <div class="card-header">
         <p class="pull-left mb-0"><i class="fa fa-exclamation-circle mr-1"></i> Warning</p>
         <i class="pull-right p-0 fa fa-times btn"></i>
        </div>
        <div class="card-body">
          <p class="text-desc">Akun yang anda gunakan merupakan akun donasi/donatur. Untuk bergabung menjadi fundraishing pada program YDSF Peduli bersama, segera daftarkan diri anda melalui menu di bawah ini</p>
          <a class="btn btn-fund" href="#">Daftar Fundraishing</a>
        </div>
      </div>
    </div>
    <form class="was-validated">
      <collapse :selected="true" class="d-block">
          <div slot="collapse-header">
            <h5>Registrasi Fundraishing</h5>
            <i class="fa fa-angle-down"></i>
          </div>
          <div slot="collapse-body">
            <div class="form-group">
              <label for="name">Nama Lengkap</label>
              <input type="text" name="name" class="form-control" required placeholder="Nama Lengkap">
            </div>
            <div class="row form-group">
              <div class="col-md-6">
                <label for="no_ktp">No.KTP</label>
                <input type="tel" class="form-control" required minlength="16" placeholder="12 Digit No. KTP">
              </div>
              <div class="col-md-5">
                <label for="no_ktp">Upload KTP</label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="customFile" @change="fileSelected" multiple accept="image/jpg,image/jpeg,/image/png" required>
                  <label class="custom-file-label" for="customFile">
                    <span class="file-info" v-if="!files || !files.length">No files selected</span>
                    <div v-else>
                      <span v-for="file in files" :key="file.name">{{file.name}}</span>
                    </div>
                  </label>
                </div>
              </div>
            </div>
            <div class="custom-control custom-checkbox form-group mb-3">
              <input type="checkbox" class="custom-control-input" id="customControlValidation1" required>
              <label class="custom-control-label" for="customControlValidation1">Dengan mengisi form tersebut saya menerima segala ketentuan yang telah di tetapkan oleh YDSF berkaitan dengan program fundraishing.</label>
              <div class="invalid-feedback"></div>
            </div>
          <button class="btn btn-submit" type="submit">Submit</button>
          </div>
        </collapse>
    </form>
    <ListFund/>
  </section>
</template>

<script>
import Axios from "axios";
import Collapse from 'vue-collapse'
import SkeletonBox from "~/components/SkeletonBox.vue";
import ListFund from "~/components/ListFund.vue";
export default {
  name: "Fundraishing",
  components: {
      Collapse,
      ListFund
  },
  data: () => ({
    loading: true,
    files: null
  }),

  computed: {
    user() {
      return this.$store.getters['auth/user']
    }
  },
  mounted() {
  },
   methods: {
    fileSelected(e) {
      this.files = e.target.files
    }
  }
};
</script>

<style lang="scss" scoped>
.file-info{
  color: #909AAD;
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
.custom-control-label{
  font-family: Lato;
  font-style: normal;
  font-weight: normal;
  font-size: 11px;
  line-height: 13px;
  color: #909AAD;
}
.custom-file{
  overflow: hidden;
}
.btn-submit{
  padding: 6px 18px;
  border-radius: 80px;
  color: #fff;
  background-color: #48b349;
  font-size: 14px;
}
.card-header{
  background-color: #F5FAFF;
  p{
    font-family: Lato;
    font-style: normal;
    font-weight: normal;
    font-size: 16px;
    line-height: 22px;
    color: #2D86BE;
    i{
      font-size: 20px;
    }
  }
  i{
      font-weight: normal;
    }
}
.card-body{
  p{
    font-family: Lato;
    font-style: normal;
    font-weight: normal;
    font-size: 14px;
    line-height: 28px;
    color: #909AAD;
  }
  a{
    padding: 6px 16px;
  border-radius: 80px;
  color: #fff;
  background-color: #48b349;
  font-size: 14px;
  }
}
</style>
