<template>
    <AppLayout title="Customer">
        <template #content>
            <div class="flex-grow-1 p-0 page-top">
                <div class="row content-margin2">
                    <div class="col-lg-12 mt-20 mt-lg-0">
                        <div class="d-flex justify-content-start align-items-center col-form-label mt-5 mt-lg-0">
                            <h1 style="margin-right: auto; font-size: 28px; color: #071437">
                                Customer
                            </h1>
                            <button class="btn btn-light-primary" style="font-weight: bold"
                                @click="showCustomerModal(selectedCustomerData = {}, emailIndex = 1, phoneIndex = 1)">
                                <i class="bi bi-plus-circle"></i> ADD NEW
                            </button>
                        </div>
                        <div class="card shadow">
                            <div class="py-3 text-sm card-body">
                                <!-- Filters -->
                                <div class="row align-items-center mb-3 mt-3">
                                    <div class="col-md-3 mb-2 mb-md-0">
                                        <div for="purchase_uom" class="col-form-label text-gray-600">CUSTOMER NAME</div>
                                        <input v-model="nameFilter" type="text" class="form-control form-control-sm"
                                            placeholder="Customer" @keyup="getSearch" />
                                    </div>
                                    <div class="col-md-3 mb-2 mb-md-0">
                                        <div for="purchase_uom" class="col-form-label text-gray-600">CONTACT</div>
                                        <input v-model="contactFilter" type="text" class="form-control form-control-sm"
                                            placeholder="Contact" @keyup="getSearch" />
                                    </div>
                                    <div class="col-md-2 align-self-end">
                                        <button @click="clearFilters" class="square-clear-button p-5">
                                            <i class="fa fa-refresh" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="col-md-2 mb-2 mb-md-0">
                                    </div>
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
                                                    <th class="ps-3">Customer</th>
                                                    <th>Contact</th>
                                                    <th>Email</th>
                                                    <th class="text-end">Outstanding</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                                <!-- Table Data Rows -->
                                                <tr v-for="customer in customers">
                                                    <td class="ps-3 py-2">{{ customer.name }}</td>
                                                    <td class="py-2">{{ customer.contact }}</td>
                                                    <td class="py-2">{{ customer.email }}</td>
                                                    <td class="text-end py-2">{{ customer.formatted_outstanding }}</td>
                                                    <td class="text-end pe-2 py-2">
                                                        <a href="javascript:void(0)" @click="editCustomer(customer.id)"
                                                            class="p-2">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" class="p-2"
                                                            @click="showDeleteModal(customer.id)">
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
        <template #modal>
            <!-- Add/Edit Customer Modal -->
            <div class="modal fade" id="customerModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form @submit.prevent="saveNewCustomer" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-8 mb-6">
                                        <h5 v-if="selectedCustomerData.id" class="modal-title" style="color: #071437">Update
                                            Customer
                                        </h5>
                                        <h5 v-else class="modal-title" style="color: #071437">Add New Customer</h5>
                                    </div>
                                    <div class="col-4 mb-6 text-end">
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"
                                            @click="closeCustomerModal"></button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <lable class="text-gray-600">Customer</lable>
                                        <input v-model="customerData.name" type="text"
                                            class="form-control form-control-sm mt-1" placeholder="Enter Customer Name" />
                                    </div>
                                    <div class="col-12 mb-4">
                                        <lable class="text-gray-600">Postal Address</lable>
                                        <input v-model="customerData.address" type="text"
                                            class="form-control form-control-sm mt-1" placeholder="Enter Postal Address" />
                                    </div>

                                    <div class="col-12 mb-4">
                                        <lable class="text-gray-600">Email 1</lable>
                                        <input v-model="customerData.email" type="email"
                                            class="form-control form-control-sm mt-1" placeholder="Enter Email 1" />
                                        <div class="row">
                                            <div class="col-12 mt-2 mb-2" :class="[emailIndex !== 1 ? 'd-none' : '',]">
                                                <a href="javascript:void(0)" class="text-primary" @click="emailIndex = 2">+
                                                    Another
                                                    Email</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4" :class="[emailIndex <= 1 ? 'd-none' : '',]">
                                        <lable class="text-gray-600">Email 2</lable>
                                        <div class="row">
                                            <div class="col-11" :class="[emailIndex === 3 ? 'col-12' : '',]">
                                                <input v-model="customerData.email2" type="email"
                                                    class="form-control form-control-sm mt-1" placeholder="Enter Email 2" />
                                            </div>
                                            <div class="col-1 d-flex align-items-center"
                                                :class="[emailIndex === 3 ? 'd-none' : '',]">
                                                <a href="javascript:void(0)" class="text-success d-inline-block"
                                                    @click="emailIndex = 1, clearEmail2()"><i
                                                        class="bi bi-dash-circle-fill text-danger"></i></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mt-2 mb-2" :class="[emailIndex !== 2 ? 'd-none' : '',]">
                                                <a href="javascript:void(0)" class="text-primary" @click="emailIndex = 3">+
                                                    Another
                                                    Email</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4" :class="[emailIndex <= 2 ? 'd-none' : '',]">
                                        <lable class="text-gray-600">Email 3</lable>
                                        <div class="row">
                                            <div class="col-11">
                                                <input v-model="customerData.email3" type="email"
                                                    class="form-control form-control-sm mt-1" placeholder="Enter Email 3" />
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <a href="javascript:void(0)" class="text-success d-inline-block"
                                                    @click="emailIndex = 2, clearEmail3()"><i
                                                        class="bi bi-dash-circle-fill text-danger"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-4">
                                        <lable class="text-gray-600">Phone No.1</lable>
                                        <input v-model="customerData.contact" type="text"
                                            class="form-control form-control-sm mt-1" placeholder="Enter Phone Number1" />
                                        <div class="row">
                                            <div class="col-12 mt-2 mb-2" :class="[phoneIndex !== 1 ? 'd-none' : '',]">
                                                <a href="javascript:void(0)" class="text-primary" @click="phoneIndex = 2">+
                                                    Another
                                                    Phone No.</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4" :class="[phoneIndex <= 1 ? 'd-none' : '',]">
                                        <lable class="text-gray-600">Phone No.2</lable>
                                        <div class="row">
                                            <div class="col-11" :class="[phoneIndex === 3 ? 'col-12' : '',]">
                                                <input v-model="customerData.contact2" type="text"
                                                    class="form-control form-control-sm mt-1"
                                                    placeholder="Enter Phone Number2" />
                                            </div>
                                            <div class="col-1 d-flex align-items-center"
                                                :class="[phoneIndex === 3 ? 'd-none' : '',]">
                                                <a href="javascript:void(0)" class="text-success d-inline-block"
                                                    @click="phoneIndex = 1, clearContact2()"><i
                                                        class="bi bi-dash-circle-fill text-danger"></i></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mt-2 mb-2" :class="[phoneIndex !== 2 ? 'd-none' : '',]">
                                                <a href="javascript:void(0)" class="text-primary" @click="phoneIndex = 3">+
                                                    Another
                                                    Phone No.</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4" :class="[phoneIndex <= 2 ? 'd-none' : '',]">
                                        <lable class="text-gray-600">Phone No.3</lable>
                                        <div class="row">
                                            <div class="col-11">
                                                <input v-model="customerData.contact3" type="text"
                                                    class="form-control form-control-sm mt-1"
                                                    placeholder="Enter Phone Number3" />
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <a href="javascript:void(0)" class="text-success d-inline-block"
                                                    @click="phoneIndex = 2, clearContact3()"><i
                                                        class="bi bi-dash-circle-fill text-danger"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-4">
                                        <lable class="text-gray-600">Website</lable>
                                        <input v-model="customerData.website" type="text"
                                            class="form-control form-control-sm mt-1" placeholder="Enter Website" />
                                    </div>
                                    <!-- <div class="col-12 mb-4">
                                        <lable class="text-gray-600">Open Outstanding</lable>
                                        <input v-model="customerData.customer_outstanding" type="text"
                                            class="form-control form-control-sm mt-1"
                                            placeholder="Enter Open Outstanding" />
                                    </div> -->
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-4 text-end">
                                        <button v-if="selectedCustomerData.id" type="button"
                                            class="btn btn-light-primary" style="font-weight: bold"
                                            @click.prevent="updateCustomer(selectedCustomerData.id)">
                                            Update
                                        </button>
                                        <button v-else type="submit" class="btn btn-light-primary"
                                            style="font-weight: bold">
                                            SAVE
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
                            Are you sure you want to delete this customer?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-darkr" style="font-weight: bold" data-dismiss="modal"
                                @click="closeDeleteModal">
                                CANCEL
                            </button>
                            <button type="button" class="btn btn-light-danger" style="font-weight: bold"
                                @click.prevent="deleteCustomer(selectedCustomerId)">
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
import { ref, onMounted, nextTick } from "vue";
import axios from 'axios';
import Swal from 'sweetalert2';
import Loader from '@/Components/Basic/LoadingBar.vue';


