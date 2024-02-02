<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithStyles;

class ProductStockExport implements FromView, WithColumnWidths, WithStyles
{
    protected $product;

    public function view(): View
    {
        return view('Export.ProductsReport', ['product' => $this->product]);
    }

    public function export($product)
    {
        $this->product = $product;
        return $this;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 20,
            'I' => 20,
            'J' => 20,
            'K' => 20,
            'L' => 20,
            'M' => 20,
            'N' => 20,
            'O' => 20,
            'P' => 20,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }


    public function styles(Worksheet $sheet)
    {
        return [
            1    => [
                'font' => ['bold' => true, 'size' => 16],
            ],
            // 2nd row
            3    => [
                'font' => ['bold' => false, 'size' => 14],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'color' => array('rgb' => '92d050'),
                ]
            ],

            // specific ones
            // 'A4'    => ['font' => ['bold' => true, 'size' => 11]],
            // 'A5'    => ['font' => ['bold' => true, 'size' => 11]],
            // 'A6'    => ['font' => ['bold' => true, 'size' => 11]],
            // 'A7'    => ['font' => ['bold' => true, 'size' => 11]],
            // 'A8'    => ['font' => ['bold' => true, 'size' => 11]],
            // 'A9'    => ['font' => ['bold' => true, 'size' => 11]],
            // 'A10'    => ['font' => ['bold' => true, 'size' => 11]],
            // 'A12'    => ['font' => ['bold' => true, 'size' => 11]],

            // 'C4'    => ['font' => ['bold' => true, 'size' => 11]],
        ];
    }
}
