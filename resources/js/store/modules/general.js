import * as types from "../mutation-types";

import moment from "moment";

// state
export const state = {
  loading: false,
  nominal: "",
  alias: "",
  virtualAccount: "",
  phone: "",
  expiredPayment: "",
  donationForm: "",
  navHasColor: false,
};

// getters
export const getters = {
  loading: (state) => state.loading,
  nominal: (state) => state.nominal,
  virtualAccount: (state) => state.virtualAccount,
  alias: (state) => state.alias,
  phone: (state) => state.phone,
  donationForm: (state) => state.donationForm,
  expiredPayment: (state) => state.expiredPayment,
  navHasColor: (state) => state.navHasColor,
};

// mutations
export const mutations = {
  [types.TOGGLE_LOADING](state, payload) {
    state.loading = payload;
  },

  [types.UPDATE_NOMINAL](state, payload) {
    state.nominal = payload;
  },

  [types.UPDATE_ALIAS](state, payload) {
    state.alias = payload;
  },

  [types.SET_VA](state, payload) {
    state.virtualAccount = payload;
  },

  [types.SET_DONATION_FORM](state, payload) {
    state.donationForm = payload;
  },

  [types.RESET_DONATION_FORM](state) {
    state.donationForm = "";
    state.nominal = "";
    state.phone = "";
    state.alias = "";
    state.expiredPayment = "";
    state.virtualAccount = "";
  },

  [types.UPDATE_PHONE](state, payload) {
    state.phone = +payload;
  },

  [types.SET_EXPIRED_PAYMENT](state) {
    state.expiredPayment = moment().add(1, "day").format("LLL");
  },

  [types.UPDATE_HAS_NAV_COLOR](state, payload) {
    state.navHasColor = payload;
  },
};

// actions
export const actions = {
  toggleLoading({ commit }, payload) {
    commit(types.TOGGLE_LOADING, payload);
  },

  updateNominal({ commit }, payload) {
    commit(types.UPDATE_NOMINAL, payload);
  },

  updateAlias({ commit }, payload) {
    commit(types.UPDATE_ALIAS, payload);
  },

  setVA({ commit }, payload) {
    commit(types.SET_VA, payload);
  },

  setDonationForm({ commit }, payload) {
    commit(types.SET_DONATION_FORM, payload);
  },

  resetDonationForm({ commit }) {
    commit(types.RESET_DONATION_FORM);
  },

  updatePhone({ commit }, payload) {
    commit(types.UPDATE_PHONE, payload);
  },

  setExpiredPayment({ commit }) {
    commit(types.SET_EXPIRED_PAYMENT);
  },

  updateNavColor({ commit }, payload) {
    commit(types.UPDATE_HAS_NAV_COLOR, payload);
  },
};
