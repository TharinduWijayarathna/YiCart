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
    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="top-margin">
        <thead>
            <tr class="heading-bg-po">
                <th class="title-text"   style="text-align: middle; padding-top: 3px; padding-bottom: 6px;">
                    GOOD RECEIVE NOTE - {{ $grn_item->code }}
                </th>
            </tr>
        </thead>
    </table>
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <tbody >
            <tr class="row-bg ">
                <td width="60%" align="left" class="td-style">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="30%" class="td-style" style="text-align: left;"><b>Warehouse</b></td>
                                    <td width="70%" align="left" class="txt-size">{{ $grn_item->warehouse_name }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="30%" class="td-style" style="text-align: left;"><b>GRN Type</b></td>
                                    <td width="70%" align="left" class="txt-size">{{ $grn_item->transaction_name }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="30%" class="td-style"  style="text-align: left;"><b>Eff Date</b></td>
                                    <td width="70%" align="left" class="txt-size">{{ $grn_item->date }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="30%" class="td-style"  style="text-align: left;"><b>Status</b></td>
                                    <td width="70%" align="left" class="txt-size">{{ $grn_item->status == 0 ? "Draft" : "Approved" }}</td>
                                </tr>
                            </tbody>
                        </table>
                </td>
                <td width="40%" align="left">
                    <table  width="100%" align="right">
                        <tbody>
                            <tr>
                                <td width="30%" class="td-style lefet-text" align="left"><b>Audit Code</b></td>
                                <td width="70%" align="left" class="right-text txt-size" >{{ $grn_item->audit_code ? $grn_item->audit_code  :'N/A'  }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @if ($grn_item->po_id)
                    <table  width="100%" align="right">
                        <tbody>
                            <tr>
                                <td width="30%" class="td-style lefet-text" align="left"><b>PO Code</b></td>
                                <td width="70%" align="left" class="right-text txt-size" >{{ $grn_item->po_code ? $grn_item->po_code  :'N/A'  }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                    @if ($grn_item->pr_id)
                    <table  width="100%" align="right">
                        <tbody>
                            <tr>
                                <td width="30%" class="td-style lefet-text" align="left"><b>PR Code</b></td>
                                <td width="70%" align="left" class="right-text txt-size" >{{ $grn_item->pr_code ? $grn_item->pr_code  :'N/A'  }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                    <table width="100%" align="right">
                        <tbody>
                            <tr>
                                <td width="30%" class="td-style " align="left"><b>Ref No.</b></td>
                                <td width="70%" align="right" class="right-text txt-size">{{ $grn_item->ref ? $grn_item->ref  :'' }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table width="100%"  align="right">
                        <tbody>
                            <tr>
                                <td width="30%" class="td-style " align="left"><b>Invoice No.</b></td>
                                <td width="70%" align="right" class="right-text txt-size">{{ $grn_item->invoice_code ? $grn_item->invoice_code  :'' }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table  width="100%" align="right">
                        <tbody>
                            <tr>
                                <td width="30%" class="td-style " align="left"><b>Vehicle No.</b></td>
                                <td width="70%" align="left" class="right-text txt-size">{{ $grn_item->vehicle ? $grn_item->vehicle  :''  }}</td>
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
                <td width="10%" align="left" class="border-l td-style left-text">
                    <b>Barcode</b>
                </td>
                <td width="25%" align="left" class="border-l td-style left-text">
                    <b>Material</b>
                </td>
                <td width="10%" align="left" class="border-l td-style left-text">
                    <b>Location</b>
                </td>
                <td width="10%" align="left" class="border-l td-style left-text">
                    <b>Bin</b>
                </td>
                <td width="10%" align="left" class="border-l td-style left-text">
                    <b>Production Date</b>
                </td>
                <td width="10%" align="right" class="border-l td-style right-text" style="width: 10%;">
                    <b>Cost</b>
                </td>
                <td width="10%" align="right" class="border-l td-style right-text" style="width: 10%;">
                    <b>QTY</b>
                </td>
                <td width="10%" align="right" class="border-l border-r td-style right-text" style="width: 10%;">
                    <b>Total</b>
                </td>
            </tr>
        </thead>
        <tbody class="border-mt border-mb">
         @foreach ($grn_item->grn_items as $key => $item)
                <tr class="row-bg border-b">
                    <td width="10%" align="left" class="border-l td-style left-text">
                        {{ $item->material ? $item->material->barcode : '' }}
                    </td>
                    <td width="25%" align="left" class="border-l td-style left-text">
                        {{ $item->material ? $item->material->name : '' }} - {{ $item->material ? $item->material->description : '' }}
                    </td>
                    <td width="10%" align="left" class="border-l td-style left-text">
                        {{ $item->location_name }}
                    </td>
                    <td width="10%" align="left" class="border-l td-style left-text">
                        {{ $item->bin_name }}
                    </td>
                    <td width="10%" align="left" class="border-l td-style left-text">
                        {{ $item->production_date }}
                    </td>
                    <td width="10%" align="right" class="border-l td-style right-text" style="width: 10%;">
                        {{ $item->formate_material_cost }}
                    </td>
                    <td width="10%" align="right" class="border-l td-style right-text" style="width: 10%;">
                        {{ number_format($item->quantity, 2) }}
                    </td>
                    <td width="10%" align="right" class="border-l border-r td-style right-text" style="width: 10%;">
                        {{ $item->formate_line_total }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table><table cellspacing="0" cellpadding="0" border="0" width="100%" class="border-mt">
    </table>
    <table cellspacing="0" cellpadding="0" border="0" width="40%" class="border-mt content-end">
        <tbody class="border-mb">
            <tr class="row-bg border-b">
                <td width="60%" align="right" class="border-l border-r td-style right-text" >
                    <b>Total Amount</b>
                </td>
                <td width="40%" align="right" class="border-r td-style right-text" >
                    <b>{{ $total['item_line_total'] ?  $total['item_line_total'] : 0.00  }}</b>
                </td>
            </tr>
            <tr class="row-bg border-b">
                <td width="60%" align="right" class="border-l border-r td-style right-text" >
                    <b>Total Discount(%)</b>
                </td>
                <td width="40%" align="right" class="border-r td-style right-text" >
                    <b>{{ $grn_item->discount ? $grn_item->discount : 0.00  }}</b>
                </td>
            </tr>
            <tr class="row-bg border-b">
                <td width="60%" align="right" class="border-l border-r td-style right-text" >
                    <b>Net Amount</b>
                </td>
                <td width="40%" align="right" class="border-r td-style right-text" >
                    <b>{{ $total['net_amount'] ?  $total['net_amount'] : 0.00  }}</b>
                </td>
            </tr>
            <tr class="row-bg border-b">
                <td width="60%" align="right" class="border-l border-r td-style right-text" >
                    <b>Vat Amount (%)</b>
                </td>
                <td width="40%" align="right" class="border-r td-style right-text" >
                    <b>{{ $grn_item->vat ? $grn_item->vat : 0.00  }}</b>
                </td>
            </tr>
            <tr class="row-bg border-b">
                <td width="60%" align="right" class="border-l border-r td-style right-text" >
                    <b>Tax Amount (%)</b>
                </td>
                <td width="40%" align="right" class="border-r td-style right-text" >
                    <b>{{ $grn_item->tax ? $grn_item->tax : 0.00  }}</b>
                </td>
            </tr>
            <tr class="row-bg border-b">
                <td width="60%" align="right" class="border-l border-r td-style right-text" >
                    <b>Grand Total</b>
                </td>
                <td width="40%" align="right" class="border-r td-style right-text" >
                    <b>{{ $total['grand_total'] ?  $total['grand_total'] : 0.00  }}</b>
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
                                    ( {{ $grn_item->created_by ? $grn_item->created_by : 'N/A'  }} )
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
                                    ( {{ $grn_item->approved_by ? $grn_item->approved_by : 'N/A'  }} )
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
                                    ( {{ $grn_item->approved_by ? $grn_item->approved_by : 'N/A'  }} )
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
                    Created At {{ \Carbon\Carbon::parse($grn_item->created_at)->format('Y-m-d h:i:s A') }}
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
        .content-end{
            margin-top: 1rem;
            margin-left: 60%;
            margin-right: 0;
        }
        .title-text{
            font-family: Arial, Helvetica, sans-serif;
        }
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
        .txt-size{
            font-size: .8rem;
            font-family: Arial, Helvetica, sans-serif;
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
