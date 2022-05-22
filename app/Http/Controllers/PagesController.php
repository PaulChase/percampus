<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use App\Models\Campus;
use App\Models\Category;
use App\Models\Enquiry;
use App\Models\Image;
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
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as ImageOptimizer;
use Coderjerk\BirdElephant\BirdElephant;
use Coderjerk\BirdElephant\Compose\Tweet;
use Abraham\TwitterOAuth\TwitterOAuth;
use App\Models\RemotePost;
use Illuminate\Support\Facades\Http;

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
            ->take(20)
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
            ->take(12)
            ->get()->shuffle();



        // to generate social share links
        $share = new Share;
        $socialLinks = $share->currentPage(null, ['class' => 'text-green-500 text-2xl lg:text-4xl bg-green-50 border-2 border-green-500 rounded-full py-1 px-3'], '<ul class = " flex items-center justify-between my-8">', '</ul>')->facebook()->whatsapp()->telegram()->twitter();

        return view('pages.index')
            ->with('social', $socialLinks)
            ->with('posts', $posts)
            ->with('gigs', $gigs)
            ->with('enquiries', $enquiries)
            ->with('campuses', $campuses); // for enquiry form
    }

   

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

        if (auth()->user()->role_id !== 1) {
            return redirect()->route('home')->with('error', 'you are allowed');
        }
        $usersCount = User::select(['id'])->count();

        $postsCount = Post::select(['id'])->count();

        $referralsCount = Referral::select(['id'])->count();

        $searchCount = Search::select(['id'])->count();

        $marketplaceCount = Category::find(2)->posts()->count();

        $opportunitiesCount = Category::find(3)->posts()->count();
        $servicesCount = Category::find(4)->posts()->count();

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


        // new users today
        $newUsersToday = User::where('created_at', '>=', today())->select('id')->get()->count();

        // new users yesterday
        $newUsersYesterday = User::whereBetween('created_at', [today()->subDay(), today()])->select('id')->get()->count();

        // new users last 7 days
        $newUsersLast7Days = User::where('created_at', '>=', today()->subWeek())->select('id')->get()->count();

        // new users this month
        $newUsersThisMonth = User::where('created_at', '>=', today()->subDays(today()->day))->select('id')->get()->count();


        // get number of verified users
        $verifiedUsers = User::verified()->get()->count();






        return view('pages.metrics', compact('usersCount', 'postsCount', 'marketplaceCount', 'opportunitiesCount', 'totalPostViews',  'totalPostContacts', 'referralsCount', 'searchCount', 'totalAdClicks', 'totalEnquiriesContacts', 'topCampuses', 'servicesCount', 'totalViewsToday', 'uniqueViewsToday', 'totalViewsYesterday', 'uniqueViewsYesterday', 'totalViewsLast7Days', 'uniqueViewsLast7Days', 'totalViewsThisMonth', 'uniqueViewsThisMonth', 'totalViews', 'uniqueViews', 'newUsersToday', 'newUsersYesterday', 'newUsersLast7Days', 'newUsersThisMonth', 'verifiedUsers'));
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
        $pendingPosts = Post::where('status', 'pending')->orderBy('created_at')->get();
        $pendingEnquiries = Enquiry::where('status', 'pending')->orderBy('created_at')->get();
        return view('pages.checkpoint', compact('pendingPosts', 'pendingEnquiries'));
    }

    public function massCreate()
    {

        if (auth()->user()->role_id !== 1) {
            return redirect()->back()->with('error', 'you are allowed');
        }
        $subcategories = SubCategory::where('category_id', 2)->get();
        return view('pages.maas-create')->with('subcategories', $subcategories);
    }

    public function massStore(Request $request)
    {

        //  checking if image is set and valid
        if (
            $request->hasFile('images')
        ) {
            // array of all the images uploaded 
            $images = $request->file('images');

            // looping through the submitted images
            foreach ($images as $image) {

                $post =  Post::create([
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'price' => number_format($request->input('price')),
                    'venue' => $request->input('venue'),
                    'contact_info' => ltrim($request->input('contact'), 0),
                    'item_condition' => $request->input('condition'),
                    'in_stock' => $request->input('instock'),
                    'subcategory_id' => $request->input('subcategory'),
                    'user_id' => auth()->id(),
                    'alias' => $request->input('alias'),
                    'alias_campus' => $request->input('alias_campus'),
                    'status' => 'pending',
                ]);

                $thePostId = $post->id;

                $fileNameWithExt = $image->getClientOriginalName();

                // get only the file name
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

                // the name should be the title of the post bcoz of some SEO tactics
                // $fileName = $request->input('title');

                // get the extension e.g .png, .jpg etc
                $extension = $image->getClientOriginalExtension();

                /*
                the filename to store is a combination of the the main file name with a timestamp, then the file extension. The reason is to have a unique filename for every image uplaoded.
                */
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                // the path to store
                $path = $image->getRealPath() . '.jpg';

                // reducing the file size of the image and also optimizing it for fast loading
                $imageResize = ImageOptimizer::make($image);
                $imageResize->resize(1000, 1000, function ($const) {
                    $const->aspectRatio();
                })->encode('jpg', 60);
                $imageResize->save($path);

                // saving it to the s3 bucket and also making it public so my website can access it
                Storage::disk('s3')->put('public/images/' . $fileNameToStore, $imageResize->__toString(), 'public');

                // get the public url from s3
                $url  = Storage::disk('s3')->url('public/images/' . $fileNameToStore);

                // then save the image record to the Db
                $this->saveImage($thePostId, $fileNameToStore, $url);
            }
        }

        return  redirect('/dashboard')->with('success', 'Your Post Has Been Added but is currently being reviewed and will become active very soon');
    }

    // method for saving image to database
    public function saveImage($postId, $name, $path)
    {
        $imagedb = new Image;

        $imagedb->post_id = $postId;
        $imagedb->Image_name = $name;
        $imagedb->Image_path = $path;
        $imagedb->save();
    }

    // public function pickCategory()
    // {
    //     $categories = Category::orderBy('name')->get();

    //     return view('pages.pickcategory')->with('categories', $categories);
    // }

    // just for testing the twitter API package
    public function test()
    {
        // $credentials = array(
        //     'bearer_token' => env('TWITTER_BEARER_TOKEN'), // OAuth 2.0 Bearer Token requests
        //     'consumer_key' =>  env('TWITTER_CONSUMER_KEY'), // identifies your app, always needed
        //     'consumer_secret' => env('TWITTER_CONSUMER_SECRET'), // app secret, always needed
        //     'token_identifier' => env('TWITTER_ACCESS_TOKEN'), // OAuth 1.0a User Context requests
        //     'token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'), // OAuth 1.0a User Context requests
        // );

        // $twitter = new BirdElephant($credentials);

        // // $followers = $twitter->user('ajonyepaul')->followers();

        // $tweets = $twitter->tweets();

        // make connection
        // $connection = new TwitterOAuth(env('TWITTER_CONSUMER_KEY'), env('TWITTER_CONSUMER_SECRET'), env('TWITTER_ACCESS_TOKEN'), env('TWITTER_ACCESS_TOKEN_SECRET'));

        // // set the timeouts incase of network delay
        // $connection->setTimeouts(10, 20);

        // // get trending keywords in nigeria
        // $tweets = $connection->get("/statuses/lookup");

        // $posts =
        //     RemotePost::query()->whereNotIn('subcategory_id', [10, 11, 12])->has('images')->inRandomOrder()->first();

        // dd($posts->subcategory->name);


        $res = Http::get('https://newsapi.org/v2/everything', [
            'q' => 'ASUU',
            'from' => today()->subWeeks(2),
            'apiKey' => env('NEWS_API_KEY'),

        ]);

        dd($res->json());
    }


    


}
