<template>

    <div class="w-full p-2 rounded-full">

        <div class="w-full p-2 my-1 rounded bg-slate-300 h-fit" v-if="test">
            <div
                class="flex w-6/12 mx-auto bg-white rounded hover:ring-2 hover:ring-blue-500 focus:ring-2 focus:ring-blue-500">
                <play-icon class="p-1 text-red-600 rounded" />
                <div class="w-full">
                    <input v-model="video_url" type="text" label="search" name="search" autocomplete="off"
                        placeholder="Enter Video"
                        class="flex-none w-full px-2 py-1 text-black border-transparent border-none rounded focus:border-transparent focus:ring-0" />
                </div>
                <div class="rounded-r">
                    <button type="button" class="flex px-2 py-1 bg-red-600 rounded-r hover:bg-red-500 text-stone-50"
                        @click="play(video_url)">
                        Play
                    </button>
                </div>
            </div>
        </div>
        <div class="w-full p-2 rounded bg-slate-300 h-fit">
            <div class="w-full">
                <video-layout :source="video_url" />
            </div>
        </div>

        <div class="w-full p-2 my-1 rounded bg-slate-300 h-fit">
            <div class="bg-white rounded-lg shadow lg:w-1/3">
                <p class="p-3">
                    Video List
                </p>
                <ul class="divide-y divide-gray-100">
                    <li v-for="video in videos" :key="video" class="p-3 hover:bg-blue-600 hover:text-blue-200"
                        @click="copyURL(video)">
                        {{ video }}
                    </li>
                </ul>
            </div>
        </div>
    </div>

</template>

<script>
import PLayIcon from 'vue-material-design-icons/Play.vue';
import VideoLayout from '@/components/VideoPlayer/VideoLayout.vue';

import { ElNotification } from 'element-plus'

export default {
    name: 'VideoExample',
    created() {
        this.$emit('response', 'Videos'),
        this.$emit('search', false)
    },
    components: {
        VideoLayout,
        PLayIcon,
    },
    data() {
        return {
            video_url: this.$store.getters.getAssetUrl + 'videos/video_one.mp4',
            videos: [
                this.$store.getters.getAssetUrl + 'videos/video_zero.mp4',
                this.$store.getters.getAssetUrl + 'videos/video_one.mp4',
                this.$store.getters.getAssetUrl + 'videos/video_two.mp4',
            ],
            test: true,
        };
    },
    watch: {
        video_url: function () {
            this.test = false;
            this.play();
        }
    },
    methods: {
        async copyURL(video_url) {
            try {
                await navigator.clipboard.writeText(video_url);
                ElNotification({
                    title: 'Success',
                    message: 'Copied ' + video_url,
                    type: 'success',
                })
            } catch ($e) {
                alert('Cannot copy');
            }
        }, 
        play(  ) {
            this.test = true;
        }
    },
};
</script>