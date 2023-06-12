<?php

use App\Http\Controllers\FamiliesController;
use App\Http\Controllers\PersonController;
use App\Models\FamilyPersons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(PersonController::class)->group(function () {
    Route::get('/persons', 'persons');

    // add new persons
    Route::get('/person/check/{id_number}', 'check_person_id_number');

    // get person infromation
    Route::get('/person/{person_id}/{family_id}', 'person');

    // Filtring
    Route::get('/person/filter/name/{filter_key}', 'filter_person_name');
    Route::get('/person/filter/birthdate/{filter_key}', 'filter_person_birthdate');
    Route::get('/person/filter/idnumber/{filter_key}', 'filter_person_idnumber');
    Route::get('/person/filter/registerNumber/{filter_key}', 'filter_person_registernumber');

    // export Certificates 
    Route::get('/person/certificate/baptismal/{id}', 'baptismal_certificate');
    Route::get('/person/certificate/engagment/{id}', 'engagment_certificate');
    Route::get('/person/certificate/marriage/{id}', 'marriage_certificate');


    Route::post('/person/new', 'add_new_person');
    Route::post('/person/delete/{id}', 'delete_person');
    Route::post('/person/edit/{id}', 'edit_person');
    Route::get('/person/disease/remove/{id}/{person_id}', 'remove_person_disease');
    Route::post('/person/disease/add/{id}', 'add_person_disease');
    Route::post('/person/adjective/add/{person_id}', 'add_person_adjective');
    Route::post('/person/adjective/remove/{id}', 'separate_person_family');
});

Route::controller(FamiliesController::class)->group(function () {
    Route::get('/families', 'all_families');

    // get family information of person
    Route::get('/family/{family_id}', 'family');

    // Filtring
    Route::get('/family/filter/number/{filter_key}', 'family_id');
    Route::get('/family/filter/registerNumber/{filter_key}', 'family_registration_summary_number');
    Route::get('/family/filter/phone/{filter_key}', 'family_phone');
    Route::get('/family/filter/landingPhone/{filter_key}', 'family_landline_phone_number');
    Route::get('/family/filter/address/{district?}/{block?}', 'family_address');

    // Add new family
    Route::get('/family/check/{rsn}',  'check_exists_family');
    Route::post('/family/new',  'add_new_family');
    Route::post('/family/edit/{id}',  'edit_family');
    Route::post('/family/delete/{id}',  'delete_family');
});
