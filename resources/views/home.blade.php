<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Styles -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <!-- Alpine Plugins -->
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>

        <!-- Alpine Core -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('cars.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col form-group">
                                <label>Arquivo XLS</label>
                                <input type="file" name="file" class="form-control">
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary">
                                    <i class="fas fa-file-import"></i>
                                    Importar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div x-data="app()">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <label>Placa</label>
                                <input type="text" class="form-control" x-model="plate">
                            </div>
                            <div class="col">
                                <label>Modelo</label>
                                <input type="text" class="form-control" x-model="model">
                            </div>
                            <div class="col">
                                <label>Ano</label>
                                <input type="text" class="form-control" x-model="year_min">
                                <label>Ano</label>
                                <input type="text" class="form-control" x-model="year_max">
                            </div>
                            <div class="col">
                                <label>Cor</label>
                                <input type="text" class="form-control" x-model="color">
                            </div>
                            <div class="col">
                                <label>KM</label>
                                <input type="text" class="form-control" x-model="km_min">
                                <label>KM</label>
                                <input type="text" class="form-control" x-model="km_max">
                            </div>
                            <div class="col">
                                <label>FIPE min</label>
                                <input type="text" class="form-control" x-model="table_price_min"
                                x-mask:dynamic="$money($input, '.', '')">
                                <label>FIPE max</label>
                                <input type="text" class="form-control" x-model="table_price_max"
                                    x-mask:dynamic="$money($input, '.', '')">
                            </div>
                            <div class="col">
                                <label>Preço min</label>
                                <input type="text" class="form-control" x-model="price_min"
                                    x-mask:dynamic="$money($input, '.', '')">
                                <label>Preço máx</label>
                                <input type="text" class="form-control" x-model="price_max"
                                    x-mask:dynamic="$money($input, '.', '')">
                            </div>
                        </div>
                        <p>
                            <strong>Total de registros: </strong>
                            <span x-text="cars.length"></span>
                        </p>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Placa</th>
                        <th>Modelo</th>
                        <th>
                            <a class="text-decoration-none text-dark"
                                @if (request()->get('sort_direction') == 'asc' && request()->get('sort') == 'year')
                                href="{{ route('cars', ['sort' => 'year', 'sort_direction' => 'desc']) }}">
                                    Ano
                                    <i class="bi bi-sort-numeric-up"></i>
                            @else
                                href="{{ route('cars', ['sort' => 'year', 'sort_direction' => 'asc']) }}">
                                    Ano
                                    <i class="bi bi-sort-numeric-down"></i>
                            @endif
                            </a>
                        </th>
                        <th>Cor</th>
                        <th>
                            <a class="text-decoration-none text-dark"
                                @if (request()->get('sort_direction') == 'asc' && request()->get('sort') == 'km')
                                href="{{ route('cars', ['sort' => 'km', 'sort_direction' => 'desc']) }}">
                                    KM
                                    <i class="bi bi-sort-numeric-up"></i>
                            @else
                                href="{{ route('cars', ['sort' => 'km', 'sort_direction' => 'asc']) }}">
                                    KM
                                    <i class="bi bi-sort-numeric-down"></i>
                            @endif
                            </a>
                        </th>
                        <th>KM/Ano</th>
                        <th>
                            <a class="text-decoration-none text-dark"
                                @if (request()->get('sort_direction') == 'asc' && request()->get('sort') == 'table_price')
                                href="{{ route('cars', ['sort' => 'table_price', 'sort_direction' => 'desc']) }}">
                                    Fipe
                                    <i class="bi bi-sort-numeric-up"></i>
                            @else
                                href="{{ route('cars', ['sort' => 'table_price', 'sort_direction' => 'asc']) }}">
                                    Fipe
                                    <i class="bi bi-sort-numeric-down"></i>
                            @endif
                            </a>
                        </th>
                        <th>
                            <a class="text-decoration-none text-dark"
                                @if (request()->get('sort_direction') == 'asc' && request()->get('sort') == 'price')
                                href="{{ route('cars', ['sort' => 'price', 'sort_direction' => 'desc']) }}">
                                    Preço
                                    <i class="bi bi-sort-numeric-up"></i>
                            @else
                                href="{{ route('cars', ['sort' => 'price', 'sort_direction' => 'asc']) }}">
                                    Preço
                                    <i class="bi bi-sort-numeric-down"></i>
                            @endif
                            </a>
                        </th>
                        <th>Desconto (R$)</th>
                        <th>Desconto (%)</th>
                        <th>Local</th>
                        <th>Origem</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="car in cars">
                        <tr x-show="canShow(car)">
                            <td>
                                <span x-text="car.plate"></span>
                            </td>
                            <td>
                                <span x-text="car.model"></span>
                            </td>
                            <td>
                                <span x-text="car.year"></span>
                            </td>
                            <td>
                                <span x-text="car.color"></span>
                            </td>
                            <td>
                                <span x-text="car.km"></span> KM
                            </td>
                            <td>
                                <span x-text="car.km_by_year"></span>
                            </td>
                            <td>
                                R$ <span x-text="car.table_price"></span>
                            </td>
                            <td>
                                R$ <span x-text="car.price"></span>
                            </td>
                            <td>
                                R$ <span x-text="car.discount"></span>
                            </td>
                            <td>
                                <span x-text="car.discount_percent"></span>%
                            </td>
                            <td>
                                <span x-text="car.place"></span>
                            </td>
                            <td>
                                <span x-text="car.origin"></span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <script>
            function app() {
                return {
                    cars: @json($cars),
                    plate: '',
                    model: '',
                    year_min: '',
                    year_max: '',
                    color: '',
                    km_min: 1,
                    km_max: 150000,
                    table_price_min: '',
                    table_price_max: '',
                    price_min: 15000,
                    price_max: 30000,
                    canShow(car) {
                        return this.filterPlate(car) &&
                            this.filterModel(car) &&
                            this.filterYear(car) &&
                            this.filterColor(car) &&
                            this.filterKm(car) &&
                            this.filterTablePrice(car) &&
                            this.filterPrice(car)
                    },
                    filterPlate(car) {
                        if (!this.plate)
                            return true;
                        return car.plate.toLowerCase().includes(this.plate.toLowerCase())
                    },
                    filterModel(car) {
                        if (!this.model)
                            return true;
                        return car.model.toLowerCase().includes(this.model.toLowerCase())
                    },
                    filterYear(car) {
                        var approved = true;
                        if (this.year_min && this.year_max) {
                            approved = car.year >= this.year_min && car.year <= this.year_max
                        } else if (this.year_min) {
                            approved = car.year >= this.year_min
                        } else if (this.year_max) {
                            approved = car.year <= this.year_max
                        }
                        return approved;
                    },
                    filterColor(car) {
                        return car.color.toLowerCase().includes(this.color.toLowerCase())
                    },
                    filterKm(car) {
                        var approved = true;
                        if (this.km_min && this.km_max) {
                            approved = car.km >= this.km_min && car.km <= this.km_max
                        } else if (this.km_min) {
                            approved = car.km >= this.km_min
                        } else if (this.km_max) {
                            approved = car.km <= this.km_max
                        }
                        return approved;
                    },
                    filterTablePrice(car) {
                        var approved = true;
                        if (this.table_price_min && this.table_price_max) {
                            approved = car.table_price >= this.table_price_min && car.table_price <= this.table_price_max
                        } else if (this.table_price_min) {
                            approved = car.table_price >= this.table_price_min
                        } else if (this.table_price_max) {
                            approved = car.table_price <= this.table_price_max
                        }
                        return approved;
                    },
                    filterPrice(car) {
                        var approved = true;
                        var price = parseInt(car.price);
                        if (this.price_min && this.price_max) {
                            approved = price >= this.price_min && price <= this.price_max
                        } else if (this.price_min) {
                            approved = price >= this.price_min
                        } else if (this.price_max) {
                            approved = price <= this.price_max
                        }
                        return approved;
                    },
                }
            }
        </script>
    </body>
</html>
