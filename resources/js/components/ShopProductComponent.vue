<template>
  <div>
    <div class="row">
      <div
        class="col-sm-4 m-1 border-1"
        v-for="menu in menuList"
        :key="menu.id"
      >
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ menu.menu_name }}</h5>
            <p class="card-text"></p>
            <!-- Button trigger modal -->
            <router-link class="btn btn-primary" :to="`/menus/${menu.id}`"
              >See ingrendients</router-link
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      menuList: [],
      apiUrl: "/api/",
    };
  },
  methods: {
    async fetchData() {
      await axios.get(this.apiUrl + "menu/").then(({ data }) => {
        console.log(data);
        this.menuList = data;
      });
    },
  },
  mounted() {
    this.fetchData();
  },
};
</script>

<style></style>
