<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Technologist;


class TechnologistController extends Controller
{    

    public function delete(Technologist $technologist){
        $technologist->delete();
        return redirect()->route('technologist.index')->with('success', 'Rol eliminado exitosamente.');}

    public function index(){
        $technologists = Technologist::all();
        return view('technologist.index', compact('technologists'));}


    public function crear(Request $request){
        // Validaciones
        $request->validate([
            'create_name' => 'required|string|max:255',
            'create_code' => 'required|integer',
        ]);
        // Crear nuevo Technologist
        Technologist::create([
            'name' => $request->create_name,
            'code' => $request->create_code,
        ]);
        // Redireccionar con mensaje de éxito
        return redirect()->route('technologist.index')->with('success', 'Technologist creado exitosamente.');}



    public function editar(Request $request){
        // Validaciones
        $request->validate([
            'edit_name' => 'required|string|max:255',
            'edit_code' => 'required|integer',
        ]);
        // Obtener la instancia de Technologist
        $technologist = Technologist::find($request->edit_technologist_id);
        // Actualizar los campos
        $technologist->name = $request->edit_name;
        $technologist->code = $request->edit_code;
        $technologist->save();
        return redirect()->route('technologist.index')->with('success', 'Technologist actualizado exitosamente.');}

        public function detalle($id){
        $technologist = Technologist::find($id);
        return response()->json($technologist);}

}
