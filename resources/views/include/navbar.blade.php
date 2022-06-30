@php

use App\Models\Campus;
use Illuminate\Support\Carbon;

if (Auth::check()) {
    $noOfUserActivePosts = Auth::user()
        ->posts()
        ->select(['id', 'status'])
        ->where('status', 'active')
        ->get()
        ->count();
    $postLeft = Auth::user()->post_limit - $noOfUserActivePosts;
}

// $campuses = Campus::orderBy('name')->get();
$campuses = Cache::remember('campuses', Carbon::now()->addDay(), function () {
    return Campus::orderBy('name', 'asc')->get();
});

@endphp

<header class="border-b md:flex md:items-center  shadow-md   bg-white">


    <nav id="header" class="w-full">
        <div class="w-full   mx-auto flex flex-wrap items-center justify-between px-3 py-3 md:py-2 lg:p-4 lg:grid lg:grid-cols-8">

            <button class="cursor-pointer lg:col-span-1 lg:float-left " id="openmenu">
                <i class="fa fa-bars fa-2x text-gray-600"></i> <span
                    class=" ml-1 hidden md:inline-block text-lg font-semibold">MENU</span>
            </button>

            <div class="order-1 lg:col-span-1">
                @auth
                    <a class=" uppercase tracking-wide no-underline hover:no-underline font-bold text-green-600 text-2xl "
                        href="{{ route('campus.home', ['campus' => Auth::user()->campus->nick_name]) }}">
                        <b> {{ config('app.name') }} </b>
                    </a>

                @else
                    <a class=" uppercase tracking-wide no-underline hover:no-underline font-bold text-green-600 text-2xl " href="/">
                        <b> {{ config('app.name') }} </b>
                    </a>
                @endauth

            </div>

            {{-- nav link for mobile and small screen devices --}}
            <div class=" fixed   w-full h-full z-30 overflow-auto  hidden  top-0 left-0  "
                style="background-color: rgba(0,0,0,0.7); " id="menu">
                <div
                    class="  order-3   w-4/6 md:w-2/6 h-full  rounded-r-lg bg-white text-base overflow-auto md:text-lg ">

                    {{-- button to close menu --}}
                    <button class=" right-3 top-3 absolute bg-gray-50 rounded-full px-2 py-1 focus:bg-gray-500 "
                        id="closemenu"> <i class="fa fa-times fa-2x text-gray-400"></i></button>
                    @auth
                        <div class=" p-3 text-center">

                            <p class=" my-4"><i class="fa fa-user-circle fa-5x text-green-400"></i></p>

                            <h4 class="font-semibold"> {{ Auth::user()->name }}</h4>
                        </div>

                    @else
                        <div class=" p-3 text-center">
                            <p class=" my-4 text-center"><i class="fa fa-user-circle fa-5x text-green-400"></i></p>
                            <h4 class="font-semibold"> Honourabe Guest</h4>
                        </div>

                    @endauth


                    <ul class="grid grid-cols-1 gap-3  items-center  text-gray-700 pt-4">
                       
                        <li class="md:ml-2 hover:bg-green-100  p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent">
                            <a class="block font-semibold  no-underline hover:no-underline py-2  hover:text-black md:font-medium md:border-none md:p-0 "
                                href="/dashboard"> <span class=""><i
                                        class="fa fa-user-circle mr-2"></i></span>My Profile
                                    </a>
                        </li>
                        <li class=" hover:bg-green-100  p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent">
                            <a class="block font-semibold md:font-medium no-underline hover:no-underline py-2  hover:text-black md:border-none md:p-0 "
                                href="/"> <i class=" fa fa-home text-gray-500 mr-2"></i>Homepage
                                
                            </a>
                        </li>

                        @auth
                            <li class=" hover:bg-green-100  p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent">
                                <a class="block font-semibold md:font-medium no-underline hover:no-underline py-2  hover:text-black md:border-none md:p-0 "
                                    href="{{ route('campus.home', ['campus' => Auth::user()->campus->nick_name]) }}">
                                    <i class=" fa fa-graduation-cap text-gray-500 mr-2"></i>
                                    <span class=" uppercase">{{ Auth::user()->campus->nick_name }} </span> campus
                                </a>
                            </li>
                        @endauth
                        <li class="md:ml-2 hover:bg-green-100  p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent">
                            <a class=" block no-underline py-2 text-grey-darkest hover:text-black md:border-none md:font-medium md:p-0 hover:no-underline font-semibold "
                                href="/allcampuses">
                                <i class=" fa fa-building text-gray-500 mr-2"></i>All Campuses
                                
                            </a>
                        </li>
                        <li class=" hover:bg-green-100  p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent">
                            <a class="block font-semibold md:font-medium no-underline hover:no-underline py-2  hover:text-black md:border-none md:p-0 "
                                href="/about"><i class=" fa fa-bookmark text-gray-500 mr-2"></i>About
                                
                            </a>
                        </li>

                        <li class="md:ml-2 hover:bg-green-100  p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent">
                            <a class=" block no-underline py-2 text-grey-darkest hover:text-black md:border-none md:font-medium md:p-0 hover:no-underline font-semibold "
                                href="/howto">
                                <i class=" fa fa-info-circle text-gray-500 mr-2"></i>how to Use
                                
                            </a>
                        </li>
                        <li class="md:ml-2 hover:bg-green-100  p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent">
                            <a class=" block no-underline py-2 text-grey-darkest hover:text-black md:border-none md:font-medium md:p-0 hover:no-underline font-semibold "
                                href="https://forms.gle/wkVRH7yDWBEKg6QV6" target="_blank">
                                <i class=" fa fa-paper-plane text-gray-500 mr-2"></i>Feedback
                                
                            </a>
                        </li>



                        <!-- Authentication Links -->
                        @guest
                            <li class=" hover:bg-green-100  p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent">
                                <a class="block font-semibold md:font-medium no-underline hover:no-underline py-2  hover:text-black md:border-none md:p-0 "
                                    href="{{ route('getSubCategories', ['mainCategoryID' => 2]) }}"><i
                                        class=" fa fa-shopping-cart text-gray-500 mr-2"></i>Marketplace
                                    
                                </a>
                            </li>
                            <li class=" hover:bg-green-100  p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent">
                                <a class="block font-semibold md:font-medium no-underline hover:no-underline py-2  hover:text-black md:border-none md:p-0 "
                                    href="{{ route('getSubCategories', ['mainCategoryID' => 4]) }}"><i
                                        class=" fa fa-toggle-on text-gray-500 mr-2"></i>Services
                                    
                                </a>
                            </li>
                            <li class=" hover:bg-green-100  p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent">
                                <a class="block font-semibold md:font-medium no-underline hover:no-underline py-2  hover:text-black md:border-none md:p-0 "
                                    href="{{ route('getSubCategories', ['mainCategoryID' => 3]) }}"><i
                                        class=" fa fa-graduation-cap text-gray-500 mr-2"></i>Opportunities
                                    
                                </a>
                            </li>


                            @if (Route::has('login'))
                                <li class="md:ml-2  py-2  ">

                                    <a class="border-2 border-green-400 px-5 py-2 rounded-md font-bold inline-block  md:w-28 text-center hover:bg-green-200 focus:bg-green-200 w-full"
                                        href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="md:ml-2  py-2  ">
                                    <a class="border-2 border-green-400 bg-green-400 px-5 py-2 rounded-md font-bold inline-block  text-center md:w-28 hover:bg-green-500 focus:bg-green-500 w-full"
                                        href="{{ route('register') }}">{{ __('Sign Up') }}</a>
                                </li>
                            @endif


                        @else
                            <li class=" hover:bg-green-100  p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent">
                                <a class="block font-semibold md:font-medium no-underline hover:no-underline py-2  hover:text-black md:border-none md:p-0 "
                                    href="{{ route('subcategory', ['campus' => Auth::user()->campus->nick_name, 'c' => 'marketplace']) }}">
                                    <i class=" fa fa-shopping-cart text-gray-500 mr-2"></i>Marketplace
                                    
                                </a>
                            </li>
                            <li class=" hover:bg-green-100  p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent">
                                <a class="block font-semibold md:font-medium no-underline hover:no-underline py-2  hover:text-black md:border-none md:p-0 "
                                    href="{{ route('subcategory', ['campus' => Auth::user()->campus->nick_name, 'c' => 'gigs']) }}">
                                    <i class=" fa fa-toggle-on text-gray-500 mr-2"></i>Services
                                    
                                </a>
                            </li>
                            <li class=" hover:bg-green-100  p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent">
                                <a class="block font-semibold md:font-medium no-underline hover:no-underline py-2  hover:text-black md:border-none md:p-0 "
                                    href="{{ route('subcategory', ['campus' => Auth::user()->campus->nick_name, 'c' => 'opportunities']) }}">
                                    <i class=" fa fa-graduation-cap text-gray-500 mr-2"></i>Opportunities
                                    
                                </a>
                            </li>


                        @endguest
                    </ul>
                </div>

            </div>

            {{-- nav link for desktop and large screens --}}

            {{-- end of nav links for desktop --}}
            <div class="order-2 md:order-3 lg:order-4 lg:col-span-1 flex items-center justify-center" id="nav-content">
                <button
                    class="inline-block bg-green-500 px-3 py-2 rounded-md text-white text-sm font-bold md:text-base focus:bg-green-600 shadow-inner addPost ">Sell A...
                </button>

            </div>

            <div class="order-3 lg:order-2 w-full  lg:col-span-5  mt-3 md:mt-2 lg:mt-0 @if (Request::is('allcampuses')) {{ 'hidden' }} @endif">
                <form class="  rounded-md lg:grid lg:grid-cols-5 lg:gap-x-2 " action="{{ url('search') }}"
                    method="GET ">
                    @csrf
                    <label class="hidden" for="search-form">Search</label>
                    <input class="px-3 py-2 rounded-md w-full focus:outline-none bg-gray-50 shadow lg:col-span-3"
                        placeholder="search the name of the item e.g mattress" type="text" name="query" >


                    <div class="mt-2 lg:m-0 bg-gray-50 flex lg:col-span-2 ">
                        <select name="campus" id=""
                            class=" p-1 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200 col-span-3 lg:p-2 lg:m-0">
                            <option value="{{ null }}" selected>Pick the Campus to search in...</option>
                            @foreach ($campuses as $campus)
                                <option value="{{ $campus->id }}" class="">{{ $campus->name }}</option>
                            @endforeach
                        </select>

                        <button type="submit" name="submit"
                            class="focus:bg-green-500 bg-gray-50 border-2 border-green-400 focus:text-white rounded-md focus:outline-none text-green-500 p-1 w-12 ml-3 "><i
                                class="fa fa-search  mx-1.5 my-1 cursor-pointer "></i></button>


                </form>
            </div>
        </div>
    </nav>

