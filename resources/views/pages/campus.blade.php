@extends('layouts.app') 

@section('title') {{$campus->name}} online marketplace @endsection
@section('description') Welcome to {{$campus->name}} campus where you can buy and sell products and services to students on your campus, find events, jobs, scholarship opportunities and so much more @endsection


@section('content')
<section
    class=" relative text-white"
    style="height: 60vh; background: url({{$campus->bg_image}}) no-repeat center center/cover;"
>
    <div class=" bg-black top-0 right-0 w-full h-full absolute opacity-80 flex flex-row justify-center items-center text-center p-3">
    <h2 class="text-3xl md:text-5xl lg:max-w-3xl font-bold mb-4">Welcome to {{$campus->name}} Online Marketplace</h2>
    </div>   
</section>

<section class="py-3 max-w-7xl mx-auto bg-gray-100">

    <div class=" bg-white p-3">
        <h3 class=" font-bold text-lg my-4 ">Recents Items for Sale in <span class=" uppercase">{{$campus->nick_name}}</span> campus</h3>

        <div class=" overflow-auto whitespace-nowrap py-3 max-w-7xl mx-auto w-full">
           
        @if (count($recentPosts) > 0)

        {{-- iterating through all the posts  --}}
            @foreach ($recentPosts as $each_post)
                <div class="border border-gray-200 md:border-none md:shadow-md  bg-white     rounded-sm md:grid-cols-1 w-40 md:w-60 inline-block mr-2 md:gap-y-2 " >

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
                                <small class=" text-green-500  text-xs md:text-base font-semibold"> N {{$each_post->price}}  </small>
                            
                        {{-- <small>{{$each_post->created_at->diffForHumans()}}</small> --}}
                        </p>
                    </div>
                </div>
        
            
            @endforeach
           
        </div>
        <div class="my-4">
                    <a href="{{route('subcategory', ['campus'=> $campus->nick_name,'c'=> 'marketplace'])}}" class="block mx-auto w-3/4 md:w-1/4 p-3 bg-green-500 rounded-full text-white text-center font-semibold focus:bg-green-700"> View More items<i class="fa fa-chevron-right ml-2"></i></a>
            </div>
        @else
            
            <p> Sorry, There are no items for sale in {{$campus->nick_name}} campus</p>
        @endif
    </div>

    <div class=" bg-white p-3 my-3">
        <h3 class=" font-bold text-lg my-4 ">Requested items and services in <span class=" uppercase">{{$campus->nick_name}}</span> campus</h3>

        <div class="grid gap-4   md:grid-cols-3 lg:grid-cols-4 py-3 max-w-7xl mx-auto w-full">
           
        @if (count($recentEnquiries) > 0)

       
            @foreach ($recentEnquiries as $enquiry)
                <div class=" border-2 border-gray-300 rounded-md p-3  space-y-2">
                    <h4 class=" text-lg font-semibold ">{{ $enquiry->message}}</h4>
                    <p  class=" text-sm">In <span class=" uppercase">{{ $enquiry->campus->nick_name}}</span> campus</p>
                    <p class=" flex justify-between items-center"><span><i class=" fa fa-user mr-2"></i> {{$enquiry->name}}</span> 
                        @if ($enquiry->contact_mode == 'call')
                            <a href="tel:0{{$enquiry->contact_info  }}" class="py-1 px-3 rounded-full border border-gray-400 bg-gray-200 contactBuyer" id="{{ $enquiry->id}}"><i class=" fa fa-phone mr-2"></i> Call</a>
                        @endif
                        @if ($enquiry->contact_mode == 'whatsapp')
                            <a href="https://wa.me/?text={{ rawurlencode("Hello $enquiry->name, I saw your post about  $enquiry->message on percampus.com") }}" class=" py-1 px-2 rounded-full border border-green-400  bg-green-100 contactBuyer " id="{{ $enquiry->id}}"><i class=" fab fa-whatsapp mr-2 text-green-500"></i> Whatsapp</a>
                        @endif
                </p>
                </div>
            
            @endforeach
           
        </div>
        <div class="my-4">
                    <a href="{{route('enquiries.index')}}" class="block mx-auto w-3/4 p-3 bg-green-500 rounded-full text-white text-center font-semibold focus:bg-green-700  md:w-1/4"> View More Requests<i class="fa fa-chevron-right ml-2"></i></a>
            </div>
        @else
            
            <p> Sorry, There are no items for sale in {{$campus->nick_name}} campus</p>
        @endif
    </div>

    <div class=" bg-white my-3 p-4">
        <h3 class=" font-bold text-lg my-4 ">Recents Opportunities for students</h3>

        <div class="grid lg:gap-4 grid-cols-1 gap-y-4 md:grid-cols-3 lg:grid-cols-4 py-3 max-w-7xl mx-auto w-full px-2">

        {{-- iterating through all the opportunities  --}}
            @foreach ($recentOpportunities as $each_post)
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
                        @php
                            
                            $deadline = new DateTime($each_post->apply_deadline);
                            // dd($deadlane);
                        @endphp
                        <p class="">
                            <strong>DeadLine:</strong>  {{ $deadline->format("jS F, Y")}}
                        </p>
                    </div>
                </div>
        
            
            @endforeach
           
        </div>
        <div class="my-4">
                    <a href="{{route('subcategory', ['campus'=> $campus->nick_name,'c'=> 'opportunities'])}}" class="block mx-auto w-3/4 p-3 bg-green-500 rounded-full text-white text-center font-semibold focus:bg-green-700  md:w-1/4"> View More Opportunities<i class="fa fa-chevron-right ml-2"></i></a>
            </div>
        
   </div>
    </div>
    {{-- <div class=" grid lg:grid-cols-3 gap-3">
        @foreach ($categories as $category)
            <div class=" border-2  border-gray-200 border-solid py-4 px-5 rounded-md hover:shadow-lg lg:text-lg lg:p-5">
                <a href="{{route('subcategory', ['campus'=> $campus->nick_name,'c'=> $category->name])}}" class=" ">
                    <h3 class="font-semibold text-green-400 mb-3 block text-lg lg:text-xl uppercase">{{$campus->nick_name}} {{ $category->name}} <i class=" fa fa-chevron-right "></i></h3>
                    <p>{{ $category->excerpt}}</p>
                </a>
            </div>
        @endforeach
        <div class=" border-2  border-gray-200 border-solid py-4 px-5 rounded-md hover:shadow-lg lg:text-lg lg:p-5">
            <a href="  @if ($campus->e_library == null)
                            /{{$campus->nick_name}}/library
                        @else
                            {{$campus->e_library}}
                        @endif" target="_blank">
                <h3 class="font-semibold text-green-400 mb-3 block text-lg lg:text-xl "><span class=" uppercase">{{$campus->nick_name.' '}}</span>E-library <i class=" fa fa-chevron-right "></i></h3>
                <p> A place to get all {{$campus->nick_name}} course materials such as PDFs, slides, scanned photos etc. Submitted by fellow {{$campus->nick_name}} students for you to search and download.</p>
            </a>
        </div>
    </div> --}}
</section>
    


@endsection
