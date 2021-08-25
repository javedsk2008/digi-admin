<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('reset_password/{token}', ['as' => 'password.reset', function($token)
{
    // implement your reset password route here!
}]);

Route::get('/','LoginContoller@showLogin');
Route::get('/forget_passwod', 'MasterController@forget_passwod');
Route::post('/forget_passwod', 'MasterController@forget_passwod');
Route::get('/create_password', 'MasterController@create_password');
Route::post('/create_password', 'MasterController@create_password');
Auth::routes();

Route::group(['middleware' => ['master_admin']], function () 
{

    Route::get('deleterow','MasterController@deleterow');
    Route::get('checkclassname','MasterController@checkclassname');
    Route::get('/chech_onkeyup','MasterController@chech_onkeyup');     
    Route::post('/get_branch_from_school','MasterController@get_branch_from_school');     
    Route::post('/get_bookorsubject_from_course','MasterController@get_bookorsubject_from_course');    

    
    Route::get('/home', 'HomeController@index');
    Route::get('/view_class','MasterController@view_class');      
    Route::post('/view_class','MasterController@view_class'); 

    Route::get('/view_subject','MasterController@view_subjects');     
    Route::post('/view_subject','MasterController@view_subjects');   
    Route::get('/add_subjects','MasterController@add_subjects');     
    Route::post('/add_subjects','MasterController@add_subjects');    
    Route::post('/edit_subjects','MasterController@edit_subjects');       
    Route::get('/edit_subjects','MasterController@edit_subjects');  
    Route::get('/view_subjects_details','MasterController@view_subjects_details');  

    Route::post('/autosearch_class','MasterController@autosearch_class');
    Route::get('/view_audiovideo','MasterController@view_audiovideo');     
    Route::get('/add_audiovideo','MasterController@add_audiovideo'); 
    Route::post('/add_audiovideo','MasterController@add_audiovideo');        
    Route::get('/edit_audiovideo','MasterController@edit_audiovideo');     
    Route::post('/edit_audiovideo','MasterController@edit_audiovideo');  
    Route::post('/get_subject_from_courseclass','MasterController@get_subject_from_courseclass'); 
    Route::post('/get_chapter_from_subject','MasterController@get_chapter_from_subject'); 
    Route::post('/get_class_from_type','MasterController@get_class_from_type'); 
    Route::post('/view_all_array_in','MasterController@view_all_array_in'); 
    Route::get('/add_activity','MasterController@add_activity'); 
    Route::post('/add_activity','MasterController@add_activity');

    Route::get('/view_questions','MasterController@view_questions');

    Route::get('/add_mcq','MasterController@add_mcq'); 
    Route::post('/add_mcq','MasterController@add_mcq');
    Route::get('/edit_mcq','MasterController@edit_mcq'); 
    Route::post('/edit_mcq','MasterController@edit_mcq');

    Route::post('/add_fillin_blanks','MasterController@add_fillin_blanks');
    Route::get('/add_fillin_blanks','MasterController@add_fillin_blanks');
    Route::get('/edit_fillin_blanks','MasterController@edit_fillin_blanks'); 
    Route::post('/edit_fillin_blanks','MasterController@edit_fillin_blanks');

    Route::post('/add_match_pairs','MasterController@add_match_pairs');
    Route::get('/add_match_pairs','MasterController@add_match_pairs');
    Route::get('/edit_match_pairs','MasterController@edit_match_pairs'); 
    Route::post('/edit_match_pairs','MasterController@edit_match_pairs');

    Route::post('/add_alphabet_tracing','MasterController@add_alphabet_tracing');
    Route::get('/add_alphabet_tracing','MasterController@add_alphabet_tracing');
    Route::get('/edit_alphabet_tracing','MasterController@edit_alphabet_tracing'); 
    Route::post('/edit_alphabet_tracing','MasterController@edit_alphabet_tracing');

    Route::post('/add_user','MasterController@add_user');
    Route::get('/add_user','MasterController@add_user');
    Route::post('/edit_user','MasterController@edit_user');
    Route::get('/edit_user','MasterController@edit_user');
    Route::get('/view_user','MasterController@view_user');
     Route::get('/view_user_details','MasterController@view_user_details');

    Route::post('/add_school','MasterController@add_school');
    Route::get('/add_school','MasterController@add_school');
    Route::post('/edit_school','MasterController@edit_school');
    Route::get('/edit_school','MasterController@edit_school');
    Route::get('/view_school','MasterController@view_school');
    Route::get('/view_school_details','MasterController@view_school_details');

    Route::post('/add_chapter','MasterController@add_chapter');
    Route::get('/add_chapter','MasterController@add_chapter');
    Route::post('/edit_chapter','MasterController@edit_chapter');
    Route::get('/edit_chapter','MasterController@edit_chapter');
    Route::get('/view_chapter','MasterController@view_chapter');
    Route::get('/view_chapter_details','MasterController@view_chapter_details');  
    
    Route::post('/add_truefalse','MasterController@add_truefalse');
    Route::get('/add_truefalse','MasterController@add_truefalse');
    Route::post('/edit_truefalse','MasterController@edit_truefalse');
    Route::get('/edit_truefalse','MasterController@edit_truefalse');

    Route::post('/add_branch','MasterController@add_branch');
    Route::get('/add_branch','MasterController@add_branch');
    Route::post('/edit_branch','MasterController@edit_branch');
    Route::get('/edit_branch','MasterController@edit_branch');
    Route::get('/view_branch','MasterController@view_branch');
	
	Route::post('/add_unit','MasterController@add_unit');
    Route::get('/add_unit','MasterController@add_unit');
    Route::post('/edit_unit','MasterController@edit_unit');
    Route::get('/edit_unit','MasterController@edit_unit');
    Route::get('/view_unit','MasterController@view_unit');

	Route::post('/add_codegenerators','MasterController@add_codegenerators');
    Route::get('/add_codegenerators','MasterController@add_codegenerators');
    Route::post('/edit_codegenerators','MasterController@edit_codegenerators');
    Route::get('/edit_codegenerators','MasterController@edit_codegenerators');
    Route::get('/view_codegenerators','MasterController@view_codegenerators');
    Route::get('/view_codegenerators_details','MasterController@view_codegenerators_details'); 
    
});
