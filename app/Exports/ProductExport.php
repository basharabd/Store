<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithHeadings;




class ProductExport implements FromQuery , WithMapping ,WithColumnFormatting ,WithHeadings
{
    use Exportable;

    protected $query;

    public function setQuery($query)
    {
        $this->query = $query;
    }


    public function query()
    {
        return $this->query;
    }

    public function map($product): array
    {
        return [
            $product->name,
            $product->description,
            $product->price,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
        ];
    }

    public function headings():  array
    {
        return[
            'Name',
            'Description',
            'Price',
        ];

    }
}
