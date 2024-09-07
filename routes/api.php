<?php

use App\Http\Controllers\BorrowedBookController;
use App\Http\Controllers\ManageBookController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/getUsers', [UsersController::class, 'getUsers']);
Route::post('/insertUsers', [UsersController::class, 'insertUsers']);

Route::post('/insertBooks', [ManageBookController::class, 'insertBook']);
Route::get('/getBooks', [ManageBookController::class, 'getBooks']);
Route::put('/updateBook', [ManageBookController::class, 'updateBook']);
Route::delete('/deleteBook', [ManageBookController::class, 'deleteBook']);

Route::post('/borrowBook', [BorrowedBookController::class, 'borrowBook']);
Route::post('/getUserBorrowedBooks', [BorrowedBookController::class, 'getUserBorrowedBooks']);
Route::delete('/cancelBorrowedRequest', [BorrowedBookController::class, 'cancelBorrowedRequest']);

Route::post('/add-student', [StudentController::class, 'insertStudent']);
Route::post('/user-login', [StudentController::class, 'login']);


// Route::middleware(['auth'])->group(function () {
//     Route::post('/user-login', function () {
//         return response()->json(['message' => 'Student Added']);
//     });

//     Route::post('/endpoint-2', function () {
//         return response()->json(['message' => 'Endpoint 2']);
//     });

 
// });