<template>

    <div class="absolute flex items-center justify-center w-full h-screen">

        <div class="items-center p-2 bg-white rounded-md w-96 border-slate-500">
            <h1 class="m-5 text-4xl font-bold text-center text-blue-600">
                Welcome to my <br>
                Vue 3 App
            </h1>
            <n-form autocomplete="off">

                <div class="m-1">
                    <el-input type="text" v-model="form_data.username" placeholder="username" class="w-50"
                        size="large" />
                </div>

                <div class="m-1">
                    <el-input type="password" size="large" name="password" placeholder="Password"
                        v-model="form_data.password" class="w-50" />
                </div>
                <div class="m-1">
                    <el-checkbox v-model="form_data.remember">Remember me</el-checkbox>
                </div>

                <div class="flex justify-center m-2 item-center">
                    <el-button type="primary" size="large" @click="login" >
                        Login
                    </el-button>
                    <!-- <it-button type="danger" size="big" round block @click="logout">Logout</it-button> -->
                </div>

            </n-form>
        </div>
    </div>


</template>
<script>

import { ElNotification } from 'element-plus';

export default {
    data() {
        return {
            processing: true,
            form_data: {
                username: '',
                password: '',
            },
        }
    },
    methods: {
        async login(e){
            e.preventDefault();

            this.processing = true;

            await this.$axios.get('/sanctum/csrf-cookie');

            await this.$axios.post('/api/login', this.form_data )
            .then(({data})=>{
                this.$store.commit( 'authenticateUser', data );
                this.$store.commit( 'setAuthUser', true );
                this.$router.push({ path: '/dashboard', redirect: '/dashboard' });
            }).catch(({response})=>{
                console.log(response);
                ElNotification({
                    title: 'Error',
                    message: response,
                    type: 'error',
                })
            }).finally(()=>{
                this.processing = false
            })
            
        },
        async logout(e){
            e.preventDefault();

            this.processing = true;

            await this.$axios.post('/api/logout').then(({data})=>{
                this.$store.commit( 'destroyAuthentication');
                // this.$router.push({ name: 'login', query: { redirect: '/login' } });
            }).catch(({response:{data}})=>{
                alert(data.message)
            }).finally(()=>{
                this.processing = false
            })
            
        },
       
    },
    
}
</script>
<style lang="">
    
</style>