@extends('layouts.app')

@section('title')
  {{ Auth::user()->name }} dashboard
@endsection

@section('content')
  <div class=" bg-gray-200 lg:p-3">

    <div class="  mx-auto py-2 lg:grid lg:grid-cols-6 lg:gap-3 max-w-7xl ">
      <div class=" lg:col-span-2 ">
        <div class=" bg-gray-50 p-3">

          @if (auth()->user()->avatar == null || auth()->user()->avatar == 'users/default.png')
            <p class=" my-2 bg-gray-100 rounded-sm p-2">Clients are likely to contact you if they see the face of
              the
              seller, so update your DP</p>
          @endif

          {{-- button to open profile pic form --}}
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

        @if (!auth()->user()->hasVerifiedEMail())
          <div class=" my-2 bg-gray-50 p-3 text-base   text-center">
            <p>Hello {{ auth()->user()->name }}, <br> to enjoy the full previledges of this website you need to verify
              your email.</p> <br>
            <form class="" method="POST" action="{{ route('verification.resend') }}">
              @csrf

              <button type="submit" class="font-bold text-green-600">Click here to receive verification email</button>.
            </form>


          </div>
        @endif

        {{-- form to update profil pic --}}
        <div id="updatepic" class=" fixed  w-full h-full z-20 overflow-auto  top-0 left-0  hidden    "
          style="background-color: rgba(0,0,0,0.7); ">
          <div class=" bg-white bottom-0 absolute w-full rounded-t-lg p-4 lg:w-1/3">
            <button class=" float-right m-3 bg-gray-200 px-3 py-1 rounded-full focus:bg-gray-500"
              id="closeformforpic">X</button><br>

            <form action="{{ route('update.profilepic') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <label for="" class=" font-semibold ">Select the Picture you want as your Profile Pic (it
                shouldn't
                be more than 3MB in size )</label>
              <input type="file" name="profilepic"
                class="p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
                required>

              <input type="submit" name="submit"
                class="uppercase font-semibold bg-green-500 hover:bg-green-600 focus:outline-none focus:bg-green-600 w-full rounded-md p-3  text-white  text-center my-5"
                value="Update Picture">

            </form>
          </div>
        </div>


        <div class=" my-2 bg-gray-50 py-3 px-5 text-base text-center">
          <p class=" font-semibold  mt-2">Refer 10 other students with your link below to unlock 5 more additional
            posts</p><br>
          <input type="text" value="https://www.percampus.com/join?refer={{ Auth::user()->id }}" id="referlink" disabled
            class=" bg-gray-200 rounded-md w-full overflow-auto  text-center p-2 "> <br>
          <div class=" mx-auto">
            <button id="copylink" onclick="copyLink()"
              class="bg-green-500 my-4 rounded-md shadow-lg px-3 py-2 font-semibold  text-white"><i
                class="fa fa-link mr-2"></i>Copy Link</button>

            <button class=" ml-3 font-semibold  px-6 py-2" id="showRefer"> Share to <i
                class="fa fa-share ml-2"></i></button>
          </div>
        </div>

        <div class=" fixed  w-full h-full z-10 overflow-auto  top-0 left-0 text-center hidden "
          style="background-color: rgba(0,0,0,0.5); " id='refer'>
          <div class=" p-3 w-4/5 bg-white rounded-md md:w-2/5 relative mx-auto my-40">
            <h4 class=" font-semibold my-4 ">Share your referral Link to:</h4>
            <button
              class=" float-right font-semibold absolute top-3 right-6 bg-gray-300 rounded-full px-2 py-1 focus:bg-gray-500"
              id="closeRefer">X</button>

            <p>
              <a href="https://wa.me/?text={{ rawurlencode('Great Nigerian student, you have been invited to join Percampus - the fastest growing online marketplace for students to buy and sell new and used items, offer services to one another. click the link below to see the items available on your campus. https://www.percampus.com/join?refer=') }}{{ Auth::user()->id }}"
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
              class="border-2 border-green-200 rounded-md p-3 text-center font-semibold " target="_blank">Metrics</a>
            <a href="/admin" class="border-2 border-green-200 rounded-md p-3 text-center font-semibold "
              target="_blank">Admin Panel</a>
            <a href="/checkpoint" class="border-2 border-green-200 rounded-md p-3 text-center font-semibold "
              target="_blank">CheckPoint</a>
          </div>
        @endif

        <div class=" my-2 bg-gray-50 p-3 text-base grid grid-cols-2 gap-5">
          <div class="border-2 border-gray-200 rounded-md  text-center p-3 font-semibold"> <span
              class=" text-green-600 font-semibold text-3xl mb-3  inline-block rounded-full ">{{ Auth::user()->post_limit - $noOfUserActivePosts }}</span><br>Posts
            Remaining
          </div>
          <div class="border-2 border-gray-200 rounded-md text-center p-3 font-semibold "> <span
              class="text-green-600 font-semibold text-3xl mb-3  inline-block rounded-full ">
              {{ Auth::user()->referrals->count() }}</span><br>
            Referrals
          </div>
          <div class="border-2 border-gray-200 rounded-md text-center p-3 font-semibold"> <span
              class="text-green-600 font-semibold text-3xl mb-3  inline-block rounded-full ">
              {{ Auth::user()->posts->count() }}</span><br>
            Posts Created
          </div>
          <div class="border-2 border-gray-200 rounded-md text-center p-3 font-semibold"> <span
              class="text-green-600 font-semibold text-3xl mb-3  inline-block rounded-full ">
              {{ Auth::user()->posts()->sum('view_count') +auth()->user()->postViews->count() }}</span><br>
            Post views
          </div>

        </div>


      </div>

      <div class=" lg:col-span-4 ">

        <div class=" my-2 lg:my-0 font-semibold bg-gray-50 p-3 flex justify-between items-center">
          <a href="{{ route('user.posts') }}" class=" font-semibold text-green-600 text-lg">View all your posts</a>
          @if (Auth::user()->role_id == 1)
            <button class="addPost bg-green-500 py-2 px-3 rounded-sm text-white">Add a Post</button>
          @endif

          

        </div>

        @if (count(Auth::user()->posts) == 1)
            <div class=" bg-gray-100 text-xl rounded-md p-4  my-3 text-center">
              <p>Sell your first item or service today to see how easy the process is. <br> Start by clicking the "sell
                A..." button at top right</p>
            </div>
          @endif








        @if (Auth::user()->role_id == 1)
          <div class=" my-2 font-semibold bg-gray-50 p-3 flex justify-between items-center">
            <span>My Active Ads</span>
            <a href="/ads/create" class=" bg-green-500 py-2 px-3 rounded-sm text-white">Create Ad</a>
            <a href="/opportunities/create" class=" bg-green-500 py-2 px-3 rounded-sm text-white">Add
              Opportunity
            </a>
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
                      <img src="{{ $ad->image_url }}" class=" rounded-sm h-28 md:h-28 w-full object-cover"
                        alt="{{ $ad->title }}">
                    </div>

                  </a>
                  <div class="flex justify-between my-2 p-3 bg-gray-50 lg:rounded-sm">
                    <div>
                      <a href="/ads/edit/{{ $ad->id }}" class=" bg-gray-200 px-3 py-2 rounded-sm inline-block ">
                        Edit Ad</a>
                    </div>
                    <div>
                      <button id="pausead" class=" border-2 border-gray-300 px-3 py-2 rounded-sm inline-block "
                        adID="{{ $ad->id }}">Pause Ad</button>
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
                                                    document.getElementById('logout-form').submit();"> <i
              class="la la-mail-reply mr-2"></i>
            {{ __('Logout') }}
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class=" hidden ">
            @csrf
          </form>
        </div>


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

      // for controlling the form for users to upload a profile pic
      $("#showformforpic").click(function() {
        $("#updatepic").show(500)
      })

      $("#closeformforpic").click(function() {
        $("#updatepic").hide(500)
      })


    });
  </script>
@endsection
