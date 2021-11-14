@extends('layouts.app')

@section('title') Recent requests for items and services @endsection

@section('content')
   <div class=" bg-gray-50 px-2 py-3">

        <div class="text-lg font-medium  px-2 md:text-center md:text-xl">
            <h2>Requested items and services</h2>
        </div>
        
        {{-- div for posts --}}
        <div class="grid lg:gap-4 grid-cols-1 gap-y-4 md:grid-cols-3 lg:grid-cols-4 py-3 max-w-7xl mx-auto w-full px-2">
           
        @if (count($enquiries) > 0)

        {{-- iterating through all the enquiries  --}}
            @foreach ($enquiries as $enquiry)
                
            <div class=" border-2 border-gray-300 rounded-md p-3  space-y-2">
                    <h4 class=" text-lg font-semibold ">{{ $enquiry->message}}</h4>
                    <p  class=" text-sm">In <span class=" uppercase">{{ $enquiry->campus->nick_name}}</span> campus</p>
                    <p class=" flex justify-between items-center"><span><i class=" fa fa-user mr-2"></i> {{$enquiry->name}}</span> 
                        @if ($enquiry->contact_mode == 'call')
                            <a href="tel:0{{$enquiry->contact_info  }}" class="py-1 px-3 rounded-full border border-gray-400 bg-gray-200 contactBuyer" id="{{ $enquiry->id}}"><i class=" fa fa-phone mr-2"></i> Call</a>
                        @endif
                        @if ($enquiry->contact_mode == 'whatsapp')
                            <a href="https://wa.me/?text={{ rawurlencode("Hello $enquiry->name, I saw your post about  $enquiry->message on percampus.com") }}" class=" py-1 px-2 rounded-full border border-green-400  bg-green-100 contactBuyer " id="{{ $enquiry->id}}"><i class=" fab fa-whatsapp mr-2 text-green-500"></i> Whatsapp</a>
                        @endif
                </p>
                </div>
            @endforeach
           
        </div>
            {{$enquiries->links()}}
        @else
            <p>No Requests today, pls check back later</p>
        @endif

        
   </div>
   {{-- @guest
       <a href="{{ route('gigs.create')}}" class=" block w-full bg-green-500 fixed bottom-0 z-50 p-3 text-center text-white font-semibold  rounded-t-md"> <i class="fab fa-bag"></i> Sell your skills on campus</a>
   @endguest --}}
   
@endsection