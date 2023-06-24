<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate',
        'model',
        'year',
        'km',
        'color',
        'table_price',
        'price',
        'place',
        'origin',
    ];

    protected $casts = [
        'discount' => 'decimal:2',
        'discount_percent' => 'decimal:2',
    ];

    protected $appends = [
        'discount',
        'discount_percent',
        'km_by_year'
    ];

    public function getDiscountAttribute()
    {
        return $this->table_price - $this->price;
    }

    public function getDiscountPercentAttribute()
    {
        return number_format(($this->table_price - $this->price) / $this->table_price * 100, 0, ',', '.');
    }

    public function getKmByYearAttribute()
    {
        if (!$this->year || !$this->km)
            return null;

        $year = Carbon::now()->year - $this->year;

        return number_format($this->km / ($year == 0 ? 1 : $year), 0, ',', '.');
    }
}
