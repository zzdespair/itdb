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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => 7,
        'redirect_uri' => 'https://itdb.it/callback',
        'response_type' => 'code',
        'scope' => '*',
    ]);
    return redirect('https://passport.it/oauth/authorize?'.$query);
});

Route::get('/callback', function (\Illuminate\Http\Request $request) {
    $http = new GuzzleHttp\Client(['verify' => false]);

    $response = $http->post('https://passport.it/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => 7,
            'client_secret' => 'HjZAJr5TgriT8kT3RtizGfBXGwfg9z9o8cRQsPxQ',
            'redirect_uri' => 'https://itdb.it/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});
