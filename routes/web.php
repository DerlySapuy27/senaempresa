<?php

use App\Http\Controllers\CertificateController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\SenaempresaController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TechnologistController;

Auth::routes();
Route::get('/', function () {return view('auth.login');});
Route::get('/home', function() {return view('home');})->name('home')->middleware('auth');

//Rutas Instructor SENAempresa//
Route::get('/instructor/index', [InstructorController::class, 'index'])->name('instructor.index')->middleware('auth');
Route::post('/instructor/create', [InstructorController::class, 'crearinstructor'])->name('instructor.crearinstructor')->middleware('auth');
Route::delete('/instructor/{instructor}', [InstructorController::class, 'delete'])->name('instructor.delete')->middleware('auth');
Route::put('/instructor/{id}/update', [InstructorController::class, 'update'])->name('instructor.update')->middleware('auth');
Route::get('/instructor/{id}/detalle', [InstructorController::class, 'detalle'])->middleware('auth');


//Rutas CRUD Estrategia SENAempresa//
Route::get('/senaempresa/index', [SenaempresaController::class, 'index'])->name('senaempresa.index')->middleware('auth');
Route::post('/senaempresa/crear', [SenaempresaController::class, 'crearsenaempresa'])->name('senaempresa.crearsenaempresa')->middleware('auth');
Route::delete('/senaempresa/{senaempresa}', [SenaempresaController::class, 'delete'])->name('senaempresa.delete')->middleware('auth');
Route::put('/senaempresa/editar', [SenaempresaController::class, 'editar'])->name('senaempresa.editar')->middleware('auth');
Route::get('/senaempresa/{id}/detalle', [SenaempresaController::class, 'detalle'])->middleware('auth');


//Rutas CRUD Roles SENAempresa//
Route::get('/rol/index', [RoleController::class, 'index'])->name('rol.index')->middleware('auth');
Route::post('/rol/create', [RoleController::class, 'crearrol'])->name('rol.crearrol')->middleware('auth');
Route::delete('/roles/{role}', [RoleController::class, 'delete'])->name('roles.delete')->middleware('auth');
Route::get('/roles/{id}/detalle', [RoleController::class, 'detalle'])->middleware('auth');
Route::put('/roles/editar', [RoleController::class, 'editar'])->name('rol.editar')->middleware('auth');


//Rutas CRUD tecnologos//
Route::get('/technologist/index', [TechnologistController::class, 'index'])->name('technologist.index')->middleware('auth');
Route::post('/technologist/crear', [TechnologistController::class, 'crear'])->name('technologist.crear')->middleware('auth');
Route::delete('/technologists/{technologist}', [TechnologistController::class, 'delete'])->name('technologists.delete')->middleware('auth');
Route::get('/technologist/{id}/detalle', [TechnologistController::class, 'detalle'])->middleware('auth');
Route::put('/technologist/editar', [TechnologistController::class, 'editar'])->name('technologist.editar')->middleware('auth');


//Rutas CRUD aprendices/->middleware('auth');
Route::get('/student/index', [StudentController::class, 'index'])->name('student.index')->middleware('auth');
Route::post('/student/crear', [StudentController::class, 'crear'])->name('student.crear')->middleware('auth');
Route::delete('/students/{student}', [StudentController::class, 'delete'])->name('students.delete')->middleware('auth');
Route::put('/students/editar', [StudentController::class, 'editar'])->name('student.editar')->middleware('auth');
Route::get('/students/{student}/detalle', [StudentController::class, 'detalle'])->middleware('auth');


//Rutas  certificado//
Route::get('/certificado/index', [CertificateController::class, 'index'])->name('certificado.index')->middleware('auth');
Route::get('/certificado/{senaempresa}/aprendices', [CertificateController::class, 'aprendices'])->name('certificado.aprendices')->middleware('auth');
Route::get('/certificado/{id}/certificado', [CertificateController::class, 'mostrarCertificado'])->name('certificado.certificado')->middleware('auth');



