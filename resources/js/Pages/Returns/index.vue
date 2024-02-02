<template>
    <AppLayout title="Return">
        <template #content>
            <div class="flex-grow-1 p-0 page-top">
                <div class="row content-margin2">
                    <div class="col-lg-12 mt-20 mt-lg-0">
                        <div class="d-flex justify-content-start align-items-center col-form-label mt-5 mt-lg-0">
                            <h1 style="margin-right: auto; font-size: 28px; color: #071437">
                                Return
                            </h1>
                            <a v-if="selectCustomer == null" href="#"
                                class="btn btn-sm fs-4 fw-bold py-2 text-sm-center text-lg-start customer-btn"
                                data-bs-toggle="modal" data-bs-target="#customerModal" @click="showCustomerModal">&plus;
                                CUSTOMER</a>
                            <a v-if="selectCustomer != null" href="#" @click.prevent="removeCustomer"
                                class="btn btn-sm fs-4 fw-bold py-2 text-sm-center text-lg-start customer-btn">✖
                                {{ selectCustomerName }}</a>
                        </div>
                        <div class="card shadow">
                            <div class="py-3 text-sm card-body">
                                <div class="row mt-3">
                                    <form id="addNewCardValidation" class="mt-0 row w-100" @submit.prevent="addProduct()">
                                        <div class="col-lg-3">
                                            <div class="col-form-label text-gray-600">Product</div>
                                            <div class="input-group input-group-merge">
                                                <div class="w-100">
                                                    <div class="position-relative">
                                                        <div class="w-100">
                                                            <input type="text"
                                                                class="form-control form-control-solid form-control-sm"
                                                                name="search" v-model="product_search_query"
                                                                @keyup="searchProduct" placeholder="Select Product" />
                                                        </div>
                                                        <div id="productsOptionsDropDown" class="options-dropdown mt-2px"
                                                            v-if="productsOptionsList.length > 0">
                                                            <div>
                                                                <div class="w-100 option"
                                                                    v-for="productOption in productsOptionsList"
                                                                    @click="setProduct(productOption.value)"
                                                                    :key="productOption.value">
                                                                    {{ productOption.text }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="col-form-label text-gray-600">Price</div>
                                            <input type="text" class="form-control form-control-solid form-control-sm"
                                                name="search" v-model="items_price" placeholder="0.00" />
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="col-form-label text-gray-600">Qty</div>
                                            <input type="text" class="form-control form-control-solid form-control-sm"
                                                name="search" v-model="items.quantity" placeholder="0" />
                                        </div>
                                        <div class="col-lg-2 mt-3 mt-lg-0 d-flex align-self-end">
                                            <button type="submit" class="btn btn-light-primary btn-sm fw-bold"><i
                                                    class="bi bi-plus-circle fw-bold"></i> ADD</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5 mt-5 mt-md-10"
                                            id="kt_ecommerce_sales_table">
                                            <thead>
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                    <th class="ps-3">CODE</th>
                                                    <th>NAME</th>
                                                    <th class="text-end">RETURNING QTY</th>
                                                    <th class="text-end">LINE TOTAL</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">

                                                <tr v-for="(returnItem, index) in returnProducts">
                                                    <td class="ps-3 py-1">
                                                        <span>{{ returnItem.product_code }}</span>
                                                    </td>
                                                    <td class="py-1">
                                                        <span>{{ returnItem.product_name }}</span>
                                                    </td>
                                                    <td class="text-end py-1">
                                                        <span>{{ formatQuantity(returnItem.return_quantity) }}</span>
                                                    </td>
                                                    <td class="text-end py-1">
                                                        <span>{{ returnItem.formatted_total }}</span>
                                                    </td>
                                                    <td class="text-end pe-3 py-1">
                                                        <a href="javascript:void(0)"
                                                            @click.prevent="deleteItem(returnItem.id)" class="p-2">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="ps-3">
                                                        <h3>Item Lines : {{ returnProducts.length }}</h3>
                                                    </td>
                                                    <td></td>
                                                    <td class="text-end text-gray-700 fw-bold">Total :</td>
                                                    <td class="text-end text-gray-700 fw-bold">{{ viewTotal }}</td>
                                                    <td></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row mt-5 mb-2">
                                    <div class="col-lg-10">
                                        <textarea v-model="remark" class="form-control" placeholder="Remark"
                                            data-kt-autosize="true" rows="1.5" style="resize: none;"></textarea>
                                    </div>
                                    <div class="col-lg-2 mt-3 mt-lg-0">
                                        <a href="javascript:void(0)" @click.prevent="returnDone"
                                            class="btn btn-lg w-100 px-0 btn-light-primary" data-toggle="modal"
                                            style="font-weight: bold" data-target="#newCustomerModal">
                                            <i class="bi bi-arrow-return-left"></i>
                                            RETURN
                                        </a>
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

    <!-- Customer Modal -->
    <div class="modal fade" id="customerModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color: #071437">Add Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data">
                        <div class="row mb-8">
                            <div class="col-md-4 mt-2">
                                <span class="text-gray-600">PHONE NUMBER</span>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control form-control-sm" v-model="customer.contact"
                                    placeholder="Phone Number" required />
                            </div>
                            <div class="col-md-2">
                                <div class="row">
                                    <div class="col-12 justify-content-end text-end">
                                        <a class="square-clear-button" @click.prevent="searchLoyaltyCustomer">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="loyalty_customer.name != null">
                            <div class="row mt-2">
                                <div class="col-md-4 mt-2">
                                    <span class="text-gray-600">NAME</span>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm" v-model="loyalty_customer.name"
                                        placeholder="Name" disabled />
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 mt-2">
                                    <span class="text-gray-600">EMAIL ADDRESS</span>
                                </div>
                                <div class="col-md-8">
                                    <input type="email" class="form-control form-control-sm"
                                        v-model="loyalty_customer.email" placeholder="Email Address" disabled />
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 mt-2">
                                    <span class="text-gray-600">ADDRESS</span>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm"
                                        v-model="loyalty_customer.address" placeholder="Address" disabled />
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 justify-content-end text-end">
                                    <a class="square-clear-button" @click.prevent="saveCustomer(loyalty_customer)">
                                        <i class=" bi bi-chevron-double-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div v-if="loyalty_customer.name == null">
                            <div class="row mt-2">
                                <div class="col-md-4 mt-2">
                                    <span class="text-gray-600">NAME</span>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm" v-model="customer.name"
                                        placeholder="Name" required />
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 mt-2">
                                    <span class="text-gray-600">EMAIL ADDRESS</span>
                                </div>
                                <div class="col-md-8">
                                    <input type="email" class="form-control form-control-sm" v-model="customer.email"
                                        placeholder="Email Address" />
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 mt-2">
                                    <span class="text-gray-600">ADDRESS</span>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm" v-model="customer.address"
                                        placeholder="Address" />
                                </div>
                            </div>
                            <div class="row mt-2">
                                        <div class="col-md-4 mt-2">
                                            <span class="text-gray-600">PHONE NUMBER</span>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="number" class="form-control form-control-sm"
                                                v-model="customer.contact" placeholder="number" required />
                                        </div>
                                    </div>
                            <div class="row mt-3">
                                <div class="col-12 justify-content-end text-end">
                                    <a type="button" class="square-clear-button" @click.prevent="saveNewCustomer">
                                        <i class=" bi bi-chevron-double-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, onMounted, nextTick } from "vue";
import axios from 'axios';
import Swal from 'sweetalert2';
import Loader from '@/Components/Basic/LoadingBar.vue';

const orderId = ref(null);

const customer = ref({});
const loyalty_customer = ref({});
const selectCustomer = ref(null);
const selectCustomerName = ref('');

const product = ref({});
const product_id = ref(null);
const items = ref({});
const items_price = ref(null);

const product_search_query = ref('');
const productsOptionsList = ref([]);

const total = ref(0);
const viewTotal = ref(0.00);

const returnProducts = ref([]);

const remark = ref(null);

const validationErrors = ref({});
const validationMessage = ref(null);

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

const addProduct = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {

        if (product_id.value != null) {
            items.value.product_id = product_id.value;
        }
        if (items.value.quantity == null) {
            items.value.quantity = 0;
        }
        if (items_price.value != null) {
            items.value.unit_price = items_price.value;
        }
        items.value.customer_id = selectCustomer.value;

        const response = (await axios.post(route("return.item.store"), items.value)).data;

        product_search_query.value = '';
        items_price.value = null;
        items.value.quantity = 0;
        getReturnProducts();
        calculateTotals();
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

const getReturnProducts = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const returnProductData = (await axios.get(route('return.get.products'))).data;
        returnProducts.value = returnProductData;
        nextTick(() => {
            loading_bar.value.finish();
        });
        return returnProductData.length;
    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });
    }
};

