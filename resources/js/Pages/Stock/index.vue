<template>
    <AppLayout title="Product Management">
        <template #content>
            <div class="flex-grow-1 p-0 page-top">
                <div class="row content-margin2">
                    <div class="col-lg-12 mt-20 mt-lg-0">
                        <div class="d-flex justify-content-start align-items-center col-form-label mt-5 mt-lg-0">
                            <h1 style="margin-right: auto; font-size: 28px; color: #071437">
                                Products Stock
                            </h1>

                        </div>
                        <div class="card shadow">
                            <div class="py-3 text-sm card-body">
                                <!-- Filters -->
                                <div class="row align-items-center mb-3 mt-3">
                                    <div class="col-md-2 mb-2 mb-md-0">
                                        <div for="purchase_uom" class="col-form-label text-gray-600">CODE</div>
                                        <input v-model="codeFilter" type="text" class="form-control form-control-sm"
                                            placeholder="Code" @keyup="getSearch" />
                                    </div>
                                    <div class="col-md-2 mb-2 mb-md-0">
                                        <div for="purchase_uom" class="col-form-label text-gray-600">NAME</div>
                                        <input v-model="nameFilter" type="text" class="form-control form-control-sm"
                                            placeholder="Product Name" @keyup="getSearch" />
                                    </div>
                                    <div class="col-md-2 mb-2 mb-md-0">
                                        <div for="purchase_uom" class="col-form-label text-gray-600">CATEGORY</div>
                                        <Multiselect v-model="select_search_category" :options="categories" class="z__index"
                                            :showLabels="false" :close-on-select="true" :clear-on-select="false"
                                            @search-change="getCategories" :searchable="true" placeholder="Select Category"
                                            label="name" track-by="id" />
                                    </div>
                                    <!-- <div class="col-md-1 mb-2 mb-md-0">
                                        <div for="purchase_uom" class="col-form-label text-gray-600">MIN PRICE</div>
                                        <input v-model="minCostFilter" type="text" class="form-control form-control-sm"
                                            placeholder="Min product price" @keyup="getSearch" />
                                    </div>
                                    <div class="col-md-1 mb-2 mb-md-0">
                                        <div for="purchase_uom" class="col-form-label text-gray-600">MAX PRICE</div>
                                        <input v-model="maxCostFilter" type="text" class="form-control form-control-sm"
                                            placeholder="Max product price" @keyup="getSearch" />
                                    </div> -->
                                    <div class="col-md-2 mb-2 mb-md-0">
                                        <div for="purchase_uom" class="col-form-label text-gray-600">MIN SELLING PRICE</div>
                                        <input v-model="minPriceFilter" type="text" class="form-control form-control-sm"
                                            placeholder="Min selling price" @keyup="getSearch" />
                                    </div>
                                    <div class="col-md-2 mb-2 mb-md-0">
                                        <div for="purchase_uom" class="col-form-label text-gray-600">MAX SELLING PRICE</div>
                                        <input v-model="maxPriceFilter" type="text" class="form-control form-control-sm"
                                            placeholder="Max selling price" @keyup="getSearch" />
                                    </div>
                                    <div class="col-md-1 align-self-end">
                                        <button @click="clearFilters" class="square-clear-button p-5">
                                            <i class="fa fa-refresh" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="col-md-1 d-flex justify-content-end align-self-end">
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
                                                    <th class="ps-3">Code</th>
                                                    <th>Name</th>
                                                    <th>Category</th>
                                                    <th class="text-end">Stock</th>
                                                    <th class="text-end">Product Price</th>
                                                    <th class="text-end">Selling Price</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                                <tr v-for="product in products"  >
                                                    <td class="ps-3 py-2">{{ product.code }}</td>
                                                    <td class="py-2">{{ product.name }}</td>
                                                    <td class="py-2">{{ product.category_name }}
                                                    </td>
                                                    <td class="text-end py-2">{{ product.formatted_stock_qty }}</td>
                                                    <td class="text-end py-2">{{ product.formatted_product_price }}</td>
                                                    <td class="text-end py-2">{{ product.formatted_selling_price }}</td>
                                                    <td class="text-end pe-1 py-2">
                                                        <a  href="javascript:void(0)" class="p-2"
                                                            @click="editStock(product.id)">
                                                            <i class="bi bi-box-seam"></i>
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



            <!-- Update Stock Modal -->
            <div class="modal fade" id="stockModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form @submit.prevent="updateStock" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-8 mb-5">
                                        <h5 class="modal-title" style="color: #071437">Stock Update</h5>
                                    </div>
                                    <div class="col-4 mb-5 text-end">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-5 col-md-4 form-label text-gray-600">Transaction Type</div>
                                    <div class="col-7 col-md-8">
                                        <div class="row">
                                            <div class="col-5">
                                                <div class="form-check form-check-inline d-flex align-items-center">
                                                    <input v-model="stock_in" class="form-check-input" type="radio"
                                                        style="width: 16px; height: 16px;" name="flexRadioDefault"
                                                        id="flexRadioDefault1" :checked="stock_in">
                                                    <label class="form-check-label ps-5" for="flexRadioDefault1">
                                                        Stock In
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="form-check form-check-inline d-flex align-items-center" v-if="props.auth.user.user_role_id == 1" >
                                                    <input v-model="stock_out" class="form-check-input" type="radio"
                                                        style="width: 16px; height: 16px;" name="flexRadioDefault"
                                                        id="flexRadioDefault2" :checked="stock_out">
                                                    <label class="form-check-label ps-5" for="flexRadioDefault2">
                                                        Stock Out
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-12 form-label text-gray-600 mt-5">Quantity</div>
                                    <div class="col-12"><input v-model="stock.quantity" type="text"
                                            class="form-control form-control-sm" placeholder="Product quantity" /></div>

                                    <div class="col-12 form-label text-gray-600 mt-5">Remark</div>
                                    <div class="col-120"><textarea v-model="stock.remarks" class="form-control"
                                            placeholder="Enter remark" data-kt-autosize="true"
                                            style="resize: none; font-size: 12px;" rows="2"></textarea></div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-light-primary mt-5" style="font-weight: bold">
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>
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
import { computed } from "vue";
import { usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { Link } from '@inertiajs/vue3';
import Loader from '@/Components/Basic/LoadingBar.vue';

const { props } = usePage();

const page = ref(1);
const perPage = ref([25, 50, 100]);
const pageCount = ref(25);
const pagination = ref({});

const products = ref([]);
const categories = ref([]);
const units = ref([]);
const select_category = ref([]);
const select_edit_category = ref([]);
const select_unit = ref([]);
const select_edit_unit = ref([]);

const product = ref({});
const edit_product = ref({});
const selectedProductId = ref(null);

const stock = ref({});

const stock_in = ref(false);
const stock_out = ref(false);

// Filter variables
const codeFilter = ref("");
const nameFilter = ref("");
const minCostFilter = ref("");
const maxCostFilter = ref("");
const minPriceFilter = ref("");
const maxPriceFilter = ref("");
const select_search_category = ref(null);
const search_category = ref({});

const validationErrors = ref({});
const validationMessage = ref(null);

const loading_bar = ref(null);

const product_image = ref(null);
const edit_product_image = ref(null);

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

const onFileChange = (e) => {
    product.value.image = e.target.files[0];
    product_image.value = e.target.files[0];
};

const onFileChangeEdit = (e) => {
    edit_product.value.image = e.target.files[0];
    edit_product_image.value = e.target.files[0];

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
watch(select_search_category, (newValue) => {
    if (newValue) {
        search_category.value.category_id = newValue.id;
    } else {
        search_category.value.category_id = null;
    }
    getSearch();
});


const userHasRole = computed(() => (roleName) => {
    return props.auth.user.role_name === roleName;
});


const reload = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    const tableData = (
        await axios.get(route('stocks.all'), {
            params: {
                page: page.value,
                per_page: pageCount.value,
                search_product_code: codeFilter.value,
                search_product_name: nameFilter.value,
                search_product_cost_min: minCostFilter.value,
                search_product_cost_max: maxCostFilter.value,
                search_product_selling_min: minPriceFilter.value,
                search_product_selling_max: maxPriceFilter.value,
                search_product_category:  search_category.value.category_id,
            },
        })
    ).data;

    products.value = tableData.data;
    pagination.value = tableData.meta;
    nextTick(() => {
        loading_bar.value.finish();
    });
};

const getCategories = async () => {
    try {
        const response = (await axios.get(route('categories.all'))).data;
        categories.value = response;
    } catch (error) {
        convertValidationError(error);
    }
};

const getUnits = async () => {
    try {
        const response = (await axios.get(route('units.all'))).data;
        units.value = response;
    } catch (error) {
        convertValidationError(error);
    }
};


const saveProduct = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        if (select_category.value != null) {
            product.value.product_category_id = select_category.value.id;
        }

        if (select_unit.value != null) {
            product.value.unit = select_unit.value.id;
        }

        await axios.post(route('product.store'), product.value, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        successMessage('Product added successfully!');

        product.value = {};
        product_image.value = null;

        const fileInput = document.getElementById('product_image');
        fileInput.value = null;

        $('#productModal').modal('hide');
        reload();
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







const editStock = async (id) => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const response = (await axios.get(route("product.get", id))).data;
        stock.value = response;

        stock_in.value = true;

        $('#stockModal').modal('show');
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

const updateStock = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        if (stock_in.value == true) {
            stock.value.transaction_type_id = 1;
        }
        if (stock_in.value == "on") {
            stock.value.transaction_type_id = 1;
        } else if (stock_out.value == "on") {
            stock.value.transaction_type_id = 0;
        }

        const response = (await axios.post(route("stock.update", stock.value.id), stock.value)).data;
        successMessage('Stock updated successfully!');

        $('#stockModal').modal('hide');
        reload();
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

function clearFilters() {
    nextTick(() => {
        loading_bar.value.start();
    });
    codeFilter.value = "";
    nameFilter.value = "";
    minCostFilter.value = "";
    maxCostFilter.value = "";
    minPriceFilter.value = "";
    maxPriceFilter.value = "";
    select_search_category.value = null;
    reload();
    nextTick(() => {
        loading_bar.value.finish();
    });
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
    reload();
    getCategories();
    getUnits();

});

watch(() => {
    if (stock_in.value == true) {
        stock_out.value = false;
    } else if (stock_out.value == true) {
        stock_in.value = false;
    }
});

</script>

<style lang="scss" scoped></style>

