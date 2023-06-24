<?php

namespace App\Imports;

use App\Models\Car;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CarsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        if($row[0] == 'Placa') {
            return null;
        }

        $table_price_row = $row[5] == 'R$' ? 6 : 5;
        $price_row = $row[7] == 'R$' ? 8 : 7;
        $place_row = 9;

        return new Car([
            'plate'     => $row[0],
            'model'    => $row[1],
            'year'    => $row[2],
            'km'    => $row[3],
            'color'    => $row[4],
            'price'    => $this->convertToDecimal($row[$price_row]),
            'table_price'    => $this->convertToDecimal($row[$table_price_row]),
            'place'    => $row[$place_row],
            'origin' => 'Evento Itaú - ' . Carbon::now()->format('d/m/Y'),
            'discount' => $this->convertToDecimal($row[$table_price_row]) - $this->convertToDecimal($row[$price_row]),
            'discount_percent' => ($this->convertToDecimal($row[$table_price_row]) - $this->convertToDecimal($row[$price_row])) / $this->convertToDecimal($row[$table_price_row]) * 100,
        ]);
    }

    private function convertToDecimal($value) {
        return str_replace(',', '.', str_replace('.', '', str_replace('R$', '', $value)));
    }
}
