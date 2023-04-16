import VueRouter from "vue-router";

const routes = [
  {
    path: "/",
    component: require("../components/ProductListComponent.vue").default,
  },
  {
    path: "/menu/:menuId",
    component: require("../components/templates/MenuComponent.vue").default,
  },
  {
    path: "/menus",
    component: require("../components/templates/admin/MenuAdminComponent.vue")
      .default,
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

export default router;
