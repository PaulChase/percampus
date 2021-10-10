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



class OpportunitiesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['latest']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function latest($categoryName)
    {
        $category = SubCategory::where('slug', $categoryName)->firstOrFail();
        $posts = $category->posts()->where('status', 'active')->orderBy('created_at', 'desc')->paginate(16);

        return view('opportunities.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // get subcatrgories for Opportunities
        $subcategories = SubCategory::where('category_id', 3)->get();
        return view('opportunities.add')->with('subcategories', $subcategories);
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
            'image.*' => 'mimes:jpeg,jpg,png|max:2048', //validate for file extensions and image size

        ]);



        // dd('yes here');

        $post = new Post;
        // add post to Database
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->price =   $request->input('reward');
        $post->apply_link = $request->input('apply_link');
        $post->apply_deadline = $request->input('deadline');
        $post->subcategory_id = $request->input('subcategory');
        $post->user_id = auth()->user()->id;
        $post->save();

        // get the ID of the image that was just added to the Db so I can save it to the images table 
        $thePostId = Post::latest()->value('id');

        //  checking if image is set and valid
        if (
            $request->hasFile('image')
        ) {
            // array of all the images uploaded 
            $image = $request->file('image');


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
            })->encode('jpg', 80);
            $imageResize->save($path);

            // saving it to the s3 bucket and also making it public so my website can access it
            Storage::disk('s3')->put('public/images/' . $fileNameToStore, $imageResize->__toString(), 'public');

            // get the public url from s3
            $url  = Storage::disk('s3')->url('public/images/' . $fileNameToStore);

            // then save the image record to the Db
            $this->saveImage($thePostId, $fileNameToStore, $url);
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            'image.*' => 'mimes:jpeg,jpg,png|max:2048', //validate for file extensions and image size

        ]);



        // dd('yes here');

        $post = Post::find($id);
        // add post to Database
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->price = $request->input('reward');
        $post->apply_link = $request->input('apply_link');
        $post->apply_deadline = $request->input('deadline');
        $post->save();



        //  checking if image is set and valid
        if (
            $request->hasFile('image')
        ) {
            // array of all the images uploaded 
            $image = $request->file('image');


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
            })->encode('jpg', 80);
            $imageResize->save($path);

            // saving it to the s3 bucket and also making it public so my website can access it
            Storage::disk('s3')->put('public/images/' . $fileNameToStore, $imageResize->__toString(), 'public');

            // get the public url from s3
            $url  = Storage::disk('s3')->url('public/images/' . $fileNameToStore);

            // then save the image record to the Db
            $this->saveImage($id, $fileNameToStore, $url);
        } /* else {

            $this->saveImage($thePostId, 'noimage.jpg', ' ');
        } */

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
        //
    }
}
