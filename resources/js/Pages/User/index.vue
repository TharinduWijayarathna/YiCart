<template>
    <AppLayout title="User Management">
        <template #content>
            <div class="flex-grow-1 p-0 page-top">
                <div class="row content-margin2">
                    <div class="col-lg-12 mt-20 mt-lg-0">
                        <div class="d-flex justify-content-start align-items-center col-form-label mt-5 mt-lg-0">
                            <h1 style="margin-right: auto; font-size: 28px; color: #071437">
                                User Management
                            </h1>
                            <button class="btn btn-light-primary" style="font-weight: bold" data-bs-toggle="modal"
                                data-bs-target="#userModal">
                                <i class="bi bi-plus-circle"></i> ADD NEW
                            </button>
                        </div>
                        <div class="card shadow">
                            <div class="py-3 text-sm card-body">
                                <!-- Filters -->
                                <div class="row align-items-center mb-3 mt-3">
                                    <div class="col-md-2 mb-2 mb-md-0">
                                        <div for="purchase_uom" class="col-form-label text-gray-600">SEARCH</div>
                                        <input v-model="search" type="text" class="form-control form-control-sm"
                                            placeholder="Search" @keyup="getSearch" />
                                    </div>
                                    <div class="col-md-1 align-self-end">
                                        <button @click="clearFilters" class="square-clear-button p-5">
                                            <i class="fa fa-refresh" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="col-md-7 mb-2 mb-md-0"></div>

                                    <div class="col-md-2 d-flex justify-content-end align-self-end">
                                        <div class="dataTables_length" id="kt_ecommerce_products_table_length">
                                            <label><select name="kt_ecommerce_products_table_length"
                                                    aria-controls="kt_ecommerce_products_table"
                                                    class="form-select form-select-sm form-select-solid" :value="2"
                                                    v-model="pageCount" @change="perPageChange">
                                                    <option v-for="perPageCount in perPage" :key="perPageCount"
                                                        :value="perPageCount" v-text="perPageCount" />
                                                </select></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Customer Table -->
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5 mt-5">
                                            <thead>
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                    <th class="ps-3 text-center">Status</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                                <tr v-for="user in users">
                                                    <td class="py-2 ps-3 text-center">
                                                        <span v-if="user.deleted_at != null"
                                                            class="badge badge-light-danger">Inactive</span>
                                                        <span v-if="user.deleted_at == null"
                                                            class="badge badge-light-success">Active</span>
                                                    </td>
                                                    <td class="py-2">{{ user.name }}</td>
                                                    <td class="py-2">{{ user.email }}</td>
                                                    <td v-if="user.user_role_id == 1" class="py-2">Admin</td>
                                                    <td v-if="user.user_role_id == 0" class="py-2">Cashier</td>
                                                    <td class="text-end pe-1 py-2">
                                                        <a v-if="user.deleted_at == null" href="javascript:void(0)"
                                                            class="p-2" @click="editUser(user.id)">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </a>
                                                        <a v-if="user.deleted_at == null" href="javascript:void(0)"
                                                            class="p-2" @click="deleteUser(user.id)">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </a>
                                                        <a v-if="user.deleted_at != null" href="javascript:void(0)"
                                                            class="p-2" @click="restoreUser(user.id)">
                                                            <i class="bi bi-arrow-clockwise"></i>
                                                        </a>
                                                    </td>
                                                </tr>

                                                <!-- End of Table Data Rows -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Pagination -->
                                <div class="row my-3">

                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <div class="dataTables_paginate paging_simple_numbers"
                                            id="kt_ecommerce_sales_table_paginate">
                                            <ul class="pagination">
                                                <li class="paginate_button page-item previous"
                                                    :class="pagination.current_page == 1 ? 'disabled' : ''"
                                                    id="kt_ecommerce_sales_table_previous"><a href="javascript:void(0)"
                                                        @click="setPage(pagination.current_page - 1)"
                                                        aria-controls="kt_ecommerce_sales_table" data-dt-idx="0"
                                                        tabindex="0" class="page-link"><i class="previous"></i></a></li>
                                                <template v-for="(page, index) in pagination.last_page">
                                                    <template
                                                        v-if="page == 1 || page == pagination.last_page || Math.abs(page - pagination.current_page) < 5">
                                                        <li class="paginate_button page-item" :key="index"
                                                            :class="pagination.current_page == page ? 'active' : ''"><a
                                                                href="javascript:void(0)" @click="setPage(page)"
                                                                aria-controls="kt_ecommerce_sales_table" data-dt-idx="1"
                                                                tabindex="0" class="page-link">{{ page }}</a></li>
                                                    </template>
                                                </template>
                                                <li class="paginate_button page-item next"
                                                    :class="pagination.current_page == pagination.last_page ? 'disabled' : ''"
                                                    id="kt_ecommerce_sales_table_next"><a href="javascript:void(0)"
                                                        @click="setPage(pagination.current_page + 1)"
                                                        aria-controls="kt_ecommerce_sales_table" data-dt-idx="6"
                                                        tabindex="0" class="page-link"><i class="next"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <template #modal>
            <!-- Add User Modal -->
            <div class="modal fade" id="userModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-8 mb-5">
                                    <h5 class="modal-title" style="color: #071437">New User</h5>
                                </div>
                                <div class="col-4 mb-5 text-end">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                            <form @submit.prevent="createUser" enctype="multipart/form-data">
                                <div class="col-form-label text-gray-600">Name</div>
                                <input v-model="new_user.name" type="text" class="form-control form-control-sm"
                                    placeholder="Name" />

                                <div class="col-form-label text-gray-600">Email</div>
                                <input v-model="new_user.email" type="text" class="form-control form-control-sm"
                                    placeholder="Email" />

                                <div class="col-form-label text-gray-600">Password</div>
                                <input v-model="new_user.password" type="password" name="password" id="password"
                                    class="form-control form-control-sm" placeholder="Password" />

                                <div class="col-form-label text-gray-600">Confirm Password</div>
                                <input v-model="new_user.con_password" type="password" name="password" id="password"
                                    class="form-control form-control-sm" placeholder="Password" />

                                <div class="col-form-label text-gray-600">User Role</div>
                                <!-- <Multiselect v-model="select_user_role" :options="user_roles" class="z__index"
                                    :showLabels="false" :close-on-select="true" :clear-on-select="false" :searchable="true"
                                    placeholder="Select User Role" label="name" track-by="id" /> -->
                                <select v-model="new_user.user_role_id" class="form-select form-select-sm"
                                    aria-label="Default select example">
                                    <option selected>Select Role</option>
                                    <option value="1">Admin</option>
                                    <option value="0">Cashier</option>
                                </select>
                                <div class="row">
                                    <div class="col-12 mt-4 text-end">
                                        <button type="submit" class="btn btn-light-primary me-2 mt-2"
                                            style="font-weight: bold">
                                            CREATE
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update User Modal -->
            <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-8 mb-5">
                                    <h5 class="modal-title" style="color: #071437">Update User</h5>
                                </div>
                                <div class="col-4 mb-5 text-end">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                            <form @submit.prevent="updateUser" enctype="multipart/form-data">
                                <div class="col-form-label text-gray-600">Name</div>
                                <input v-model="edit_user.name" type="text" class="form-control form-control-sm"
                                    placeholder="Name" />

                                <div class="col-form-label text-gray-600">Email</div>
                                <input v-model="edit_user.email" type="text" class="form-control form-control-sm"
                                    placeholder="Name" />

                                <div class="col-form-label text-gray-600">Password</div>
                                <input v-model="edit_user.password" type="password" name="password" id="password"
                                    class="form-control form-control-sm" placeholder="Password" />

                                <div class="col-form-label text-gray-600">Confirm Password</div>
                                <input v-model="edit_user.con_password" type="password" name="password" id="password"
                                    class="form-control form-control-sm" placeholder="Password" />

                                <div class="col-form-label text-gray-600">User Role</div>
                                <!-- <Multiselect v-model="select_edit_user_role" :options="user_roles" class="z__index"
                                    :showLabels="false" :close-on-select="true" :clear-on-select="false" :searchable="true"
                                    placeholder="Select User Role" label="name" track-by="id" /> -->
                                <select v-model="edit_user.user_role_id" class="form-select form-select-sm"
                                    aria-label="Default select example">
                                    <option>Select Role</option>
                                    <option :selected="edit_user.user_role_id == 1" value="1">Admin</option>
                                    <option :selected="edit_user.user_role_id == 0" value="0">Cashier</option>
                                </select>
                                <div class="row">
                                    <div class="col-12 mt-4 text-end">
                                        <button type="submit" class="btn btn-light-primary me-2 mt-2"
                                            style="font-weight: bold">
                                            UPDATE
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this product?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-darkr" style="font-weight: bold"
                                data-bs-dismiss="modal">
                                CANCEL
                            </button>
                            <button type="button" class="btn btn-light-danger" style="font-weight: bold"
                                @click.prevent="confirmDelete(selectedProductId)">
                                <i class="bi bi-trash"></i>
                                DELETE
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #loader>
            <Loader ref="loading_bar" />
        </template>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, onMounted, watch, nextTick } from "vue";
