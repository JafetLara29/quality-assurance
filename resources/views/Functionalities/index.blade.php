@extends('layouts.adminhome')
@section('content')
    {{-- <h1 class="display-4 mb-5 text-center">QRM-Quality Assurance</h1> --}}
    <a class="btn btn-info text-light" href="{{route('modules.index')}}">Volver a lista de modulos</a>
    
    {{-- Sección para control de modulos --}}
    <div class="card login-card border-dark">
        <div class="card-header text-light">
            <h2 class="display-5">Control de funcionalidades</h2>
        </div>
        <div class="row align-items-center p-3">
            <div style="max-width:315px!important; width:100%!important;" class="col-3">
                {{-- Add --}}
                <h3 class="display-6 text-light">Agregar</h3>
                <form id="add-functionality-form" action="{{route('functionalities.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="moduleId" value="{{$module->id}}">
                    <div class="mb-3">
                        <input class="form-control" type="text" name="name" id="name" placeholder="Ingrese el nombre de la funcionalidad">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="text" name="description" id="description" placeholder="Comentarios">
                    </div>
                    <div class="mb-3">
                      {{-- <label for="state" class="form-label">Estado</label> --}}
                      <select class="form-control" name="state" id="state">
                        <option value="Seleccionar">Seleccionar estado</option>
                        <option value="Correcto">Correcto</option>
                        <option value="Defectuoso">Defectuoso</option>
                      </select>
                    </div>
                    <div class="mb-3">
                        <input class="btn btn-success btn-sm" type="button" onclick="save_functionality()" value="Agregar módulo">
                    </div>
                </form>
                {{-- Edit --}}
                <form id="edit-functionality-form" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input class="form-control" type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <input class="form-control" type="text" name="name" id="name" placeholder="Ingrese el nombre de la funcionalidad">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="text" name="description" id="description" placeholder="Comentarios">
                    </div>
                    <div class="mb-3">
                      {{-- <label for="state" class="form-label">Estado</label> --}}
                      <select class="form-control" name="state" id="state">
                        <option>Seleccionar estado</option>
                        <option value="Correcto">Correcto</option>
                        <option value="Defectuoso">Defectuoso</option>
                      </select>
                    </div>
                    <div class="mb-3">
                        <input class="btn btn-warning btn-sm" type="button" onclick="edit_functionality()" value="Guardar cambios">
                        <input class="btn btn-dark btn-sm" type="button" onclick="setFunctionalityForm('', '', '', '', '')" value="Cancelar">
                    </div>
                </form>
            </div>
            <div style="max-width:950px!important; width:100%!important;" class="col-9">
                <div class="table-responsive text-light">
                    {{-- style="width:100%" --}}
                    <table id="functionalityTable" class="table table-sm table-hover table-borderless table-primary align-middle">
                        <caption>Tabla de funcionalidades a testear</caption>
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Comentarios</th>
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
        document.getElementById('edit-functionality-form').style.setProperty('display', 'none');
        $(document).ready( function () {
            // Obtenemos los registro y los ponemos en la tabla
            getAllFuntionalities({{$module->id}});
        } );
        function getAllFuntionalities(moduleId){
            $.ajax({
                type: "POST",
                url: "{{route('functionalities.all')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'moduleId': moduleId}, 
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    var rows = "";
                    
                    for(let i = 0; i < response.length; i++){
                        rows += '<tr class="table-info">' +
                                    '<td>'+response[i]["name"]+'</td>' +
                                        ((response[i]["state"] == "Correcto") ? '<td class="text-center p-2"><form action="{{route("criteria.index")}}" method="get"> @csrf <input type="hidden" name="id" value="'+response[i]["id"]+'"/> <button class="btn btn-success btn-sm position-relative" type="submit"><ion-icon name="checkmark-circle-outline"></ion-icon><span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-info">'+response[i]['percent']+'%</span></button></form></td>' : '<td class="text-center text-danger p-2"><form action="{{route("criteria.index")}}" method="get"> @csrf <input type="hidden" name="id" value="'+response[i]["id"]+'"/> <button class="btn btn-danger btn-sm shadow position-relative" type="submit"><ion-icon name="close-circle-outline"></ion-icon> <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-info">'+response[i]['percent']+'%</span> </button></form></td>') +
                                    '<td>'+response[i]["description"]+'</td>' +
                                    '<td class="col-3">' +
                                        '<div class="d-flex w-100 btn-group" role="group" aria-label="Basic example">' +
                                            
                                            '<button type="button" class="btn btn-warning btn-sm" onclick="setFunctionalityForm(\'edit\', \''+response[i]["id"]+'\', \''+response[i]["name"]+'\', \''+response[i]["description"]+'\', \''+response[i]["state"]+'\')">' +
                                                'Editar' +
                                            '</button>' +
                                            '<form id="delete_form'+response[i]["id"]+'" action="{{route("modules.destroy", ["module"=>'+response[i]["id"]+'])}}" method="post">' +
                                                '@method("DELETE")' +
                                                '<input type="hidden" name="id" value="'+response[i]["id"]+'">' +
                                                '<input class="btn btn-danger btn-sm" type="button" value="Eliminar" onclick="delete_functionality('+response[i]["id"]+')">' +
                                            '</form>' +
                                        '</div>' +
                                    '</td>' +
                                '</tr>';
                    }
                    $('#functionalityTable tbody').html(rows);
                    table = $('#functionalityTable').DataTable({
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
                }
            });
        }
        function save_functionality(){
            var htmlForm = document.getElementById('add-functionality-form');
            var form = new FormData(htmlForm);
            if($('#name').val() == '' || $('#description').val() == '' || $('#state').val() == 'Seleccionar'){
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
                            getAllFuntionalities({{$module->id}});
                            htmlForm.reset();
                        }else{
                            alert('Ha ocurrido un error al registrar la funcionalidad');
                        }
                    }
                });
            }
        }
        function edit_functionality(){
            var htmlForm = document.getElementById('edit-functionality-form');
            var form = new FormData(htmlForm);
            // alert(form.get('module'));
            $.ajax({
                type: "POST",
                url: '/functionalities/'+form.get('id'),
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
                        getAllFuntionalities({{$module->id}});
                        htmlForm.reset();
                        setFunctionalityForm('', '', '', '', '');
                    }
                }
            });
        }
        function delete_functionality(id){
            var htmlForm = document.getElementById('delete_form'+id);
            var form = new FormData(htmlForm);
            // alert(form.get('module'));
            $.ajax({
                type: "POST",
                url: '/functionalities/'+form.get('id'),
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
                        getAllFuntionalities({{$module->id}});
                        htmlForm.reset();

                    }
                }
            });
        }
        function setFunctionalityForm(formTo, id, name, description, state){
            if(formTo == 'edit'){
                // Cambiamos visibilidad de formularios
                document.getElementById('add-functionality-form').style.setProperty('display', 'none');
                document.getElementById('edit-functionality-form').style.setProperty('display', 'block');
                
                //Seteamos los valores de los inputs 
                $('#edit-functionality-form #name').val(name);
                $('#edit-functionality-form #description').val(description);
                $('#edit-functionality-form #state').val(state);
                $('#edit-functionality-form #id').val(id);
    
                // Activamos el action para enviarlo con el id correspondiente
                document.getElementById('edit-functionality-form').action = "/functionalities/"+id;
            }else{
                // Cambiamos visibilidad de formularios
                document.getElementById('add-functionality-form').style.setProperty('display', 'block');
                document.getElementById('edit-functionality-form').style.setProperty('display', 'none');
                
                //Seteamos los valores de los inputs 
                $('#edit-functionality-form #name').val('');
                $('#edit-functionality-form #description').val('');
                $('#edit-functionality-form #state').val('');
    
            }

        }

    </script>
@endsection