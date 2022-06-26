<template>
    <div>
        <video-player :options="videoOptions" :customClass="objectClass" />
    </div>
</template>

<script>
import VideoPlayer from '@/components/VideoPlayer/VideoPlayer.vue';

export default {
    name: 'VideoExample',
    props: {
        source: {
            type: String,
            default() {
                return '/videos/video_zero.mp4';
            }
        },
        objectClass: {
            type: String,
            default() {
                return { 'w-full m-auto round': true};
            }
        }
    },
    components: {
        VideoPlayer
    },
    watch: {
        source: function () {
            this.videoOptions = {
                autoplay: true,
                controls: true,
                sources: [
                    {
                        src: this.source,
                        type: 'video/mp4'
                    }
                ]
            }
        }
    },
    data() {
        return {
            videoOptions: {
                autoplay: true,
                controls: true,
                sources: [
                    {
                        src: this.source,
                        type: 'video/mp4'
                    }
                ]
            }
        };
    }
};
</script>