<template>
    <AppLayout title="POS Cart">
        <template #content>
            <div class="flex-grow-1 p-0 page-top">
                <div class="row content-margin">
                    <div class="col-lg-7 mt-18 mt-lg-0 pb-lg-0">

                        <input type="text" class="form-control form-control-solid w-100 bg-white" name="search"
                            v-model="cart.name" placeholder="Product search / Barcode" v-bind="$attrs">

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="shadow card payment-done-card p-2">
                                    <div class="row mx-1 horizontal-btn-scroller">
                                        <div class="col-md-3 mt-1 mb-1">
                                            <a href="javascript:void(0)" @click.prevent="getAllProducts"
                                                class="btn bg-light btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-200 border-active-primary btn-active-light-primary w-100 px-4 "
                                                :class="{ 'active': selectedId === null }" data-kt-button="true">
                                                <span class="fs-7 fw-bold d-block">All</span>
                                            </a>
                                        </div>
                                        <div v-for="category in categories" class="col-md-3 mt-1 mb-1">
                                            <a href="javascript:void(0)"
                                                @click.prevent="getProductsFromCategory(category.id)"
                                                class="btn bg-light btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-200 border-active-primary btn-active-light-primary w-100 px-4 "
                                                :class="{ 'active': category.id === selectedId }"
                                                @click="selectItem(category.id)" data-kt-button="true">
                                                <span class="fs-7 fw-bold d-block">{{ category.name }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row product-scroller mt-3">

                            <div v-for="product in products" class="col-md-3 col-6 cursor-pointer">
                                <div @click.prevent="selectProduct(product.id)" class="card card-flush p-3 mt-3">
                                    <!--begin::Body-->

                                    <div class="card-body text-center p-0">

                                        <!--begin::Food img-->
                                        <div class="image-container">

                                            <img src="../../../src/assets/media/stock/food/product_image.jpg"
                                                class="rounded-3 mb-4" alt="" v-if="!product.image_url" />
                                            <img :src="product.image_url" class="rounded-3 mb-4" alt=""
                                                v-if="product.image_url" />
                                        </div>
                                        <div class="text-center h-10px" v-if="product.stock_quantity <= 0">

                                            <span class="text-red-600 fw-semibold d-block fs-5 mt-1">Stock Out</span>
                                        </div>
                                        <!--end::Food img-->

                                        <!--begin::Info-->
                                        <div class="mb-2 mt-3">
                                            <!--begin::Title-->
                                            <div class="text-center h-49px"
                                                style="overflow-y: auto; -webkit-overflow-scrolling: touch;">

                                                <span class="text-gray-600 fw-semibold d-block fs-5 mt-1">{{ product.name
                                                }}</span>
                                            </div>

                                            <!--end::Title-->
                                        </div>
                                        <!--end::Info-->

                                        <!--begin::Total-->
                                        <span class="text-gray-800 fw-semibold d-block fs-3 mt-1">{{
                                            product.formatted_selling_price
                                        }}</span>
                                        <!--end::Total-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-5 mt-4 mt-lg-0 pb-lg-0">
                        <div class="shadow card payment-done-card">
                            <div class=" row">
                                <div class="col-md-12">

                                    <div class="card-body pt-0">

                                        <div class="row mt-5">
                                            <div class="col-lg-8">
                                                <a v-if="selectCustomer == null" href="#" @click="showCustomerModal()"
                                                    class="btn btn-sm fs-4 fw-bold py-2 w-100 text-sm-center text-lg-start customer-btn">&plus;
                                                    CUSTOMER</a>
                                                <a v-if="selectCustomer != null" href="#" @click.prevent="removeCustomer"
                                                    class="btn btn-sm fs-4 fw-bold py-2 w-100 text-sm-center text-lg-start customer-btn">✖
                                                    {{ selectCustomerName }}</a>
                                            </div>
                                            <div class="col-lg-4 mt-3 mt-lg-0">
                                                <a href="javascript:void(0)" @click.prevent="clearOrder"
                                                    class="btn btn-sm fs-4 fw-bold py-2 w-100 clear-btn">CLEAR</a>
                                            </div>
                                        </div>

                                        <!--begin::Table container-->
                                        <div class="table-responsive mt-3 mb-8 select_product_scroller">
                                            <!--begin::Table-->
                                            <table class="table align-middle gs-0 gy-2 my-0">
                                                <!--begin::Table head-->
                                                <thead>

                                                </thead>
                                                <!--end::Table head-->

                                                <!--begin::Table body-->
                                                <tbody>
                                                    <tr v-for="orderProduct, key in orderProducts" :key="key"
                                                        data-kt-pos-element="item" data-kt-pos-item-price="33">
                                                        <td class="text-end">
                                                            <span class="fw-bold text-gray-600 fs-7">{{ key + 1 }}</span>
                                                        </td>
                                                        <td @click.prevent="editQty(orderProduct.product_id)">
                                                            <img src="../../../src/assets/media/stock/food/product_image.jpg"
                                                                class="w-40px h-40px rounded-3"
                                                                v-if="!orderProduct.image_url" />
                                                            <img :src="orderProduct.image_url"
                                                                class="w-50px h-50px rounded-3"
                                                                v-if="orderProduct.image_url" />
                                                        </td>
                                                        <td class="pe-0 py-0"
                                                            @click.prevent="editQty(orderProduct.product_id)">
                                                            <div class="align-items-center item-name-div">

                                                                <span
                                                                    class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-6 me-1"
                                                                    style="white-space: normal;">{{
                                                                        orderProduct.product_name }}</span>
                                                            </div>
                                                        </td>


                                                        <td class="pe-0">
                                                            <!--begin::Dialer-->
                                                            <div class="position-relative d-flex align-items-center"
                                                                data-kt-dialer="true" data-kt-dialer-min="1"
                                                                data-kt-dialer-max="10" data-kt-dialer-step="1"
                                                                data-kt-dialer-decimals="0">

                                                                <!--begin::Decrease control-->
                                                                <a href="javascript:void(0)"
                                                                    @click.prevent="decreaseQty(orderProduct.product_id)"
                                                                    type="button"
                                                                    class="btn btn-sm btn-light btn-icon-gray-400 ps-1 pt-1 pb-1 pe-0"
                                                                    data-kt-dialer-control="decrease">
                                                                    <i class="bi bi-dash-lg"></i> </a>
                                                                <!--end::Decrease control-->

                                                                <!--begin::Input control-->
                                                                <input type="text"
                                                                    class="form-control border-0 text-center px-0 fs-4 fw-bold text-gray-800 w-30px"
                                                                    data-kt-dialer-control="input" placeholder="Amount"
                                                                    name="manageBudget" readonly
                                                                    :value="formatQuantity(orderProduct.quantity)" />
                                                                <!--end::Input control-->

                                                                <!--begin::Increase control-->
                                                                <a href="javascript:void(0)"
                                                                    @click.prevent="increaseQty(orderProduct.product_id)"
                                                                    type="button"
                                                                    class="btn btn-sm btn-light btn-icon-gray-400 ps-1 pt-1 pb-1 pe-0"
                                                                    data-kt-dialer-control="increase">
                                                                    <i class="bi bi-plus-lg"></i> </a>
                                                                <!--end::Increase control-->
                                                            </div>
                                                            <!--end::Dialer-->
                                                        </td>

                                                        <td class="text-end">
                                                            <span class="fw-bold text-primary fs-4"
                                                                data-kt-pos-element="item-total">{{
                                                                    orderProduct.formatted_sub_total
                                                                }}</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Table container-->

                                        <div v-if="orderProducts.length >= 1" class="row mt-5">
                                            <div class="col-6 col-lg-3">
                                                <h1 class="fw-bold text-gray-800 mb-5 fs-3 mt-3">Discount</h1>

                                            </div>
                                            <div class="col-lg-4">
                                                <a v-if="discount != 0" href="javascript:void(0)"
                                                    @click.prevent="removeDiscount"
                                                    class="btn btn-sm fs-4 fw-bold py-2 w-100 clear-btn">Remove</a>
                                            </div>
                                            <div v-if="discount == 0" class="col-6 col-lg-5">
                                                <a href="#" @click="showDiscountModal()"
                                                    class="btn btn-sm fs-4 fw-bold py-2 w-100 discount-btn">&plus;
                                                    Discount</a>
                                            </div>
                                            <div v-if="discount != 0" class="col-6 col-lg-5">
                                                <a href="#" @click="showDiscountModal()"
                                                    class="btn btn-sm fs-4 fw-bold py-2 w-100 discount-btn">Change</a>
                                            </div>
                                        </div>
                                        <div v-if="orderProducts.length == 0" class="row mt-5">
                                            <div class="col-12 mt-lg-14"></div>
                                        </div>

                                        <!--begin::Summary-->
                                        <div class="col-12 mt-2">
                                            <div class="d-flex flex-stack bg-success rounded-3 p-3 mb-3">

                                                <div class="fs-6 fw-bold text-white">
                                                    <span class="d-block lh-1 mb-2">Subtotal</span>
                                                    <span class="d-block mb-2">Discounts</span>
                                                    <span class="d-block fs-1 lh-1 mt-5">Total</span>
                                                </div>

                                                <div class="fs-6 fw-bold text-white text-end">
                                                    <span class="d-block lh-1 mb-2" data-kt-pos-element="total">LKR {{
                                                        Number(subTotal).toLocaleString('en-US', {
                                                            minimumFractionDigits: 2
                                                        }) }}</span>
                                                    <span class="d-block mb-2" data-kt-pos-element="discount">- LKR {{
                                                        Number(discount).toLocaleString('en-US', {
                                                            minimumFractionDigits: 2
                                                        }) }}</span>
                                                    <span class="d-block fs-1 lh-1 mt-5"
                                                        data-kt-pos-element="grant-total">LKR {{
                                                            Number(total).toLocaleString('en-US', { minimumFractionDigits: 2 })
                                                        }}</span>
                                                </div>

                                            </div>
                                            <!--end::Summary-->

                                            <!--begin::Paid Amount-->
                                            <div class="m-0">
                                                <h1 class="fw-bold text-gray-800 mb-1 fs-2">Paid Amount</h1>

                                                <div data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">

                                                    <input v-model="paidAmount" type="text"
                                                        class="form-control form-control-sm mb-2" placeholder="Paid amount"
                                                        @keyup="getChange" />

                                                    <div class="d-inline">
                                                        Change: LKR
                                                        <span v-if="changeAmount == 0">0.00</span>
                                                        <span v-if="changeAmount > 0" class="text-primary">{{
                                                            Number(changeAmount).toLocaleString('en-US', {
                                                                minimumFractionDigits: 2
                                                            }) }}</span>
                                                        <span v-if="changeAmount < 0" class="text-danger">{{
                                                            Number(changeAmount).toLocaleString('en-US', {
                                                                minimumFractionDigits: 2
                                                            }) }}</span>
                                                    </div>

                                                </div>

                                                <!--begin::Actions-->
                                                <div class="row mt-3" v-if="orderProducts.length >= 1">
                                                    <div class="col-lg-5">
                                                        <a href="javascript:void(0)" @click.prevent="holdCart"
                                                            class="btn fs-1 w-100 py-4 hold-btn fw-bold">HOLD</a>
                                                    </div>
                                                    <div class="col-lg-7 mt-3 mt-lg-0">
                                                        <a href="javascript:void(0)" @click.prevent="paymentDone"
                                                            class="btn fs-1 w-100 py-4 done-btn fw-bold">DONE</a>
                                                    </div>
                                                </div>
                                                <div class="row mt-3" v-if="orderProducts.length == 0">
                                                    <div class="col-lg-12 mt-3 mt-lg-0">
                                                        <button class="btn fs-1 w-100 py-4 done-btn fw-bold">Place an order
                                                            first</button>
                                                    </div>
                                                </div>
                                                <!--end::Actions-->
                                            </div>
                                        </div>
                                        <!--end::Payment Method-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #modal>
            <!-- Customer Modal -->
            <div class="modal fade" id="customerModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color: #071437">Add Customer</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"
                                @click="closeCustomerModal"></button>
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
                                            <input type="text" class="form-control form-control-sm"
                                                v-model="loyalty_customer.name" placeholder="Name" disabled />
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
                                            <input type="email" class="form-control form-control-sm"
                                                v-model="customer.email" placeholder="Email Address" required />
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4 mt-2">
                                            <span class="text-gray-600">ADDRESS</span>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control form-control-sm"
                                                v-model="customer.address" placeholder="Address" required />
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

            <!-- Discount Modal -->
            <div class="modal fade" id="discountModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color: #071437">Discount</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"
                                @click="closeDiscountModal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-8">
                                <div class="col-md-4 mt-2 text-end">
                                    <span class="text-gray-800">Subtotal</span><br>
                                    <span class="text-gray-600">{{ subTotal }}</span><br>
                                    <span class="text-gray-800">Discount</span><br>
                                    <span class="text-gray-600">{{ newDiscount ? newDiscount : 0 }}</span><br>
                                    <hr />
                                    <span class="text-gray-800">New Total</span><br>
                                    <span class="text-gray-600">{{ newTotal }}</span>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-6">
                                            <a href="javascript:void(0)"
                                                class="btn bg-light btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-200 border-active-primary btn-active-light-primary w-100 px-4 "
                                                :class="{ 'active': tabIndex === 1 }" @click="tabIndex = 1, percentage = 0"
                                                data-kt-button="true">
                                                <span class="fs-7 fw-bold d-block">Amount</span>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="javascript:void(0)"
                                                class="btn bg-light btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-200 border-active-primary btn-active-light-primary w-100 px-4 "
                                                :class="{ 'active': tabIndex === 2 }" @click="tabIndex = 2, amount = 0"
                                                data-kt-button="true">
                                                <span class="fs-7 fw-bold d-block">Percentage</span>
                                            </a>
                                        </div>
                                        <div :class="[tabIndex === 2 ? 'd-none' : '',]" class="col-12 mt-5 d-block">
                                            <input type="number" class="form-control form-control-sm" v-model="amount"
                                                placeholder="Amount" required />
                                        </div>
                                        <div :class="[tabIndex === 1 ? 'd-none' : '',]" class="col-12 mt-5 d-block">
                                            <input type="number" class="form-control form-control-sm" v-model="percentage"
                                                placeholder="Percentage" required />
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-12">
                                            <a href="javascript:void(0)" @click.prevent="addDiscount(newDiscount)"
                                                class="btn bg-light btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-200 border-active-primary btn-active-light-primary w-100 px-4 "
                                                data-kt-button="true">
                                                <span class="fs-6 fw-bold d-block">ADD DISCOUNT</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Qty Update Modal -->
            <div class="modal fade" id="qtyUpdateModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-8 mb-5">
                                    <h5 class="modal-title" style="color: #071437">{{ edit_product.name }}</h5>
                                </div>
                                <div class="col-4 mb-5 text-end">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                            <form @submit.prevent="updateQty" enctype="multipart/form-data">
                                <div class="col-form-label text-gray-600">Selling Price</div>
                                <div class="row">
                                    <div class="col-9">
                                        <input v-model="unit_price" type="text" class="form-control form-control-sm"
                                            placeholder="Unit Price" />
                                    </div>
                                    <div class="col-3 text-end">
                                        <button type="button" @click.prevent="unitPriceUpdate"
                                            class="btn btn-light-primary btn-sm w-100" style="font-weight: bold">
                                            CHANGE
                                        </button>
                                    </div>
                                </div>
                                <div class="col-form-label text-gray-600">Enter Quantity</div>
                                <div class="row">
                                    <div class="col-9">
                                        <input v-model="edit_qty.quantity" type="text" class="form-control form-control-sm"
                                            placeholder="Quantity" />
                                    </div>
                                    <div class="col-3 text-end">
                                        <button type="submit" class="btn btn-light-primary btn-sm w-100"
                                            style="font-weight: bold">
                                            UPDATE
                                        </button>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-12 text-gray-500">
                                        <hr />
                                    </div>
                                    <div class="col-9 mt-2">
                                        <span class="text-gray-600">Product remove from the cart</span>
                                    </div>
                                    <div class="col-3 text-end">
                                        <button type="button" @click.prevent="removeItem"
                                            class="btn btn-light-danger btn-sm w-100" style="font-weight: bold">
                                            REMOVE
                                        </button>
                                    </div>
                                </div>
                            </form>
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
import { onMounted, ref, watch, nextTick, computed } from 'vue';
import axios from 'axios';
import { debounce } from 'lodash';
import Swal from 'sweetalert2';
import Loader from '@/Components/Basic/LoadingBar.vue';

const loading = ref(false);
const cart = ref({ name: '', product_category_id: null });
const products = ref([]);
const orderProducts = ref([]);
const categories = ref([]);
const selectedId = ref(null);
const subTotal = ref(0);
const total = ref(0);
const discount = ref(0);
const customer = ref({});
const loyalty_customer = ref({});
const selectCustomer = ref('');
const selectCustomerName = ref('');
const orderId = ref(null);

const tabIndex = ref(1);
const amount = ref(0);
const percentage = ref(0);
const newDiscount = ref(0);
const newTotal = ref(0);

const edit_product = ref({});
const edit_qty = ref({});

const unit_price = ref('');
const paidAmount = ref('');
const changeAmount = ref(0);

const loading_bar = ref(null);

const validationErrors = ref({});

const resetValidationErrors = (error) => {
    if (!(error.response && error.response.data)) return;
    const { message } = error.response.data;
    errorMessage(message);
};

const convertValidationNotification = (error) => {
    resetValidationErrors(error);
};

const convertValidationError = (err) => {
    resetValidationErrors();
    if (!(err.response && err.response.data)) return;
    const { message, errors } = err.response.data;
    validationMessage.value = message;
    if (errors) {
        for (const error in errors) {
            validationErrors.value[error] = errors[error][0];
        }
    }
};

const getAllProducts = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const productData = (await axios.get(route('cart.products.all'))).data;
        products.value = productData;
        selectedId.value = null;
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {

    }
};

