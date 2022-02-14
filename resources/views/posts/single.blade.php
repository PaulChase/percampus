@extends('layouts.app')

@section('title') Buy {{ $post->title }} on a university campus @endsection
@section('description'){{ $post->title }} for sale, it is also {{ $post->description }} @endsection
@section('image_url')
    @if (is_object($post->images()->first()))
        {{ $post->images()->first()->Image_path }}
    @endif
@endsection


@section('content')

    <div class=" bg-gray-200">

        <div class=" max-w-7xl mx-auto py-3 lg:grid lg:grid-cols-6 lg:gap-5">
            {{-- {{ dd($post->images()->get())}} --}}
            <div class="lg:col-span-4">
                <div class="  w-full  lg:rounded-sm" id='contact'>
                    <div class=" overflow-auto whitespace-nowrap">
                        @foreach ($post->images()->get() as $image)
                            <div
                                class="inline-block 
                            @if ($post->images()->count() === 1)
                                w-full
                            @else
                                w-4/5 lg:w-auto
                            @endif
                             mr-3">
                                <img src="{{ $image->Image_path }}" class=" w-full h-80 md:h-96 object-fill "
                                    alt="{{ $post->title }}">
                            </div>
                        @endforeach
                    </div>

                </div>


                <div class="px-3 pt-3 pb-1 bg-gray-50 lg:rounded-sm">
                    <h1 class="text-lg lg:text-xl font-semibold my-3 ">{{ $post->title }}</h1>
                    <hr />
                    <div class=" flex justify-between items-center mb-3 pt-2">
                        {{-- {{ dd($post->price)}} --}}
                        <p class=" text-lg text-green-500"> <span class="fa fa-credit-card mr-2 "></span>
                            @if ($post->price > 0 && $post->price != '' && $post->price != ' ')
                                N{{ $post->price }}
                            @else
                                {{ 'Contact Me' }}
                            @endif
                        </p>
                        <p> {{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <div class=" mt-3 p-3 bg-gray-50 lg:rounded-sm">
                    <h3 class=" font-semibold border-b border-gray-200 pb-2">Description</h3>
                    <p class=" whitespace-pre-line">{{ $post->description }}</p>
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
                                            class="adclick grid grid-cols-6 gap-2 md:grid-cols-1 md:gap-0 md:gap-y-2 "
                                            id="{{ $ad->id }}">
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


                <table class=" w-full bg-gray-50 mt-3  lg:rounded-sm">

                    <tr class=" border-b border-gray-200">
                        <td class="p-3 font-semibold"> Condition</td>
                        <td class=" float-right p-3">{{ $post->item_condition }}</td>
                    </tr>
                    <tr class=" border-b border-gray-200">
                        <td class="p-3 font-semibold"> Are they more of these?</td>
                        <td class=" float-right p-3">{{ $post->in_stock }}</td>
                    </tr>
                    <tr class=" border-b border-gray-200 hidden lg:flex lg:justify-between">
                        <td class="p-3 font-semibold"> Contact Me at</td>
                        <td class=" float-right p-3">0{{ $post->contact_info }}</td>
                    </tr>
                    <tr class=" border-b border-gray-200">
                        <td class="p-3 font-semibold"> Meeting point</td>
                        <td class=" float-right p-3"> {{ $post->venue }}</td>
                    </tr>
                    <tr class=" border-b border-gray-200">
                        <td class="p-3 font-semibold"> Category</td>
                        <td class=" float-right p-3"> <a
                                href="{{ route('getposts.bycategory', ['m' => 'marketplace', 'c' => $post->subcategory->slug]) }}"
                                class=" float-right p-3 text-green-500 italic">{{ $post->subcategory->name }}</a> </td>
                    </tr>
                    <tr>
                        <td class="p-3 font-semibold"> Campus</td>
                       
                        <td class=" float-right p-3 text-green-500 italic">
                          
                            <a
                                href="/{{$post->alias_campus ? $post->alias_user_campus->nick_name: $post->user->campus->nick_name }}">{{ $post->alias_user_campus ? $post->alias_user_campus->name: $post->user->campus->name }}</a>
                        
                     </td>
                    </tr>
                </table>
                @include('include.convince')
            </div>


            <div class=" lg:col-span-2">

                <div class=" mt-3 p-3 bg-gray-50 lg:mt-0 lg:rounded-sm">
                    <h3 class=" font-semibold border-b border-gray-200 pb-2">Posted by:</h3>
                    <p class=" text-xl my-3 flex items-center">
                        @if ($post->user->avatar == null || $post->user->avatar == 'users/default.png')
                            <span class="fa fa-user-circle fa-2x text-gray-400 mr-2"></span>
                        @else
                            <img src="{{ $post->user->avatar }}"
                                class=" w-20 h-20 rounded-full border-2 border-green-300 object-cover mr-3 " alt="">
                        @endif

                        @if ($post->alias)
                            {{ $post->alias }}

                        @else
                            {{ $post->user->name }}

                        @endif
                    </p>
                    <p class=" font-medium text-center text-base my-2">Contact seller via:</p>
                    <div class=" grid grid-cols-2 gap-3">
                        <a href="tel:0{{ $post->contact_info }}"
                            class=" block p-3 text-center font-semibold focus:border-green-500 rounded-md contact bg-gray-200"><i
                                class="fa fa-phone mr-3  text-green-500 "></i> Call</a>
                        <a href="https://wa.me/234{{ $post->contact_info }}?text=Hello%20{{ $post->user->name }},%20I%20saw%20your%20adverstisement%20on%20www.percampus.com%20I%20want%20to%20ask%20if%20the%20item%20you%20posted%20is%20still%20available%20for%20sale"
                            class="font-semibold block p-3 text-center focus:border-green-500 rounded-md contact bg-green-200"><i
                                class="fab fa-whatsapp mr-3  text-green-500"></i> Whatsapp</a>

                    </div>

                </div>

             

                @if (count($similarPosts) > 1)
                    <div class=" mt-3 p-3 bg-gray-50   lg:rounded-sm ">
                        <h3 class=" my-3 font-semibold text-lg">Similar Items for sale</h3>
                        <div class=" overflow-auto whitespace-nowrap">
                            @foreach ($similarPosts as $similarPost)
                                @php
                                    if ($similarPost->id == $post->id) {
                                        continue;
                                    }
                                @endphp

                                <div
                                    class="border border-gray-200 md:border-none md:shadow-md  bg-white     rounded-sm inline-block w-40 mr-2">

                                    <div class=" col-span-2  ">
                                        <a
                                            href="/{{ $similarPost->user->campus->nick_name }}/{{ $similarPost->subcategory->slug }}/{{ $similarPost->slug }}">
                                            @if (is_object($similarPost->images()->first()))
                                                <img src="{{ $similarPost->images()->first()->Image_path }}"
                                                    class=" w-full  object-fill  rounded-t-sm h-32 md:h-40   md:rounded-b-none md:rounded-t-sm"
                                                    lazy="loading" alt="{{ $similarPost->title }}">
                                            @endif
                                        </a>

                                    </div>
                                    <div class="col-span-4  flex flex-col justify-center md:justify-start px-3 py-2">
                                        <h3
                                            class=" text-sm md:text-lg text-gray-600 mb-2 font-semibold overflow-hidden whitespace-nowrap overflow-ellipsis">
                                            <a href="/{{ $similarPost->user->campus->nick_name }}/{{ $similarPost->subcategory->slug }}/{{ $similarPost->slug }}"
                                                class="focus:text-green-600">{{ $similarPost->title }}</a>
                                        </h3>

                                        <p>
                                            <small class=" text-green-500  text-xs md:text-base font-semibold"> N
                                                {{ $similarPost->price }} </small>

                                        </p>
                                    </div>
                                </div>


                            @endforeach

                           
                        </div>

                    </div>
                @endif


                {{-- Bottom Ads section --}}
                @if ($ads->count() > 0)
                    <div class=" mt-3 bg-gray-50 p-3 lg:rounded-sm">
                        <h2 class=" my-3 font-bold  tracking-wide">Sponsored</h2>

                        <div class=" md:grid md:grid-cols-2 md:gap-3">
                            @foreach ($ads as $ad)
                                @if ($ad->position == 'bottom')
                                    <div class=" border-2 border-gray-200 rounded-sm  my-2">
                                        <a href="{{ $ad->link }}" target="_blank"
                                            class="adclick grid grid-cols-6 gap-2 md:grid-cols-1 md:gap-0 md:gap-y-2 "
                                            id="{{ $ad->id }}">
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
                    <p class=" md:text-lg mb-5">Share to a friend who you think might also be interested in this item</p>
                    {!! $social !!}
                </div>
                {{-- end of Social share --}}

                {{-- @if (!Auth::guest())
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

@section('js')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            $(".contact").click(function() {

                // let _token = $('meta[name="csrf-token"]').attr('content');
                let postID = {{ $post->id }};


                $.ajax({
                    type: "POST",
                    url: "{{ route('contact.seller') }}",
                    data: {
                        postID: postID
                    }
                    // success : function(data) {
                    //     console.log(data.success);
                    // },
                });



            });

            $(".adclick").click(function() {
                let adID = $(this).attr('id');

                $.ajax({
                    type: "POST",
                    url: "{{ route('ad.click') }}",
                    data: {
                        adID: adID
                    }
                    // success : function(data) {
                    //     console.log(data.success);
                    // },
                });

            });


        });
    </script>
@endsection
