function page(path) {
  return () =>
    import(/* webpackChunkName: '' */ `~/pages/${path}`).then(
      (m) => m.default || m
    );
}

export default [
  {
    path: "/login",
    name: "login",
    component: page("auth/login.vue"),
  },

  { path: "/", name: "home", component: page("home.vue") },

  {
    path: "/dashboard/:page",
    name: "dashboard",
    component: page("dashboard.vue"),
  },

  {
    path: "/mitra",
    name: "mitra",
    component: page("mitra.vue"),
  },

  {
    path: "/mitra/:id",
    name: "detail-mitra",
    component: page("detail-mitra.vue"),
  },

  {
    path: "/campaigns",
    name: "campaigns",
    component: page("campaigns.vue"),
  },

  {
    path: "/campaigns/:slug",
    name: "single-campaign",
    component: page("single-campaign.vue"),
  },

  {
    path: "/story/:slug",
    name: "single-blog",
    component: page("single-blog.vue"),
  },

  {
    path: "*",
    name: "404",
    component: page("errors/404.vue"),
  },
];
