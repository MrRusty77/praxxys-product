<template>
    <div v-slot="{ keyword }">
        {{keyword}}
        <div class="w-full p-2 overflow-x-hidden rounded bg-slate-300 h-[38em] overflow-y-scroll">
            <div class="w-full">
                <div class="px-3 py-2 my-2 bg-white rounded" v-for=" (product, index) in pagination.data" :key="index">

                    <div class="inline-flex w-full">

                        <div class="w-1/12 m-auto">
                            <div class="flex items-center m-auto">
                                <input id="default-checkbox" type="checkbox" value="" @change="add_to_checkout(product)"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <!-- <label for="default-checkbox"
                                    class="ml-2 text-sm font-medium text-black dark:text-gray-300">Add to
                                    Checkout</label> -->
                            </div>
                        </div>

                        <div class="w-1/12 my-auto">
                            <img class="!h-10 mx-auto" :src="'images/' + product.image_path" alt="product image" />
                        </div>

                        <div class="inline-flex w-10/12 my-auto">
                            <div class="inline-flex w-1/2 py-2 text-2xl">
                                <div class="w-1/2 text-left">
                                    {{ product.name }}
                                </div>

                                <div class="w-1/2 px-2 text-right">
                                    P {{ product.price }}
                                </div>
                            </div>

                            <div class="inline-flex w-1/2 py-3">
                                <div class="inline-flex w-1/2">

                                    <el-button text @click="add(product)">
                                        <plus-icon />
                                    </el-button>

                                    <div>
                                        <input class="text-lg text-center bg-gray-100 rounded" v-model="product.qty">
                                    </div>

                                    <el-button text @click="deduct(product)" :disabled="product.qty == 1">
                                        <minus-icon />
                                    </el-button>
                                </div>
                                <div class="w-1/2">
                                    <el-button class="float-right" @click="remove( product, index )"
                                        :loading="remove_loading">Remove product</el-button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="fixed bottom-0 w-full p-2 my-2 text-lg bg-white rounded">
            <div class="inline-flex w-full">
                <div class="w-4/12">
                    Total Items: {{this.checkout.total_items}}
                </div>
                <div class="w-4/12">
                    Total Amount: {{ this.checkout.total_amount }}
                </div>
                <div class="w-4/12">
                    <el-button class="w-full" type="primary" @click="open_modal" :disabled="(checkout.lenght == 0)">
                        Go
                        to Checkout</el-button>
                </div>
            </div>

        </div>

        <checkout-modal @openCheckout="( value ) => openModal = value" :openModal="openModal" :checkout="checkout">
        </checkout-modal>
    </div>

</template>

<script>
import Header from './Shared/Header';

import Layout from './Layout';

import { ElNotification } from 'element-plus'
import PlusIcon from 'vue-material-design-icons/Plus.vue';
import MinusIcon from 'vue-material-design-icons/Minus.vue';

import CheckoutModal from './CheckoutModal.vue';

export default {
    layout: Layout,
    setup() {
        return {
            // v$: useVuelidate()
        }
    },
    components: {
        PlusIcon,
        MinusIcon,
        Header,
        'checkout-modal':CheckoutModal
    },
    created() {
        this.$emit('response', 'Cart')
        // this.$emit('search', true)
    },
    watch: {
        openModal: function () {
            console.log(this.openModal)
        }
    },
    data() {
        return {
            pagination: {
                current_page: 1
            },
            remove_loading: false,
            navTitle: "Cart",
            checkout: {
                total_amount:0,
                total_items:0,
                products: [],
            },
            openModal: false,
        }
    },
    beforeMount() {
        this.search();
    },
    methods: {
        async search() {
            
            let url = '/cart/search';

            if (this.selectedPage !== undefined) this.pagination.current_page = selectedPage;

            url += '?page=' + this.pagination.current_page;

            await this.axios.post(url)
                .then(({ data }) => {
                    this.pagination = data;
                }).catch(({ response: { data } }) => {
                    // alert(data.message)
                }).finally(() => {
                    // this.processing = false
                });
        },
        add(product) {
            product.qty++;
            clearTimeout(this.update_timeou);
            this.change_qty_timeout(product);
        },
        deduct(product) {

            if ( product.qty != 1 ){
                product.qty--;
                clearTimeout(this.update_timeou);
                this.change_qty_timeout(product);
            }
            
        },
        change_qty_timeout(product) {
            this.update_timeout = setTimeout(this.update_product_qty(product), 2000);
        },
        async update_product_qty(product){
 
            await this.axios.post('/cart/update', product)
                .then(({ data }) => {
                    this.compute_total();
                }).catch(({ response: { data } }) => {
                    ElNotification({
                        title: 'Error',
                        message: "Unable to update Quantity. Please try again later",
                        type: 'error',
                    })
                }).finally(() => {
                    // this.processing = false 
                });
        },

        async remove(product, index) {

            this.remove_loading = true;

            await this.axios.post('/cart/remove', product)
                .then(({ data }) => {

                    ElNotification({
                        title: 'Success',
                        message: data.message,
                        type: 'success',
                    })

                    this.remove_product_from_list(index);

                }).catch(({ response: { data } }) => {
                    ElNotification({
                        title: 'Error',
                        message: data.message,
                        type: 'error',
                    })
                }).finally(() => {
                    this.remove_loading = false;
                });
        },
        async remove_product_from_list(index ) {
            this.pagination.data.splice(index, 1)
        },
        add_to_checkout( product ) {

            let index = this.checkout.products.findIndex(function (checkout) {
                return checkout.cart_id === product.cart_id;
            })

            if( index < 0 ) {
                this.checkout.products.push( product );
            } else {
                this.checkout.products.splice( index, 1 );
            }
            
            this.compute_total();

        },
        compute_total(){
            this.checkout.total_amount = this.checkout.products.reduce(function (_this, val) {
                return _this + val.qty * val.price
            }, 0);

            this.checkout.total_items = this.checkout.products.reduce(function (_this, val) {
                return _this + val.qty
            }, 0);
        },
        open_modal(){
            this.openModal = true;
        }
    },
}
</script>
