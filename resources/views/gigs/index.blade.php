@extends('layouts.app')

@section('title') Cheap Services offered by Students @endsection

@section('content')
   <div class=" bg-gray-50 px-2 py-3">

        <div class="text-lg font-medium  px-2 md:text-center md:text-xl">
            <h2>Recent Services <i>{{$cName ?? ''}}</i></h2>
        </div>
        
        {{-- div for posts --}}
        <div class="grid lg:gap-4 grid-cols-1 gap-y-4 md:grid-cols-3 lg:grid-cols-4 py-3 max-w-7xl mx-auto w-full px-2">
           
        @if (count($posts) > 0)

        {{-- iterating through all the posts  --}}
            @foreach ($posts as $each_post)
                <div class="border-2 border-gray-200 md:border-none md:shadow-md grid  bg-white      rounded-md grid-cols-1  md:gap-y-2 " >

                    <div class="   ">
                            <a href="/{{$each_post->alias_campus ? $each_post->alias_user_campus->nick_name : $each_post->user->campus->nick_name }}/{{$each_post->subcategory->slug}}/{{$each_post->slug}}">
                                @if (is_object($each_post->images()->first()))
                                    <img src="{{$each_post->images()->first()->Image_path}}" class=" w-full  object-cover  rounded-t-md h-44 md:h-48   md:rounded-b-none md:rounded-t-sm" lazy="loading" alt="">
                                @endif
                            </a>
                            
                            
                    </div>        
                    <div class="  flex flex-col justify-center md:justify-start px-3 py-2">
                        <h3 class=" text-base  text-gray-600 mb-2 font-semibold gigtext " >
                            <a href="/{{$each_post->alias_campus ? $each_post->alias_user_campus->nick_name : $each_post->user->campus->nick_name }}/{{$each_post->subcategory->slug}}/{{$each_post->slug}}" class="focus:text-green-600">{{$each_post->title}}</a>
                        </h3>
                        <hr>
                        @php
                            $nameArray = explode(" ", $each_post->user->name )
                        @endphp

                        <div class="py-2 flex items-center justify-between border-gray-100">
                            @if ($each_post->user->avatar == null || $each_post->user->avatar == 'users/default.png')
                            <p class="  inline-block"><i class="fa fa-user-circle fa-2x text-gray-400 "></i>
                            <span class=" font-semibold ml-1"> {{$nameArray[0]}}</span>
                        </p> 
                                
                            @else
                                <div>
                                    <img src="{{$each_post->user->avatar}}" alt="" class="inline-block rounded-full object-cover h-8 w-8">
                                    @if ($each_post->alias)
                                    <span class=" font-semibold ml-1">{{ $each_post->alias }}</span>
                        

                        @else
                        <span class=" font-semibold ml-1"> {{$nameArray[0]}}</span>
                            
                        @endif
                                    
                                </div>

                            @endif
                                
                                <div class="py-2 ">
                                    @if ($each_post->price === 0)
                            <span class=" uppercase text-xs">price depends </span>
                        @else
                        <span class=" uppercase text-xs">from </span><span class=" text-green-400 font-semibold ml-1 text-lg">N{{{$each_post->price}}}</span>
                            
                        @endif
                                    
                                </div>
                            </div>
                            
                        
                    </div>
                </div>
        
            
            @endforeach
           
        </div>
            {{$posts->links()}}
        @else
            <p>No Services today</p>
        @endif

        
   </div>
   {{-- @guest
       <a href="{{ route('gigs.create')}}" class=" block w-full bg-green-500 fixed bottom-0 z-50 p-3 text-center text-white font-semibold  rounded-t-md"> <i class="fab fa-bag"></i> Sell your skills on campus</a>
   @endguest --}}
   
@endsection