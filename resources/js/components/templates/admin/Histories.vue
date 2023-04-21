<template>
  <div>
    <div
      v-for="(history, index) in histories"
      :key="index"
      :class="'list-style-type alert ' + returnClass(history.action)"
    >
      <p>
        <strong>{{ getEntityName(history) }}</strong>
      </p>
      <p><strong>Type d'action :</strong> {{ history.action }}</p>
      <p><strong>Auteur :</strong> {{ history.author.name }}</p>
      <p><strong>Date :</strong> {{ history.created_at }}</p>
      <div v-if="history.entity_type === 'product'">
        <p>
          <strong>Produit :</strong>
          {{ JSON.parse(history.changes).product_name }}
        </p>
      </div>
      <div v-else>
        <p>
          <strong>Menu :</strong>
          {{ JSON.parse(history.changes).menu_name }}
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      histories: [],
      allProducts: [],
      apiUrl: "/api",
      menuList: [],
    };
  },
  async mounted() {
    // Récupérer les entrées de la table histories depuis l'API
    await this.fetchHistories();
    // Récupérer les produits depuis l'API
    await this.fetchProducts();
    // Récupérer les menus depuis l'API
    await this.fetchMenus();
  },
  methods: {
    returnClass(action) {
      switch (action) {
        case "CREATE":
          return "alert-success";
        case "UPDATE":
          return "alert-warning";
        case "DELETE":
          return "alert-danger";
        default:
          return "alert-primary";
      }
    },
    async fetchHistories() {
      const data = JSON.parse(localStorage.getItem("shop_token"));
      await axios
        .get(this.apiUrl + "/histories/", {
          headers: {
            Authorization: "Bearer " + data.token,
          },
        })
        .then(({ data }) => (this.histories = data));
    },
    async fetchMenus() {
      const data = JSON.parse(localStorage.getItem("shop_token"));
      await axios
        .get(this.apiUrl + "/menu/", {
          headers: {
            Authorization: "Bearer " + data.token,
          },
        })
        .then(({ data }) => (this.menuList = data));
    },
    async fetchProducts() {
      const data = JSON.parse(localStorage.getItem("shop_token"));

      await axios
        .get(this.apiUrl + "/product/", {
          headers: {
            Authorization: "Bearer " + data.token,
          },
        })
        .then(({ data }) => (this.allProducts = data.data));
      this.product = {};
    },
    getEntityName(history) {
      if (history.entity_type === "product") {
        return "Changement sur le produit";
      } else if (history.entity_type === "menu") {
        return "Changement sur le menu";
      } else {
        return "Changement sur une entité inconnue";
      }
    },
    getProduct(id) {
      return this.allProducts.find((product) => product.id === id);
    },
    getMenu(id) {
      return this.menuList.find((menu) => menu.id === id);
    },
  },
};
</script>
