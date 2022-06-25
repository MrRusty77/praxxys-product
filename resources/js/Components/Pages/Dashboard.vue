<template >
    <div class="w-full p-2 rounded-full">
        <div class="w-1/4 bg-teal-400 rounded card">
            <div class="flex w-full p-5 text-white">
                <div class="block w-6/12">
                    <div class="w-fit">
                        <p class="text-[3rem] font-medium ">150</p>
                    </div>
                    <div class=" w-fit">
                        <p class="text-lg">Products</p>
                    </div>
                </div>
                <div class="w-6/12 p-1  icon-area">
                        <div class="float-right">
                            <archive-icon />
                        </div>
                    </div>
                </div>
                <div class="w-full text-white bg-teal-700 rounded-b more-info-area">
                    <div class="p-1 text-base text-center">
                        More info
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    
import AccountMultipleIcon from 'vue-material-design-icons/AccountMultiple.vue';
import AppsIcon from 'vue-material-design-icons/Apps.vue';
import ArchiveIcon from 'vue-material-design-icons/Archive.vue';
import TagIcon from 'vue-material-design-icons/Tag.vue';

export default {
    components: {
        AccountMultipleIcon,
        AppsIcon,
        ArchiveIcon,
        TagIcon,
    },
    data() {
        return {
            
        }
    },
    methods() {
        
    }
};
</script>