const getCategories = async () => {
    try {
        const categoryData = (await axios.get(route('categories.all'))).data;
        categories.value = categoryData;
    } catch (error) {

    }
};

const selectItem = (id) => {
    selectedId.value = id;
};

const getProductsFromCategory = async (categoryId) => {
    try {
        const productData = (await axios.get(route('products.category.all', categoryId))).data;
        products.value = productData;
    } catch (error) {

    }
};

const onSearchByNameBarcode = debounce(async () => {
    try {
        if (cart.value.name.length < 1) {
            getAllProducts();
        } else {
            loading.value = true;
            searchByName(cart.value.name, selectedId.value);
        }
    } catch (error) {
    }
}, 250);

const searchByName = async (name, product_category_id) => {
    try {
        if (product_category_id === null) {
            product_category_id = 0;
        }

        const filter_letter = {
            name: name,
            product_category_id: product_category_id,
        };

        const res = await axios.post(route('product.name.all'), filter_letter);
        products.value = res.data;
        loading.value = false;
    } catch (error) {
        loading.value = false;
    }
};

const selectProduct = async (product_id) => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const productData = (await axios.get(route('cart.select.product', product_id))).data;
        getOderProduct();
        calculateTotals();
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {

    }
};

const getOderProduct = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const orderProductData = (await axios.get(route('cart.get.products'))).data;
        orderProducts.value = orderProductData;
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {

    }
};

