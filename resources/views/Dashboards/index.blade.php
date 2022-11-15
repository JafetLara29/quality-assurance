@extends('layouts.adminhome')
@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container justify-content-center text-center text-light">
            <div class="card dashboard-card">
                <h1>Bajo responsabilidad</h1>
                <div class="row justify-content-center text-center">
                    <div class="col-lg-3">
                        <!-- small box -->
                        <div class="small-box text-light">
                            <div class="inner">
                                <h4 id="totalProductos">Funcionalidades</h4>
                                <p>{{$functionalities}}</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-clipboard"></i>
                            </div>
                        </div>
                    </div>
        
                    <!-- TARJETA TOTAL COMPRAS -->
                    <div class="col-lg-3">
                        <!-- small box -->
                        <div class="small-box text-light">
                            <div class="inner">
                                <h4 id="totalCompras">Criterios</h4>
                                <p>{{$criterion}}</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-cash"></i>
                            </div>
                        </div>
                    </div>
        
                    <!-- TARJETA TOTAL VENTAS -->
                    <div class="col-lg-3">
                        <!-- small box -->
                        <div class="small-box text-light">
                            <div class="inner">
                                <h4 id="totalVentas">Módulos</h4>
                                <p>{{$modules}}</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-cart"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <h1>Por revisar</h1>
            </div>
            <div class="container justify-content-center">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
    <script>
        const ctx = document.getElementById('myChart');
      
        new Chart(ctx, {
            type: 'polarArea',
            data: {
                labels: ['Funcionalidades', 'Criterios'],
                datasets: [{
                    label: 'Numero',
                    data: [{{$functionalitiesRev}}, {{$criterionRev}}],
                    backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(75, 192, 192)',
                    'rgb(255, 205, 86)',
                    'rgb(201, 203, 207)',
                    'rgb(54, 162, 235)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
            });
    </script>
@endsection