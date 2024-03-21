@extends('adminlte::page')

@section('content_header')
    @include('head')
    <h1>Aprendices asociados a {{ $senaempresa->name }}</h1>
@stop

@section('content')
    <div class="card" style="width: 90%; margin-left: 40px;">
        <!-- Lista de Aprendices -->
        <div class="card-body">
            <table id="datatable" class="table table-striped table-bordered table-hover shadow-lg mt-4" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Número de Documento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($aprendices->isNotEmpty())
                        @foreach ($aprendices as $aprendiz)
                            <tr>
                                <td>{{ $aprendiz->name }}</td>
                                <td>{{ $aprendiz->last_name }}</td>
                                <td>{{ $aprendiz->document_number }}</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <a href="{{ route('certificado.certificado', $aprendiz->id) }}" target="_blank">
                                        <i class="far fa-file-pdf"></i>
                                    </a>
                                </td>
                                
                                
                                
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">No hay aprendices asociados a esta SENA empresa.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div><!-- Fin Lista de Aprendices -->
    </div>
    
    @include('datatable-script')
@stop
