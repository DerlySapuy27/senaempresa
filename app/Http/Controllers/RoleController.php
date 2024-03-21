<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    
    public function index(){
        $roles = Role::all();
        return view('rol.index')->with('roles', $roles);}           

    public function delete(Role $role){
        $role->delete();
        return redirect()->route('rol.index')->with('success', 'Rol eliminado exitosamente.');}
    
    public function crearrol(Request $request){
        $request->validate([
            'rol_name' => 'required|string|max:255',
            'rol_description' => 'required|string|max:1000',
        ]);
        $rol = new Role();
        $rol->name = $request->input('rol_name');
        $rol->description = $request->input('rol_description');
        $rol->save();
        return redirect()->route('rol.index')->with('success', 'Rol creado exitosamente.');}

    public function detalle($id) {
        $rol = Role::find($id);
        return response()->json($rol);}
        

    public function editar(Request $request){
            $request->validate([
                'edit_rol_name' => 'required|string|max:255',
                'edit_rol_description' => 'required|string|max:255',
            ]);    
            $rol = Role::find($request->edit_rol_id);
        
            $rol->name = $request->edit_rol_name;
            $rol->description = $request->edit_rol_description;
            $rol->save();
            return redirect()->route('rol.index')->with('success', 'Rol actualizado exitosamente.');}
        

}



