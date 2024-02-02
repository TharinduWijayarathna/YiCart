<template>
    <AppLayout title="Bills">
        <template #content>
            <div class="flex-grow-1 p-0 page-top">
                <div class="row content-margin2">
                    <div class="col-lg-12 mt-20 mt-lg-0">
                        <div class="d-flex justify-content-start align-items-center col-form-label mt-5 mt-lg-0">
                            <h1 style="margin-right: auto; font-size: 28px; color: #071437">
                                Bills
                            </h1>
                            <!-- <Link :href="route('notComplete.view')" class="btn btn-light-primary me-3"
                                style="font-weight: bold">
                            <i class="bi bi-plus-circle"></i> Not Complete Bills
                            </Link> -->
                        </div>
                        <div class="card shadow">
                            <div class="py-3 text-sm card-body">
                                <!-- Filters -->
                                <div class="row align-items-center mb-3 mt-3">
                                    <div class="col-md-1 mb-2 mb-md-0">
                                        <div for="purchase_uom" class="col-form-label text-gray-600">STATUS</div>
                                        <select class="form-select form-select-sm" v-model="orderStatus"
                                            data-control="select2" data-placeholder="Select an option" @keyup="getSearch"  >
                                            <option value="1">Done</option>
                                            <option value="2">Hold</option>
                                            <option value="4">Return</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 mb-2 mb-md-0">
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
                                    <div class="col-md-2 mb-2 mb-md-0">
                                        <div for="purchase_uom" class="col-form-label text-gray-600">CASHIER</div>
                                        <Multiselect v-model="select_search_cashier" :options="cashiers" class="z__index"
                                            :showLabels="false" :close-on-select="true" :clear-on-select="false"
                                            @search-change="getCashier" :searchable="true" placeholder="Select Cashier"
                                            label="name" track-by="id" />
                                    </div>
                                    <div class="col-md-2 mb-2 mb-md-0">
                                        <div for="purchase_uom" class="col-form-label text-gray-600">FROM DATE</div>
                                        <input v-model="from_date" type="date" class="form-control form-control-sm"
                                            placeholder="Search" @keyup="getSearch" />
                                    </div>
                                    <div class="col-md-2 mb-2 mb-md-0">
                                        <div for="purchase_uom" class="col-form-label text-gray-600">TO DATE</div>
                                        <input v-model="to_date" type="date" class="form-control form-control-sm"
                                            placeholder="Search" @keyup="getSearch" />
                                    </div>
                                    <div class="col-md-1 align-self-end">
                                        <button @click="clearFilters" class="square-clear-button p-5">
                                            <i class="fa fa-refresh" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="col-md-1 ps-0 d-flex justify-content-end align-self-end">
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

                                <!-- Bills Table -->
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5 mt-5">
                                            <thead>
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                    <th></th>
                                                    <th class="text-center">STATUS</th>
                                                    <th>BILL NO.</th>
                                                    <th>CUSTOMER</th>
                                                    <th>CASHIER</th>
                                                    <th>DATE & TIME</th>
                                                    <th class="text-end">SUB TOTAL</th>
                                                    <th class="text-end">DISCOUNT</th>
                                                    <th class="text-end">TOTAL</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                                <!-- Table Data Rows -->
                                                <tr v-for="(bill, index) in bills" :key="index">
                                                    <td class="text-center py-1">
                                                        <a v-if="bill.status == 1"
                                                            href="javascript:void(0)" @click.prevent="historyPrint(bill.id)"
                                                            class="btn btn-icon btn-outline btn-outline-primary btn-active-light-primary btn-sm"><i
                                                                class="bi bi-printer"></i></a>
                                                        <a v-else-if="bill.status == 4"
                                                            href="javascript:void(0)" @click.prevent="returnPrint(bill.id)"
                                                            class="btn btn-icon btn-outline btn-outline-primary btn-active-light-primary btn-sm"><i
                                                                class="bi bi-printer"></i></a>
                                                        <a v-else href="javascript:void(0)" @click.prevent="errorPrint"
                                                            class="btn btn-icon btn-outline btn-outline-danger btn-active-light-danger btn-sm"><i
                                                                class="bi bi-printer"></i></a>
                                                    </td>
                                                    <td class="py-2 text-center">
                                                        <div v-if="bill.status == 1" class="badge badge-light-success">DONE
                                                        </div>
                                                        <div v-if="bill.status == 0" class="badge badge-light-info">PENDING
                                                        </div>
                                                        <div v-if="bill.status == 2" class="badge badge-light-danger">HOLD
                                                        </div>
                                                        <div v-if="bill.status == 4" class="badge badge-light-info">RETURN
                                                        </div>
                                                    </td>
                                                    <td class="py-2">{{ bill.code }}</td>
                                                    <td v-if="bill.customer_id == null" class="py-2">Walking Customer</td>
                                                    <td v-else class="py-2">{{ bill.customer_name }}</td>
                                                    <td class="py-2">{{ bill.cashier_name }}</td>
                                                    <td class="py-2">{{ bill.date }}</td>
                                                    <td class="text-end py-2">{{ bill.formatted_sub_total }}</td>
                                                    <td class="text-end py-2">{{ bill.formatted_discount }}</td>
                                                    <td class="text-end py-2">{{ bill.formatted_total }}</td>
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
        <template #loader>
            <Loader ref="loading_bar" />
        </template>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { onMounted, ref, watch, nextTick } from 'vue';
