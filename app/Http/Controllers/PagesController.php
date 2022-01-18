<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use App\Models\Campus;
use App\Models\Category;
use App\Models\Enquiry;
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
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('checkpoint');
    }


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

        $campuses = Cache::remember('campuses', Carbon::now()->addDay(), function () {
            return Campus::orderBy('name', 'asc')->get();
        });

        $enquiries = Enquiry::where('status', 'active')->orderBy('created_at', 'desc')
            ->take(10)->with('campus')
            ->get()->shuffle();

        $marketplace = Category::find(2);
        $gig = Category::find(4);

        $posts = $marketplace->posts()
            ->where('status', 'active')->with('user', 'images', 'subcategory')->orderBy('created_at', 'desc')
        ->take(10)
        ->get()->shuffle();

        $gigs = $gig->posts()
        ->where(
            'status',
            'active'
        )->with(
            'user',
            'images',
            'subcategory'
        )->orderBy('created_at', 'desc')
        ->take(8)
            ->get()->shuffle();



        // to generate social share links
        $share = new Share;
        $socialLinks = $share->currentPage(null, ['class' => 'text-green-500 text-2xl lg:text-4xl bg-green-50 border-2 border-green-500 rounded-full py-1 px-3'], '<ul class = " flex flex-row justify-around mt-12">', '</ul>')->facebook()->whatsapp()->telegram()->twitter();

        return view('pages.index')
            ->with('social', $socialLinks)
            ->with('posts', $posts)
            ->with('gigs', $gigs)
            ->with('enquiries', $enquiries)
            ->with('campuses', $campuses); // for enquiry form
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
        $recentPosts = $campus->posts()->whereIn('subcategory_id', [1, 2, 3, 4, 5, 6, 7, 8, 9, 13, 14])->where('status', 'active')->orderBy('created_at', 'desc')->with(
            'user',
            'images',
            'subcategory'
        )->take(12)->get();
        //  same as above
        $recentOpportunities = Post::whereIn('subcategory_id', [10, 11, 13])->where('status', 'active')->orderBy('created_at', 'desc')->with(
            'user',
            'images',
            'subcategory'
        )->take(6)->get();

        $recentEnquiries = $campus->enquiries()->where('status', 'active')->orderBy('created_at', 'desc')->take(12)->get();
        
        return view('pages.campus')
            ->with('campus', $campus)
            ->with('recentPosts',  $recentPosts)
            ->with('recentEnquiries',  $recentEnquiries)
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
        $servicesCount = Category::find(4)->posts()->count();

        $mostViewedPosts = Post::select(['title', 'view_count'])->where('created_at', '>',  today()->subDays(7))->orderBy('view_count', 'desc')->take(10)->get();



        $topCampuses = Campus::with('users')->take(10)->get()->sortByDesc(function ($campus) {
            return $campus->users()->count();
        });

        


        $totalPostViews = Post::select(['view_count'])->sum(
            'view_count'
        );
        
        $totalPostContacts = Post::select(['no_of_contacts'])->sum('no_of_contacts');
        $totalEnquiriesContacts = Enquiry::select(['requestCount'])->sum('requestCount');
        $totalAdClicks = Advert::select(['linkclick'])->sum('linkClick');



        // the metrics from the new laravel viewable package

        // today metrics
        $totalViewsToday = DB::table('views')->where('viewed_at', '>=', today())->select('id')->get()->count();
        $uniqueViewsToday = DB::table('views')->where('viewed_at', '>=', today())->select('visitor')->distinct()->get()->count();

        // yesterday metrics
        $totalViewsYesterday = DB::table('views')->whereBetween('viewed_at', [today()->subDay(), today()])->select('id')->get()->count();
        $uniqueViewsYesterday = DB::table('views')->whereBetween('viewed_at', [today()->subDay(), today()])->select('visitor')->distinct()->get()->count();

        // last 7 days metrics
        $totalViewsLast7Days = DB::table('views')->where('viewed_at', '>=', today()->subWeek())->select('id')->get()->count();
        $uniqueViewsLast7Days = DB::table('views')->where('viewed_at', '>=', today()->subWeek())->select('visitor')->distinct()->get()->count();

        // this month metrics
        $totalViewsThisMonth = DB::table('views')->where('viewed_at', '>=', today()->subDays(today()->day))->select('id')->get()->count();
        $uniqueViewsThisMonth = DB::table('views')->where('viewed_at', '>=', today()->subDays(today()->day))->select('visitor')->distinct()->get()->count();

        // overall metrics
        $totalViews = DB::table('views')->select('id')->get()->count();
        $uniqueViews = DB::table('views')->select('visitor')->distinct()->get()->count();


        // dd($uniqueViews);




        return view('pages.metrics', compact('usersCount', 'postsCount', 'marketplaceCount', 'opportunitiesCount', 'totalPostViews', 'mostViewedPosts', 'totalPostContacts', 'referralsCount', 'searchCount', 'totalAdClicks', 'totalEnquiriesContacts', 'topCampuses', 'servicesCount', 'totalViewsToday', 'uniqueViewsToday', 'totalViewsYesterday', 'uniqueViewsYesterday', 'totalViewsLast7Days', 'uniqueViewsLast7Days', 'totalViewsThisMonth', 'uniqueViewsThisMonth', 'totalViews', 'uniqueViews'));
    }

    public function join(Request $request)
    {

        $refererID  = $request->get('refer');

        Cookie::queue('refererID', $refererID, 10080);

        return redirect()->route('welcome');
    }

    public function checkpoint()
    {
        // redirect users back to dashboard if not admin
        if (auth()->user()->role_id != 1) {
            return redirect()->route('home');
        }
        $pendingPosts = Post::where('status', 'pending')->orderBy('created_at')->paginate(10);
        $pendingEnquiries = Enquiry::where('status', 'pending')->orderBy('created_at')->paginate(10);
        return view('pages.checkpoint', compact('pendingPosts', 'pendingEnquiries'));
    }

    // public function pickCategory()
    // {
    //     $categories = Category::orderBy('name')->get();

    //     return view('pages.pickcategory')->with('categories', $categories);
    // }
}