</header>

<div id="picktype" class=" fixed  w-full h-full z-30 overflow-auto  top-0 left-0 text-center  hidden"
    style="background-color: rgba(0,0,0,0.7); ">
    <div class=" bg-white bottom-0 absolute w-full rounded-t-lg p-4 lg:w-1/3 lg:h-2/3 lg:top-1/3 lg:right-0 lg:rounded-l-md">
        <button class=" float-right m-3 bg-gray-200 px-3 py-1 rounded-full focus:bg-gray-500"
            id="closepicktype">X</button><br>
        @if (Auth::check() and $postLeft <= 0 and Auth::user()->role_id  !== 1 )
            <div>
                <p class=" font-semibold  mt-2">You've reached the Limit of your posts, refer 10 other students with
                    your link below to unlock 5 more additional posts</p><br>
                <input type="text" value="https://www.percampus.com/join?refer={{ Auth::user()->id }}" id="referlink"
                    disabled class=" bg-gray-200 rounded-md w-full overflow-auto  text-center p-2 "> <br>

                <button id="copylink" onclick="copyLink()"
                    class="bg-green-500 my-4 rounded-md shadow-lg px-3 py-2 font-semibold  text-white"><i
                        class="fa fa-link mr-2"></i>Copy Link</button>


            </div>
        @else
            <h3 class=" font-bold text-lg text-center my-5">What type of post do you want to add?</h3>
            <ul class=" text-gray-700 space-y-5 font-semibold mt-4 text-base lg:text-base lg:mt-8">
                    <li><a href="{{ route('posts.create') }}"
                            class=" p-3 font-semibold text-center border-2 border-gray-500 rounded-full block hover:bg-gray-700 hover:text-white subscribed" >
                            <i class="fa fa-bullhorn mr-2"></i> Sell a product</a>
                        </li>
                    <li><a href="{{ route('gigs.create') }}"
                            class=" p-3 font-semibold text-center border-2 border-gray-500 rounded-full block hover:bg-gray-700 hover:text-white subscribed" >
                            <i class="fa fa-toggle-on mr-2"></i> Offer a service</a>
                        </li>
                    
                </ul>
            
        @endif

    </div>
</div>



