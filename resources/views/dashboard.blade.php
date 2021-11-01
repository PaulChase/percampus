@extends('layouts.app')

@section('title') {{ Auth::user()->name }} dashboard @endsection

@section('content')
    <div class=" bg-gray-200">

        <div class=" max-w-xl mx-auto py-2 ">
            <div class=" bg-gray-50 p-3">
                @if (auth()->user()->avatar == null || auth()->user()->avatar == 'users/default.png')
                    <p class=" my-2 bg-gray-100 rounded-sm p-2">Buyers are likely to call you if they see the face of the
                        seller, so update your DP</p>
                @endif
                <div class=" relative">

                    <button class=" absolute right-2 top-2 p-1 border border-gray-200 bg-gray-100 rounded-md "
                        id="showformforpic"><i class=" fa fa-pen mx-1"></i> Edit Profile Pic</button>
                </div>
                <div class=" text-center p-3 ">

                    @if (auth()->user()->avatar == null || auth()->user()->avatar == 'users/default.png')
                        <p class=" my-4"><i class="fa fa-user-circle fa-7x text-gray-400"></i></p>

                    @else
                        <img src="{{ auth()->user()->avatar }}"
                            class=" w-44 h-44 rounded-full mx-auto border-4 border-green-300 object-cover my-4" alt="">
                    @endif

                    <p><strong class=" text-xl">{{ Auth::user()->name }}</strong> <br>
                        <span>{{ Auth::user()->campus->name ?? ' ' }}</span> <br>
                        <span class=" italic">Email: {{ Auth::user()->email }}</span>
                    </p>
                </div>
            </div>

            <div id="updatepic" class=" fixed  w-full h-full z-20 overflow-auto  top-0 left-0  hidden   "
                style="background-color: rgba(0,0,0,0.7); ">
                <div class=" bg-white bottom-0 absolute w-full rounded-t-lg p-4">
                    <button class=" float-right m-3 bg-gray-200 px-3 py-1 rounded-full focus:bg-gray-500"
                        id="closeformforpic">X</button><br>

                    <form action="{{ route('update.profilepic') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="" class=" font-semibold ">Select the Picture you want as your Profile Pic (it shouldn't
                            be more than 3MB in size oo)</label>
                        <input type="file" name="profilepic"
                            class="p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
                            required>

                        <input type="submit" name="submit"
                            class="uppercase font-semibold bg-green-500 hover:bg-green-600 focus:outline-none focus:bg-green-600 w-full rounded-md p-3  text-white  text-center my-5"
                            value="Update Picture">

                    </form>
                </div>
            </div>

            <div class=" my-2 bg-gray-50 p-3 text-base text-center">
                <span>The more students that join us on the website, the fatser your items will be sold, the more money
                    you'll make... It's A win win. </span>
                <button class="block mx-auto  text-white font-semibold bg-green-500 my-4 rounded-md shadow-lg px-6 py-2"
                    id="showRefer">Invite Your Friends now</button>
            </div>

            <div class=" fixed  w-full h-full z-10 overflow-auto  top-0 left-0 text-center hidden "
                style="background-color: rgba(0,0,0,0.5); " id='refer'>
                <div class=" p-3 w-4/5 bg-white rounded-md md:w-2/5 relative mx-auto my-40">
                    <h4 class=" font-semibold my-4 ">Share your referral Link to:</h4>
                    <button
                        class=" float-right font-semibold absolute top-3 right-6 bg-gray-300 rounded-full px-2 py-1 focus:bg-gray-500"
                        id="closeRefer">X</button>

                    <p>
                        <a href="https://wa.me/?text={{ rawurlencode('Great Nigerian student, you have been invited to join Percampus - the fastest growing online marketplace for students to buy and sell new and used items to one another. click the link below to see the items available on your campus. https://www.percampus.com/join?refer=') }}{{ Auth::user()->id }}"
                            class=" block w-4/5 mx-auto p-3 rounded-2xl border-2 text-center font-medium border-gray-100 mb-3 focus:border-green-500">
                            <i class=" fab fa-whatsapp mr-2 "></i>WhatsApp</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.percampus.com/join?refer={{ Auth::user()->id }}"
                            class=" block w-4/5 mx-auto p-3 rounded-2xl border-2 text-center font-medium border-gray-100 mb-3 focus:border-green-500">
                            <i class=" fab fa-facebook mr-2 "></i>Facebook</a>

                    </p>
                </div>
            </div>

            {{-- for only admins --}}
            @if (Auth::user()->role_id == 1)
                <div class=" my-2 bg-gray-50 p-3 flex justify-between items-center">
                    <a href="{{ route('metrics') }}"
                        class="border-2 border-green-200 rounded-md p-3 text-center font-semibold " target="_blank">Boss
                        Arena</a>
                    <a href="/admin" class="border-2 border-green-200 rounded-md p-3 text-center font-semibold "
                        target="_blank">Admin Panel</a>
                    <a href="/checkpoint" class="border-2 border-green-200 rounded-md p-3 text-center font-semibold "
                        target="_blank">Check Point</a>
                </div>
            @endif


            <div class=" my-2 font-semibold bg-gray-50 p-3 flex justify-between items-center">
                <span>Your Recent Posts</span>
                <a href="/posts/create" class=" bg-green-500 py-2 px-3 rounded-sm text-white">Add a Post</a>
            </div>



            <div class=" my-2 bg-gray-50 p-3">

                @if (count($posts) > 0)

                    @foreach ($posts as $each_post)
                        <div class=" border-2 border-gray-200 rounded-md my-3 px-4 py-3 ">
                            <div class="">
                                <h2 class="text-xl text-gray-700 font-semibold mb-2">{{ $each_post->title }}</h2>
                                <p class=" flex justify-between my-3">
                                    <small>views: <span class=" text-green-400">{{ $each_post->view_count }}</span></small>
                                    <small> status: <span class=" font-semibold @if ($each_post->status == 'rejected') {{ 'text-red-500' }}
                                        @elseif ( $each_post->status == 'pending') {{ 'text-yellow-500' }}
                                        @else {{ 'text-green-500' }} @endif
                                            ">{{ $each_post->status }}</span> </small>
                                    <small> Added: {{ $each_post->created_at->diffForHumans() }}</small>
                                </p>
                            </div>

                            <div class=" flex justify-between mt-2">
                                <div>
                                    <a href="/{{ $each_post->user->campus->nick_name }}/{{ $each_post->subcategory->slug }}/{{ $each_post->slug }}"
                                        class=" bg-gray-200 py-2 px-3 rounded-md inline-block hover:bg-gray-400 focus:bg-gray-400">
                                        <i class="la la-paint-brush"></i> View</a>
                                </div>
                                <div>
                                    <a href="/posts/{{ $each_post->id }}/edit"
                                        class=" bg-gray-200 py-2 px-3 rounded-md inline-block hover:bg-gray-400 focus:bg-gray-400">
                                        <i class="la la-paint-brush"></i> Edit</a>
                                </div>
                                <div>
                                    <form action="{{ route('posts.delete', ['id' => $each_post->id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" name="submit"
                                            class="text-red-400 font-semibold py-2 px-2 rounded-md hover:bg-red-300 hover:text-white focus:bg-red-300 focus:text-white">
                                            <i class="la la-trash"></i> Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                @else
                    <div class=" bg-gray-100 text-xl rounded-md p-4  my-3 text-center">
                        <p>You have no Posts yet, Try Adding some.</p>
                    </div>
                @endif

            </div>
            @if (Auth::user()->role_id == 1)
                <div class=" my-2 font-semibold bg-gray-50 p-3 flex justify-between items-center">
                    <span>My Active Ads</span>
                    <a href="/ads/create" class=" bg-green-500 py-2 px-3 rounded-sm text-white">Create Ad</a>
                </div>
                <div class=" p-3 bg-gray-50 my-2 lg:grid  lg:gap-3">
                    @if (count($ads) > 0)
                        @foreach ($ads as $ad)
                            <div class=" border-2 border-gray-200 rounded-sm  my-2">
                                <a href="{{ $ad->link }}" target="_blank"
                                    class="grid grid-cols-6 gap-2 md:grid-cols-1 md:gap-0 md:gap-y-2 ">
                                    <div class="col-span-4  p-2 my-auto">
                                        <h3 class="  font-semibold">{{ $ad->title }}</h3>
                                        <p>url: {{ $ad->link }}</p>
                                        <p>status: {{ $ad->status }}</p>
                                        <p>Clicks: <span class=" text-green-500">{{ $ad->linkClick }}</span></p>
                                    </div>
                                    <div class="col-span-2 md:order-first">
                                        <img src="{{ $ad->image_url }}"
                                            class=" rounded-sm h-28 md:h-28 w-full object-cover" alt="{{ $ad->title }}">
                                    </div>

                                </a>
                                <div class="flex justify-between my-2 p-3 bg-gray-50 lg:rounded-sm">
                                    <div>
                                        <a href="/ads/edit/{{ $ad->id }}"
                                            class=" bg-gray-200 px-3 py-2 rounded-sm inline-block "> Edit Ad</a>
                                    </div>
                                    <div>
                                        <button id="pausead" class=" border-2 border-gray-300 px-3 py-2 rounded-sm inline-block " adID="{{ $ad->id}}">Pause Ad</button>
                                    </div>
                                    <form action="{{ route('ads.delete', ['ad' => $ad->id]) }}" method="POST" id="submitPause">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="status" value="paused">
                                            
                                        </form>
                                    <div>
                                        <form action="{{ route('ads.delete', ['ad' => $ad->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="status" value="deleted">
                                            <input type="submit" name="submit" value="Delete Ad"
                                                class=" inline-block bg-red-400 px-3 py-2  rounded-sm">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div> There are No Ads</div>
                    @endif
                </div>
            @endif
            <div class=" bg-red-100 rounded-md p-2">
                <a class="block font-semibold  no-underline md:font-medium hover:no-underline py-2  hover:text-black md:border-none md:p-0 "
                    href="{{ route('logout') }}" onclick="event.preventDefault();
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


@section('js')
    <script>
        

        $(document).ready(function() {
            // $("#refer").hide();

            

            

            $("#pausead").click(function(e) {
                e.preventDefault();
                $("#submitPause").submit()
                
            })

            $("#closeRefer").click(function() {
                $("#refer").hide(500);
            })

            $("#showRefer").click(function() {
                $("#refer").show(500);
            })

            $("#showformforpic").click(function() {
                $("#updatepic").show(500)
            })

            $("#closeformforpic").click(function() {
                $("#updatepic").hide(500)
            })

            
        });

    </script>
@endsection
