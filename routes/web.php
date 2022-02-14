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
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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
// Route::get('/tweet', [PagesController::class, 'testTwt']);
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

Route::view('/getuserinfo', 'auth.getuserinfo')->name('getuserinfo');
Route::post('/pushuserinfo', [DashboardController::class, 'pushUserInfo'])->name('push.userinfo');

// to run artisan commands in production
Route::get('cache-config', function () {

    try {
        Artisan::call('config:cache');
        return 'config was cached successfully';
    } catch (Exception $e) {
        return $e->getMessage();
    }
});

Route::get('cache-view', function () {

    try {
        Artisan::call('view:cache');
        return 'view was cached successfully';
    } catch (Exception $e) {
        return $e->getMessage();
    }
});

Route::get('cache-route', function () {

    try {
        Artisan::call('route:cache');
        return 'route was cached successfully';
    } catch (Exception $e) {
        return $e->getMessage();
    }
});

 // get the subcategories without going through the campus page so therefore the campus is not known
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
Route::group(['prefix' => 'ads'], function () {
    Route::get('/create', [AdvertsController::class, 'create']);
    Route::post('/click', [AdvertsController::class, 'adClick'])->name('ad.click');
    Route::get('/edit/{id}', [AdvertsController::class, 'edit']);
    Route::put('/update/{id}', [AdvertsController::class, 'update'])->name('ads.update');
    Route::delete('/{ad}', [AdvertsController::class, 'destroy'])->name('ads.delete');
    Route::post('/save', [AdvertsController::class, 'store'])->name('ads.save');
});


// for opportunities
Route::resource('opportunities', 'OpportunitiesController');
Route::get('opportunities/latest/{categoryName}', [OpportunitiesController::class, 'latest']);

// for gigs
Route::resource('gigs', 'GigsController');
Route::get('gigs/latest/{categoryName}', [GigsController::class, 'latest']);



Auth::routes(['verify' => true]);

// email verification links
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// the link the user clicks to verify email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

// for resend the email verification link
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/user', [LoginController::class, 'getGoogleUser']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');

Route::get('search', [PostsController::class, 'search']);

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

// these routes should stay here, for some reason if its above, some routes won't work
Route::get('/{campus}', [PagesController::class, 'showCampusPage'])->name('campus.home');
Route::get('/{campusNickName}/{categoryName}/{slug}', [PostsController::class, 'show']);
// Route::get('/{campus}/{subCategoryName}', [PostsController::class, 'byCategory']);


// not offering library services for now
// Route::get('/{campus}/library', [PagesController::class, 'library'])->name('library');

// to all the subcategories in that parent category
Route::get('/{campus}/subcategories', [PagesController::class, 'subCategory'])->name('subcategory');

// to all the posts in that category
Route::get('/{campus}/posts', [PostsController::class, 'byCategory'])->name('campus.posts.bycategory');
