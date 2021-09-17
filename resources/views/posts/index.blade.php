@extends('layouts.app')

@section('title') Recent Posts in {{$cName ?? ''}} @endsection

@section('content')
   <div class=" bg-gray-50 px-3 py-3">

        <div class="text-lg font-medium  px-2 md:text-center md:text-xl">
            @if ($query)
            <h2> showing results for  <i>{{$query}}</i></h2>
            @else
            <h2>Recent Posts <i>{{$cName ?? ''}}</i></h2>
            @endif
            
        </div>
        
        {{-- div for posts --}}
        <div class="grid gap-4 grid-cols-2  md:grid-cols-3 lg:grid-cols-4 py-3 max-w-7xl mx-auto w-full">
           
        @if (count($posts) > 0)

        {{-- iterating through all the posts  --}}
            @foreach ($posts as $each_post)
                <div class="border border-gray-200 md:border-none md:shadow-md  bg-white     rounded-sm md:grid-cols-1  md:gap-y-2 " >

                    <div class=" col-span-2  ">
                            <a href="/{{$each_post->user->campus->nick_name}}/{{$each_post->subcategory->slug}}/{{$each_post->slug}}">
                                @if (is_object($each_post->images()->first()))
                                    <img src="{{$each_post->images()->first()->Image_path}}" class=" w-full  object-fill  rounded-t-sm h-32 md:h-48   md:rounded-b-none md:rounded-t-sm" lazy="loading" alt="{{$each_post->title}}">
                                @endif
                            </a>
                            
                    </div>        
                    <div class="col-span-4  flex flex-col justify-center md:justify-start px-3 py-2">
                        <h3 class=" text-sm md:text-lg text-gray-600 mb-2 font-semibold overflow-hidden whitespace-nowrap overflow-ellipsis">
                            <a href="/{{$each_post->user->campus->nick_name}}/{{$each_post->subcategory->slug}}/{{$each_post->slug}}" class="focus:text-green-600">{{$each_post->title}}</a>
                        </h3>
                        
                        <p>
                            @if ($each_post->price > 0)
                                <small class=" text-green-500  text-xs md:text-base font-semibold"> N {{$each_post->price}}  </small>
                            @else
                            <small class=" text-green-500 text-xs md:text-base"> {{'Contact Me'}}  </small>    
                        
                        @endif
                        {{-- <small>{{$each_post->created_at->diffForHumans()}}</small> --}}
                        </p>
                    </div>
                </div>
        
            
            @endforeach
           
        </div>
            {{$posts->links()}}
        @else
            @if ($query)
                <p class=" text-center ">Sorry, there are no <i>{{ $query}}</i> for now, you can check back later.</p>
                
            @else
                <p>No Posts</p>
                
            @endif
        @endif

        
   </div>
   @guest
       <a href="/posts/create" class=" block w-full bg-green-500 fixed bottom-0 z-50 p-3 text-center text-white font-semibold  rounded-t-md "> <i class="fab fa-bag"></i> Start selling for FREE</a>
   @endguest
   
@endsection