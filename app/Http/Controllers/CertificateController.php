<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Models\Senaempresa;
use App\Models\Student;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use PDF;





class CertificateController extends Controller
{

    public function index(){
        // Obtener todos los registros de Sena Empresa con sus estudiantes (aprendices) cargados
        $senaempresas = Senaempresa::with('students')->get();
        // Pasar la variable a la vista
        return view('certificado.index', compact('senaempresas'));}



    public function aprendices(Senaempresa $senaempresa){
        // Obtén todos los aprendices asociados a la SENA empresa seleccionada
        $aprendices = $senaempresa->students;
        // Pasa los datos a la vista
        return view('certificado.aprendices', compact('aprendices', 'senaempresa'));}


    
        public function mostrarCertificado($id)
        {
            $aprendiz = Student::findOrFail($id);
            return view('certificado.certificado', compact('aprendiz'));
        }



    







}