const formatQuantity = (quantity) => {
    return Number(quantity).toFixed(0);
};

const deleteItem = async (id) => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        await axios.delete(route('return.delete.product', id)).data;
        getReturnProducts();
        calculateTotals();
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {

    }
};

const searchProduct = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    const optionsDropdown = document.getElementById('productsOptionsDropDown');

    if (optionsDropdown) {
        optionsDropdown.style.display = 'block';
    }

    if (product_search_query.value.trim() !== "") {
        try {
            const search_result = (
                await axios.post(route('product.search'), {
                    params: {
                        search: product_search_query.value,
                    },
                })
            ).data.data;
            productsOptionsList.value = search_result.map((element) => {
                return {
                    value: element.id,
                    text: element.name,
                };
            });
            console.log(productsOptionsList.value);
        } catch (error) {
            console.error(error);
        }
    } else {
        productsOptionsList.value = [];
    }

    nextTick(() => {
        loading_bar.value.finish();
    });

    return productsOptionsList;
};

const setProduct = async (productId) => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        if (productId != 0) {
            const productData = (await axios.get(route('product.get.details', productId))).data;
            product.value = productData;
            product_id.value = productData.id;
            items_price.value = productData.selling;
            product_search_query.value = productData.name
            toggleDropDown();
        } else {
            product.value = {};
            items_price.value = null;
        }
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {

    }
};

