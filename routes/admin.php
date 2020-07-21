<?php


Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

		Config::set('auth.defines', 'admin');
		Route::get('login', 'AdminAuth@login');
		Route::post('login', 'AdminAuth@dologin');
		Route::get('forgot/password', 'AdminAuth@forgot_password');
		Route::post('forgot/password', 'AdminAuth@forgot_password_post');
		Route::get('reset/password/{token}', 'AdminAuth@reset_password');
		Route::post('reset/password/{token}', 'AdminAuth@reset_password_final');
		Route::group(['middleware' => 'admin:admin'], function () {

				Route::resource('admin', 'AdminController');

				Route::resource('users', 'UsersController');

				Route::resource('countries', 'countriesController');
				Route::delete('countries/destroy/all', 'CountriesController@multi_delete');

				Route::resource('departments', 'DepartmentsController');
				Route::delete('departments/destroy/all', 'DepartmentsController@multi_delete');

				Route::resource('manufacturers', 'ManufacturerController');
				Route::delete('manufacturers/destroy/all', 'ManufacturerController@multi_delete');
				
				Route::resource('trademarks', 'trademarksController');
				Route::delete('trademarks/destroy/all', 'trademarksController@multi_delete');
				
				Route::resource('cities', 'CitiesController');
				Route::delete('cities/destroy/all', 'CitiesController@multi_delete');

				Route::resource('states', 'statesController');
				Route::delete('states/destroy/all', 'statesController@multi_delete');

				Route::delete('users/destroy/all', 'UsersController@multi_delete');

				Route::delete('admin/destroy/all', 'AdminController@multi_delete');

				Route::get('/', function () {
						return view('admin.home');
					});

					Route::get('settings', 'Settings@setting');
					Route::post('settings', 'Settings@setting_save');
				Route::any('logout', 'AdminAuth@logout');
			});


            Route::get('lang/{lang}', function ($lang) {
				session()->has('lang')?session()->forget('lang'):'';
				$lang == 'ar'?session()->put('lang', 'ar'):session()->put('lang', 'en');
				return back();
			});
	});