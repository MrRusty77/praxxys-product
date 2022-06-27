<template >

    <div class="flex w-full p-4 rounded-full">
        <div class="w-1/4 m-1 text-white bg-teal-400 rounded cursor-pointer hover:bg-teal-600 hover:text-teal-400 card"
            @click="toProduct">
            <div class="flex w-full p-5 ">
                <div class="block w-6/12">
                    <div class="w-fit">
                        <p class="text-[3rem] font-medium ">{{ numbers.users }}</p>
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

        <div class="w-1/4 m-1 text-white bg-green-400 rounded cursor-pointer hover:bg-green-600 hover:text-green-400 card"
            @click="toCategories">
            <div class="flex w-full p-5 ">
                <div class="block w-6/12">
                    <div class="w-fit">
                        <p class="text-[3rem] font-medium ">{{ numbers.product }}</p>
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

        <div class="w-1/4 m-1 text-black bg-yellow-400 rounded cursor-pointer hover:bg-yellow-600 hover:text-yellow-400 card"
            @click="toUsers">
            <div class="flex w-full p-5 ">
                <div class="block w-6/12">
                    <div class="w-fit">
                        <p class="text-[3rem] font-medium ">{{ numbers.categories }}</p>
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

        <div class="w-1/4 m-1 text-black bg-red-400 rounded cursor-pointer hover:bg-red-600 hover:text-red-400 card"
            @click="toVideos">
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
        </div>
    </div>
</template>

<script>
    
import AccountMultipleIcon from 'vue-material-design-icons/AccountMultiple.vue';
import AppsIcon from 'vue-material-design-icons/Apps.vue';
import ArchiveIcon from 'vue-material-design-icons/Archive.vue';
import TagIcon from 'vue-material-design-icons/Tag.vue';
import ChevronRightBoxIcon from 'vue-material-design-icons/ChevronRightBox.vue';
import VideoIcon from 'vue-material-design-icons/Youtube.vue';

export default {
    components: {
        AccountMultipleIcon,
        AppsIcon,
        ArchiveIcon,
        TagIcon,
        ChevronRightBoxIcon,
        VideoIcon,
    },
    mounted() {
        this.getCategories();
    },
    data() {
        return {
            numbers: {
                users: 0,
                product: 0,
                categories: 0,
            },
        }
    },
    methods: {
        toProduct() {
            this.$router.push({ path: '/product', redirect: '/product' });
        },
        toCategories() {
            this.$router.push({ path: '/categories', redirect: '/categories' });
        },
        toUsers() {
            this.$router.push({ path: '/users', redirect: '/users' });
        },
        toVideos() {
            this.$router.push({ path: '/videos', redirect: '/videos' });
        },
        async getCategories() {
            await this.$axios.get('api/dashboard/getNumbers')
                .then(({ data }) => {
                    this.numbers = data;
                }).catch(({ response: { data } }) => {
                    ElNotification({
                        title: 'Error',
                        message: 'Unable to retrieve numbers. Please try again later',
                        type: 'error',
                    })
                }).finally(() => {
                    this.processing = false
                });
        },
    }
};
</script>

