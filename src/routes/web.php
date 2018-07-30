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

Route::group(['middleware' => ['web']], function () {
	Route::get('/', 'HomeController@index')->name('home.index');
	Route::resource('alerts', 'AlertsController');
	Route::resource('search', 'SearchController');
	Route::resource('agencies', 'AgencySubElementsController');
	Route::resource('listings', 'ListingsController');
	Route::resource('clearances', 'SecurityClearancesController');
	Route::resource('careers', 'OccupationalSeriesController');
	Route::resource('locations', 'LocationsController');
	Route::resource('plans', 'PayPlansController');
	Route::resource('schedules', 'PositionSchedulesController');
	Route::resource('travels', 'TravelPercentagesController');
	Route::resource('paths', 'HiringPathsController');
	Route::get(config('job-core.most_route'), 'MostController@index')->name('most.index');
	Route::get(config('job-core.specific_route'), 'SpecificController@index')->name('specific.index');
	Route::get(config('job-core.affiliate_route'), 'AffiliateController@index')->name('affiliate.index');
	Route::get('/contact', 'ContactController@create')->name('contact.create');
	Route::post('/contact', 'ContactController@store')->name('contact.store');
	Route::get('/about', 'PagesController@about')->name('pages.about');
	Route::get('/advertise', 'PagesController@advertise')->name('pages.advertise');
	Route::get('/disclaimer', 'PagesController@disclaimer')->name('pages.disclaimer');
	Route::get('/newsletter', 'PagesController@newsletter')->name('pages.newsletter');
	Route::get('/privacy', 'PagesController@privacy')->name('pages.privacy');
	Route::get('/terms', 'PagesController@terms')->name('pages.terms');
	Route::get('/sitemap.xml', 'SitemapController@index')->name('sitemap');

    Auth::routes();
});