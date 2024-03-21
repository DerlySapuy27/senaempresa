@extends('adminlte::page')

@section('content_header')
    @include('head')

    <h1 class="m-0 text-dark">Tecnólogos SENA Empresa</h1>

@stop

@section('content')
    <!-- Boton de Agregar nueva estrategia sena empresa -->
    <div class="card" style="width: 90%; margin-left: 40px;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <button id="showcrearTechnologistModalButton" class="btn btn-success" data-bs-toggle="modal"
                data-bs-target="#crearTechnologist">
                <i class="fas fa-folder-plus"></i> Agregar
            </button>
        </div>

        <!-- Lista de Technologists -->
        <div class="card-body">
            <table id="datatable" class="table table-striped shadow-lg mt-4" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre Tecnólogo</th>
                        <th>Número Ficha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($technologists as $technologist)
                        <tr>
                            <td>{{ $technologist->name }}</td>
                            <td>{{ $technologist->code }}</td>
                            <td>
                                <!-- Botones de Editar y eliminar -->
                                <div class="container text-center">
                                    <div class="row">
                                        <div class="col">
                                            <form method="POST" action="{{ route('technologist.editar') }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" class="btn btn-primary" style="width: 70px;"
                                                    data-bs-toggle="modal" data-bs-target="#editarTechnologist"
                                                    onclick="editarTechnologist({{ $technologist->id }})">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col">
                                            <form id="deleteForm{{ $technologist->id }}"
                                                action="{{ route('technologists.delete', ['technologist' => $technologist->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger" style="width: 70px;"
                                                    onclick="confirmDelete({{ $technologist->id }})">
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
        </div><!-- Fin Lista de Technologists -->
    </div>

    <!-- Modal de Crear Technologist -->
    <div class="modal fade" id="crearTechnologist" tabindex="-1" aria-labelledby="crearTechnologistLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearTechnologistLabel">Crear Technologist</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('technologist.crear') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="create_name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="create_name" name="create_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="create_code" class="form-label">Código</label>
                            <input type="number" class="form-control" id="create_code" name="create_code" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal de Crear Technologist -->

    <!-- Modal de Editar Technologist -->
    <div class="modal fade" id="editarTechnologist" tabindex="-1" aria-labelledby="editarTechnologistLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarTechnologistLabel">Editar Technologist</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('technologist.editar') }}" id="editarTechnologistForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit_name" name="edit_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_code" class="form-label">Código</label>
                            <input type="text" class="form-control" id="edit_code" name="edit_code" required>
                        </div>
                        <input type="hidden" id="edit_technologist_id" name="edit_technologist_id">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal de Editar Technologist -->

    @include('alerts')
    @include('datatable-script')
@stop

<!-- Script Agregar -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var crearTechnologistModal = new bootstrap.Modal(document.getElementById('crearTechnologist'));

        document.getElementById('showcrearTechnologistModalButton').addEventListener('click', function() {
            crearTechnologistModal.show();
        });

        // Agrega eventos necesarios o personalizados según tus necesidades
    });
</script>

<!-- Script editar -->
<script>
    function editarTechnologist(technologistId) {
        // Llamar a tu controlador o endpoint para obtener los datos del registro
        // Puedes utilizar Axios, Fetch u otra librería para hacer la petición AJAX
        // Aquí se utiliza Fetch como ejemplo

        fetch(`/technologist/${technologistId}/detalle`)
            .then(response => response.json())
            .then(data => {
                // Llenar los campos del formulario con los datos obtenidos
                document.getElementById('edit_technologist_id').value = data.id;
                document.getElementById('edit_name').value = data.name;
                document.getElementById('edit_code').value = data.code;

                // Abrir el modal
                var modal = new bootstrap.Modal(document.getElementById('editarTechnologist'));
                modal.show();
            })
            .catch(error => console.error('Error:', error));
    }
</script>

