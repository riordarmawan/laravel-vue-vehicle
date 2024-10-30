<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehiclesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Vehicle::select('id', 'brand', 'name', 'price', 'seat', 'transmission', 'type')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Brand',
            'Name',
            'Price',
            'Seat',
            'Transmission',
            'Type',
        ];
    }
}
