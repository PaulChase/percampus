@extends('layouts.focused')

@section('title') Welcome to the Number 1 online marketplace for students on campus @endsection


@section('focus')


    <header class="text-white gray-70  ">


        <div class="bg-green-700 w-full h-full  px-2">
            <nav class=" flex flex-row justify-between max-w-7xl mx-auto items-center p-4">
                <h1 class=" no-underline hover:no-underline font-extrabold  text-2xl lg:text-3xl tracking-wide">
                    Per Campus </h1>
                @guest
                    <a href="/register"
                        class=" inline-block border-2border-green-400 px-4 py-3 rounded-full  text-sm font-semibold md:text-base focus:bg-green-700 bg-white text-gray-600 ">
                        Register</a>
                @else
                    <a href="/dashboard"
                        class=" inline-block border-2border-green-400 px-4 py-3 rounded-full  text-sm font-semibold md:text-base focus:bg-green-700 bg-white text-gray-600 ">My
                        Profile</a>
                @endguest


            </nav>
            <div
                class="flex flex-col lg:flex-row justify-center lg:justify-between items-center md:max-w-6xl md:mx-auto py-6 lg:py-10">
                <div class="px-2  w-full my-10 lg:my-14 lg:max-w-2xl">

                    <p class=" text-3xl lg:text-4xl lg:max-w-3xl  font-extrabold my-3">
                        Sell your products and services 10x faster to students on your campus
                    </p>
                    <p class=" lg:text-lg font-medium lg:font-semibold">
                        We are here to help you reach more students, all you have to do is post about your products or
                        services you offer and we'll do the marketing for you.
                    </p>
                    <div class=" my-6">
                        <form action="{{ url('search') }}"
                            class=" flex bg-white px-4 py-3  rounded-full text-base shadow-xl">
                            <input name="query" type="text" placeholder="I am looking for..."
                                class=" w-full outline-none text-gray-600 focus:bg-white" required>
                            <button type="submit" class=" focus:bg-green-600 focus:text-white text-green-500 "><i
                                    class="fa fa-search "></i></button>
                        </form>

                    </div>
                    <p class="grid gap-3 grid-cols-2 py-4">
                        <a href="/register"
                            class=" inline-block  opacity-100 py-3  rounded-full text-sm font-bold md:text-base focus:bg-green-800 text-white    text-center border-2 border-white">Become
                            a Seller <i class="fa fa-chevron-right ml-2"></i></a>
                        <a href="/posts"
                            class=" inline-block    rounded-full py-3 text-sm font-semibold md:text-base border-2 border-green-500  bg-green-500 focus:border-green-700  shadow-xl  text-center text-white">View
                            Items for Sale</a>
                    </p>
                </div>
                <div class=" lg:w-96 hidden lg:block">
                    <img src="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/public/bg/experimental-online-shopping-1+(1)+(1).png"
                        alt="">
                </div>

            </div>
        </div>
    </header>
    {{-- end of hero section --}}


    <main class=" bg-gray-50 text-gray-700 m-0">


        <div class="p-3">
            <h3 class="p-3  font-semibold text-xl lg:text-2xl my-3"> What other Students are Selling </h3>
            <div class="grid gap-3 grid-cols-2 lg:grid-cols-4 lg:px-5">
                @foreach ($posts as $each_item)
                    <div class=" md:border-none md:shadow-md  bg-white     rounded-md md:grid-cols-1  md:gap-y-2 ">

                        <div class="   ">
                            <a
                                href="/{{ $each_item->user->campus->nick_name }}/{{ $each_item->subcategory->slug }}/{{ $each_item->slug }}">
                                @if (is_object($each_item->images()->first()))
                                    <img src="{{ $each_item->images()->first()->Image_path }}"
                                        class=" w-full  object-fill  rounded-md h-36 md:h-48   md:rounded-b-none md:rounded-t-md"
                                        lazy="loading" alt="{{ $each_item->title }}">
                                @endif
                            </a>

                        </div>
                        <div class="col-span-4  flex flex-col justify-center md:justify-start px-3 py-2">
                            <h3
                                class=" text-sm md:text-lg text-gray-600 mb-2 font-semibold overflow-hidden whitespace-nowrap overflow-ellipsis">
                                <a href="/{{ $each_item->user->campus->nick_name }}/{{ $each_item->subcategory->slug }}/{{ $each_item->slug }}"
                                    class="focus:text-green-600">{{ $each_item->title }}</a>
                            </h3>

                            <p>
                                <span class="block italic">In <span
                                        class=" uppercase">{{ $each_item->user->campus->nick_name }}</span>
                                    campus</span>
                                <small class=" text-green-500  text-xs md:text-base font-semibold">
                                    @if ($each_item->price > 0 && $each_item->price != '' && $each_item->price != ' ')
                                        N{{ $each_item->price }}
                                    @else
                                        {{ 'Contact Me' }}
                                    @endif
                                </small>
                            </p>
                        </div>
                    </div>


                @endforeach
            </div>
            <div class="my-8 ">

                <a href="/posts"
                    class="block mx-auto w-3/4 lg:w-1/3 lg:p-5 lg:text-xl p-3 bg-green-500 rounded-full text-white text-center font-semibold focus:bg-green-700">
                    View More <i class="fa fa-chevron-right ml-2"></i></a>
            </div>
        </div>
        </div>

        <div class="p-3 bg-green-700 text-white py-6">
            <h3 class=" uppercase font-bold text-2xl lg:text-4xl text-center my-5 p-2">Top categories</h3>
            <div class="grid gap-x-4 gap-y-8  grid-cols-2 text-center">
                <a href="{{ route('getposts.bycategory', ['m' => 'marketplace', 'c' => 'phones']) }}"
                    class="focus:bg-green-700 rounded-md">
                    <img src="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/icons/smartphone.png"
                        alt="" class=" h-24  w-24 mx-auto my-2 lg:w-40 lg:h-40">
                    <h4 class=" font-semibold">Mobile Phones</h4>
                </a>
                <a class="focus:bg-green-700 rounded-md"
                    href="{{ route('getposts.bycategory', ['m' => 'marketplace', 'c' => 'men']) }}">
                    <img src="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/icons/running-shoes.png"
                        alt="" class=" h-24  w-24 mx-auto my-2 lg:w-40 lg:h-40">
                    <h4 class=" font-semibold"> Shoes & Footwears</h4>
                </a>
                <a href="{{ route('getposts.bycategory', ['m' => 'marketplace', 'c' => 'women']) }}"
                    class="focus:bg-green-700 rounded-md">
                    <img src="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/icons/dress.png"
                        alt="" class=" h-24  w-24 mx-auto my-2 lg:w-40 lg:h-40">
                    <h4 class=" font-semibold">Women Clothings</h4>
                </a>
                <a href="{{ route('getposts.bycategory', ['m' => 'marketplace', 'c' => 'household']) }}"
                    class="focus:bg-green-700 rounded-md">
                    <img src="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/icons/book.png"
                        alt="" class=" h-24  w-24 mx-auto my-2 lg:w-40 lg:h-40">
                    <h4 class=" font-semibold">Books </h4>
                </a>
            </div>
            <div class="my-8">
                <a href="{{ route('getSubCategories', ['mainCategoryID' => 2]) }}"
                    class="block mx-auto w-3/4 p-3 bg-white rounded-full text-green-500 text-center font-semibold focus:bg-green-500 focus:text-white lg:w-1/3 lg:p-5 lg:text-xl ">
                    Explore All Categories <i class="fa fa-chevron-right ml-2"></i></a>
            </div>
        </div>
        <div class="p-3 bg-white">
            <h3 class="p-3  font-semibold text-xl lg:text-2xl my-3"> Recent Gigs from other students </h3>
            <div class="grid gap-4 lg:grid-cols-4  lg:px-5">
                @foreach ($gigs as $each_gig)
                    <div
                        class="border border-gray-200 md:border-none md:shadow-md  bg-white grid grid-cols-5   rounded-md md:grid-cols-1  md:gap-y-2 ">

                        <div class=" col-span-2   ">
                            <a
                                href="/{{ $each_gig->user->campus->nick_name }}/{{ $each_gig->subcategory->slug }}/{{ $each_gig->slug }}">
                                @if (is_object($each_gig->images()->first()))
                                    <img src="{{ $each_gig->images()->first()->Image_path }}"
                                        class=" w-full  object-cover  rounded-l-md h-32 md:h-48   md:rounded-b-none md:rounded-t-md"
                                        lazy="loading" alt="{{ $each_gig->title }}">
                                @endif
                            </a>

                        </div>
                        <div class="col-span-3  flex flex-col justify-between md:justify-start p-3">
                            <h3 class=" text-sm md:text-lg text-gray-600 mb-2 font-semibold gigtext">
                                <a href="/{{ $each_gig->user->campus->nick_name }}/{{ $each_gig->subcategory->slug }}/{{ $each_gig->slug }}"
                                    class="focus:text-green-600 ">{{ $each_gig->title }}</a>
                            </h3>

                            <p>
                                @if ($each_gig->price == 0)
                                    <span class=" uppercase text-xs">price depends</span>

                                @else
                                    <span class=" uppercase text-xs">starting from</span>
                                    <span class=" ml-3 text-green-500  text-base md:text-base font-semibold">
                                        N{{ $each_gig->price }} </span>
                                @endif

                            </p>
                        </div>
                    </div>


                @endforeach
            </div>
            <div class="mt-12 flex justify-between items-center text-sm">
                <a href="/s?mainCategoryID=4"
                    class="block col-span-2 lg:w-1/3 lg:p-5 lg:text-xl p-3  rounded-full text-green-500 text-center font-semibold focus:bg-green-700 focus:text-white">
                    View by Category <i class="fa fa-chevron-right ml-2"></i></a>
                <a href="/gigs"
                    class="block col-span-1  lg:w-1/3 lg:p-5 lg:text-xl p-3 bg-green-500 rounded-full text-white text-center font-semibold focus:bg-green-700">
                    View All Gigs <i class="fa fa-chevron-right ml-2"></i></a>
            </div>
        </div>
        </div>

        <div class="p-3">
            <div
                class=" bg-green-700  lg:py-44 shadow-inner px-4 py-16 rounded-md text-white my-3 text-center font-bold text-2xl lg:text-4xl">
                <p class="">Didn't find what you're looking? <br>
                </p>
                <button
                    class="showEnquiry shadow-inner my-3 font-semibold lg:text-xl lg:px-10  text-gray-500 focus:bg-gray-500 focus:text-white   inline-block bg-gray-50 rounded-full py-3 px-4 text-base lg:mt-8"><i
                        class=" fa fa-pen mr-1"></i>Click here to make a request here..</button>

            </div>
            <h3 class=" font-semibold text-lg mb-3 lg:text-2xl p-2">Requested items/Services</h3>

            <div class="grid gap-4 lg:grid-cols-4  lg:px-5">
                @foreach ($enquiries as $enquiry)
                    <div class=" border-2 border-gray-300 rounded-md p-3  space-y-2">
                        <h4 class=" text-lg font-semibold ">{{ $enquiry->message }}</h4>
                        <p class=" text-sm">In <span
                                class=" uppercase">{{ $enquiry->campus->nick_name }}</span> campus
                        </p>
                        <p class=" flex justify-between items-center"><span><i class=" fa fa-user mr-2"></i>
                                {{ $enquiry->name }}</span>
                            @if ($enquiry->contact_mode == 'call')
                                <a href="tel:0{{ $enquiry->contact_info }}"
                                    class="py-1 px-3 rounded-full border border-gray-400 bg-gray-200 contactBuyer"
                                    id="{{ $enquiry->id }}"><i class=" fa fa-phone mr-2"></i> Call</a>
                            @endif
                            @if ($enquiry->contact_mode == 'whatsapp')
                                <a href="https://wa.me/234{{ $enquiry->contact_info }}?text={{ rawurlencode("Hello $enquiry->name, I saw your post about  '$enquiry->message' on percampus.com") }}"
                                    class="contactBuyer py-1 px-2 rounded-full border border-green-400  bg-green-100"
                                    id="{{ $enquiry->id }}"><i class=" fab fa-whatsapp mr-2 text-green-500"></i>
                                    Whatsapp</a>

                            @endif
                        </p>
                    </div>

                @endforeach
            </div>
            <div class="my-12  ">

                <a href="/enquiries"
                    class="block mx-auto w-3/4 lg:w-1/3 lg:p-5 lg:text-xl p-3 bg-green-500 rounded-full text-white text-center font-semibold focus:bg-green-700">
                    View all requests <i class="fa fa-chevron-right ml-2"></i></a>
            </div>
        </div>


        {{-- call to action --}}
        @guest
            <div
                class=" bg-gray-700 px-4 py-24 h-auto text-xl text-white font-semibold text-center lg:h-72 lg:flex  lg:items-center lg:px-10">
                <p class=" md:w-3/12"><i class="fa fa-rocket fa-3x text-green-500 mb-6"></i></p>
                <div>
                    <p class=" lg:text-3xl "> If you start selling now, your items and Gigs will be seen first when buyers
                        start
                        flooding
                        in. <br> So what are you waiting for?</p>
                    <p class=""> <a href="/register"
                            class=" rounded-full border-2 py-3 px-5 text-base bg-green-500 border-green-500 focus:bg-green-700 focus:border-green-700 md:text-lg block my-7 lg:w-1/3 lg:p-5 lg:text-xl mx-auto">Sign
                            Me up ASAP</a></p>
                </div>
            </div>
        @endguest

        <div class=" text-center p-4 lg:grid lg:grid-cols-2 lg:my-12 py-16">
            <img src="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/icons/school.png" alt=""
                class="h-40 w-40 lg:w-60 lg:h-60 mx-auto my-4">
            <div>
                <p class=" text-2xl font-semibold ">Want to view items for sale on your campus?</p>
                <div class="my-8">
                    <a href="/allcampuses"
                        class="block mx-auto w-11/12 lg:w-3/5 p-3 bg-white rounded-full text-green-500 border-2 border-green-300  text-center font-semibold focus:bg-green-500 focus:text-white">
                        Visit your Campus marketplace <i class="fa fa-chevron-right ml-2"></i></a>
                </div>
            </div>

        </div>

        {{-- FAQ --}}
        <div class=" bg-gray-700 px-4 py-24 h-auto  text-white    lg:px-10">
            <div class=" max-w-2xl mx-auto">
                <h3 class=" font-bold text-lg text-center mb-5">Frequently Asked Questions (FAQ)</h3>
                <button class="accordion p-3 shadow-2xl rounded-lg font-semibold w-full text-left my-3">what's this site
                    all
                    about? <i class="fa fa-chevron-right float-right"></i></button>
                <div class="panel p-3 bg-gray-50 rounded-md text-gray-700  border-l-4 border-green-400 hidden">
                    <p>In summary, this is an online marketplace similar to jiji but for us students on campus to buy and
                        sell
                        both new and used items to one another.</p>
                </div>
                <button class="accordion p-3 shadow-2xl rounded-lg font-semibold w-full text-left my-3">who is the website
                    for?<i class="fa fa-chevron-right float-right"></i></button>
                <div class="panel p-3 bg-gray-50 rounded-md text-gray-700  border-l-4 border-green-400 hidden">
                    <p>The website is for any student on campus who wants to buy anything from their fellow students, sell a
                        new
                        or used product to their departmental students or campus at large.</p>
                </div>
                <button class="accordion p-3 shadow-2xl rounded-lg font-semibold w-full text-left my-3">How can this
                    website
                    benefit me?<i class="fa fa-chevron-right float-right"></i></button>
                <div class="panel p-3 bg-gray-50 rounded-md text-gray-700  border-l-4 border-green-400 hidden">
                    <p>With this website you are no longer limited to posting your products on whatsapp status or groups
                        every
                        now and then. You will now be able to reach all the thousands of students on your campus with a
                        single
                        post.</p>
                </div>
                <button class="accordion p-3 shadow-2xl rounded-lg font-semibold w-full text-left my-3">Can I make money
                    from
                    this website?<i class="fa fa-chevron-right float-right"></i></button>
                <div class="panel p-3 bg-gray-50 rounded-md text-gray-700  border-l-4 border-green-400 hidden">
                    <p>Sure, If you own a business on campus of selling products students wants to buy such as footwears,
                        clothes, phone accessories etc. You can definitely use this website as your personal online store to
                        showcase all the items you have in stock with thier prices. <br> The more you sell, the more you
                        earn.
                        The best part is that you keep all the profits (the website is totally FREE, we don't take any cut).
                    </p>
                </div>
            </div>
        </div>

        <div class=" max-w-2xl mx-auto px-4 py-12 lg:py-32  text-center text-xl lg:text-3xl font-semibold ">


            <p class=" font-semibold  ">You know a friend that this website may change his/her life for good?
                Don't hesitate to click the share buttons below </p>
            {!! $social !!}

        </div>

    </main>

    @include('include.enquiryform')

    @include('include.footer')

@endsection

@section('js')
    <script>
        // for the FAQ section
        $(document).ready(function() {
            $('.accordion').click(function() {
                $(this).next().toggle(500)
                $(this).toggleClass('text-green-500')
            })

        });
    </script>
@endsection
