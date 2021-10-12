@extends('layouts.app')

@section('title') {{ Auth::user()->name }} dashboard @endsection

@section('content')
<div class=" bg-gray-200">
       
        <div class=" max-w-xl mx-auto py-2 ">
            

            
            
            <div class=" my-2 bg-gray-50 p-3" >
                <h2 class=" font-semibold text-xl text-center my-4">Pending Posts that needs Approval <span class=" text-green-400 font-semibold">({{count($pendingPosts)}})</span></h2>
                @if (count($pendingPosts) > 0)
                    
                    @foreach ($pendingPosts as $each_post)
                    <div  class=" border-2 border-gray-200 rounded-md my-3 px-4 py-3 "  level="grand">
                        <div class="">
                            <h2 class="text-xl text-gray-700 font-semibold mb-2">{{$each_post->title}}</h2>
                            <hr>
                            <p class=" my-2">{{$each_post->description}}</p>
                            <hr>

                            
                                <small> Added: {{$each_post->created_at->diffForHumans()}}</small>
                           
                        </div>
        
                        <div class=" flex justify-between mt-2">
                            <div>
                                <a href="/{{$each_post->user->campus->nick_name}}/{{$each_post->subcategory->slug}}/{{$each_post->slug}}" class=" bg-gray-200 py-2 px-3 rounded-md inline-block hover:bg-gray-400 focus:bg-gray-400"> <i class="la la-paint-brush"></i> View</a>
                            </div>
                            <div>
                               <button id="{{ $each_post->id}}" class="text-white font-semibold py-2 px-2 rounded-md hover:bg-green-300 focus:bg-green-300 focus:text-white bg-green-500 screen" status="active"  >Approve</button>
                            </div>
                            <div>
                                <button id="{{ $each_post->id}}"  class="text-red-400 font-semibold py-2 px-2 rounded-md hover:bg-red-300 hover:text-white focus:bg-red-300 focus:text-white screen" status="rejected" >Delete</button>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                @else
                <div class=" bg-gray-100 text-xl rounded-md p-4  my-3 text-center"><p>You are lucky oo, there are no pending posts</p></div>
                @endif
                
            
            
            
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
        $(".screen").click(function(){
             let _token = $('meta[name="csrf-token"]').attr('content');
                let postID = $(this).attr('id');
                let status = $(this).attr('status');

                $.ajax({
                    type: "POST",
                    url: "{{ route('screenpost')}}",
                    data: { postID : postID, status:status},
                    success : function(data) {
                        console.log(data.success);
                    },
                });

                // $(`div[id='${postID}']`).hide(500);
                $(this).parents("div[level='grand']").hide(200);


         })
       

            
         })
         
        
    </script>
@endsection