const formatQuantity = (quantity) => {
    return Number(quantity).toFixed(0);
};

const clearOrder = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        (await axios.get(route('cart.clear.order'))).data;
        successMessage('Clearing the order is successful');
        paidAmount.value = '';
        getOderProduct();
        calculateTotals();
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
        const order = (await axios.get(route('cart.getsubtotal.order'))).data;
        const formattedSubTotal = Number(order.sub_total).toFixed(2);
        const formattedTotal = Number(order.total).toFixed(2);
        const formattedDiscount = Number(order.discount).toFixed(2);
        const formattedBalance = Number(order.balance).toFixed(2);
        selectCustomer.value = order.customer_id;
        selectCustomerName.value = order.customer_name;
        orderId.value = order.id;
        subTotal.value = formattedSubTotal;
        total.value = formattedTotal;
        discount.value = formattedDiscount;

        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {

    }

    getChange();
};

const getChange = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const changeValue = paidAmount.value - total.value;
        changeAmount.value = Number(changeValue).toFixed(2);
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {

    }
};

const decreaseQty = async (product_id) => {
    nextTick(() => {
        loading_bar.value.start();
    });
    (await axios.get(route('cart.decrease.product', product_id))).data;
    getOderProduct();
    calculateTotals();
    nextTick(() => {
        loading_bar.value.finish();
    });
};

