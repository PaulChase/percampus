@extends('layouts.app')

@section('title') {{$post->title}} @endsection

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
                    <hr/>
                    <div class=" flex justify-between items-center mb-3 pt-2"> 
                        {{-- {{ dd($post->price)}} --}}
                        <p class=" text-lg text-green-500"> <span class="fa fa-credit-card mr-2 "></span> @if ($post->price > 0 && $post->price != '' && $post->price != " " )
                            N{{$post->price}}
                        @else
                            {{'Contact Me'}}
                        @endif </p>
                        <p>  {{$post->created_at->diffForHumans()}}</p>
                    </div>
               </div>
                
                <div class=" mt-3 p-3 bg-gray-50 lg:rounded-sm">
                    <h3 class=" font-semibold border-b border-gray-200 pb-2">Description</h3>
                    <p class=" whitespace-pre-line">{{$post->description}}</p>
                </div>

                <table class=" w-full bg-gray-50 mt-3  lg:rounded-sm">
                    
                    <tr  class=" border-b border-gray-200">
                        <td class="p-3 font-semibold"> Condition</td>
                        <td class=" float-right p-3">{{ $post->item_condition}}</td>
                    </tr>
                    <tr  class=" border-b border-gray-200">
                        <td class="p-3 font-semibold"> Are they more of these?</td>
                        <td class=" float-right p-3">{{ $post->in_stock}}</td>
                    </tr>
                    <tr class=" border-b border-gray-200">
                        <td class="p-3 font-semibold"> Contact Me at</td>
                        <td class=" float-right p-3">0{{$post->contact_info}}</td>
                    </tr>
                    <tr >
                        <td class="p-3 font-semibold"> Meeting point</td>
                        <td class=" float-right p-3"> {{$post->venue}}</td>
                    </tr>
                </table>
            </div>

            <div class=" lg:col-span-2">
                
                <div class=" mt-3 p-3 bg-gray-50 lg:mt-0 lg:rounded-sm">
                    <h3 class=" font-semibold border-b border-gray-200 pb-2">Posted by:</h3>
                    <p class=" text-xl my-3 flex items-center"> <span class="fa fa-user-circle fa-2x text-gray-400 mr-2"></span>  {{ $post->user->name}}</p>
                    <div class=" grid grid-cols-2 gap-3">
                            <a href="tel:+234{{$post->contact_info}}" class=" block p-3 border-2 border-gray-200 text-center focus:border-green-500 rounded-sm"><i class="fa fa-phone mr-3  text-green-500"></i> Call</a>
                            <a href="https://wa.me/234{{$post->contact_info}}?text=Hello%20{{$post->user->name}},%20I%20saw%20your%20adverstisement%20on%20www.percampus.com%20I%20want%20to%20ask%20if%20the%20item%20you%20posted%20is%20still%20available%20for%20sale" class=" block p-3 border-2 border-gray-200 text-center focus:border-green-500 rounded-sm"><i class="fab fa-whatsapp mr-3  text-green-500"></i> Whatsapp</a>
                        </div>
                        
                </div>
    
    
                {{-- Ads section --}}
                @if ($ads->count() > 0)
                    <div class=" mt-3 bg-gray-50 p-3 lg:rounded-sm">
                        <h2 class=" my-3 font-bold  tracking-wide">Sponsored</h2>
    
                        <div class=" md:grid md:grid-cols-2 md:gap-3">
                            @foreach ($ads as $ad)
                                <div class=" border-2 border-gray-200 rounded-sm  my-2">
                                <a href="{{$ad->link}}" target="_blank" class="grid grid-cols-6 gap-2 md:grid-cols-1 md:gap-0 md:gap-y-2 ">
                                    <h3 class=" col-span-4  p-2 my-auto font-semibold">{{$ad->title}}</h3>
                                    <div class="col-span-2 md:order-first">
                                        <img src="{{$ad->image_url}}" class=" rounded-sm h-28 md:h-28 w-full object-cover" alt="{{$ad->title}}">
                                    </div>
                                    
                                </a>
                                </div>
                        @endforeach
                    </div>
                    </div>
                    @endif
                    {{-- end of Ads section --}}
                
                {{-- Social share --}}
                <div class=" bg-gray-50 px-4 py-6 rounded-sm  my-3 border  text-center lg:rounded-sm">
                    <p class=" md:text-lg mb-5">Share to a friend who you think might also be interested in this item</p>
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