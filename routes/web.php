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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/test', function(){
    dd(bcrypt('admin123'));
});



Route::get('/', 'Client\PageController@index')->name('home');

Route::get('/{cateUrl}/{postUrl}/{cateId}/{postId}.htm', 'Client\PageController@getPostByUrl')->name('single-post');

Route::get('/{cateUrl}/{cateId}.htm', 'Client\PageController@getCateByUrl')->name('category');

Route::get('/search','Client\PageController@getSearch')->name('search');

Route::get('/tag/search/{tag}','Client\PageController@getTag')->name('tag');



Route::get('datatables', 'DatatablesController@getIndex')->name('datatables');
Route::get('datatabless', 'DatatablesController@anyData')->name('datatables.data');


// admin
Route::get('login', 'Admin\LoginController@getLogin');
Route::post('login', 'Admin\LoginController@postLogin')->name('login');
Route::get('logout', 'Admin\LoginController@getLogout');

/*Group router for author and admin */
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){

	Route::get('/', 'Admin\HomeController@getDashboard')->name('dashboard');
	// /* Group for profile */
    Route::get('profile', 'Admin\ProfileController@getProfile');
    Route::post('profile/update', 'Admin\ProfileController@profileUpdate');

    /* Group post*/
    Route::prefix('post')->group(function () {
        Route::get('/', 'Admin\PostController@getList')->name('list-post');
        Route::get('add', 'Admin\PostController@getAdd');
        Route::post('add', 'Admin\PostController@postAdd');
        Route::put('updateStatus', 'Admin\PostController@updateStatus');
        Route::put('updateHot', 'Admin\PostController@updateHot');
        Route::post('add', 'Admin\PostController@postAdd');
        Route::get('update/{id}', 'Admin\PostController@getUpdate');
        Route::post('update/{id}', 'Admin\PostController@postUpdate');
        Route::get('delete/{id}', 'Admin\PostController@getDelete');
    });
    
    /* Group for admin */
    Route::middleware(['role'])->group(function () {
        /* Group category */
        Route::prefix('category')->group(function () {
            Route::get('/', 'Admin\CategoryController@getList');
            Route::get('add', 'Admin\CategoryController@getAdd');
            Route::post('add', 'Admin\CategoryController@postAdd');
            Route::get('data', 'Admin\CategoryController@dataTable')->name('data-cate');
            Route::post('update', 'Admin\CategoryController@postUpdate');
            Route::delete('delete', 'Admin\CategoryController@delete');
        });
    //     /* Group file */
        Route::prefix('tag')->group(function () {
            Route::get('/', 'Admin\TagController@getList')->name('list-tag');
            Route::get('data', 'Admin\TagController@dataTable')->name('data-tag');
            Route::post('add', 'Admin\TagController@postAdd');
            Route::put('update', 'Admin\TagController@putUpdate');
            Route::delete('delete', 'Admin\TagController@delete');
        });
        /* Group author */
        Route::prefix('author')->group(function () {
            Route::get('/', 'Admin\UserController@getList')->name('list-author');
            Route::get('data', 'Admin\UserController@dataTable')->name('data-author');
            Route::post('add', 'Admin\UserController@postAdd');
            Route::delete('delete', 'Admin\UserController@delete');
        });
    });
});

Route::group(['prefix'=>'ajax'], function(){
    Route::get('tag/search', 'AjaxController@searchTag')->name('search-tag');
    Route::get('tag/search/{id}', 'AjaxController@searchTagWithId')->name('search-tag-id');
});