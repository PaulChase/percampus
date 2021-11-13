<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as ImageOptimizer;
use Illuminate\Support\Facades\Auth;



class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $ads = Advert::get();

        $posts = Auth::user()->posts()->whereIn('status', ['active', 'pending', 'rejected'])->orderBy('created_at', 'desc')->with(
            'user',
            'subcategory'
        )->get();

        $noOfUserActivePosts = Auth::user()->posts()->where('status', 'active')->get()->count();

        if (Auth::user()->referrals->count() >= 10) {

            $user = User::find(Auth::id());
            $user->update(['post_limit' => 10]);
        }

        // $collection = collect($user->posts->where('status', 'active'));

        // $arranged = $collection->sortByDesc('id');

        return view('dashboard')->with('posts', $posts)->with('ads', $ads)->with('noOfUserActivePosts', $noOfUserActivePosts);
    }


    public function pushUserInfo( Request $request)
    {

        // dd('sure');
        $userID = auth()->user()->id;
        $user = User::find($userID);

        // dd($user, $request->input('campus'), $request->input('phone') );

       $user->campus_id = $request->input('campus');
       $user->phone = $request->input('phone');
       $user->save();

       return redirect()->route('home');
    }

    public function updateProfilePic( Request $request)
    {
        // dd('here');
        $this->validate($request, [
            'profilepic.*' => 'mimes:jpeg,jpg,png|max:4048',
        ]);

        if (
            $request->hasFile('profilepic')
        ) {

            $profilepic = $request->file('profilepic');


            // $fileNameWithExt = $profilepic->getClientOriginalName();

            // get only the file name
            $fileName = auth()->user()->name;

            // the name should be the title of the post bcoz of some SEO tactics
            // $fileName = $request->input('title');

            // get the extension e.g .png, .jpg etc
            $extension = $profilepic->getClientOriginalExtension();

            /*
                the filename to store is a combination of the the main file name with a timestamp, then the file extension. The reason is to have a unique filename for every profilepic uplaoded.
                */
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            
            if ($extension == 'png') {
                $path = $profilepic->getRealPath() . '.png';
                
            } else {
                $path = $profilepic->getRealPath() . '.jpg';

            }
            
            // the path to store

            // reducing the file size of the profilepic and also optimizing it for fast loading
            $imageResize = ImageOptimizer::make($profilepic);
            $imageResize->resize(800, 800, function ($const) {
                $const->aspectRatio();
            })->encode('jpg', 60);
            $imageResize->save($path);

            // saving it to the s3 bucket and also making it public so my website can access it
            Storage::disk('local')->put('public/users/' . $fileNameToStore, $imageResize->__toString(), 'public');

            // get the public url from s3
            $url  = Storage::disk('local')->url('public/users/' . $fileNameToStore);

            $user = User::find(auth()->user()->id);
            $user->avatar = $url;
            $user->save();
        }

        return  redirect('/dashboard')->with('success', 'Your Profile Pic Has Been Upated');

        
    }
}
