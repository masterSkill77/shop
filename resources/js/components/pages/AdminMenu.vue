<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="/">Shop</a>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/">Products</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/menus">Menu</router-link>
        </li>
        <li class="nav-item" v-if="isConnected">
          <a href="#" @click="logout" class="nav-link">Logout</a>
        </li>
      </ul>
    </div>
  </nav>
</template>
<script>
export default {
  computed: {
    isConnected() {
      return localStorage.getItem("shop_token");
    },
  },
  methods: {
    logout() {
      localStorage.removeItem("shop_token");
      window.location.href = "/";
    },
  },
};
</script>
