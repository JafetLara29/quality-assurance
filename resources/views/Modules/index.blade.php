@extends('layouts.adminhome')
@section('content')
    {{-- <h1 class="display-4 mb-5 text-center">QRM-Quality Assurance</h1> --}}
    
    {{-- Sección para control de modulos --}}
    <div class="card login-card text-light">
        <div class="card-header text-light">
            <h2 class="display-5">Control de módulos</h2>
        </div>
        <div class="row align-items-center p-3">
            <div style="max-width:300px!important; width:100%!important;" class="col-2">
                {{-- Add --}}
                <h3 class="display-6">Agregar</h3>
                <form id="add-module-form" action="{{route('modules.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input class="form-control" type="text" name="module" id="module" placeholder="Ingrese el nombre del módulo">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="text" name="author" id="author" placeholder="Ingrese el nombre del encargado">
                    </div>
                    <div class="mb-3">
                        <input class="btn btn-success btn-sm" type="button" onclick="save_module()" value="Agregar módulo">
                    </div>
                </form>
                {{-- Edit --}}
                <form id="edit-module-form" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input class="form-control" type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <input class="form-control" type="text" name="module" id="module" placeholder="Ingrese el nombre del módulo">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="text" name="author" id="author" placeholder="Ingrese el nombre del encargado">
                    </div>
                    <div class="mb-3">
                        <input class="btn btn-warning btn-sm" type="button" onclick="edit_module()" value="Guardar cambios">
                        <input class="btn btn-secondary btn-sm" type="button" onclick="setModuleForm()" value="Cancelar">
                    </div>
                </form>
            </div>
            {{-- Table --}}
            <div class="col">
                <div class="table-responsive text-light">
                    {{-- style="width:100%" --}}
                    <table style="width:100%" id="modulesTable" class="table table-sm table-hover table-borderless table-primary align-middle">
                        <caption>Tabla de modulos a testear</caption>
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Encargado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($Modules as $module) --}}
                                
                            {{-- @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        var table;
        // Al levantar la vista ocultamos el form de editar
        document.getElementById('edit-module-form').style.setProperty('display', 'none');
        $(document).ready( function () {
            // Obtenemos los registro y los ponemos en la tabla
            getAllModules();

            $('#functionalitiesTable').DataTable({
                dom: 'Bfrtip',
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
                buttons: [
                    // 'copy',
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    // 'excel',
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    // 'pdf',
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    // 'print',
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'colvis',
                ],
                columnDefs: [ {
                    // targets: -1,
                    visible: false,
                } ]
            });
        } );
        function getAllModules(){
            $.ajax({
                type: "POST",
                url: "{{route('modules.all')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: '', 
                dataType: "json",
                success: function (response) {
                    var rows = "";
                    for(let i = 0; i < response.length; i++){
                        rows += '<tr class="table-info">' +
                                    '<td>'+response[i]["module"]+'</td>' +
                                    '<td>'+response[i]["author"]+'</td>' +
                                    '<td class="col-3">' +
                                        '<div class="d-flex w-100 btn-group" role="group" aria-label="Basic example">' +
                                            '<form action="{{route("functionalities.index")}}" method="get">' +
                                                '@csrf' +
                                                '<input type="hidden" name="id" value="'+response[i]["id"]+'"/>' +
                                                '<button class="btn btn-info btn-sm position-relative px-3" type="submit">' +
                                                    'Ver' +
                                                    '<span class="position-absolute top-50 start-0 translate-middle badge rounded-pill bg-danger">' +
                                                        response[i]['functionalities_count'] +
                                                    '</span>' +
                                                '</button>' +
                                            '</form>' +
                                            '<button type="button" class="btn btn-warning btn-sm" onclick="setModuleForm(\'edit\', \''+response[i]["id"]+'\', \''+response[i]["module"]+'\', \''+response[i]["author"]+'\')">' +
                                                'Editar' +
                                            '</button>' +
                                            '<form id="delete_form'+response[i]["id"]+'" action="{{route("modules.destroy", ["module"=>'+response[i]["id"]+'])}}" method="post">' +
                                                '@method("DELETE")' +
                                                '<input type="hidden" name="id" value="'+response[i]["id"]+'">' +
                                                '<input class="btn btn-danger btn-sm" type="button" value="Eliminar" onclick="delete_module('+response[i]["id"]+')">' +
                                            '</form>' +
                                        '</div>' +
                                    '</td>' +
                                '</tr>';
                    }
                    $('#modulesTable tbody').html(rows);
                    table = $('#modulesTable').DataTable({
                        dom: 'Bfrtip',
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
                        buttons: [
                            // 'copy',
                            {
                                extend: 'copy',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            // 'excel',
                            {
                                extend: 'excel',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            // 'pdf',
                            {
                                extend: 'pdf',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            // 'print',
                            {
                                extend: 'print',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            'colvis',
                        ],
                        columnDefs: [ {
                            targets: -1,
                            visible: false
                        } ]
                    });   
                }
            });
        }
        function save_module(){
            var htmlForm = document.getElementById('add-module-form');
            var form = new FormData(htmlForm);
            if($('#module').val() == '' || $('#author').val() == ''){
                Toastify({
                    text: "Ha ocurrido un error al procesar la petición. Asegurese de llenar toda la información requerida",
                    duration: 5000,
                    gravity: "top",
                    position: "center",
                    style: {
                        background: "linear-gradient(to right, green, greenyellow)",
                    },

                }).showToast();
            }else{
                $.ajax({
                    type: "POST",
                    url: htmlForm.action,
                    data: form,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: "json",
                    success: function (response) {
                        if(response['message'] == 'success'){
                            Toastify({
                                text: "Registro exitoso",
                                duration: 5000,
                                gravity: "top",
                                position: "center",
                                style: {
                                    background: "linear-gradient(to right, green, greenyellow)",
                                },
    
                            }).showToast();
                            table.destroy();
                            getAllModules();
                            htmlForm.reset();
                        }else{
                            
                        }
                    }
                });
            }
        }
        function edit_module(){
            var htmlForm = document.getElementById('edit-module-form');
            var form = new FormData(htmlForm);
            // alert(form.get('module'));
            $.ajax({
                type: "POST",
                url: '/modules/'+form.get('id'),
                data: form,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: "json",
                success: function (response) {
                    if(response['message'] == 'success'){
                        Toastify({
                            text: "Cambios guardados",
                            duration: 5000,
                            gravity: "top",
                            position: "center",
                            style: {
                                background: "linear-gradient(to right, green, greenyellow)",
                            },

                        }).showToast();
                        table.destroy();
                        getAllModules();
                        htmlForm.reset();
                        setModuleForm();
                    }
                }
            });
        }
        function delete_module(id){
            var htmlForm = document.getElementById('delete_form'+id);
            var form = new FormData(htmlForm);
            // alert(form.get('module'));
            $.ajax({
                type: "POST",
                url: '/modules/'+form.get('id'),
                data: form,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: "json",
                success: function (response) {
                    if(response['message'] == 'success'){
                        Toastify({
                            text: "Se eliminó el registro exitosamente",
                            duration: 5000,
                            gravity: "top",
                            position: "center",
                            style: {
                                background: "linear-gradient(to right, green, greenyellow)",
                            },

                        }).showToast();
                        table.destroy();
                        getAllModules();
                        htmlForm.reset();

                    }
                }
            });
        }
        function setModuleForm(formTo, id, module, author){
            if(formTo == 'edit'){
                // Cambiamos visibilidad de formularios
                document.getElementById('add-module-form').style.setProperty('display', 'none');
                document.getElementById('edit-module-form').style.setProperty('display', 'block');
                
                //Seteamos los valores de los inputs 
                $('#edit-module-form #module').val(module);
                $('#edit-module-form #author').val(author);
                $('#edit-module-form #id').val(id);
    
                // Activamos el action para enviarlo con el id correspondiente
                document.getElementById('edit-module-form').action = "/modules/"+id;
            }else{
                // Cambiamos visibilidad de formularios
                document.getElementById('add-module-form').style.setProperty('display', 'block');
                document.getElementById('edit-module-form').style.setProperty('display', 'none');
                
                //Seteamos los valores de los inputs 
                $('#edit-module-form #module').val('');
                $('#edit-module-form #author').val('');
    
            }

        }

    </script>
@endsection