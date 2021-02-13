<?php

//перевірено
Route::get('/', function () {
    return view('welcome');
});

Route::get('/profile/', 'UserController@showProfilePage')->name('profile');
Route::put('/profile/avatar/','UserController@updateAvatar');
Route::put('/profile/avatar-del/','UserController@delAvatar');
//перевірено
Auth::routes();

//перевірено
Route::get('/home', 'HomeController@index')->name('home');
//перевірено
Route::get('/register-as-student', 'CustomRegisterController@registerAsStudent')->name('register-as-student');
//перевірено
Route::get('/register-as-teacher', 'CustomRegisterController@registerAsTeacher')->name('register-as-teacher');
//перевірено
Route::post('/add-student', 'CustomRegisterController@addStudent')->name('add-student');
//перевірено
Route::post('/add-teacher', 'CustomRegisterController@addTeacher')->name('add-teacher');



Route::group(['middleware' => ['role:superadmin']], function () {
    Route::get('/register-cathedraworker', 'CustomRegisterController@registerCathedraworker')->name('register-cathedraworker');
    Route::post('/add-cathedraworker', 'CustomRegisterController@addCathedraworker')->name('add-cathedraworker');
});

Route::group(['middleware' => ['role:student|cathedraworker']], function () {
    //перевірено  
    Route::get('search', array('as'=>'search','uses'=>'SearchController@search'));
    //перевірено
    Route::get('autocomplete2', 'ScienceworkController@autocomplete')->name('autocomplete2');
    Route::get('autocomplete3', 'ScienceworkController@autocomplete2')->name('autocomplete3');
    Route::get('autocompleteGroup', 'ScienceworkController@autocompleteGroup')->name('autocompleteGroup');

    //перевірено
    Route::get('autocomplete', 'ScienceworkController@autocompleteStudent')->name('autocomplete');
});

Route::group(['middleware' => ['role:student']], function () {
    Route::get('/student/work-reviewing', 'ScienceworksController@getWorkReviewingPage')->name('work-reviewing');
    Route::get('/student/work-download', 'ScienceworksController@workDownload')->name('work-download');
    Route::put('/student/work-upload/','ScienceworksController@workUpload')->name('work-upload');
    Route::put('/student/work-del/','ScienceworksController@workDel')->name('work-del');


    //перевірено
    Route::get('/student/show', 'ScienceworksController@showForStudent')->name('show-for-student');
     //перевірено
    Route::get('/student/source-tool', 'ScienceworksController@showSourceTool')->name('source-tool');
     
    Route::post('/student/formulate-source', 'ScienceworksController@sourceTool')->name('formulate-source');
    //перевірено
    Route::get('/student/show-topics', 'ScienceworksController@showTopicsForStudent')->name('show-topics-for-student');
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

    Route::get('student/get-first-page', 'ScienceworksController@getFirstPage');

});

Route::group(['middleware' => ['role:teacher']], function () {
    Route::group(['prefix' => 'teacher'], function () {
        //перевірено
        Route::get('/propose', 'ScienceworkController@proposeTopic')->name('propose-topic-as-teacher');
        //перевірено
        Route::post('/post', 'ScienceworkController@postTopic')->name('post-topic-as-teacher');
        //перевірено
        Route::get('/get-topics', 'ScienceworkController@getTopics')->name('get-topics-as-teacher');
        //перевірено
        Route::get('/show', 'ScienceworksController@showForTeacher')->name('show-for-teacher');
        //перевірено
        Route::get('/edit/{id}', 'ScienceworkController@editScienceworkAsTeacher')->name('edit-sciencework-as-teacher');
        //перевірено
        Route::get('/editTopic/{id}', 'ScienceworkController@editTopicAsTeacher')->name('edit-topic-as-teacher');
        //перевірено
        Route::patch('/update/{id}', 'ScienceworkController@updateScienceworkAsTeacher')->name('update-sciencework-as-teacher');
       //перевірено
        Route::patch('/updateTopic/{id}', 'ScienceworkController@updateTopicAsTeacher')->name('update-topic-as-teacher');
        //перевірено
        Route::patch('/change-status/{id}', 'ScienceworksController@changeStatus')->name('change-status');
       //перевірено
        Route::patch('/disapprove/{id}', 'ScienceworksController@disapproveForStudent')->name('disapprove-for-student'); 
        //перевірено
        Route::delete('/deleteTopic/{id}', 'ScienceworkController@deleteTopicAsTeacher')->name('delete-topic-as-teacher');
    });
});

Route::group(['middleware' => ['role:cathedraworker']], function () {
    Route::group(['prefix' => 'cathedraworker'], function () {
        Route::get('/register', 'ScienceworkController@registerScienceworkAsCathedraworker')->name('register-sciencework-as-cathedraworker');
        Route::post('/add', 'ScienceworkController@addScienceworkAsCathedraworker')->name('add-sciencework-as-cathedraworker');
        //перевірено
        Route::get('/show', 'ScienceworksController@showForCathedraworker')->name('show-for-cathedraworker');
        //перевірено
        Route::patch('/change-status/{id}', 'ScienceworksController@changeStatus')->name('change-status');
        //перевірено
        Route::patch('/disapprove/{id}', 'ScienceworksController@disapproveByCathedraworker')->name('disapprove-by-cathedraworker');
        //перевірено
        Route::get('/edit/{id}', 'ScienceworkController@editScienceworkAsCathedraworker')->name('edit-sciencework-as-cathedraworker');
        //перевірено
        Route::patch('/update/{id}', 'ScienceworkController@updateScienceworkAsCathedraworker')->name('update-sciencework-as-cathedraworker');
        //перевірено
        Route::patch('add-application/{id}', 'ScienceworkController@addApplication')->name('add-application');
        Route::get('/report', 'ScienceworksController@report')->name('report');
        Route::get('/application-report', 'ScienceworksController@applicationReport')->name('application-report');
        Route::get('/app-send-letters','MailController@appSendLetters')->name('app-send-letters');
        Route::get('/works-report', "ScienceworksController@worksReport")->name('works-report');
        Route::get('/works-send-letters','MailController@worksSendLetters')->name('works-send-letters');
        Route::get('/generate-docx', 'HomeController@generateDocx');
        Route::get('/year-report', 'HomeController@returnYearReportView');

    });
}); 