const page = ref(1);
const perPage = ref([25, 50, 100]);
const pageCount = ref(25);
const pagination = ref({});

const customers = ref([]);
const selectedCustomerData = ref({});

const emailIndex = ref(1);
const phoneIndex = ref(1);

// Filter variables
const nameFilter = ref("");
const contactFilter = ref("");

const validationErrors = ref({});
const validationMessage = ref(null);

const customerData = ref({});
const selectedCustomerId = ref(null);

const loading_bar = ref(null);

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

// Clear filters Method
function clearFilters() {
    nameFilter.value = "";
    contactFilter.value = "";
    getCustomers();
}

// Show Add/Edit Customer Modal
const showCustomerModal = async (selectedCustomerData) => {
    if (selectedCustomerData) {
        customerData.value.name = selectedCustomerData.name;
        customerData.value.company = selectedCustomerData.company;
        customerData.value.address = selectedCustomerData.address;
        customerData.value.email = selectedCustomerData.email;
        customerData.value.email2 = selectedCustomerData.email2;
        customerData.value.email3 = selectedCustomerData.email3;
        customerData.value.contact = selectedCustomerData.contact;
        customerData.value.contact2 = selectedCustomerData.contact2;
        customerData.value.contact3 = selectedCustomerData.contact3;
        customerData.value.website = selectedCustomerData.website;
        customerData.value.customer_credit = selectedCustomerData.customer_credit;
        customerData.value.customer_outstanding = selectedCustomerData.customer_outstanding;
        $("#customerModal").modal("show");
    } else {
        customerData.value.name = "";
        customerData.value.company = "";
        customerData.value.address = "";
        customerData.value.email = "";
        customerData.value.email2 = "";
        customerData.value.email3 = "";
        customerData.value.contact = "";
        customerData.value.contact2 = "";
        customerData.value.contact3 = "";
        customerData.value.website = "";
        customerData.value.customer_credit = "";
        customerData.value.customer_outstanding = "";
        $("#customerModal").modal("show");
    }
};

