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
	if(Auth::check()) {
		return redirect(route('home'));
	}
	
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function() {
	Route::get('/home', 'HomeController@index')->name('home');

	Route::prefix('activity')->group(function() {
		Route::get('/new', 'ActivityController@newActivity')->name('newActivity');
		Route::get('/edit/{actId}', 'ActivityController@edit')->name('editActivity');
		Route::get('/{actId}', 'ActivityController@show')->name('showActivity');
		Route::post('/save', 'ActivityController@save');
		Route::post('/delete/{rowId}', 'ActivityController@delete');
	});

	Route::get('/activity/list/{typeId}', 'ActivityController@activityTopList')->name('activity.top-list');

	Route::get('/history/{year}/{month?}/{activityType?}', 'ActivityController@history')->name('history');
	Route::post('/history/filter', 'ActivityController@historyFilter');

	Route::prefix('user')->group(function() {
		Route::get('/settings', 'UserController@edit')->name('userSettings');
		Route::get('/{rowId}', 'UserController@show')->name('profile');
		Route::post('/save', 'UserController@save');
	});

	// , 'namespace' => 'Api\V1', 'as' => 'api.'
	Route::group(['prefix' => '/v1'], function () {
		Route::prefix('lists')->group(function() {
		    Route::get('/xp-top-list/{limit?}/{year?}/{month?}', 'HomeController@xpTopList');
		    Route::get('/activity-top-list/{activityType}/{limit?}/{year?}/{month?}', 'HomeController@activityTopList');
		    Route::get('/recentActivities/{activityType?}', 'HomeController@recentActivities');
		});

		Route::prefix('user')->group(function() {
    		Route::get('/activities/{rowId}', 'HomeController@userActivities');
    		Route::get('/unseenAwards', 'UserController@getUnseenAwards');
    		Route::get('/awardsSeen', 'UserController@awardsSeen');
		});

		Route::prefix('activity')->group(function() {
			Route::get('/{rowId}', 'ActivityController@get');
		});
	});

	

	// Route::get('/auth/{service}', 'UserController@connectAPI');
	// Route::get('/auth/{service}/callback', 'UserController@callbackAPI');
	
	Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});

Route::post('/auth/webhooks/strava/activity', 'ActivityController@getActivity');
Route::post('/auth/strava/subscribe', 'ActivityController@stravaSubscription');
Route::get('/auth/strava/subscribe/callback', 'ActivityController@stravaSubscriptionCallback');

