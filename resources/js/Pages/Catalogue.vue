<template lang="">
     <div class="block w-full h-screen overscroll-none bg-gradient-to-b from-blue-800 to-cyan-500">
        <Header @keywordChange="(response) => keyword = response" :searchInput=true :navTitle="navTitle"></Header>

        <div class="w-full p-2 rounded-full">
            <div class="w-full p-2 rounded bg-slate-300 h-fit">
                <div class="inline-block w-1/12 p-2 m-1 bg-white rounded " v-for="product in pagination.data" >

                    <div class="w-full">
                        <img class="!h-20 mx-auto" :src="'images/' + product.images[0].path" alt="product image" />
                    </div>

                    <div class="w-full">
                        <div class="text-center">
                            {{product.name}}
                        </div>
                        <div class="text-center">
                            P {{product.price}}
                        </div>
                    </div>
                    <div class="w-full">
                        <el-button class="my-auto" type="primary" @click="update_product_qty(product)" :loading="product.adding">Add to Cart</el-button>
                    </div>

                </div>
            </div>
            <div class="w-full p-1">
                <el-button type="primary" class="w-full" @click="search(pagination.meta.current_page+1)" :disabled=" pagination.meta.current_page == pagination.meta.last_page " :loading="processing">Load more</el-button>
            </div>

            <div class="fixed p-3 m-5 text-lg text-white bg-orange-400 rounded-full cursor-pointer bottom-1 right-1 hover:bg-orange-500" :class="{ 'animate-bounce': product_added }" @click="get_cart()">
                <basket-icon />
            </div>

            <el-drawer v-model="cart_drawer" title="Your Cart" :with-header="false">
                <div class="w-full overflow-x-hidden overflow-y-scroll h-[42em]">
                    <div class="border-b" v-for="product in cart.data">
                        <div class="inline-flex w-full">
                            <div class="w-2/12">
                                <img class="mx-auto !h-14" :src="'images/' + product.image_path" alt="product image" />
                            </div>
                            <div class="inline-block w-10/12">
                                <div class="w-full text-2xl">
                                    {{product.name}}
                                </div>
                                <div class="inline-flex w-full my-auto text-xl py-auto">
                                    <div class="w-1/2">
                                        P {{product.price}} x {{product.qty}}
                                    </div>
                                    <div class="float-right w-1/2 px-6 text-right">
                                        P {{product.price * product.qty }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full py-1 h-1/12">
                    <el-button class="w-full" type="primary" @click="go_to_cart" >
                        <basket-icon />
                        <div class="p-1">
                            Go to cart
                        </div>
                    </el-button>
                </div>
            </el-drawer>
        </div>
        
    </div>
</template>
<script>
import Header from './Shared/Header';

import { ElNotification } from 'element-plus';
import BasketIcon from 'vue-material-design-icons/Basket.vue';

export default {
    components: {
        Header,
        BasketIcon,
    },
    data() {
        return {
            keyword: '',
            navTitle: 'Catalogue',
            adding: false,
            product_added: false,
            pagination: {
                data: [],
                meta: {
                    total: 1,
                    current_page: 1,
                    per_page: 1,
                }
            },
            cart: {
                meta: {
                    total: 1,
                    current_page: 1,
                    per_page: 1,
                }
            },
            cart_drawer: false,
        }
    },
    created() {
        this.$emit('response', 'Catalogue'),
            this.$emit('search', true)
    },
    beforeMount() {
        this.search();
    },
    watch: {
        keyword: function () {
            this.search();
        }
    },
    methods: {
        async search(selectedPage) {

            this.processing = true;

            if (typeof selectedPage !== "undefined") this.pagination.meta.current_page = selectedPage;

            var url = '/product/show?page=' + this.pagination.meta.current_page;

            if (this.keyword)
                url += '&keyword=' + this.keyword;

            if (this.filter_category)
                url += '&category_id=' + this.filter_category;

            await this.axios.post(url)
                .then(({ data }) => {

                    console.table(typeof this.pagination.data);

                    if (this.pagination.meta.current_page != 1) {

                        this.pagination.meta = data.meta;

                        data.data.forEach((value) => {
                            this.pagination.data.push(value);
                        });
                    } else {
                        this.pagination = data;
                    }
                    this.processing = false;

                }).catch(({ response: { data } }) => {
                    ElNotification({
                        title: 'Error',
                        message: 'Unable to retrieve data. Please try again later',
                        type: 'error',
                    })
                }).finally(() => {
                    this.processing = false;
                });
        },

        async update_product_qty(product) {

            product.adding = true;

            let data = {
                type: 'adding',
                product_id: product.product_id,
                qty: 1,
            }

            await this.axios.post('/cart/update', data)
                .then(({ data }) => {

                    ElNotification({
                        title: 'Succes',
                        message: data.message,
                        type: 'succes',
                    })
                    this.cart_amination();
                }).catch(({ response: { data } }) => {
                    ElNotification({
                        title: 'Error',
                        message: "Unable to add product to cart. Please try again later",
                        type: 'error',
                    })
                }).finally(() => {
                    product.adding = false;
                });
        },

        async get_cart() {

            let url = '/cart/search';

            if (this.selectedPage !== undefined) this.cart.current_page = selectedPage;

            url += '?page=' + this.cart.meta.current_page;

            await this.axios.post(url)
                .then(({ data }) => {
                    this.cart = data;
                    this.cart_drawer = true;
                }).catch(({ response: { data } }) => {
                    // alert(data.message)
                }).finally(() => {
                    // this.processing = false
                });
        },

        cart_amination() {
            this.product_added = true;

            this.cart_timeout = setTimeout(function () {
                this.product_added = false;
            }, 1000)
        },

        go_to_cart() {
            this.$inertia.get('/cart');
        },
    },
}
</script>
<style lang="">
    
</style>