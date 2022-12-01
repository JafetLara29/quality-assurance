@extends('layouts.adminhome')
@section('content')
    <!-- Main content -->
    <div class="content">
        {{-- Cantidad de modulos, funcionalidades y criterios asignados --}}
        <div class="container justify-content-center text-center text-light mb-3">
            <div class="card dashboard-card p-4">
                <h1>Bajo responsabilidad</h1>
                <div class="row justify-content-center text-center">
                    <div class="col-lg-3 border border-info m-2">
                        <!-- small box -->
                        <div class="small-box text-light p-3">
                            <div class="inner">
                                <p>{{$modulesCount}}</p>
                                <h4 id="totalVentas">Módulo(s)</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 border border-success m-2">
                        <!-- small box -->
                        <div class="small-box text-light p-3">
                            <div class="inner">
                                <p>{{$functionalitiesCount}}</p>
                                <h4 id="totalProductos">Funcionalidad(es)</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 border border-warning m-2">
                        <!-- small box -->
                        <div class="small-box text-light p-3">
                            <div class="inner">
                                <p>{{$criterionCount}}</p>
                                <h4 id="totalCompras">Criterio(s)</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        {{-- Modulos, funcionalidades y criterios por revisar --}}
        <div class="container justify-content-center text-center text-light mb-3">
            <div class="card dashboard-card p-4">
                <h1>Por revisar</h1>
                <div class="row justify-content-center text-center">
                    
                    <div class="col-lg-5 border border-danger m-2">
                        {{-- Tabla --}}
                        <h3>Funcionalidades</h3>
                        <table class="table text-light" id="functionalities-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeOf($functionalitiesRev) <= 0 )
                                   <p class="alert alert-danger">No hay funcionalidades por revisar</p> 
                                @else
                                    @foreach ($functionalitiesRev as $functionality)
                                        <tr>
                                            <td>{{$functionality->name}}</td>
                                            <td>{{$functionality->description}}</td>
                                            <td>
                                                <form action="{{route('dashboards.functionality.state', ['functionality'=>$functionality->id])}}" method="post" id="form{{$functionality->id}}">
                                                    @csrf
                                                    {{-- <select class="btn text-light bg-dark border-success @error('type') is-invalid @enderror" name="state" id="state{{$functionality->id}}" onchange="changeState('{{$functionality->id}}')">
                                                        <option {{ $functionality->state == "Correcto"?"Selected":"" }} value="Correcto">Correcto</option>
                                                        <option {{ $functionality->state == "Defectuoso"?"Selected":"" }} value="Defectuoso">Defectuoso</option>
                                                        <option {{ $functionality->state == "Revisar"?"Selected":"" }} value="Revisar">Revisar</option>
                                                    </select> --}}
                                                    <button type="submit" class="btn border-info text-light">Solucionado</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="col-lg-5 border border-danger m-2">
                        {{-- Tabla --}}
                        <h3>Criterios</h3>
                        <table class="table text-light" id="criteria-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeOf($criterionRev) <= 0 )
                                   <p class="alert alert-danger">No hay criterios por revisar</p>
                                @else
                                    @foreach ($criterionRev as $criterion)
                                        <tr>
                                            <td>{{$criterion->name}}</td>
                                            <td>{{$criterion->description}}</td>
                                            <td>
                                                <form action="{{route('dashboards.criterion.state', ['criterion'=>$criterion->id])}}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn border-info text-light">Solucionado</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            
        </div>

        {{-- Grafica --}}
        <div class="container justify-content-center">
            <canvas id="myChart"></canvas>
        </div>
    </div>
    <script>
        // Chart
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Funcionalidades', 'Criterios'],
                datasets: [{
                    label: 'Numero',
                    data: [{{$functionalitiesRevCount}}, {{$criterionRevCount}}],
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
        // Tables
        $(document).ready(function () {
            $('#functionalities-table').DataTable({
                stateSave: true,
                pagingType: 'full_numbers',
                scrollY: '200px',
                scrollCollapse: true,
                language: {
                    lengthMenu: 'Filas_MENU_',
                    zeroRecords: 'Nada que mostrar',
                    info: 'Página #_PAGE_',
                    infoEmpty: 'No hay coincidencias',
                    search: 'Buscar',
                    infoFiltered: '(Filtrado de _MAX_ registros)',
                },
                searching: false,
            });
            $('#criteria-table').DataTable({
                stateSave: true,
                pagingType: 'full_numbers',
                scrollY: '200px',
                scrollCollapse: true,
                language: {
                    lengthMenu: 'Mostrando _MENU_ filas por página',
                    zeroRecords: 'Nada que mostrar',
                    info: 'Página #_PAGE_ de _PAGES_',
                    infoEmpty: 'No hay coincidencias',
                    search: 'Buscar',
                    infoFiltered: '(Filtrado de _MAX_ registros)',
                },
                searching: false,
            });    
        });
        // Metodos
        function changeState(id){
            var form = document.getElementById('form'+id);
            form.submit();
        }
    </script>
@endsection