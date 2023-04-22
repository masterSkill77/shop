<template>
  <div>
    <AdminMenu />
    <notifications />
    <router-view></router-view>
  </div>
</template>
<script>
import AdminMenu from "./pages/AdminMenu.vue";
export default {
  components: {
    AdminMenu,
  },
};
</script>
