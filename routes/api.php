<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// ambil semua data
Route::get('/students', [StudentController::class, 'index']);

//tambah data baru
Route::post('/students/tambah-data', [StudentController::class, 'store']);

//generate token csrf
Route::get('/generate-token', [StudentController::class, 'createToken']);

//ambil satu data spesifik
Route::get('/students/{id}', [StudentController::class, 'show']);

//mengubah data tertentu
Route::patch('/students/update/{id}', [StudentController::class, 'update']);

Route::delete('/students/delete/{id}', [StudentController::class, 'destroy']);

// menampilkan data yang sudah dihapus sementara oleh sofdeletes
Route::get('/students/show/trash', [StudentController::class, 'trash']);

//mengembalikan data spesifik yang sudah dihapus
Route::get('/students/trash/restore/{id}', [StudentController::class, 'restore']);

//menghapus data permanen tertentu
Route::get('/students/trash/delete/permanen/{id}', [StudentController::class, 'permanenDelete']);
