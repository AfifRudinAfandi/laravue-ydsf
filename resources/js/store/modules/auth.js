import axios from "axios";
import Cookies from "js-cookie";
import * as types from "../mutation-types";

import * as general from "./general";

// state
export const state = {
  user: null,
  token: Cookies.get("token"),
  bgImage: null,
  authEmail: false,
  emailLogin: true,
  facebookLogin: false,
  googleLogin: true,
};

// getters
export const getters = {
  authEmail: (state) => state.authEmail,
  user: (state) => state.user,
  token: (state) => state.token,
  check: (state) => state.user !== null,
  bgImage: (state) => state.bgImage,
  emailLogin: (state) => state.emailLogin,
  facebookLogin: (state) => state.facebookLogin,
  googleLogin: (state) => state.googleLogin,
};

// mutations
export const mutations = {
  [types.SAVE_TOKEN](state, { token, remember }) {
    state.token = token;
    Cookies.set("token", token, { expires: remember ? 365 : null });
  },

  [types.FETCH_USER_SUCCESS](state, { user }) {
    state.user = user;
  },

  [types.FETCH_USER_FAILURE](state) {
    state.token = null;
    Cookies.remove("token");
  },

  [types.LOGOUT](state) {
    state.user = null;
    state.token = null;

    Cookies.remove("token");
  },

  [types.UPDATE_USER](state, { user }) {
    state.user = user;
  },

  [types.UPDATE_BG_IMAGE](state, url) {
    state.bgImage = url;
  },

  [types.UPDATE_AUTH_TYPE](state, isAuthEmail) {
    state.authEmail = isAuthEmail;
  },
};

// actions
export const actions = {
  saveToken({ commit }, payload) {
    commit(types.SAVE_TOKEN, payload);
  },

  async fetchUser({ commit }) {
    try {
      const { data } = await axios.get("/api/user");

      commit(types.FETCH_USER_SUCCESS, { user: data });
    } catch (e) {
      commit(types.FETCH_USER_FAILURE);
    }
  },

  updateUser({ commit }, payload) {
    commit(types.UPDATE_USER, payload);
  },

  updateBgImage({ commit }, payload) {
    commit(types.UPDATE_BG_IMAGE, payload);
  },

  updateAuthEmail({ commit }, payload) {
    commit(types.UPDATE_AUTH_TYPE, payload);
  },

  async logout({ commit, dispatch }) {
    try {
      dispatch("general/toggleLoading", true, { root: true });
      await axios
        .post("/api/logout")
        .then(() => dispatch("general/toggleLoading", false, { root: true }));
    } catch (e) {
      dispatch("general/toggleLoading", false, { root: true });
    }

    commit(types.LOGOUT);
  },

  async fetchOauthUrl(ctx, { provider }) {
    const { data } = await axios.post(`/api/oauth/${provider}`);

    return data.url;
  },
};
