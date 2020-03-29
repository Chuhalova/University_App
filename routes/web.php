<?php

//перевірено
Route::get('/', function () {
    return view('welcome');
});

//перевірено
Auth::routes();

//перевірено
Route::get('/home', 'HomeController@index')->name('home');
//перевірено
Route::get('/register-as-student', 'CustomRegisterController@registerAsStudent')->name('register-as-student');
//перевірено
Route::get('/register-as-teacher', 'CustomRegisterController@')->name('register-as-teacher');
//перевірено
Route::post('/add-student', 'CustomRegisterController@addStudent')->name('add-student');
//перевірено
Route::post('/add-teacher', 'CustomRegisterController@addTeacher')->name('add-teacher');



Route::group(['middleware' => ['role:superadmin']], function () {
    Route::get('/register-cathedraworker', 'CustomRegisterController@registerCathedraworker')->name('register-cathedraworker');
    Route::post('/add-cathedraworker', 'CustomRegisterController@addCathedraworker')->name('add-cathedraworker');
});

Route::group(['middleware' => ['role:student']], function () {
    //перевірено
    Route::get('/student/show', 'ScienceworksController@showForStudent')->name('show-for-student');
    //перевірено  
    Route::get('search', array('as'=>'search','uses'=>'SearchController@search'));
    //перевірено
    Route::get('autocomplete2', 'ScienceworkController@autocomplete')->name('autocomplete2');
    //перевірено
    Route::get('/register-sciencework-as-student', 'ScienceworkController@registerScienceworkAsStudent')->name('register-sciencework-as-student');
   //перевірено
    Route::post('/add-sciencework-as-student', 'ScienceworkController@addScienceworkAsStudent')->name('add-sciencework-as-student');
    //перевірено
    Route::get('/student/edit/{id}', 'ScienceworkController@editScienceworkAsStudent')->name('edit-sciencework-as-student');
    //перевірено
    Route::patch('/student/update/{id}', 'ScienceworkController@updateScienceworkAsStudent')->name('update-sciencework-as-student');
    //перевірено
    Route::delete('/student/delete/{id}', 'ScienceworkController@deleteScienceworkAsStudent')->name('delete-sciencework-as-student');
});

Route::group(['middleware' => ['role:teacher']], function () {
    Route::group(['prefix' => 'teacher'], function () {
        //перевірено
        Route::get('/show', 'ScienceworksController@showForTeacher')->name('show-for-teacher');
        //перевірено
        Route::get('/edit/{id}', 'ScienceworkController@editScienceworkAsTeacher')->name('edit-sciencework-as-teacher');
         //перевірено
        Route::patch('/update/{id}', 'ScienceworkController@updateScienceworkAsTeacher')->name('update-sciencework-as-teacher');
       //перевірено
        Route::patch('/change-status/{id}', 'ScienceworksController@changeStatus')->name('change-status');
       //перевірено
        Route::patch('/disapprove/{id}', 'ScienceworksController@disapproveForStudent')->name('disapprove-for-student'); 
    });
});

Route::group(['middleware' => ['role:cathedraworker']], function () {
    Route::group(['prefix' => 'cathedraworker'], function () {
        Route::get('/show-approved', 'CathedraworkersController@showApproved')->name('show-approved');
        Route::get('/show-active', 'CathedraworkersController@showActive')->name('show-active');
        
        // Route::patch('/change-status/{id}', 'TeachersController@changeStatus')->name('change-status');
        // Route::delete('/delete/{id}', 'TeachersController@delete')->name('delete');
        // Route::get('/show-approved', 'TeachersController@showApproved')->name('show-approved');
    });
}); 