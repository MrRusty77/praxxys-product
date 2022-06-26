<template >

    <div class="w-full p-2 rounded-full">

        <LexicalComposer :initial-config="config" @error="onError">
            <LexicalPlainTextPlugin>
                <template #contentEditable>
                    <LexicalContentEditable />
                </template>
                <template #placeholder>
                    <div>
                        Enter some text...
                    </div>
                </template>
            </LexicalPlainTextPlugin>
            <LexicalOnChangePlugin v-model="content" @change="onChange" />
            <LexicalHistoryPlugin />
            <LexicalAutoFocusPlugin />
        </LexicalComposer>
        <div class="w-full p-2 rounded bg-slate-300 h-fit">

            <div class="inline-block w-full py-1">
                <el-select class="float-right" v-model="filter_category" placeholder="Select category" size="large"
                    @change="search()">
                    <el-option :label="'All categoty'" :value="null"></el-option>

                    <el-option v-for="category in categories" :key="category.category_id" :label="category.name"
                        :value="category.category_id" />
                </el-select>
            </div>

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
            <div class="flex-none float-right w-6/12" v-if="!processing">
                <VuePaginationTw class="float-right" :totalItems="pagination.total"
                    :currentPage="pagination.current_page" :perPage="pagination.per_page" @pageChanged="search"
                    :goButton="false" styled="centered" borderActiveColor="border-red-500"
                    borderTextActiveColor="text-red-500" />
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
            <el-form :label-position="top" label-width="100px">

                <el-form-item label="Product Code" prop="Code">
                    <el-input v-model="formData.code" type="text" placeholder="Product Code" autocomplete="off"
                        :readonly='true' />
                </el-form-item>

                <el-form-item label="Select category" prop="">
                    <el-select class="w-full" v-model="formData.category_id" placeholder="Select category" size="large">
                        <el-option v-for="category in categories" :key="category.category_id" :label="category.name"
                            :value="category.category_id" />
                    </el-select>

                    <div class="text-red-600" v-for="error of v$.formData.category_id.$errors" :key="error.$uid">
                        <strong>{{ error.$message }}</strong> <br />
                    </div>
                </el-form-item>

                <el-form-item label="Name" prop="name">
                    <el-input v-model="formData.name" @blur="v$.formData.name.$touch" type="text" placeholder="Name"
                        autocomplete="off" />

                    <div class="text-red-600" v-for="error of v$.formData.name.$errors" :key="error.$uid">
                        <strong>{{ error.$message }}</strong> <br />
                    </div>
                </el-form-item>

                <el-form-item label="Description" prop="name">
                    <!-- <editor-content :editor="editor" /> -->

                    <el-input v-model="formData.description" @blur="v$.formData.description.$touch" :rows="5"
                        type="textarea" placeholder="Please input" />

                    <div class="text-red-600" v-for="error of v$.formData.description.$errors" :key="error.$uid">
                        <strong>{{ error.$message }}</strong> <br />
                    </div>
                </el-form-item>

                <div class="flex w-full h-6/12">
                    <div class="w-6/12 ">
                        <!-- <el-button class="float-left" type="info" @click="active_form = 0">Previous</el-button> -->
                    </div>
                    <div class="w-6/12 ">
                        <el-button class="float-right" type="primary" @click="step0Form()"> Next</el-button>
                    </div>
                </div>

            </el-form>
        </div>

        <div class="w-full step-1" v-show="active_form == 1">

            <div class="inline-flex block w-full m-2 overflow-x-scroll h-60">
                <div class="p-1 m-1 !w-1/4 bg-slate-300 rounded !max-h-50 " v-for="image in this.formData.images"
                    :key="image.path">
                    <div class="relative w-fit !h-40 inline-block m-auto bg-slate-500 " v-if="image.status == 'active'">
                        <img class="!h-40" :src="'images/' + image.path" alt="product image" />
                        <div class="w-full p-2">
                            <div class="my-auto">
                                <el-button type="danger" @click="removeImage(image)">Remove
                                </el-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center w-full h-fit bg-grey-lighter">
                <label
                    class="flex flex-col items-center px-4 py-2 tracking-wide uppercase bg-white border rounded-lg shadow-lg cursor-pointer w-fit text-blue border-blue hover:bg-blue hover:text-white hover:bg-sky-500">
                    <span class="text-base leading-normal">Upload Image</span>
                    <input type='file' ref="imageUpload" accept="image/*" class="hidden" @change="photoOnChange" />
                </label>
            </div>

            <div class="flex w-full h-6/12">
                <div class="w-6/12 ">
                    <el-button class="float-left" type="info" @click="active_form = 0">Previous</el-button>
                </div>
                <div class="w-6/12 ">
                    <el-button class="float-right" type="primary" @click="step1Form">Next</el-button>
                </div>
            </div>
        </div>

        <div class="w-full step-1" v-show="active_form == 2">

            <el-form :label-position="top" label-width="100px">
                <el-form-item label="Select category" prop="">
                    <el-date-picker class="w-full" v-model="formData.date_and_time" type="datetime"
                        placeholder="Select date and time" :default-time="defaultTime" />

                    <div class="text-red-600" v-for="error of v$.formData.date_and_time.$errors" :key="error.$uid">
                        <strong>{{ error.$message }}</strong> <br />
                    </div>
                </el-form-item>
            </el-form>

            <div class="flex w-full h-6/12">
                <div class="w-6/12 ">
                    <el-button class="float-left" type="info" @click="active_form = 1">Previous</el-button>
                </div>
                <div class="w-6/12 ">
                    <el-button class="float-right" type="primary" @click="step2Form">Save</el-button>
                </div>
            </div>
        </div>

        <template #footer class="bg-slate-200">
            <span class="dialog-footer ">
                <el-button @click="openForm = false">Cancel</el-button>
                <!-- <el-button type="success" @click="step0Form()" :disabled="v$.$error && true" :loading="saving">Save -->
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

