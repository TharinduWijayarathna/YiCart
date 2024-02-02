<template>
    <AppLayout title="Settings">
        <template #content>
            <div class="flex-grow-1 p-0 page-top">
                <div class="row content-margin2">
                    <div class="col-lg-12 mt-20 mt-lg-0">
                        <div class="d-flex justify-content-start align-items-center col-form-label mt-5 mt-lg-0">
                            <h1 style="margin-right: auto; font-size: 28px; color: #071437">
                                Business Details
                            </h1>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-8 py-0">

                                <div class="card shadow h-100">
                                    <div class="py-3 text-sm card-body">

                                        <div class="row px-md-7 px-xl-10">
                                            <div class="col-12 mt-4">
                                                <div v-if="edit_business.image_url" class="border p-1"
                                                    style="position: relative; display: inline-block;">
                                                    <a @click.prevent="removeLogo(edit_business.id)"
                                                        href="javascript:void(0)" class="mt-1 me-1"
                                                        style="position: absolute; top: 0; right: 0;"><i
                                                            class="bi bi-x-lg"></i></a>
                                                    <img :src="edit_business.image_url" class="rounded-3 mb-4" alt=""
                                                        height="100" />
                                                </div>
                                                <img src="../../../src/logo/logo_b.png" class="rounded-3 mb-4" alt=""
                                                    height="100" v-if="!edit_business.image_url" />
                                            </div>
                                            <div v-if="edit_business.length <= 0" class="col-12">
                                                <form @submit.prevent="saveDetails" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-5 mt-3">
                                                            <div class="col-form-label text-gray-600">Business Logo</div>
                                                        </div>
                                                        <div class="col-12 col-lg-7 mt-3">
                                                            <input type="file" ref="fileInput" accept="image/jpg, image/png"
                                                                id="business_logo" class="form-control form-control-sm"
                                                                @change="onFileChange" />
                                                        </div>
                                                        <div class="col-12 col-lg-5 mt-3">
                                                            <div class="col-form-label text-gray-600">Business Name</div>
                                                        </div>
                                                        <div class="col-12 col-lg-7 mt-3">
                                                            <input v-model="business.name" type="text"
                                                                class="form-control form-control-sm"
                                                                placeholder="Business name" />
                                                        </div>
                                                        <div class="col-12 col-lg-5 mt-3">
                                                            <div class="col-form-label text-gray-600">Address</div>
                                                        </div>
                                                        <div class="col-12 col-lg-7 mt-3">
                                                            <input v-model="business.address" type="text"
                                                                class="form-control form-control-sm"
                                                                placeholder="Business address" />
                                                        </div>
                                                        <div class="col-12 col-lg-5 mt-3">
                                                            <div class="col-form-label text-gray-600">Phone Number</div>
                                                        </div>
                                                        <div class="col-12 col-lg-7 mt-3">
                                                            <input v-model="business.mobile" type="text"
                                                                class="form-control form-control-sm"
                                                                placeholder="Phone number" />
                                                        </div>
                                                        <div class="col-12 col-lg-5 mt-3">
                                                            <div class="col-form-label text-gray-600">Email</div>
                                                        </div>
                                                        <div class="col-12 col-lg-7 mt-3">
                                                            <input v-model="business.email" type="email"
                                                                class="form-control form-control-sm" placeholder="Email" />
                                                        </div>
                                                        <div class="col-12 col-lg-5 mt-3">
                                                            <div class="col-form-label text-gray-600">Footer</div>
                                                        </div>
                                                        <div class="col-12 col-lg-7 mt-3">
                                                            <input v-model="business.footer" type="text"
                                                                class="form-control form-control-sm"
                                                                placeholder="Footer text" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 mt-4 text-end">
                                                            <button type="submit" class="btn btn-light-primary"
                                                                style="font-weight: bold">
                                                                SAVE
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div v-else class="col-12">
                                                <form @submit.prevent="updateDetails" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3 mt-3">
                                                            <div class="col-form-label text-gray-600">Business Logo</div>
                                                        </div>
                                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9 mt-3">
                                                            <input type="file" ref="fileInput" accept="image/jpg, image/png"
                                                                id="business_logo" class="form-control form-control-sm"
                                                                @change="onFileChangeEdit" />
                                                        </div>
                                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3 mt-3">
                                                            <div class="col-form-label text-gray-600">Business Name</div>
                                                        </div>
                                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9 mt-3">
                                                            <input v-model="edit_business.name" type="text"
                                                                class="form-control form-control-sm"
                                                                placeholder="Business name" />
                                                        </div>
                                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3 mt-3">
                                                            <div class="col-form-label text-gray-600">Address</div>
                                                        </div>
                                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9 mt-3">
                                                            <input v-model="edit_business.address" type="text"
                                                                class="form-control form-control-sm"
                                                                placeholder="Business address" />
                                                        </div>
                                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3 mt-3">
                                                            <div class="col-form-label text-gray-600">Phone Number</div>
                                                        </div>
                                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9 mt-3">
                                                            <input v-model="edit_business.mobile" type="text"
                                                                class="form-control form-control-sm"
                                                                placeholder="Phone number" />
                                                        </div>
                                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3 mt-3">
                                                            <div class="col-form-label text-gray-600">Email</div>
                                                        </div>
                                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9 mt-3">
                                                            <input v-model="edit_business.email" type="email"
                                                                class="form-control form-control-sm" placeholder="Email" />
                                                        </div>
                                                        <div class="col-12 col-md-5 col-lg-4 col-xl-3 mt-3">
                                                            <div class="col-form-label text-gray-600">Footer</div>
                                                        </div>
                                                        <div class="col-12 col-md-7 col-lg-8 col-xl-9 mt-3">
                                                            <input v-model="edit_business.footer" type="text"
                                                                class="form-control form-control-sm"
                                                                placeholder="Footer text" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 mt-4 text-end mb-3">
                                                            <button type="button" @click="resetDetails()"
                                                                class="btn btn-light-danger me-3" style="font-weight: bold">
                                                                RESET
                                                            </button>
                                                            <button type="submit" class="btn btn-light-primary"
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
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">

                                <div class="card shadow h-100">
                                    <div class="py-3 text-sm card-body">
                                        <div class="row px-md-7 px-xl-10 py-5">

                                            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th width="25%">

                                                            <img v-if="edit_business.image_url"
                                                                :src="edit_business.image_url" class="brand-logo"  width="100" />
                                                            <img v-if="!edit_business.image_url" src="logo/logo_b.png"
                                                                class="brand-logo"  width="100"  />
                                                        </th>
                                                        <th width="75%">

                                                            <div v-if="edit_business.name" class="header-title text-center">
                                                                {{ edit_business.name }}</div>

                                                            <div v-if="edit_business.address"
                                                                class="header-sub-title text-center">{{
                                                                    edit_business.address }}
                                                            </div>

                                                            <div v-if="edit_business.email"
                                                                class="header-sub-title text-center">{{ edit_business.email
                                                                }}
                                                            </div>

                                                            <div v-if="edit_business.mobile"
                                                                class="header-sub-title text-center mb-3">{{
                                                                    edit_business.mobile }}</div>


                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>

                                            <table cellspacing="0" cellpadding="0" border="0" width="100%"
                                                class="top-margin">
                                                <thead>
                                                    <tr class="heading-bg-po">
                                                        <th width="40%">
                                                            <div class="sub-title text-left">Invoice No : #C00000</div>
                                                        </th>
                                                        <th>
                                                            <div class="sub-title text-left">Customer : </div>
                                                        </th>
                                                        <th>
                                                            <div class="sub-title text-left">Walking Customer</div>
                                                        </th>
                                                    </tr>
                                                    <tr class="heading-bg-po">
                                                        <th width="60%">
                                                            <div class="sub-title text-left">Cashier : Fernando</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <table cellspacing="0" cellpadding="0" border="0" width="100%"
                                                class="item-section">
                                                <thead class="">
                                                    <tr class="row-bg" style="height: 50px;">
                                                        <td colspan="2" align="center" class="td-style">
                                                            <b>Code</b>
                                                            <br />
                                                            <b>Product Name</b>
                                                        </td>
                                                        <td width="17%" align="end" class="td-style ">
                                                            <b>Qty</b>
                                                        </td>
                                                        <td width="25%" align="end" class="td-style ">
                                                            <b>Rate (Rs)</b>
                                                            <br />
                                                            <b>Total</b>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody class="">
                                                    <tr class="row-bg">
                                                        <td colspan="2" align="left">
                                                            <div class="invoice-item-text item-margin">
                                                                <b>P00000</b>
                                                                <div class="dotted-line-hr"></div>
                                                                <p style="word-wrap: break-word;"><b>Product 01</b></p>
                                                            </div>
                                                        </td>
                                                        <td width="17%" align="end" class="right-text-qty pe-0">
                                                            <div class="invoice-item-text-qty item-margin">
                                                                <b>2</b>
                                                            </div>
                                                        </td>
                                                        <td width="25%" align="left"
                                                            class="right-text invoice-item-text pe-0">
                                                            <div class="invoice-item-text item-margin">
                                                                <b>500.00</b>
                                                                <br />
                                                                <b>1,000.00</b>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table cellspacing="0" cellpadding="0" border="0" width="100%"
                                                class="item-section">
                                                <tbody class=" total-text top-margin">
                                                    <tr class="row-bg">
                                                        <td width="60%" class="right-text bold-text"
                                                            style="text-align: right">
                                                            Sub Total
                                                            <br />
                                                            Discount

                                                        </td>
                                                        <td width="40%" class="right-text bold-text pe-0"
                                                            style="text-align: right">
                                                            1,000.00
                                                            <br />
                                                            100.00

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="100%" colspan="2">
                                                            <div class="line-hr"></div>
                                                        </td>
                                                    </tr>
                                                    <tr class="row-bg">
                                                        <td width="60%" class="right-text bold-text"
                                                            style="text-align: right">
                                                            Total

                                                        </td>
                                                        <td width="40%" class="right-text bold-text pe-0"
                                                            style="text-align: right">
                                                            900.00

                                                        </td>
                                                    </tr>
                                                    <tr class="row-bg">
                                                        <td width="60%" class="right-text bold-text"
                                                            style="text-align: right">
                                                            Cash Paid

                                                        </td>
                                                        <td width="40%" class="right-text bold-text pe-0"
                                                            style="text-align: right">
                                                            1,000.00

                                                        </td>
                                                    </tr>
                                                    <tr class="row-bg">
                                                        <td width="60%" class="right-text bold-text"
                                                            style="text-align: right">
                                                            Balance

                                                        </td>
                                                        <td width="40%" class="right-text bold-text pe-0"
                                                            style="text-align: right">
                                                            100.00

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table cellspacing="0" cellpadding="0" border="0" width="100%"
                                                class="section-table">
                                                <tbody>
                                                    <tr class="row-bg">
                                                        <td align="center">
                                                            <img :src="barcodeDataURL" height="50" width="180" />
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table cellspacing="0" cellpadding="0" border="0" width="100%"
                                                class="section-footer">
                                                <thead>
                                                    <tr>
                                                        <td class="footer-content">
                                                            <b> Date & Time 2023-10-24 02:53:43 AM </b>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <table cellspacing="0" cellpadding="0" border="0" width="100%" class="">
                                                <thead>
                                                    <tr>
                                                        <td class="terms">
                                                            <b>
                                                                <div v-if="edit_business.footer">
                                                                    {{ edit_business.footer }}
                                                                </div>
                                                                <div v-if="!edit_business.footer">
                                                                    *Thank you for your visit*
                                                                </div>
                                                            </b>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
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
            <!-- Reset Confirmation Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to reset business details?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-darkr" style="font-weight: bold"
                                data-bs-dismiss="modal">
                                CANCEL
                            </button>
                            <button type="button" class="btn btn-light-danger" style="font-weight: bold"
                                @click.prevent="confirmReset(edit_business.id)">
                                <i class="bi bi-arrow-clockwise"></i>
                                RESET
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
import bwipjs from 'bwip-js';

