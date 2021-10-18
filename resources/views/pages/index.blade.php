@extends('layouts.focused') 

@section('title') Welcome to the Online marketplace for students on campus @endsection


@section('focus')

    
        <header  class="  text-gray-700   " style="
        height: 90vh;">
        
        
        <div class=" bg-green-100 top-0 right-0 w-full h-full  px-2">
            <nav class=" flex flex-row justify-between max-w-7xl mx-auto align-middle p-4">
                <h1 class=" no-underline hover:no-underline font-extrabold  text-2xl lg:text-3xl tracking-widest"> {{config('app.name')}}</h1>
                @guest
                <a href="/register" class=" inline-block border-2 border-green-400 px-4 py-2 rounded-md  text-sm font-semibold md:text-base focus:bg-green-700">Register</a >
                    @else
                    <a href="/dashboard" class=" inline-block border-2 border-green-400 px-4 py-2 rounded-md  text-sm font-semibold md:text-base focus:bg-green-700">My Profile</a >
                @endguest
                
                
            </nav>
            <div class="   ">
                <div class="px-2 md:w-3/5 md:mx-auto ">
                    <img class=" h-44 w-44 md:h-52  md:w-52 mx-auto my-4" src="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/icons/social-media-marketing.png" alt="" >
                    <p class=" text-3xl lg:text-4xl lg:max-w-3xl  font-semibold my-3">Discover  affordable products up For Sale  by other Students on your Campus.
                    </p>
                    <p>Welcome to our campus marketplace, where you will be able to sell new and used items very fast to students on your campus  </p>
                    <p class="grid gap-3 grid-cols-2">
                        <a href="/register" class=" inline-block bg-green-500 opacity-100 py-4  rounded-md text-white text-sm font-semibold md:text-base focus:bg-green-800 mt-5 border-2 border-green-500 shadow-xl  text-center">Start selling for FREE</a>
                        <a href="/posts" class=" inline-block opacity-100 py-4  rounded-md text-gray-700 text-sm font-semibold md:text-base border-2 border-green-400  focus:border-green-700 mt-5 shadow-xl  text-center">View Items for Sale</a>
                    </p>
                </div>
            </div>
        </div>
    </header>
    {{-- end of hero section --}}


    <main class=" bg-gray-50 text-gray-700 m-0">
                
            
        <div class="p-3">
            <h3 class="p-3  font-semibold text-xl lg:text-2xl my-3"> What other Students are Selling </h3>
                <div class="grid gap-4 grid-cols-2 lg:grid-cols-4 lg:px-5">
                    @foreach ($posts as $each_post)
                    <div class="border border-gray-200 md:border-none md:shadow-md  bg-white     rounded-md md:grid-cols-1  md:gap-y-2 " >

                    <div class="   ">
                            <a href="/{{$each_post->user->campus->nick_name}}/{{$each_post->subcategory->slug}}/{{$each_post->slug}}">
                                @if (is_object($each_post->images()->first()))
                                    <img src="{{$each_post->images()->first()->Image_path}}" class=" w-full  object-fill  rounded-t-sm h-32 md:h-48   md:rounded-b-none md:rounded-t-md" lazy="loading" alt="{{$each_post->title}}">
                                @endif
                            </a>
                            
                    </div>        
                    <div class="col-span-4  flex flex-col justify-center md:justify-start px-3 py-2">
                        <h3 class=" text-sm md:text-lg text-gray-600 mb-2 font-semibold overflow-hidden whitespace-nowrap overflow-ellipsis">
                            <a href="/{{$each_post->user->campus->nick_name}}/{{$each_post->subcategory->slug}}/{{$each_post->slug}}" class="focus:text-green-600">{{$each_post->title}}</a>
                        </h3>
                        
                        <p>
                          <span class="block italic">In <span class=" uppercase">{{$each_post->user->campus->nick_name}}</span>  campus</span>  
                          <small class=" text-green-500  text-xs md:text-base font-semibold"> N {{$each_post->price}}  </small>
                        </p>
                    </div>
                    </div>
        
            
                    @endforeach
                </div>
                <div class="my-4">
                    <a href="/posts" class="block mx-auto w-3/4 lg:w-1/3 lg:p-5 lg:text-xl p-3 bg-green-500 rounded-full text-white text-center font-semibold focus:bg-green-700"> View More <i class="fa fa-chevron-right ml-2"></i></a>
                </div>   
            </div>
        </div>

        <div class="p-3 bg-green-400 text-white py-6">
            <h3 class=" uppercase font-bold text-2xl lg:text-4xl text-center my-5 p-2">Top categories</h3>
            <div class="grid gap-x-4 gap-y-8  grid-cols-2 text-center">
                <a href="{{ route('getposts.bycategory', ['m' => 'marketplace', 'c' => 'phones' ])}}" class="focus:bg-green-700 rounded-md">
                        <img src="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/icons/smartphone.png" alt="" class=" h-24  w-24 mx-auto my-2 lg:w-40 lg:h-40">
                        <h4 class=" font-semibold">Mobile Phones</h4>
                </a >
                <a class="focus:bg-green-700 rounded-md" href="{{ route('getposts.bycategory', ['m' => 'marketplace', 'c' => 'men' ])}}" >
                    <img src="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/icons/running-shoes.png" alt="" class=" h-24  w-24 mx-auto my-2 lg:w-40 lg:h-40">
                    <h4 class=" font-semibold"> Shoes & Footwears</h4>
                </a >
                <a href="{{ route('getposts.bycategory', ['m' => 'marketplace', 'c' => 'women' ])}}" class="focus:bg-green-700 rounded-md">
                    <img src="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/icons/dress.png" alt="" class=" h-24  w-24 mx-auto my-2 lg:w-40 lg:h-40">
                    <h4 class=" font-semibold">Women Clothings</h4>
                </a >
                <a href="{{ route('getposts.bycategory', ['m' => 'marketplace', 'c' => 'household' ])}}" class="focus:bg-green-700 rounded-md">
                    <img src="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/icons/pot.png" alt="" class=" h-24  w-24 mx-auto my-2 lg:w-40 lg:h-40">
                    <h4 class=" font-semibold">Household </h4>
                </a >
            </div>
            <div class="my-8">
                    <a href="{{ route('getSubCategories', ['mainCategoryID' => 2])}}" class="block mx-auto w-3/4 p-3 bg-white rounded-full text-green-500 text-center font-semibold focus:bg-green-500 focus:text-white lg:w-1/3 lg:p-5 lg:text-xl "> Explore All Categories <i class="fa fa-chevron-right ml-2"></i></a>
                </div>   
        </div>


        {{-- call to action --}}
        @guest
        <div class=" bg-gray-700 px-4 py-24 h-auto text-xl text-white font-semibold text-center lg:h-72 lg:flex  lg:items-center lg:px-10">
            <p class=" md:w-3/12"><i class="fa fa-rocket fa-3x text-green-500 mb-6"></i></p>
            <div>
                <p class=" lg:text-3xl "> If you start selling now, your items will be seen first when buyers start flooding in.  <br> So what are you waiting for?</p> 
                <p class=""> <a href="/register" class=" rounded-full border-2 py-3 px-5 text-base bg-green-500 border-green-500 focus:bg-green-700 focus:border-green-700 md:text-lg block my-7 lg:w-1/3 lg:p-5 lg:text-xl mx-auto">Sign Me up ASAP</a></p>
            </div>
        </div>
        @endguest
        
        <div class=" text-center p-4 lg:grid lg:grid-cols-2 lg:my-12 py-16">
            <img src="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/icons/school.png" alt="" class="h-40 w-40 lg:w-60 lg:h-60 mx-auto my-4">
            <div>
                <p class=" text-2xl font-semibold ">Want to view items for sale on your campus?</p>
            <div class="my-8">
                    <a href="/allcampuses" class="block mx-auto w-11/12 lg:w-3/5 p-3 bg-white rounded-full text-green-500 border-2 border-green-300  text-center font-semibold focus:bg-green-500 focus:text-white"> Visit your Campus marketplace  <i class="fa fa-chevron-right ml-2"></i></a>
                </div>
            </div>
            
        </div>
        