import { $getRoot, $getSelection } from 'lexical'

import {
    LexicalAutoFocusPlugin,
    LexicalComposer,
    LexicalContentEditable,
    LexicalHistoryPlugin,
    LexicalOnChangePlugin,
    LexicalPlainTextPlugin,
} from 'lexical-vue'


export default {
    setup() {
        return {
            v$: useVuelidate()
        }
    },
    validations() {
        return {
            formData: {
                name: {
                    required,
                    minLength: minLength(2),
                    maxLength: maxLength(255),
                },
                code: {
                    required,
                    minLength: minLength(8),
                    maxLength: maxLength(8),
                },
                category_id: {
                    required,
                },
                description: {
                    required,
                    minLength: minLength(2),
                    maxLength: maxLength(255),
                },
                date_and_time: { required } 
            },
        }
    },
    created() {
        this.$emit('response', 'Products'),
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
            filter_category: null,
            pagination:{
                total: 1,
                current_page: 1,
                per_page: 1,
            },
            processing: false,
            saving: false,
            openForm: false,
            keyword: this.keywordSearch,
            action: 'Add',
            formData: {
                name: '',
                code: this.randomInteger(10000000, 99999999),
                category_id: '',
                description: '',
                date_and_time: new Date() ,
                images: [ { path: "milk_carton.png"} ],
            },
            active_form: 0,
            editor: null,
            show_image: true,
            defaultTime: new Date(),
            content: '',
            config: {
                theme: {
                    
                },
                onError(error) {
                    console.error(error)
                },
            }
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
    },
    beforeMount() {
        this.getCategories();
        this.search();
        // this.editor.destroy();
    },
    methods: {
        async getCategories(){
            await this.$axios.get('api/category/get')
                .then(({ data }) => {
                    this.categories = data;
                }).catch(({ response: { data } }) => {
                    ElNotification({
                        title: 'Error',
                        message: 'Unable to retrieve categorie. Please try again later',
                        type: 'error',
                    })
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

            if (this.filter_category )
                url += '&category_id=' + this.filter_category;

            await this.$axios.post(url, this.keyword)
            .then( ({ data }) => {
                this.pagination = data;
                this.processing = false;
            } ).catch(({response:{data}})=>{
                ElNotification({
                    title: 'Error',
                    message: 'Unable to retrieve data. Please try again later',
                    type: 'error',
                })
                this.processing = false;
            }).finally(()=>{
            });
        },
        randomInteger(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        },
        async addOrEdit( action, product ){
            this.action = action;
            this.openForm = true;

            if (action == 'Edit') {
                this.formData = product;
                this.formData.date_and_time = new Date(product.date_and_time);

                this.formData.images = await this.$axios.post('api/images/get', product)
                    .then(({ data }) => {
                        return data;
                    }).catch(({ response: { data } }) => {
                        ElMessage({
                            type: 'error',
                            message: 'Delete canceled',
                        })
                    });
            }
        },
        async getProductImages( product ) {

            await this.$axios.post('api/images/get', product)
                .then(({ data }) => {
                    return data;
                }).catch(({ response: { data } }) => {
                    ElMessage({
                        type: 'error',
                        message: 'Delete canceled',
                    })
                });
        },
        onChange(editorState) {
            editorState.read(() => {
                // Read the contents of the EditorState here.
                const root = $getRoot()
                const selection = $getSelection()

                console.log(root, selection)
            })
        },
        async photoOnChange(e) {
            
            this.show_image = true;

            const Imagedata = new FormData();


            Imagedata.append('image', e.target.files[ 0 ]);

            console.log(Imagedata );
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            
            this.formData.images.push({
                path: await this.$axios.post('api/product/uploadImg', Imagedata, config)
                        .then(function (response) {
                            return response.data.image_path
                        })
                        .catch(function (err) {
                            ElNotification({
                                title: 'Error',
                                message: err,
                                type: 'error',
                            })
                            return null;
                        }) ,
                status: 'active'
            });
            
            this.$refs.imageUpload.value = null;

        },
        removeImage( image ){

            if ( image?.image_id ) {

                let findParams = this.check_in_images('path', image.path);
                let index = this.formData.images.findIndex(findParams);
    
                this.formData.images[index].status = "delete";
            } else {
                this.formData.images = this.formData.images.filter(object => {
                    return object.path !== image.path;
                })
            }

        },
        check_in_images(key, value) {
            return (item, i) => item[key] === value;
        },
        clearform() {
            this.active_form = 0;
            this.formData = {
                name: '',
                code: this.randomInteger(10000000, 99999999),
                category_id: '',
                description: '',
                date_and_time: new Date(),
                images: [{ path: "milk_carton.png" }],
            };
        },
        step0Form() {
            this.v$.formData.name.$validate();
            this.v$.formData.code.$validate();
            this.v$.formData.category_id.$validate();
            this.v$.formData.description.$validate();

            if (!this.v$.formData.name.$error && !this.v$.formData.code.$error && !this.v$.formData.category_id.$error && !this.v$.formData.description.$error)
                this.active_form = 1;
        },
        step1Form() {
            this.active_form = 2;
        },
        step2Form() {
            this.v$.formData.$validate() 

            if (!this.v$.formData.$error)
                this.save(this.formData);
                
        },
        async save( form ){
            this.saving = true;
            await this.$axios.post( 'api/product/AddOrUpdate', form )
            .then( ({ data }) => {

                ElNotification({
                    title: 'Success',
                    message: data.message,
                    type: 'success',
                })

                this.openForm = false;
                this.search();
                this.clearform();
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
        confirmDelete( product ){
            ElMessageBox.confirm(
                `Are you sure you want to delete ${ product.name }?`,
                'Warning',
                {
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel',
                    type: 'warning',
                }
            )
            .then((action) => {
                this.remove(product);
            })
            .catch((action) => {
                console.log(action + 'hello');

                ElMessage({
                    type: 'info',
                    message: 'Delete canceled',
                })
            })
        },
        async remove(product) {

            await this.$axios.post('api/product/remove', product)
                .then(({ data }) => {
                    ElMessage({
                        type: 'success',
                        message: 'Delete completed',
                    })
                    this.search(1);
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