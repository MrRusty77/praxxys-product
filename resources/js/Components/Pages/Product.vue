<template >

    <div class="w-full p-2 rounded-full">

        <div class="w-full p-2 rounded bg-slate-300 h-fit">
            {{keywordSearch}}
            <table class="w-full bg-white border-none rounded table-auto border-spacing-3">
                <thead>
                    <tr>
                        <th class="p-2 text-left">Code</th>
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

                        <td class="p-2 text-left"> {{ value.code }}</td>
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


    <el-dialog v-model="openForm" :title="action + ' Product'" width="50%" :close-on-click-modal="clearform">

        <div class="w-full">
            <el-steps :active=" active_form" finish-status="success">
                <el-step title="Step 1" />
                <el-step title="Step 2" />
                <el-step title="Step 3" />
            </el-steps>
        </div>

        <div class="step-0" v-show="active_form == 0">
            <el-form :label-position="top" label-width="100px" :model="formdata" :rules="rules">

                <el-form-item label="Product Code" prop="Code">
                    <el-input v-model="formdata.code" type="text" placeholder="Product Code" autocomplete="off"
                        :readonly='true' />
                </el-form-item>

                <el-select v-model="formdata.category_id" class="m-2" placeholder="Select" size="large">
                    <el-option v-for="category in categories" :key="category.category_id" :label="category.name"
                        :value="category.category_id" />
                </el-select>

                <el-form-item label="Name" prop="name">
                    <el-input v-model="formdata.name" @blur="v$.formdata.name.$touch" type="text" placeholder="Name"
                        autocomplete="off" />

                    <div class="text-red-600" v-for="error of v$.formdata.name.$errors" :key="error.$uid">
                        <strong>{{ error.$message }}</strong> <br />
                    </div>
                </el-form-item>

                <el-form-item label="Description" prop="name">
                    <el-input v-model="formdata.description" @blur="v$.formdata.description.$touch" :rows="5"
                        type="textarea" placeholder="Please input" />

                    <div class="text-red-600" v-for="error of v$.formdata.description.$errors" :key="error.$uid">
                        <strong>{{ error.$message }}</strong> <br />
                    </div>
                </el-form-item>

                <!-- <editor-content :editor="editor" /> -->
                <div class="block w-full h-6/12">
                    <div class="w-6/12 ">
                        <button type="button"
                            class="flex float-left px-1 py-2 bg-white rounded text-slate-400 hover:text-slate-500"
                            @click="active_form = 0">
                            Previou step
                        </button>
                    </div>
                    <div class="w-6/12 ">

                        <button type="button"
                            class="flex float-left px-1 py-2 bg-green-300 rounded text-slate-500 hover:bg-green-500"
                            @click="active_form = 1">
                            Next step
                        </button>
                    </div>
                </div>
            </el-form>
        </div>

        <div class="w-full step-1" v-show="active_form == 1">

            <input type="file" @change="photoOnChange" />
            <button type="submit" @click="selectFile"> upload</button>

            <div class="flex items-center justify-center w-full h-screen bg-grey-lighter">
                <label
                    class="flex flex-col items-center w-64 px-4 py-6 tracking-wide uppercase bg-white border rounded-lg shadow-lg cursor-pointer text-blue border-blue hover:bg-blue hover:text-white">
                    <span class="mt-2 text-base leading-normal">Upload Image</span>
                    <input type='file' class="hidden" />
                </label>
            </div>
        </div>

        <template #footer class="bg-slate-200">
            <span class="dialog-footer ">
                <el-button @click="openForm = false">Cancel</el-button>
                <!-- <el-button type="success" @click="submitForm()" :disabled="v$.$error && true" :loading="saving">Save -->
                <!-- </el-button> -->
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

import { Editor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'

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
                code: this.randomInteger(10000000, 99999999),
                category_id: '',
                description: '',
                img_path: '',
                date_and_time: '',
            },
            active_form: 0,
            editor: null,
        }
    },
    validationConfig: {
        $lazy: true,
        $autoDirty: true
    },
    mounted() {
        this.editor = new Editor({
            content: '<p>I’m running Tiptap with Vue.js. 🎉</p>',
            extensions: [
                StarterKit.configure({
                    heading: {
                        levels: [1, 2, 3],
                    },
                }),
            ],
        });
        this.search();
    },
    beforeMount() {
        this.getCategories();
        // this.editor.destroy();
    },
    methods: {
        async getCategories(){
            await this.$axios.get('api/category/get')
                .then(({ data }) => {
                    this.categories = data;
                }).catch(({ response: { data } }) => {
                    alert(data.message)
                }).finally(() => {
                    this.processing = false
                });
        },
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
        randomInteger(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        },
        addOrEdit( action, product ){
            this.action = action;
            this.openForm = true;

            action == 'Edit' ? this.formdata = product : '';
        },
        next(){
            if ( this.active_form++ > 2 ) this.active_form = 2;
        },
        back(){
            if ( this.active_form-- < 0 ) this.active_form = 0;
        },
        photoOnChange(e) {
            this.image = e.target.files[0];
        },
        async selectFile(e) {
            
            e.preventDefault();

            let existingObj = this;

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            
            const Imagedata = new FormData();

            Imagedata.append('image', this.image);

            console.log(Imagedata );

            await this.$axios.post('api/product/uploadImg', Imagedata, config)
                .then(function (res) {
                    existingObj.success = res.data.success;
                })
                .catch(function (err) {
                    existingObj.output = err;
                });

        },
        clearform() {
            this.formdata = {
                name: '',
                code: this.randomInteger(10000000, 99999999),
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
    components: {
        'edit-icon': EditIcon,
        'delete-icon': DeleteIcon, 
        'plus-icon': PlusIcon, 
        VueAdsPagination,
        EditorContent,
    }
    
}
</script>
<style >
    
</style>