<?php
route::group(['prefix'=>'admin','namespace'=>'admin'],function(){

    Config::set('auth.defines','admin');
    route::get('login','adminAuth@login');
    route::post('login','adminAuth@doLogin');
    route::get('forgotPassword','adminAuth@forgot_password');
    route::post('forgotPassword','adminAuth@forgot_password_post');
    route::get('reset/password/{token}','adminAuth@reset_password');
    route::post('reset/password/{token}','adminAuth@reset_password_post');

route::group(['middleware'=>"admin:admin"],function(){
    route::get('/',function(){
        return view('admin.home');

    });
    route::any('logout','adminAuth@logout');
    });
    route::resource('admin',"adminController");
});
Route::get('lang/{lang}', function ($lang) {
    session()->has('lang')?session()->forget('lang'):'';
    $lang == 'ar'?session()->put('lang', 'ar'):session()->put('lang', 'en');
    return back();
});

 
