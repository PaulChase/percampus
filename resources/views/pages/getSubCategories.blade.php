@extends('layouts.app') 

@section('title') All categories @endsection

@section('content')

<section class="py-6 px-3 max-w-7xl mx-auto">
    <div class=" grid grid-cols-2 lg:grid-cols-3 gap-4 text-center">
        @foreach ($subCategories as $subcategory)
           
                <a href="{{ route('posts.index', ['sub_category' => $subcategory->id])}}" class=" border-2  border-gray-200 focus:border-green-700 rounded-md p-3">
                        <img src="{{$subcategory->icon}}" alt="" class=" h-24  w-24 mx-auto my-2">
                        <h4 class=" font-semibold">{{ $subcategory->name}}</h4>
                </a >
            
        @endforeach
        
    </div>
</section>
    


@endsection
