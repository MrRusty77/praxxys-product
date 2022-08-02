<template lang="">
    <div class="w-full p-2 rounded-full">
        <div class="w-full p-2 rounded bg-slate-300 h-fit">
            <div class="w-full">
                <div class="px-3 py-2 my-2 bg-white rounded" v-for=" (product, index) in pagination.data ">

                    <div class="inline-flex w-full">

                        <div class="w-2/12 my-auto">
                            <div class="flex items-center mb-4" >
                                <input id="default-checkbox" type="checkbox" value="" @change="add_to_checkout(product)" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="default-checkbox" class="ml-2 text-sm font-medium text-black dark:text-gray-300">Add to Checkout</label>
                            </div>
                        </div>

                        <div class="w-3/12 my-auto">
                            <img class="!h-40 mx-auto" :src="'images/' + product.product.images[0].path" alt="product image" />
                        </div>

                        <div class="w-7/12 my-auto">
                            <div class="inline-flex w-full py-2 text-4xl">
                                <div class="w-1/2 text-left">
                                    {{ product.product.name }}
                                </div>

                                <div class="w-1/2 px-2 text-right">
                                    P {{ product.product.price }}
                                </div>
                            </div>

                            <div class="inline-flex w-full py-3">
                                <div class="inline-flex w-1/2">

                                    <el-button text @click="add(product)">
                                        <plus-icon />
                                    </el-button>

                                    <div>
                                        <input class="text-lg text-center bg-gray-100 rounded" v-model="product.qty" >
                                    </div>

                                    <el-button text @click="deduct(product)" :disabled="product.qty == 1">
                                        <minus-icon />
                                    </el-button>
                                </div>
                                <div class="w-1/2">
                                    <el-button class="float-right" @click="remove( product, index )" :loading="remove_loading" >Remove product</el-button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="fixed bottom-0 w-full p-2 my-2 text-lg bg-white rounded">
            <div class="inline-flex w-full">
                <div class="w-1/2">
                    Total Items: 1
                </div>
                <div class="w-1/2">
                    Total Amount: {{ total_amount }}
                </div>
            </div>
            <div class="w-full">
                <el-button @click="search">search</el-button>
                <el-button @click="checkout_modal_visible = true" :disabled="(checkout.lenght == 0)">Go to Checkout</el-button>

            </div>
        </div>
        
        <el-dialog v-model="checkout_modal_visible" width="90%" title="Payment Checkout">
            <div class="w-full" v-show="active_form == 1">
                <div class="border-b-2" v-for=" products in checkout ">
                    <div class="inline-flex w-full">
                        <div class="w-2/12">
                            <img class="!h-20 mx-auto" :src="'images/' + products.product.images[0].path" alt="product image" />
                        </div>
                        <div class="inline-block w-10/12">
                            <div class="w-full text-2xl">
                                {{products.product.name}}
                            </div>
                            <div class="inline-flex w-full my-auto text-xl">
                                <div class="w-1/2">
                                    P {{products.product.price}} x {{products.qty}}
                                </div>
                                <div class="float-right w-1/2 px-6 text-right">
                                    P {{products.product.price * products.qty }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full" v-show="active_form == 2">

                <el-form :label-position="top" label-width="100px">

                    <el-form-item label="Card Number" prop="name">

                        <el-input v-model="formData.card_number" @blur="v$.formData.card_number.$touch" 
                            type="number" placeholder="Card number" />

                        <div class="text-red-600" v-for="error of v$.formData.card_number.$errors" :key="error.$uid">
                            <strong>{{ error.$message }}</strong> <br />
                        </div>
                    </el-form-item>
                    
                    <el-form-item label="Holder name" prop="name">

                        <el-input v-model="formData.name" @blur="v$.formData.name.$touch" 
                            type="number" placeholder="Card holder name" />

                        <div class="text-red-600" v-for="error of v$.formData.name.$errors" :key="error.$uid">
                            <strong>{{ error.$message }}</strong> <br />
                        </div>
                    </el-form-item>

                    <el-form-item label="Expiration date" prop="name">

                        <div class="inline-flex w-full" >
                            <el-input class="w-1/2" v-model="formData.expiry_month" @blur="v$.formData.expiry_month.$touch" 
                                type="number" placeholder="Expiring month" />
                            <el-input class="w-1/2" v-model="formData.expiry_year" @blur="v$.formData.expiry_year.$touch" 
                                type="number" placeholder="Expiring year" />
                        </div>

                        <div class="inline-flex w-full" >
                            <div class="w-1/2 text-red-600" v-for="error of v$.formData.expiry_month.$errors" :key="error.$uid">
                                <strong class="w-full">{{ error.$message }}</strong> <br />
                            </div>
                            
                            <div class="w-1/2 text-red-600" v-for="error of v$.formData.expiry_year.$errors" :key="error.$uid">
                                <strong class="w-full">{{ error.$message }}</strong> <br />
                            </div>
                        </div>

                    </el-form-item>

                    <el-form-item label="CVV" prop="name">

                        <el-input v-model="formData.cvv" @blur="v$.formData.cvv.$touch" 
                            type="number" placeholder="Please input" />

                        <div class="text-red-600" v-for="error of v$.formData.cvv.$errors" :key="error.$uid">
                            <strong>{{ error.$message }}</strong> <br />
                        </div>
                    </el-form-item>
                </el-form>
            </div>

            <div class="w-full p-2 my-2 text-lg bg-white rounded">
                <div class="inline-flex w-full">
                    <div class="w-1/2">
                        Total Items: 1
                    </div>
                    <div class="w-1/2">
                        Total Amount: {{ total_amount }}
                    </div>
                </div>
            </div>
        

            <div class="flex w-full h-6/12">
                <div class="w-6/12 ">
                    <el-button class="float-left" type="info" @click="active_form--">Previous</el-button>
                </div>
                <div class="w-6/12 ">
                    <el-button class="float-right" type="primary" @click="active_form++"> Next</el-button>
                </div>
            </div>

            <template #footer>
                <span class="dialog-footer">
                    <el-button @click="checkout_modal_visible = false">Cancel</el-button>
                    <el-button type="primary" @click="dialogFormVisible = false"
                    >Confirm</el-button
                    >
                </span>
            </template>
        </el-dialog>

    </div>
</template>

<script>

import { ElNotification } from 'element-plus'
import PlusIcon from 'vue-material-design-icons/Plus.vue';
import MinusIcon from 'vue-material-design-icons/Minus.vue';

import useVuelidate from '@vuelidate/core'
import { required, minLength, maxLength, minValue, maxValue } from '@vuelidate/validators';

export default {
    setup() {
        return {
            v$: useVuelidate()
        }
    },
    components: {
        PlusIcon,
        MinusIcon
    },
    validations() {
        return {
            formData: {
                name: { 
                    required,
                    minLength: minLength(2),
                },
                card_number: { 
                    required,
                    minLength: minLength(16),
                    maxLength: maxLength(16),
                },
                expiry_month: { 
                    required,
                    minLength: minLength(2),
                    maxLength: maxLength(2),
                    minValue: minValue(1),
                    maxValue: maxValue(12),
                },
                expiry_year: { 
                    required,
                    minLength: minLength(4),
                    maxLength: maxLength(4),
                    minValue: minValue(1500),
                    maxValue: maxValue(2022),
                },
                cvv: { 
                    required,
                    minLength: minLength(3),
                    maxLength: maxLength(3),
                },
            }
        }
    },
    data() {
        return {
            pagination: {
                current_page: 1
            },
            remove_loading: false,
            checkout: [],
            total_amount: 0,
            checkout_modal_visible: false,
            active_form: 1,
            top: 'top',
            formData: {
                name:'',
                card_number:'',
                expiry_month:'',
                expiry_year:'',
                cvv:'',
            },
        }
    },
    beforeMount() {
        this.search();
    },
    methods: {
        async search() {
            
            let url = '/api/cart/search';

            // url += '&keyword=' + this.keywordSearch;

            if (this.selectedPage !== undefined) this.pagination.current_page = selectedPage;

            url += '?page=' + this.pagination.current_page;

            await this.$axios.post(url)
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

            let data = {
                product_id: product.product.id,
                qty: product.qty,
            }

            await this.$axios.post('/api/cart/update', data)
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
        // async add( product ) {
        //     await this.$axios.post( '/apl/cart/add', product )
        //         .then(({ data }) => {
        //             console.log(data);
        //         }).catch(({ response: { data } }) => {
        //             // alert(data.message)
        //         }).finally(() => {
        //             // this.processing = false
        //         });
        // },
        async remove(product, index) {

            this.remove_loading = true;

            await this.$axios.post('/api/cart/remove', product)
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

            let index = this.checkout.findIndex(function (checkout) {
                return checkout.id === product.id;
            })

            if( index < 0 ) {
                this.checkout.push( product );
            } else {
                this.checkout.splice( index, 1 );
            }
            
            this.compute_total();

        },
        compute_total(){
            this.total_amount = this.checkout.reduce(function (_this, val) {
                return _this + val.qty * val.product.price
            }, 0);
        },
        open_payment_checkout() {
            //open modal
        },
        
        async process_checkout() {
            await this.$axios.post('/apl/cart/remove', this.checkout)
                .then(({ data }) => {
                   //remove - Backend??? or reload page.
                   // on success or fail show modal purchase alert
                }).catch(({ response: { data } }) => {
                    // alert(data.message)
                }).finally(() => {
                    // this.processing = false
                });
        }
    },
}
</script>
