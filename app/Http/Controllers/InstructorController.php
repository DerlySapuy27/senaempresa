<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Instructor;
use Illuminate\Support\Facades\Storage;

class InstructorController extends Controller
{
public function index(){
    $instructors = Instructor::all();
    return view('instructor.index')->with('instructors', $instructors);}


public function crearinstructor(Request $request){
    $request->validate([
        'name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'ocupation' => 'required|string|max:255',
        'position' => 'required|string|max:255',
        'document_type' => 'required|in:C.C,T.I',
        'document_number' => 'required|string|max:255',
        'expedition_place' => 'required|string|max:255',
        'phone_number' => 'required|string|max:10',
        'signature' => 'file|nullable',
    ]);

    $instructor = new Instructor([
        'name' => $request->name ? strtoupper($request->name) : null,
        'last_name' => $request->last_name ? strtoupper($request->last_name) : null,
        'ocupation' => $request->ocupation,
        'position' => $request->position,
        'document_type' => $request->document_type,
        'document_number' => $request->document_number,
        'expedition_place' => $request->expedition_place,
        'phone_number' => $request->phone_number,
    ]);
    
    if ($request->hasFile('signature')) {
        $signaturePath = $request->file('signature')->store('signatures', 'public');
        $instructor->signature = $signaturePath;
    }
    $instructor->save();
    return redirect()->route('instructor.index')->with('success', 'Instructor creado exitosamente.');}

public function delete(Instructor $instructor){
    $instructor->delete();
    return redirect()->route('instructor.index')->with('success', 'Instructor eliminado exitosamente.');}


public function update(Request $request, $id){
    $request->validate([
        // Añade las reglas de validación necesarias
    ]);

    $instructor = Instructor::find($id);
    if (!$instructor) {
        return redirect()->route('instructor.index')->with('error', 'Instructor no encontrado.');
    }
    $instructor->name = strtoupper($request->name); // Convierte a mayúsculas
    $instructor->last_name = strtoupper($request->last_name);
    $instructor->ocupation = $request->ocupation;
    $instructor->position = $request->position;
    $instructor->document_type = $request->document_type;
    $instructor->document_number = $request->document_number;
    $instructor->expedition_place = $request->expedition_place;
    $instructor->phone_number = $request->phone_number;


    // Manejar la carga de la firma si está presente
    if ($request->hasFile('signature')) {
        // Eliminar la firma anterior si existe
        if ($instructor->signature) {
            Storage::disk('public')->delete($instructor->signature);
        }
        // Guardar la nueva firma
        $signaturePath = $request->file('signature')->store('signatures', 'public');
        $instructor->signature = $signaturePath;
    }
    $instructor->save();
    return redirect()->route('instructor.index')->with('success', 'Instructor actualizado exitosamente.');}
    
public function detalle($id){
    $instructor = Instructor::findOrFail($id);
    return response()->json($instructor);}




}




