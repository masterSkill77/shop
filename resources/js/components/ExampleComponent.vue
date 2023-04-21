<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <product-list v-if="connected"></product-list>
            <login :connected="connected" @connected="logged" v-else />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Login from "./pages/Login.vue";
import ProductList from "./ProductListComponent.vue";
export default {
  components: {
    ProductList,
    Login,
  },
  data() {
    return { user: null };
  },
  methods: {
    logged(user) {
      this.connected = user;
      this.$router.push("/");
    },
  },
  mounted() {
    this.user = localStorage.getItem("shop_token");
  },
  computed: {
    connected: {
      get() {
        return this.user;
      },
      set(value) {
        this.user = value;
      },
    },
  },
};
</script>
