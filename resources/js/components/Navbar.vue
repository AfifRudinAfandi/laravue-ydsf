<template>
  <nav
    class="navbar navbar-expand-lg navbar-light fixed-top"
    :class="{ 'nav-color': show || navHasColor }"
  >
    <div class="container-fluid">
      <router-link class="navbar-brand" :to="{ name: 'home' }">
        <img src="/images/logo.png" width="86px" alt />
      </router-link>

      <!-- Mobile menu -->
      <ul
        class="navbar-nav nav-right mobile-lang flex-row d-lg-none d-xl-none ml-md-auto ml-sm-auto"
      >
        <div
          v-if="user"
          class="active-notif d-none d-md-flex"
          data-toggle="modal"
          data-target="#modal-notif"
          @click="$emit('showNotif')"
        >
          <img src="/images/notif.svg" />
          <span v-if="totalUnread > 0" class="badge badge-success">&nbsp;</span>
        </div>

        <!-- <li class="nav-item dropdown">
          <a
            class="btn btn-language dropdown-toggle"
            href="#"
            role="button"
            id="dropdownMenuLink"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <img class="ic-language" src="/images/flag-eg.png" alt />
            <span>EN</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right drop-lang" aria-labelledby="bd-versions">
            <a class="dropdown-item itm-language" href="#">
              <img class="ic-language" src="/images/flag-eg.png" alt />
              <span>EN</span>
            </a>
            <a class="dropdown-item itm-language" href="#">
              <img class="ic-language" src="/images/flag-ind.png" alt />
              <span>ID</span>
            </a>
          </div>
        </li>-->
      </ul>

      <button class="navbar-toggler" type="button" @click="togglerMenu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div v-show="show" class="navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <router-link :to="{ name: 'home' }" class="nav-link">
              Beranda
              <span class="sr-only">(current)</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" :to="{ name: 'campaigns' }">Bidang Garap</router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'mitra' }" class="nav-link">Mitra</router-link>
          </li>
        </ul>
        <ul class="navbar-nav nav-right flex-row ml-md-auto md-nav-right">
          <div
            v-if="user"
            class="active-notif d-none d-md-flex"
            data-toggle="modal"
            data-target="#modal-notif"
            @click="$emit('showNotif')"
          >
            <img src="/images/notif.svg" />
            <span v-if="totalUnread > 0" class="badge badge-success">&nbsp;</span>
          </div>

          <!-- <li class="nav-item dropdown d-none d-md-flex md-btn-lang">
            <a
              class="btn btn-language dropdown-toggle"
              href="#"
              role="button"
              id="dropdownMenuLink"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <img class="ic-language" src="/images/flag-eg.png" />
              <span>English</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right drop-lang" aria-labelledby="bd-versions">
              <a class="dropdown-item itm-language" href="#">
                <img class="ic-language" src="/images/flag-eg.png" />
                <span>English</span>
              </a>
              <a class="dropdown-item itm-language" href="#">
                <img class="ic-language" src="/images/flag-ind.png" />
                <span>Indonesia</span>
              </a>
            </div>
          </li>-->

          <li class="nav-item dropdown" v-if="user" :key="user.id">
            <a
              class="btn btn-profile dropdown-toggle"
              href="#"
              role="button"
              id="dropdownMenuLink"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <img style="width: 32px; border-radius: 50%;" class="mr-2" :src="user.photo_url" />
              <span v-if="user.username">{{user.username}}</span>
            </a>

            <div
              class="dropdown-menu drop-lang profile dropdown-menu-right"
              aria-labelledby="bd-versions"
            >
              <router-link
                :to="{name:'dashboard', params: {page: 'profile'}}"
                class="dropdown-item"
              >
                <span>Dashboard</span>
              </router-link>
              <a class="dropdown-item" href="#" @click.prevent="logout">
                <span>Logout</span>
              </a>
            </div>
          </li>

          <li class="nav-item" v-else>
            <router-link class="btn login-nav" :to="{ name: 'login' }">Login</router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import $ from "jquery";
import Axios from "axios";
import { mapGetters } from "vuex";
import firebase from "firebase";

export default {
  name: "Navbar",

  created() {
    window.addEventListener("scroll", this.handleScroll);
  },

  deactivated() {
    window.removeEventListener("scroll", this.handleScroll);
  },

  data: () => ({
    show: false,
    totalUnread: 0,
  }),

  computed: mapGetters({
    user: "auth/user",
    navHasColor: "general/navHasColor",
  }),

  mounted() {
    this.getTotal();
  },

  methods: {
    async logout() {
      await this.$store
        .dispatch("auth/logout")
        .then(() => this.$router.push({ name: "home" }));
      firebase.auth().signOut();
    },

    handleScroll() {
      if (!this.navHasColor) {
        var scroll = $(window).scrollTop();
        if (scroll > 1) {
          $(".navbar-light").addClass("nav-color");
        } else {
          if (!this.show) {
            $(".navbar-light").removeClass("nav-color");
          }
        }
      }
    },

    togglerMenu() {
      this.show = !this.show;
      this.handleScroll();
    },

    async getTotal() {
      if (this.user) {
        return await Axios.get(`/api/user/${this.user.id}/notif/unread-count`)
          .then(({ data }) => (this.totalUnread = data))
          .catch((err) => console.log(err));
      }
    },
  },
};
</script>

<style src="../../css/navbar.css"></style>
<style scoped src="../../css/mobile.css">
