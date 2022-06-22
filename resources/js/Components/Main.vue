<template lang="">
    <div class="flex w-screen h-screen">

        <div class="flex-none w-2/12 p-2 text-white bg-gray-800 ">
            <div class="flex">
                <ul class="space-y-2">
                    <li class="flex" >
                        <it-avatar />
                        <p class="p-2">Menu</p>
                    </li>
                    <li>
                        <router-link to="/hello">hello</router-link>
                    </li>
                </ul>
            </div>

        </div>

        <div class="flex-none w-10/12 p-2  bg-white">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>

import BlogList from './Example.vue';
// import Categories from './Pages/Categories.vue';

export default {
    data() {
        return {
            temp: null
        }
    },
    methods: {
        
    },
    components: {
        'my-table': BlogList, 
        // 'categories': Categories, 
    }
}
</script>
<style>
    .search_icon_size{
        font-size: 25px !important;
    }
</style>