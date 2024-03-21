@extends('adminlte::page')

@section('content_header')
    @include('head')

    <h1 class="m-0 text-dark"> Instructor Lider SenaEmpresa</h1>

@stop

@section('content')

    <!-- Boton de Agregar nuevo Instructor -->
<div class="card" style="width: 90%; margin-left: 40px;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <button id="showcrearInstructorModalButton" class="btn btn-success" data-bs-toggle="modal"
            data-bs-target="#crearInstructor">
            <i class="fas fa-folder-plus"></i> Agregar
        </button>
    </div>
    <!-- Lista de Instructores -->
    <div class="card-body">
        <table id="datatable" class="table table-striped shadow-lg mt-4" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Ocupación</th>
                    <th>Posición</th>
                    <th># Documento</th>
                    <th>Firma</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($instructors as $instructor)
                    <tr>
                        <td>{{ $instructor->name }}</td>
                        <td>{{ $instructor->last_name }}</td>
                        <td>{{ $instructor->ocupation }}</td>
                        <td>{{ $instructor->position }}</td>
                        <td>{{ $instructor->document_number }}</td>
                        <td>
                            @if ($instructor->signature)
                                <!-- Muestra la firma si está presente -->
                                <img src="{{ asset('storage/' . $instructor->signature) }}" alt="Firma"
                                    style="max-width: 100px; max-height: 100px;">
                            @else
                                Sin firma
                            @endif
                        </td>
                        <td>
                            <!-- Botones de Editar y eliminar -->
                            <div class="container text-center">
                                <div class="row">
                                    <div class="col">
                                        <form method="POST"
                                            action="{{ route('instructor.update', ['id' => $instructor->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" class="btn btn-primary" style="width: 70px;"
                                                data-bs-toggle="modal" data-bs-target="#editarInstructorModal"
                                                onclick="editarInstructor({{ $instructor->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col">
                                        <form id="deleteForm{{ $instructor->id }}"
                                            action="{{ route('instructor.delete', ['instructor' => $instructor->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger" style="width: 70px;"
                                                onclick="confirmDelete({{ $instructor->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Botones de Editar y eliminar -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Fin Lista de Instructores -->
</div>


    <!-- Modal de Crear nuevo instructor -->
    <div class="modal fade" id="crearInstructor" tabindex="-1" aria-labelledby="crearInstructorLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearInstructorLabel">Crear Nuevo Instructor</h5>
                </div>
                <div class="modal-body">
                    <!-- Formulario para crear un nuevo instructor -->
                    <form method="POST" action="{{ route('instructor.crearinstructor') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name"
                                style="text-transform: uppercase;" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="last_name" name="last_name"
                                style="text-transform: uppercase;" required>
                        </div>
                        <!-- Campo para la ocupación -->
                        <div class="mb-3">
                            <label for="ocupation" class="form-label">Ocupación</label>
                            <input type="text" class="form-control" id="ocupation" name="ocupation" required
                                placeholder="Instructor SENA">
                        </div>
                        <!-- Campo para la posición -->
                        <div class="mb-3">
                            <label for="position" class="form-label">Posición</label>
                            <input type="text" class="form-control" id="position" name="position" required
                                placeholder="Líder Estrategia SENA Empresa">
                        </div>
                        <!-- Campo para el tipo de documento -->
                        <div class="mb-3">
                            <label for="document_type" class="form-label">Tipo de Documento</label>
                            <select class="form-select" id="document_type" name="document_type" required>
                                <option value="C.C">Cédula de Ciudadanía</option>
                                <option value="T.I">Tarjeta de Identidad</option>
                            </select>
                        </div>
                        <!-- Campo para el número de documento -->
                        <div class="mb-3">
                            <label for="document_number" class="form-label">Número de Documento</label>
                            <input type="number" class="form-control" id="document_number" name="document_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="expedition_place" class="form-label">Lugar de Expedicion</label>
                            <input type="text" class="form-control" id="expedition_place" name="expedition_place"
                                required placeholder="Bogotá">
                        </div>
                        <!-- Campo para el número de teléfono -->
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Número de Teléfono</label>
                            <input type="number" class="form-control" id="phone_number" name="phone_number" required>
                        </div>
                        <!-- Campo para la firma -->
                        <div class="mb-3">
                            <label for="signature" class="form-label">Seleccione una firma</label>
                            <div class="input-group">
                                <input type="file" class="form-control" id="signature" name="signature"
                                    onchange="previewSignature(this)">
                            </div>
                            <hr>
                            <div id="signaturePreviewContainer" class="signature-preview-container mt-2">
                                <img id="signaturePreview" src="" alt="Firma previa"
                                    style="max-width: 80%; max-height: 100px; display: block; margin: auto;">
                            </div>
                        </div>
                        <hr>
                        <!-- Botón para guardar el instructor -->
                        <center><button type="submit" class="btn btn-primary">Guardar</button></center>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal de Crear nuevo instructor -->

    <!-- Modal de Editar Instructor -->
    <div class="modal fade" id="editarInstructorModal" tabindex="-1" aria-labelledby="editarInstructorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarInstructorModalLabel">Editar Instructor</h5>
                </div>
                <div class="modal-body">
                    @isset($instructor)
                        <form method="POST" id="editarInstructorForm"
                            action="{{ route('instructor.update', ['id' => $instructor->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="edit_id" name="id">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Nombre del Instructor</label>
                                <input type="text" class="form-control" id="edit_name" name="name"
                                    style="text-transform: uppercase;" required>
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    value="{{ $instructor->last_name }}" style="text-transform: uppercase;" required>
                            </div>
                            <div class="mb-3">
                                <label for="ocupation" class="form-label">Ocupación</label>
                                <input type="text" class="form-control" id="ocupation" name="ocupation"
                                    value="{{ $instructor->ocupation }}" required placeholder="Instructor SENA">
                            </div>
                            <div class="mb-3">
                                <label for="position" class="form-label">Posición</label>
                                <input type="text" class="form-control" id="position" name="position"
                                    value="{{ $instructor->position }}" required placeholder="Líder Estrategia SENA Empresa">
                            </div>
                            <div class="mb-3">
                                <label for="document_type" class="form-label">Tipo de Documento</label>
                                <select class="form-select" id="document_type" name="document_type" required>
                                    <option value="C.C" {{ $instructor->document_type === 'C.C' ? 'selected' : '' }}>Cédula
                                        de Ciudadanía</option>
                                    <option value="T.I" {{ $instructor->document_type === 'T.I' ? 'selected' : '' }}>
                                        Tarjeta de Identidad</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="document_number" class="form-label">Número de Documento</label>
                                <input type="text" class="form-control" id="document_number" name="document_number"
                                    value="{{ $instructor->document_number }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="expedition_place" class="form-label">Lugar de Expedicion</label>
                                <input type="text" class="form-control" id="expedition_place" name="expedition_place"
                                    value="{{ $instructor->expedition_place }}" required
                                    placeholder="Ciudad de expedicion, eje:Bogotá">
                            </div>
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Número de Teléfono</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number"
                                    value="{{ $instructor->phone_number }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_signature" class="form-label">Firma</label>
                                <input type="file" class="form-control" id="edit_signature" name="signature">
                                <div class="signature-preview-container">
                                    <hr>
                                    <img id="current_signature" src="" alt="Firma actual">
                                </div>
                            </div>
                            <hr>
                            <!-- Botón para guardar la edición -->
                            <center><button type="submit" class="btn btn-primary">Guardar</button></center>
                        </form>
                    @endisset
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal de Editar Instructor -->

    @include('alerts')
    @include('datatable-script')

