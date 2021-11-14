<?php

use App\Http\Controllers\AdvertsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnquiriesController;
use App\Http\Controllers\GigsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\OpportunitiesController;
use App\Http\Controllers\SubcategoriesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

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
Route::get('/metrics', [PagesController::class, 'showMetricsPage'])->name('metrics');
Route::post('/contactSeller', [PostsController::class, 'contactSeller'])->name('contact.seller');
Route::post('/screenpost', [PostsController::class, 'screenPost'])->name('screenpost');
Route::get('/join', [PagesController::class, 'join'])->name('join');
Route::get('/checkpoint', [PagesController::class, 'checkpoint'])->name('checkpoint');
Route::post('/updateprofilepic', [DashboardController::class, 'updateProfilePic'])->name('update.profilepic');
// Route::get('/getuserinfo', function ( Request $request)
// {
//     return view('auth.getuserinfo')->with('name', $request->get('name'));
// })->name('getuserinfo');
Route::view('/getuserinfo', 'auth.getuserinfo')->name('getuserinfo');
Route::post('/pushuserinfo', [DashboardController::class, 'pushUserInfo'])->name('push.userinfo');
// Route::get('createlink', function() {
//     Artisan::call('storage:link');
// });

// // get the subcategories without going through the campus page so therefore the campus is not known
Route::get('s/', [SubcategoriesController::class, 'getSubcategories'])->name('getSubCategories');

// get the posts without going through the campus page so therefore the campus is not known
Route::get('/s/posts', [SubcategoriesController::class, 'getPostsCategory'])->name('getposts.bycategory');


// for marketplace posts
Route::resource('posts', 'PostsController');
Route::post('/submitPost', 'PostsController@store')->name('posts.save');
Route::post('/posts/{id}', 'PostsController@update')->name('posts.toupdate');
Route::delete('/posts/{id}', 'PostsController@destroy')->name('posts.delete');

Route::resource('enquiries', 'EnquiriesController');
Route::post('/enquries/contact', [EnquiriesController::class, 'contactBuyer'])->name('contact.buyer');


// for Adverts
Route::get('/ads/create', [AdvertsController::class, 'create']);
Route::post('/ads/click', [AdvertsController::class, 'adClick'])->name('ad.click');
Route::get('/ads/edit/{id}', [AdvertsController::class, 'edit']);
Route::put('/ads/update/{id}', [AdvertsController::class, 'update'])->name('ads.update');
Route::delete('/ads/{ad}', [AdvertsController::class, 'destroy'])->name('ads.delete');
Route::post('/ads/save', [AdvertsController::class, 'store'])->name('ads.save');

// for opportunities
Route::resource('opportunities', 'OpportunitiesController');
Route::get('opportunities/latest/{categoryName}', [OpportunitiesController::class, 'latest']);

// for gigs
Route::resource('gigs', 'GigsController');
Route::get('gigs/latest/{categoryName}', [GigsController::class, 'latest']);



Auth::routes();

Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/user', [LoginController::class, 'getGoogleUser']);

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
