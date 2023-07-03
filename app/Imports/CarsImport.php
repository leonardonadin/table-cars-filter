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

        if ($row[5] == 'R$') {
            $table_price_row = 6;
            $price_row = $row[7] == 'R$' ? 8 : 7;
        } else {
            $table_price_row = 5;
            $price_row = $row[6] == 'R$' ? 7 : 6;
        }

        $place_row = $price_row + 1;

        $price = $this->convertToDecimal($row[$price_row]);
        $table_price = $this->convertToDecimal($row[$table_price_row]);

        try {
            $car = new Car([
                'plate'     => $row[0],
                'model'    => $row[1],
                'year'    => $row[2],
                'km'    => $row[3],
                'color'    => $row[4],
                'price'    => $price,
                'table_price' => $table_price,
                'place'    => $row[$place_row],
                'origin' => 'Evento Itaú - ' . Carbon::now()->format('d/m/Y'),
                'discount' => $table_price - $price,
                'discount_percent' => ($table_price - $price) / $table_price * 100,
            ]);
        } catch (\Exception $e) {
            dd($row);
        }

        return $car;
    }

    private function convertToDecimal($value) {
        return str_replace(',', '.', str_replace('.', '', str_replace('R$', '', $value)));
    }
}
