@extends('layouts.adminhome')
@section('content')
    {{-- <h1 class="display-4 mb-5 text-center">QRM-Quality Assurance</h1> --}}
    
    {{-- Sección para control de modulos --}}
    <form action="{{route('functionalities.index')}}" method="get">
        @csrf
        <input type="hidden" name="id" value="{{$functionality->module->id}}">
        <input class="btn btn-info" type="submit" value="Volver a las funcionalidades">
    </form>
    <div class="card border-dark login-card">
        <div class="card-header text-light">
            <h2 data-aos="fade-right" data-aos-delay="500" class="display-5">Control de criterios de aceptación</h2>
        </div>
        <div class="row align-items-center p-3">
            <div style="max-width:300px!important; width:100%!important;" class="col-4">
                {{-- Add --}}
                <h3 data-aos="fade-left" data-aos-delay="500" class="display-6 text-light">Agregar</h3>
                <form data-aos="fade-up" data-aos-delay="800" id="add-criterion-form" action="{{route('criteria.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="functionalityId" value="{{$functionality->id}}">
                    <div class="mb-3">
                        <input class="form-control" type="text" name="scenary" id="scenary" placeholder="Ingrese el nombre del escenario de prueba">
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" name="description" id="description" placeholder="Comentarios o descripción del criterio"></textarea>
                    </div>
                    <div class="mb-3">
                      {{-- <label for="state" class="form-label">Estado</label> --}}
                      <select class="form-control" name="state" id="state">
                        <option>Seleccionar estado</option>
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
                        <input class="btn text-light border-success btn-sm" type="button" onclick="save_criterion()" value="Agregar">
                    </div>
                </form>
                {{-- Edit --}}
                <form id="edit-criterion-form" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <input class="form-control" type="text" name="scenary" id="scenary" placeholder="Ingrese el nombre del escenario de prueba">
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" name="description" id="description" placeholder="Comentarios o descripción del criterio"></textarea>
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
                        <input class="btn btn-warning btn-sm" type="button" onclick="edit_criterion()" value="Guardar cambios">
                        <input class="btn btn-dark btn-sm" type="button" onclick="setEditForm('', '', '', '', '')" value="Cancelar">
                    </div>
                </form>
            </div>
            <div class="col">
                <div data-aos="fade-up" data-aos-delay="1000" class="table-responsive text-light">
                    {{-- style="width:100%" --}}
                    <table style="width:90%" id="functionalityTable" class="table table-sm table-borderless align-middle text-light">
                        <caption>Tabla de criterios de aceptación</caption>
                        <thead class="text-light">
                            <tr>
                                <th>Escenario</th>
                                <th>Estado</th>
                                <th>Encargado</th>
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
        document.getElementById('edit-criterion-form').style.setProperty('display', 'none');
        $(document).ready( function () {
            // Obtenemos los registro y los ponemos en la tabla
            getAll({{$functionality->id}});
        } );
        function getAll(functionalityId){
            $.ajax({
                type: "POST",
                url: "{{route('criteria.all')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'functionalityId': functionalityId}, 
                dataType: "json",
                success: function (response) {
                    var rows = "";
                    var user;
                    var modal;
                    var checks;
                    for(let i = 0; i < response.length; i++){
                        usersId = [];
                        UsersData = '<ul class="list-group list-group-flush">';
                        user = response[i]["user"];
                        if(user.length == 0){
                            checks = '<p class="text-danger">Sin usuarios encargados ligados</p>'
                        }else{
                            for(let j = 0; j < user.length; j++){
                                // Armamos json de usuarios para el formulario de editado
                                usersId.push(user[j]['id']);
                                UsersData += '<li class="list-group-item">'+user[j]['name']+'('+user[j]['type']+')</li>';
                            }
                        }
                        UsersData += '</ul>';

                        if(response[i]["state"] == "Correcto"){
                                stateButton = '<td class="text-success"><span class="visually-hidden">Correcto</span><ion-icon size="large" name="checkmark-circle-outline"></ion-icon></td>'; 
                            }else{ 
                                if(response[i]["state"] == "Defectuoso"){
                                    stateButton = '<td class="text-danger"><span class="visually-hidden">Defectuoso</span><ion-icon size="large" name="close-circle-outline"></ion-icon></td>';
                                }else{
                                    if(response[i]["state"] == "Revisar"){
                                        stateButton = '<td class="text-warning"><span class="visually-hidden">Defectuoso</span><ion-icon size="large" name="bug-outline"></ion-icon></td>';
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
                                    '<td>'+response[i]["scenary"]+'</td>' +
                                        stateButton +
                                    '<td>'+modal+'</td>' +
                                    '<td>'+response[i]["description"]+'</td>' +
                                    '<td class="col-3">' +
                                        '<div class="d-flex w-100 btn-group" role="group" aria-label="Basic example">' +
                                            '<form action="{{route("attachments.index")}}" method="get">' +
                                                '@csrf' +
                                                '<input type="hidden" name="id" value="'+response[i]["id"]+'"/>' +
                                                '<button class="btn text-light border-info btn-sm position-relative px-3" type="submit">' +
                                                    'Adj.' +
                                                '</button>' +
                                            '</form>' +
                                            '<button type="button" class="btn text-light border-warning btn-sm" onclick="setEditForm(\'edit\', \''+response[i]["id"]+'\', \''+response[i]["scenary"]+'\', \''+response[i]["description"]+'\', \''+response[i]["state"]+'\', \''+usersId+'\')">' +
                                                'Editar' +
                                            '</button>' +
                                            '<form id="delete_form'+response[i]["id"]+'" action="{{route("criteria.destroy", ["criterion"=>'+response[i]["id"]+'])}}" method="post">' +
                                                '@method("DELETE")' +
                                                '<input type="hidden" name="id" value="'+response[i]["id"]+'">' +
                                                '<input class="btn text-light border-danger btn-sm" type="button" value="Eliminar" onclick="delete_criterion('+response[i]["id"]+')">' +
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
                            visible: false
                        } ]
                    });   
                }
            });
        }
        function save_criterion(){
            var htmlForm = document.getElementById('add-criterion-form');
            var form = new FormData(htmlForm);
            if($('#add-criterion-form #scenary').val() == '' || $('#add-criterion-form #description').val() == '' || $('#add-criterion-form #state').val() == ''){
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
                            getAll({{$functionality->id}});
                            htmlForm.reset();
                        }
                    }
                });
            }
        }
        function edit_criterion(){
            var htmlForm = document.getElementById('edit-criterion-form');
            var form = new FormData(htmlForm);
            // alert(form.get('module'));
            $.ajax({
                type: "POST",
                url: '/criteria/'+form.get('id'),
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
                        getAll({{$functionality->id}});
                        htmlForm.reset();
                        setEditForm('', '', '', '', '');
                    }
                }
            });
        }
        function delete_criterion(id){
            var htmlForm = document.getElementById('delete_form'+id);
            var form = new FormData(htmlForm);
            // alert(form.get('module'));
            $.ajax({
                type: "POST",
                url: '/criteria/'+form.get('id'),
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
                        getAll({{$functionality->id}});
                        htmlForm.reset();

                    }
                }
            });
        }
        function setEditForm(formTo, id, scenary, description, state, user){
            if(formTo == 'edit'){
                // Cambiamos visibilidad de formularios
                document.getElementById('add-criterion-form').style.setProperty('display', 'none');
                document.getElementById('edit-criterion-form').style.setProperty('display', 'block');
                
                //Seteamos los valores de los inputs 
                $('#edit-criterion-form #scenary').val(scenary);
                $('#edit-criterion-form #description').val(description);
                $('#edit-criterion-form #state').val(state);
                $('#edit-criterion-form #id').val(id);
                
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
                document.getElementById('edit-criterion-form').action = "/criteria/"+id;
            }else{
                // Cambiamos visibilidad de formularios
                document.getElementById('add-criterion-form').style.setProperty('display', 'block');
                document.getElementById('edit-criterion-form').style.setProperty('display', 'none');
                
                //Seteamos los valores de los inputs 
                $('#edit-criterion-form #name').val('');
                $('#edit-criterion-form #description').val('');
                $('#edit-criterion-form #state').val('');
                $('#edit-functionality-form #user_id').val('');
            }

        }

    </script>
@endsection