<script setup>
import { ref, watch} from 'vue';

import { Link } from '@inertiajs/inertia-vue3'

import MenuIcon from 'vue-material-design-icons/Menu.vue';
import LogoutIcon from 'vue-material-design-icons/Logout.vue';
import SearchIcon from 'vue-material-design-icons/Magnify.vue';
import AccountMultipleIcon from 'vue-material-design-icons/AccountMultiple.vue';
import AppsIcon from 'vue-material-design-icons/Apps.vue';
import ArchiveIcon from 'vue-material-design-icons/Archive.vue';
import TagIcon from 'vue-material-design-icons/Tag.vue';
import VideoIcon from 'vue-material-design-icons/Youtube.vue';
import CartIcon from 'vue-material-design-icons/cart.vue';
import BasketIcon from 'vue-material-design-icons/Basket.vue';
import ShoppingIcon from 'vue-material-design-icons/Shopping.vue';
import ReceiptTextIcon from 'vue-material-design-icons/Receipt.vue';


let direction = 'ltr';
let side_menu = "!bg-gray-50 dark:!bg-gray-800";

const keyword = ref("");
const navState = ref(false);

const emit = defineEmits(['keywordChange']);

const props = defineProps({
    searchInput: String,
    navTitle: {
        type: String,
        default: "Welcome",
    },
})

watch(() => keyword.value, () => {
    emit('keywordChange', keyword);
})

</script>

<template>

    <div class="flex w-full h-12 p-2 text-white bg-gray-800 header-not-sr-only">
        <div class="flex w-2/12">
            <div class="w-1/4">
                <el-button type="primary" text @click="navState = true">
                    <MenuIcon />
                </el-button>
            </div>
            <div class="w-3/4 p-1 text-left">
                {{ $page.component }}
            </div>
        </div>
        <div class="w-7/12">
            <div class="flex w-6/12 mx-auto bg-white rounded hover:ring-2 hover:ring-blue-500 focus:ring-2 focus:ring-blue-500"
                v-show="searchInput">
                <search-icon class="p-1 rounded text-sky-600" />
                <input v-model="keyword" type="text" label="search" name="search" autocomplete="off"
                    placeholder="Search"
                    class="flex-none px-2 py-1 text-black border-transparent border-none rounded w-fit focus:border-transparent focus:ring-0" />
            </div>
        </div>
        <div class="flex w-3/12">
            <div class="w-3/4 p-1 text-right">
                {{ $page.props.auth.user.name }}
            </div>
            <div class="w-1/4">
                <el-button type="primary" text @click="this.$inertia.get('/logout');">
                    <logout-icon />
                </el-button>
            </div>
        </div>
    </div>

    <el-drawer v-model="navState" title="I am the title" size="18%" :with-header="false" :custom-class="side_menu"
        :direction="direction">

        <div class="px-3 py-2 overflow-y-auto rounded bg-gray-50 dark:bg-gray-800">
            <h2 class="p-3 text-xl font-normal text-gray-900 bg-gray-100 bg-gray-700 rounded-lg dark:text-white">
                Menu
            </h2>
            <ul class="p-1 space-y-2">
                <li>
                    <Link href="/dashboard"
                        class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                        :class="{ 'bg-gray-100 dark:bg-gray-700': $page.url.startsWith( '/dashboard' ) } ">
                    <apps-icon
                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
                    <span class="flex-1 ml-3 whitespace-nowrap">Dashboard</span>
                    </Link>
                </li>
                <li>
                    <Link href="/users"
                        class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                        :class="{ 'bg-gray-100 dark:bg-gray-700': $page.url.startsWith( '/users' ) } ">
                    <account-multiple-icon
                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
                    <span class="flex-1 ml-3 whitespace-nowrap">Users</span>
                    </Link>
                </li>
                <li>
                    <Link href="/product"
                        class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                        :class="{ 'bg-gray-100 dark:bg-gray-700': $page.url.startsWith( '/product' ) } ">
                    <archive-icon
                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
                    <span class="flex-1 ml-3 whitespace-nowrap">Products</span>
                    </Link>
                </li>
                <li>
                    <Link href="/catalogue"
                        class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                        :class="{ 'bg-gray-100 dark:bg-gray-700': $page.url.startsWith( '/catalogue' ) } ">
                    <shopping-icon
                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
                    <span class="flex-1 ml-3 whitespace-nowrap">Catalogue</span>
                    </Link>
                </li>
                <li>
                    <Link href="/cart" :headers="{ foo: bar }"
                        class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                        :class="{ 'bg-gray-100 dark:bg-gray-700': $page.url.startsWith( '/cart' ) } ">
                    <cart-icon
                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
                    <span class="flex-1 ml-3 whitespace-nowrap">Cart</span>
                    </Link>
                </li>
                <li>
                    <Link href="/transactions"
                        class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                        :class="{ 'bg-gray-100 dark:bg-gray-700': $page.url.startsWith( '/transactions' ) } ">
                    <receipt-text-icon
                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
                    <span class="flex-1 ml-3 whitespace-nowrap">Transactions</span>
                    </Link>
                </li>
                <li>
                    <Link href="/categories"
                        class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                        :class="{ 'bg-gray-100 dark:bg-gray-700': $page.url.startsWith( '/categories' ) } ">
                    <tag-icon
                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
                    <span class="flex-1 ml-3 whitespace-nowrap">Categories</span>
                    </Link>
                </li>
                <!-- <li>
                    <Link href="/videos"
                        class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                        :class="{ 'bg-gray-100 dark:bg-gray-700': $page.url.startsWith( '/categories' ) } ">
                    <video-icon
                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
                    <span class="flex-1 ml-3 whitespace-nowrap">Videos</span>
                    </Link>
                </li> -->

            </ul>
        </div>

    </el-drawer>
</template>