import axios from 'axios';
import Multiselect from 'vue-multiselect';
import Swal from 'sweetalert2';
import Loader from '@/Components/Basic/LoadingBar.vue';
import { Link } from '@inertiajs/vue3';

const page = ref(1);
const perPage = ref([25, 50, 100]);
const pageCount = ref(25);
const pagination = ref({});

const bills = ref([]);

const search = ref(null);
const search_order = ref({});
const from_date = ref(null);
const to_date = ref(null);
const select_search_customer = ref(null);
const select_search_cashier = ref(null);
const customers = ref([]);
const cashiers = ref([]);
const orderStatus = ref(null);

const loading_bar = ref(null);

const getCustomer = async () => {
    try {
        const tableData = (await axios.get(route('customer.all'))).data;
        customers.value = tableData.data;
    } catch (error) {

    }
};

const getCashier = async () => {
    try {
        const tableData = (await axios.get(route('user.all'))).data;
        cashiers.value = tableData.data;
    } catch (error) {

    }
};

const setPage = async (new_page) => {
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
        await axios.get(route('cart.bill.all'), {
            params: {
                page: page.value,
                per_page: pageCount.value,
                "filter[search]": search.value,
                search_order_customer: search_order.value.customer_id,
                search_order_cashier: search_order.value.cashier_id,
                search_order_from_date: search_order.value.from_date,
                search_order_to_date: search_order.value.to_date,
                search_order_status: search_order.value.orderStatus,
            },
        })
    ).data;

    bills.value = tableData.data;
    pagination.value = tableData.meta;
    nextTick(() => {
        loading_bar.value.finish();
    });
};

const getAllOrders = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const tableData = (await axios.get(route('cart.bill.all'))).data;
        bills.value = tableData.data;
        pagination.value = tableData.meta;
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });
    }
};

const historyPrint = async (id) => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const print = await axios.get(route('payment.print', id), { responseType: "blob" });
        const url = window.URL.createObjectURL(print.data);
        window.open(url, "_blank");
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });

    }
};

const returnPrint = async (id) => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const print = await axios.get(route('return.print', id), { responseType: "blob" });
        const url = window.URL.createObjectURL(print.data);
        window.open(url, "_blank");
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });

    }
};

watch(select_search_customer, (newValue) => {
    if (newValue) {
        search_order.value.customer_id = newValue.id;
    } else {
        search_order.value.customer_id = null;
    }
    getSearch();
});

watch(select_search_cashier, (newValue) => {
    if (newValue) {
        search_order.value.cashier_id = newValue.id;
    } else {
        search_order.value.cashier_id = null;
    }
    getSearch();
});

watch(from_date, (newValue) => {
    search_order.value.from_date = newValue;
    getSearch();
});

watch(to_date, (newValue) => {
    search_order.value.to_date = newValue;
    getSearch();
});

watch(orderStatus, (newValue) => {
    search_order.value.orderStatus = newValue;
    getSearch();
});

function clearFilters() {
    search.value = "";
    select_search_customer.value = null;
    select_search_cashier.value = null;
    from_date.value = null;
    to_date.value = null;
    orderStatus.value = null;
    reload();
}

const errorPrint = () => {
    errorMessage('The order payment is not done!');
}

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
    getAllOrders();
    getCustomer();
    getCashier();
});

</script>

<style lang="scss" scoped></style>
