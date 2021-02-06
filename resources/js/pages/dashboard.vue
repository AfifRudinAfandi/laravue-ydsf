<template>
  <section id="profile-container">
    <ul class="nav">
      <li class="nav-item col-lg-2 col-md-4 col-6 col-sm-4 pr-2 pl-2 text-center border-sm-0" :class="{ active: activeClass('profile') }">
        <router-link :to="{ name: 'dashboard', params: { page: 'profile' } }">
          <i class="fa fa-user-circle"></i>Profil
        </router-link>
      </li>
      <li class="nav-item col-lg-2 col-md-4 col-6 col-sm-4 pr-2 pl-2 text-center" :class="{ active: activeClass('donation') }">
        <router-link :to="{ name: 'dashboard', params: { page: 'donation' } }">
          <i class="fa fa-inbox"></i>Report Donasi
        </router-link>
      </li>
      <li class="nav-item col-lg-2 col-md-4 col-6 col-sm-4 pr-2 pl-2 text-center" :class="{ active: activeClass('reward') }">
        <router-link :to="{ name: 'dashboard', params: { page: 'reward' } }">
          <i class="fa fa-book"></i>Majalah &amp; Ebook
        </router-link>
      </li>
      <li class="nav-item col-lg-2 col-md-4 col-6 col-sm-4 pr-2 pl-2 text-center" :class="{ active: activeClass('fundraish') }">
        <router-link :to="{ name: 'dashboard', params: { page: 'fundraish' } }">
          <i class="fa fa-heart"></i>Fundraishing
        </router-link>
      </li>
    </ul>
    <div class="container content mt-0 mt-md-5">
      <div class="row">
        <div class="col-md-4 col-profile mb-5 mb-md-0">
          <div class="img-wrapper">
            <img :src="user.photo_url" class="pic" />
            <div class="update-pic">
              <a
                href="#"
                v-if="!loading.avatar"
                class="link"
                @click.prevent="$refs.fileavatar.click()"
                ><i class="fa fa-edit"></i> Change Profile Pic</a
              >
              <div v-else class="spinner-grow spinner-grow-sm" role="status">
                <span class="sr-only">Loading...</span>
              </div>
              <input
                type="file"
                ref="fileavatar"
                style="display: none;"
                @change="updateAvatar($event)"
              />
            </div>
          </div>
          <h4 class="name">{{ user.name }}</h4>
          <template v-if="user.email">
            <p class="user-id">{{ user.email }}</p>
          </template>
          <template v-else-if="user.phone">
            <p class="user-id">{{ user.phone }}</p>
          </template>
          <button class="logout-btn btn" @click="logout">
            <i class="fa fa-sign-out"></i>Log Out
          </button>
        </div>
        <div class="col-md-8">
          <template v-if="page == 'profile'">
            <Profile />
          </template>
          <template v-else-if="page == 'donation'">
            <Donation />
          </template>
          <template v-else-if="page == 'reward'">
            <Reward />
          </template>
          <template v-else-if="page == 'fundraish'">
            <Fundraishing />
          </template>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import Axios from "axios";
import firebase from "firebase";

import { mapGetters } from "vuex";

import Profile from "~/components/dashboard/Profile.vue";
import Donation from "~/components/dashboard/Donations.vue";
import Reward from "~/components/dashboard/Rewards.vue";
import Fundraishing from "~/components/dashboard/Fundraishing.vue"

export default {
  name: "Dashboard",

  metaInfo() {
    return { title: "Profil" };
  },

  components: {
    Profile,
    Donation,
    Reward,
    Fundraishing,
  },

  data: () => ({
    donations: [],
    rewards: [],
    loading: {
      user: true,
      donations: true,
      rewards: true,
      avatar: false,
    },
  }),

  computed: {
    page() {
      return this.$route.params.page;
    },
    ...mapGetters({
      user: "auth/user",
    }),
  },

  methods: {
    activeClass($page) {
      return this.$route.params.page == $page ? true : false;
    },

    async logout() {
      await this.$store
        .dispatch("auth/logout")
        .then(() => this.$router.push({ name: "home" }));
      firebase.auth().signOut();
    },

    async updateAvatar(event) {
      this.loading.avatar = true;
      let file = event.target.files[0];
      let formData = new FormData();
      formData.append("avatar", file);
      await Axios.post(`/api/user/${this.user.id}/update-avatar`, formData, {
        headers: { "Content-Type": "multipart/form-data" },
      })
        .then(({ data }) => {
          console.log(data);
          this.$store.dispatch("auth/fetchUser");
        })
        .catch((err) => console.log(err))
        .finally(() => (this.loading.avatar = false));
    },
  },
};
</script>

<style lang="scss" scoped>
#profile-container {
  position: relative;
  margin-top: 60px;
  margin-bottom: 60px;
  .nav {
    position: sticky;
    top: 60px;
    background-color: #f5f5f5;
    justify-content: center;
    padding: 18px 0px;
    z-index: 999;
    .nav-item {
      color: #909aad;
      font-size: 16px;
      padding: 7px 60px;
      &.active a {
        color: #0c55a4;
        i {
          color: #48b349;
        }
      }
      &:nth-child(2) {
        border-left: 0.8px solid #c7ccd6;
        border-right: 0.8px solid #c7ccd6;
      }&:nth-child(3) {
        border-left: 0.8px solid #c7ccd6;
        border-right: 0.8px solid #c7ccd6;
      }
      a {
        text-decoration: none;
        color: #909aad;
        &:hover {
          color: #0c55a4;
          i {
            color: #48b349;
          }
        }
        i {
          margin-right: 12px;
        }
      }
    }
  }
  .col-profile {
    text-align: center;
    .pic {
      width: 13rem;
      height: 13rem;
      object-fit: cover;
      object-position: center;
      border-radius: 5px;
    }
    .update-pic {
      margin-top: 10px;
      a {
        text-decoration: none;
        color: #024e9b;
      }
    }
    .name {
      margin-top: 27px;
      color: #024e9b;
      font-size: 20px;
      font-weight: 600;
    }
    .user-id {
      color: #909aad;
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 0px;
    }
    .logout-btn {
      margin-top: 58px;
      border: 1px solid #ff6060;
      padding: 12px 68px;
      border-radius: 80px;
      color: #ff6060;
      font-size: 16px;
      &:hover {
        background-color: #ff6060;
        color: #fff;
      }
      i {
        margin-right: 15px;
      }
    }
  }
  .content {
    margin-top: 64px;
  }
}
</style>
