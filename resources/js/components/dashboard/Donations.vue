<template>
  <section id="dashboard-donations">
    <h4 class="heading-histori">History <span>Donasi</span></h4>
    <div class="alert alert-info mb-4" role="alert">
      <i class="fa fa-exclamation-circle"></i><span>Catatan:<br>Semua donasi yang telah anda berikan tercatat dan ter arsip. Temukan kembali donasi anda untuk melakukan kembali donasi.</span>
    </div>
    <div v-if="!loading" class="sorting-wrapper">
      <div class="date">
        <label>Pilih Tanggal:</label>
        <date-picker
          ref="datepicker"
          class="select-control"
          @selected="setDate"
          i18n="ID"
          :captions="{ title: 'Pilih Tanggal', ok_button: 'Pilih' }"
        />
      </div>
      <div class="status">
        <label for="status">Pilih Status Donasi:</label>
        <select name="status" v-model="sortStatus" class="select-control sort">
          <option value>Semua Status</option>
          <option value="1">Sudah Diverifikasi</option>
          <option value="0">Belum Diverifikasi</option>
        </select>
      </div>
      <div class="reset">
        <button
          type="button"
          class="btn btn-reset"
          @click="resetSort"
          :disabled="sortDate == '' && sortStatus == ''"
        >Reset</button>
      </div>
    </div>
    <div class="donations-wrapper">
      <template v-if="loading">
        <div v-for="n in 2" :key="n" class="card item">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <skeleton-box height="10em" width="12em" />
              </div>
              <div class="col-md-8">
                <skeleton-box width="8em" />
                <skeleton-box />
                <skeleton-box />
                <div class="mt-4">
                  <skeleton-box width="10em" height="1.4em" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>
      <template v-else>
        <template v-if="items.length > 0">
          <div v-for="item in items" :key="item.id" class="card item">
            <div class="info" :class="{ verified: item.is_verified > 0 }">
              <p class="pull-left">
                Tanggal Donasi:
                <strong>{{ item.created_at | formatDate }}</strong>
              </p>
              <p class="pull-right">
                No. VA:
                <strong>{{ item.va }}</strong>
              </p>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4 image">
                  <img v-lazy="item.image" />
                </div>
                <div class="col-md-8 donation-content">
                  <div class="title">
                    <p>Program Donasi:</p>
                    <router-link
                      :to="{
                        name: 'single-campaign',
                        params: { slug: item.slug },
                      }"
                    >{{ item.title }}</router-link>
                  </div>
                  <div class="nominal">
                    <p>Nominal Donasi:</p>
                    <h4 class="number">{{ item.nominal | currency }}</h4>
                    <div class="wp-btn">
                      <p class="status mr-3" :class="item.is_verified > 0 ? 'verified' : 'unverified'">
                        {{
                        item.is_verified > 0 ? "Sudah Dibayar" : "Belum Dibayar"
                        }}
                      </p>
                      <p class="btn btn-outline-info cetak">
                        Cetak Kwitansi
                      </p>
                    </div>
                  </div>
                  <h4></h4>
                </div>
              </div>
            </div>
          </div>
        </template>
        <template v-else>
          <p>Belum ada donasi nih.</p>
        </template>
      </template>
    </div>
  </section>
</template>

<script>
import Axios from "axios";
import moment from "moment";

import DatePicker from "vue-rangedate-picker";
import SkeletonBox from "~/components/SkeletonBox.vue";

