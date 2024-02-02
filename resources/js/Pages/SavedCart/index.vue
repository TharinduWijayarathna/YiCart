<template>
    <AppLayout title="Hold Orders">
        <template #content>
            <div class="flex-grow-1 p-0 page-top">
                <div class="row content-margin2">
                    <div class="col-lg-12 mt-20 mt-lg-0">
                        <div class="d-flex justify-content-start align-items-center col-form-label mt-5 mt-lg-0">
                            <h1 style="margin-right: auto; font-size: 28px; color: #071437;">Hold</h1>
                        </div>
                        <div class="card shadow mt-18 mt-lg-0">

                            <div class="py-3 text-sm card-body">

                                <div class="row my-3">
                                    <div class="col-md-2 mb-2 mb-md-0">
                                        <div for="purchase_uom" class="col-form-label text-gray-600">BILL NO.</div>
                                        <input v-model="search" type="text" class="form-control form-control-sm"
                                            placeholder="Bill No." @keyup="getSearch" />
                                    </div>
                                    <div class="col-md-2 mb-2 mb-md-0">
                                        <div for="purchase_uom" class="col-form-label text-gray-600">CUSTOMER</div>
                                        <Multiselect v-model="select_search_customer" :options="customers" class="z__index"
                                            :showLabels="false" :close-on-select="true" :clear-on-select="false"
                                            @search-change="getCustomer" :searchable="true" placeholder="Select Customer"
                                            label="name" track-by="id" />
                                    </div>
                                    <div class="col-md-1 align-self-end">
                                        <button @click="clearFilters" class="square-clear-button p-5">
                                            <i class="fa fa-refresh" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="col-md-5"></div>
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

                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5 mt-5"
                                            id="kt_ecommerce_sales_table">
                                            <thead>
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                    <th class="ps-3">BILL NO.</th>
                                                    <th>CREATED BY</th>
                                                    <th>CUSTOMER</th>
                                                    <th class="text-end">SUB TOTAL</th>
                                                    <th class="text-end">DISCOUNT</th>
                                                    <th class="text-end">TOTAL</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                                <tr v-for="order in orders">
                                                    <td class="py-2 ps-3">
                                                        <span>{{ order.code }}</span>
                                                    </td>
                                                    <td class="py-2">
                                                        <span>Cashier</span>
                                                    </td>
                                                    <td class="py-2">
                                                        <span v-if="order.customer_id == null">Walking Customer</span>
                                                        <span v-else>{{ order.customer_name }}</span>
                                                    </td>
                                                    <td class="text-end py-2">
                                                        <span>{{ order.formatted_sub_total }}</span>
                                                    </td>
                                                    <td class="text-end py-2">
                                                        <span>{{ order.formatted_discount }}</span>
                                                    </td>
                                                    <td class="text-end py-2">
                                                        <span>{{ order.formatted_total }}</span>
                                                    </td>
                                                    <td class="text-end pe-1 py-2">
                                                        <a href="javascript:void(0)" @click.prevent="reActive(order.id)"
                                                            class="p-2">
                                                            <i class="fa fa-refresh" aria-hidden="true"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" @click="showDeleteModal(order.id)"
                                                            class="p-2">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

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
        <template #loader>
            <Loader ref="loading_bar" />
        </template>
    </AppLayout>

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
                    Are you sure you want to delete this order?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-darkr" style="font-weight: bold" data-dismiss="modal"
                        @click="closeDeleteModal">
                        CANCEL
                    </button>
                    <button type="button" class="btn btn-light-danger" style="font-weight: bold"
                        @click.prevent="deleteHoldedOrder(selectedOrderId)">
                        <i class="bi bi-trash"></i>
                        DELETE
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { onMounted, ref, watch, nextTick } from 'vue';
import axios from 'axios';
import Multiselect from 'vue-multiselect';
import Swal from 'sweetalert2';
import Loader from '@/Components/Basic/LoadingBar.vue';

const page = ref(1);
const perPage = ref([25, 50, 100]);
const pageCount = ref(25);
const pagination = ref({});

const orders = ref([]);

const search = ref(null);
const search_order = ref({});
const select_search_customer = ref(null);
const customers = ref([]);

const selectedOrderId = ref(null);

const loading_bar = ref(null);

const getCustomer = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const tableData = (await axios.get(route('customer.all'))).data;
        customers.value = tableData.data;
        nextTick(() => {
        loading_bar.value.finish();
    });
    } catch (error) {

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
    try {
        const tableData = (
            await axios.get(route('cart.hold.all'), {
                params: {
                    page: page.value,
                    per_page: pageCount.value,
                    "filter[search]": search.value,
                    search_order_customer_id: search_order.value.customer_id,
                },
            })
        ).data;

        orders.value = tableData.data;
        pagination.value = tableData.meta;
        nextTick(() => {
        loading_bar.value.finish();
    });
    } catch (error) {

    }
};

const getHoldCartOrders = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const tableData = (await axios.get(route('cart.hold.all'))).data;

        orders.value = tableData.data;
        pagination.value = tableData.meta;
        nextTick(() => {
        loading_bar.value.finish();
    });
    } catch (error) {

    }
};

const reActive = async (id) => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        await axios.get(route('cart.order.reactive', id));
        window.location.href = route("cart.index");
        nextTick(() => {
        loading_bar.value.finish();
    });
    } catch (error) {

    }
};

const deleteHoldedOrder = async (id) => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        await axios.get(route('order.delete', id));
        getHoldCartOrders();
        closeDeleteModal();
        successMessage('Deletion of hold order successful');
        nextTick(() => {
        loading_bar.value.finish();
    });
    } catch (error) {

    }
};

// Show Delete Confirmation Modal
function showDeleteModal(orderId) {
    selectedOrderId.value = orderId;
    $("#deleteModal").modal("show");
}

// Delete Order (Delete Confirmation Modal)
function closeDeleteModal() {
    $("#deleteModal").modal("hide");
}

function clearFilters() {
    search.value = null;
    select_search_customer.value = null;
    reload();
}

watch(select_search_customer, (newValue) => {
    if (newValue) {
        search_order.value.customer_id = newValue.id;
    } else {
        search_order.value.customer_id = null;
    }
    getSearch();
});

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
    getHoldCartOrders();
    getCustomer();
});

</script>

<style lang="scss" scoped></style>
