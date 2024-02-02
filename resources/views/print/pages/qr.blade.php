@extends('print.layouts.app')
@section('content')
    @foreach ($grnItems as $item)
        {{-- <table cellspacing="0" cellpadding="0" border="0" width="100%" class="section-table">
            <tbody>
                <tr class="row-bg">
                    <td width="30%" align="left">
                        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($item['item']->sku,'C39') }}" height="60" width="180" /><br />
                    </td>
                    <td width="70%" align="left" class="td-style">
                        <p class="td-location_name"> {{ $item['item']->sku }} </p>
                        <p class="td-description">{{ $item['item']->material ? $item['item']->material->code : '' }}</p>
                    </td>
                </tr>
            </tbody>
        </table> --}}
        <table cellspacing="0" cellpadding="0" border="0" width="100%" class="date-block">
            <tbody>
                <tr>
                    <td width="40%" align="left">
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tbody>
                                <tr class="row-bg">
                                    <td width="100%" align="center">
                                        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($item['item']->sku, 'C39') }}"
                                            height="40" width="515" /><br />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%" align="center" class="td-style">
                                        <p class="td-material_name">
                                            {{ Illuminate\Support\Str::limit($item['item']->sku, 20) }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%" align="center" class="td-style">
                                        <p class="td-material_name">
                                            {{ Illuminate\Support\Str::limit($item['item']->material_code, 20) }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table cellspacing="0" cellpadding="0" border="0" width="100%" >
                            <tbody>
                                <tr>
                                    <td width="30%" align="left" class="td-style">
                                        <p class="td-material_code"> {{ $item['item']->production_date}} </p>
                                    </td>
                                    <td width="40%" align="center" class="td-style">
                                        <p class="td-material_code">{{ $item['item']->warehouse_name }}</p>
                                    </td>
                                    <td width="30%" align="right" class="td-style">
                                        <p class="td-material_code"> {{ $item['item']->quantity}} </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td width="100px">
                        &nbsp;
                    </td>
                    <td width="40%" align="right">
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tbody>
                                <tr class="row-bg">
                                    <td width="100%" align="center">
                                        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($item['item']->sku, 'C39') }}"
                                            height="40" width="515" /><br />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%" align="center" class="td-style">
                                        <p class="td-material_name">
                                            {{ Illuminate\Support\Str::limit($item['item']->sku, 20) }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tbody>
                                <tr>
                                    <td width="100%" align="center" class="td-style">
                                        <p class="td-material_name">
                                            {{ Illuminate\Support\Str::limit($item['item']->material_code, 20) }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table cellspacing="0" cellpadding="0" border="0" width="100%" >
                            <tbody>
                                <tr>
                                    <td width="30%" align="left" class="td-style">
                                        <p class="td-material_code"> {{ $item['item']->production_date }} </p>
                                    </td>
                                    <td width="40%" align="center" class="td-style">
                                        <p class="td-material_code">{{ $item['item']->warehouse_name }}</p>
                                    </td>
                                    <td width="30%" align="right" class="td-style">
                                        <p class="td-material_code"> {{ $item['item']->quantity }} </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    @endforeach

    <style>
        .td-style {
            font-family: 'Arial';
        }

        .margin-top {
            margin-top: 20px;
        }

        .td-description {
            font-size: 2rem;
            font-weight: bold;
            padding: 0px;
            margin: 0px;
            padding-bottom: 3px;
        }

        .td-barcode {
            font-size: 2.5rem;
            font-weight: bold;
            padding: 0px;
            margin: 0px;
            padding-bottom: 3px;
        }

        .td-serial_no {
            font-size: 30px;
            font-weight: bold;
            padding: 0px;
            margin: 0px;
            padding-bottom: 3px;
        }

        .td-category_name {
            font-size: 2.5rem;
            font-weight: bold;
            padding: 0px;
            margin: 0px;
            padding-bottom: 3px;
        }

        .td-material_code {
            font-size: 1.5rem;
            font-weight: 600;
            padding: 0px;
            margin: 0px;
        }

        .td-barcode_data {
            font-size: 1.2rem;
            font-weight: 600;
            padding: 0px;
            margin: 0px;
        }

        .td-material_name {
            font-size: 1.9rem;
            font-weight: 900;
            padding: 0px;
            margin: 0px;
        }

        .td-material_selling_price {
            font-size: 2.5rem;
            font-weight: bold;
            padding: 0px;
            margin: 0px;
        }

        .date-block {
            margin-top: 0px;
        }
    </style>
@endsection
