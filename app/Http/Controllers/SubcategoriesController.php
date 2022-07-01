<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Campus;
use App\Models\Post;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;
use App\Http\Controllers\GigsController;



class SubcategoriesController extends Controller
{
    public function getSubCategories(Request $request)
    {


        $subCategories = Cache::remember('subcategories', Carbon::now()->addMonths(6), function () {
            return SubCategory::orderBy('name')->get();
        });

        return view('pages.getSubCategories')
        ->with('subCategories', $subCategories);
    }

    // public function getPostsCategory( Request $request)
    // {

    //     $categoryName = $request->get('c');
    //     $mainCategory = $request->get('m');

    //     /*
    //     if the main category is among these below, redirect the request to the latest controller on their respective controller so it can find the posts and render it to the 
    //     */
    //     if ($mainCategory == 'opportunities') {
    //         return redirect()->action([OpportunitiesController::class, 'latest'], ['categoryName' => $categoryName]);
    //     } elseif ($mainCategory == 'gigs') {
    //         return redirect()->action([GigsController::class, 'latest'], ['categoryName' => $categoryName]);
    //     }
    //     // get the logged user campus
    //     // if (Auth::user()) {
    //     //     $campus = auth()->user()->campus;
    //     // } else {
    //     //     // or get it from the arguments from the URL
    //     //     $campus = Campus::where('nick_name', $campusNickName)->firstOrFail();
    //     // }

    //     $category = SubCategory::where('slug', $categoryName)->firstOrFail();

    //     // get posts from the campus above the match the category
    //     $posts = $category->posts()->where('status', 'active')->orderBy('created_at', 'desc')->paginate(20);


    //     return view('posts.index')->with('posts', $posts)->with('cName', $categoryName);
    // }
}
