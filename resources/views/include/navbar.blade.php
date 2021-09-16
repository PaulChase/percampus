@php
    use App\Models\Category;
    $categories = Category::get();
@endphp

<header class="border-b md:flex md:items-center md:justify-between shadow-md md:py-2  bg-white">
  
    
    <nav id="header" class="w-full">
        <div class="w-full max-w-7xl  mx-auto flex flex-wrap items-center justify-between px-3 py-3 md:py-2 lg:p-4">

            <label for="menu-toggle" class="cursor-pointer md:hidden block">
              <i class="fa fa-bars fa-2x text-gray-600"></i>
                
            </label>

            <div class="order-1">
              @auth
              <a class=" tracking-wide no-underline hover:no-underline font-bold text-green-600 text-2xl " href="{{route('campus.home', ['campus'=> Auth::user()->campus->nick_name])}}"> 
                <b> {{config('app.name')}}_<small class=" font-thin">{{Auth::user()->campus->nick_name }}</small>  </b>
            </a> 

                  @else
                  <a class=" tracking-wide no-underline hover:no-underline font-bold text-green-600 text-2xl " href="/"> 
                    <b> {{config('app.name')}} </b>
                </a>
              @endauth
              
          </div>
          <input class="hidden" type="checkbox" id="menu-toggle" />
            <div class=" md:flex md:items-center md:w-auto  order-3 md:order-2 lg:order-2 hidden  w-full" id="menu">
               
                    <ul class="grid grid-cols-2 gap-3 md:flex items-center md:justify-between text-base text-gray-700 pt-4 md:pt-0  md:space-y-0 ">
                      <li class=" hover:bg-green-100 rounded-md p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent"> 
                        <a class="block font-semibold md:font-medium no-underline hover:no-underline py-2  hover:text-black md:border-none md:p-0 " href="/">
                          Homepage
                        </a>
                      </li>
                      <li class="md:ml-2 hover:bg-green-100 rounded-md p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent">
                        <a class=" block no-underline py-2 text-grey-darkest hover:text-black md:border-none md:font-medium md:p-0 hover:no-underline font-semibold " href="/allcampuses">
                          All Campuses
                        </a>
                      </li>
                      <li class=" hover:bg-green-100 rounded-md p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent"> 
                        <a class="block font-semibold md:font-medium no-underline hover:no-underline py-2  hover:text-black md:border-none md:p-0 " href="/about">
                          About
                        </a>
                      </li>
                      
                      <li class="md:ml-2 hover:bg-green-100 rounded-md p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent">
                        <a class=" block no-underline py-2 text-grey-darkest hover:text-black md:border-none md:font-medium md:p-0 hover:no-underline font-semibold " href="/howto">
                          how to Use
                        </a>
                      </li>
                      <li class="md:ml-2 hover:bg-green-100 rounded-md p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent">
                        <a class=" block no-underline py-2 text-grey-darkest hover:text-black md:border-none md:font-medium md:p-0 hover:no-underline font-semibold " href="https://forms.gle/wkVRH7yDWBEKg6QV6" target="_blank">
                          Feedback
                        </a>
                      </li>
                      
                     

                          <!-- Authentication Links -->
                          @guest

                               
                                  @if (Route::has('login'))
                                      <li class="md:ml-2  py-2  ">

                                          <a class="border-2 border-green-400 px-5 py-2 rounded-md font-bold inline-block 
                                          md:w-28 text-center hover:bg-green-200 focus:bg-green-200 w-full" href="{{ route('login') }}">{{ __('Login') }}</a>
                                      </li>
                                  @endif
                    
                                  @if (Route::has('register'))
                                      <li class="md:ml-2  py-2  ">
                                          <a class="border-2 border-green-400 bg-green-400 px-5 py-2 rounded-md font-bold inline-block  text-center md:w-28
                                          hover:bg-green-500 focus:bg-green-500 w-full" href="{{ route('register') }}">{{ __('Sign Up') }}</a>
                                      </li>
                                  @endif
                               
                             
                          @else
                            @foreach ($categories as $category)
                              <li class=" hover:bg-green-100 rounded-md p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent"> 
                                <a class="block font-semibold md:font-medium no-underline hover:no-underline py-2  hover:text-black md:border-none md:p-0 " href="{{route('subcategory', ['campus'=> Auth::user()->campus->nick_name,'c'=> $category->name])}}">
                                  {{ $category->name}}
                                </a>
                              </li>
                            @endforeach
                                <li class="md:ml-2 hover:bg-green-100 rounded-md p-2 focus:bg-green-100 bg-gray-100 md:bg-transparent">
                                    <a class="block font-semibold  no-underline hover:no-underline py-2  hover:text-black md:font-medium md:border-none md:p-0 " href="/dashboard"
                                    > <span class="  md:hidden"><i class="la la-user-circle la-2x"></i></span>
                                     My Profile</a>
                                </li>    
                          @endguest
                    </ul>
            </div>
            <div class="order-2 md:order-3 lg:order-4 flex items-center" id="nav-content">

              <ul class=" list-none flex">
                
                <li class="md:ml-2">
                  <a class=" inline-block bg-green-500 px-3 py-2 rounded-md text-white text-sm font-semibold md:text-base focus:bg-green-600" href="/post-type"> <i class="la la-pencil"></i>
                    Add post
                  </a>
                </li>
                
              </ul>

            </div>
            
            <div class="order-3 lg:order-2 w-full lg:w-auto  mt-3 md:mt-2 lg:mt-0 @if ( Route::current()->getName() == 'campus.home' || Request::is('allcampuses'))
            {{'hidden'}}
        @endif">
              <form class="bg-gray-100 flex rounded-md shadow" action="{{ url ('search')}}" method="GET " >
                {{ csrf_field() }}
                <label class="hidden" for="search-form">Search</label>
                <input class="px-3 py-2 rounded-md w-full focus:outline-none bg-gray-50" placeholder="I'm looking for ..." type="text" name="query" required>
                
                <button type="submit" name="submit" class="focus:bg-green-500 text-green-500 focus:text-white rounded-r-md focus:outline-none"><i class="fa fa-search  mx-1.5 my-1 cursor-pointer "></i></button>
              </form>
            </div>
        </div>
    </nav>
  
  </header>