<template>
  <div>
    <div class="row">
      <div class="col-sm-4" v-for="product in productList" :key="product.id">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ product.product_name }}</h5>
            <p class="card-text"></p>
            <a href="#" class="card-link"
              >Price : {{ product.product_price }} $</a
            >
            <a href="#" class="card-link text-primary"
              >Category : {{ product.category.category_name }}</a
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
      productList: [],
      apiUrl: "/api/",
      categoriesList: [],
    };
  },
  methods: {
    async fetchData() {
      await axios
        .get(this.apiUrl + "category/")
        .then(({ data }) => (this.categoriesList = data.data));
      await axios
        .get(this.apiUrl + "product/")
        .then(({ data }) => (this.productList = data.data));
    },
  },
  mounted() {
    this.fetchData();
  },
};
</script>

<style></style>
