<template>
<section id="dashboard-donations">
    <h4 class="heading-histori">History <span>Donasi</span></h4>
    <div class="wrapper-kategori mb-4">
      <div class="form-row">
        <div class="col-auto my-1">
          <label for="#kategori" class="label-kategori">Category</label>
        </div>
        <div class="col-auto my-1">
          <select id="kategori" class="custom-select">
            <option selected="selected" value="0">Semua</option>
            <option value="4">Bantuan Anak Yatim</option>
            <option value="3">Sedekah</option>
            <option value="2">Bantuan Sosial</option>
            <option value="1">Bantuan Kemanusiaan</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="col-auto my-1">
          <label for="#lokasi" class="label-kategori">Location</label>
        </div>
        <div class="col-auto my-1">
          <select id="lokasi" class="custom-select">
            <option selected="selected" value="">Semua</option>
            <option value="INDONESIA">INDONESIA</option>
            <option value="Purworejo">Purworejo</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="col-auto my-1">
          <label for="#sort" class="label-kategori">Sort</label>
        </div>
        <div class="col-auto my-1">
          <select id="sort" class="custom-select">
            <option selected="selected" value="LATEST">Terbaru</option>
            <option value="OLDEST">Terlama</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="col-auto my-1">
          <button type="button" class="btn btn-success btn-category">Reset</button>
        </div>
      </div>
    </div>
    <div class="donations-wrapper">
      <div class="fundraishing-wrapper">
        <div class="card">
          <div class="card-header">
          <p class="pull-left mb-0"><i class="fa fa-exclamation-circle mr-1"></i> Warning</p>
          <i class="pull-right p-0 fa fa-times btn"></i>
          </div>
          <div class="card-body">
            <p class="text-desc">Anda belum memiliki program fundraisher !
Temukan program donasi yang sesuai dengan keinginan anda, share dan atur target donasi sekarang</p>
            <a class="btn btn-fund" href="#">Cari Program Donasi</a>
          </div>
        </div>
      </div>
    </div>

    <div class="item mb-3">
      <div class="card-body">
        <div class="row">
          <div class="col-md-4 cl-auto">
            <div class="wrapper-image-btn">
              <img class="card-img-list" src="/images/Images-Banner-new.png">
              <div class="overlay-button row">
                <a href="#" class="btn btn-donasi mr-1">Donasi</a>
                <button class="btn btn-setting">Setting</button>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <h5 class="card-category">Bantuan Anak Yatim</h5>
            <h3 class="title-project">Bantuan Gawai Untuk Siswa Yatim Dan Dhuafa</h3>
            <p class="cabang"><i class="fa fa-map-marker"></i>INDONESIA</p>
            <div class="wrapper-value">
              <p class="percent">1%</p>
              <p class="value-idr">Rp. 200.000.000</p>
            </div>
            <div class="progress">
              <div role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" class="progress-bar" style="width: 1%;"></div>
            </div>
            <div class="wrapper-time">
              <p class="time-left"><i class="fa fa-hourglass-half"></i> 28 hari</p>
              <p class="status-project">Collected</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import Axios from 'axios'

export default {
	name: 'List',

	data: () => ({
    locations: [],
    selectedLocations: '',
    sort: 'LATEST',
		loading: true,
	}),

  components: {
  },

	computed: {
	},

	mounted() {
	},

	methods: {
		},
}
</script>

<style lang="scss" scoped>
.btn-donasi{
  border: none;
  background: #48b349;
  border-radius: 80px;
  font-style: normal;
  font-weight: bold;
  font-size: 12px;
  line-height: 18px;
  color: #ffffff;
  padding: 4px 10px;
}
.btn-setting{
  border: none;
  background: #ffffff;
  border-radius: 80px;
  font-style: normal;
  font-weight: bold;
  font-size: 12px;
  line-height: 18px;
  color: #2d386e;
  padding: 4px 12px;
}
.heading-histori{
  font-family: Lato;
  font-style: normal;
  font-weight: normal;
  font-size: 28px;
  line-height: 32px;
  color: #2D386E;
  margin-bottom: 20px;
  span{
    color:#48B349;
    font-weight: bold;
  }
}

.wrapper-kategori {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  width: 100%;
  justify-content: flex-start;
  align-items: center;
}
.wrapper-kategori .form-row {
  align-items: center;
  margin-left: 0;
  margin-right: 10px;
}
.wrapper-kategori .form-row:nth-last-child(1) {
  margin-right: 0;
}
.form-row .col-auto .custom-select {
  font-weight: normal;
  font-size: 14px;
  line-height: 20px;
}
.form-row .col-auto .custom-select option {
  font-weight: normal;
  font-size: 14px;
  line-height: 20px;
}

.label-kategori {
  margin-bottom: 0;
  font-weight: normal;
  font-size: 16px;
  line-height: 20px;
  color: #2d386e;
}
.btn-category {
  border-color: #48b349;
  background: #48b349;
  box-shadow: 0px 4px 24px rgba(72, 179, 74, 0.158);
  border-radius: 80px;
  font-style: normal;
  font-weight: bold;
  font-size: 14px;
  line-height: 20px;
  color: #ffffff;
  padding: 6px 16px;
}
.btn-category i {
  margin-left: 8px;
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
.overlay-button{
    position: absolute;
    bottom: 10%;
    left: 40%;
    transform: translate(-23%, -10%);
    margin-bottom: 0;
    opacity: 0;
    transition: all 0.2s ease-in-out;
}
.cl-auto{
  display: flex;
  align-items: center;
}
.wrapper-image-btn{
  display: flex;
  position: relative;
  overflow: hidden;
  height: 10em;
  border-radius: 8px;
  width: 100%;
}
.wrapper-image-btn:hover{
  background: linear-gradient(180deg, rgba(45, 56, 110, 0) 33.19%, #2D386E 105.84%);
}
.wrapper-image-btn:hover .overlay-button{
  opacity: 1;
}
.card-img-list{
    width: 100%;
    height: 10em;
    object-fit: cover;
    object-position: center;
    border-radius: 8px;
    z-index: -1;
}
.card-category {
  font-style: normal;
  font-weight: normal;
  font-size: 14px;
  line-height: 16px;
  color: #909aad;
  margin-bottom: 10px;
}
.title-project {
  font-style: normal;
  font-weight: bold;
  font-size: 16px;
  line-height: 22px;
  color: #2d386e;
  margin-bottom: 8px;
}
.cabang {
  font-style: normal;
  font-weight: normal;
  font-size: 12px !important;
  line-height: 15px;
  color: #909aad;
  margin-bottom: 14px;
  text-transform: uppercase;
}
.cabang i {
  color: #fcbd60;
  margin-right: 10px;
  font-size: 14px;
}
.wrapper-value {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}
.wrapper-value p {
  font-style: normal;
  font-weight: bold;
  font-size: 14px;
  line-height: 17px;
  color: #2d386e;
  margin-bottom: 10px;
}
.progress {
  border-radius: 12px;
  margin-bottom: 16px;
}
.progress .progress-bar {
  background-color: #48b349;
}
.wrapper-time {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}
.wrapper-time p {
  font-style: normal;
  font-weight: normal;
  font-size: 12px;
  line-height: 17px;
  color: #909aad;
  margin-bottom: 0;
}

</style>