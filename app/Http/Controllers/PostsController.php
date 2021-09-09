<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Category;
use App\Models\Advert;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Image;
use App\Models\Search;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as ImageOptimizer;
use Illuminate\Http\File;
use Jorenvh\Share\Share;

// use Spatie\Image\Image as SpatieImage;



class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'byCategory']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campus = auth()->user()->campus;
        $post = $campus->posts()->where('status', 'active')->orderBy('created_at', 'desc')->paginate(12);

        return view('posts.index')->with('posts', $post);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subcategories = SubCategory::get();
        return view('posts.add')->with('subcategories', $subcategories);
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
            'title' => 'required',
            'description' => 'required',
            'images' => 'nullable|max:2', // validate the number of incoming images
            'images.*' => 'mimes:jpeg,jpg,png|max:2048', //validate for file extensions and image size
            'price' => 'required '

        ]);

        // default since there is only one category
        if (empty($request->input('contact'))) {
            $phoneNo = ltrim(auth()->user()->phone, 0);
        } else {
            $phoneNo = ltrim($request->input('contact'), 0);
        }



        $post = new Post;
        // add post to Database
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->price = $request->input('price');
        $post->venue = $request->input('venue');
        $post->contact_info = $phoneNo;
        $post->item_condition =  $request->input('condition');
        $post->in_stock = $request->input('instock');
        $post->subcategory_id = $request->input('subcategory');
        $post->user_id = auth()->user()->id;
        $post->save();

        // get the ID of the image that was just added to the Db so I can save it to the images table 
        $thePostId = Post::latest()->value('id');

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
                })->encode('jpg', 80);
                $imageResize->save($path);

                // saving it to the s3 bucket and also making it public so my website can access it
                Storage::disk('s3')->put('public/images/' . $fileNameToStore, $imageResize->__toString(), 'public');

                // get the public url from s3
                $url  = Storage::disk('s3')->url('public/images/' . $fileNameToStore);

                // then save the image record to the Db
                $this->saveImage($thePostId, $fileNameToStore, $url);
            }
        } /* else {

            $this->saveImage($thePostId, 'noimage.jpg', ' ');
        } */

        return  redirect('/dashboard')->with('success', 'Your Post Has Been Added');
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
    public function show($campusNickName, $categoryName, $slug)
    {

        // to generate social share links
        $share = new Share;
        $socialLinks = $share->currentPage(null, ['class' => 'text-white text-2xl bg-gray-600 rounded-full py-2 px-3'], '<ul class = " flex flex-row justify-between">', '</ul>')->facebook()->whatsapp()->telegram()->twitter();


        $post = Post::where('slug', $slug)->firstOrFail();

        // get the logged in user campus ID
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

        return view('posts.single')->with('post', $post)->with('social', $socialLinks)->with('ads', $ads);
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
            'price' => 'required ',
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
                })->encode('jpg', 80);
                $imageResize->save($path);

                Storage::disk('s3')->put('public/images/' . $fileNameToStore, $imageResize->__toString(), 'public');
                $url  = Storage::disk('s3')->url('public/images/' . $fileNameToStore);

                // get the record
                $imagedb = Image::where('post_id', $id)->orderBy('updated_at', 'asc')->firstOrFail();


                // checking if the record is in the database
                if ($imagedb->count() > 0) {

                    Storage::disk('s3')->delete('public/images/' . $imagedb->Image_name);
                    $imagedb->Image_name = $fileNameToStore;
                    $imagedb->Image_path = $url;
                    $imagedb->save();
                } else {
                    $this->saveImage($id, $fileNameToStore, $path);
                }

                // $path = $request->file('avatar')->store('public/images');


            }
        }
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
        $post->price = $request->input('price');
        $post->contact_info = $phoneNo;


        $post->save();

        return  redirect('/dashboard')->with('success', 'Your Post Has Been updated');
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
            if ($image->Image_name != 'noimage.jpg') {
                Storage::disk('s3')->delete('public/images/' . $image->Image_name);
            }
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


        $campus = auth()->user()->campus;
        $results = $campus->posts()->where('status', 'active')->where('title', 'like', "%{$query}%")->orderBy('created_at', 'desc')->paginate(5);

        // save the search query to the database
        $saveQuery = new Search;
        $saveQuery->query = $query;
        $saveQuery->user_id = auth()->user()->id;
        $saveQuery->if_results = $results->count() > 0 ? 'yes' : 'no';

        $saveQuery->save();

        return view('posts.index')->with('query', $query)->with('posts', $results);
    }

    public function byCategory($campusNickName,  Request $request)
    {

        $categoryName = $request->get('c');
        // get the logged user campus
        if (Auth::user()) {
            $campus = auth()->user()->campus;
        } else {
            // or get it from the arguments from the URL
            $campus = Campus::where('nick_name', $campusNickName)->firstOrFail();
        }

        $categoryID = SubCategory::where('slug', $categoryName)->value('id');

        // get posts from the campus above the match the category
        $posts = $campus->posts()->where('subcategory_id', $categoryID)->where('status', 'active')->orderBy('created_at', 'desc')->paginate(16);


        return view('posts.index')->with('posts', $posts)->with('cName', $categoryName);
    }
}