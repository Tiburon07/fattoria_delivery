<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\AttivitaController;
use App\Events\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Traits\Date;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

//HOME
Route::group(
    ['middleware' => 'auth','prefix' => ''],
    function (){
        Route::get('/', function(){ return view('home', ['view' => 'home']); })->name('home');
        Route::get('/chat',[ChatController::class,'index'])->name('chat');
        Route::post('/send-message', function(Request $request){
            event(new Message($request->input('user_name'), $request->input('message'), $request->input('user_id')));
            return ["success" => true];
        });
    }
);

//ADMIN
Route::group(
    ['middleware' => ['auth','verifyIsAdmin'],'prefix' => 'admin'],
    function (){
        Route::get('/', [AdminUserController::class,'index'])->name('user-list');
        Route::get('/getUsers/{start}/{length}/{col}/{dir}/{search}', [AdminUserController::class, 'getUsers']);
    }
);