const increaseQty = async (product_id) => {
    nextTick(() => {
        loading_bar.value.start();
    });
    (await axios.get(route('cart.increase.product', product_id))).data;
    getOderProduct();
    calculateTotals();
    nextTick(() => {
        loading_bar.value.finish();
    });
};

const editQty = async (product_id) => {
    try {
        const response = (await axios.get(route("product.get", product_id))).data;
        edit_product.value = response;

        $('#qtyUpdateModal').modal('show');
    } catch (error) {
        convertValidationNotification(error);
    }
};

const updateQty = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {

        await axios.post(route("cart.product.qty", edit_product.value.id), edit_qty.value, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        successMessage('Updated new quantity');

        edit_qty.value = {};

        $('#qtyUpdateModal').modal('hide');

        getOderProduct();
        calculateTotals();

        nextTick(() => {
            loading_bar.value.finsh();
        });
    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });
        convertValidationNotification(error);
    }
};

const removeItem = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {

        (await axios.get(route('cart.remove.product', edit_product.value.id))).data;
        successMessage('Item removed');

        $('#qtyUpdateModal').modal('hide');

        getOderProduct();
        calculateTotals();

        nextTick(() => {
            loading_bar.value.finsh();
        });
    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });
        convertValidationNotification(error);
    }
};

