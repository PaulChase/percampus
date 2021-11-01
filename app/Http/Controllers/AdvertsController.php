<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use App\Models\Campus;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as ImageOptimizer;
use Illuminate\Support\Facades\Cookie;


class AdvertsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->role_id !== 1) {
            return  redirect('/dashboard')->with('error', 'you are not allowed to create Ads yet');
        }
        $campus = Campus::get();
        $categories = SubCategory::get();
        return view('ads.create')->with('campuses', $campus)->with('subcategories', $categories);
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
            'url' => 'required',
            'subcategory' => 'required',
            'image' => 'mimes:jpeg,jpg,png | max:2048', //validate for file extensions and image size

        ]);

        //  checking if image is set and valid
        if (
            $request->hasFile('image')
        ) {
            $image = $request->file('image');

            $fileNameWithExt = $image->getClientOriginalName();

            // get only the file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            // get the extension e.g .png, .jpg etc
            $extension = $image->getClientOriginalExtension();

            /*
            the filename to store is a combination of the the main file name with a timestamp, then the file extension. The reason is to have a unique filename for every image uplaoded.
            */
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

            // $path = $image->storeAs('public/images', $fileNameToStore);

            // the path to store
            $path = $image->getRealPath() . '.jpg';

            // reducing the file size of the image and also optimizing it for fast loading
            $imageResize = ImageOptimizer::make($image);
            $imageResize->resize(1000, 1000, function ($const) {
                $const->aspectRatio();
            })->encode('jpg', 80);
            $imageResize->save($path);

            // saving it to the s3 bucket and also making it public so my website can access it
            Storage::disk('s3')->put('public/ads/' . $fileNameToStore, $imageResize->__toString(), 'public');

            // get the public url from s3
            $url  = Storage::disk('s3')->url('public/ads/' . $fileNameToStore);
        }


        $ad = new Advert();
        // add post to Database
        $ad->title = $request->input('title');
        $ad->link = $request->input('url');
        $ad->campus_id = $request->input('campus');
        $ad->subcategory_id = $request->input('subcategory');
        $ad->image_url = $url;
        $ad->status = 'active';
        $ad->position = $request->input('position');

        $ad->user_id = auth()->user()->id;

        $ad->save();

        return  redirect('/dashboard')->with('success', 'Your Ad Has gone Live, GoodLuck');
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
        $ad = Advert::find($id);

        $campus = Campus::get();
        $categories = SubCategory::get();

        // check if it is the logged in user that is trying to edit the post
        if (auth()->user()->role_id !== 1) {
            return redirect('/dashboard')->with('error', 'You are not allowed to edit this ad');
        }

        return view('ads.edit')->with('ad', $ad)->with('campuses', $campus)->with('subcategories', $categories);
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
            'url' => 'required',
            'subcategory' => 'required',
            'image' => 'mimes:jpeg,jpg,png | max:2048', //validate for file extensions and image size

        ]);

        $ad = Advert::find($id);
        // add post to Database
        $ad->title = $request->input('title');
        $ad->link = $request->input('url');
        $ad->campus_id = $request->input('campus');
        $ad->subcategory_id = $request->input('subcategory');
        $ad->position = $request->input('position');
        $ad->user_id = auth()->user()->id;

        //  checking if image is set and valid
        if (
            $request->hasFile('image')
        ) {
            $image = $request->file('image');

            $fileNameWithExt = $image->getClientOriginalName();

            // get only the file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            // get the extension e.g .png, .jpg etc
            $extension = $image->getClientOriginalExtension();

            /*
            the filename to store is a combination of the the main file name with a timestamp, then the file extension. The reason is to have a unique filename for every image uplaoded.
            */
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

            // $path = $image->storeAs('public/images', $fileNameToStore);

            // the path to store
            $path = $image->getRealPath() . '.jpg';

            // reducing the file size of the image and also optimizing it for fast loading
            $imageResize = ImageOptimizer::make($image);
            $imageResize->resize(1000, 1000, function ($const) {
                $const->aspectRatio();
            })->encode('jpg', 80);
            $imageResize->save($path);

            // saving it to the s3 bucket and also making it public so my website can access it
            Storage::disk('s3')->put('public/ads/' . $fileNameToStore, $imageResize->__toString(), 'public');

            // get the public url from s3
            $url  = Storage::disk('s3')->url('public/ads/' . $fileNameToStore);
            $ad->image_url = $url;
        }

        $ad->save();

        return  redirect('/dashboard')->with('success', 'The Ad Has Been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Advert $ad)
    {
        // $ad->update(['status' => 'deleted']);
        $status =  $request->input('status');
        $ad->status = $status;
        $ad->save();

        return redirect()->route('home');
    }

    public function adClick(Request $request)
    {
        $adID = $request->input('adID');
        $ad = Advert::find($adID);


        if (!Cookie::has($ad->title)) {

            Cookie::queue($ad->title, 'clicked', 120);
            $ad->incrementAdClick();
        }
    }
}
