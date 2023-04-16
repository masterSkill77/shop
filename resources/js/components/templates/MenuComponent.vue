<template>
  <div class="card text-center" style="width: 18rem">
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
      <a href="#" class="btn btn-success card-link">Commander</a>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      menuId: null,
      menu: { user: {} },
      apiUrl: "/api/",
    };
  },
  async mounted() {
    this.menuId = this.$route.params.menuId;
    this.menu = await axios
      .get(this.apiUrl + "menu/" + this.menuId)
      .then((res) => res.data);
  },
};
</script>
