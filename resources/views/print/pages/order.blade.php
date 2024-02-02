@extends('print.layouts.app')
@section('content')
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <thead>
            <tr  class="bg-ash">
                <th style="text-align: middle;">
                    <div class="text-head">SELYN EXPORTERS (PVT) LTD</div>
                    <div class="text-body">FAIR TRADE HANDLOOMS & HANDICRAFTS<div>
                </th>
                <th class="" style="text-align: middle;">
                    <img src="img/logo/logo_loader.png" alt="SELYN" class="brand-logo">
                </th>
            </tr>
        </thead>
    </table>
    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="top-margin" >
        <thead>
            <tr class="heading-bg-po">
                <th class="title-text" style="text-align: middle; padding-top: 3px; padding-bottom: 6px;">
                    CUSTOM ORDER - {{ $order->order_no }} - {{ $order->created_at }}
                </th>
            </tr>
        </thead>
    </table>
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <tbody class="">
            <tr class="row-bg ">
                <td width="60%" align="left" class="td-style">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="40%" class="td-style" style="text-align: left;"><b>Advance Receipt No.</b></td>
                                    <td width="60%" align="left">#{{ $advance_receipt ? $advance_receipt->receipt_no : 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="40%" class="td-style"  style="text-align: left;"><b>User</b></td>
                                    <td width="60%" align="left">{{ $order->cashier_name }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="40%%" class="td-style"  style="text-align: left;"><b>Customer Name</b></td>
                                    <td width="60%" align="left">{{ $order->customer_name }}</td>
                                </tr>
                            </tbody>
                        </table>
                </td>
                <td width="40%" align="left" class="td-style">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="40%" class="td-style" style="text-align: left;"><b>Customer Email</b></td>
                                <td width="60%" align="right">{{ $order->customer_email }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="40%" class="td-style"  style="text-align: left;"><b>Customer Address</b></td>
                                <td width="60%" align="right">{{ $order->customer_address }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="40%" class="td-style"  style="text-align: left;"><b>Mobile No.</b></td>
                                <td width="60%" align="right">{{ $order->customer_mobile }}</td>
                            </tr>
                        </tbody>
                    </table>
            </td>
            </tr>
        </tbody>
    </table>
    <table class="border-t details_table margin-section top-margin" cellspacing="0" cellpadding="0" border="0" width="100%">
        <thead class="border-mt border-mb">
            <tr class="row-bg">
                <td width="5%" align="center" class="border-l td-style ">
                    <b>No</b>
                </td>
                <td width="10%" align="left" class="border-l td-style left-text">
                    <b>Code</b>
                </td>
                <td width="25%" align="left" class="border-l  td-style desc-wrap  left-text">
                    <b>Desc</b>
                </td>
                <td width="5%" align="left" class="border-l td-style left-text">
                    <b>Size</b>
                </td>
                <td width="10%" align="right" class="border-l td-style left-text">
                    <b>Remark </b>
                </td>
                <td width="10%" align="right" class="border-l td-style right-text">
                    <b>Qty</b>
                </td>
                <td width="15%" align="right" class="border-l td-style right-text">
                    <b>Unit Price (Rs)</b>
                </td>
                <td  max-width="20%" align="left" class="border-l desc-wrap  border-r td-style right-text">
                    <b>Total Price (Rs)</b>
                </td>
            </tr>
        </thead>
        <tbody class="border-mt border-mb">
         @foreach ($order->items as $index => $item)
                <tr class="row-bg">
                    <td width="5%" align="center" class="border-l td-style">
                        {{ ++$index }}
                    </td>
                    <td width="10%" align="left" class="border-l td-style left-text">
                        {{ $item->material_code }}
                    </td>
                    <td width="25%" align="left" class="border-l  td-style left-text">
                        <span class=' desc-wrap '>{{ $item->description }}</span>
                    </td>
                    <td width="5%" align="left" class="border-l td-style left-text">
                        {{ $item->size }}
                    </td>
                    <td width="10%" align="left" class="border-l td-style left-text">
                        {{ $item->remark }}
                    </td>
                    <td width="10%" align="left" class="border-l td-style right-text">
                        {{ $item->quantity }}
                    </td>
                    <td width="15%" align="left"  class="border-l td-style right-text">
                        {{ $item->unit_price }}
                    </td>
                    <td  max-width="20%" align="left" class="border-l desc-wrap  border-r td-style right-text">
                        {{ $item->format_total }}
                    </td>
                </tr>
            @endforeach
            <tr class="row-bg border-mt">
                <td width="60%" colspan="5" align="right" class="border-l border-r td-style right-text">
                    <b>Total</b>
                </td>
                <td width="10%" align="left" class="border-r td-style right-text">
                    <b>{{ $totalQuantity ? number_format($totalQuantity, 2) : 0.00}}</b>
                </td>
                <td width="15%" align="left" class="border-r td-style right-text">
                </td>
                <td width="15%" align="left" class="border-r td-style right-text">
                    <b>{{ $totalAmount ? number_format($totalAmount, 2) : 0.00}}</b>
                </td>
            </tr>
        </tbody>
    </table>
    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="top-margin">
        <tbody class="">
            <tr class="row-bg ">
                <td width="60%" align="left" class="td-style">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="40%" class="td-style" style="text-align: left;"><b>Delivery Date</b></td>
                                    <td width="60%" align="left">{{ $order->delivery_date }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="40%" class="td-style"  style="text-align: left;"><b>Order Type</b></td>
                                    <td width="60%" align="left">{{ $order->order_type }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="40%%" class="td-style"  style="text-align: left;"><b>Payment Type</b></td>
                                    <td width="60%" align="left">
                                    @if ($order->payment_status == 0)
                                    No Any Payment
                                    @endif
                                    @if ($order->payment_status == 1)
                                    Partial Payment
                                    @endif
                                    @if ($order->payment_status == 2)
                                    Payment Completed
                                    @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                </td>
                <td width="40%" align="left" class="td-style">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="40%" class="td-style" style="text-align: left;"><b>Contact at selyn HQ</b></td>
                                <td width="60%" align="right">{{ $order->contact_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="40%" class="td-style"  style="text-align: left;"><b>Extra chagers</b></td>
                                <td width="60%" align="right">{{ $order->extra_charges }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="40%" class="td-style"  style="text-align: left;"><b>Grand Total</b></td>
                                <td width="60%" align="right">{{ $order->grand_total }}</td>
                            </tr>
                        </tbody>
                    </table>
            </td>
            </tr>
        </tbody>
    </table>
    <table class="margin-section" cellspacing="0" cellpadding="0" border="0" width="100%" class="top-margin">
        <thead>
            <tr>
                <td width="20%" class="" style="text-align: left;">
                    <div class="td-style"><b>Remark<b/></div>
                </td>
                <td width="80%" class="" style="text-align: left;">
                    <div>{{ $order->remark }}</div>
                </td>
            </tr>
        </thead>
    </table>
    <table class=" margin-section" cellspacing="0" cellpadding="0" border="0" width="100%">
        <thead>
            <tr>
                <td width="20%" class="" style="text-align: left;">
                    <div class="td-style"><b>Special Note<b/></div>
                </td>
                <td width="80%" class="" style="text-align: left;">
                    <div></div>
                </td>
            </tr>
        </thead>
    </table>
    <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" class="section-footer top-margin" >
        <thead>
            <tr>
                <td width="50%" align="center">
                    <table cellspacing="0" cellpadding="0" border="0" width="50%" align="center">
                        <tbody >
                            <tr class="row-bg">
                                <td width="50%" align="center" class="td-style" style="text-align: center;">
                                    ...............................................................
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" align="center" class="td-style">
                                    Showroom Manager
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" align="center" class="td-style">
                                    {{-- ( {{ $pr_item->created_by ? $pr_item->created_by : 'N/A'  }} ) --}}
                                </td>
                            </tr>
                            {{-- <tr>
                                <td width="50%" align="left" class="td-style" style="text-align: center;">
                                    ...............................................................
                                </td>
                                <td width="50%" align="left" class="td-style">
                                    Approved by
                                </td>
                                <td width="50%" align="left" class="td-style">
                                    ( {{ $pr_item->approved_by ? $pr_item->approved_by : 'N/A'  }} )
                                </td>
                            </tr> --}}
                        </tbody>
                    </table>
                </td>
                <td width="50%" align="center">
                    <table cellspacing="0" cellpadding="0" border="0" width="50%" align="center">
                        <tbody >
                            <tr class="row-bg">
                                <td width="50%" align="center" class="td-style" style="text-align: center;">
                                    ...............................................................
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" align="center" class="td-style">
                                    Customer
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" align="center" class="td-style">
                                    {{-- ( {{ $printed_by ? $printed_by : 'N/A'  }} ) --}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </thead>
    </table>


    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="section-footer">
        <thead>
            <tr>
                <td class="footer-content">
                    Created At {{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d h:i:s A') }}
                </td>
            </tr>
            <tr>
                <td class="footer-content">
                    Printed At {{ Date('Y-m-d h:i:s A') }}
                </td>
            </tr>
            <tr>
                <td class="footer-content">
                    Selyn Exporters Pvt. Ltd.
                </td>
            </tr>
        </thead>
    </table>
    <style>
        .main-details{
            font-weight: bold;
            font-size: .5rem;
            color: #000000;
        }
        .page_break {
            page-break-before: always;
        }

        .left-text {
            padding-left: 5px !important;
        }
        .top-margin{
            margin-top: 20px;
        }

        .right-text {
            text-align: right !important;
            padding-right: 5px;
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
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            font-weight: 400;
            line-height: 17px;
            padding-bottom: 3px;
            padding-top: 3px;
        }

        .title-text{
            font-family: Arial, Helvetica, sans-serif;
        }

        .td-style-head {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
            padding-left: 10px;
            padding-bottom: 1px;
            padding-top: 1px;
        }

        .td-style-gt {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            font-weight: 400;
            line-height: 17px;
            padding-left: 10px;
            padding-bottom: 6px;
            padding-top: 6px;
        }

        .bg-ash{
            background-color: #e8e8e7;
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
            border-bottom: #252525 solid 0.25px;
        }

        .border-t {
            border-top: #252525 solid 0.25px;
        }

        .border-l {
            border-left: #252525 solid 0.25px;
        }

        .border-r {
            border-right: #252525 solid 0.25px;
        }

        .brand-logo {
            width: 70px;
            height: 70px;
            padding-bottom: 5px;
            padding-top: 2px;
        }

        .heading-bg {
            background-color: #e8e8e8c4;
        }

        .heading-bg-po {
            background-color: #ffffff7d;
            color: #2b2b2b;
        }

        .total-bg {
            background-color: #e8e8e8c4;
            padding-right: 10px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            font-weight: 400;
            line-height: 20px;
            padding-left: 10px;
            padding-bottom: 5px;
        }

        .total-txt {
            text-align: left;
            padding-left: 10px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            font-weight: 400;
            line-height: 20px;
            font-weight: bold;
        }

        .total-value {
            text-align: right;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            font-weight: 400;
            line-height: 20px;
            font-weight: bold;
        }

        .table-heading {
            padding-left: 15px;
            font-size: 12px;
        }

        .footer-content {
            text-align: center;
            font-size: 8px;
        }

        .section-table {
            margin-bottom: 20px;
        }

        .section-footer {
            margin-top: 50px;
            margin-bottom: 20px;
        }

        .section-table {
            margin-bottom: 20px;
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

        .text-head {font-family: Arial, Helvetica, sans-serif;
            font-size: 30px;
            font-weight: bold;
        }

        .text-body {font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
        }

        .text-tc {
            font-size: 12px;
            line-height: 20px;
        }

        /* table {
                    page-break-inside: avoid
                }

                tr {
                    page-break-inside: avoid;
                    page-break-after: auto
                } */

        .vendor-info {
            font-size: 10px;
            line-height: 5px;
        }
    </style>
@endsection

{{--
@extends('print.layouts.app')
@section('content')
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <thead>
            <tr>
                <td class="" style="text-align: center">
                    <img src="img/logo/new-selyn-logo.png" alt="SELYN" class="brand-logo">
                </td>
                <td class="" style="text-align: middle;">
                    <div class="text-body">Selyn Exports (pvt) Ltd</div>
                    <div class="text-body">No.195, Colombo Road<div>
                        <div class="text-body">Wanduragala</div>
                        <div class="text-body">0372232188<div>
                            <div class="text-body">showrooms@selyn.lk<div>
                </td>
                <td class="" style="text-align: middle;">
                    <div class="text-body">CUSTOM ORDER</div>
                </td>
                <td class="" style="text-align: middle;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <thead>
                            <tr>
                                <td class="" style="text-align: left">
                                    <div class="text-body">Date:</div>
                                </td>
                                <td class="" style="text-align: left">
                                    <div class="text-body" >{{ $order->created_at }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" style="text-align: left">
                                    <div class="text-body">Order No:</div>
                                </td>
                                <td class="" style="text-align: left">
                                    <div class="text-body" >{{ $order->order_no }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" style="text-align: left">
                                    <div class="text-body">Specification No:</div>
                                </td>
                                <td class="" style="text-align: left">
                                    <div class="text-body" >{{ $order->specification_no }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" style="text-align: left">
                                    <div class="text-body">User:</div>
                                </td>
                                <td class="" style="text-align: left">
                                    <div class="text-body" >{{ $order->cashier_name }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" style="text-align: left">
                                    <div class="text-body">Advance Receipt No:</div>
                                </td>
                                <td class="" style="text-align: left">
                                    <div class="text-body" >{{ $order->advanced_receipt_id }}</div>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </td>
            </tr>
        </thead>
    </table>
    <table class="border-t margin-section" cellspacing="0" cellpadding="0" border="0" width="100%">
        <thead>
            <tr>
                <td class="" style="text-align: middle;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <thead>
                            <tr>
                                <td class="" style="text-align: left">
                                    <div class="text-body">Customer Name:</div>
                                </td>
                                <td class="" style="text-align: left">
                                    <div class="text-body" >{{ $order->customer_name }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" style="text-align: left">
                                    <div class="text-body">Customer Email:</div>
                                </td>
                                <td class="" style="text-align: left">
                                    <div class="text-body" >{{ $order->customer_email }}</div>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </td>
                <td class="" style="text-align: middle;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <thead>
                            <tr>
                                <td class="" style="text-align: right">
                                    <div class="text-body">Customer Address:</div>
                                </td>
                                <td class="" style="text-align: right">
                                    <div class="text-body" >{{ $order->customer_address }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" style="text-align: right">
                                    <div class="text-body">Mobile No:</div>
                                </td>
                                <td class="" style="text-align: right">
                                    <div class="text-body" >{{ $order->customer_mobile }}</div>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </td>
            </tr>
        </thead>
    </table>
    <table class="border-t details_table margin-section" cellspacing="0" cellpadding="0" border="0" width="100%">
        <thead class="border-mt border-mb">
            <tr class="row-bg">
                <td width="5%" align="left" class="border-l td-style left-text">
                    <b>No</b>
                </td>
                <td width="10%" align="left" class="border-l td-style left-text">
                    <b>Code</b>
                </td>
                <td width="25%" align="left" class="border-l  td-style desc-wrap  left-text">
                    <b>Desc</b>
                </td>
                <td width="5%" align="left" class="border-l td-style left-text">
                    <b>Size</b>
                </td>
                <td width="10%" align="right" class="border-l td-style right-text">
                    <b>Qty</b>
                </td>
                <td width="10%" align="right" class="border-l td-style right-text">
                    <b>Unit Price (Rs)</b>
                </td>
                <td width="15%" align="right" class="border-l td-style right-text">
                    <b>Total Price (Rs)</b>
                </td>
                <td  max-width="20%" align="left" class="border-l desc-wrap  border-r td-style left-text">
                    <b>Reamrk </b>
                </td>
            </tr>
        </thead>
        <tbody class="border-mt border-mb">
         @foreach ($order->items as $index => $item)
                <tr class="row-bg">
                    <td width="5%" align="left" class="border-l td-style">
                        {{ ++$index }}
                    </td>
                    <td width="10%" align="left" class="border-l td-style">
                        {{ $item->material_code }}
                    </td>
                    <td width="25%" align="left" class="border-l  td-style left-text">
                        <span class=' desc-wrap '>{{ $item->description }}</span>
                    </td>
                    <td width="5%" align="left" class="border-l td-style left-text">
                        {{ $item->size }}
                    </td>
                    <td width="10%" align="left" class="border-l td-style right-text">
                        {{ $item->quantity }}
                    </td>
                    <td width="10%" align="left" class="border-l td-style right-text">
                        {{ $item->unit_price }}
                    </td>
                    <td width="15%" align="left"  class="border-l td-style right-text">
                        {{ $item->format_total }}
                    </td>
                    <td  max-width="20%" align="left" class="border-l desc-wrap  border-r td-style left-text">
                         {{ $item->remark }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="margin-section" cellspacing="0" cellpadding="0" border="0" width="100%">
        <thead>
            <tr>
                <td class="" style="text-align: middle;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <thead>
                            <tr>
                                <td class="" style="text-align: left">
                                    <div class="text-body">Delivery Date:</div>
                                </td>
                                <td class="" style="text-align: left">
                                    <div class="text-body" >{{ $order->delivery_date }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" style="text-align: left">
                                    <div class="text-body">Order Type:</div>
                                </td>
                                <td class="" style="text-align: left">
                                    <div class="text-body" >{{ $order->order_type }}</div>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </td>
                <td class="" style="text-align: middle;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <thead>
                            <tr>
                                <td class="" style="text-align: right">
                                    <div class="text-body">Payment Type:</div>
                                </td>
                                <td class="" style="text-align: left">
                                    @if ($order->payment_status == 0)
                                    <div class="text-body" >Full</div>
                                    @endif
                                    @if ($order->payment_status == 1)
                                    <div class="text-body" >Partial</div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="" style="text-align: right">
                                    <div class="text-body">Contact at selyn HQ:</div>
                                </td>
                                <td class="" style="text-align: left">
                                    <div class="text-body" >{{ $order->contact_at }}</div>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </td>
                <td class="" style="text-align: middle;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <thead>
                            <tr>
                                <td class="" style="text-align: right">
                                    <div class="text-body">Extra chagers:</div>
                                </td>
                                <td class="" style="text-align: right">
                                    <div class="text-body">{{ $order->extra_charges }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" style="text-align: right">
                                    <div class="text-body">Grand Total:</div>
                                </td>
                                <td class="" style="text-align: right">
                                    <div class="text-body">{{ $order->grand_total }}</div>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </td>
            </tr>
        </thead>
    </table>
    <table class="margin-section" cellspacing="0" cellpadding="0" border="0" width="100%">
        <thead>
            <tr>
                <td width="15%" class="" style="text-align: left;">
                    <div class="text-body">Remark:</div>
                </td>
                <td width="85%" class="" style="text-align: left;">
                    <div class="text-body">{{ $order->remark }}</div>
                </td>
            </tr>
        </thead>
    </table>
    <table class=" margin-section" cellspacing="0" cellpadding="0" border="0" width="100%">
        <thead>
            <tr>
                <td width="15%" class="" style="text-align: left;">
                    <div class="text-body">Special Note:</div>
                </td>
                <td width="85%" class="" style="text-align: left;">
                    <div class="text-body">fjkd jk gk ghgkh gg</div>
                </td>
            </tr>
        </thead>
    </table>


    <table class=" margin-section" cellspacing="0" cellpadding="0" border="0" width="100%">
        <thead>
            <tr>
                <td class="" style="text-align: middle;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <thead>
                            <tr>
                                <td width="40%" class="" style="text-align: left;">
                                    <div class="text-body">Showroom Manager:</div>
                                </td>
                                <td width="60%" class="" style="text-align: left;">
                                    <div class="text-body">..........................</div>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </td>
                <td class="" style="text-align: middle;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <thead>
                            <tr>
                                <td width="40%" class="" style="text-align: left;">
                                    <div class="text-body">Customer:</div>
                                </td>
                                <td width="60%" class="" style="text-align: left;">
                                    <div class="text-body">..........................</div>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </td>
            </tr>
        </thead>
    </table>

    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="section-footer border-t">
        <thead>
            <tr>
                <td class="footer-content">
                    Created At {{ Date('Y-m-d h:i:s A') }} By Selyn Exporters Pvt Ltd
                </td>
            </tr>
        </thead>
    </table>
    <style>
        .page_break {
            page-break-before: always;
        }

        .right-text {
            text-align: right;
            padding-right: 5px;
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
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            font-weight: 400;
            line-height: 17px;
            padding-left: 10px;
            padding-bottom: 3px;
            padding-top: 3px;
        }

        .td-style-head {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
            padding-left: 10px;
            padding-bottom: 1px;
            padding-top: 1px;
        }

        .td-style-gt {
            font-family: Arial, Helvetica, sans-serif;
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

        .margin-section {
            margin-top: 20px;
            margin-bottom: 20px;
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
            border-bottom: #000000 solid 2px;
        }

        .border-t {
            border-top: #000000 solid 2px;
        }

        .border-l {
            border-left: #000000 solid 2px;
        }

        .border-r {
            border-right: #000000 solid 2px;
        }

        .brand-logo {
            width: 60px;
            height: 70px;
            padding-bottom: 5px;
            padding-top: 2px;
        }

        .heading-bg {
            background-color: #e8e8e8c4;
        }

        .heading-bg-po {
            background-color: #ffffff7d;
            color: #2b2b2b;
        }

        .total-bg {
            background-color: #e8e8e8c4;
            padding-right: 10px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            font-weight: 400;
            line-height: 20px;
            padding-left: 10px;
            padding-bottom: 5px;
        }

        .total-txt {
            text-align: left;
            padding-left: 10px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            font-weight: 400;
            line-height: 20px;
            font-weight: bold;
        }

        .total-value {
            text-align: right;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            font-weight: 400;
            line-height: 20px;
            font-weight: bold;
        }

        .table-heading {
            padding-left: 15px;
            font-size: 12px;
        }

        .footer-content {
            text-align: center;
            font-size: 8px;
        }

        .section-table {
            margin-bottom: 20px;
        }

        .section-footer {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .section-table {
            margin-bottom: 20px;
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
            font-family: Cambria;
            font-size: 30px;
            font-weight: bold;
        }

        .desc-wrap {
            word-wrap:break-word;
        }

        .details_table{
            table-layout: fixed;
        }

        .text-body {
            font-family: Cambria;
            font-size: 15px;
        }

        .text-tc {
            font-size: 12px;
            line-height: 20px;
        }

        /* table {
                    page-break-inside: avoid
                }

                tr {
                    page-break-inside: avoid;
                    page-break-after: auto
                } */

        .vendor-info {
            font-size: 10px;
            line-height: 5px;
        }
    </style>
@endsection --}}
