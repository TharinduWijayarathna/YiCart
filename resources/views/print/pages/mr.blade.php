@extends('print.layouts.app')
@section('content')
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <thead>
            <tr class="bg-ash">
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
    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="top-margin">
        <thead>
            <tr class="heading-bg-po">
                <th class="title-text" style="text-align: middle; padding-top: 3px; padding-bottom: 6px;">
                    MATERIAL REQUEST - {{ $mr_item->code }}
                </th>
            </tr>
        </thead>
    </table>
    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="top-margin">
        <tbody>
            <tr class="row-bg ">
                <td width="70%" align="left" class="td-style">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="30%" class="td-style" style="text-align: left;"><b>Warehouse</b></td>
                                <td width="70%" align="left" class="txt-size">To {{ $mr_item->to_warehouse_name }} From
                                    {{ $mr_item->from_warehouse_name }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="30%" class="td-style" style="text-align: left;"><b>MR Type</b></td>
                                <td width="70%" align="left" class="txt-size">{{ $mr_item->transaction_name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td width="30%" align="left">
                    <table width="100%" align="right">
                        <tbody>
                            <tr>
                                <td width="60%" class="td-style" align="left"><b>Date</b></td>
                                <td width="40%" align="right" class="txt-size">{{ $mr_item->date }} </td>
                            </tr>
                        </tbody>
                    </table>
                    @if ($mr_item->crm_code )
                    <table width="100%" align="right">
                        <tbody>
                            <tr>
                                <td width="60%" class="td-style" style="text-align: left;"><b>CRM Code</b></td>
                                <td width="40%" align="right" class="txt-size">{{ $mr_item->crm_code }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    @if ($mr_item->transaction_type_slug != 'crm-invoice')
        <table cellspacing="0" cellpadding="0" border="0" width="100%">
            <thead class="border-mt border-mb">
                <tr class="row-bg">
                    <td width="25%" align="left" class="border-l td-style left-text">
                        <b>Barcode</b>
                    </td>
                    <td width="30%" align="left" class="border-l td-style left-text">
                        <b>Material </b>
                    </td>
                    <td width="35%" align="left" class="border-l td-style left-text">
                        <b>Material Desc</b>
                    </td>
                    <td width="10%" align="right" class="border-l border-r td-style right-text">
                        <b>Quantity</b>
                    </td>
                </tr>
            </thead>
            <tbody class="border-mt border-mb">
                @foreach ($mr_item->items as $key => $item)
                    <tr class="row-bg border-b">
                        <td width="25%" align="left" class="border-l td-style left-text">
                            {{ $item->material ? $item->material->code : '' }}
                        </td>
                        <td width="35%" align="left" class="border-l td-style left-text">
                            {{ $item->material ? $item->material->name : '' }}
                        </td>
                        <td width="30%" align="left" class="border-l td-style left-text">
                            {{ $item->material ? $item->material->description : '' }}
                        </td>
                        <td width="10%" align="right" class="border-l border-r td-style right-text">
                            {{ number_format($item->quantity, 2) }}
                        </td>
                    </tr>
                @endforeach
                <tr class="row-bg">
                    <td colspan="3" align="right" class="border-l border-r td-style right-text">
                        <b>Total</b>
                    </td>
                    <td width="10%" align="left" class="border-r td-style right-text">
                        <b>{{ $totalQuantity ? number_format($totalQuantity, 2) : 0.0 }}</b>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
    @if ($mr_item->transaction_type_slug == 'crm-invoice')
        <table cellspacing="0" cellpadding="0" border="0" width="100%">
            <thead class="border-mt border-mb">
                <tr class="row-bg">
                    <td width="5%" align="left" class="border-l td-style left-text">
                        <b>No</b>
                    </td>
                    <td width="20%" align="left" class="border-l td-style left-text">
                        <b>Barcode</b>
                    </td>
                    <td width="25%" align="left" class="border-l td-style left-text">
                        <b>Material </b>
                    </td>
                    <td width="30%" align="left" class="border-l td-style left-text">
                        <b>Material Desc</b>
                    </td>
                    <td width="10%" align="right" class="border-l td-style right-text">
                        <b>Selling Price </b>
                    </td>
                    <td width="10%" align="right" class="border-l border-r td-style right-text">
                        <b>Quantity</b>
                    </td>
                </tr>
            </thead>
            <tbody class="border-mt border-mb">
                @foreach ($mr_item->items as $key => $item)
                    <tr class="row-bg border-b">
                        <td width="5%" align="center" class="border-l td-style">
                            {{ ++$key }}
                        </td>
                        <td width="20%" align="left" class="border-l td-style left-text">
                            {{ $item->material ? $item->material->code : '' }}
                        </td>
                        <td width="25%" align="left" class="border-l td-style left-text">
                            {{ $item->material ? $item->material->name : '' }}
                        </td>
                        <td width="30%" align="left" class="border-l td-style left-text">
                            {{ $item->material ? $item->material->description : '' }}
                        </td>
                        <td width="10%" align="right" class="border-l td-style right-text">
                            {{ number_format($item->selling_price, 2) }}
                        </td>
                        <td width="10%" align="right" class="border-l border-r td-style right-text">
                            {{ number_format($item->quantity, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table cellspacing="0" cellpadding="0" border="0" width="100%" class="border-mt">
            <tbody class="border-mb border-mt">
                <tr class="row-bg">
                    <td width="80%" align="right" class="border-l border-r td-style right-text">
                        <b>Total</b>
                    </td>
                    <td width="10%" align="left" class="border-r td-style right-text">
                        <b>{{ $totalPrice ? number_format($totalPrice, 2) : 0.0 }}</b>
                    </td>
                    <td width="10%" align="left" class="border-r td-style right-text">
                        <b>{{ $totalQuantity ? number_format($totalQuantity, 2) : 0.0 }}</b>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
    <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%"
        class="section-footer top-margin">
        <thead>
            <tr>
                <td width="33%" align="center">
                    <table cellspacing="0" cellpadding="0" border="0" width="50%" align="center">
                        <tbody>
                            <tr class="row-bg">
                                <td width="50%" align="center" class="td-style" style="text-align: center;">
                                    ...............................................................
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" align="center" class="td-style">
                                    Created by
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" align="center" class="td-style">
                                    ( {{ $mr_item->created_by ? $mr_item->created_by : 'N/A' }} )
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
                <td width="33%" align="center">
                    <table cellspacing="0" cellpadding="0" border="0" width="50%" align="center">
                        <tbody>
                            <tr class="row-bg">
                                <td width="50%" align="center" class="td-style" style="text-align: center;">
                                    ...............................................................
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" align="center" class="td-style">
                                    Approved by
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" align="center" class="td-style">
                                    ( {{ $mr_item->approved_by ? $mr_item->approved_by : 'N/A' }} )
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
                <td width="33%" align="center">
                    <table cellspacing="0" cellpadding="0" border="0" width="50%" align="center">
                        <tbody>
                            <tr class="row-bg">
                                <td width="50%" align="center" class="td-style" style="text-align: center;">
                                    ...............................................................
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" align="center" class="td-style">
                                    Printed by
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" align="center" class="td-style">
                                    ( {{ $printed_by ? $printed_by : 'N/A' }} )
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
                    Created At {{ \Carbon\Carbon::parse($mr_item->created_at)->format('Y-m-d h:i:s A') }}
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
        .txt-size {
            font-size: .8rem;
            font-family: Arial, Helvetica, sans-serif;
        }

        .main-details {
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

        .top-margin {
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

        .title-text {
            font-family: Arial, Helvetica, sans-serif;
        }

        .td-style {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            font-weight: 400;
            line-height: 17px;
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

        .bg-ash {
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
            border-bottom: #252525 solid 0.25px;
        }

        .border-mt {
            border-top: #252525 solid 0.25px;
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

        */ .brand-logo {
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
            font-family: Arial, Helvetica, sans-serif;
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

        .text-head {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 30px;
            font-weight: bold;
        }

        .text-body {
            font-family: Arial, Helvetica, sans-serif;
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
