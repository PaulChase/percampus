@extends('layouts.app')

@section('title') Latest scholarships opportunities for university students @endsection

@section('content')
   <div class=" bg-gray-50 px-2 py-3">

        <div class="text-lg font-medium  px-2 md:text-center md:text-xl">
            <h2>Recent Posts <i>{{$cName ?? ''}}</i></h2>
        </div>
        
        {{-- div for posts --}}
        <div class="grid lg:gap-4 grid-cols-1 gap-y-4 md:grid-cols-3 lg:grid-cols-4 py-3 max-w-7xl mx-auto w-full px-2">
           
        @if (count($posts) > 0)

        {{-- iterating through all the posts  --}}
            @foreach ($posts as $each_post)
                <div class="border border-gray-200 md:border-none md:shadow-md  bg-white     rounded-sm md:grid-cols-1  md:gap-y-2 " >

                    <div class=" col-span-2  ">
                            <a href="/{{$each_post->user->campus->nick_name}}/{{$each_post->subcategory->slug}}/{{$each_post->slug}}">
                                @if (is_object($each_post->images()->first()))
                                    <img src="{{$each_post->images()->first()->Image_path}}" class=" w-full  object-fill  rounded-t-sm h-48 md:h-48   md:rounded-b-none md:rounded-t-sm" lazy="loading" alt="{{$each_post->title}}">
                                @endif
                            </a>
                            
                    </div>        
                    <div class="col-span-4  flex flex-col justify-center md:justify-start px-3 py-2">
                        <h3 class=" text-lg md:text-lg text-gray-600 mb-2 font-semibold ">
                            <a href="/{{$each_post->user->campus->nick_name}}/{{$each_post->subcategory->slug}}/{{$each_post->slug}}" class="focus:text-green-600">{{$each_post->title}}</a>
                        </h3>
                        
                        <p class="">
                            <strong>DeadLine:</strong> {{ $each_post->apply_deadline}}
                        
                        </p>
                    </div>
                </div>
        
            
            @endforeach
           
        </div>
            {{$posts->links()}}
        @else
            <p>No Posts</p>
        @endif

        
   </div>
   @guest
       <a href="/posts/create" class=" block w-full bg-green-500 fixed bottom-0 z-50 p-3 text-center text-white font-semibold  rounded-t-md"> <i class="fab fa-bag"></i> Start selling for FREE</a>
   @endguest
   
@endsection