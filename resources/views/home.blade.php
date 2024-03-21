@extends('adminlte::page')

@section('content_header')
@stop

@section('content')
        <h2 class="display-8">SENA EMPRESA "LA ANGOSTURA"</h2>
        <p class="lead"><i class="fas fa-map-marker-alt"></i>   CAMPOALEGRE-HUILA </p>
        <center>
            <p><img src="{{ asset('images/casona.jpeg') }}" alt="Descripción de la imagen" style="width: 80%; height: 50%;"></p>
        </center>
    @section('footer')
    <footer class="bg-body-tertiary text-center">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-4 col-md-12 mb-4 mb-md-0 text-center"> <!-- Modificado: Agregado text-center -->
                    <div>
                        <h5 class="text-uppercase" style="color: black; font-family: 'Times New Roman', Times, serif;">Yuderly Sapuy</h5>
                        <p>
                            <img src="{{ asset('images/dev.jpg') }}" alt="Rostros" class="img-fluid mx-auto" style="max-width: 100px;"> <!-- Modificado: Agregado mx-auto -->
                        </p>
                        <p style="font-weight: bold; font-style: italic; color: black;">Aprendiz Análisis y Desarrollo de Software</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 mb-4 mb-md-0 text-center"> <!-- Modificado: Agregado text-center -->
                    <div>
                        <h5 class="text-uppercase" style="color: black; font-family: 'Times New Roman', Times, serif;">Rubén Dario Delgado</h5>
                        <p>
                            <img src="{{ asset('images/instructor.png') }}" alt="Rostros" class="img-fluid mx-auto" style="max-width: 100px;"> <!-- Modificado: Agregado mx-auto -->
                        </p>
                        <p style="font-weight: bold; font-style: italic; color: black;">Instructor Líder <i class="fas fa-chalkboard-teacher"></i></p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 mb-4 mb-md-0 text-center"> <!-- Modificado: Agregado text-center -->
                    <div>
                        <h5 class="text-uppercase mb-0" style="color: black; font-family: 'Times New Roman', Times, serif;">SENA Empresa</h5>
                        <p>
                            <img src="{{ asset('images/logo.png') }}" alt="Rostros" class="img-fluid mx-auto" style="max-width: 100px;"> <!-- Modificado: Agregado mx-auto -->
                        </p>
                        <p style="font-weight: bold; font-style: italic; color: black;">LA ANGOSTURA <i class="fas fa-map-marker-alt"></i></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center p-3" style="background-color: #aae0aa;">
            © 2024 Copyright:
            <a class="text-body" href="https://mdbootstrap.com/">Yuderly Sapuy Chavarro</a>
        </div>
    </footer>
    

@stop

@stop


