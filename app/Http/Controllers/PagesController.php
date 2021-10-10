<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Post;
use App\Models\Referral;
use App\Models\Search;
use App\Models\SubCategory;
use App\Models\User;
use Jorenvh\Share\Share;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;

class PagesController extends Controller
{
    public function index()
    {
        // if the user is logged in, redirect to the user's campus homepage
        // if (Auth::User()) {
        //     return redirect()->route('campus.home', ['campus' => auth()->user()->campus->nick_name]);
        // }
        // $name = 'chase';

        // if (Auth::User()) {
        //     return redirect()->to('https://google.'. $name . 'paul' );
        // }

        // get the list of all the supported campus
        // $campuses = Campus::orderBy('name', 'asc')->get();
        // $campuses = Cache::remember('campuses', Carbon::now()->addDay(), function () {
        //          return Campus::orderBy('name', 'asc')->get();
        //     });

        $marketplace = Category::find(2);
            
        $posts = $marketplace->posts()
                    ->where('status', 'active')
                    ->get()
                    ->shuffle()
                    ->take(10);
        
        

        // to generate social share links
        $share = new Share;
        $socialLinks = $share->currentPage(null, ['class' => 'text-green-500 text-2xl bg-green-50 border-2 border-green-500 rounded-full py-1 px-3'], '<ul class = " flex flex-row justify-between">', '</ul>')->facebook()->whatsapp()->telegram()->twitter();

        return view('pages.index')
            ->with('social', $socialLinks)
            ->with('posts', $posts);
    }

    // return the about page
    // public function about()
    // {

    //     return view('pages.about');
    // }

    // return the howto page
    // public function howto()
    // {

    //     return view('pages.howto');
    // }

    // public function safety()
    // {

    //     return view('pages.safety');
    // }

    // public function terms()
    // {

    //     return view('pages.terms');
    // }

    public function showCampusPage($campusNickName)
    {
        /*
        check for the logged in user campus nickname instead
        */
        // if (Auth::User()) {
        //     $campusNickName = auth()->user()->campus->nick_name;
        // }


        $campus = Campus::where('nick_name', $campusNickName)->firstOrFail();
        // $campus = Cache::remember('campus', Carbon::now()->addDay(), function ($campusNickName) {
        //          return Campus::where('nick_name', $campusNickName)->firstOrFail();
        //     });

        // $categories = Category::get();
        // $categories = Cache::remember('categories', Carbon::now()->addDay(), function () {
        //          return Category::get();
        //     });

        
            // find a better to do this stuff oo
        $recentPosts = $campus->posts()->whereIn('subcategory_id', [1,2,3,4,5,6,7,8,9,13,14])->where('status', 'active')->orderBy('created_at', 'desc')->get()->take(12);
            //  same as above
        $recentOpportunities =Post::whereIn('subcategory_id', [10,11,13])->where('status', 'active')->orderBy('created_at', 'desc')->get()->take(6);
        // dd($recentPosts);
        return view('pages.campus')
                ->with('campus', $campus)
                ->with('recentPosts',  $recentPosts)
                ->with('recentOpportunities',  $recentOpportunities);
    }

    public function library($campus)
    {
        return view('pages.library')->with('campus', $campus);
    }

    public function subcategory($campusNickName, Request $request)
    {
        $categoryName = $request->get('c');

        $campus = Campus::where('nick_name', $campusNickName)->firstOrFail();

        $category = Category::where('name', $categoryName)->firstOrFail();

        $subCategories = $category->subcategories()->orderBy('name')->get();

        // dd($campus);
        return view('pages.subcategory')
                ->with('subCategories', $subCategories)
                ->with('campus', $campus)
                ->with('mainCategory', $category);
    }

    public function getAllCampuses()
    {
        $campuses = Cache::remember('campuses', Carbon::now()->addDay(), function () {
                 return Campus::orderBy('name', 'asc')->get();
            });
        // $campuses = Campus::orderBy('name')->get();

        return view('pages.allcampuses')->with('campuses', $campuses);
    }

    public function showMetricsPage()
    {
        
        $usersCount = User::select(['id'])->count();

        $postsCount = Post::select(['id'])->count();

        $referralsCount = Referral::select(['id'])->count();

        $searchCount = Search::select(['id'])->count();

        $marketplaceCount = Category::find(2)->posts()->count();

        $opportunitiesCount = Category::find(3)->posts()->count();

        $mostViewedPosts = Post::select(['title','view_count'])->orderBy('view_count', 'desc')->get()->take(10);

        $totalPostViews = Post::select(['view_count'])->sum('view_count');
        $totalPostContacts = Post::select(['no_of_contacts'])->sum('no_of_contacts');

        // dd($mostViewedPosts);
       


        return view('pages.metrics', compact('usersCount', 'postsCount', 'marketplaceCount', 'opportunitiesCount', 'totalPostViews', 'mostViewedPosts', 'totalPostContacts', 'referralsCount', 'searchCount'));
    }

    public function join(Request $request)
    {

        $refererID  = $request->get('inviter');
        
        Cookie::queue('refererID', $refererID, 10080);

        return redirect()->route('welcome');
    }

    // public function pickCategory()
    // {
    //     $categories = Category::orderBy('name')->get();

    //     return view('pages.pickcategory')->with('categories', $categories);
    // }
}
