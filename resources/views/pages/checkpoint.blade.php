@extends('layouts.app')

@section('title')
  Check Point
@endsection

@section('content')
  <div class=" bg-gray-200">

    <div class=" max-w-7xl mx-auto py-2 ">




      <div class=" my-2 bg-gray-50 p-3">
        <h2 class=" font-semibold text-xl text-center my-4">Pending Posts that needs Approval <span
            class=" text-green-400 font-semibold">({{ count($pendingPosts) }})</span></h2>
        @if (count($pendingPosts) > 0)
          <div class=" lg:grid lg:grid-cols-4 lg:gap-4 ">
            @foreach ($pendingPosts as $each_post)
              <div class=" border-2 border-gray-200 rounded-md my-3 px-4 py-3 " level="grand">
                <div class="">
                  <h2 class="text-xl text-gray-700 font-semibold mb-2">{{ $each_post->title }}</h2>
                  <hr>
                  <p class=" my-2">{{ $each_post->description }}</p>
                  <hr>


                  <small> Added: {{ $each_post->created_at->diffForHumans() }}</small>

                </div>

                <div class=" flex justify-between mt-2">
                  <div>
                    <a href="{{ route('posts.show', $each_post->slug) }}"
                      class=" bg-gray-200 py-2 px-3 rounded-md inline-block hover:bg-gray-400 focus:bg-gray-400">
                      <i class="la la-paint-brush"></i> View</a>
                  </div>
                  <div>
                    <button id="{{ $each_post->id }}"
                      class="text-white font-semibold py-2 px-2 rounded-md hover:bg-green-300 focus:bg-green-300 focus:text-white bg-green-500 screen"
                      status="active" typeOfPost="post">Approve</button>
                  </div>
                  <div>
                    <button id="{{ $each_post->id }}"
                      class="text-red-400 font-semibold py-2 px-2 rounded-md hover:bg-red-300 hover:text-white focus:bg-red-300 focus:text-white screen"
                      status="rejected" typeOfPost="post">Delete</button>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div class=" bg-gray-100 text-xl rounded-md p-4  my-3 text-center">
            <p>You are lucky oo, there are no pending posts</p>
          </div>
        @endif

      </div>

      <div class=" my-2 bg-gray-50 p-3">
        <h2 class=" font-semibold text-xl text-center my-4">Pending Enquiries that needs Approval <span
            class=" text-green-400 font-semibold">({{ count($pendingEnquiries) }})</span></h2>
        @if (count($pendingEnquiries) > 0)
          <div class=" grid lg:grid-cols-4 gap-4 ">
            @foreach ($pendingEnquiries as $enquiry)
              <div class=" border-2 border-gray-300 rounded-md p-3  space-y-2" level="grand">
                <h4 class=" text-lg font-semibold ">{{ $enquiry->message }}</h4>
                <p class=" text-sm">In <span class=" uppercase">{{ $enquiry->campus->nick_name }}</span>
                  campus</p>
                <p class=" flex justify-between items-center"><span><i class=" fa fa-user mr-2"></i>
                    {{ $enquiry->name }}</span>
                  @if ($enquiry->contact_mode == 'call')
                    <a href="tel:0{{ $enquiry->contact_info }}"
                      class="py-1 px-3 rounded-full border border-gray-400 bg-gray-200 contactBuyer"
                      id="{{ $enquiry->id }}"><i class=" fa fa-phone mr-2"></i> Call</a>
                  @endif
                  @if ($enquiry->contact_mode == 'whatsapp')
                    <a href="https://wa.me/?text={{ rawurlencode("Hello $enquiry->name, I saw your post about  $enquiry->message on percampus.com") }}"
                      class=" py-1 px-2 rounded-full border border-green-400  bg-green-100 contactBuyer "
                      id="{{ $enquiry->id }}"><i class=" fab fa-whatsapp mr-2 text-green-500"></i>
                      Whatsapp</a>
                  @endif
                </p>
                <div class=" flex justify-between mt-2">

                  <div>
                    <button id="{{ $enquiry->id }}"
                      class="text-white font-semibold py-2 px-2 rounded-md hover:bg-green-300 focus:bg-green-300 focus:text-white bg-green-500 screen"
                      status="active" typeOfPost="enquiry">Approve</button>
                  </div>
                  <div>
                    <button id="{{ $enquiry->id }}"
                      class="text-red-400 font-semibold py-2 px-2 rounded-md hover:bg-red-300 hover:text-white focus:bg-red-300 focus:text-white screen"
                      status="rejected" typeOfPost="enquiry">Delete</button>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div class=" bg-gray-100 text-xl rounded-md p-4  my-3 text-center">
            <p>You are lucky oo, there are no pending enquiries</p>
          </div>
        @endif

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

      $(".screen").click(function() {
        let _token = $('meta[name="csrf-token"]').attr('content');
        let postID = $(this).attr('id');
        let status = $(this).attr('status');
        let type = $(this).attr('typeOfPost');

        $.ajax({
          type: "POST",
          url: "{{ route('screenpost') }}",
          data: {
            postID,
            status,
            type
          },
          success: function(data) {
            console.log(data.success);
          },
        });

        // hide the current post after approving/rejecting the post

        // $(`div[id='${postID}']`).hide(500);
        $(this).parents("div[level='grand']").hide(200);


      })



    })
  </script>
@endsection
