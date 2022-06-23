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
                <input v-model="keyword" type="text" label="search" name="search" autocomplete="off"
                    class="flex-none w-full px-2 py-1 text-black border-none rounded focus-visible:border-transparent focus-visible:outline-0" v-show="searchInput" />
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

        <div class="w-full h-screen bg-white header-nav ">
            <router-view @response="(msg) => navTitle = msg" @search="( search ) => searchInput = search" :keywordSearch="keyword" ></router-view>
        </div>

        <el-drawer v-model="drawer" title="I am the title" size="20%" :with-header="false" :direction="direction">
            <span>Hi there!</span>
            <router-link to="/categories">Categories</router-link>
        </el-drawer>

    </div>
</template>

<script>

import MenuIcon from 'vue-material-design-icons/Menu.vue';
import LogoutIcon  from 'vue-material-design-icons/Logout.vue';
import { ElNotification } from 'element-plus';
import { useRouter } from 'vue-router';

export default {
    data() {
        return {
            temp: null,
            drawer: false,
            direction: 'ltr',
            user: window.user ? window.user.username : '',
            navTitle: 'home',
            keyword: "hello",
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
        'menu-icon': MenuIcon, 
        'logout-icon': LogoutIcon, 
    }
}
</script>
<style>
    .search_icon_size{
        font-size: 25px !important;
    }
</style>