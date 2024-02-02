@extends('print.layouts.app')
@section('content')
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <thead>
            <tr>
                <th width="15%">
                    {{-- <img src="img/logo/logo_black.png" alt="SELYN" class="brand-logo"> --}}
                </th>
                <th width="85%">
                    @if ($receptDetails->order->cashier->location->name == 'CSR STOCK')
                        @include('print.components.colombo_advance')
                    @else
                        @include('print.components.waduragala_advance')
                    @endif
                </th>
            </tr>
        </thead>
    </table>

    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="top-margin">
        <thead>
            <tr class="heading-bg-po">
                <th width="50%">
                    <div class="sub-title text-left">Order No : #{{ $receptDetails->order_no }}</div>
                </th>
                <th>
                    <div class="sub-title text-left">Name : {{ $receptDetails->order->customer_name }}</div>
                </th>
            </tr>
            <tr class="heading-bg-po">
                <th width="50%">
                    <div class="sub-title text-left">Receipt No : #{{ $receipt->receipt_no }}</div>
                </th>
                <th>
                    <div class="sub-title text-left">Address : {{ $receptDetails->order->customer_address }}</div>
                </th>
            </tr>
            <tr class="heading-bg-po">
                <th width="50%">
                    <div class="sub-title text-left">Cashier : {{ $receptDetails->order->cashier_name }}</div>
                </th>
                <th>
                    <div class="sub-title text-left">Date : {{ $receipt->date }}</div>
                </th>
            </tr>
        </thead>
    </table>

    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="item-section">
        <thead class="">
            <tr class="row-bg">
                <td width="100%" align="left" class="td-style">
                    <b>Remark</b>
                </td>
            </tr>
        </thead>
        <tbody class="">
                <tr class="row-bg ">
                    <td width="100%" align="left" class="left-text">
                        <div>
                            {{ $receptDetails->remark }}
                        </div>
                    </td>
                </tr>
        </tbody>
    </table>

    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="item-section  top-margin">
        <tbody class=" total-text top-margin">
            <tr class="row-bg">
                <td width="60%" class="right-text bold-text receipt-amount" style="text-align: right">
                   <b>Receipt Payed Amount</b>
                </td>
                <td  style="text-align: right" class="receipt-amount">
                    <b>{{ $receipt->format_amount }}<b/>
                </td>
            </tr>
        </tbody>
    </table>
    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="item-section  top-margin">
        <tbody class=" total-text top-margin">
            <tr class="row-bg">
                <td width="60%" class="right-text bold-text" style="text-align: right">
                   Order Amount
                    <br />
                    Total Payed Amount
                    <div class="line-hr" ></div>
                    Due Payment
                </td>
                <td  style="text-align: right">
                    <b>{{ $receptDetails->items_total }}<b/>
                    <br />
                    <b>{{number_format($total, 2) }}</b>
                    <div class="line-hr" ></div>
                    <b>{{ $receptDetails->grand_total}}</b>
                </td>
            </tr>
        </tbody>
    </table>
    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="section-footer">
        <thead>
            <tr>
                <td class="footer-content">
                    <b>Date & Time {{ Date('Y-m-d h:i:s A') }}</b>
                </td>
            </tr>
        </thead>
    </table>
    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="">
        <thead>
            <tr>
                <td class="terms">
                    <b>
                    <div>
                        *Thank you for your visit*
                    </div>
                    <div>
                        *Exchange is possible within 14 days*
                    </div>
                    <div>
                        *No returns / exchange on discount item*
                    </div>
                    <div>
                        *Terms and conditions apply*
                    </div>
                    <div>
                        (invoice must be produced)
                    </div>
                    </b>
                </td>
            </tr>
        </thead>
    </table>
    <style>
        .top-margin{
            margin-top: 10px;
        }
        .page_break {
            page-break-before: always;
        }
        .left-text {
            margin-top: 10px;
            margin-bottom: 10px;
            font-family: 'Consolas', monospace;
            text-align: left;
            padding-right: 5px;
            font-size: .7rem;
        }

        .right-text {
            font-family: 'Consolas', monospace;
            text-align: right;
            padding-right: 5px;
            font-size: .7rem;
        }
        .bold-text{
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
        .receipt-amount {
            font-family: 'Consolas', monospace !important;
            font-size: 0.9rem;
            font-weight: 400;
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
        .text-left{
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

        .section-table{
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

        .invoice-order-item{
            border-bottom: #000000 solid 1px;
        }

        .line-hr{
            border-bottom: #000000 solid 1px;
        }

        .dotted-line-hr{
            border-bottom: #000000 dotted 1px;
        }
    </style>
@endsection
