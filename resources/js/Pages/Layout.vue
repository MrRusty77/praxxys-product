<template lang="">
    <div class="block w-full h-screen overscroll-none bg-gradient-to-b from-blue-800 to-cyan-500">
        <Header @keywordChange="(response) => keyword = response" :searchInput=true :navTitle="navTitle"></Header>

        <div class="w-full p-2 rounded-full">
            <slot :keyword=keyword :navTitle="navTitle"></slot>
        </div>

    </div>
</template>
<script>
import Header from './Shared/Header';

export default {
    components: {
        Header,
    },
    data() {
        return {
            keyword:''
        }
    },
}
</script>
<style lang="">
    
</style>