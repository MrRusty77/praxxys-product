<script setup>

</script>

<template lang="">
    <div class="block w-full h-screen overscroll-none">
        <Header @keywordChange="(response) => keyword = response" :searchInput=true></Header>

        {{openMenu}}

        Hello there {{keyword}}

         <div>
            <Link href="/" >Test</Link>
            <Link href="/users" >users</Link>
            <Link href="/catalog" >catalog</Link>
        </div>
    </div>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3';
import Header from './Shared/Header';
import Nav from './Shared/Nav';
export default {
    props: {
        message: String
    },
    components: {
        Link,
        Header,
        Nav,
    },
    watch: {
        openMenu: function () {
            
        }
    },
    data() {
        return {
            keyword: "",
            openMenu: false,
        }
    },
}
</script>
<style lang="">
    
</style>