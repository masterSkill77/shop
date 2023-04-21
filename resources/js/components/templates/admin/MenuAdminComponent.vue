<template>
  <div>
    <input
      type="text"
      v-model="queryText"
      @input="querymenu"
      class="w-100 form-control mb-2"
      placeholder="Rechercher un menu"
    />
    <button
      class="btn btn-sm btn-success mb-2"
      data-toggle="modal"
      data-target="#createmenuModal"
      v-if="isAdmin"
    >
      Créer un menu
    </button>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>ID menu</th>
          <th>Nom</th>
          <th>Ingrédients</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr :key="menu.id" v-for="menu in menuList">
          <td>{{ menu.id }}</td>
          <td>{{ menu.menu_name }}</td>
          <td>
            <ul>
              <li :key="product.id" v-for="product in menu.products">
                {{ product.product_name }} |
                <span class="badge badge-primary"
                  >{{ product.pivot.quantity }} {{ product.pivot.unite }}</span
                >
              </li>
            </ul>
          </td>
          <td>
            <button
              class="btn btn-sm btn-warning"
              data-toggle="modal"
              @click="showFormUpdatemenu(menu)"
              type="button"
              data-target="#updateModal"
            >
              Modifier
            </button>
            <button
              v-if="isAdmin"
              class="btn btn-sm btn-danger"
              @click="deletemenu(menu)"
            >
              Supprimer
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <div>Il y a {{ menuList.length }} menu(s)</div>
    <div
      class="modal fade"
      id="updateModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="updateModalTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="updateModalTitle">Modifier</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="menu-name">Nom du menu</label>
              <input
                type="text"
                v-model="menu.menu_name"
                class="form-control"
                id="menu-name"
                aria-describedby=""
                placeholder="menu"
              />
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Fermer
            </button>
            <button
              type="button"
              class="btn btn-primary"
              data-dismiss="modal"
              @click="saveModification"
            >
              Sauvegarder
            </button>
          </div>
        </div>
      </div>
    </div>
    <div
      class="modal fade"
      id="createmenuModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="createModalTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createModalTitle">
              Créer un nouveau menu
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="menu-name">Nom du menu</label>
              <input
                type="text"
                v-model="newMenu.menu_name"
                class="form-control"
                id="menu-name"
                aria-describedby=""
                placeholder="menu"
              />
            </div>
            <div v-for="(product, index) in products" :key="product.id">
              <div class="form-group">
                <label :for="'product' + product.id"
                  >Produit {{ index + 1 }}</label
                >
                <select
                  class="form-control"
                  :id="'product' + product.id"
                  :name="'product[' + product.id + ']'"
                  v-model="product.selectedProductId"
                >
                  <option disabled value="">Choisissez un produit</option>
                  <option v-for="p in allProducts" :key="p.id" :value="p.id">
                    {{ p.product_name }}
                  </option>
                </select>
                Quantité :
                <input
                  type="number"
                  class="form-control"
                  :id="'quantity' + product.id"
                  :name="'quantity[' + product.id + ']'"
                  min="0"
                  v-model="product.quantity"
                  :disabled="!product.selectedProductId"
                />
                Unité :
                <input
                  type="text"
                  class="form-control"
                  :id="'quantity' + product.id"
                  :name="'quantity[' + product.id + ']'"
                  min="0"
                  v-model="product.unite"
                  :disabled="!product.selectedProductId"
                />
              </div>
            </div>
            <button type="button" class="btn btn-primary" @click="addProduct">
              Ajouter un produit
            </button>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Fermer
            </button>
            <button
              type="button"
              class="btn btn-primary"
              data-dismiss="modal"
              @click="createmenu"
            >
              Sauvegarder
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      menu: {},
      newMenu: {},
      id_category: "",
      apiUrl: "/api/",
      menuList: [],
      categoriesList: [],
      queryText: "",
      isAdmin: false,
      nextId: 1,
      products: [],
      allProducts: [],
    };
  },
  methods: {
    addProduct() {
      this.products.push({ id: this.nextId, quantity: 0 });
      this.nextId++;
    },
    filterByCategory(id_category) {
      this.fetchData().then((data) => {
        let menuListFiltered = this.menuList.filter((menu) => {
          if (menu.id_category == id_category) return menu;
        });
        this.menuList = menuListFiltered;
      });
    },
    querymenu() {
      if (this.queryText == "") {
        this.fetchData();
      } else {
        this.fetchData().then((data) => {
          this.menuList = this.menuList.filter((menu) => {
            if (menu.menu_name.indexOf(this.queryText) != -1) return menu;
          });
        });
      }
    },
    async createmenu() {
      const data = JSON.parse(localStorage.getItem("shop_token"));
      this.newMenu.recettes = this.products;
      await axios
        .post(this.apiUrl + "menu", this.newMenu, {
          headers: {
            Authorization: "Bearer " + data.token,
          },
        })
        .then(({ data }) => this.fetchData());
    },
    showFormUpdatemenu(menu) {
      this.menu = menu;
    },
    saveModification() {
      const data = JSON.parse(localStorage.getItem("shop_token"));
      axios
        .patch(this.apiUrl + "menu/" + this.menu.id, this.menu, {
          headers: {
            Authorization: "Bearer " + data.token,
          },
        })
        .then((data) => {
          if (data) {
            alert("menu modifié avec succès");
            this.fetchData();
          }
        });
    },
    async deletemenu(menu) {
      const data = JSON.parse(localStorage.getItem("shop_token"));
      if (confirm("Voulez-vous vraiment supprimer le menu n " + menu.id)) {
        await axios
          .delete(this.apiUrl + "menu/" + menu.id, {
            headers: {
              Authorization: "Bearer " + data.token,
            },
          })
          .then(async ({ data }) => {
            if (data.status) {
              alert("menu supprimé avec succès");
              await this.fetchData();
            }
          });
      }
    },
    async fetchData() {
      const data = JSON.parse(localStorage.getItem("shop_token"));
      await axios
        .get(this.apiUrl + "menu/", {
          headers: {
            Authorization: "Bearer " + data.token,
          },
        })
        .then(({ data }) => (this.menuList = data));
      this.menu = {};
    },
    async fetchProductData() {
      const data = JSON.parse(localStorage.getItem("shop_token"));

      await axios
        .get(this.apiUrl + "product/", {
          headers: {
            Authorization: "Bearer " + data.token,
          },
        })
        .then(({ data }) => (this.allProducts = data.data));
      this.product = {};
    },
  },
  async mounted() {
    await this.fetchData();
    await this.fetchProductData();
    const data = JSON.parse(localStorage.getItem("shop_token"));
    this.isAdmin = data.user.role.role_name == "ADMIN";
  },
};
</script>

<style></style>
