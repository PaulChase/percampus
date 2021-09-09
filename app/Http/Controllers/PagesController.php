<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\SubCategory;
use Jorenvh\Share\Share;



class PagesController extends Controller
{
    public function index()
    {
        // if the user is logged in, redirect to the user's campus homepage
        if (Auth::User()) {
            return redirect()->route('campus.home', ['campus' => auth()->user()->campus->nick_name]);
        }

        // get the list of all the supported campus
        $campuses = Campus::orderBy('name', 'asc')->get();

        // to generate social share links
        $share = new Share;
        $socialLinks = $share->currentPage(null, ['class' => 'text-white text-2xl bg-gray-600 rounded-full py-2 px-3'], '<ul class = " flex flex-row justify-between">', '</ul>')->facebook()->whatsapp()->telegram()->linkedin()->twitter();

        return view('pages.index')->with('campuses', $campuses)->with('social', $socialLinks);
    }

    // return the about page
    // public function about()
    // {

    //     return view('pages.about');
    // }

    // return the howto page
    // public function howto()
    // {

    //     return view('pages.howto');
    // }

    // public function safety()
    // {

    //     return view('pages.safety');
    // }

    // public function terms()
    // {

    //     return view('pages.terms');
    // }

    public function showCampusPage($campusNickName)
    {
        /*
        check for the logged in user campus nickname instead
        */
        if (Auth::User()) {
            $campusNickName = auth()->user()->campus->nick_name;
        }


        $campus = Campus::where('nick_name', $campusNickName)->firstOrFail();

        $categories = Category::get();
        return view('pages.campus')->with('campus', $campus)->with('categories', $categories);
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


        return view('pages.subcategory')->with('subCategories', $subCategories)->with('campus', $campus)->with('mainCategory', $categoryName);
    }

    public function getAllCampuses()
    {
        $campuses = Campus::orderBy('name')->get();

        return view('pages.allcampuses')->with('campuses', $campuses);
    }

    // public function pickCategory()
    // {
    //     $categories = Category::orderBy('name')->get();

    //     return view('pages.pickcategory')->with('categories', $categories);
    // }
}
