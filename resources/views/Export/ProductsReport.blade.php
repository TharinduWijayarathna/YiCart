@extends('print.layouts.app')
@section('content')
    <p>Product Registry </p>
    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="product_table">
        <thead class="product_table_head">
            <tr>
                <th width="5%" class="table_head_data" align="left">#</th>
                <th width="20%" class="table_head_data" align="left">Product Code</th>
                <th width="30%" class="table_head_data" align="left">Name</th>
                {{-- <th width="15%" class="table_head_data" align="left">Unit</th> --}}
                <th width="15%" class="table_head_data" align="left">Stock</th>
                {{-- @if ($print_type == 1)
                    <th width="15%" align="right" class="table_head_data" >Cost</th>
                @endif --}}
                <th width="15%" align="right" class="table_head_data" >Cost</th>
                <th width="15%" align="right" class="table_head_data">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($product as $key => $products)
                <tr>
                    <td align="left" class="table_td">{{ ++$key }}</td>
                    <td align="left" class="table_td">{{ $products->code }}</td>
                    <td align="left" class="table_td">{{ $products->name }}</td>
                    {{-- <td align="left" class="table_td">
                       @foreach ( $unit as $units )
                            @if($products->unit==$units->id)
                            <span >{{ $units->title }}</span>
                            @endif
                       @endforeach
                    </td> --}}
                    <td align="right" class="table_td">{{ number_format($products->stock_quantity, 2) }}</td>
                    {{-- @if ($print_type == 1)
                        <td align="right" class="table_td">{{ number_format($products->cost, 2) }}</td>
                    @endif --}}
                    <td align="right" class="table_td">{{ number_format($products->cost, 2) }}</td>
                    <td align="right" class="table_td">{{ number_format($products->selling, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="footer-area">
        <thead>
            <tr>
                <td class="footer-content">
                    Created At {{ Carbon\Carbon::now()->setTimezone('Asia/Colombo')->format('d M, Y h:i A') }} | Prepared By www.ibilz.com
                </td>
            </tr>
        </thead>
    </table>


    <style>
        .brand-logo {
            width: 100px;
        }

        .customer_data {
            padding-left: 2rem;
        }

        .product_title {
            text-transform: uppercase;
            font-size: 1.5rem;
            font-weight: 500;
        }

        .company_data {
            font-size: 0.8rem;
            font-weight: 400;
        }

        .product_table {
            margin-top: 1.5rem;
            border-collapse: collapse;
        }

        .product_table_head {
            background-color: #f5f5f5;
            margin-top: 1.5rem;
        }

        .product_date {
            font-weight: 400;
            vertical-align: top;
        }

        .table_head_data {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            font-weight: 500;
        }

        .table_td {
            font-size: 0.8rem;
            padding-top: 0.3rem;
            padding-bottom: 0.3rem;
            font-weight: 400;
        }

        .footer-content {
            text-align: center;
            font-size: 8px;
        }

        .footer-area{
            margin-top: 3rem;
        }
    </style>
@endsection
