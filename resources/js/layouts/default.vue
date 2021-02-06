<template>
  <div class="main-layout flex justify-center">
    <div class="px-6 w-full md:px-0 md:w-4/6">
      <navbar @showNotif="getDonations" />

      <div class="modal fade" id="modal-notif" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content modal-notif">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Notifikasi</h5>
              <button type="button" class="close" aria-label="Close" data-dismiss="modal">
                <span aria-hidden="true"></span>
              </button>
            </div>
            <div class="modal-body">
              <div v-if="loadingNotif" class="loading">
                <span>Loading..</span>
              </div>
              <template v-else>
                <template v-if="notifications.length > 0">
                  <div
                    v-for="item in notifications"
                    :key="item.id"
                    class="item"
                    :class="{ unread: item.is_read == 0 }"
                  >
                    <h4 class="title">{{ item.title }}</h4>
                    <p class="body" v-html="item.body"></p>
                    <p class="type">
                      Kode Status:
                      <strong>{{ item.type }}</strong>
                    </p>
                  </div>
                </template>
                <div v-else class="no-data">
                  <span>Tidak ada notifikasi</span>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>

      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import Navbar from "~/components/Navbar";
import Axios from "axios";

export default {
  name: "MainLayout",

  data: () => ({
    notifications: [],
    loadingNotif: true,
  }),

  computed: {
    loading() {
      return this.$store.getters["general/loading"];
    },
    user() {
      return this.$store.getters["auth/user"];
    },
  },

  components: {
    Navbar,
  },

  methods: {
    async getDonations() {
      this.loadingNotif = true;
      await Axios.get(`/api/user/${this.user.id}/notif`)
        .then(({ data }) => {
          this.notifications = data;
        })
        .catch((err) => {})
        .finally(() => (this.loadingNotif = false));
    },
  },
};
</script>

<style lang="scss" scoped>
.modal-body {
  overflow: hidden;
  max-height: 500px;
  overflow-y: auto;
}
.container-spinner {
  display: flex;
  width: 100%;
  height: 100vh;
  overflow: hidden;
  position: fixed;
  z-index: 90;
  background: #fff;
  align-items: center;
  justify-content: center;
  top: 0;
  z-index: 999999;
}

#modal-notif {
  border: none;
  border-radius: 12px;
  outline: 0;
  min-height: 350px;
  .modal-header {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    border: none;
    padding-top: 40px;
    border-bottom: solid 1px #e0e0e0;
    .modal-title {
      font-style: normal;
      font-weight: bold;
      font-size: 24px;
      line-height: 29px;
      text-align: center;
      color: #2d386e;
    }
    .close {
      position: absolute;
      top: 0;
      right: 0;
      height: 32px;
      width: 32px;
      opacity: 1 !important;
      background-image: url("~/images/ic-close.svg");
      &:hover {
        opacity: 100%;
      }
      &:focus {
        outline: none !important;
      }
    }
  }
  .modal-body {
    padding: 0px;
    .no-data,
    .loading {
      min-height: 300px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .item {
      padding: 10px 20px;
      border-bottom: solid 1px #e0e0e0;
      &.unread {
        background: #eeee;
      }
      .title {
        color: #2d386e;
        font-size: 16px;
        font-weight: 600;
      }
      .body {
        font-size: 14px;
        margin-bottom: 0px;
      }
      .type {
        color: #909aad;
        margin-top: 5px;
        margin-bottom: 0px;
        font-size: 13px;
      }
    }
  }
}
</style>

<style scoped src="../../css/mobile.css">