@extends('layouts.adminhome')
@section('content')
    {{-- <h1 class="display-4 mb-5 text-center">QRM-Quality Assurance</h1> --}}
    <a class="btn btn-info" href="{{route('modules.index')}}">Volver a lista de modulos</a>
    
    {{-- Sección para control de modulos --}}
    <div class="card login-card border-dark">
        <div class="card-header text-light">
            <h2 data-aos="fade-right" data-aos-delay="500" class="display-5">Control de funcionalidades</h2>
        </div>
        <div class="row align-items-center p-3">
            <div style="max-width:315px!important; width:100%!important;" class="col-3">
                {{-- Add --}}
                <h3 data-aos="fade-left" data-aos-delay="500" class="display-6 text-light">Agregar</h3>
                <form data-aos="fade-up" data-aos-delay="800" id="add-functionality-form" action="{{route('functionalities.store')}}" method="POST">
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
                    
                    <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Seleccionar encargados
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header bg-secondary text-light">
                                    <h5 class="modal-title" id="exampleModalLabel">Encargados del módulo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @foreach ($users as $user)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$user->id}}" id="user_id{{$user->id}}" name="user_id[]">
                                            <label class="form-check-label" for="user_id{{$user->id}}">
                                                {{$user->name}}  ({{$user->type}})
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="mb-3">
                        <input class="btn text-light border-success btn-sm" type="button" onclick="save_functionality()" value="Agregar módulo">
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
                        <option value="Revisar">Revisar</option>
                      </select>
                    </div>
                    
                    <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                        Seleccionar encargados
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header bg-secondary text-light">
                                    <h5 class="modal-title" id="exampleModalLabel">Encargados del módulo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <ul class="list-group list-group-flush" id="edit-form-users-list">
                                        
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <input class="btn btn-warning btn-sm" type="button" onclick="edit_functionality()" value="Guardar cambios">
                        <input class="btn btn-dark btn-sm" type="button" onclick="setFunctionalityForm('', '', '', '', '')" value="Cancelar">
                    </div>
                </form>
            </div>
            <div style="max-width:950px!important; width:100%!important;" class="col-9">
                <div data-aos="fade-up" data-aos-delay="1000" class="table-responsive text-light">
                    {{-- style="width:100%" --}}
                    <table id="functionalityTable" class="table table-sm table-borderless align-middle text-light">
                        <caption>Tabla de funcionalidades a testear</caption>
                        <thead class="text-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Encargado(s)</th>
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
                    var user;
                    var modal;
                    var checks;
                    if(response.length > 0){
                        for(let i = 0; i < response.length; i++){
                            usersId = [];
                            UsersData = '<ul class="list-group list-group-flush">';
                            user = response[i]["user"];
                            if(user.length == 0){
                                checks = '<p class="text-danger">Sin usuarios encargados ligados</p>'
                            }else{
                                for(let j = 0; j < user.length; j++){
                                    usersId.push(user[j]['id']);
                                    UsersData += '<li class="list-group-item">'+user[j]['name']+'('+user[j]['type']+')</li>';
                                }
                            }
                            UsersData += '</ul>';
                            if(response[i]["state"] == "Correcto"){
                                stateButton = '<td class="text-center p-2"><form action="{{route("criteria.index")}}" method="get"> @csrf <input type="hidden" name="id" value="'+response[i]["id"]+'"/> <button class="btn btn-success btn-sm position-relative" type="submit"><ion-icon name="checkmark-circle-outline"></ion-icon><span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-info">'+response[i]['percent']+'%</span></button></form></td>';
                                
                            }else{ 
                                if(response[i]["state"] == "Defectuoso"){
                                    stateButton = '<td class="text-center text-danger p-2"><form action="{{route("criteria.index")}}" method="get"> @csrf <input type="hidden" name="id" value="'+response[i]["id"]+'"/> <button class="btn btn-danger btn-sm shadow position-relative" type="submit"><ion-icon name="close-circle-outline"></ion-icon> <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-info">'+response[i]['percent']+'%</span> </button></form></td>';
                                }else{
                                    if(response[i]["state"] == "Revisar"){
                                        stateButton = '<td class="text-center text-danger p-2"><form action="{{route("criteria.index")}}" method="get"> @csrf <input type="hidden" name="id" value="'+response[i]["id"]+'"/> <button class="btn btn-warning btn-sm shadow position-relative" type="submit"><ion-icon name="bug-outline"></ion-icon> <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-info">'+response[i]['percent']+'%</span> </button></form></td>';
                                    }
                                }
                            }

                            modal = '<button type="button" class="btn text-light border-info btn-sm" data-bs-toggle="modal" data-bs-target="#modal'+i+'">Ver</button>'+
                                    '<div class="modal fade" id="modal'+i+'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
                                        '<div class="modal-dialog">'+
                                            '<div class="modal-content">'+
                                                '<div class="modal-header bg-secondary">'+
                                                    '<h5 class="modal-title" id="exampleModalLabel">Encargado(s)</h5>'+
                                                    '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>'+
                                                '</div>'+
                                                '<div class="modal-body text-center">'+
                                                    UsersData+
                                                '</div>'+
                                                '<div class="modal-footer">'+
                                                    '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>';
                            rows += '<tr class="text-light">' +
                                        '<td>'+response[i]["name"]+'</td>' +
                                            stateButton +
                                        '<td>'+modal+'</td>' +
                                        '<td>'+response[i]["description"]+'</td>' +
                                        '<td class="col-3">' +
                                            '<div class="d-flex w-100 btn-group" role="group" aria-label="Basic example">' +
                                                
                                                '<button type="button" class="btn text-light border-warning btn-sm" onclick="setFunctionalityForm(\'edit\', \''+response[i]["id"]+'\', \''+response[i]["name"]+'\', \''+response[i]["description"]+'\', \''+response[i]["state"]+'\', \''+usersId+'\')">' +
                                                    'Editar' +
                                                '</button>' +
                                                '<form id="delete_form'+response[i]["id"]+'" action="{{route("modules.destroy", ["module"=>'+response[i]["id"]+'])}}" method="post">' +
                                                    '@method("DELETE")' +
                                                    '<input type="hidden" name="id" value="'+response[i]["id"]+'">' +
                                                    '<input class="btn text-light border-danger btn-sm" type="button" value="Eliminar" onclick="delete_functionality('+response[i]["id"]+')">' +
                                                '</form>' +
                                            '</div>' +
                                        '</td>' +
                                    '</tr>';
                        }
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
        function setFunctionalityForm(formTo, id, name, description, state, user){
            if(formTo == 'edit'){
                // Cambiamos visibilidad de formularios
                document.getElementById('add-functionality-form').style.setProperty('display', 'none');
                document.getElementById('edit-functionality-form').style.setProperty('display', 'block');
                
                //Seteamos los valores de los inputs 
                $('#edit-functionality-form #name').val(name);
                $('#edit-functionality-form #description').val(description);
                $('#edit-functionality-form #state').val(state);
                $('#edit-functionality-form #id').val(id);
                
                // Proceso para llenar los select de usuarios
                var users = @json($users);
                var checks = '';
                var flag = false;
                for(let i = 0; i < users.length; i++){
                    for(let j = 0; j < user.length; j++){
                        if(users[i]['id'] == user[j]){
                            checks += '<div class="form-check">'+
                                        '<input class="form-check-input" type="checkbox" value="'+users[i]['id']+'" id="user_id'+users[i]['id']+'" name="user_id[]" checked>'+
                                        '<label class="form-check-label" for="user_id'+users[i]['id']+'">'+
                                            users[i]['name']+'('+users[i]['type']+')'+
                                        '</label>'+
                                    '</div>';
                                    j = user.length;
                                    flag = true;
                        }
                    }
                    if(flag == false){
                        checks += '<div class="form-check">'+
                                        '<input class="form-check-input" type="checkbox" value="'+users[i]['id']+'" id="user_id'+users[i]['id']+'" name="user_id[]">'+
                                        '<label class="form-check-label" for="user_id'+users[i]['id']+'">'+
                                            users[i]['name']+'('+users[i]['type']+')'+
                                        '</label>'+
                                    '</div>';
                    }else{
                        flag = false;
                    }
                }
                $('#edit-form-users-list').html(checks);
                $('#edit-functionality-form #user_id').val(user);
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
                $('#edit-functionality-form #user_id').val('');
    
            }

        }

    </script>
@endsection