export default {
  name: "Donation",
  data: () => ({
    donations: [],
    sortDate: "",
    sortStatus: "",
    loading: true,
  }),
  components: { SkeletonBox, DatePicker },
  computed: {
    user() {
      return this.$store.getters["auth/user"];
    },
    items() {
      return this.sort();
    },
  },
  mounted() {
    this.fetchDonations();
  },
  methods: {
    async fetchDonations() {
      return await Axios.get(`/api/donations/user/${this.user.id}/report`)
        .then(({data}) => {
          this.donations = data.map((item) => {
            return {
              id: item.id,
              title: item.campaign.title,
              slug: item.campaign.slug,
              image: `/storage/admin/${item.campaign.cover_image_url}`,
              nominal: item.nominal,
              message: item.message,
              username: item.user.name,
              alias: item.alias,
              va: item.va,
              created_at: item.created_at,
              is_verified: item.is_verified,
            };
          });
        })
        .catch(() => {})
        .finally(() => (this.loading = false));
    },

    target(id) {
      return `#${id}`;
    },

    setDate({ start, end }) {
      this.sortDate = { start, end };
      this.sort();
    },

    resetSort() {
      this.sortDate = "";
      this.sortStatus = "";
      this.$refs.datepicker.$data.dateRange = {};
      this.sort();
    },

    sort() {
      let items = [];

      if (this.sortDate == "" && this.sortStatus == "") {
        items = this.donations;
      } else {
        items = this.donations.filter((donation) => {
          if (this.sortDate != "" && this.sortStatus != "") {
            const { start, end } = this.sortDate;
            const checkStatus = this.checkStatus(
              +donation.is_verified,
              +this.sortStatus
            );
            const checkDate = this.checkDateInRange(
              donation.created_at,
              start,
              end
            );
            return checkStatus && checkDate;
          } else if (this.sortDate != "" && this.sortStatus == "") {
            const { start, end } = this.sortDate;
            return this.checkDateInRange(donation.created_at, start, end);
          } else if (this.sortDate == "" && this.sortStatus != "") {
            return this.checkStatus(+donation.is_verified, +this.sortStatus);
          } else {
            return donation;
          }
        });
      }

      return items;
    },

    checkDateInRange(date, start, end) {
      const fDate = new Date(date);
      const fStart = new Date(start);
      const fEnd = new Date(end);

      console.log(`${fDate} = ${fStart}`);

      if (moment(fDate).isSame(fStart, 'day') || moment(fDate).isSame(fEnd, 'day'))
        return true;

      return moment(fDate).isBetween(fStart, fEnd);
    },

    checkStatus(val1, val2) {
      return val1 === val2;
    },
  },
};
</script>

<style lang="scss" scoped>
.cetak{
  display: inline-block;
  padding: 6px 14px;
  font-weight: bold;
  border-radius: 100px;
  font-size: 14px;
}
.wp-btn{
  display: flex;
  flex-direction: row;
  align-items: center;
}
.heading-histori{
  font-family: Lato;
  font-style: normal;
  font-weight: normal;
  font-size: 32px;
  line-height: 38px;
  color: #2D386E;
  margin-bottom: 20px;
  span{
    color:#48B349;
    font-weight: bold;
  }
}
.alert-info{
  font-family: Lato;
  font-style: normal;
  font-weight: normal;
  font-size: 14px;
  line-height: 22px;
  background-color: #F5FAFF;
  color: #2D86BE;
  display: flex;
  flex-direction: row;
}
.alert-info i{
  margin-right: .8rem;
  font-size: 22px;
}
#dashboard-donations {
  .sorting-wrapper {
    margin-bottom: 28px;
    display: flex;
    flex-wrap: wrap;
    label {
      display: block;
      color: #909aad;
    }
    .select-control {
      font-size: 1rem;
      font-weight: 400;
      color: #495057;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid #ced4da;
      border-radius: 0.25rem;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
      overflow: hidden;
      margin-right: 10px;
      &.sort {
        padding: 7px 2px;
        border: 1.5px solid #ced4da;
        &:focus {
          outline: none;
        }
      }
    }
    .btn-reset {
      padding: 4px 30px;
      margin-top: 32px;
      border-radius: 80px;
      color: #fff;
      background-color: #48b349;
      font-size: 16px;
    }
  }

  .item {
    border-radius: 8px;
    border: 1px solid #e9ebef;
    margin-bottom: 28px;
    overflow: hidden;
    .info {
      font-size: 14px;
      padding: 10px 20px;
      font-weight: bold;
      background-color: #cecfd4;
      color: #ffffff;
      &.verified {
        background-color: #48B349;
      }
    }
    .image img {
      width: 100%;
      height: 10em;
      object-fit: cover;
      object-position: center;
      border-radius: 8px;
    }
    .donation-content {
      font-weight: 600;
      .title {
        a {
          text-decoration: none;
          color: #024e9b;
          font-size: 20px;
        }
      }
      .nominal {
        margin-top: 16px;
        .number {
          font-weight: bold;
          font-size: 20px;
          color: #48b349;
        }
        .status {
          display: inline-block;
          padding: 6px 14px;
          font-weight: bold;
          border-radius: 100px;
          font-size: 14px;
          color: #fff;
          &.verified {
            background-color: #48b349;
          }
          &.unverified {
            background-color: #ff6060;
          }
        }
      }
    }
  }
  p {
    margin-bottom: 0px;
  }
}
</style>
