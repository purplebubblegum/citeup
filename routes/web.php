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

/*
 * Original Namespace Group
 */
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    
    /*
     * Authentication Routes
     */    
    Route::group(['namespace' => 'Auth'], function () {
        Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/logout', 'LoginController@logout')->name('logout');
        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::post('/password/reset', 'ResetPasswordController@reset');
    });
    
    Route::get('/home', 'HomeController@index')->name('home');

});

/*
 * Web Group 
 */
Route::group(['namespace' => 'App\Web'], function () {

    /*
     * Front Subapp 
     */
    Route::group(['namespace' => 'Front\Controllers'], function () {

        Route::get('/', 'FrontController@root')->name('root');
        Route::get('/about', 'FrontController@about')->name('about');
        Route::get('/activities/{t?}', 'FrontController@activities')->name('activities');
        Route::get('/faqs', 'FrontController@faqs')->name('faqs');
        Route::get('/news', 'FrontController@news')->name('news');
        Route::get('/news/{news}/{slug?}', 'FrontController@newsItem')->name('news.item');

    });

    /*
     * Auth Subapp 
     */
    Route::group(['namespace' => 'Auth\Controllers'], function () {

        Route::get('/purplebubblegum', 'LoginController@form')->name('login.form');
        Route::post('/login', 'LoginController@login')->name('login');
        // Route::get('/register', 'RegisterController@form')->name('register.form');
        // Route::post('/register', 'RegisterController@register')->name('register');

    });

    /*
     * Dashboard Subapp 
     */
    Route::group(['namespace' => 'Dashboard\Controllers'], function () {
        
        Route::get('/app/{vue?}', 'DashboardController@index')->name('dashboard')->where('vue', '[\/\w\.-]*');
        
    });

});

Route::get('/coba', function () {
    // return view('coba');
});