const unitPriceUpdate = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {

        await axios.post(route('cart.update.unit.price'), {
            product_id: edit_product.value.id,
            unit_price: unit_price.value
        });
        successMessage('Selling price changed');

        getOderProduct();
        calculateTotals();

        unit_price.value = "";

        $('#qtyUpdateModal').modal('hide');

        nextTick(() => {
            loading_bar.value.finsh();
        });
    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });
        convertValidationNotification(error);
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
    $("#customerModal").modal("show");
};

const closeCustomerModal = async () => {
    $("#customerModal").modal("hide");
};

const showDiscountModal = async () => {
    $("#discountModal").modal("show");
};

const closeDiscountModal = async () => {
    $("#discountModal").modal("hide");
};

const showTaxModal = async () => {
    $("#taxModal").modal("show");
};

const closeTaxModal = async () => {
    $("#taxModal").modal("hide");
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
            const customer_all_details = (await axios.post(route('cart.update'), customer)).data;
            selectCustomer.value = customer_all_details.customer_id;
            selectCustomerName.value = customer_all_details.customer_name;
            closeCustomerModal();
            successMessage('Customer selected successfully');
        }
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });
    }
};

const removeCustomer = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        await axios.get(route('customer.remove', orderId.value));
        selectCustomer.value = null;
        successMessage('Successfully removed the customer');
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {

    }
};

