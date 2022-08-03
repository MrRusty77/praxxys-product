<template>
    <div>
        <el-dialog v-model="openModal" width="90%" title="Payment Checkout">
            <div class="border-b-2" v-for=" products in checkout.products ">
                <div class="inline-flex w-full">
                    <div class="w-2/12">
                        <img class="!h-20 mx-auto" :src="'images/' + products.product.images[0].path"
                            alt="product image" />
                    </div>
                    <div class="inline-block w-10/12">
                        <div class="w-full text-2xl">
                            {{products.product.name}}
                        </div>
                        <div class="inline-flex w-full my-auto text-xl py-auto">
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


            <div class="w-full p-2 my-2 text-lg bg-white rounded">
                <div class="inline-flex w-full">
                    <div class="w-1/2">
                        Total Items: {{this.checkout.total_items}}
                    </div>
                    <div class="w-1/2">
                        Total Amount: {{ this.checkout.total_amount }}
                    </div>
                </div>
            </div>

            <template #footer>
                <span class="dialog-footer">
                    <el-button @click="close_modal">Cancel</el-button>
                    <el-button type="primary" :loading="processing" @click="process_checkout">Confirm</el-button>
                </span>
            </template>
        </el-dialog>
    </div>
</template>
<script>
import { ElNotification } from 'element-plus';

export default {
    props: {
        checkout: Object,
        openModal: {
            type: Boolean,
            default() {
                return false;
            }
        }
    },
    data() {
        return {
            processing: false
        }
    },
    methods: {
        async process_checkout( ) {

            this.processing = true;

            ElNotification({
                title: 'Succes',
                message: "Processing payment",
                type: 'succes',
            })

            await this.$axios.put( '/api/transaction', this.checkout )
                .then(({ data }) => {

                    ElNotification({
                        title: 'Succes',
                        message: "Redirecting to billing merchant",
                        type: 'succes',
                    })

                    this.process_paymaya(data)
                }).catch(({ response: { data } }) => {
                    this.processing = false
                }).finally(() => {
                    
                });
        },
        
        async process_paymaya(transaction_code) {
            const checkout_info = {
                "totalAmount": {
                    "value": this.checkout.total_amount,
                    "currency": "PHP",
                    "details": {
                        "discount": 0,
                        "serviceCharge": 0,
                        "shippingFee": 0,
                        "tax": 0,
                        "subtotal": this.checkout.total_amount
                    }
                },
                "buyer": {
                    "firstName": "John",
                    "middleName": "Paul",
                    "lastName": "Doe",
                    "birthday": "1995-10-24",
                    "customerSince": "1995-10-24",
                    "sex": "M",
                    "contact": {
                        "phone": "+639181008888",
                        "email": "louiecabacungan.praxxys@gmail.com"
                    },
                    "shippingAddress": {
                        "firstName": "John",
                        "middleName": "Paul",
                        "lastName": "Doe",
                        "phone": "+639181008888",
                        "email": "merchant@merchantsite.com",
                        "line1": "6F Launchpad",
                        "line2": "Reliance Street",
                        "city": "Mandaluyong City",
                        "state": "Metro Manila",
                        "zipCode": "1552",
                        "countryCode": "PH",
                        "shippingType": "ST" // ST - for standard, SD - for same day
                    },
                    "billingAddress": {
                        "line1": "6F Launchpad",
                        "line2": "Reliance Street",
                        "city": "Mandaluyong City",
                        "state": "Metro Manila",
                        "zipCode": "1552",
                        "countryCode": "PH"
                    }
                },
                
                "items": [],
                "redirectUrl": {
                    "success": `${window.location.origin }/mayaPayment?code=${ transaction_code }&status=success`,
                    "failure": `${window.location.origin }/mayaPayment?code=${ transaction_code }&status=failure`,
                    "cancel": `${window.location.origin }/mayaPayment?code=${ transaction_code }&status=cancel`
                },
                "requestReferenceNumber": "1551191039",
                "metadata": {}
            };

            checkout_info.totalAmount.value = this.checkout.total_amount;
            checkout_info.totalAmount.details.subtotal = this.checkout.total_amount;

            this.checkout.products.forEach((product, index) => {
                checkout_info.items.push(
                    {
                        "name": product.product.name,
                        "quantity": product.qty,
                        "code": "CVG-096732",
                        "description": product.product.description ? product.product.description : "no description",
                        "amount": {
                            "value": product.qty * product.product.price,
                            "details": {
                                "discount": 0,
                                "serviceCharge": 0,
                                "shippingFee": 0,
                                "tax": 0,
                                "subtotal": product.qty * product.product.price
                            }
                        },
                        "totalAmount": {
                            "value": product.qty * product.product.price,
                            "details": {
                                "discount": 0,
                                "serviceCharge": 0,
                                "shippingFee": 0,
                                "tax": 0,
                                "subtotal": product.qty * product.product.price
                            }
                        }
                    },
                );
            })

            PayMayaSDK.init('pk-Z0OSzLvIcOI2UIvDhdTGVVfRSSeiGStnceqwUE7n0Ah', true);
            PayMayaSDK.createCheckout(checkout_info);

            this.processing = false
        },

        close_modal(){
            this.openModal = false;
            this.$emit('openModal', openModal)
        }

    },
}
</script>
