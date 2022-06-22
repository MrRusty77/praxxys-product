<template >
    <div class="w-full p-2 rounded-full">
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
            <div class="flex w-full py-2 my-2 rounded-full hover:drop-shadow-md bg-slate-50">
                <div class="flex-none w-11/12 pl-3 text-base">
                    Category Name
                </div>
                <div class="flex-none w-1/12 text-center">
                    Actions
                </div>
            </div>
            <div v-for="(value, key) in pagination.data" :key="value.cathegory_id"
                class="flex w-full py-2 my-2 rounded-full hover:drop-shadow-md bg-slate-50">
                <div class="flex-none w-11/12 pl-3 text-base">
                    {{ value.name }}
                </div>
                <div class="flex-none w-1/12">
                    <div class="flex float-right">
                        <el-button text @click="addOrEdit('Edit', value)">
                            <edit-icon />
                        </el-button>
                        <el-button text @click="remove(value)">
                            <delete-icon />
                        </el-button>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-none w-full">
            <div class="flex-none w-5/12">
                <el-button type="primary" :icon="Edit" @click="addOrEdit('Add')" round>Add Cathegory</el-button>
            </div>
            <div class="flex-none w-5/12">
                <VuePaginationTw class="float-right" :totalItems="pagination.total"
                    :currentPage="pagination.current_page" :perPage="pagination.per_page" @pageChanged="search"
                    :goButton="false" styled="centered" borderActiveColor="border-red-500"
                    borderTextActiveColor="text-red-500" v-if="!processing" />
            </div>
        </div>
    </div>


    <el-dialog v-model="openForm" :title="action + ' Cathegory'" width="20%" :close-on-click-modal="clearform">
        <el-form :label-position="top" label-width="100px" :model="formdata" :rules="rules" style="max-width: 460px">
            <el-form-item label="Name" prop="name">
                <el-input v-model="v$.formdata.name.$model" type="text" placeholder="Name" autocomplete="off"
                    error="v$.formdata.name.$error" />
                <div class="text-red-600" v-if="v$.formdata.name.$error" v-for="error of v$.formdata.name.$errors"
                    :key="error.$uid">
                    <strong>{{ error.$message }}</strong>
                </div>
            </el-form-item>

        </el-form>
        <template #footer class="bg-slate-200">
            <span class="dialog-footer ">
                <el-button @click="openForm = false">Cancel</el-button>
                <el-button type="success" @click="submitForm()" :disabled="v$.$error && true" :loading="saving">Save
                </el-button>
            </span>
        </template>
    </el-dialog>

</template>
<script >
import { reactive, ref } from 'vue';
import { required, minLength, maxLength } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import VueAdsPagination from 'vue-ads-pagination';

import EditIcon from 'vue-material-design-icons/Pencil.vue';
import DeleteIcon from 'vue-material-design-icons/Delete.vue';

export default {
    setup: () => ({ v$: useVuelidate() }),
    created() {
        this.$emit('response', 'Categories')
    },
    data() {
        return {
            keyword: '',
            pagination:{
                current_page: 1
            },
            processing: false,
            saving: false,
            openForm: false,
            keyword: '',
            action: 'Add',
            formdata: {
                name: '',
            },
        }
    },
    validations() {
        return {
            formdata: {
                name: { 
                    required,
                    minLength: minLength(2),
                }
            }
        }
    },
    validationConfig: {
        $lazy: true,
        $autoDirty: true
    },
    methods: {
        async search( selectedPage ) {
             
            this.processing = true;

            if( selectedPage !== undefined ) this.pagination.current_page = selectedPage;
            
            var url = '/api/cathegory/search?page=' + this.pagination.current_page;

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

            action == 'add' ? this.clearform : this.formdata = cathegory;
            
        },
        clearform() {
            this.formdata = {
                name: '',
            };
        },
        async save( form ){
            this.saving = true;
            await this.$axios.post( 'api/cathegory/AddOrUpdate', form )
            .then( ({ data }) => {
                this.openForm = false;
                this.search();
            } ).catch(({response:{data}})=>{
                alert(data.message)
            }).finally(()=>{
                this.saving = false
            });
        },
        remove(cathegory){
            alert( cathegory );
        },
        submitForm() {
            this.v$.$validate() // checks all inputs

            if (!this.v$.$error) { // if ANY fail validation
                this.save(this.formdata);
            } else {
                alert('Form successfully submitted.')
            }
        }
    },
    mounted() {
        this.search();
    },
    components: {
        'edit-icon': EditIcon,
        'delete-icon': DeleteIcon, 
        VueAdsPagination,
    }
    
}
</script>
<style >
    
</style>