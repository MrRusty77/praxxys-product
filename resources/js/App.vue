<template>
    <div class="w-full h-screen bg-gradient-to-t from-cyan-500 to-blue-500">
        <router-view></router-view>
    </div>
</template>

<script>
    export default {

        mounted() {
            this.$store.commit('setAuthUser', window.auth_user);
            
            if( window.auth_user ) 
                this.$store.commit('authenticateUser', window.user);

        }

    }
</script>

