@extends('layouts.adminhome')
@section('content')
    {{-- <h1 class="display-4 mb-5 text-center">QRM-Quality Assurance</h1> --}}
    
    {{-- Sección para control de modulos --}}
    <div class="card login-card text-light">
        <div class="card-header text-light">
            <h2 class="display-5">Control de usuarios</h2>
        </div>
        {{-- Add --}}
        <a href="{{route('register')}}" class="btn text-light border-info m-3">Agregar</a>
        <div class="row align-items-center p-3 justify-content-center">
            {{-- Table --}}
            <div data-aos="fade-right" data-aos-delay="500" class="table-responsive text-light">
                <table id="table" class="table table-borderless align-middle text-light">
                    <caption>Tabla de usuarios</caption>
                    <thead class="text-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    <form action="{{route('users.update', ['user'=>$user->id])}}" method="post" id="form{{$user->id}}">
                                        @csrf
                                        @method('PUT')
                                        <select class="btn text-light bg-dark border-success @error('type') is-invalid @enderror" name="type" id="type{{$user->id}}" onchange="changeRole('{{$user->id}}')">
                                            <option {{ $user->type == "Admin"?"Selected":"" }} value="Admin">Admin</option>
                                            <option {{ $user->type == "QA"?"Selected":"" }} value="QA">QA</option>
                                            <option {{ $user->type == "Developer"?"Selected":"" }} value="Developer">Developer</option>
                                            <option {{ $user->type == "Outsourcing"?"Selected":"" }} value="Outsourcing">Outsourcing</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{route("users.destroy", ["user" => $user->id])}}" method="post" class="button-group"> 
                                        @csrf
                                        @method("DELETE")
                                        {{-- <a href="{{route("users.edit", ['user'=>$user->id])}}" class="btn btn-warning btn-sm">Editar</a> --}}
                                        <input class="btn btn-danger btn-sm" type="submit" value="Eliminar"> 
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        var table;
        $(document).ready( function () {
            $('#table').DataTable({
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
                }
            });
        } );

        function changeRole(id){
            var form = document.getElementById('form'+id);
            form.submit();
        }
    </script>
@endsection