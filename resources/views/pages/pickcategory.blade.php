@extends('layouts.focused') 

@section('title') Choose the Category of the post @endsection

@section('focus')

<section class="py-6 px-3 max-w-7xl mx-auto">
    <div class="px-3 py-5 border-2 border-green-400 bg-green-100 rounded-sm text-center font-semibold mb-3 text-lg">
        Please selct the Category of the Post 
        
    </div>
    {{-- <div class=" grid lg:grid-cols-3 gap-3">
        @foreach ($categories as $category)
            <div class=" border-2  border-gray-200 border-solid p-3 rounded-sm hover:shadow-lg lg:text-lg lg:p-5">
                <a href="" class=" ">
                    <h3 class="font-semibold text-green-400 my-3 block text-lg lg:text-xl ">{{ $category->name}} <i class=" fa fa-chevron-right "></i></h3>
                    <p>{{ $category->excerpt}}</p>
                </a>
            </div>
        @endforeach
        
    </div> --}}
    
</section>
    


@endsection
