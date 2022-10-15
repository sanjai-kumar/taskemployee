<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'EmployeeController@index')->name('home');

Route::get('/employee/create', 'EmployeeController@Create')->name('create');

Route::post('employee/store', 'EmployeeController@Store')->name('Store');

Route::post('employee/update', 'EmployeeController@Update')->name('update');

Route::get('/employee/edit/{id}','EmployeeController@Edit')->name('edit');

Route::get('/employee/delete/{id}','EmployeeController@Delete')->name('delete');

Route::get('/employee/show/{id}','EmployeeController@Show')->name('show');

Route::get('/employee/Employee_search','EmployeeController@EmployeeSearch')->name('EmployeeSearch');

Route::post('/employee/Employee_Export','EmployeeController@Employee_Export')->name('Employee_Export');

Route::get('test', function () {

    $user = [
        'name' => 'Sanjai Kumar',
        'info' => 'Laravel & Python Devloper'
    ];

    \Mail::to('msanjai3197@gmail.com')->send(new \App\Mail\NewMail($user));

    return \Redirect::to('/home')->with(array('message' => 'Successfully Sent Mail !', 'note_type' => 'success') );
});

Auth::routes(['verify' => true]);

Route::get('/home', 'EmployeeController@index')->middleware('verified');