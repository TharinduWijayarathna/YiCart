@extends('print.layouts.app')
@section('content')
    @foreach ($stockItems as $item)
        <table cellspacing="0" cellpadding="0" border="0" width="100%" class="section-table">
            <tbody>
                <tr class="row-bg">
                    <td width="30%" align="left">
                        <img src="data:image/svg;base64, {{ $item['qrCode'] }}">
                    </td>
                    <td width="70%" align="left" class="td-style">
                        <p class="td-location_name"> {{ $item['item']['barcode'] }} </p>
                        <p class="td-description">{{ $item['item']['material'] ? $item['item']['material']['code'] : '' }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
    @endforeach

    <style>
        .td-style {
            font-family: arial;
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

        .td-location_name {
            font-size: 2.5rem;
            font-weight: bold;
            padding: 0px;
            margin: 0px;
        }
    </style>
@endsection
