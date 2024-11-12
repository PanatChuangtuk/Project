<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'size' => $product->size,
                'model' => $product->model,
                'price' => $product->price,
                'quantity' => $product->quantity,
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Size', 'Model', 'Price', 'Quantity'];
    }
}