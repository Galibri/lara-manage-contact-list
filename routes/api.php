<?php

use App\Contact;
use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api'], function() {
    /**
     * View all contacts
     */
    Route::get('contacts', function() {
        return Contact::latest()->orderBy('id', 'desc')->get();
    });

    /**
     * View single contact
     */
    Route::get('contact/{id}', function($id) {
        return Contact::findOrFail($id);
    });

    /**
     * Add new contact
     */
    Route::post('contact/store', function(Request $request) {
        return Contact::create([
            'name' => $request->input(['name']),
            'email' => $request->input(['email']),
            'phone' => $request->input(['phone'])
            ]);
    });

    /**
     * Update contact
     */
    Route::patch('contact/{id}', function(Request $request, $id) {
        Contact::findOrFail($id)->update([
            'name' => $request->input(['name']),
            'email' => $request->input(['email']),
            'phone' => $request->input(['phone'])
            ]);
        return "updated!";
    });

    /**
     * Delete contact
     */
    Route::delete('contact/{id}', function($id) {
        return Contact::destroy($id);
    });
});