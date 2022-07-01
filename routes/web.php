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
use App\Models\Post;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use TCG\Voyager\Facades\Voyager;

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
Route::view('/about-us', 'pages.about');
Route::get('/test', [PagesController::class, 'test']);
Route::view('/howto', 'pages.howto');
Route::view('/safety', 'pages.safety');
Route::view('/terms', 'pages.terms');
Route::get('/allcampuses', [PagesController::class, 'getAllCampuses']);

Route::post('/screenpost', [PostsController::class, 'screenPost'])->name('screenpost');
Route::get('/join', [PagesController::class, 'join'])->name('join');

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

Auth::routes(['verify' => true]);

Route::get('/posts', [PostsController::class, 'index'])->name('posts.index');
Route::get('search',  [PostsController::class, 'search']);
Route::post('/contactSeller', [PostsController::class, 'contactSeller'])->name('contact.seller');
Route::get('/post/{slug}', [PostsController::class, 'show'])->name('posts.show');


// get the subcategories without going through the campus page so therefore the campus is not known
Route::get('/sub-categories', [SubcategoriesController::class, 'getSubcategories'])->name('getSubCategories');


Route::get('/campus/{campus}', [PagesController::class, 'showCampusPage'])->name('campus.home');


Route::middleware(['auth'])->group(function () {

    Route::get('/metrics', [PagesController::class, 'showMetricsPage'])->name('metrics');
    Route::get('/checkpoint', [PagesController::class, 'checkpoint'])->name('checkpoint');
    Route::get('dashboard/mass-create', [PagesController::class, 'massCreate'])->name('mass.create');
    Route::post('dashboard/mass-create', [PagesController::class, 'massStore'])->name('mass.store');

    Route::post('/update-profile-pic', [DashboardController::class, 'updateProfilePic'])->name('update.profilepic');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');
    Route::get('dashboard/posts', [DashboardController::class, 'userPosts'])->name('user.posts');
    // for users that signed up using google login
    Route::view('/getuserinfo', 'auth.getuserinfo')->name('getuserinfo');
    Route::post('/pushuserinfo', [DashboardController::class, 'pushUserInfo'])->name('push.userinfo');

    // for marketplace posts
    Route::get('/posts/create', [PostsController::class, 'create'])->name('posts.create');
    Route::get('/posts/{id}/edit', [PostsController::class, 'edit'])->name('posts.edit');
    Route::post('/posts/store', [PostsController::class, 'store'])->name('posts.store');
    Route::put('/posts/{id}', [PostsController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}', [PostsController::class, 'destroy'])->name('posts.delete');

    

    // get the posts without going through the campus page so therefore the campus is not known
    // Route::get('/s/posts', [SubcategoriesController::class, 'getPostsCategory'])->name('getposts.bycategory');

    Route::resource('enquiries', 'EnquiriesController');
    Route::post('/enquries/contact', [EnquiriesController::class, 'contactBuyer'])->name('contact.buyer');

    // for Adverts
    Route::group(['prefix' => 'ads'], function () {
        Route::get('/create', [
            AdvertsController::class, 'create'
        ]);
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
    Route::get(
        'gigs/latest/{categoryName}',
        [GigsController::class, 'latest']
    );

    // email verification links
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    // the link the user clicks to verify email
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('home');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    // for resend the email verification link
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return redirect()->route('home')->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/auth/google/user', [LoginController::class, 'getGoogleUser']);



    Route::group(['prefix' => 'admin'], function () {
        Voyager::routes();
    });


});

 