import axios from 'axios';
import Multiselect from 'vue-multiselect';
import Swal from 'sweetalert2';
import { Link, router } from '@inertiajs/vue3';
import Loader from '@/Components/Basic/LoadingBar.vue';

const page = ref(1);
const perPage = ref([25, 50, 100]);
const pageCount = ref(25);
const pagination = ref({});

const search = ref(null);
const users = ref([]);
const edit_user = ref({});
const select_value_type = ref(null);

const new_user = ref({});
const select_user_role = ref(null);
const select_edit_user_role = ref(null);
const user_roles = ref([]);

const loading_bar = ref(null);

const validationErrors = ref({});
const validationMessage = ref(null);

const setPage = (new_page) => {
    page.value = new_page;
    reload();
};

const getSearch = async () => {
    page.value = 1;
    reload();
};

const perPageChange = async () => {
    reload();
};

const resetValidationErrors = () => {
    validationErrors.value = {};
    validationMessage.value = null;
};

const convertValidationNotification = (error) => {
    resetValidationErrors();
    if (!(error.response && error.response.data)) return;
    const { message } = error.response.data;

    errorMessage(message);
};

const convertValidationError = (err) => {
    resetValidationErrors(err);
    if (!(err.response && err.response.data)) return;
    const { message, errors } = err.response.data;
    validationMessage.value = message;
    if (errors) {
        for (const error in errors) {
            validationErrors.value[error] = errors[error][0];
        }
    }
};

