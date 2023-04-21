<template>
  <div>
    <div class="input-group mb-3">
      <select
        v-model="id_category"
        class="custom-select"
        id="inputGroupSelect02"
      >
        <option
          :key="category.id"
          v-for="category in categoriesList"
          :value="category.id"
        >
          {{ category.category_name }}
        </option>
      </select>
      <div
        class="input-group-append cursor-pointer"
        @click="filterByCategory(id_category)"
      >
        <label class="input-group-text" for="inputGroupSelect02"
          >Filtrer par catégorie</label
        >
      </div>
    </div>
    <input
      type="text"
      v-model="queryText"
      @input="queryProduct"
      class="w-100 form-control mb-2"
      placeholder="Rechercher un produit"
    />
    <button
      class="btn btn-sm btn-success mb-2"
      data-toggle="modal"
      data-target="#createProductModal"
      v-if="isAdmin"
    >
      Créer un produit
    </button>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>ID produit</th>
          <th>Nom</th>
          <th>Prix</th>
          <th>Catégorie</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr :key="product.id" v-for="product in productList">
          <td>{{ product.id }}</td>
          <td>{{ product.product_name }}</td>
          <td>{{ product.product_price }}</td>
          <td>{{ product.category.category_name }}</td>
          <td>
            <button
              class="btn btn-sm btn-warning"
              data-toggle="modal"
              @click="showFormUpdateProduct(product)"
              type="button"
              data-target="#updateModal"
            >
              Modifier
            </button>
            <button
              v-if="isAdmin"
              class="btn btn-sm btn-danger"
              @click="deleteProduct(product)"
            >
              Supprimer
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <div>Il y a {{ productList.length }} produit(s)</div>
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
              <label for="product-name">Nom du produit</label>
              <input
                type="text"
                v-model="product.product_name"
                class="form-control"
                id="product-name"
                aria-describedby=""
                placeholder="Produit"
              />
            </div>
            <div class="form-group">
              <label for="product-price">Prix</label>
              <input
                type="text"
                class="form-control"
                id="product-price"
                placeholder="Prix"
                v-model="product.product_price"
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
      id="createProductModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="createModalTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createModalTitle">
              Créer un nouveau produit
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
              <label for="product-name">Nom du produit</label>
              <input
                type="text"
                v-model="newProduct.product_name"
                class="form-control"
                id="product-name"
                aria-describedby=""
                placeholder="Produit"
              />
            </div>
            <div class="form-group">
              <label for="product-price">Prix</label>
              <input
                type="text"
                class="form-control"
                id="product-price"
                placeholder="Prix"
                v-model="newProduct.product_price"
              />
            </div>
            <div class="input-group mb-3">
              <select
                v-model="newProduct.id_category"
                class="custom-select"
                id="inputGroupSelect02"
              >
                <option
                  :key="category.id"
                  v-for="category in categoriesList"
                  :value="category.id"
                >
                  {{ category.category_name }}
                </option>
              </select>
              <div class="input-group-append">
                <label class="input-group-text" for="inputGroupSelect02"
                  >Caterogie</label
                >
              </div>
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
              @click="createProduct"
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
      product: {},
      newProduct: {},
      id_category: "",
      apiUrl: "/api/",
      productList: [],
      categoriesList: [],
      queryText: "",
      isAdmin: false,
    };
  },
  methods: {
    filterByCategory(id_category) {
      this.fetchData().then((data) => {
        let productListFiltered = this.productList.filter((product) => {
          if (product.id_category == id_category) return product;
        });
        this.productList = productListFiltered;
      });
    },
    queryProduct() {
      if (this.queryText == "") {
        this.fetchData();
      } else {
        this.fetchData().then((data) => {
          this.productList = this.productList.filter((product) => {
            if (
              product.product_name.indexOf(this.queryText) != -1 ||
              product.product_price == this.queryText ||
              product.category.category_name.indexOf(this.queryText) != -1
            )
              return product;
          });
        });
      }
    },
    createProduct() {
      const data = JSON.parse(localStorage.getItem("shop_token"));
      axios
        .post(this.apiUrl + "product", this.newProduct, {
          headers: {
            Authorization: "Bearer " + data.token,
          },
        })
        .then(({ data }) => this.fetchData());
    },
    showFormUpdateProduct(product) {
      this.product = product;
    },
    saveModification() {
      const data = JSON.parse(localStorage.getItem("shop_token"));
      axios
        .patch(this.apiUrl + "product/" + this.product.id, this.product, {
          headers: {
            Authorization: "Bearer " + data.token,
          },
        })
        .then((data) => {
          if (data) {
            alert("Produit modifié avec succès");
            this.fetchData();
          }
        });
    },
    deleteProduct(product) {
      const data = JSON.parse(localStorage.getItem("shop_token"));
      if (
        confirm("Voulez-vous vraiment supprimer le produit n " + product.id)
      ) {
        axios
          .delete(this.apiUrl + "product/" + product.id, {
            headers: {
              Authorization: "Bearer " + data.token,
            },
          })
          .then(({ data }) => {
            if (data.status == 1) {
              alert("Produit supprimé avec succès");
              this.fetchData();
            }
          });
      }
    },
    async fetchData() {
      const data = JSON.parse(localStorage.getItem("shop_token"));
      await axios
        .get(this.apiUrl + "category/", {
          headers: {
            Authorization: "Bearer " + data.token,
          },
        })
        .then(({ data }) => (this.categoriesList = data.data));
      await axios
        .get(this.apiUrl + "product/", {
          headers: {
            Authorization: "Bearer " + data.token,
          },
        })
        .then(({ data }) => (this.productList = data.data));
      this.product = {};
    },
  },
  mounted() {
    this.fetchData();
    const data = JSON.parse(localStorage.getItem("shop_token"));
    this.isAdmin = data.user.role.role_name == "ADMIN";
  },
};
</script>

<style></style>
