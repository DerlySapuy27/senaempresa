@extends('adminlte::page')

@section('content_header')
    @include('head')

    <h1 class="m-0 text-dark">Estrategia SENA Empresa</h1>

@stop

@section('content')
    <!-- Boton de Agregar nueva estrategia sena empresa -->
    <div class="card" style="width: 90%; margin-left: 40px;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <button id="showcrearSenaempresaModalButton" class="btn btn-success" data-bs-toggle="modal"
                data-bs-target="#crearSenaempresa">
                <i class="fas fa-folder-plus"></i> Agregar
            </button>
        </div>

        <!-- Lista de Senaempresas -->
        <div class="card-body">
            <table id="datatable" class="table table-striped shadow-lg mt-4" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Ubicación</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Fin</th>
                        <th>Instructor Lider</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($senaempresas as $senaempresa)
                        <tr>
                            <td>{{ $senaempresa->name }}</td>
                            <td>{{ $senaempresa->location }}</td>
                            <td>{{ $senaempresa->start_date }}</td>
                            <td>{{ $senaempresa->end_date }}</td>
                            <td>{{ $senaempresa->instructor->name }} {{ $senaempresa->instructor->last_name }}</td>
                            <td>
                                <!-- Botones de Editar y eliminar -->
                                <div class="container text-center">
                                    <div class="row">
                                        <div class="col">
                                            <form method="POST"
                                                action="{{ route('senaempresa.editar', ['id' => $senaempresa->id]) }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" class="btn btn-primary" style="width: 70px;"
                                                    data-bs-toggle="modal" data-bs-target="#editarSenaempresa"
                                                    onclick="editarSenaempresa({{ $senaempresa->id }})">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col">
                                            <form id="deleteForm{{ $senaempresa->id }}"
                                                action="{{ route('senaempresa.delete', ['senaempresa' => $senaempresa->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger" style="width: 70px;"
                                                    onclick="confirmDelete({{ $senaempresa->id }})">
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
        </div>
        <!-- Fin Lista de Senaempresas -->
    </div>

    <!-- Modal de Crear nuevo Senaempresa -->
    <div class="modal fade" id="crearSenaempresa" tabindex="-1" aria-labelledby="crearSenaempresaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearSenaempresaLabel">Agregar nuevo Senaempresa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('senaempresa.crearsenaempresa') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Fecha de inicio</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Fecha de finalización</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="instructor_id" class="form-label">Instructor</label>
                            <select class="form-select" id="instructor_id" name="instructor_id" required>
                                <option value="" disabled selected>Seleccione el instructor líder</option>
                                @foreach ($instructors as $instructor)
                                    <option value="{{ $instructor->id }}">{{ $instructor->name }}
                                        {{ $instructor->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal de Crear nuevo Senaempresa -->

    <!-- Modal de Editar Senaempresa -->
    <div class="modal fade" id="editarSenaempresa" tabindex="-1" aria-labelledby="editarSenaempresaLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarSenaempresaLabel">Editar Senaempresa</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('senaempresa.editar') }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit_name" name="edit_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_location" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" id="edit_location" name="edit_location" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_start_date" class="form-label">Fecha de inicio</label>
                            <input type="date" class="form-control" id="edit_start_date" name="edit_start_date"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_end_date" class="form-label">Fecha de finalización</label>
                            <input type="date" class="form-control" id="edit_end_date" name="edit_end_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_instructor_id" class="form-label">Instructor</label>
                            <select class="form-select" id="edit_instructor_id" name="edit_instructor_id" required>
                                @foreach ($instructors as $instructor)
                                    <option value="{{ $instructor->id }}">{{ $instructor->name }}
                                        {{ $instructor->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" id="edit_senaempresa_id" name="edit_senaempresa_id">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal de Editar Senaempresa -->







    @include('alerts')
    @include('datatable-script')
@stop

<!-- Script de crear nueva estrategia sena empresa -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var crearSenaempresaModal = new bootstrap.Modal(document.getElementById('crearSenaempresa'));

        document.getElementById('showcrearSenaempresaModalButton').addEventListener('click', function() {
            crearSenaempresaModal.show();
        });

    });
</script>

<!-- Script de editar estrategia sena empresa -->
<script>
    function editarSenaempresa(senaempresaId) {
        // Llamar a tu controlador o endpoint para obtener los datos del registro
        // Puedes utilizar Axios, Fetch u otra librería para hacer la petición AJAX
        // Aquí se utiliza Fetch como ejemplo

        fetch(`/senaempresa/${senaempresaId}/detalle`)
            .then(response => response.json())
            .then(data => {
                // Llenar los campos del formulario con los datos obtenidos
                document.getElementById('edit_senaempresa_id').value = data.id;
                document.getElementById('edit_name').value = data.name;
                document.getElementById('edit_location').value = data.location;
                document.getElementById('edit_start_date').value = data.start_date;
                document.getElementById('edit_end_date').value = data.end_date;
                document.getElementById('edit_instructor_id').value = data.instructor_id;

                // Abrir el modal
                var modal = new bootstrap.Modal(document.getElementById('editarSenaempresa'));
                modal.show();
            })
            .catch(error => console.error('Error:', error));
    }
</script>