{{-- faq --}}
<div class=" bg-gray-700 px-4 py-24 h-auto  text-white   lg:h-72 lg:flex  lg:items-center lg:px-10">
    <h3 class=" font-bold text-lg text-center mb-5">Frequently Asked Questions (FAQ)</h3>
    <button class="accordion p-3 shadow-2xl rounded-lg font-semibold w-full text-left my-3">what's this site all about? <i class="fa fa-chevron-right float-right"></i></button>
    <div class="panel p-3 bg-gray-50 rounded-md text-gray-700  border-l-4 border-green-400 hidden">
        <p>In summary, this is an online marketplace similar to jiji but for us students on campus to buy and sell both new and used items to one another.</p>
    </div>
    <button class="accordion p-3 shadow-2xl rounded-lg font-semibold w-full text-left my-3">who is the website for?<i class="fa fa-chevron-right float-right"></i></button>
    <div class="panel p-3 bg-gray-50 rounded-md text-gray-700  border-l-4 border-green-400 hidden">
        <p>The website is for any student on campus who wants to buy anything from their fellow students, sell a new or used product to their departmental students or campus at large.</p>
    </div>
    <button class="accordion p-3 shadow-2xl rounded-lg font-semibold w-full text-left my-3">How can this website benefit me?<i class="fa fa-chevron-right float-right"></i></button>
    <div class="panel p-3 bg-gray-50 rounded-md text-gray-700  border-l-4 border-green-400 hidden">
        <p>With this website you are no longer limited to posting your products on whatsapp status or groups every now and then. You will now be able to reach all the thousands of students on your campus with a single post.</p>
    </div>
    <button class="accordion p-3 shadow-2xl rounded-lg font-semibold w-full text-left my-3">Can I make money from this website?<i class="fa fa-chevron-right float-right"></i></button>
    <div class="panel p-3 bg-gray-50 rounded-md text-gray-700  border-l-4 border-green-400 hidden">
        <p>Sure, If you own a business on campus of selling products students wants to buy such as footwears, clothes, phone accessories etc. You can definitely use this website as your personal online store to showcase all the items you have in stock with thier prices. <br> The more you sell, the more you earn. The best part is that you keep all the profits (the website is totally FREE, we don't take any cut). </p>
    </div>
</div>

        <div class=" grid lg:grid-cols-2 gap-4 p-4"> 
            

            <div class=" p-4  my-4 text-center">
                <p class="text-lg font-semibold mb-7">You know a friend that this website may change his/her life for good? Don't hesitate to click the share buttons below </p>
                {!! $social!!}
            </div>
        </div>

    </main>
@include('include.footer')
    
@endsection

@section('js')
<script>
    $(document).ready(function(){
        $('.accordion').click(function( ){
            $(this).next().toggle(500) 
            $(this).toggleClass('text-green-500')
        })

        });
</script>
@endsection