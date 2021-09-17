@extends('layouts.app')

@section('title') Key Metrics @endsection

@section('content')

    <div class=" bg-white">
        <div class="p-3">
            <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                <h3 class=" mb-2 font-semibold text-lg">Registered Users</h3>
                <p class=" text-5xl text-green-400">{{$usersCount}}</p>
            </div>
            <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                <h3 class=" mb-2 font-semibold text-lg">Total No of Posts</h3>
                <p class=" text-5xl text-green-400">{{$postsCount}}</p>
            </div>
            <div class=" grid grid-cols-2 gap-x-3">
                <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                    <h3 class=" mb-2 font-semibold text-lg">Marketplace</h3>
                    <p class=" text-3xl text-green-400">{{$marketplaceCount}}</p>
                </div>
                <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                    <h3 class=" mb-2 font-semibold text-lg">Opportunities</h3>
                    <p class=" text-3xl text-green-400">{{$opportunitiesCount}}</p>
                </div>
            </div>
        </div>
        
    </div>
@endsection 