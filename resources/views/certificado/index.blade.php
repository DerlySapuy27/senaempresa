@extends('adminlte::page')

@section('content_header')
    @include('head')
    <h1 class="m-0 text-dark">GENERACIÓN DE CERTIFICADOS SENA EMPRESA</h1><br>
@stop

@section('content')
<div class="row">
    @foreach($senaempresas as $senaempresa)
    <div class="col-md-4">
        <a href="{{ route('certificado.aprendices', ['senaempresa' => $senaempresa->id]) }}" class="text-decoration-none">
            <div class="card shadow-sm mb-4 rounded">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">{{ $senaempresa->name }}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong>Ubicación:</strong> {{ $senaempresa->location }}</p>
                    <p class="card-text"><strong>Inicio:</strong> {{ $senaempresa->start_date }}</p>
                    <p class="card-text"><strong>Fin:</strong> {{ $senaempresa->end_date }}</p>

                    <p class="card-text"><strong>Instructor líder:</strong> {{ $senaempresa->instructor->name }} {{ $senaempresa->instructor->last_name }}</p>
                    <!-- Agrega más información del instructor líder según sea necesario -->
                </div>
                <div class="card-footer bg-primary">
                    <!-- Puedes agregar botones o enlaces aquí según sea necesario -->
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>

@include('alerts')
@include('datatable-script')
@stop
