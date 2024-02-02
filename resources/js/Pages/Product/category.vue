<template>
    <AppLayout title="Categories">
        <template #content>
            <div class="flex-grow-1 p-0 page-top">
                <div class="row content-margin2">
                    <div class="col-lg-12 mt-20 mt-lg-0">
                        <div class="d-flex justify-content-start align-items-center col-form-label mt-5 mt-lg-0">
                            <h1 style="margin-right: auto; font-size: 28px; color: #071437">
                                Categories
                            </h1>
                            <button class="btn btn-light-primary" style="font-weight: bold"
                                @click="showCategoryModal(selectedCategoryData = {})">
                                <i class="bi bi-plus-circle"></i> ADD NEW
                            </button>
                        </div>
                        <div class="card shadow">
                            <div class="py-3 text-sm card-body">

                                <div class="row align-items-center mb-3 mt-3">
                                    <div class="col-md-12 d-flex justify-content-end align-self-end">
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

                                <!-- Category Table -->
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5 mt-5">
                                            <thead>
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                    <th class="ps-3">#</th>
                                                    <th>Name</th>
                                                    <th>Remark</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                                <tr v-for="category, key in categories" :key="key">
                                                    <td class="py-2 ps-3">{{ key + 1 }}</td>
                                                    <td class="py-2">{{ category.name }}</td>
                                                    <td class="py-2">{{ category.remarks }}</td>
                                                    <td class="text-end py-2 pe-3">
                                                        <a href="javascript:void(0)" class="p-2"
                                                            @click="editCategory(category.id)">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" class="p-2"
                                                            @click="showDeleteModal(category.id)">
                                                            <i class="bi bi-trash-fill"></i>
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
    </AppLayout>

    <!-- Add/Edit Category Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-8 mb-5">
                            <h5 v-if="selectedCategoryData.id" class="modal-title" style="color: #071437">Update
                                Category</h5>
                            <h5 v-else class="modal-title" style="color: #071437">Add New Category</h5>
                        </div>
                        <div class="col-4 mb-5 text-end">
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"
                                @click="closeCategoryModal"></button>
                        </div>
                    </div>
                    <form @submit.prevent="saveNewCategory" enctype="multipart/form-data">
                        <div class="col-form-label text-gray-600">Name</div>
                        <input v-model="categoryData.name" type="text" class="form-control form-control-sm"
                            placeholder="Name" />

                        <div class="col-form-label text-gray-600">Remark</div>
                        <textarea v-model="categoryData.remarks" class="form-control" placeholder="Enter category remark"
                            data-kt-autosize="true" style="resize: none; font-size: 12px;" rows="2"></textarea>
                        <div class="row">
                            <div class="col-12 mt-4 text-end">
                                <button v-if="selectedCategoryData.id" type="button" class="btn btn-light-primary me-2 mt-2"
                                    style="font-weight: bold" @click.prevent="updateCategory(selectedCategoryData.id)">
                                    Update
                                </button>
                                <button v-else type="submit" class="btn btn-light-primary me-2 mt-2"
                                    style="font-weight: bold">
                                    SAVE
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
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"
                        @click="closeDeleteModal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this category?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-darkr" style="font-weight: bold" data-dismiss="modal"
                        @click="closeDeleteModal">
                        CANCEL
                    </button>
                    <button type="button" class="btn btn-light-danger" style="font-weight: bold"
                        @click.prevent="deleteCategory(selectedCategoryId)">
                        <i class="bi bi-trash"></i>
                        DELETE
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, onMounted } from "vue";
import axios from 'axios';
import Swal from 'sweetalert2';

const page = ref(1);
const perPage = ref([25, 50, 100]);
const pageCount = ref(25);
const pagination = ref({});

const categories = ref([]);

const categoryData = ref({});
const selectedCategoryId = ref(null);

const selectedCategoryData = ref({});

const validationErrors = ref({});
const validationMessage = ref(null);


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

const editCategory = async (id) => {
    try {
        const category = (await axios.get(route('category.get', id))).data;
        selectedCategoryData.value = category;
        showCategoryModal(selectedCategoryData.value);
    } catch (error) {
        console.error(error);
    }
};

// Show Add/Edit Category Modal
const showCategoryModal = async (selectedCategoryData) => {
    if (selectedCategoryData) {
        categoryData.value.name = selectedCategoryData.name;
        categoryData.value.remarks = selectedCategoryData.remarks;
        $("#categoryModal").modal("show");
    } else {
        categoryData.value.name = "";
        categoryData.value.remarks = "";
        $("#categoryModal").modal("show");
    }
};

// Show Delete Confirmation Modal
function showDeleteModal(categoryId) {
    selectedCategoryId.value = categoryId;
    $("#deleteModal").modal("show");
}

// Delete Category (Delete Confirmation Modal)
function closeDeleteModal() {
    $("#deleteModal").modal("hide");
}

// Close Add/Edit, Category (Close Modal)
const closeCategoryModal = async () => {
    $("#categoryModal").modal("hide");
    categoryData.value.stock_quantity = "";
};

const saveNewCategory = async () => {
    resetValidationErrors();
    try {
        const response = (await axios.post(route("category.store"), categoryData.value)).data;
        if (response === "This category already exists") {
            errorMessage('This category already exists');
        } else {
            successMessage('New category registration is successful');
            closeCategoryModal();
            getCategories();
        }
    } catch (error) {
        convertValidationNotification(error);
    }
};

const updateCategory = async (id) => {
    resetValidationErrors();
    try {
        await axios.post(route('category.update', id), categoryData.value);
        successMessage('Category successfully updated');
        closeCategoryModal();
        getCategories();
    } catch (error) {
        convertValidationNotification(error);
    }
};

const setPage = (new_page) => {
    page.value = new_page;
    reload();
};
const perPageChange = async () => {
    reload();
};

const reload = async () => {
    const tableData = (
        await axios.get(route('categoryDetails.all'), {
            params: {
                page: page.value,
                per_page: pageCount.value,
            },
        })
    ).data;

    categories.value = tableData.data;
    pagination.value = tableData.meta;
};

const getCategories = async () => {
    try {
        const tableData = (await axios.get(route('categoryDetails.all'))).data;

        categories.value = tableData.data;
        pagination.value = tableData.meta;
    } catch (error) {

    }
};

const deleteCategory = async (categoryId) => {
    try {
        await axios.delete(route("category.delete", categoryId));
        closeDeleteModal();
        successMessage('Category deleted successfully');
        getCategories();
    } catch (error) {
    }
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
    getCategories();
});

</script>

<style lang="scss" scoped></style>

