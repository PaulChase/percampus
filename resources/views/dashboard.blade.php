@extends('layouts.app')

@section('title') {{ Auth::user()->name }} dashboard @endsection

@section('content')
<div class=" bg-gray-200">
   
        <div class=" max-w-xl mx-auto py-2 ">
            <div class=" text-center p-3 bg-gray-50">
                <p class=" my-4"><i class="fa fa-user-circle fa-7x text-gray-400"></i></p>
                <p><strong class=" text-xl">{{ Auth::user()->name}}</strong> <br>
                <span>{{ Auth::user()->campus->name}}</span> <br>
            <span class=" italic">Email: {{  Auth::user()->email}}</span></p>
            </div>
            <div class=" my-2 font-semibold bg-gray-50 p-3 flex justify-between items-center">
                <span>Your Recent Posts</span>
                <a href="/posts/create" class=" bg-green-500 py-2 px-3 rounded-sm text-white">Add a Post</a>
            </div>
    
            <div class=" my-2 bg-gray-50 p-3" >
                
                @if (count($posts) > 0)
                    
                    @foreach ($posts as $each_post)
                    <div class=" border-2 border-gray-200 rounded-md my-3 px-4 py-3 grid   grid-cols-1">
                        <div class=" col-span-3">
                            <h2 class="text-base text-gray-700 font-semibold">{{$each_post->title}}</h2>
                            <small> Added: {{$each_post->created_at->diffForHumans()}}</small>
                        </div>
        
                        <div class=" flex justify-between mt-2">
                            <div>
                                <a href="/{{$each_post->user->campus->nick_name}}/{{$each_post->subcategory->slug}}/{{$each_post->slug}}" class=" bg-gray-200 py-2 px-3 rounded-md inline-block hover:bg-gray-400 focus:bg-gray-400"> <i class="la la-paint-brush"></i> View</a>
                            </div>
                            <div>
                                <a href="/posts/{{$each_post->id}}/edit" class=" bg-gray-200 py-2 px-3 rounded-md inline-block hover:bg-gray-400 focus:bg-gray-400"> <i class="la la-paint-brush"></i> Edit</a>
                            </div>
                            <div>
                                <form action="{{ route('posts.delete', ['id' => $each_post->id])}}" method="POST">
                                    @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" name="submit" class="text-red-400 font-semibold py-2 px-2 rounded-md hover:bg-red-300 hover:text-white focus:bg-red-300 focus:text-white"> <i class="la la-trash"></i> Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                @else
                <div class=" bg-gray-100 text-xl rounded-md p-4  my-3 text-center"><p>You have No Posts</p></div>
                @endif
                
            </div>
            @if (Auth::user()->role_id == 1)
                <div class=" my-2 font-semibold bg-gray-50 p-3 flex justify-between items-center">
                    <span>My Active Ads</span>
                    <a href="/ads/create" class=" bg-green-500 py-2 px-3 rounded-sm text-white">Create Ad</a>
                </div>
                <div class=" p-3 bg-gray-50 my-2 lg:grid lg:grid-cols-2 lg:gap-3">
                @if (count($ads ) > 0)
                        @foreach ($ads as $ad)
                            <div class=" border-2 border-gray-200 rounded-sm  my-2">
                            <a href="{{$ad->link}}" target="_blank" class="grid grid-cols-6 gap-2 md:grid-cols-1 md:gap-0 md:gap-y-2 ">
                                <div class="col-span-4  p-2 my-auto">
                                    <h3 class="  font-semibold">{{$ad->title}}</h3>
                                    <p>url: {{ $ad->link}}</p>
                                </div>
                                <div class="col-span-2 md:order-first">
                                    <img src="{{$ad->image_url}}" class=" rounded-sm h-28 md:h-28 w-full object-cover" alt="{{$ad->title}}">
                                </div>
                                
                            </a>
                            <div class="flex justify-between my-2 p-3 bg-gray-50 lg:rounded-sm">
                                <div>
                                    <a href="/ads/edit/{{$ad->id}}" class=" bg-gray-200 px-3 py-2 rounded-sm inline-block "> Edit Post</a>
                                </div>
                                <div>
                                    <form action="{{ route('ads.delete', ['id' => $ad->id])}}" method="POST">
                                    @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="submit" name="submit" value="Delete Post" class=" inline-block bg-red-400 px-3 py-2  rounded-sm">
                                    </form>
                                </div>
                            </div>
                            </div>
                        @endforeach
                @else
                    <div> There No Ads</div>
                @endif
                </div>
            @endif
            <div class=" bg-red-100 rounded-md p-2">
                <a class="block font-semibold  no-underline md:font-medium hover:no-underline py-2  hover:text-black md:border-none md:p-0 " href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"> <i class="la la-mail-reply mr-2"></i>
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class=" hidden ">
                    @csrf
                </form>
            </div>
            
            
        </div>
    
</div>
@endsection
