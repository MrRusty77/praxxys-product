<template >
    <div class="block w-full h-screen overscroll-none bg-gradient-to-b from-blue-800 to-cyan-500">
        <Header @keywordChange="(response) => keyword = response" :searchInput=false :navTitle="navTitle"></Header>
        <div class="flex w-full p-4 rounded-full">
            <div class="relative m-1 text-white bg-teal-400 rounded cursor-pointer hover:bg-teal-600 hover:text-teal-400 card w-[32em] inline-block"
                @click="this.$inertia.get('/product');">
                <div class="flex w-full p-5 ">
                    <div class="block w-6/12">
                        <div class="w-fit">
                            <p class="text-[3rem] font-medium ">{{ users }}</p>
                        </div>
                        <div class=" w-fit">
                            <p class="text-lg">Products</p>
                        </div>
                    </div>
                    <div class="w-6/12 p-1 icon-area">
                        <div class="float-right text-teal-500 ">
                            <archive-icon class="w-2/12" :size="100" />
                        </div>
                    </div>
                </div>
                <div class="w-full text-white bg-teal-700 rounded-b more-info-area">
                    <div class="flex p-1 text-base text-center">
                        <div class="flex mx-auto">
                            More info
                            <chevron-right-box-icon />
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative m-1 text-white bg-green-400 rounded cursor-pointer hover:bg-green-600 hover:text-green-400 card w-[32em] inline-block"
                @click="this.$inertia.get('/categories');">
                <div class="flex w-full p-5 ">
                    <div class="block w-6/12">
                        <div class="w-fit">
                            <p class="text-[3rem] font-medium ">{{ product }}</p>
                        </div>
                        <div class=" w-fit">
                            <p class="text-lg">Category</p>
                        </div>
                    </div>
                    <div class="w-6/12 p-1 icon-area">
                        <div class="float-right text-green-500 ">
                            <tag-icon class="w-2/12" :size="100" />
                        </div>
                    </div>
                </div>
                <div class="w-full text-white bg-green-700 rounded-b more-info-area">
                    <div class="flex p-1 text-base text-center">
                        <div class="flex mx-auto">
                            More info
                            <chevron-right-box-icon />
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative m-1 text-black bg-yellow-400 rounded cursor-pointer hover:bg-yellow-600 hover:text-yellow-400 card w-[32em] inline-block"
                @click="this.$inertia.get('/users')">
                <div class="flex w-full p-5 ">
                    <div class="block w-6/12">
                        <div class="w-fit">
                            <p class="text-[3rem] font-medium ">{{ categories }}</p>
                        </div>
                        <div class=" w-fit">
                            <p class="text-lg">Users</p>
                        </div>
                    </div>
                    <div class="w-6/12 p-1 icon-area">
                        <div class="float-right text-yellow-500 ">
                            <account-multiple-icon class="w-2/12" :size="100" />
                        </div>
                    </div>
                </div>
                <div class="w-full text-white bg-yellow-700 rounded-b more-info-area">
                    <div class="flex p-1 text-base text-center">
                        <div class="flex mx-auto">
                            More info
                            <chevron-right-box-icon />
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="relative m-1 text-black bg-red-400 rounded cursor-pointer hover:bg-red-600 hover:text-red-400 card w-[32em] inline-block"
                @click="this.$inertia.get('/videos');">
                <div class="flex w-full p-5 ">
                    <div class="block w-6/12">
                        <div class="w-fit">
                            <p class="text-[3rem] font-medium ">Play</p>
                        </div>
                        <div class=" w-fit">
                            <p class="text-lg">Video</p>
                        </div>
                    </div>
                    <div class="w-6/12 p-1 icon-area">
                        <div class="float-right text-red-500 ">
                            <video-icon class="w-2/12" :size="100" />
                        </div>
                    </div>
                </div>
                <div class="w-full text-white bg-red-700 rounded-b more-info-area">
                    <div class="flex p-1 text-base text-center">
                        <div class="flex mx-auto">
                            More info
                            <chevron-right-box-icon />
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="relative m-1 text-black bg-orange-400 rounded cursor-pointer hover:bg-orange-600 hover:text-orange-400 card w-[32em] inline-block"
                @click="this.$inertia.get('/cart');">
                <div class="flex w-full p-5 ">
                    <div class="block w-6/12">
                        <div class="w-fit">
                            <p class="text-[3rem] font-medium ">{{ cart }}</p>
                        </div>
                        <div class=" w-fit">
                            <p class="text-lg">Cart</p>
                        </div>
                    </div>
                    <div class="w-6/12 p-1 icon-area">
                        <div class="float-right text-orange-500 ">
                            <cart-icon class="w-2/12" :size="100" />
                        </div>
                    </div>
                </div>
                <div class="w-full text-white bg-orange-700 rounded-b more-info-area">
                    <div class="flex p-1 text-base text-center">
                        <div class="flex mx-auto">
                            More info
                            <chevron-right-box-icon />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Header from './Shared/Header';

import AccountMultipleIcon from 'vue-material-design-icons/AccountMultiple.vue';
import AppsIcon from 'vue-material-design-icons/Apps.vue';
import ArchiveIcon from 'vue-material-design-icons/Archive.vue';
import TagIcon from 'vue-material-design-icons/Tag.vue';
import ChevronRightBoxIcon from 'vue-material-design-icons/ChevronRightBox.vue';
import VideoIcon from 'vue-material-design-icons/Youtube.vue';
import CartIcon from 'vue-material-design-icons/cart.vue';
import ReceiptIcon from 'vue-material-design-icons/Receipt.vue';


export default {
    components: {
        AccountMultipleIcon,
        AppsIcon,
        ArchiveIcon,
        TagIcon,
        ChevronRightBoxIcon,
        VideoIcon,
        CartIcon,
        ReceiptIcon,
        Header
    },
    props: {
        users: {
            type: Number,
            default: 0,
        },
        product: {
            type: Number,
            default: 0,
        },
        categories: {
            type: Number,
            default: 0,
        },
        cart: {
            type: Number,
            default: 0,
        },
        transaction: {
            type: Number,
            default: 0,
        },
    },
    data() {
        return {
            navTitle: 'Dashboard',
            numbers: {
                users: 0,
                product: 0,
                categories: 0,
            },
        }
    }
};
</script>

