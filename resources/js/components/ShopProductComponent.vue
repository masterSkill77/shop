<template>
  <div>
    <div class="row">
      <div
        class="col-sm-4 m-1 border-1"
        v-for="menu in menuList"
        :key="menu.id"
      >
        <div class="card" style="width: 25rem">
          <img
            class="card-img-top"
            src="https://media.gettyimages.com/id/184355725/fr/photo/pain.jpg?s=612x612&w=0&k=20&c=UovfMuolBw-a-ruIeb6WdCRKxSprZI6ZPTjOBYHvG-w="
            alt="Card image cap"
          />
          <div class="card-body">
            <h5 class="card-title">{{ menu.menu_name }}</h5>
            <p class="card-text">Prix : {{ menu.price }}</p>
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
