<?php

use Illuminate\Http\Request;
use App\Contact;
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

//adding api for backend
Route::group(['middleware'=>'api'],function(){

    Route::get('contacts',function(){
            return Contact::latest()->orderBy('created_at','desc')->get();
    });

    //single contact
    Route::get('contact/{id}',function($id){
        return Contact::findOrFail($id);
    });

    //add
    Route::post('contact/store',function(Request $request){
        return Contact::create(
            [
                'name'=>$request->input(['name']),
                'email'=>$request->input(['email']),
                'phone'=>$request->input(['phone'])
            ]);
    });

    //update
    Route::patch('contact/{id}',function(Request $request,$id){
        Contact::findOrFail($id)->update(
            [
            'name'=>$request->input(['name']),
            'email'=>$request->input(['email']),
            'phone'=>$request->input(['phone'])
            ]);
    });

    Route::delete('contact/{id}',function($id){
        return Contact::destroy($id);
    });



});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


