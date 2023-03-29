<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        <product-list></product-list>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ProductList from "./ProductListComponent.vue"
export default {
    components: {
        ProductList
    },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>
