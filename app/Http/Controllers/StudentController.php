<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Technologist;
use App\Models\Senaempresa;
use App\Models\Role;

class StudentController extends Controller
{

public function index(){
    // Obtén los datos necesarios para llenar los selectores
    $technologists = Technologist::all();
    $senaempresas = Senaempresa::all();
    $roles = Role::all();

    // Obtén los estudiantes con las relaciones cargadas
    $students = Student::with(['technologist', 'senaempresa', 'roles'])->get();


    // Retorna la vista con los datos necesarios
    return view('student.index', compact('students', 'technologists', 'senaempresas', 'roles'));}

public function crear(Request $request){
    // Validaciones

    // Crear una nueva instancia de Student
    $student = new Student([
        'name' => $request->name,
        'last_name' => $request->last_name,
        'document_type' => $request->document_type,
        'document_number' => $request->document_number,
        'expedition_date' => $request->expedition_date,
        'expedition_place' => $request->expedition_place,
    ]);

    // Asignar las relaciones
    $student->technologist()->associate(Technologist::find($request->technologist_id));
    $student->senaempresa()->associate(Senaempresa::find($request->senaempresa_id));

    // Guardar el estudiante
    $student->save();

    // Asociar roles
    $roles = $request->input('roles', []);
    $student->roles()->attach($roles);

    // Redireccionar con mensaje de éxito
    return redirect()->route('student.index')->with('success', 'Estudiante creado exitosamente.');}

public function delete(Student  $student){
    $student->delete();
    return redirect()->route('student.index')->with('success', 'student eliminado exitosamente.');}



public function detalle(Student $student) {
    // Obtener los detalles del estudiante con sus roles
    $studentDetails = $student->load('roles');
    return response()->json($studentDetails);
}



    
public function editar(Request $request) {
    // Obtener la instancia del estudiante
    $estudiante = Student::find($request->edit_student_id);

    // Verificar si el estudiante existe
    if (!$estudiante) {
        return redirect()->route('student.index')->with('error', 'Estudiante no encontrado.');
    }

    // Actualizar los campos básicos del estudiante
    $estudiante->update([
        'name' => $request->edit_name,
        'last_name' => $request->edit_last_name,
        'document_type' => $request->edit_document_type,
        'document_number' => $request->edit_document_number,
        'expedition_date' => $request->edit_expedition_date,
        'expedition_place' => $request->edit_expedition_place,
        'technologist_id' => $request->edit_technologist_id,
        'senaempresa_id' => $request->edit_senaempresa_id,
    ]);

    // Obtener los roles seleccionados
    $roles = $request->edit_roles;

    // Sincronizar los roles del estudiante con los roles seleccionados
    if ($roles !== null) {
        $estudiante->roles()->sync($roles);
    } else {
        // Si no se seleccionaron roles, desasociar todos los roles del estudiante
        $estudiante->roles()->detach();
    }

    // Redireccionar
    return redirect()->route('student.index')->with('success', 'Estudiante actualizado exitosamente.');
}

    
    
    
}

