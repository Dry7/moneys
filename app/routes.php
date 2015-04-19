<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('as' => 'home', function()
{
    return View::make('hello');
}));

Route::get('logout', array('as' => 'login.logout', 'uses' => 'LoginController@logout'));

Route::group(array('before' => 'un_auth'), function()
{
    Route::get('login', array('as' => 'login.index', 'uses' => 'LoginController@index'));
    Route::get('register', array('as' => 'login.register', 'uses' => 'LoginController@register'));
    Route::post('login', array('uses' => 'LoginController@login'));
    Route::post('register', array('uses' => 'LoginController@store'));
});

Route::group(array('before' => 'admin.auth'), function()
{
    Route::get('dashboard', function()
    {
        $days = DB::select("SELECT date_format(created_at, '%d.%m.%Y') AS `created_at`, SUM(`summ`) as `summ` FROM `payments` GROUP BY date_format(created_at, '%d.%m.%Y') ORDER BY UNIX_TIMESTAMP(created_at) DESC LIMIT 7");
        $sections = DB::select("SELECT `section`, SUM(`summ`) as `summ` FROM `payments` GROUP BY `section` ORDER BY SUM(`summ`) DESC");
        $food = DB::select("SELECT `category`, SUM(`summ`) as `summ` FROM `payments` WHERE `section` = 'Еда' GROUP BY `category` ORDER BY SUM(`summ`) DESC");
        $total = DB::select("SELECT SUM(`summ`) as `summ` FROM `payments`");

        return View::make('login.dashboard', array('days' => $days, 'sections' => $sections, 'food' => $food, 'total' => $total));
    });

    Route::resource('payments', 'PaymentsController');

});

Route::filter('admin.auth', function() 
{
    if (Auth::guest()) {
        return Redirect::to('login');
    }
});

Route::filter('un_auth', function() 
{
    if (!Auth::guest()) {
        Auth::logout();
    }
});