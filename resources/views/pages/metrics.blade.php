@extends('layouts.app')

@section('title') Key Metrics @endsection

@section('content')

    <div class=" bg-white">
        <div class="p-3">
            <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                <h3 class=" mb-2 font-semibold text-lg">Registered Users</h3>
                <p class=" text-5xl text-green-400">{{ $usersCount }}</p>
            </div>
            <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                <h3 class=" mb-2 font-semibold text-lg">Total No of Posts</h3>
                <p class=" text-5xl text-green-400">{{ $postsCount }}</p>
            </div>
            <div class=" grid grid-cols-2 gap-x-3">
                <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                    <h3 class=" mb-2 font-semibold text-lg">Marketplace</h3>
                    <p class=" text-3xl text-green-400">{{ $marketplaceCount }}</p>
                </div>
                <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                    <h3 class=" mb-2 font-semibold text-lg">Opportunities</h3>
                    <p class=" text-3xl text-green-400">{{ $opportunitiesCount }}</p>
                </div>
            </div>
            <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                <h3 class=" mb-2 font-semibold text-lg">Total Post Views</h3>
                <p class=" text-5xl text-green-400">{{ $totalPostViews }}</p>
            </div>
            <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                <h3 class=" mb-2 font-semibold text-lg">Total Post Contacts</h3>
                <p class=" text-5xl text-green-400">{{ $totalPostContacts }}</p>
            </div>
            <div class=" grid grid-cols-2 gap-x-3">
                <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                    <h3 class=" mb-2 font-semibold text-lg">Total referrals</h3>
                    <p class=" text-3xl text-green-400">{{ $referralsCount }}</p>
                </div>
                <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                    <h3 class=" mb-2 font-semibold text-lg">Search Queries</h3>
                    <p class=" text-3xl text-green-400">{{ $searchCount }}</p>
                </div>
            </div>
            <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                    <h3 class=" mb-2 font-semibold text-lg">Total Ad Clicks</h3>
                    <p class=" text-5xl text-green-400">{{$totalAdClicks}}</p>
                </div>
            <div class=" border-2 border-gray-300 p-4 rounded-md my-3  bg-white">
                <h2 class=" text-center text-xl font-semibold my-3">Top 10 Posts</h2>
                <h3 class=" font-semibold grid grid-cols-6"><span class=" col-span-5">Title</span> <span>Count</span></h3>
                @foreach ($mostViewedPosts as $post)
                    <p class=" grid grid-cols-6 gap-x-2 border-b border-gray-200 py-2"><span
                            class=" col-span-5 ">{{ $post->title }}</span> <span>{{ $post->view_count }}</span></p>

                @endforeach
            </div>

        </div>

    </div>
@endsection
