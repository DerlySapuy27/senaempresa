@extends('adminlte::page')

@section('content_header')
@include('head')

<h1 class="m-0 text-dark">Cargos SENA Empresa</h1>

@stop

@section('content')
    <!-- Boton de Agregar nueva estrategia sena empresa -->
    <div class="card" style="width: 90%; margin-left: 40px;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <!-- Botón para mostrar el modal de crear rol -->
            <button id="showCrearRolModalButton" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearRol">
                <i class="fas fa-folder-plus"></i> Agregar
            </button>
        </div>
        <!-- Lista de Roles -->
        <div class="card-body">
            <table id="datatable" class="table table-striped shadow-lg mt-4" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción del Cargo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->description }}</td>
                            <td>
                                <!-- Botones de Editar y eliminar -->
                                <div class="container text-center">
                                    <div class="row">
                                        <div class="col">
                                            <form method="POST" action="{{ route('rol.editar') }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" class="btn btn-primary" style="width: 70px;"
                                                    data-bs-toggle="modal" data-bs-target="#editarRol" onclick="editarRol({{ $role->id }})">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </form>
                                        </div>                                        
                                        <div class="col">
                                            <form id="deleteForm{{ $role->id }}"
                                                action="{{ route('roles.delete', ['role' => $role->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger" style="width: 70px;"
                                                    onclick="confirmDelete({{ $role->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Fin Botones de Editar y eliminar -->
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- Fin Lista de Roles -->
    </div><!-- cierre div tarjeta -->

    
<!-- Modal de Crear nuevo rol -->
    <div class="modal fade" id="crearRol" tabindex="-1" aria-labelledby="crearRolLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearRolLabel">Crear Nuevo Rol</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('rol.crearrol') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="rol_name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="rol_name" name="rol_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="rol_description" class="form-label">Descripción del Cargo</label>
                            <textarea class="form-control" id="rol_description" name="rol_description" required></textarea>
                        </div>
                        <center><button type="submit" class="btn btn-primary">Guardar</button></center>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
<!-- Fin Modal de Crear nuevo rol -->


<!-- Modal de Editar Rol -->
    <div class="modal fade" id="editarRol" tabindex="-1" aria-labelledby="editarRolLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarRolLabel">Editar Rol</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('rol.editar') }}" id="editarRolForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit_rol_name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit_rol_name" name="edit_rol_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_rol_description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="edit_rol_description" name="edit_rol_description" required></textarea>
                        </div>
                        <input type="hidden" id="edit_rol_id" name="edit_rol_id">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- Fin Modal de Editar Rol -->
@include('alerts')
@include('datatable-script')
@stop

<!-- Script del modal Crear cargo -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var crearRolModal = new bootstrap.Modal(document.getElementById('crearRol'));

        document.getElementById('showCrearRolModalButton').addEventListener('click', function() {
            crearRolModal.show();
        });

        /* Evento para cerrar el modal de crear rol */
        document.querySelector('#crearRol .modal-footer .btn-secondary').addEventListener('click',
            function() {
                crearRolModal.hide();
            });
    });
</script>

<!-- Script de editar rol -->
<script>
    function editarRol(rolId) {
        fetch(`/roles/${rolId}/detalle`)
            .then(response => response.json())
            .then(data => {
                // Llenar los campos del formulario con los datos obtenidos
                document.getElementById('edit_rol_id').value = data.id;
                document.getElementById('edit_rol_name').value = data.name;
                document.getElementById('edit_rol_description').value = data.description;

                // Abrir el modal
                var modal = new bootstrap.Modal(document.getElementById('editarRol'));
                modal.show();
            })
            .catch(error => console.error('Error:', error));
    }
</script>


