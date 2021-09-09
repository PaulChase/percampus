@extends('layouts.app') 

@section('title') {{$campus->name}} {{$mainCategory}} @endsection

@section('content')

<section class="py-6 px-3 max-w-7xl mx-auto">
    <div class=" grid lg:grid-cols-3 gap-3">
        
        @foreach ($subCategories as $subcategory)
            <div class=" border-2  border-gray-200 border-solid p-3 rounded-md hover:shadow-lg lg:text-lg lg:p-5">
                <a href="{{route('posts.latest', ['campus'=>$campus->nick_name ,'c'=> $subcategory->slug, 'm'=> $mainCategory])}}" class=" ">
                    <h3 class="font-semibold text-green-600 my-3 block text-lg lg:text-xl">{{ $subcategory->name}} <i class=" fa fa-chevron-right "></i></h3>
                    
                </a>
            </div>
        @endforeach
        
    </div>
</section>
    


@endsection
