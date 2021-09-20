@extends('layouts.app') 

@section('title') All Campuses @endsection

@section('content')

<section class="py-6 px-3 max-w-7xl mx-auto">
    <div class="p-3 text-lg text-center font-semibold mb-3">
        Before you proceed, please select your university from the list below<br>
        <small class=" italic">Arranged alphabetically</small>
    </div>
    <div class=" p-6 shadow-xl rounded-md my-4">
        <i class="fa fa-info-circle fa-2x mr-2"></i>
        As of now, I don't have the complete list of all the Universities in Nigeria. <br> 
        So if you can't find your university below, You can DM me on whatsapp with the name of your university so I can add it.
        <a href="https://wa.me/2347040214836" class=" border p-2 border-gray-400 text-center font-medium rounded-sm block my-2"> <i class=" fab fa-whatsapp mr-2 "></i>Contact Me</a>
    </div>
    <div class=" grid lg:grid-cols-3 gap-3">
        
        @foreach ($campuses as $campus)
            
                <a href="{{route('campus.home', ['campus'=>$campus->nick_name ])}}" class=" border-2  border-gray-200 border-solid px-3 py-1 rounded-md hover:shadow-lg lg:text-lg lg:p-5">
                    <h3 class="font-semibold text-green-600 my-3 block text-lg lg:text-xl">{{ $campus->name}} <i class=" fa fa-chevron-right "></i></h3>
                    
                </a>
           
        @endforeach
        
    </div>
</section>
    


@endsection
