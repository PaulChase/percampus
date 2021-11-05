@extends('layouts.app')

@section('title') {{$post->title}} @endsection
@section('description') Apply for {{$post->title}} before the deadline, to know more visit our website @endsection

@section('content')

<div class=" bg-gray-200">

    <div class=" max-w-7xl mx-auto py-3 lg:grid lg:grid-cols-6 lg:gap-5">
        {{-- {{ dd($post->images()->get())}} --}}
        <div class="lg:col-span-4">
            <div class="cover-photos swiper w-full  lg:rounded-sm">
                <div class="swiper-wrapper">
                    @foreach ($post->images()->get() as $image)
                    <div class="swiper-slide ">
                        <img src="{{$image->Image_path}}" class=" w-full h-96 md:h-96 object-fill " alt="{{$post->title}}">
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination "></div>
            </div>
            <div class="px-3 pt-3 pb-1 bg-gray-50 lg:rounded-sm">
                <h1 class="text-lg lg:text-xl font-semibold my-3 ">{{$post->title}}</h1>
                <hr />
                <div class=" flex justify-between items-center mb-3 pt-2">
                    @if ($post->apply_deadline == null )
                    <p class=" text-lg text-green-500"> <strong>DeadLine:</strong> {{'Not Specified'}} </p>

                    @else
                    @php

                    $deadline = new DateTime($post->apply_deadline);

                    @endphp
                    <p class=" text-lg text-green-500"> <strong>DeadLine:</strong> {{ $deadline->format("jS F, Y")}} </p>
                    @endif
                    <p> {{$post->created_at->diffForHumans()}}</p>
                </div>
            </div>

            <div class=" mt-3 p-3 bg-gray-50 lg:rounded-sm">
                <h3 class=" font-semibold border-b border-gray-200 pb-2">More Info</h3>
                <p class=" whitespace-pre-line">{{$post->description}}</p>
            </div>
            {{-- Middle Ads section --}}
                @if ($ads->count() > 0)
                    <div class=" mt-3 bg-gray-50 p-3 lg:rounded-sm">
                        <h2 class=" my-3 font-bold  tracking-wide">Sponsored</h2>

                        <div class=" md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-3">
                            @foreach ($ads as $ad)
                                @if ($ad->position == 'middle')
                                    <div class=" border-2 border-gray-200 rounded-sm  my-2">
                                        <a href="{{ $ad->link }}" target="_blank"
                                            class="adclick grid grid-cols-6 gap-2 md:grid-cols-1 md:gap-0 md:gap-y-2 " id="{{ $ad->id}}">
                                            <h3 class=" col-span-4  p-2 my-auto font-semibold">{{ $ad->title }}</h3>
                                            <div class="col-span-2 md:order-first">
                                                <img src="{{ $ad->image_url }}"
                                                    class=" rounded-sm h-24 md:h-24 w-full object-cover"
                                                    alt="{{ $ad->title }}">
                                            </div>

                                        </a>
                                    </div>
                                @endif

                            @endforeach
                        </div>
                    </div>
                @endif
                {{-- end of Ads section --}}

            <table class=" w-full bg-gray-50 mt-3  lg:rounded-sm">

                <tr class=" border-b border-gray-200">
                    <td class="p-3 font-semibold"> Reward</td>
                    <td class=" float-right p-3">{{ $post->price}}</td>
                </tr>

            </table>
        </div>

        <div class=" lg:col-span-2">

            <div class=" mt-3 p-3 bg-gray-50 lg:mt-0 lg:rounded-sm">
                <h3 class=" font-semibold border-b border-gray-200 pb-2">Posted by:</h3>
                <p class=" text-xl my-3 flex items-center">
                    @if ( $post->user->avatar == null || $post->user->avatar == 'users/default.png' )
                    <span class="fa fa-user-circle fa-2x text-gray-400 mr-2"></span>
                    @else
                    <img src="{{$post->user->avatar}}" class=" w-20 h-20 rounded-full border-2 border-green-300 object-cover mr-3 " alt="">
                    @endif
                    {{ $post->user->name}}
                </p>
            </div>
            @include('include.convince')


            <div class=" mt-3 p-3 bg-gray-50 lg:rounded-sm text-center">
                <h3 class=" font-bold text-lg my-3 italic">If you are Eligible? proceed to</h3>
                <a href="{{ $post->apply_link}}" class=" block p-2 border-2 border-green-500 rounded-sm w-2/3 uppercase font-bold mx-auto text-green-500" target="_blank">Apply now</a>
            </div>

            <div class="mt-3 p-3 bg-gray-50">
                <h3 class=" font-bold text-lg my-4 ">Items for sale by students on Campus</h3>

                <div class="grid gap-4 grid-cols-2   py-3 max-w-7xl mx-auto w-full">
                    @foreach ($recentPosts as $each_post)
                    <div class="border border-gray-200 md:border-none md:shadow-md  bg-white     rounded-sm md:grid-cols-1  md:gap-y-2 ">

                        <div class=" col-span-2  ">
                            <a href="/{{$each_post->user->campus->nick_name}}/{{$each_post->subcategory->slug}}/{{$each_post->slug}}">
                                @if (is_object($each_post->images()->first()))
                                <img src="{{$each_post->images()->first()->Image_path}}" class=" w-full  object-fill  rounded-t-sm h-32 md:h-40   md:rounded-b-none md:rounded-t-sm" lazy="loading" alt="{{$each_post->title}}">
                                @endif
                            </a>

                        </div>
                        <div class="col-span-4  flex flex-col justify-center md:justify-start px-3 py-2">
                            <h3 class=" text-sm md:text-lg text-gray-600 mb-2 font-semibold overflow-hidden whitespace-nowrap overflow-ellipsis">
                                <a href="/{{$each_post->user->campus->nick_name}}/{{$each_post->subcategory->slug}}/{{$each_post->slug}}" class="focus:text-green-600">{{$each_post->title}}</a>
                            </h3>

                            <p>
                                <small class=" text-green-500  text-xs md:text-base font-semibold"> N {{$each_post->price}} </small>

                                {{-- <small>{{$each_post->created_at->diffForHumans()}}</small> --}}
                            </p>
                        </div>
                    </div>


                    @endforeach
                </div>

            </div>

            <script async="async" data-cfasync="false" src="//pl16709005.trustedgatetocontent.com/ea58161327edc8f0ced5adb72df97e34/invoke.js"></script>
            <div id="container-ea58161327edc8f0ced5adb72df97e34">
                
            </div>


            {{--Bottom Ads section --}}
                @if ($ads->count() > 0)
                    <div class=" mt-3 bg-gray-50 p-3 lg:rounded-sm">
                        <h2 class=" my-3 font-bold  tracking-wide">Sponsored</h2>

                        <div class=" md:grid md:grid-cols-2 md:gap-3">
                            @foreach ($ads as $ad)
                                @if ($ad->position == 'bottom')
                                    <div class=" border-2 border-gray-200 rounded-sm  my-2">
                                        <a href="{{ $ad->link }}" target="_blank"
                                            class="adclick grid grid-cols-6 gap-2 md:grid-cols-1 md:gap-0 md:gap-y-2 " id="{{ $ad->id}}">
                                            <h3 class=" col-span-4  p-2 my-auto font-semibold">{{ $ad->title }}</h3>
                                            <div class="col-span-2 md:order-first">
                                                <img src="{{ $ad->image_url }}"
                                                    class=" rounded-sm h-28 md:h-28 w-full object-cover"
                                                    alt="{{ $ad->title }}">
                                            </div>

                                        </a>
                                    </div>
                                @endif

                            @endforeach
                        </div>
                    </div>
                @endif
                {{-- end of Ads section --}}

            {{-- Social share --}}
            <div class=" bg-gray-50 px-4 py-6 rounded-sm  my-3 border  text-center lg:rounded-sm">
                <p class=" md:text-lg mb-5">Someone around you really need this, kindly share till it get to that Someone</p>
                {!! $social!!}
            </div>
            {{-- end of Social share --}}

            {{-- @if (!Auth::guest() )
            @if (Auth::user()->id == $post->user_id)
            <div class="flex justify-between my-5 p-3 bg-gray-50 lg:rounded-sm">
                <div>
                    <a href="/posts/{{$post->id}}/edit" class=" bg-gray-200 px-3 py-2 rounded-sm inline-block "> Edit Post</a>
        </div>
        <div>
            <form action="{{ route('posts.delete', ['id' => $post->id])}}" method="POST">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
                <input type="submit" name="submit" value="Delete Post" class=" inline-block bg-red-400 px-3 py-2  rounded-sm">
            </form>
        </div>
    </div>
    @endif
    @endif --}}
</div>
</div>

</div>
@endsection