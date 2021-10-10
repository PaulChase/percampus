<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Campus;
use App\Models\Post;
use App\Models\SubCategory;



class SubcategoriesController extends Controller
{
    public function getSubCategories(Request $request)
    {
        $mainCategoryID = $request->get('mainCategoryID');
        $mainCategory = Category::find($mainCategoryID);
        
        $subCategories = $mainCategory->subcategories()->orderBy('name')->get();

        return view('pages.getSubCategories')
            ->with('subCategories', $subCategories)
            ->with('mainCategory', $mainCategory);
    }

    public function getPostsCategory( Request $request)
    {

        $categoryName = $request->get('c');
        $mainCategory = $request->get('m');
        if ($mainCategory == 'opportunities') {
            return redirect()->action([OpportunitiesController::class, 'latest'], ['categoryName' => $categoryName]);
        }
        // get the logged user campus
        // if (Auth::user()) {
        //     $campus = auth()->user()->campus;
        // } else {
        //     // or get it from the arguments from the URL
        //     $campus = Campus::where('nick_name', $campusNickName)->firstOrFail();
        // }
        
        $categoryID = SubCategory::where('slug', $categoryName)->value('id');

        // get posts from the campus above the match the category
        $posts = Post::where('subcategory_id', $categoryID)->where('status', 'active')->orderBy('created_at', 'desc')->paginate(16);


        return view('posts.index')->with('posts', $posts)->with('cName', $categoryName);
    }
}