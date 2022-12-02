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

                    {{-- Columna para la tabla de funcionalidades --}}
                    <div class="col-lg-5 border border-danger m-1">
                        {{-- Tabla --}}
                        <h3>Funcionalidades</h3>
                        <table class="table text-light" id="functionalities-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeOf($functionalitiesRev) <= 0 )
                                   <p class="alert alert-danger">No hay funcionalidades por revisar</p> 
                                @else
                                    @foreach ($functionalitiesRev as $functionality)
                                        <tr>
                                            <td class="align-middle">{{$functionality->name}}</td>
                                            <td>
                                                <button type="button" class="btn border-info text-light" data-bs-toggle="modal" data-bs-target="#modal{{$functionality->id}}">
                                                    Ver
                                                </button>
                                                <div class="modal fade" id="modal{{$functionality->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-secondary">
                                                                <h5 class="modal-title" id="exampleModalLabel">Información</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <ul class="list-group">
                                                                    <li class="list-group-item"><strong>Nombre:</strong> <br> {{$functionality->name}}</li>
                                                                    <li class="list-group-item"><strong>Descripción:</strong> <br> {{$functionality->description}}</li>
                                                                    <li class="list-group-item list-group-item-dark d-flex justify-content-center">
                                                                        @if (Auth::user()->type == 'Developer')
                                                                            <form action="{{route('dashboards.functionality.state', ['functionality'=>$functionality->id])}}" method="post" id="form{{$functionality->id}}" class="m-1">
                                                                                @csrf
                                                                                {{-- Manda a QA para que revise --}}
                                                                                <input type="hidden" name="state" value="Revisar">
                                                                                <button type="submit" class="btn btn-sm btn-success text-light">Solucionado</button>
                                                                            </form>
                                                                        @else
                                                                            {{-- QA y Admin --}}
                                                                            <form action="{{route('dashboards.functionality.state', ['functionality'=>$functionality->id])}}" method="post" id="form{{$functionality->id}}" class="m-1">
                                                                                @csrf
                                                                                {{-- Correcto --}}
                                                                                <input type="hidden" name="state" value="Correcto">
                                                                                <button type="submit" class="btn btn-sm btn-success text-light">Solucionado</button>
                                                                            </form>
                                                                            <form action="{{route('dashboards.functionality.state', ['functionality'=>$functionality->id])}}" method="post" id="form{{$functionality->id}}" class="m-1">
                                                                                @csrf
                                                                                {{-- Manda como Defectuoso y notifica al dev --}}
                                                                                <input type="hidden" name="state" value="Defectuoso">
                                                                                <button type="submit" class="btn btn-sm btn-danger text-light">Defectuoso</button>
                                                                            </form>
                                                                        @endif
                                                                    </li>
                                                                  </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>{{-- Modal end--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- Columna para la tabla de criterios --}}
                    <div class="col-lg-5 border border-danger m-1">
                        {{-- Tabla --}}
                        <h3>Criterios</h3>
                        <table class="table text-light" id="criteria-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeOf($criterionRev) <= 0 )
                                   <p class="alert alert-danger">No hay criterios por revisar</p>
                                @else
                                    @foreach ($criterionRev as $criterion)
                                        <tr>
                                            <td>{{$criterion->scenary}}</td>
                                            <td>
                                                <button type="button" class="btn border-info text-light" data-bs-toggle="modal" data-bs-target="#modalC{{$criterion->id}}">
                                                    Ver
                                                </button>
                                                <div class="modal fade" id="modalC{{$criterion->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-secondary">
                                                                <h5 class="modal-title" id="exampleModalLabel">Información</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <ul class="list-group">
                                                                    <li class="list-group-item"><strong>Nombre:</strong> <br> {{$criterion->scenary}}</li>
                                                                    <li class="list-group-item"><strong>Descripción:</strong> <br> {{$criterion->description}}</li>
                                                                    <li class="list-group-item list-group-item-dark d-flex justify-content-center">
                                                                        @if (Auth::user()->type == 'Developer')
                                                                            <form action="{{route('dashboards.criterion.state', ['criterion'=>$criterion->id])}}" method="post">
                                                                                @csrf
                                                                                {{-- Manda a QA para que revise --}}
                                                                                <input type="hidden" name="state" value="Revisar">
                                                                                <button type="submit" class="btn btn-sm btn-success text-light">Solucionado</button>
                                                                            </form>
                                                                        @else
                                                                            {{-- QA y Admin --}}
                                                                            <form action="{{route('dashboards.criterion.state', ['criterion'=>$criterion->id])}}" method="post">
                                                                                @csrf
                                                                                {{-- Correcto --}}
                                                                                <input type="hidden" name="state" value="Correcto">
                                                                                <button type="submit" class="btn btn-sm btn-success text-light m-1">Solucionado</button>
                                                                            </form>
                                                                            <form action="{{route('dashboards.criterion.state', ['criterion'=>$criterion->id])}}" method="post">
                                                                                @csrf
                                                                                {{-- Manda como Defectuoso y notifica al dev --}}
                                                                                <input type="hidden" name="state" value="Defectuoso">
                                                                                <button type="submit" class="btn btn-sm btn-danger text-light m-1">Defectuoso</button>
                                                                            </form>
                                                                        @endif
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>{{-- Modal end--}}
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