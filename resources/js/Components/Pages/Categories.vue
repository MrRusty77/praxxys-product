<template >

    <div class="w-full p-2 rounded-full">
    
        <div class="w-full p-2 m-2 rounded bg-slate-300 h-fit">
            <table class="w-full bg-white border-none rounded table-auto border-spacing-3">
                <thead>
                    <tr>
                        <th class="p-2">Category Name</th>
                        <th class="p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="p-2 border border-solid rounded hover:border-sky-500 hover:border-2"
                        v-for="(value, key) in pagination.data" :key="value.cathegory_id">
                        <td class="p-2"> {{ value.name }}</td>
                        <td class="float-right">
                            <el-button text @click="addOrEdit('Edit', value)">
                                <edit-icon />
                            </el-button>
                            <el-button text @click="remove(value)">
                                <delete-icon />
                            </el-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-none w-full">
            <div class="flex-none w-5/12">
                <el-button type="primary" :icon="Edit" @click="addOrEdit('Add')" round>Add Cathegory</el-button>
            </div>
            <div class="flex-none float-right w-5/12">
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
        this.$emit('response', 'Categories'),
        this.$emit('search', true)
    },
    props: {
        keywordSearch: String
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
            keyword: this.keywordSearch,
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

            if( this.keywordSearch )
                url+= '&keyword='+ this.keywordSearch;

            console.log(this.keywordSearch );

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