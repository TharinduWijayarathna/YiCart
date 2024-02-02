<template>
    <AppLayout title="Credit Management">
        <template #content>
            <div class="flex-grow-1 p-0 page-top">
                <div class="row content-margin2">
                    <div class="col-lg-12 mt-20 mt-lg-0">
                        <div class="d-flex justify-content-start align-items-center col-form-label mt-5 mt-lg-0">
                            <h1 style="margin-right: auto; font-size: 28px; color: #071437">
                                Credit Bill Management
                            </h1>
                        </div>

                        <div class="card shadow mb-9">
                            <div class="py-2 text-sm card-body">

                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5 mt-5">
                                            <thead>
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                    <!-- <th class="ps-3">CUSTOMER TYPE</th> -->
                                                    <th class="ps-3">CUSTOMER NAME</th>
                                                    <th class="text-end">ORDER AMOUNT</th>
                                                    <th class="text-end pe-3">PAID AMOUNT</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                                <tr>
                                                    <!-- <td class="py-2 ps-3">{{ order.customer_type }}</td> -->
                                                    <td class="py-2 ps-3">{{ order.customer_name }}</td>
                                                    <td class="text-end py-2">{{ order.formatted_total }}</td>
                                                    <td class="text-end py-2 pe-3">{{ order.formatted_customer_paid }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card shadow">
                            <div class="py-3 text-sm card-body">

                                <div class="row">
                                    <div class="col-12 col-md-6 mt-3">
                                        <span class="pe-5 fs-4 text-gray-600">PAYMENTS</span>
                                        <button class="btn btn-light-primary btn-sm py-2" style="font-weight: bold"
                                            data-bs-toggle="modal" @click="clearFields" data-bs-target="#paymentModal">
                                            <i class="bi bi-wallet2"></i> ADD PAYMENT
                                        </button>
                                    </div>
                                    <div class="col-12 col-md-6 text-end mt-3">
                                        <span class="ps-2 pe-2 fs-4 text-danger">DUE PAYMENT : {{ (order.total -
                                            order.customer_paid).toLocaleString('en-US', {
                                                minimumFractionDigits:
                                                    2
                                            }) }}</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5 mt-5">
                                            <thead>
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                    <th class="ps-3">BILL NO.</th>
                                                    <th>DATE</th>
                                                    <th>REMARK</th>
                                                    <th class="text-end pe-3">AMOUNT</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                                <tr v-for="(bill, index) in bills" :key="index"
                                                    onmouseover="this.style.backgroundColor='#F2F4F4'; this.style.cursor='pointer';"
                                                    onmouseout="this.style.backgroundColor='#ffffff';">
                                                    <td class="py-2 ps-3">{{ bill.code }}</td>
                                                    <td class="py-2">{{ bill.date }}</td>
                                                    <td class="py-2">{{ bill.remark }}</td>
                                                    <td class="text-end py-2 pe-3">{{ bill.formatted_accepted_amount }}</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-end text-gray-700 fs-4">Total:</td>
                                                    <td class="text-end text-gray-700 fs-4 pe-3">{{
                                                        order.formatted_customer_paid }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
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

    <!-- Add Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color: #071437">PAYMENT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form @submit.prevent="savePayment" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="col-form-label text-gray-600">Amount</div>
                        <input v-model="payment.balance" type="text" class="form-control form-control-sm"
                            placeholder="Enter paid amount" />
                        <div class="col-form-label text-gray-600 mt-2">Remark</div>
                        <textarea v-model="payment.remark" class="form-control" placeholder="Enter payment remark"
                            data-kt-autosize="true" style="resize: none; font-size: 12px;" rows="2"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-light-primary me-2 mt-2" style="font-weight: bold">
                            ADD
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { onMounted, ref, nextTick } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import { usePage } from '@inertiajs/vue3'
import Loader from '@/Components/Basic/LoadingBar.vue';

const { props } = usePage();
const order = props.order;

const bills = ref([]);

const payment = ref({});

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

const getBills = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const tableData = (await axios.get(route('credit.bill.all', order.id))).data;
        bills.value = tableData;
        nextTick(() => {
            loading_bar.value.finish();
        });
    } catch (error) {

    }
};

const savePayment = async () => {
    nextTick(() => {
        loading_bar.value.start();
    });
    try {
        const response = (await axios.post(route("payment.credit.bill", order.id), payment.value)).data;
        successMessage('Payment successfully!');

        $('#paymentModal').modal('hide');
        window.location.href = route("credit.edit", order.id);
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

function clearFields() {
    payment.value = {};
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
    getBills();
});

</script>

<style lang="scss" scoped></style>
