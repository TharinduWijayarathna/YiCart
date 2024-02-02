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
                    PURCHASING REQUISITION - {{ $pr_item->code }}
                </th>
            </tr>
        </thead>
    </table>
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <tbody class="">
            <tr class="row-bg ">
                <td width="70%" align="left" class="td-style">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="15%" class="td-style" style="text-align: left;"><b>Warehouse</b></td>
                                    <td width="75%" align="left">{{ $pr_item->warehouse_name }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="15%" class="td-style"  style="text-align: left;"><b>Date</b></td>
                                    <td width="75%" align="left">{{ $pr_item->date }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="15%" class="td-style"  style="text-align: left;"><b>Status</b></td>
                                    <td width="75%" align="left">{{ $pr_item->status == 0 ? "Draft" : "Approved" }}</td>
                                </tr>
                            </tbody>
                        </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <thead class="border-mt border-mb">
            <tr class="row-bg">
                <td width="5%" align="center" class="border-l td-style ">
                    <b>No</b>
                </td>
                <td width="20%" align="left" class="border-l td-style left-text">
                    <b>Barcode</b>
                </td>
                <td width="60%" align="left" class="border-l td-style left-text">
                    <b>Material</b>
                </td>
                <td width="15%" align="right" class="border-l border-r td-style right-text">
                    <b>Quantity</b>
                </td>
            </tr>
        </thead>
        <tbody class="border-mt border-mb">
         @foreach ($pr_item->pr_items as $key => $item)
                <tr class="row-bg border-b">
                    <td width="5%" align="center" class="border-l td-style ">
                        {{ ++$key }}
                    </td>
                    <td width="20%" align="left" class="border-l td-style left-text">
                        {{ $item->material ? $item->material->barcode : '' }}
                    </td>
                    <td width="60%" align="left" class="border-l td-style left-text">
                        {{ $item->material ? $item->material->name : '' }} - {{ $item->material ? $item->material->description : '' }}
                    </td>
                    <td width="15%" align="left" class="border-l border-r td-style right-text">
                        {{ $item->format_qty }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <tbody class="border-mb">
            <tr class="row-bg">
                <td width="85%" align="right" class="border-l border-r td-style right-text">
                    <b>Total</b>
                </td>
                <td width="15%" align="left" class="border-r td-style right-text">
                    <b>{{ $totalAmount ? number_format($totalAmount, 2) : 0.00}}</b>
                </td>
            </tr>
        </tbody>
    </table>
    <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" class="section-footer top-margin" >
        <thead>
            <tr>
                <td width="33%" align="center">
                    <table cellspacing="0" cellpadding="0" border="0" width="50%" align="center">
                        <tbody >
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
                                    ( {{ $pr_item->created_by ? $pr_item->created_by : 'N/A'  }} )
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
                        <tbody >
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
                                    ( {{ $pr_item->approved_by ? $pr_item->approved_by : 'N/A'  }} )
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td width="33%" align="center">
                    <table cellspacing="0" cellpadding="0" border="0" width="50%" align="center">
                        <tbody >
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
                                    ( {{ $printed_by ? $printed_by : 'N/A'  }} )
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
                    Created At {{ \Carbon\Carbon::parse($pr_item->created_at)->format('Y-m-d h:i:s A') }}
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
        .title-text{
            font-family: Arial, Helvetica, sans-serif;
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
