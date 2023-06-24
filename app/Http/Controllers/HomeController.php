<?php

namespace App\Http\Controllers;

use App\Imports\CarsImport;
use App\Models\Car;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{

    public function index()
    {
        $sort = request()->get('sort', 'price');
        $sort_direction = request()->get('sort_direction', 'asc');

        $cars = Car::orderBy($sort, $sort_direction)->get();

        return view('home', compact('cars'));
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        $file->storeAs('public', 'cars.xlsx');
        $path = storage_path('app/public/cars.xlsx');

        Excel::import(new CarsImport, $path);

        return redirect()->route('home');
    }
}