@stop

{{-- estilo de la imagen en el modal EDITAR --}}
<style>
    .signature-preview-container {
        text-align: center;
        /* Centrar horizontalmente */
    }

    .signature-preview-container img {
        max-width: 80%;
        /* El ancho máximo es el 80% del contenedor */
        max-height: 100px;
        /* Altura máxima para evitar imágenes muy altas */
        margin-top: 10px;
        /* Margen superior opcional para separar la imagen del campo de entrada de archivo */
        margin: auto;
        /* Centrar verticalmente */
        display: block;
        /* Para evitar márgenes no deseados */
    }
</style>

{{-- Script del modal Crear Instructor --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var crearInstructorModal = new bootstrap.Modal(document.getElementById('crearInstructor'));

        document.getElementById('showcrearInstructorModalButton').addEventListener('click', function() {
            crearInstructorModal.show();
        });

        /* Evento para cerrar el modal de crear instructor */
        document.querySelector('#crearInstructor .modal-footer .btn-secondary').addEventListener('click',
            function() {
                crearInstructorModal.hide();
            })
    });
</script>

<!-- Script del modal editar instructor -->
<script>
    function editarInstructor(id) {
        // Realizar una petición AJAX para obtener los datos del instructor
        fetch(`/instructor/${id}/detalle`)
            .then(response => response.json())
            .then(data => {
                // Actualizar el valor del campo name
                document.getElementById('edit_name').value = data.name;

                // Mostrar la firma actual si está presente
                if (data.signature) {
                    document.getElementById('current_signature').src = '{{ asset('storage/') }}/' + data.signature;
                } else {
                    document.getElementById('current_signature').src = '';
                }

                // Actualizar el formulario con la ruta correcta para la actualización
                document.getElementById('editarInstructorForm').action = `/instructor/${data.id}/update`;

                // Abrir el modal de edición
                var editarInstructorModal = new bootstrap.Modal(document.getElementById('editarInstructorModal'));
                editarInstructorModal.show();
            })
            .catch(error => console.error('Error al obtener datos del instructor:', error));
    }
</script>

<!-- Script previzualizacion de la firma cargada en el modal agregar -->
<script>
    function previewSignature(input) {
        var previewContainer = document.getElementById('signaturePreviewContainer');
        var previewImage = document.getElementById('signaturePreview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block'; // Muestra el contenedor de la previsualización
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            previewImage.src = '';
            previewContainer.style.display =
                'none'; // Oculta el contenedor de la previsualización si no hay imagen seleccionada
        }
    }
</script>
