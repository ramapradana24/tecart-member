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

Route::get('/', function () {
    return view('app');
});


Route::get('/login', function(){
    return view('app');
})->middleware('guest');

Route::get('/register', function () {
    return view('app');
})->where('name', '[\/\w\.-]*');


// Auth::routes();
Route::post('login', 'Auth\LoginController@loginMember')->name('login')->middleware('guest');
Route::get('logout', 'Auth\LoginController@logoutMember')->name('logout');

Route::post('/regist', 'Auth\RegisterController@regist');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function(){
    return redirect(route('profile.index'));
})->middleware('login');

Route::middleware(['login'])->group(function(){
    Route::resource('profile', 'ProfileController');    
    Route::resource('findevent', 'FindEventController');
    Route::post('join', 'FindEventController@join');
    Route::resource('myevent', 'MyEventController');

    #admin
    Route::middleware(['admin'])->group(function(){
        Route::resource('event', 'EventController');
        Route::resource('member', 'MemberController');
        Route::resource('event-validation', 'EventValidationController');
    });
});