const business = ref({});
const edit_business = ref({});
const business_logo = ref(null);
const edit_business_logo = ref(null);

const code = ref('C00000');
const barcodeDataURL = ref('');

const loading_bar = ref(null);

const validationErrors = ref({});
const validationMessage = ref(null);

const onFileChange = (e) => {
    business.value.image = e.target.files[0];
    business_logo.value = e.target.files[0];
};

const onFileChangeEdit = (e) => {
    edit_business.value.image = e.target.files[0];
    edit_business_logo.value = e.target.files[0];

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

const getBusinessDetails = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const response = (await axios.get(route("configuration.get"))).data;
        edit_business.value = response;

        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {
        nextTick(() => {
            loading_bar.value.finish();
        });
    }
};

const saveDetails = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        await axios.post(route('configuration.store'), business.value, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        successMessage('Your Business Details Saved successfully!');

        business.value = {};
        business_logo.value = null;

        const fileInput = document.getElementById('business_logo');
        fileInput.value = null;

        getBusinessDetails();

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

const updateDetails = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {

        if (edit_business_logo.value != null) {
            edit_business.value.image = edit_business_logo.value;
        } else {
            edit_business.value.image = null;
        }

        await axios.post(route("configuration.update", edit_business.value.id), edit_business.value, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        successMessage('Business details updated successfully!');

        getBusinessDetails();

        window.location.href = route("configuration.index");

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

const resetDetails = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {

        $('#deleteModal').modal('show');
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

const removeLogo = async (id) => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const response = (await axios.get(route("configuration.logo.remove", id))).data;

        getBusinessDetails();
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

const confirmReset = async (id) => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const response = (await axios.delete(route("configuration.delete", id))).data;
        successMessage('Business details reset successfully!');

        $('#deleteModal').modal('hide');
        getBusinessDetails();
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

const generateBarcode = async () => {
    const canvas = document.createElement('canvas');
    bwipjs.toCanvas(canvas, {
        bcid: 'code128',
        text: code.value,
        scale: 3,
        includetext: false,
        textxalign: 'center',
        textsize: 16
    });

    barcodeDataURL.value = canvas.toDataURL();
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
    getBusinessDetails();
    generateBarcode();
});

</script>

<style lang="css" scoped>
.item-margin {
    margin-bottom: 5px;
}

.top-margin {
    margin-top: 10px;
}

.page_break {
    page-break-before: always;
}

.right-text {
    font-family: 'Consolas', monospace;
    text-align: right;
    padding-right: 5px;
    font-size: .7rem;
}

.right-text-qty {
    font-family: 'Consolas', monospace;
    text-align: right;
    padding-right: 4px;
    font-size: .5rem;
}

.bold-text {
    font-weight: bold;
}

.row-style {
    padding-left: 0px;
    padding-right: 0px;
    padding-top: 0px;
    padding-bottom: 0px;
}

.row-bg {
    background-color: #ffffff;
}

.row-bg-subtotal {
    background-color: #e8e8e8c4;
}

.row-bg-head {
    background-color: #dcdcdcb1;
}

.row-white {
    background-color: #ffffff;
}

.td-style {
    font-family: 'Consolas', monospace;
    font-size: 12px;
    font-weight: 400;
    line-height: 17px;
    padding-left: 10px;
    padding-bottom: 3px;
    padding-top: 3px;
}

.td-style-head {
    font-family: 'Consolas', monospace;
    font-size: 14px;
    font-weight: 400;
    line-height: 20px;
    padding-left: 10px;
    padding-bottom: 1px;
    padding-top: 1px;
}

.td-style-gt {
    font-family: 'Consolas', monospace;
    font-size: 14px;
    font-weight: 400;
    line-height: 17px;
    padding-left: 10px;
    padding-bottom: 6px;
    padding-top: 6px;
}

.signature {
    text-align: center;
    line-height: 10px;
}

.signature-section {
    margin-top: 50px;
}

.material-img {
    height: 120px;
    position: fixed;
    right: 150px;
    top: 160px;
    z-index: 999999;
    padding: 5px 0px 5px 0px;
}

.border-mb {
    border-bottom: #000000 solid 1px;
}

.border-mt {
    border-top: #000000 solid 1px;
}

.border-b {
    border-bottom: #000000 solid 1px;
}

.border-t {
    border-top: #000000 solid 1px;
}

.border-l {
    border-left: #000000 solid 1px;
}

.border-r {
    border-right: #000000 solid 1px;
}

.brand-logo {
    width: 70px;
    padding-bottom: 5px;
    padding-top: 2px;
}

.invoice-head {
    font-family: 'Consolas', monospace !important;
    font-size: 1.5rem;
}

.company-title {
    font-family: 'Consolas', monospace !important;
    font-size: 1rem;
    font-weight: 400;
}

.sub-title {
    font-family: 'Consolas', monospace !important;
    font-size: 0.6rem;
}

.header-title {
    font-family: 'Liberation Mono' !important;
    font-size: 1.3rem;
    font-weight: bold;
}

.header-sub-title {
    font-family: 'Consolas', monospace !important;
    font-size: 0.8rem;
}

.text-left {
    text-align: left;
}

.company-address {
    font-family: 'Consolas', monospace !important;
    font-size: 0.8rem;
}

.company-tel {
    font-family: 'Consolas', monospace !important;
    font-size: 0.6rem;
}

.company-mail {
    font-family: 'Consolas', monospace !important;
    font-size: 0.6rem;
}

.invoice-item-text {
    font-family: 'Consolas', monospace;
    font-size: 0.7rem;
    /* font-weight: 300; */
}

.invoice-item-text-qty {
    font-family: 'Consolas', monospace;
    font-size: 0.7rem;
    /* font-weight: 300; */
}

.total-text {
    font-family: 'Consolas', monospace !important;
    font-size: 0.6rem;
    /* font-weight: 300; */
}


.heading-bg {
    background-color: #e8e8e8c4;
}

.heading-bg-po {
    font-family: 'Consolas', monospace;
    background-color: #ffffff7d;
    color: #2b2b2b;
}

.total-bg {
    background-color: #e8e8e8c4;
    padding-right: 10px;
    font-family: 'Consolas', monospace;
    font-size: 10px;
    font-weight: 400;
    line-height: 20px;
    padding-left: 10px;
    padding-bottom: 5px;
}

.total-txt {
    text-align: left;
    padding-left: 10px;
    font-family: 'Consolas', monospace;
    font-size: 10px;
    font-weight: 400;
    line-height: 20px;
    font-weight: bold;
}

.total-value {
    text-align: right;
    font-family: 'Consolas', monospace;
    font-size: 10px;
    font-weight: 400;
    line-height: 20px;
    font-weight: bold;
}

.table-heading {
    font-family: 'Consolas', monospace !important;
    padding-left: 15px;
    font-size: 12px;
}

.footer-content {
    font-family: 'Consolas', monospace !important;
    text-align: center;
    font-size: 8px;
}

.section-table {
    margin-bottom: 20px;
}

.section-footer {
    margin-top: 20px;
    margin-bottom: 20px;
}

.section-table {
    margin-bottom: 20px;
}

.section-table {
    margin-top: 20px;
}

.note-area {
    border-bottom: #c8c8c8ab solid 1px;
    border-top: #c8c8c8ab solid 1px;
    border-left: #c8c8c8ab solid 1px;
    border-right: #c8c8c8ab solid 1px;
    border-radius: 5px;
    margin-top: 50px;
}

.text {
    text-align: left;
    margin-top: 20px;
    padding-bottom: 20px;
    margin-left: 20px;
}

.text-head {
    font-family: 'Consolas', monospace;
    font-size: 30px;
    font-weight: bold;
}

.text-body {
    font-family: 'Consolas', monospace;
    font-size: 15px;
}

.text-tc {
    font-family: 'Consolas', monospace !important;
    font-size: 12px;
    line-height: 20px;
}

.vendor-info {
    font-family: 'Consolas', monospace !important;
    font-size: 10px;
    line-height: 5px;
}

.item-section {
    margin-top: 5px;
}

.terms {
    font-family: 'Consolas', monospace;
    font-size: 0.6rem;
    text-align: center;
}

.invoice-order-item {
    border-bottom: #000000 solid 1px;
}

.line-hr {
    border-bottom: #000000 solid 1px;
}

.dotted-line-hr {
    border-bottom: #000000 dotted 1px;
}</style>

