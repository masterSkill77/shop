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
              <li :key="products.id" v-for="products in menu.products">
                {{ products.product_name }}
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
              data-toggle="modal"
              type="button"
              data-target="#updateModal"
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
    };
  },
  methods: {
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
    createmenu() {
      axios
        .post(this.apiUrl + "menu", this.newMenu)
        .then(({ data }) => this.fetchData());
    },
    showFormUpdatemenu(menu) {
      this.menu = menu;
    },
    saveModification() {
      axios
        .patch(this.apiUrl + "menu/" + this.menu.id, this.menu)
        .then((data) => {
          if (data) {
            alert("menu modifié avec succès");
            this.fetchData();
          }
        });
    },
    deletemenu(menu) {
      if (confirm("Voulez-vous vraiment supprimer le menu n " + menu.id)) {
        axios.delete(this.apiUrl + "menu/" + menu.id).then(({ data }) => {
          if (data.status == 1) {
            alert("menu supprimé avec succès");
            this.fetchData();
          }
        });
      }
    },
    async fetchData() {
      await axios
        .get(this.apiUrl + "menu/")
        .then(({ data }) => (this.menuList = data));
      this.menu = {};
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
