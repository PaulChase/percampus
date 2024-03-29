@extends('layouts.focused')

@section('title')
  Welcome to the Number One online marketplace for students on campus
@endsection


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
            Profile
					</a>
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
            <form action="{{ url('search') }}" class=" flex bg-white px-4 py-3  rounded-full text-base shadow-xl">
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
          <img
            src="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/public/bg/experimental-online-shopping-1+(1)+(1).png"
            alt="">
        </div>

      </div>
    </div>
  </header>
  {{-- end of hero section --}}



  <main class=" bg-gray-50 text-gray-700 m-0">


    <div class="p-3">
      <h3 class="p-3  font-semibold text-xl lg:text-2xl my-5 bg-green-200 rounded-md text-green-700"> What other Students
        are Selling </h3>
      <div class="grid gap-5 grid-cols-2 lg:grid-cols-4 lg:px-5">
        @foreach ($posts as $each_item)
          <div class=" md:border-none md:shadow-md  bg-white     rounded-md md:grid-cols-1  md:gap-y-2 ">

            <div class="">
              <a
                href="{{ route('posts.show', $each_item->slug)}}">
                @if (is_object($each_item->images()->first()))
                  <img src="{{ $each_item->images()->first()->Image_path }}"
                    class=" w-full  object-cover  rounded-md h-36 md:h-48   md:rounded-b-none md:rounded-t-md"
                    lazy="loading" alt="{{ $each_item->title }}">
                @endif
              </a>

            </div>
            <div class="col-span-4  flex flex-col justify-center md:justify-start px-3 py-2">
              <h3
                class=" text-sm md:text-lg text-gray-600 mb-2 font-semibold overflow-hidden whitespace-nowrap overflow-ellipsis">
                <a href="{{ route('posts.show', $each_item->slug)}}"
                  class="focus:text-green-600">{{ $each_item->title }}</a>
              </h3>

              <p>
                <span class="block italic">In <span
                    class=" uppercase">{{ $each_item->alias_campus ? $each_item->alias_user_campus->nick_name : $each_item->user->campus->nick_name }}</span>
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
        <a href="{{ route('posts.index', ['sub_category'=> 2])}}"
          class="focus:bg-green-700 rounded-md">
          <img src="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/icons/smartphone.png"
            alt="" class=" h-24  w-24 mx-auto my-2 lg:w-40 lg:h-40">
          <h4 class=" font-semibold">Mobile Phones</h4>
        </a>
        <a class="focus:bg-green-700 rounded-md"
          href="{{ route('posts.index', ['sub_category'=> 4])}}">
          <img src="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/icons/clothes-hanger.png"
            alt="" class=" h-24  w-24 mx-auto my-2 lg:w-40 lg:h-40">
          <h4 class=" font-semibold"> Men's Clothing</h4>
        </a>
        <a href="{{ route('posts.index', ['sub_category'=> 8])}}"
          class="focus:bg-green-700 rounded-md">
          <img src="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/icons/laptop.png"
            alt="" class=" h-24  w-24 mx-auto my-2 lg:w-40 lg:h-40">
          <h4 class=" font-semibold">Laptops & PC</h4>
        </a>
        <a href="{{ route('posts.index', ['sub_category'=> 5])}}"
          class="focus:bg-green-700 rounded-md">
          <img src="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/icons/cosmetics.png"
            alt="" class=" h-24  w-24 mx-auto my-2 lg:w-40 lg:h-40">
          <h4 class=" font-semibold">Beauty & Jewelries </h4>
        </a>
      </div>
      <div class="my-8">
        <a href="{{ route('getSubCategories') }}"
          class="block mx-auto w-3/4 p-3 bg-white rounded-full text-green-500 text-center font-semibold focus:bg-green-500 focus:text-white lg:w-1/3 lg:p-5 lg:text-xl ">
          Explore All Categories <i class="fa fa-chevron-right ml-2"></i></a>
      </div>
    </div>


    <div class="p-3 bg-white">
      <h3 class="p-3  font-semibold text-xl lg:text-2xl  my-5 bg-green-200 rounded-md text-green-700"> Recent Services
        from other students </h3>
      <div class="grid gap-4 lg:grid-cols-4  lg:px-5">
        @foreach ($gigs as $each_gig)
          <div
            class="border border-gray-200 md:border-none md:shadow-md  bg-white grid grid-cols-5   rounded-md md:grid-cols-1  md:gap-y-2 ">

            <div class=" col-span-2   ">
              <a
                href="{{ route('posts.show', $each_gig->slug)}}">
                @if (is_object($each_gig->images()->first()))
                  <img src="{{ $each_gig->images()->first()->Image_path }}"
                    class=" w-full  object-cover  rounded-l-md h-32 md:h-48   md:rounded-b-none md:rounded-t-md"
                    lazy="loading" alt="{{ $each_gig->title }}">
                @endif
              </a>

            </div>
            <div class="col-span-3  flex flex-col justify-between md:justify-start p-3">
              <h3 class=" text-sm md:text-lg text-gray-600 mb-2 font-semibold gigtext">
                <a href="{{ route('posts.show', $each_gig->slug)}}"
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
        <a href="{{ route('getSubCategories') }}"
          class="block col-span-2 lg:w-1/3 lg:p-5 lg:text-xl p-3  rounded-full text-green-500 text-center font-semibold focus:bg-green-700 focus:text-white">
          View by Category <i class="fa fa-chevron-right ml-2"></i></a>
        <a href="/gigs"
          class="block col-span-1  lg:w-1/3 lg:p-5 lg:text-xl p-3 bg-green-500 rounded-full text-white text-center font-semibold focus:bg-green-700">
          More Services <i class="fa fa-chevron-right ml-2"></i></a>
      </div>
    </div>
    </div>

    


    <div class=" bg-gray-700 px-4   text-base lg:text-lg text-white     lg:px-10 py-24 ">
      <h2 class=" uppercase mb-16 font-bold text-xl lg:text-2xl">Steps to selling your 1st product/service</h2>
      <div class=" overflow-auto whitespace-nowrap py-4 ">
        <div class="w-3/5 lg:w-1/4  inline-block mr-5  whitespace-normal align-top shadow-xl p-4 bg-gray-800 rounded-md">
          <i class="fa fa-pen-square fa-3x mb-4"></i>
          <p class=" ">You will quickly <a href="/register" class=" underline">register here</a>, don't worry the
            process is very easy.</p>
        </div>
        <div
          class="w-3/5 lg:w-1/4  inline-block mr-5   whitespace-normal align-top  shadow-xl p-4 bg-gray-800 rounded-md">
          <i class="fa fa-mouse-pointer fa-3x mb-4"></i>
          <p>Next, click the green 'sell A...' button at the top right corner and pick whether you want to sell a product
            or service.</p>
        </div>
        <div class="w-3/5 lg:w-1/4  inline-block mr-5  whitespace-normal align-top shadow-xl p-4 bg-gray-800 rounded-md">
          <i class="fa fa-upload fa-3x mb-4"></i>
          <p>Fill in few details about the product or service such as name, price etc. Also upload an image to better
            decribe the product and then click the submit button when you're done.</p>
        </div>
        <div class="w-3/5 lg:w-1/4  inline-block mr-5  whitespace-normal align-top shadow-xl p-4 bg-gray-800 rounded-md">
          <i class="fa fa-check-circle fa-3x mb-4"></i>
          <p>Your post will be submitted for review and within a few minutes you will receive an email if it was approved
            or not. You can always visit your dashboard to check your post status </p>
        </div>
      </div>

      <a href="/register"
        class=" rounded-full border-2 py-3 px-5 text-base bg-green-500 border-green-500 focus:bg-green-700 focus:border-green-700 md:text-lg block  lg:w-1/3 lg:p-4 lg:text-xl mx-auto mt-6 lg:mt-12 font-semibold text-center">Sign
        Me up ASAP</a>
     
    </div>


    <div class=" text-center p-4 lg:grid lg:grid-cols-2 lg:my-12 py-16">
      <img src="https://elasticbeanstalk-us-east-2-481189719363.s3.us-east-2.amazonaws.com/icons/school.png"
        alt="" class="h-40 w-40 lg:w-60 lg:h-60 mx-auto my-4">
      <div class="lg:text-2xl">
        <p class=" text-2xl font-semibold lg:text-3xl">Want to view items for sale on your campus?</p>
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
