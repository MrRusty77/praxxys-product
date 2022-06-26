<template>
    <div>
        <video ref="videoPlayer" class="video-js" :class="customClass"></video>
    </div>
</template>

<script>
import videojs from 'video.js';

export default {
    name: 'VideoPlayer',
    props: {
        options: {
            type: Object,
            default() {
                return {};
            }
        },
        customClass: {
            type: String,
            default() {
                return { 'w-full m-auto': true };
            }
        }
    },
    data() {
        return {
            player: null
        }
    },
    watch: {
        options: function () {
            this.player.src(this.options.sources) 
        }
    },
    mounted() {
        this.player = videojs(this.$refs.videoPlayer, this.options);
    },
    beforeDestroy() {
        if (this.player) {
            this.player.dispose();
        }
    }
}
</script>