const holdCart = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        axios.get(route('cart.hold'));
        window.location.href = route("cart.index");
        successMessage('Holding the order is successful');
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });

    }
};

const addDiscount = async (newDiscount) => {
    nextTick(() => {
        loading_bar.value.start();
    });
    if (amount.value < 0) {
        amount.value = 0;
        errorMessage('The discount amount should be more than 0');
    } else if (amount.value > subTotal.value) {
        amount.value = 0;
        errorMessage('The discount amount should be less than the subtotal');
    } else if (percentage.value > 100) {
        percentage.value = 0;
        errorMessage('Discount percentage should be less than 100%');
    } else if (percentage.value < 0) {
        percentage.value = 0;
        errorMessage('The discount percentage should be more than 0%');
    } else {
        const discount_data = {
            discountType: tabIndex.value,
            discountAmount: newDiscount,
            orderId: orderId.value,
        };
        await axios.post(route('cart.discount'), discount_data);
        calculateTotals();
        closeDiscountModal();
        successMessage('The discount is successful');
    }
    nextTick(() => {
        loading_bar.value.finish();
    });

};

const removeDiscount = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        await axios.get(route('remove.discount', orderId.value));
        calculateTotals();
        successMessage('Removing the discount is successful');
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });

    }
};

const paymentDone = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {

        if (changeAmount.value < 0 && selectCustomer.value == null) {
            errorMessage('Please select a customer');
        } else {

            const data = {
                order_id: orderId.value,
                customer_id: selectCustomer.value,
                order_total: total.value,
                paid_amount: paidAmount.value,
                balance: changeAmount.value,
            }

            await axios.post(route('order.done'), data);

            const print = await axios.get(route('payment.print', orderId.value), { responseType: "blob" });
            const url = window.URL.createObjectURL(print.data);
            window.open(url, "_blank");

            successMessage('Order is successful');

            window.location.href = route("cart.index");

        }
        nextTick(() => {
            loading_bar.value.finish();
        });

    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });
    }
};

watch(() => cart.value.name, () => {
    onSearchByNameBarcode();
});

watch([amount, subTotal], () => {
    const formattedNewDiscount = Number(amount.value).toFixed(2);
    newDiscount.value = formattedNewDiscount;
    const formattedNewTotal = Number(subTotal.value - amount.value).toFixed(2);
    newTotal.value = formattedNewTotal;
});
watch([percentage, subTotal], () => {
    const formattedNewDiscount = Number(subTotal.value * (percentage.value / 100)).toFixed(2);
    newDiscount.value = formattedNewDiscount;
    const formattedNewTotal = Number(subTotal.value - newDiscount.value).toFixed(2);
    newTotal.value = formattedNewTotal;
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
    getAllProducts();
    getCategories();
    getOderProduct();
    calculateTotals();
});

</script>

<style lang="scss" scoped></style>
