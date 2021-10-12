<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use Illuminate\Http\Request;
use App\Models\User;
// use App\Models\Post;
use Illuminate\Support\Collection;

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
        $user_id = auth()->user()->id;
        $user = User::find($user_id);

        $ads = Advert::where('status', 'active')->get();

        $posts = $user->posts()->orderBy('created_at', 'desc' )->get();
        // $collection = collect($user->posts->where('status', 'active'));

        // $arranged = $collection->sortByDesc('id');

        return view('dashboard')->with('posts', $posts )->with('ads', $ads);
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
}
