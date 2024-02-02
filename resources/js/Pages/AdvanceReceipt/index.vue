<template>
    <AppLayout title="Advance Receipt">
        <template #header>
            <div class="header pb-6">
                <div class="container-fluid">
                    <div class="header-body row">
                        <div class="col-lg-8 align-items-center py-4">
                            <h6 class="h2 text-dark d-inline-block mb-0">Advance Receipt Management</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-block">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item">
                                        <!-- <Link href="/"> -->
                                        <font-awesome-icon icon="fa-solid fa-house" color="#505050" />
                                        <!-- </Link> -->
                                    </li>
                                    <li class="breadcrumb-item active text-dark" aria-current="page">
                                        Advance Receipt Management
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <!-- <div class="py-4 text-right col-lg-4">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#newadvanceReceiptModal"
                                class="btn btn-sm btn-neutral float-end" @click.prevent="FirstTab">
                                <font-awesome-icon icon="fa-solid fa-circle-plus" /> ADD NEW
                            </a>
                        </div> -->
                    </div>
                </div>
            </div>
        </template>
        <template #content>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow">

                        <div class="py-3 mx-3 text-sm card-body">
                            <div class="flex">
                                <div class="flex items-center text-muted">
                                    Search:
                                    <div class="inline-block ml-2">
                                        <input type="text" class="form-control form-control-sm" v-model="search"
                                            @keyup="getSearch" />
                                    </div>
                                </div>
                                <div class="flex text-muted ml-auto">
                                    Show
                                    <div class="inline-block mx-2">
                                        <select class="form-control form-control-sm per-page-entry" :value="25"
                                            v-model="pageCount" @change="perPageChange">
                                            <option v-for="perPageCount in perPage" :key="perPageCount"
                                                :value="perPageCount" v-text="perPageCount" />
                                        </select>
                                    </div>
                                    entries
                                </div>
                            </div>
                        </div>

                        <div class="row mx-4">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <!-- <th :class="textClassHead"></th> -->
                                            <th :class="textClassHead">#</th>
                                            <th :class="textClassHead">Order No</th>
                                            <th :class="textClassHead">Receipt No</th>
                                            <th :class="textClassHead">Date</th>
                                            <th :class="textClassHead">Remark</th>
                                            <th :class="valueClassHead">Amount</th>
                                            <th :class="valueClassHead"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(receipt, index) in receipts" :key="receipt.id" :class="rowClass">
                                            <!-- <td :class="textClassBody">
                                                <a href="javascript:void(0)" @click.prevent="printAdvanceReceipt(receipt.order_id)"
                                                    class="btn btn-sm btn-round btn-outline-success btn-md mb-0">
                                                    <font-awesome-icon icon="fa-solid fa-print" />
                                                </a>
                                            </td> -->
                                            <td :class="textClassBody">
                                                {{ ++index }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ receipt.order_no }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ receipt.receipt_no }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ receipt.date }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ receipt.remark }}
                                            </td>
                                            <td :class="valueClassBody">
                                                {{ receipt.format_amount }}
                                            </td>
                                            <td :class="valueClassBody">
                                                <a href="javascript:void(0)" @click.prevent="editAdvanceReceipt(receipt.order_id)"
                                                    class="m-2">
                                                    <font-awesome-icon icon="fa-solid fa-pen" />
                                                </a>
                                                <a href="javascript:void(0)"
                                                    @click.prevent="printAdvanceReceipt(receipt.order_id)" class=" mb-0">
                                                    <font-awesome-icon icon="fa-solid fa-print" />
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="flex mt-1 px-3 mx-1 card-footer table-footer align-items-center">
                            <div class="col-sm-12 col-md-6 p-0">
                                <div class="dataTables_info column__left___padding" id="DataTables_Table_0_info"
                                    role="status" aria-live="polite">
                                    Showing {{ pagination.from }} to {{ pagination.to }} of
                                    {{ pagination.total }} entries
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 p-0">
                                <div class="dataTables_paginate paging_simple_numbers column__right___padding"
                                    id="DataTables_Table_0_paginate">
                                    <nav aria-label="Page navigation" style="float: right">
                                        <ul class="pagination">
                                            <li class="page-item" :class="pagination.current_page == 1 ? 'disabled' : ''">
                                                <a class="page-link" href="javascript:void(0)"
                                                    @click="setPage(pagination.current_page - 1)">
                                                    <i class="fa-solid fa-angles-left"></i>
                                                </a>
                                            </li>
                                            <template v-for="(page, index) in pagination.last_page">
                                                <template v-if="
                                                    page == 1 ||
                                                    page == pagination.last_page ||
                                                    Math.abs(page - pagination.current_page) < 5
                                                ">
                                                    <li class="page-item" :key="index"
                                                        :class="pagination.current_page == page ? 'active' : ''">
                                                        <a class="page-link" @click="setPage(page)">{{ page }}</a>
                                                    </li>
                                                </template>
                                            </template>
                                            <li class="page-item" :class="
                                                pagination.current_page == pagination.last_page
                                                    ? 'disabled'
                                                    : ''
                                            ">
                                                <a class="page-link" href="javascript:void(0)"
                                                    @click="setPage(pagination.current_page + 1)">
                                                    <i class="fa-solid fa-angles-right"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <template #modal>
            <div class="modal fade" id="editAdvanceReceiptModal" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="editAdvanceReceiptModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="pb-0 modal-header">
                            <h5 class="modal-title font-weight-bolder text-info text-gradient" id="add_brandLabel">
                                EDIT ADVANCE RECEIPT
                            </h5>
                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">
                                    <font-awesome-icon icon="fa-solid fa-xmark" />
                                </span>
                            </button>
                        </div>
                        <div class="p-0 modal-body">
                            <div class="card-plain">
                                <div class="m-2 card-body">
                                    <form role="form text-left" enctype="multipart/form-data">
                                        <div class="mb-1  row">
                                            <div for="order_no" class="col-md-3 col-form-label">
                                                ORDER NO
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" disabled
                                                    name="order_no" id="order_no" v-model="edit_receipt.order_no"
                                                    placeholder="Order No" />
                                                <small v-if="validationErrors.order_no" id="order_no"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.order_no
                                                    }}</small>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="my-2 row">
                                                <div for="receipt_no" class="col-md-3 col-form-label">
                                                    RECEIPT NO
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control form-control-sm" disabled
                                                        name="receipt_no" id="receipt_no" v-model="edit_receipt.receipt_no"
                                                        placeholder="Receipt No" />
                                                    <small v-if="validationErrors.receipt_no" id="receipt_no"
                                                        class="text-danger form-text text-error-msg error">{{
                                                            validationErrors.receipt_no
                                                        }}</small>
                                                </div>
                                            </div>
                                            <div class="mb-1 row">
                                                <div for="date" class="col-md-3 col-form-label">
                                                    DATE
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="date" class="form-control form-control-sm" name="date"
                                                        id="date" v-model="edit_receipt.date" placeholder="Extra Charges" />
                                                    <small v-if="validationErrors.date" id="date"
                                                        class="text-danger form-text text-error-msg error">{{
                                                            validationErrors.date
                                                        }}</small>
                                                </div>
                                            </div>
                                            <div class="mb-1 row">
                                                <div for="amount" class="col-md-3 col-form-label">
                                                    AMOUNT
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="number" class="form-control form-control-sm" name="amount"
                                                        id="amount" v-model="edit_receipt.amount" placeholder="Amount" />
                                                    <small v-if="validationErrors.amount" id="amount"
                                                        class="text-danger form-text text-error-msg error">{{
                                                            validationErrors.amount }}</small>
                                                </div>
                                            </div>
                                            <div class="mb-1 row">
                                                <div for="remark" class="col-md-3 col-form-label">
                                                    REMARKS
                                                </div>
                                                <div class="col-md-9">
                                                    <textarea type="text" class="form-control form-control-sm" required
                                                        name="remark" id="remark" v-model="edit_receipt.remark"
                                                        placeholder="Remark"></textarea>
                                                    <small v-if="validationErrors.remark" id="remark"
                                                        class="text-danger form-text text-error-msg error">{{
                                                            validationErrors.remark
                                                        }}</small>
                                                </div>
                                            </div>
                                            <div class="mt-2 text-right">
                                                <button type="button" @click.prevent="updateAdvanceReceipt"
                                                    class="mb-0 btn btn-round btn-outline-primary btn-sm">
                                                    <font-awesome-icon icon="fa-solid  fa-floppy-disk" /> UPDATE
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { library } from "@fortawesome/fontawesome-svg-core";
import Multiselect from "vue-multiselect";
import { faHouse, faXmark, faPen, faPrint, faMagnifyingGlass, faAnglesRight, faFloppyDisk } from "@fortawesome/free-solid-svg-icons";

