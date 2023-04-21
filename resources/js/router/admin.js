import VueRouter from "vue-router";

const routes = [
  {
    path: "/",
    component: require("../components/ProductListComponent.vue").default,
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: "/menu/:menuId",
    component: require("../components/templates/MenuComponent.vue").default,
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: "/menus",
    component: require("../components/templates/admin/MenuAdminComponent.vue")
      .default,
    meta: {
      requiresAuth: true,
    },
  },
  ,
  {
    path: "/histories",
    component: require("../components/templates/admin/Histories.vue").default,
    meta: {
      requiresAuth: true,
    },
  },

  {
    path: "/login",
    name: "login",
    component: require("../components/pages/Login.vue").default,
  },

  //   { path: "/foo", component: Foo },
  //   { path: "/bar", component: Bar },
];

// 3. Créez l'instance du routeur et passez l'option `routes`.
// Vous pouvez également passer des options supplémentaires,
// mais nous allons faire simple pour l'instant.
const router = new VueRouter({
  routes, // raccourci pour `routes: routes`
});

router.beforeEach((to, from, next) => {
  // const authStore = useAuthStore();
  // const src = "/public/js/active.js";
  // var s = document.createElement("script");
  // s.setAttribute("src", src);
  // document.body.appendChild(s);
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (!localStorage.getItem("shop_token")) {
      next({ name: "login" });
      return;
    } else {
      next();
      return;
    }
  } else {
    next();
  }
});

export default router;
