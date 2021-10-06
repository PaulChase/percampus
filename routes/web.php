<?php

use App\Http\Controllers\AdvertsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\OpportunitiesController;
use App\Http\Controllers\SubcategoriesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



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

Route::get('/', 'PagesController@index')->name('welcome');
Route::view('/about', 'pages.about');
Route::view('/howto', 'pages.howto');
Route::view('/safety', 'pages.safety');
Route::view('/terms', 'pages.terms');
Route::get('/allcampuses', 'PagesController@getAllCampuses');
Route::view('/post-type', 'pages.pickcategory')->name('pickCategory');
Route::get('/metrics', [PagesController::class, 'showMetricsPage'])->name('metrics');
Route::post('/contactSeller', [PostsController::class, 'contactSeller'])->name('contact.seller');
Route::get('/join', [PagesController::class, 'join'])->name('join');

// // get the subcategories without going through the campus page so therefore the campus is not known
Route::get('s/', [SubcategoriesController::class, 'getSubcategories'])->name('getSubCategories');

// get the posts without going through the campus page so therefore the campus is not known
Route::get('/s/posts', [SubcategoriesController::class, 'getPostsCategory'])->name('getposts.bycategory');


// for marketplace posts
Route::resource('posts', 'PostsController');
Route::post('/submitPost', 'PostsController@store')->name('posts.save');
Route::post('/posts/{id}', 'PostsController@update')->name('posts.toupdate');
Route::delete('/posts/{id}', 'PostsController@destroy')->name('posts.delete');

// for Adverts
Route::get('/ads/create', [AdvertsController::class, 'create']);
Route::get('/ads/edit/{id}', [AdvertsController::class, 'edit']);
Route::put('/ads/update/{id}', [AdvertsController::class, 'update'])->name('ads.update');
Route::delete('/ads/{id}', [AdvertsController::class, 'destroy'])->name('ads.delete');
Route::post('/ads/save', [AdvertsController::class, 'store'])->name('ads.save');

// for opportunities
Route::resource('opportunities', 'OpportunitiesController');
Route::get('opportunities/latest/{categoryName}', [OpportunitiesController::class, 'latest']);

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('home');

Route::get('search', [PostsController::class, 'search']);

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

// these routes should stay here, for some reason if its above, some routes won't work
Route::get('/{campus}', [PagesController::class, 'showCampusPage'])->name('campus.home');
Route::get('/{campusNickName}/{categoryName}/{slug}', [PostsController::class, 'show']);
// Route::get('/{campus}/{subCategoryName}', [PostsController::class, 'byCategory']);



Route::get('/{campus}/library', [PagesController::class, 'library'])->name('library');

// to all the subcategories in that parent category
Route::get('/{campus}/subcategories', [PagesController::class, 'subCategory'])->name('subcategory');

// to all the posts in that category
Route::get('/{campus}/posts', [PostsController::class, 'byCategory'])->name('campus.posts.bycategory');
