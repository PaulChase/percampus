@extends('layouts.app') 

@section('title') {{$campus->name}} campus @endsection

@section('content')
<section
    class=" relative text-white"
    style="height: 60vh; background: url({{$campus->bg_image}}) no-repeat center center/cover;"
>
    <div class=" bg-black top-0 right-0 w-full h-full absolute opacity-80 flex flex-row justify-center items-center text-center p-3">
    <h2 class="text-3xl md:text-5xl lg:max-w-3xl font-bold mb-4">Welcome to {{$campus->name}} campus</h2>
    </div>   
</section>

<section class="py-6 px-3 max-w-7xl mx-auto">
    <div class=" grid lg:grid-cols-3 gap-3">
        @foreach ($categories as $category)
            <div class=" border-2  border-gray-200 border-solid py-4 px-5 rounded-md hover:shadow-lg lg:text-lg lg:p-5">
                <a href="{{route('subcategory', ['campus'=> $campus->nick_name,'c'=> $category->name])}}" class=" ">
                    <h3 class="font-semibold text-green-400 mb-3 block text-lg lg:text-xl uppercase">{{ $category->name}} <i class=" fa fa-chevron-right "></i></h3>
                    <p>{{ $category->excerpt}}</p>
                </a>
            </div>
        @endforeach
        <div class=" border-2  border-gray-200 border-solid py-4 px-5 rounded-md hover:shadow-lg lg:text-lg lg:p-5">
            <a href="  @if ($campus->e_library == null)
                            /{{$campus->nick_name}}/library
                        @else
                            {{$campus->e_library}}
                        @endif" target="_blank">
                <h3 class="font-semibold text-green-400 mb-3 block text-lg lg:text-xl "><span class=" uppercase">{{$campus->nick_name.' '}}</span>E-library <i class=" fa fa-chevron-right "></i></h3>
                <p> A place to get all {{$campus->nick_name}} course materials such as PDFs, slides, scanned photos etc. Submitted by fellow {{$campus->nick_name}} students for you to search and download.</p>
            </a>
        </div>
    </div>
</section>
    


@endsection
