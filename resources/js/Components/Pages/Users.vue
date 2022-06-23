<template >

    <div class="w-full p-2 rounded-full">

        <div class="w-full p-2 rounded bg-slate-300 h-fit">
            {{ keywordSearch }}
            <table class="w-full bg-white border-none rounded table-auto border-spacing-3">
                <thead>
                    <tr>
                        <th class="p-2 text-left">Name</th>
                        <th class="p-2 text-left">Username</th>
                        <th class="p-2 text-left">Date created</th>
                        <th class="p-2 pr-8 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="p-2 text-black border border-solid rounded hover:ring-2 hover:ring-blue-500 focus:ring-2 focus:ring-blue-500"
                        v-for="(value, key) in pagination.data" :key="value.user_id">
                        <td class="p-2 text-left"> {{ value.name }}</td>
                        <td class="p-2 text-left"> {{ value.username }}</td>
                        <td class="p-2 text-left"> {{ formatdateTime(value.created_at) }}
                        </td>
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
                    <plus-icon /> Add user
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


    <el-dialog v-model="openForm" :title="action + ' User'" width="40%" :close-on-click-modal="clearform">
        <el-form :label-position="top" label-width="100px" :model="formdata" :rules="rules">

            <el-form-item label="Name" prop="name">
                <el-input v-model="formdata.name" @blur="v$.formdata.name.$touch" type="text" placeholder="Name"
                    autocomplete="off" />

                <div class="text-red-600" v-for="error of v$.formdata.name.$errors" :key="error.$uid">
                    <strong>{{ error.$message }}</strong> <br />
                </div>
            </el-form-item>

            <el-form-item label="Username" prop="username">
                <el-input v-model="formdata.username" @blur="v$.formdata.username.$touch" type="text"
                    placeholder="username" autocomplete="off" />

                <div class="text-red-600" v-for="error of v$.formdata.username.$errors" :key="error.$uid">
                    <strong>{{ error.$message }}</strong> <br />
                </div>
            </el-form-item>

            <el-form-item label="Password" prop="password">
                <el-input v-model="formdata.password" type="password" placeholder="password" autocomplete="off" />

                <div class="text-red-600" v-for="error of v$.formdata.password.$errors" :key="error.$uid">
                    <strong>{{ error.$message }}</strong> <br />
                </div>
            </el-form-item>

            <el-form-item label="Confirm Password" prop="confirmPassword">
                <el-input v-model="formdata.confirmPassword" type="password" placeholder="Confirm password"
                    autocomplete="off" />

                <div class="text-red-600" v-for="error of v$.formdata.confirmPassword.$errors" :key="error.$uid">
                    <strong>{{ error.$message }}</strong> <br />
                </div>
            </el-form-item>

        </el-form>
        <template #footer class="bg-slate-200">
            <span class="dialog-footer ">
                <el-button @click="clearform()">Cancel</el-button>
                <el-button type="success" @click="submitForm(  )" :disabled="v$.$error" :loading="saving">Save
                </el-button>
            </span>
        </template>
    </el-dialog>

</template>
<script >
import moment from 'moment';

import { reactive } from 'vue'
import useVuelidate from '@vuelidate/core'
import { required, minLength, maxLength, sameAs, and, or, helpers } from '@vuelidate/validators';

import VueAdsPagination from 'vue-ads-pagination';

import { ElMessage, ElMessageBox, ElNotification } from 'element-plus'

import EditIcon from 'vue-material-design-icons/Pencil.vue';
import DeleteIcon from 'vue-material-design-icons/Delete.vue';
import PlusIcon from 'vue-material-design-icons/Plus.vue';

const { withAsync } = helpers

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
                username: {
                    required,
                    minLength: minLength(2),
                    maxLength: maxLength(255),
                    // asyncValidator: and(withAsync(this.checkUsername)),
                    someProperty: withAsync(this.checkUsername),

                },
                password: {
                    required,
                    minLength: minLength(2),
                    maxLength: maxLength(255),
                },
                confirmPassword: {
                    required,
                    sameAs: sameAs(this.formdata.password),
                    minLength: minLength(2),
                    maxLength: maxLength(255),
                },
            }
        }
    },
    created() {
        this.$emit('response', 'Users'),
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
            pagination: {
                current_page: 1
            },
            processing: false,
            saving: false,
            openForm: false,
            keyword: this.keywordSearch,
            action: 'Add',
            formdata: {
                name: '',
                username: '',
                password: '',
                confirmPassword: '',
            },
        }
    },
    validationConfig: {
        $lazy: true,
        $autoDirty: true
    },
    methods: {
        async search(selectedPage) {

            this.processing = true;

            if (selectedPage !== undefined) this.pagination.current_page = selectedPage;

            var url = '/api/users/search?page=' + this.pagination.current_page;

            if (this.keywordSearch)
                url += '&keyword=' + this.keywordSearch;

            await this.$axios.post(url, this.keyword)
                .then(({ data }) => {
                    this.pagination = data;
                }).catch(({ response: { data } }) => {
                    // alert(data.message)
                }).finally(() => {
                    this.processing = false
                });
        },
        addOrEdit(action, user) {
            this.action = action;
            this.openForm = true;

            action == 'Edit' ? this.formdata = user : '';

        },
        clearform() {
            this.openForm = false;

            this.formdata = {
                name: '',
                username: '',
                password: '',
                confirmPassword: '',
            };
        },
        formatdateTime(value) {
            return moment(value).add(+8, 'hours').format('MM/DD/YYYY hh:mm');
        },
        async checkUsername() {
            await this.$axios.post('api/users/checkUsername', this.formdata)
                .then(({ data }) => {
                    return !(data === 'true');
                }).catch(({ response: { data } }) => {
                    // alert(data.message)
                }).finally(() => {
                    
                });
        },
        async save(form) {

            this.saving = true;
            await this.$axios.post('api/users/AddOrUpdate', form)
                .then(({ data }) => {
                    this.openForm = false;
                    this.search();
                }).catch(({ response: { data } }) => {
                    ElNotification({
                        title: 'Error',
                        message: 'Unable to save data, Please try again later',
                        type: 'error',
                    })
                }).finally(() => {
                    this.saving = false
                });
        },
        confirmDelete(user) {
            ElMessageBox.confirm(
                `Are you sure you want to delete ${user.name}?`,
                'Warning',
                {
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel',
                    type: 'warning',
                }
            )
                .then((action) => {
                    console.log(action);
                    this.remove(user);
                })
                .catch((action) => {
                    console.log(action + 'hello');

                    ElMessage({
                        type: 'info',
                        message: 'Delete canceled',
                    })
                })
        },
        async remove(user) {

            await this.$axios.post('api/users/remove', user)
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
        submitForm() {
            this.v$.$validate() 
            
            if (!this.v$.$error)
                this.save(this.formdata);
        }
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