const reload = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    const tableData = (
        await axios.get(route('user.all'), {
            params: {
                page: page.value,
                per_page: pageCount.value,
                "filter[search]": search.value,
            },
        })
    ).data;

    users.value = tableData.data;
    pagination.value = tableData.meta;
    nextTick(() => {
        loading_bar.value.finish();
    });
};

const createUser = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    resetValidationErrors();
    try {
        if (new_user.value.password != new_user.value.con_password) {
            errorMessage("Password not match");
        }
        await axios.post(route("user.store"), new_user.value);
        reload();
        $("#userModal").modal("hide");
        new_user.value = {};
        select_value_type.value = null;
        successMessage("User created successfully")
        getUsers();
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });
        convertValidationNotification(error);
    }
};

const getUsers = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const tableData = (await axios.get(route("user.all"))).data;
        users.value = tableData.data;
        pagination.value = tableData.meta;

        console.log(tableData);
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });
        convertValidationError(error);
    }
};

const getUserRoles = async () => {
    try {
        const tableData = (await axios.get(route("role.all"))).data;
        user_roles.value = tableData;
    } catch (error) {
        convertValidationError(error);
    }
};

const editUser = async (id) => {
    resetValidationErrors();
    try {
        const user = (await axios.get(route('user.get', id))).data
        edit_user.value = user.data;
        if (edit_user.value.user_role_id) {
            select_edit_user_role.value = edit_user.value.user_role;
        } else {
            select_edit_user_role.value = null;
        }

        $('#editUserModal').modal('show')
    } catch (error) {
        convertValidationNotification(error);
    }
};

const updateUser = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    resetValidationErrors();
    try {
        if (edit_user.value.password != edit_user.value.con_password) {
            errorMessage("Password not match")
        }
        const response = await axios.post(route('user.update', edit_user.value.id), edit_user.value);

        reload();
        $('#editUserModal').modal('hide');
        edit_user.value = {};
        select_edit_user_role.value = null;
        successMessage("User updated successfully");

        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });
        convertValidationNotification(error)
    }
};
const deleteUser = async (id) => {
    nextTick(() => {

    });
    try {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#C00202', // Red
            cancelButtonColor: '#6CA925', // Secondary Color
            confirmButtonText: 'Yes, delete it!',
            iconHtml: '<i class="fas fa-exclamation" style="color: error;"></i>', // Red warning icon
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(route("user.delete", id)).then((response) => {
                    nextTick(() => {
                       
                    });
                    window.location.reload();
                });
            }
        });
    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });
        convertValidationNotification(error);
    }
};

const restoreUser = async (id) => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to restore this user!",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#6CA925', // Red
            cancelButtonColor: '#C00202', // Secondary Color
            confirmButtonText: 'Yes, restore it!',
            iconHtml: '<i class="fas fa-exclamation" style="color: error;"></i>', // Red warning icon
        }).then((result) => {
            if (result.isConfirmed) {
                axios.get(route("user.restore", id)).then((response) => {
                    nextTick(() => {
                        loading_bar.value.finish();
                    });
                    window.location.reload();
                });
            }
        });
    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });
        convertValidationNotification(error);
    }
};

function clearFilters() {
    search.value = null;
    reload();
}

const successMessage = (message) => {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
};

const errorMessage = (message) => {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
};

onMounted(() => {
    getUsers();
    getUserRoles();

});

</script>

<style lang="scss" scoped></style>

