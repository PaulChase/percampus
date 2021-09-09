@extends('layouts.app') 

@section('title') {{ $campus}} E-library @endsection

@section('content')
    <div class="p-4 text-center text-lg md:text-xl md:max-w-xl mx-auto">
        <p class="my-4"><i class="fa fa-book fa-5x"></i></p>
        <p>Sorry, we haven't open an E-library for <b>{{$campus}}</b> yet. <br> When we do, we will email you immediately.</p>
        <p class="my-3 p-3 rounded-sm border border-gray-200 focus:bg-green-500"><a href="/{{$campus}}">Go back Home</a></p>
    </div>


@endsection
