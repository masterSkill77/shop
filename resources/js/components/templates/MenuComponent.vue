<template>
  <div class="card text-center" style="width: 18rem">
    <Teleport to="body">
      <div
        class="modal fade"
        id="commanderMenu"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Quantité :</h5>
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
                <input
                  type="number"
                  class="form-control"
                  id="product-price"
                  placeholder="Quantité"
                  v-model="quantity"
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
                @click="proccess"
                class="btn btn-primary"
                data-dismiss="modal"
              >
                Procéder
              </button>
            </div>
          </div>
        </div>
      </div>
    </Teleport>
    <img
      class="card-img-top"
      src="https://media.gettyimages.com/id/184355725/fr/photo/pain.jpg?s=612x612&w=0&k=20&c=UovfMuolBw-a-ruIeb6WdCRKxSprZI6ZPTjOBYHvG-w="
      alt="Card image cap"
    />
    <div class="card-body">
      <h5 class="card-title">{{ menu.menu_name }} by {{ menu.user.name }}</h5>
    </div>
    <ul class="list-group list-group-flush">
      <li
        v-for="product in menu.products"
        :key="product.id"
        class="list-group-item"
      >
        {{ product.product_name }} : {{ product.pivot.quantity }}
        {{ product.pivot.unite }}
      </li>
    </ul>
    <div class="card-body">
      <button
        type="button"
        data-toggle="modal"
        data-target="#commanderMenu"
        class="btn btn-success card-link"
      >
        Commander
      </button>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import Teleport from "vue2-teleport";
export default {
  components: {
    Teleport,
  },
  data() {
    return {
      menuId: null,
      menu: { user: {} },
      apiUrl: "/api/",
      quantity: 0,
    };
  },
  async mounted() {
    this.menuId = this.$route.params.menuId;
    this.menu = await axios
      .get(this.apiUrl + "menu/" + this.menuId)
      .then((res) => res.data);
  },
  methods: {
    proccess: function () {
      console.log(this.menuId, this.quantity);
    },
  },
};
</script>
