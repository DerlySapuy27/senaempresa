@extends('adminlte::page')

@section('content_header')
    @include('head')

    <h1 class="m-0 text-dark"> Aprendices SENA Empresa</h1>

@stop

@section('content')
    <!-- Boton de Agregar nueva estrategia sena empresa -->
    <div class="card" style="width: 90%; margin-left: 40px;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <button id="showCrearStudentModalButton" class="btn btn-success" data-bs-toggle="modal"
                data-bs-target="#crearStudent">
                <i class="fas fa-folder-plus"></i> Agregar
            </button>
        </div>
        <!-- Lista de Students -->
        <div class="card-body">
            <table id="datatable" class="table table-striped shadow-lg mt-4" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>#Documento</th>
                        <th>Tecnólogo</th>
                        <th>Estrategia</th>
                        <th>Cargo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->last_name }}</td>
                            <td>{{ $student->document_number }}</td>
                            <td>{{ $student->technologist->name }}</td>
                            <td>{{ $student->senaempresa->name }}</td>
                            <td>
                                @if ($student->roles->isNotEmpty())
                                    @foreach ($student->roles as $index => $role)
                                        {{ $role->name }}
                                        <!-- Agrega un guion si no es el último rol -->
                                        @if ($index < $student->roles->count() - 1)
                                            -
                                        @endif
                                    @endforeach
                                @else
                                    Sin roles asignados
                                @endif
                            </td>
                            <td>
                                <!-- Botones de Editar y eliminar -->
                                <div class="container text-center">
                                    <div class="row">
                                        <div class="col">
                                            <button type="button" class="btn btn-primary" style="width: 70px;"
                                                data-bs-toggle="modal" data-bs-target="#editarStudentModal"
                                                onclick="cargarDatosEstudiante({{ $student->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                        <div class="col">
                                            <form id="deleteForm{{ $student->id }}"
                                                action="{{ route('students.delete', ['student' => $student->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger" style="width: 70px;"
                                                    onclick="confirmDelete({{ $student->id }})">
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
        </div><!-- Fin Lista de Students -->
    </div>

    <!-- Modal de Crear nuevo Student -->
    <div class="modal fade" id="crearStudent" tabindex="-1" aria-labelledby="crearStudentLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearStudentLabel">Agregar nuevo Aprendiz</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('student.crear') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="name" name="name" pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+" required>
                        </div>
                        <div class="mb-3">
                            <label for="document_type" class="form-label">Tipo de Documento</label>
                            <select class="form-select" id="document_type" name="document_type" required>
                                <option value="">Seleccione Tipo de Documento</option>
                                <option value="C.C">Cédula de Ciudadanía</option>
                                <option value="T.I">Tarjeta de Identidad</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="document_number" class="form-label">Número de Documento</label>
                            <input type="number" class="form-control" id="document_number" name="document_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="expedition_date" class="form-label">Fecha de Expedición</label>
                            <input type="date" class="form-control" id="expedition_date" name="expedition_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="expedition_place" class="form-label">Lugar de Expedición</label>
                            <input type="text" class="form-control" id="expedition_place" name="expedition_place" pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="technologist_id" class="form-label">Tecnólogo</label>
                            <select class="form-select" id="technologist_id" name="technologist_id" required>
                                <option value="">Seleccione Tecnólogo</option>
                                @foreach ($technologists as $technologist)
                                    <option value="{{ $technologist->id }}">{{ $technologist->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="senaempresa_id" class="form-label">Sena Empresa</label>
                            <select class="form-select" id="senaempresa_id" name="senaempresa_id" required>
                                <option value="">Seleccione estrategia SENA Empresa</option>
                                @foreach ($senaempresas as $senaempresa)
                                    <option value="{{ $senaempresa->id }}">{{ $senaempresa->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="num_roles" class="form-label">Seleccione la cantidad de Roles a Asignar al
                                aprendiz</label>
                            <select class="form-select" id="num_roles" name="num_roles" required>
                                <option value="">Seleccione Numero de Rol del Aprendiz</option>
                                <option value="1">1 Cargo</option>
                                <option value="2">2 Cargos</option>
                            </select>
                        </div>

                        <div id="roles-container">
                            <!-- Aquí se mostrarán dinámicamente los campos de selección de roles -->
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Editar Estudiante -->
    <div class="modal fade" id="editarEstudianteModal" tabindex="-1" aria-labelledby="editarEstudianteLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarEstudianteLabel">Editar Estudiante</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('student.editar') }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit_name" name="edit_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_last_name" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="edit_last_name" name="edit_last_name"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_document_type" class="form-label">Tipo de Documento</label>
                            <select class="form-select" id="edit_document_type" name="edit_document_type" required>
                                <option value="C.C">Cédula de Ciudadanía</option>
                                <option value="T.I">Tarjeta de Identidad</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_document_number" class="form-label">Número de Documento</label>
                            <input type="number" class="form-control" id="edit_document_number"
                                name="edit_document_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_expedition_date" class="form-label">Fecha de Expedición</label>
                            <input type="date" class="form-control" id="edit_expedition_date"
                                name="edit_expedition_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_expedition_place" class="form-label">Lugar de Expedición</label>
                            <input type="text" class="form-control" id="edit_expedition_place"
                                name="edit_expedition_place" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_technologist_id" class="form-label">Tecnólogo</label>
                            <select class="form-select" id="edit_technologist_id" name="edit_technologist_id" required>
                                <!-- Puedes llenar las opciones según tus necesidades -->
                                @foreach ($technologists as $technologist)
                                    <option value="{{ $technologist->id }}">{{ $technologist->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_senaempresa_id" class="form-label">Sena Empresa</label>
                            <select class="form-select" id="edit_senaempresa_id" name="edit_senaempresa_id" required>
                                <!-- Puedes llenar las opciones según tus necesidades -->
                                @foreach ($senaempresas as $senaempresa)
                                    <option value="{{ $senaempresa->id }}">{{ $senaempresa->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="edit_roles-container">
                            <!-- Aquí se mostrarán dinámicamente los campos de selección de roles -->
                        </div>                                         
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal de Editar Student -->


    @include('alerts')
    @include('datatable-script')
@stop



<!-- script editar -->
<script>
    function cargarDatosEstudiante(studentId) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', `/students/${studentId}/detalle`, true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                var data = JSON.parse(xhr.responseText);
                console.log(data);

                setValueIfPresent('edit_student_id', data.id);
                setValueIfPresent('edit_name', data.name);
                setValueIfPresent('edit_last_name', data.last_name);
                setValueIfPresent('edit_document_type', data.document_type);
                setValueIfPresent('edit_document_number', data.document_number);
                setValueIfPresent('edit_expedition_date', data.expedition_date);
                setValueIfPresent('edit_expedition_place', data.expedition_place);
                setValueIfPresent('edit_technologist_id', data.technologist_id);
                setValueIfPresent('edit_senaempresa_id', data.senaempresa_id);

                var rolesContainer = document.getElementById('edit_roles-container');
                if (rolesContainer) {
                    rolesContainer.innerHTML = '';

                    data.roles.forEach(function(role, index) {
                        var roleId = role.id;
                        var roleName = role.name;

                        var roleField = `<div class="mb-3">
                            <label for="edit_role_id_${roleId}" class="form-label">Rol ${index + 1}:</label>
                            <select id="edit_role_id_${roleId}" name="edit_roles[]" class="form-select">
                                <!-- Opciones de roles -->
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>`;

                        rolesContainer.insertAdjacentHTML('beforeend', roleField);
                    });

                    var modal = new bootstrap.Modal(document.getElementById('editarEstudianteModal'));
                    modal.show();
                } else {
                    console.error('Contenedor de roles no encontrado');
                }
            } else {
                console.error('Error en la solicitud:', xhr.statusText);
            }
        };

        xhr.onerror = function() {
            console.error('Error de red');
        };

        xhr.send();
    }

    function setValueIfPresent(elementId, value) {
        var element = document.getElementById(elementId);
        if (element) {
            element.value = value;
        }
    }
</script>



<!-- Script de crear nuevo estudiante -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var crearStudentModal = new bootstrap.Modal(document.getElementById('crearStudent'));

        document.getElementById('showCrearStudentModalButton').addEventListener('click', function() {
            crearStudentModal.show();
        });

        // Puedes agregar eventos adicionales según sea necesario
    });
</script>
<!-- Script JavaScript puro -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var roles = <?php echo json_encode($roles); ?>;

        function updateRolesFields() {
            var numRoles = document.getElementById("num_roles").value;
            var rolesContainer = document.getElementById("roles-container");
            rolesContainer.innerHTML = '';

            for (var i = 0; i < numRoles; i++) {
                var roleField = '<div class="mb-3">' +
                    '<label for="role_id_' + i + '" class="form-label">Rol ' + (i + 1) + ':</label>' +
                    '<select id="role_id_' + i + '" name="roles[]">' +
                    '<option value="">Seleccione un Rol</option>';

                for (var j = 0; j < roles.length; j++) {
                    roleField += '<option value="' + roles[j].id + '">' + roles[j].name + '</option>';
                }

                roleField += '</select></div>';
                rolesContainer.innerHTML += roleField;
            }

            rolesContainer.style.display = numRoles > 0 ? 'block' : 'none';
        }

        document.getElementById("num_roles").addEventListener('change', updateRolesFields);

        updateRolesFields();
    });
</script>



