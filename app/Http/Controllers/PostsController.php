<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Category;
use App\Models\Advert;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Image;
use App\Models\Search;
use App\Models\SubCategory;
use App\Notifications\ApprovalEmailNotification;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as ImageOptimizer;

use Jorenvh\Share\Share;
use Illuminate\Support\Facades\Cookie;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Coderjerk\BirdElephant\BirdElephant;
use Coderjerk\BirdElephant\Compose\Tweet;
use Coderjerk\BirdElephant\Compose\Media;
use Abraham\TwitterOAuth\TwitterOAuth;


class PostsController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware(['verified'], ['except' => ['index', 'show', 'byCategory', 'search', 'contactSeller']]);
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$marketplace = Category::find(2);

		// testing queries to rank users based on levels
		// $post = DB::table('posts')->join('users', 'users.id' ,'=', 'posts.user_id'  )->join('roles', 'roles.id', '=','users.role_id')->select('posts.*', 'users.*')->orderBy('roles.id', 'desc')->get();

		// $post2 = Post::join('users', 'users.id', '=', 'posts.user_id')->join('roles', 'roles.id', '=', 'users.role_id')->select('posts.*', 'users.*')->orderBy('roles.id', 'desc')->get();

		$campusId = request('campus');
		$campus = [];
		if ($campusId) {
			$campus = Campus::findOrFail($campusId);
		}

		$subCategory = request('sub_category');

		$posts = $marketplace->posts()->where('status', 'active')->when($campusId, function ($query) use ($campus) {
			$query->whereIn('user_id', $campus->users()->pluck('id'));
		})->when($subCategory, function ($query, $subCategory) {
			$query->where('subcategory_id', $subCategory);
		})->orderBy('created_at', 'desc')->with(
			'user',
			'images',
			'subcategory'
		)->paginate(20);

		return view('posts.index')->with('posts', $posts);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{

		if (Auth::check() and Auth::user()->role_id !== 1) {
			$noOfUserActivePosts = Auth::user()
				->posts()
				->select(['id', 'status'])
				->where('status', 'active')
				->get()
				->count();
			$postLeft = Auth::user()->post_limit - $noOfUserActivePosts;
			if ($postLeft <= 0) {
				return redirect()->route('home')->with('error', 'sorry, you are not allowed to add more posts. Refer your friends to increase your limit');
			}
		}

		return view('posts.add');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{

		$this->validate($request, [
			'title' => 'required|string',
			'description' => 'required|string',
			'images' => 'nullable|max:2', // validate the number of incoming images
			'images.*' => 'mimes:jpeg,jpg,png|max:2048', //validate for file extensions and image size
			'price' => 'required ',
			'subcategory' => 'required|integer',
			'instock' => 'required|string'

		]);

		if (empty($request->input('contact'))) {
			$phoneNo = ltrim(auth()->user()->phone, 0);
		} else {
			$phoneNo = ltrim($request->input('contact'), 0);
		}



		$post = new Post;
		// add post to Database
		$post->title = $request->input('title');
		$post->description = $request->input('description');
		$post->price = number_format($request->input('price'));
		$post->venue = $request->input('venue');
		$post->contact_info = $phoneNo;
		$post->item_condition =  $request->input('condition');
		$post->in_stock = $request->input('instock');
		$post->subcategory_id = $request->input('subcategory');
		$post->user_id = auth()->user()->id;
		$post->status = 'pending';

		// set an alias if its not posted by the actual user
		$post->alias = $request->input('alias');
		$post->alias_campus = $request->input('campus') ? $request->input('campus') : null;
		$post->save();



		// get the ID of the image that was just added to the Db so I can save it to the images table 
		$thePostId = $post->id;

		//  checking if image is set and valid
		if (
			$request->hasFile('images') && (count($request->file('images')) <= 2)
		) {
			// array of all the images uploaded 
			$images = $request->file('images');

			// looping through the submitted images
			foreach ($images as $image) {

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
				Storage::put('public/images/' . $fileNameToStore, $imageResize->__toString(), 'public');

				// get the public url from s3
				$url  = Storage::url('public/images/' . $fileNameToStore);

				// then save the image record to the Db
				$this->saveImage($thePostId, $fileNameToStore, $url);
			}
		} /* else {

			$this->saveImage($thePostId, 'noimage.jpg', ' ');
		} */

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

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($slug)
	{

		// to generate social share links
		$share = new Share;
		$socialLinks = $share->currentPage(null, ['class' => 'text-green-500 text-2xl bg-red-900 border-2 border-gray-300 rounded-full py-2 px-3'], '<ul class = " flex flex-row justify-between">', '</ul>')->facebook()->whatsapp()->telegram()->twitter();



		$post = Post::where('slug', $slug)->with(
			'user',
			'images',
			'subcategory'
		)->firstOrFail();

		OpenGraph::setDescription($post->description);
		OpenGraph::setTitle($post->title);
		OpenGraph::setUrl(url()->full());
		OpenGraph::addProperty('type', 'ecommerce');

		// if the post has at least one image
		if ($post->images->count() > 0) {
			OpenGraph::addImage('https://www.percampus.com' . $post->images()->first()->Image_path);
			TwitterCard::addValue('image', 'https://www.percampus.com' . $post->images()->first()->Image_path);
		}

		TwitterCard::setTitle($post->title);
		TwitterCard::setSite('@percampus_com');
		TwitterCard::setUrl(url()->full());
		TwitterCard::setDescription($post->description);

		// the time interval before recording a new post as seen
		$expiresAt = now()->addHours(3);

		// if the logged in user owns the post, do not record the view so as to avoid spammy views
		if (Auth::check()  && (Auth::user()->id !== $post->user->id) && !Cookie::has($post->slug)) {
			views($post)->cooldown($expiresAt)->record();
		} else if (!(Auth::check()) && !Cookie::has($post->slug)) {
			// only record for guest that hasn't seen the post
			views($post)->cooldown($expiresAt)->record();

			// Cookie::queue($post->slug, 'seen', 120);
			// $post->incrementViewCount();
		}


		// get the logged in user campus ID so as to show ads that is related to their campus
		if (Auth::user()) {
			$campusID = auth()->user()->campus_id;
		} else {
			// or get it from the arguments from the post
			$campusID = $post->user->campus_id;
		}

		$categoryID = $post->subcategory_id;
		$allCampus = 0;
		$allCategory = 0;

		$ads = Advert::whereIn('campus_id',  [$allCampus, $campusID])->whereIn('subcategory_id', [$categoryID, $allCategory])->where('status', 'active')->get();


		// so I can send marketplace posts to the opportunities category
		$marketplace = Category::find(2);

		// get the recent posts from marketplace for the opportunities pages
		$recentPosts = $marketplace->posts()
			->where('status', 'active')
			->orderBy('created_at', 'desc')
			->take(6)
			->get();


		// if the request is an opportunity post, go to opportunity post view
		if ($post->subcategory->category->name == 'opportunities') {
			return view('opportunities.single')
				->with('post', $post)
				->with('social', $socialLinks)
				->with('recentPosts', $recentPosts)
				->with('ads', $ads);
		}

		$similarPosts = Post::where('status', 'active')
			// ->where('created_at', '>',  today()->subDays(7))
			->where('subcategory_id', $post->subcategory->id)
			->with('images')
			->orderBy('created_at', 'desc')
			->take(8)
			->get()
			->shuffle();



		if ($post->subcategory->category->name == 'gigs') {
			return view('gigs.single')
				->with('post', $post)
				->with('social', $socialLinks)
				->with('similarPosts', $similarPosts)
				->with('ads', $ads);
		}



		return view('posts.single')
			->with('post', $post)
			->with('social', $socialLinks)
			->with('ads', $ads)
			->with('similarPosts', $similarPosts);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$post = Post::find($id);

		// check if it is the logged in user that is trying to edit the post
		if (auth()->user()->id !== $post->user_id) {
			return redirect('/dashboard')->with('error', 'You are not allowed to edit this post');
		}

		// if the post is in opportunities category, return the view of the edit opportunity
		if ($post->subcategory->category->name == 'opportunities') {
			return view('opportunities.edit')->with('post', $post);
		}

		return view('posts.edit')->with('post', $post);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'title' => 'required',
			'description' => 'required',
			'images' => 'nullable|max:2', // validate the number of incoming images
			'images.*' => 'mimes:jpeg,jpg,png|max:2048', //validate for file extensions and image size
			'contact' => 'required',
		]);



		//  checking if image is set
		if (
			$request->hasFile('images') && (count($request->file('images')) <= 2)
		) {
			// array of all the images uploaded 
			$images = $request->file('images');

			// looping through the submitted images
			foreach ($images as $image) {

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
				// $path = $image->storeAs('public/images', $fileNameToStore);

				// the path to store
				$path = $image->getRealPath() . '.jpg';

				$imageResize = ImageOptimizer::make($image);
				$imageResize->resize(1000, 1000, function ($const) {
					$const->aspectRatio();
				})->encode('jpg', 60);
				$imageResize->save($path);

				Storage::put('public/images/' . $fileNameToStore, $imageResize->__toString(), 'public');
				$url  = Storage::url('public/images/' . $fileNameToStore);

				// get the record
				$imagedb = Image::where('post_id', $id)->orderBy('updated_at', 'asc')->first();
				// dd($imagedb);



				// checking if the record is in the database
				if ($imagedb != null &&  $imagedb->count() > 0) {

					Storage::delete('public/images/' . $imagedb->Image_name);
					$imagedb->Image_name = $fileNameToStore;
					$imagedb->Image_path = $url;
					$imagedb->save();
				} else {
					$this->saveImage($id, $fileNameToStore, $url);
				}

				// $path = $request->file('avatar')->store('public/images');


			}
		}

		// trim the phpne muber
		if (empty($request->input('contact'))) {
			$phoneNo = ltrim(auth()->user()->phone, 0);
		} else {
			$phoneNo = ltrim($request->input('contact'), 0);
		}


		// add post to Database
		$post = Post::find($id);
		$post->title = $request->input('title');
		$post->description = $request->input('description');
		$post->venue = $request->input('venue');
		$post->price =  number_format($request->input('price'));
		$post->status = 'pending';
		$post->alias = $request->input('alias');
		$post->contact_info = $phoneNo;


		$post->save();

		return  redirect('/dashboard')->with('success', 'Your Post Has Been Updated but is currently being reviewed and will become active very soon');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$post = Post::find($id);

		// check if it is the logged in user that is trying to delete the post
		if (auth()->user()->id !== $post->user_id) {
			return redirect('/dashboard')->with('error', ' you are not allowed to delete this post');
		}

		$images = Image::where('post_id', $id)->get();
		// to delete the post with image from storage
		foreach ($images as $image) {

			Storage::delete('public/images/' . $image->Image_name);
			$image->delete();
		}


		$post->status = 'deleted';
		$post->save();

		return  redirect('/dashboard')->with('success', 'Your Post Has Been deleted');
	}

	// seach form class
	public function search(Request $request)
	{
		$query = trim($request->get('query'));
		$campusID = $request->get('campus');

		// if (Auth::user()) {
		//     $campus = auth()->user()->campus;
		// } else {
		//     $campus = Campus::find($campusID);
		// }

		if ($campusID == null) {
			$results = Post::where('status', 'active')
				->where('title', 'like', "%{$query}%")
				->orderBy('created_at', 'desc')
				->paginate(16);
		} else {
			$campus = Campus::find($campusID);
			$results = $campus->posts()
				->where('status', 'active')
				->where('title', 'like', "%{$query}%")
				->orderBy('created_at', 'desc')
				->paginate(16);
		}





		// save the search query to the database
		$saveQuery = new Search;
		$saveQuery->query = $query;

		// the user_id of zero means guest
		$saveQuery->user_id = Auth::user() ? auth()->user()->id : 0;
		$saveQuery->if_results = $results->count() > 0 ? 'yes' : 'no';

		$saveQuery->save();

		return view('posts.index')->with('query', $query)->with('posts', $results);
	}




	public function contactSeller(Request $request)
	{
		// dd('here');

		$postID = $request->input('postID');
		$post = Post::find($postID);

		// just to make every cookie name unique
		$contactCookie = $postID . $post->slug;

		// don't count if its the owner of the post that clicked the contact button, just to avoid spamming 
		if (Auth::user()  && (Auth::user()->id !== $post->user->id) && !Cookie::has($contactCookie)) {

			Cookie::queue($contactCookie, 'contacted', 1440);
			$post->incrementContactCount();
		} else if (!Cookie::has($contactCookie)) {

			Cookie::queue($contactCookie, 'contacted', 1440);
			$post->incrementContactCount();
		}


		return response()->json(['success' => 'yep']);
	}


	public function screenPost(Request $request)
	{
		if (!auth()->user()->isAdmin()) {
			abort(403);
		}

		$postID = $request->input('postID');
		$status = $request->input('status');
		$type = $request->input('type');

		// checking if it's a post so I can delete the related images if it's rejected
		if ($type == 'post') {

			$post = Post::find($postID);
			$post->status = $status;
			$post->save();

			// // only try to upload posts with images to twitter and delete them if rejected
			// if ($post->images->count() > 0) {

			// 	// make connection
			// 	$connection = new TwitterOAuth(env('TWITTER_CONSUMER_KEY'), env('TWITTER_CONSUMER_SECRET'), env('TWITTER_ACCESS_TOKEN'), env('TWITTER_ACCESS_TOKEN_SECRET'));

			// 	// set the timeouts incase of network delay
			// 	$connection->setTimeouts(10, 20);

			// 	// get trending keywords in nigeria
			// 	$trendingNow = $connection->get("trends/place", ["id" => 1398823]);

			// 	$trendingTopics = [];

			// 	// this if because of how the the data is structured
			// 	foreach ($trendingNow as $hash) {

			// 		$inner = $hash->trends;

			// 		foreach ($inner as $in) {

			// 			$value = $in->name;

			// 			array_push($trendingTopics, $value);

			// 			if (count($trendingTopics) === 15) {
			// 				break;
			// 			}
			// 		}
			// 	}

			// 	shuffle($trendingTopics);

			// 	$trendingKeywords = "{$trendingTopics[0]} {$trendingTopics[1]}";

			// 	$credentials = array(
			// 		'bearer_token' => env('TWITTER_BEARER_TOKEN'), // OAuth 2.0 Bearer Token requests
			// 		'consumer_key' =>  env('TWITTER_CONSUMER_KEY'), // identifies your app, always needed
			// 		'consumer_secret' => env('TWITTER_CONSUMER_SECRET'), // app secret, always needed
			// 		'token_identifier' => env('TWITTER_ACCESS_TOKEN'), // OAuth 1.0a User Context requests
			// 		'token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'), // OAuth 1.0a User Context requests
			// 	);

			// 	$twitter = new BirdElephant($credentials);

			// 	$image = $twitter->tweets()->upload("https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/public/images/{$post->images()->first()->Image_name}");


			// 	$media = (new Media)->mediaIds([$image->media_id_string]);

			// 	$tweet = (new Tweet)->text("title: '{$post->title}'. \r\n \r\n If interested, visit our website for more info: https://www.percampus.com/{$post->user->campus->nick_name}/{$post->subcategory->slug}/{$post->slug} \r\n \r\n {$trendingKeywords} ")->media($media);

			// 	$twitter->tweets()->tweet($tweet);

			// 	// delete the posts images if they are rejected
			// 	if ($status == 'rejected') {

			// 		$images = Image::where('post_id', $postID)->get();

			// 		foreach ($images as $image) {

			// 			Storage::disk('s3')->delete('public/images/' . $image->Image_name);
			// 			$image->delete();
			// 		}
			// 	}
			// }

			//Do not send email if the user is an admin
			if ($post->user->role_id !== 1) {
				$post->user->notify(new ApprovalEmailNotification($post));
			}
		} else {
			$enquiry = Enquiry::find($postID);
			$enquiry->status = $status;
			$enquiry->save();
		}




		return response()->json(['success' => 'status changed']);
	}
}
