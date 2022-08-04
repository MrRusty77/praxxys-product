<template >

    <div class="w-full p-2 rounded-full">

        <div class="w-full p-2 rounded bg-slate-300 h-fit">
            <table class="w-full bg-white border-none rounded table-auto border-spacing-3">
                <thead>
                    <tr>
                        <th class="p-2 text-left">Reference Number</th>
                        <th class="p-2 text-left">Transaction Date</th>
                        <th class="p-2 text-left">Status</th>
                        <th class="p-2 text-left">Number of Items</th>
                        <th class="p-2 text-left">Total amount</th>
                        <th class="p-2 pr-8 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="p-2 text-black border border-solid rounded hover:ring-2 hover:ring-blue-500 focus:ring-2 focus:ring-blue-500"
                        v-for="transaction in pagination.data" :key="transaction.transaction_id">
                        <td class="p-2 text-left"> {{ transaction.code }}</td>
                        <td class="p-2 text-left"> {{ transaction.date_purchased }}</td>
                        <td class="p-2 text-left"> {{ transaction.payment_status }}</td>
                        <td class="p-2 text-left"> {{ transaction.total_items }}</td>
                        <td class="p-2 text-left"> P {{ transaction.total_amount }}</td>
                        <td class="float-right p-1">
                            <el-button class="text-red" @click="open_transaction_modal(transaction)">
                                <receipt-icon />
                            </el-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-none w-full p-2">
            <div class="flex-none w-6/12 ">


            </div>
            <div class="flex-none float-right w-6/12">
                <VuePaginationTw class="float-right" :totalItems="pagination.total"
                    :currentPage="pagination.current_page" :perPage="pagination.per_page" @pageChanged="search"
                    :goButton="false" styled="centered" borderActiveColor="border-red-500"
                    borderTextActiveColor="text-red-500" v-if="!processing" />
            </div>
        </div>
    </div>


    <el-dialog v-model="transaction_log_modal" :title="'Reference Number: ' + transaction_modal.code" width="80%"
        :close-on-click-modal="close_transaction_modal">
        <table class="w-full bg-white border-none rounded table-auto border-spacing-3">
            <thead>
                <tr>
                    <th class="p-2 text-left">Product Code</th>
                    <th class="p-2 text-left">Product Name</th>
                    <th class="p-2 text-left">Quantiy</th>
                    <th class="p-2 text-left">Trice</th>
                    <th class="p-2 text-left">Sub total</th>
                </tr>
            </thead>
            <tbody>
                <tr class="p-2 text-black border border-solid rounded hover:ring-2 hover:ring-blue-500 focus:ring-2 focus:ring-blue-500"
                    v-for="logs in transaction_modal.transaction_logs" :key="logs.id">
                    <td class="p-2 text-left"> {{ logs.product.code }}</td>
                    <td class="p-2 text-left"> {{ logs.product.name }}</td>
                    <td class="p-2 text-left"> {{ logs.qty }}</td>
                    <td class="p-2 text-left"> P {{ logs.price }}</td>
                    <td class="p-2 text-left"> P {{ logs.total_price }}</td>
                </tr>
            </tbody>
        </table>

        <template #footer class="bg-slate-200">
            <span class="dialog-footer ">
                <el-button @click="close_transaction_modal">close</el-button>
            </span>
        </template>

    </el-dialog>

</template>
<script >
import VueAdsPagination from 'vue-ads-pagination';

import ReceiptIcon from 'vue-material-design-icons/Receipt.vue';

export default {
    setup() {
        
    },
    mounted() {
        this.search();
    },
    components: {
        VueAdsPagination,
        ReceiptIcon,
    },
    created() {
        this.$emit('response', 'Transactions')
        this.$emit('search', true)
    },
    props: {
        keywordSearch: String
    },
    watch: {
        keywordSearch: function () {
            this.search();
        }
    },
    data() {
        return {
            top: 'top',
            pagination: {
                current_page: 1,
                data: []
            },
            processing: false,
            keyword: this.keywordSearch,
            transaction_log_modal: false,
            transaction_modal: {
                code: 0,
                transaction_logs:[],
            },
        }
    },
    methods: {
        async search(selectedPage) {

            this.processing = true;

            if (selectedPage !== undefined) this.pagination.current_page = selectedPage;

            var url = '/api/transaction?page=' + this.pagination.current_page;

            if (this.keywordSearch) {
                url += '&keyword=' + this.keywordSearch;
            }

            await this.$axios.post(url, this.keyword)
                .then(({ data }) => {
                    this.pagination = data;
                }).catch(({ response: { data } }) => {
                    // alert(data.message)
                }).finally(() => {
                    this.processing = false
                });
        },
        open_transaction_modal(transaction) {
            this.transaction_log_modal = true;
            this.transaction_modal = transaction;
        },
        close_transaction_modal() {
            this.transaction_log_modal = false;
        },
    },
}
</script>
<style >
</style>