<template >

    <div class="w-full p-2 rounded-full">

        <div class="w-full p-2 rounded bg-slate-300 h-fit">
            {{keywordSearch}}
            <table class="w-full bg-white border-none rounded table-auto border-spacing-3">
                <thead>
                    <tr>
                        <th class="p-2 text-left">Product Name</th>
                        <th class="p-2 text-left">Category</th>
                        <th class="p-2 text-left">Description</th>
                        <th class="p-2 text-left">Date and time</th>
                        <th class="p-2 pr-8 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="p-2 text-black border border-solid rounded hover:ring-2 hover:ring-blue-500 focus:ring-2 focus:ring-blue-500"
                        v-for="(value, key) in pagination.data" :key="value.hash">

                        <td class="p-2 text-left"> {{ value.name }}</td>
                        <td class="p-2 text-left"> {{ value.category }}</td>
                        <td class="p-2 text-left"> {{ value.description }}</td>
                        <td class="p-2 text-left"> {{ value.date_and_time }}</td>

                        <td class="float-right">
                            <el-button text @click="addOrEdit('Edit', value)">
                                <edit-icon />
                            </el-button>
                            <el-button text @click="confirmDelete(value)">
                                <delete-icon />
                            </el-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-none w-full p-2">
            <div class="flex-none w-6/12 ">

                <button type="button" class="flex p-3 bg-green-600 rounded-lg hover:bg-emerald-500 text-stone-50"
                    @click="addOrEdit('Add')">
                    <plus-icon /> Add Product
                </button>
            </div>
            <div class="flex-none float-right w-6/12">
                <VuePaginationTw class="float-right" :totalItems="pagination.total"
                    :currentPage="pagination.current_page" :perPage="pagination.per_page" @pageChanged="search"
                    :goButton="false" styled="centered" borderActiveColor="border-red-500"
                    borderTextActiveColor="text-red-500" v-if="!processing" />
            </div>
        </div>
    </div>


    <el-dialog v-model="openForm" :title="action + ' Product'" width="20%" :close-on-click-modal="clearform">
        <el-form :label-position="top" label-width="100px" :model="formdata" :rules="rules">

            <el-form-item label="Name" prop="name">
                <el-input v-model="formdata.name" @blur="v$.formdata.name.$touch" type="text" placeholder="Name"
                    autocomplete="off" />

                <div class="text-red-600" v-for="error of v$.formdata.name.$errors" :key="error.$uid">
                    <strong>{{ error.$message }}</strong> <br />
                </div>
            </el-form-item>

            <el-steps :active="active" finish-status="success">
                <el-step title="Step 1" />
                <el-step title="Step 2" />
                <el-step title="Step 3" />
            </el-steps>

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
import { reactive } from 'vue'  
import useVuelidate from '@vuelidate/core'
import { required, minLength, maxLength } from '@vuelidate/validators';

import VueAdsPagination from 'vue-ads-pagination';
import { ElMessage, ElMessageBox, ElNotification } from 'element-plus'

import EditIcon from 'vue-material-design-icons/Pencil.vue';
import DeleteIcon from 'vue-material-design-icons/Delete.vue';
import PlusIcon from 'vue-material-design-icons/Plus.vue';


export default {
    setup() {
        return {
            v$: useVuelidate()
        }
    },
    validations() {
        return {
            formdata: {
                name: {
                    required,
                    minLength: minLength(2),
                    maxLength: maxLength(255),
                },
                category_id: {
                    required,
                },
                description: {
                    required,
                    minLength: minLength(2),
                    maxLength: maxLength(255),
                },
                date_and_time: {
                    required,
                },
            }
        }
    },
    created() {
        this.$emit('response', 'Categories'),
        this.$emit('search', true)
    },
    props: {
        keywordSearch: String
    },
    watch: {
        keywordSearch: function () { 
            this.search();
        }
    },
    data() {
        return {
            keyword: '',
            top: 'top',
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
                category_id: '',
                description: '',
                img_path: '',
                date_and_time: '',
            },
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
            
            var url = '/api/product/search?page=' + this.pagination.current_page;

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
        addOrEdit( action, product ){
            this.action = action;
            this.openForm = true;

            action == 'Edit' ? this.formdata = product : '';
        },
        clearform() {
            this.formdata = {
                name: '',
                category_id: '',
                description: '',
                img_path: '',
                date_and_time: '',
            };
        },
        submitForm() {
            this.v$.$validate() // checks all inputs

            if (!this.v$.$error)
                this.save(this.formdata);

        },
        async save( form ){
            this.saving = true;
            await this.$axios.post( 'api/product/AddOrUpdate', form )
            .then( ({ data }) => {
                this.openForm = false;
                this.search();
            } ).catch(({response:{data}})=>{

                ElNotification({
                    title: 'Error',
                    message: data.message,
                    type: 'error',
                })
            }).finally(()=>{
                this.saving = false
            });
        },
        confirmDelete( Product ){
            ElMessageBox.confirm(
                `Are you sure you want to delete ${ Product.name }?`,
                'Warning',
                {
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel',
                    type: 'warning',
                }
            )
            .then((action) => {
                console.log(action);
                this.remove(Product);
            })
            .catch((action) => {
                console.log(action + 'hello');

                ElMessage({
                    type: 'info',
                    message: 'Delete canceled',
                })
            })
        },
        async remove(Product) {

            await this.$axios.post('api/product/remove', Product)
                .then(({ data }) => {
                    ElMessage({
                        type: 'success',
                        message: 'Delete completed',
                    })
                    this.search();
                }).catch(({ response: { data } }) => {
                    ElMessage({
                        type: 'error',
                        message: 'Delete canceled',
                    })
                }).finally(() => {
                    this.saving = false
                });
        },
    },
    mounted() {
        this.search();
    },
    components: {
        'edit-icon': EditIcon,
        'delete-icon': DeleteIcon, 
        'plus-icon': PlusIcon, 
        VueAdsPagination,
    }
    
}
</script>
<style >
    
</style>