const editCustomer = async (id) => {
    const customer = (await axios.get(route('customer.get', id))).data
    selectedCustomerData.value = customer;
    showCustomerModal(selectedCustomerData.value);
};

// Show Delete Confirmation Modal
function showDeleteModal(customerId) {
    selectedCustomerId.value = customerId;
    $("#deleteModal").modal("show");
}

// Delete Customer (Delete Confirmation Modal)
function closeDeleteModal() {
    $("#deleteModal").modal("hide");
}

// Close Add/Edit, Customer (Close Modal)
const closeCustomerModal = async () => {
    $("#customerModal").modal("hide");
    // $("#deleteModal").modal("hide");
};

const clearContact3 = async () => {
    customerData.value.contact3 = "";
};
const clearContact2 = async () => {
    customerData.value.contact2 = "";
};
const clearEmail2 = async () => {
    customerData.value.email2 = "";
};
const clearEmail3 = async () => {
    customerData.value.email3 = "";
};

const saveNewCustomer = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    resetValidationErrors();
    try {
        (await axios.post(route("customer.all.store"), customerData.value)).data;
        successMessage('New customer registration is successful');
        closeCustomerModal();
        getCustomers();
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });
        convertValidationNotification(error);
        // convertValidationError(error);
    }
};

const updateCustomer = async (id) => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        await axios.post(route('customer.update', id), customerData.value);
        successMessage('Customer successfully updated');
        closeCustomerModal();
        getCustomers();
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });
        convertValidationNotification(error);
        convertValidationError(error);
    }
};

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

const reload = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    const tableData = (
        await axios.get(route('customer.all'), {
            params: {
                page: page.value,
                per_page: pageCount.value,
                search_customer_name: nameFilter.value,
                search_customer_contact: contactFilter.value,
            },
        })
    ).data;

    customers.value = tableData.data;
    pagination.value = tableData.meta;
    nextTick(() => {
        loading_bar.value.finish();
    });
};

const getCustomers = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const tableData = (await axios.get(route('customer.all'))).data;

        customers.value = tableData.data;
        pagination.value = tableData.meta;
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

const deleteCustomer = async (customerId) => {
    try {
        await axios.delete(route("customer.delete", customerId));
        closeDeleteModal();
        successMessage('Customer deleted successfully');
        getCustomers();
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
    getCustomers();
});

</script>

<style lang="scss" scoped></style>

