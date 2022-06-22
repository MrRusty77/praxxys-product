<template >
    <div class="flex w-full p-2 rounded-full bg-slate-300">
        <div class="flex-1 p-1 w-50">
            <input v-model="keyword" type="text" label="search" name="search" autocomplete="off"
                class="flex-none w-full px-2 py-1 border-none rounded-full focus-visible:border-transparent focus-visible:outline-0" />
        </div>
        <div class="flex-1 p-1 w-50">
            <it-button type="primary" icon="search" round block @click="search(pagination.current_page)">search
            </it-button>
        </div>
    </div>

    <div class="w-full p-2 m-2 rounded-lg bg-slate-300 h-fit">
        <div v-for="(value, key) in pagination.data" :key="value.cathegory_id"
            class="flex w-full py-2 my-2 rounded-full hover:drop-shadow-md bg-slate-50">
            <div class="flex-none w-11/12 pl-3 text-lg">
                {{ value.name }}
            </div>
            <div class="flex-none w-1/12">
                <div class="flex">
                    <it-button icon="edit" lable="edit" @click="addOrEdit( 'Edit', value)" />
                    <it-button icon="delete" lable="delete" @click="remove(value)" />
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-none w-full">
        <div class="flex-none w-5/12">
            <el-button type="primary" :icon="Edit" @click="addOrEdit('Add')">Add Cathegory</el-button>
        </div>
        <div class="flex-none w-5/12">
            <el-pagination layout="prev, pager, next" :total="pagination.last_page" :page-size="pagination.per_page"
                :page-count="pagination.per_page" :current-page="pagination.current_page" />
            <!-- <VuePaginationTw 
                class="float-right"
                :totalItems="pagination.last_page"
                :currentPage="pagination.current_page"
                :perPage="pagination.per_page"
                @pageChanged="search"
                :goButton="false"
                styled="centered"
                v-if="!processing"
            /> -->
        </div>
    </div>

    <el-dialog v-model="openForm" title="Shipping address">
        <el-form :label-position="right" label-width="100px" :model="formdata" :rules="rules" style="max-width: 460px">
            <el-form-item label="Name" prop="name">
                <!-- <el-input v-model="formdata.name" type="text" /> -->
                <input type="text" placeholder="name" v-model="name" />
            </el-form-item>

            {{ v$.$error }}
            <p v-for="(error, index) of v$.$errors" :key="index">
                <strong>{{ error.$validator }}</strong>
                <small> on property</small>
                <strong>{{ error.$property }}</strong>
                <small> says:</small>
                <strong>{{ error.$message }}</strong>
            </p>

            <el-form-item label="Password" prop="pass">
                <el-input v-model="formdata.pass" type="password" autocomplete="off" />
            </el-form-item>
        </el-form>
        <template #footer>
            <span class="dialog-footer">
                <el-button @click="dialogFormVisible = false">Cancel</el-button>
                <el-button type="primary" @click="submitForm()">Confirm
                </el-button>
            </span>
        </template>
    </el-dialog>

</template>
<script >
import { reactive, ref } from 'vue';
import { email, required } from '@vuelidate/validators'
import { useVuelidate } from '@vuelidate/core'

// const formRef = ref < FormInstance > ();

export default {
    data() {
        return {
            keyword: '',
            cathegories_data: {},
            pagination:{},
            processing: false,
            openForm: false,
            keyword: '',
            action: 'Add',
            formdata:{
                name:'',
                pass:'',
            },
            v$: useVuelidate(),
        }
    },
    validations() {
        return {
            name: { required },
        }
    },
    methods: {
        async search( selectedPage ) {
             
            this.processing = true;

            if( selectedPage !== undefined ) this.pagination.current_page = selectedPage;
            
            var url = '/api/cathegory/search?page=' + this.pagination.current_page;

            console.log(this.keyword);

            if( this.keyword )
                url+= '&keyword='+ this.keyword;

            await this.$axios.post(url, this.keyword)
            .then( ({ data }) => {
                this.pagination = data;
            } ).catch(({response:{data}})=>{
                alert(data.message)
            }).finally(()=>{
                this.processing = false
            });
        },
        addOrEdit( action, cathegory ){
            this.action = action;
            this.openForm = true;

            if( cathegory !== undefined ) this.form = cathegory;
            
        },
        async save( form ){
            
            await this.$axios.post( 'api/cathegory/AddOrUpdate', form )
            .then( ({ data }) => {
                this.openForm = false;
                this.search();
            } ).catch(({response:{data}})=>{
                alert(data.message)
            }).finally(()=>{
                this.processing = false
            });
        },
        remove(cathegory){
            alert( cathegory );
        },
        submitForm() {
            this.v$.$validate() // checks all inputs
            console.log(this.v$.$validate() );
            if (!this.v$.$error) { // if ANY fail validation
                alert('Form successfully submitted.')
            } else {
                alert('Form failed validation')
            }
        }
    },
    mounted() {
        this.search()
    }
    
}
</script>
<style >
    
</style>