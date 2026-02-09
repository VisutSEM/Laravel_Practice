<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;
use App\Http\Requests\PostRequest;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Routing\Route as RoutingRoute;

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
// ______________________________________
Route::get('/posts',function (){
    $post = DB::table('posts')->get();
    return response()->json([
        'data'=> $post,
        'message' => true
    ],200);
});

Route::post('/posts', function(Request $request){
    $post = DB::table('posts')->insert([
        'title' => $request->title,
        'desc' => $request->desc,
        'image_url' => $request->image_url
    ]);

    return response()->json([
        'sucess' => $post,
        'message' => 'succes'
    ],201);
});

Route::put('/posts/{id}', function($id, Request $request){
    $affected = DB::table('posts')
    -> where('id', $id)
    ->update([ 'title' => $request->title,
        'desc' => $request->desc,
        'image_url' => $request->image_url]);

        if ($affected == 0){
            return response()->json([
                 'success' => false
             ],404);
        }
        return response()->json([
            'data' => true
        ],202);

Route::delete('/posts/{id}', function ($id) {
    $deleted = DB::table('posts')->where('id', $id)->delete();

    if ($deleted === 0) {
        return response()->json([
            'success' => false
        ], 404);
    }

    return response()->json([
        'success' => true
    ], 202);
});
    
});