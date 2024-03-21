<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Senaempresa;
use App\Models\Instructor;



class SenaempresaController extends Controller
{

    public function index(){
        $instructors = Instructor::all();
        $senaempresas = Senaempresa::with('instructor')->get();
        return view('senaempresa.index', compact('senaempresas', 'instructors'));}


    public function crearsenaempresa(Request $request){
        // Validaciones
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'instructor_id' => 'required|exists:instructors,id',
        ]);
        // Crear una nueva instancia de Senaempresa
        $senaempresa = new Senaempresa([
            'name' => $request->name,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        // Asignar el instructor
        $instructor = Instructor::find($request->instructor_id);
        if (!$instructor) {
            // Manejar el caso en el que no se encuentra el instructor
            return redirect()->route('senaempresa.index')->with('error', 'Instructor no encontrado.');
        }
        // Asociar el instructor al Senaempresa
        $senaempresa->instructor()->associate($instructor);
        // Guardar el Senaempresa
        $senaempresa->save();
        // Redireccionar con mensaje de éxito
        return redirect()->route('senaempresa.index')->with('success', 'Senaempresa creado exitosamente.');}


    public function delete(Senaempresa $senaempresa){
        $senaempresa->delete();
        return redirect()->route('senaempresa.index')->with('success', 'Estrategia Sena Empresa eliminado exitosamente.');}


    public function editar(Request $request){
        $request->validate([
            'edit_name' => 'required|string|max:255',
            'edit_location' => 'required|string|max:255',
            'edit_start_date' => 'required|date',
            'edit_end_date' => 'required|date|after:edit_start_date',
            'edit_instructor_id' => 'required|exists:instructors,id',
        ]);
        // Obtener la instancia de Senaempresa
        $senaempresa = Senaempresa::find($request->edit_senaempresa_id);
        // Actualizar los campos
        $senaempresa->name = $request->edit_name;
        $senaempresa->location = $request->edit_location;
        $senaempresa->start_date = $request->edit_start_date;
        $senaempresa->end_date = $request->edit_end_date;
        $senaempresa->instructor_id = $request->edit_instructor_id;
        // Guardar los cambios
        $senaempresa->save();
        return redirect()->route('senaempresa.index')->with('success', 'Senaempresa actualizado exitosamente.');}

    public function detalle($id){
        $senaempresa = Senaempresa::with('instructor')->find($id);
        return response()->json($senaempresa);}
}
