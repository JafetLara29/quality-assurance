@extends('layouts.adminhome')
@section('content')
    {{-- <h1 class="display-4 mb-5 text-center">QRM-Quality Assurance</h1> --}}
    
    {{-- Sección para control de modulos --}}
    <form action="{{route('criteria.index')}}" method="get">
        @csrf
        <input type="hidden" name="id" value="{{$criterion->functionality->id}}">
        <input class="btn btn-info text-light" type="submit" value="Volver a los criterios">
    </form>
    <div class="card border-dark login-card">
        <div class="card-header text-light">
            <h2 class="display-5">Adjuntos</h2>
        </div>
        <div class="row align-items-center p-2">
            <div style="max-width:350px!important; width:100%!important;" class="col-2">
                {{-- Add --}}
                <h3 class="display-6 text-light">Agregar</h3>
                <form id="add-attachment-form" action="{{route('attachments.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="criterionId" value="{{$criterion->id}}">
                    <div class="mb-3">
                        <p class="text-light">Seleccione la imagen que desea registrar</p>
                        <input class="form-control" type="file" name="image" id="image">
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" name="description" id="description" placeholder="Ingrese una descripción"></textarea>
                    </div>
                    {{-- <div class="mb-3">
                        <input class="form-control" type="text" name="description" id="description" placeholder="Ingrese la descripción">
                    </div> --}}
                    {{-- <div class="mb-3">
                      <select class="form-control" name="state" id="state">
                        <option>Seleccionar estado</option>
                        <option value="Correcto">Correcto</option>
                        <option value="Defectuoso">Defectuoso</option>
                      </select>
                    </div> --}}
                    <div class="mb-3">
                        <input class="btn btn-success btn-sm" id="button-submit" type="submit" value="Agregar" disabled="disabled">
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
                        <input class="form-control" type="text" name="description" id="description" placeholder="Ingrese la descripción">
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
            <div class="col">
                <div class="table-responsive text-light">
                    <table id="attachmentTable" class="table table-sm table-hover table-borderless table-primary align-middle">
                        <caption>Tabla de adjuntos de el criterio de aceptación</caption>
                        <thead class="table-light">
                            <tr>
                                <th>Archivo</th>
                                {{-- <th>Tipo</th> --}}
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attachments as $attachment)
                            <tr class="table-info">
                                {{-- <td><img src="{{asset($attachment->image)}}" width="50" height="50"/></td> --}}
                                <td><a class="btn btn-success btn-sm" href="{{asset($attachment->image)}}" target="_blank">Ver</a></td>
                                
                                {{-- <td>{{$attachment->type}}</td> --}}
                                <td>{{$attachment->description}}</td>
                                <td class="col-3">
                                    <div class="d-flex w-100 btn-group" role="group" aria-label="Basic example">
                                        {{-- <button type="button" class="btn btn-warning btn-sm">
                                            Editar
                                        </button> --}}
                                        <form id="delete_form" action="{{route('attachments.destroy', ['attachment' => $attachment->id])}}" method="post">
                                            @method("DELETE")
                                            @csrf
                                            <input type="hidden" name="id" value="{{$attachment->id}}">
                                            <input class="btn btn-danger btn-sm" type="submit" value="Eliminar">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
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
            table = $('#attachmentTable').DataTable({
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
            $("#image").change(function(){
                $("#button-submit").prop("disabled", this.files.length == 0);
            });
        });
        function getAll(functionalityId){
            $.ajax({
                type: "POST",
                url: "{{route('attachments.all')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'functionalityId': functionalityId}, 
                dataType: "json",
                success: function (response) {
                    var rows = "";
                    
                    for(let i = 0; i < response.length; i++){
                        
                        rows += '<tr class="table-info">' +
                                    // '<td>'+response[i]["image"]+'</td>' +
                                    (response[i]["image"]).includes('image') == true ? '<td><img src="asset('+response[i]["image"]+')"/></td>' : '<td><a href="asset('+response[i]["image"]+'">Ver PDF</a></td>' +
                                    '<td>'+response[i]["type"]+'</td>' +
                                    '<td class="col-3">' +
                                        '<div class="d-flex w-100 btn-group" role="group" aria-label="Basic example">' +
                                            // '<a class="btn btn-info btn-sm" href="{{route("functionalities.all")}}">Ver</a>' +
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
                    $('#attachmentTable tbody').html(rows);
                    table = $('#attachmentTable').DataTable({
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
                            'copy',
                            'excel',
                            'pdf',
                            'print'
                        ]
                    });   
                }
            });
        }
        function save_attachment(){
            var htmlForm = document.getElementById('add-attachment-form');
            var form = new FormData(htmlForm);
            if($('#description').val == ''){
                Toastify({
                    text: "Debe ingresar una descripción",
                    duration: 5000,
                    gravity: "top",
                    position: "center",
                    style: {
                        background: "linear-gradient(to right, green, greenyellow)",
                    },

                }).showToast();
            }
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
                        getAll({{$criterion->id}});
                        htmlForm.reset();
                    }else{
                        Toastify({
                            text: "Ha ocurrido un erro al procesar la solicitud. Asegurate de ingresar todo lo necesario para el formulario",
                            duration: 5000,
                            gravity: "top",
                            position: "center",
                            style: {
                                background: "linear-gradient(to right, gray, greenyellow)",
                            },

                        }).showToast();
                        table.destroy();
                        getAll({{$criterion->id}});
                        htmlForm.reset();
                    }
                }
            });
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
                        // alert('Cambios guardados exitosamente');
                        table.destroy();
                        getAll({{$criterion->id}});
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
                        getAll({{$criterion->id}});
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