const searchLoyaltyCustomer = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const tableData = (
            await axios.get(
                route('customer.number.get', customer.value.contact)
            )
        ).data;
        loyalty_customer.value = tableData;
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });
    }
};

const saveNewCustomer = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const customerData = (await axios.post(route('customer.store'), customer.value)).data;
        if (customerData == "exists") {
            errorMessage('This customer already exists');
        } else {
            saveCustomer(customerData);
        }
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

const saveCustomer = async (customer) => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        if (customer) {
            const customer_all_details = (await axios.post(route('return.customer'), customer)).data;
            selectCustomer.value = customer_all_details.customer_id;
            selectCustomerName.value = customer_all_details.customer_name;
            $('#customerModal').modal('hide');
            successMessage('Customer selected successfully');
        }
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {

    }
};

const removeCustomer = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        await axios.get(route('return.customer.remove', orderId.value));
        selectCustomer.value = null;
        successMessage('Successfully removed the customer');
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {

    }
};

const calculateTotals = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const calTotal = (await axios.get(route('return.get.total'))).data;
        const formattedTotal = Number(calTotal).toFixed(2);
        const formattedViewTotal = Number(calTotal).toLocaleString('en-US', { minimumFractionDigits: 2 });

        total.value = formattedTotal;
        viewTotal.value = formattedViewTotal;
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {

    }
};

const getReturnOrder = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const order = (await axios.get(route('return.order'))).data;
        orderId.value = order.id;
        selectCustomer.value = order.customer_id;
        selectCustomerName.value = order.customer_name;
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {

    }
};

const returnDone = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const order_status = ref(null);

        if (remark.value !== null || selectCustomer.value !== null) {
            order_status.value = 1;
        } else {
            errorMessage('Please enter remark or select customer');
            order_status.value = 0;
        }

        if (order_status.value == 1) {
            const length = await getReturnProducts();

            if (length <= 0) {
                errorMessage('Please select return item');
            } else {
                const data = {
                    order_id: orderId.value,
                    order_total: total.value,
                    remark: remark.value,
                };
                try {
                    await axios.post(route('return.done'), data);

                    nextTick(() => {
                        loading_bar.value.start();
                    });
                    const print = await axios.get(route('return.print', orderId.value), { responseType: "blob" });
                    const url = window.URL.createObjectURL(print.data);
                    window.open(url, "_blank");

                    successMessage('Return is successful');
                    window.location.href = route("return.index");
                    nextTick(() => {
                        loading_bar.value.finish();
                    });
                } catch (error) {
                    console.error(error);
                    errorMessage('An error occurred while processing the return');
                }
            }
        }
        nextTick(() => {
            loading_bar.value.finish();
        });

    } catch (error) {

    }
};

const toggleDropDown = () => {
    const optionsDropdown = document.getElementById('productsOptionsDropDown');

    if (optionsDropdown) {
        optionsDropdown.style.display = optionsDropdown.style.display === 'none' ? 'block' : 'none';
    }
};

const showCustomerModal = async () => {
    customer.value.contact = "";
    customer.value.name = "";
    customer.value.email = "";
    customer.value.address = "";
    loyalty_customer.value.name = "";
    loyalty_customer.value.email = "";
    loyalty_customer.value.address = "";
};

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
    getReturnOrder();
    getReturnProducts();
    calculateTotals();
});

</script>

<style lang="scss" scoped>
.options-dropdown {
    background: #fff;
    position: absolute;
    top: 32px;
    z-index: 10;
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.option {
    padding: 8px;
    cursor: pointer;
}

.mt-2px {
    margin-top: 2px;
}

#productsOptionsDropDown {
    top: 37px;
}
</style>