export default {
    components: {
        AppLayout,
        Link,
        library,
        Multiselect,
    },
    data() {
        return {
            textClassHead: "text-start text-uppercase",
            textClassBody: "text-start",
            iconClassHead: "text-center",
            iconClassBody: "text-center",
            valueClassHead: "text-right",
            valueClassBody: "text-right",
            rowClass: "cursor-pointer",

            search: null,
            page: 1,
            perPage: [25, 50, 100],
            pageCount: 25,
            pagination: {},

            customer: {},
            edit_customer: {},
            receipts: [],

            search_customer: {},

            loyalty_customer: {},
            order: {},
            index: 0,
            customer_id: null,

            edit_receipt: {},

        };
    },
    beforeMount() {
        library.add(faHouse);
        library.add(faXmark);
        library.add(faMagnifyingGlass);
        library.add(faAnglesRight);
        library.add(faPen);
        library.add(faFloppyDisk);
        library.add(faPrint);
        this.getAdvanceReceipt();
    },
    watch: {
    },
    methods: {
        async setPage(page) {
            this.page = page;
            this.reload();
        },
        async getSearch() {
            this.page = 1;
            this.reload();
        },
        async perPageChange() {
            this.reload();
        },
        async reload() {
            this.$root.loader.start();
            const tableData = (
                await axios.get(route("advanceReceipt.all"), {
                    params: {
                        page: this.page,
                        per_page: this.pageCount,
                        "filter[search]": this.search,
                    },
                })
            ).data;

            this.receipts = tableData.data;
            this.pagination = tableData.meta;
            this.$root.loader.finish();
        },

        async editAdvanceReceipt(id) {
            this.resetValidationErrors();
            try {
                const edit_receipt = (await axios.get(route('advanceReceipt.get', id))).data;
                this.edit_receipt = edit_receipt
                $('#editAdvanceReceiptModal').modal('show')
            } catch (error) {
                this.convertValidationNotification(error)
            }
        },
        async updateAdvanceReceipt() {
            this.resetValidationErrors();
            try {
                if (this.edit_receipt.order.payment_status == 0) {

                    const total = parseFloat(this.edit_receipt.order.items_total.replace(/,/g, ''))
                    if(total !=  this.edit_receipt.amount){
                        this.$root.notify.error({
                            title: 'Fail',
                            message: 'Payment not completed. You have to pay '+ this.edit_receipt.order.items_total,
                        });
                        return;
                    }
                }
                await axios.post(route('advanceReceipt.update', this.edit_receipt.id), this.edit_receipt);
                $('#editAdvanceReceiptModal').modal('hide');
                this.printAdvanceReceipt(this.edit_receipt.order_id);
                this.edit_receipt = {};
                this.getAdvanceReceipt();
                this.$root.notify.success({
                    title: 'Success',
                    message: 'Advance receipt updated successfully',
                })
            } catch (error) {
                this.convertValidationNotification(error)
            }
        },

        async printAdvanceReceipt(id) {
            this.$root.loader.start();
            try {
                const print = await axios.get(route("advanceReceipt.print", id), {
                    responseType: 'blob'
                });
                const url = window.URL.createObjectURL(print.data);
                window.open(url, '_blank');

            } catch (error) {
                this.convertValidationNotification(error);
            }
            this.$root.loader.finish();
        },
        async getAdvanceReceipt() {
            const tableData = (await axios.get(route("advanceReceipt.all"))).data;
            this.receipts = tableData.data;
            this.pagination = tableData.meta;
        },
    },
};
</script>
