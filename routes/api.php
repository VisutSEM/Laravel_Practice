<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
 
Route::get('/products', function(){
    $prodoct = DB::table('products')->get();
    return response()->json(
        [
            "data"=>$prodoct,
            "sucess"=> true
        ],200
    );
});

Route::post('/products', function(Request $request){
        $prodoct = DB::table('products')->insert([
        'name' => $request-> name,
        'price' => $request->price,
        'desc' => $request->desc,
        'image' => $request->image
    ]);
    return response()->json(
        [
            'data'=> $prodoct,
            'succes' => true
        ],200
    );
    
});

Route::post('/register', [AuthenticationController::class,'register']);
Route::post('/login', [AuthenticationController::class,'login']);