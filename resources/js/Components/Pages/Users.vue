<template >

    <div class="w-full p-2 rounded-full">

        <div class="w-full p-2 rounded bg-slate-300 h-fit">
            {{ keywordSearch }}
            <table class="w-full bg-white border-none rounded table-auto border-spacing-3">
                <thead>
                    <tr>
                        <th class="p-2 ">Name</th>
                        <th class="p-2 ">Username</th>
                        <th class="p-2 ">Date created</th>
                        <th class="p-2 pr-8 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="p-2 border border-solid rounded hover:ring-2 hover:ring-blue-500 focus:ring-2 focus:ring-blue-500 text-black"
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

                <button type="button" class="flex rounded-lg bg-green-600 hover:bg-emerald-500 text-stone-50 p-3"
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
                <el-input v-model="v$.formdata.name.$model" type="text" placeholder="Name" autocomplete="off"
                    error="v$.formdata.name.$error" />
                <div class="text-red-600" v-if="v$.formdata.name.$error" v-for="error of v$.formdata.name.$errors"
                    :key="error.$uid">
                    <strong>{{ error.$message }}</strong>
                </div>
            </el-form-item>

            <el-form-item label="Username" prop="username">
                <el-input v-model="v$.formdata.username.$model" type="text" placeholder="username" autocomplete="off"
                    error="v$.formdata.username.$error" />
                <div class="text-red-600" v-if="v$.formdata.username.$error"
                    v-for="error of v$.formdata.username.$errors" :key="error.$uid">
                    <strong>{{ error.$message }}</strong>
                </div>
            </el-form-item>

            <el-form-item label="Password" prop="password">
                <el-input v-model="v$.formdata.password.$model" type="password" placeholder="password"
                    autocomplete="off" error="v$.formdata.password.$error" />
                <div class="text-red-600" v-if="v$.formdata.password.$error"
                    v-for="error of v$.formdata.password.$errors" :key="error.$uid">
                    <strong>{{ error.$message }}</strong>
                </div>
            </el-form-item>

            <el-form-item label="Confirm Password" prop="confirmPassword">
                <el-input v-model="v$.formdata.confirmPassword.$model" type="password" placeholder="Confirm password"
                    autocomplete="off" error="v$.formdata.confirmPassword.$error" />
                <div class="text-red-600" v-if="v$.formdata.confirmPassword.$error"
                    v-for="error of v$.formdata.confirmPassword.$errors" :key="error.$uid">
                    <strong>{{ error.$message }}</strong>
                </div>
            </el-form-item>

        </el-form>
        <template #footer class="bg-slate-200">
            <span class="dialog-footer ">
                <el-button @click="clearform()">Cancel</el-button>
                <el-button type="success" @click="submitForm()" :disabled="v$.$error && true" :loading="saving">Save
                </el-button>
            </span>
        </template>
    </el-dialog>

</template>
<script >
import moment from 'moment';
import { required, minLength, maxLength, sameAs } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import VueAdsPagination from 'vue-ads-pagination';
import { ElMessage, ElMessageBox } from 'element-plus'

import EditIcon from 'vue-material-design-icons/Pencil.vue';
import DeleteIcon from 'vue-material-design-icons/Delete.vue';
import PlusIcon from 'vue-material-design-icons/Plus.vue';

export default {
    setup: () => ({ v$: useVuelidate() }),
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
    validations() {
        return {
            formdata: {
                name: {
                    required,
                    minLength: minLength(2),
                },
                username: {
                    required,
                    minLength: minLength(2),
                    maxLength: maxLength(25),
                },
                password: {
                    required,
                    minLength: minLength(8),
                },
                confirmPassword: sameAs('password'),
            }
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

            console.log(this.keywordSearch);

            await this.$axios.post(url, this.keyword)
                .then(({ data }) => {
                    this.pagination = data;
                }).catch(({ response: { data } }) => {
                    alert(data.message)
                }).finally(() => {
                    this.processing = false
                });
        },
        addOrEdit(action, user) {
            this.action = action;
            this.openForm = true;

            action == 'add' ? this.clearform : this.formdata = user;

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
            return moment(value).add(+8, 'hours').format('DD MM YYYY hh:mm');
        },
        async save(form) {
            this.saving = true;
            await this.$axios.post('api/users/AddOrUpdate', form)
                .then(({ data }) => {
                    this.openForm = false;
                    this.search();
                }).catch(({ response: { data } }) => {
                    alert(data.message)
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
        'plus-icon': PlusIcon,
        VueAdsPagination,
    }

}
</script>
<style >
</style>