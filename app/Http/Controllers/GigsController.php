<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Post;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as ImageOptimizer;
use Illuminate\Support\Facades\Auth;

class GigsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'], ['except' => ['index', 'latest']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $opportunities = Category::find(4);

        $posts = $opportunities->posts()->where('status', 'active')->orderBy('created_at', 'desc')->with(
            'user',
            'images',
            'subcategory'
        )->paginate(20);

        return view('gigs.index')->with('posts', $posts);
    }

    public function latest($categoryName)
    {
        $category = SubCategory::where('slug', $categoryName)->firstOrFail();
        $posts = $category->posts()->where('status', 'active')->orderBy('created_at', 'desc')->with(
            'user',
            'images',
            'subcategory'
        )->paginate(20);

        return view('gigs.index')->with('posts', $posts);
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
        $subcategories = SubCategory::where('category_id', 4)->get();
        return view('gigs.create')->with('subcategories', $subcategories);
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
        $post->price = number_format($request->input('price'));
        $post->contact_info = $phoneNo;
        $post->subcategory_id = $request->input('subcategory');
        $post->user_id = auth()->user()->id;
        $post->status = 'pending';

        $post->alias = $request->input('alias');
        $post->alias_campus = $request->input('campus') ? $request->input('campus') : null;


        $post->save();

        // get the ID of the image that was just added to the Db so I can save it to the images table. find a better to do this in the future
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
        //
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
