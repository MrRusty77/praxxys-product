<script setup>
import { ref, watch } from 'vue'

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

const count = ref(0);
const navState = ref(false);

const emit = defineEmits(['navStateChange']);

const props = defineProps({
    navState: Boolean,
})

watch(() => navState.value, () => {
    console.log(navState);
    emit('navStateChange', navState);
})

</script>

<template>
    <div>

       

    </div>
</template>
<style lang="">
    
</style>