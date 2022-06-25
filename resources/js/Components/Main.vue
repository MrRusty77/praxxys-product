<template lang="">
    <div class="block w-full h-screen overscroll-none">

        <div class="flex w-full h-12 p-2 text-white bg-gray-800 header-not-sr-only">
            <div class="flex w-2/12">
                <div class="w-1/4">
                    <el-button type="primary" text @click="open_menu">
                        <menu-icon />
                    </el-button>
                </div>
                <div class="w-3/4 p-1 text-left" >
                    {{ navTitle }}
                </div>
            </div>
            <div class="w-7/12">
                <div class="flex w-6/12 mx-auto bg-white rounded hover:ring-2 hover:ring-blue-500 focus:ring-2 focus:ring-blue-500">                
                    <search-icon class="p-1 rounded text-sky-600"/>
                    <input 
                        v-model="keyword" 
                        v-show="searchInput" 
                        type="text" 
                        label="search" 
                        name="search" 
                        autocomplete="off" 
                        placeholder="Search"
                        class="flex-none px-2 py-1 text-black border-transparent border-none rounded w-fit focus:border-transparent focus:ring-0" 
                    />
                </div>
            </div>
            <div class="flex w-3/12">
                <div class="w-3/4 p-1 text-right" >
                    {{ user }}
                </div>
                <div class="w-1/4">
                    <el-button type="primary" text @click="logout">
                        <logout-icon/>
                    </el-button>
                </div>
            </div>
        </div>

        <div class="w-full h-fit header-nav ">
            <router-view @response="(msg) => navTitle = msg" @search="( search ) => searchInput = search" :keywordSearch="keyword" ></router-view>
        </div>

        <el-drawer v-model="drawer" title="I am the title" size="18%" :with-header="false" :custom-class="side_menu" :direction="direction">

            <div class="px-3 py-2 overflow-y-auto rounded bg-gray-50 dark:bg-gray-800">
                <h2 class="p-3 text-xl font-normal text-gray-900 bg-gray-100 bg-gray-700 rounded-lg dark:text-white">
                    Menu
                </h2>
                <ul class="p-1 space-y-2">
                    <li>
                        <router-link  to="/dashboard" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <apps-icon class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
                            <span class="flex-1 ml-3 whitespace-nowrap">Dashboard</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link  to="/users" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <account-multiple-icon class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
                            <span class="flex-1 ml-3 whitespace-nowrap">Users</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link  to="/product" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <archive-icon class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
                            <span class="flex-1 ml-3 whitespace-nowrap">Product</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link  to="/categories" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <tag-icon class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
                            <span class="flex-1 ml-3 whitespace-nowrap">Categories</span>
                        </router-link>
                    </li>
                   
                </ul>
            </div>

        </el-drawer>

    </div>
</template>

<script>

import MenuIcon from 'vue-material-design-icons/Menu.vue';
import LogoutIcon  from 'vue-material-design-icons/Logout.vue';
import SearchIcon from 'vue-material-design-icons/Magnify.vue';
import AccountMultipleIcon from 'vue-material-design-icons/AccountMultiple.vue';
import AppsIcon from 'vue-material-design-icons/Apps.vue';
import ArchiveIcon from 'vue-material-design-icons/Archive.vue';
import TagIcon from 'vue-material-design-icons/Tag.vue';
import { ElNotification } from 'element-plus';

export default {
    data() {
        return {
            temp: null,
            drawer: false,
            direction: 'ltr',
            user: window.user ? window.user.username : '',
            navTitle: 'home',
            keyword: "",
            side_menu: "!bg-gray-50 dark:!bg-gray-800",
        }
    },
    methods: {
        open_menu() {
            this.drawer = true;
        },
        async logout() {

            await this.$axios.post('/api/logout')
            .then(({ data }) => {
                this.$store.commit('destroyAuthentication');
                this.$router.push({ name: "Login" });

            }).catch(({ response: { data } }) => {
                ElNotification({
                    title: 'Error',
                    message: data.message,
                    type: 'error',
                })
            }).finally(() => {
                this.processing = false
            })

        },
    },
    components: {
        MenuIcon, 
        LogoutIcon, 
        SearchIcon, 
        AccountMultipleIcon,
        AppsIcon,
        ArchiveIcon,
        TagIcon,
    }
}
</script>
<style>
    .search_icon_size{
        font-size: 25px !important;
    }
</style>