@extends('layouts.app')

@section('title') Key Metrics @endsection

@section('content')

    <div class=" bg-white  max-w-7xl mx-auto">
        <h2 class=" text-center text-3xl  font-bold my-3">New Metrics</h2>

        <div class=" grid lg:grid-cols-5 gap-4">
            <div class="p-3 lg:col-span-3 lg:order-2">
            
                {{-- today metrics --}}
                <h3 class=" font-semibold text-lg text-gray-600">Today:</h3>
                <div class=" grid grid-cols-2 gap-x-4">
                    <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                        <h3 class=" mb-2 font-semibold text-lg">Total Views</h3>
                        <p class=" text-3xl text-green-400">{{ $totalViewsToday }}</p>
                    </div>
                    <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                        <h3 class=" mb-2 font-semibold text-lg">Unique Visitors</h3>
                        <p class=" text-3xl text-green-400">{{ $uniqueViewsToday }}</p>
                    </div>
                </div>
            
                {{-- yesterday metrics --}}
                <h3 class=" font-semibold text-lg text-gray-600">Yesterday:</h3>
                <div class=" grid grid-cols-2 gap-x-4">
                    <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                        <h3 class=" mb-2 font-semibold text-lg">Total Views</h3>
                        <p class=" text-3xl text-green-400">{{ $totalViewsYesterday }}</p>
                    </div>
                    <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                        <h3 class=" mb-2 font-semibold text-lg">Unique Visitors</h3>
                        <p class=" text-3xl text-green-400">{{ $uniqueViewsYesterday }}</p>
                    </div>
                </div>
            
                {{-- last 7 days metrics --}}
                <h3 class=" font-semibold text-lg text-gray-600">Last 7 days:</h3>
                <div class=" grid grid-cols-2 gap-x-4">
                    <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                        <h3 class=" mb-2 font-semibold text-lg">Total Views</h3>
                        <p class=" text-3xl text-green-400">{{ $totalViewsLast7Days }}</p>
                    </div>
                    <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                        <h3 class=" mb-2 font-semibold text-lg">Unique Visitors</h3>
                        <p class=" text-3xl text-green-400">{{ $uniqueViewsLast7Days }}</p>
                    </div>
                </div>
            
                {{-- this month metrics --}}
                <h3 class=" font-semibold text-lg text-gray-600">This Month:</h3>
                <div class=" grid grid-cols-2 gap-x-4">
                    <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                        <h3 class=" mb-2 font-semibold text-lg">Total Views</h3>
                        <p class=" text-3xl text-green-400">{{ $totalViewsThisMonth }}</p>
                    </div>
                    <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                        <h3 class=" mb-2 font-semibold text-lg">Unique Visitors</h3>
                        <p class=" text-3xl text-green-400">{{ $uniqueViewsThisMonth }}</p>
                    </div>
                </div>
            
                {{-- overall metrics --}}
                <h3 class=" font-semibold text-lg text-gray-600">OverAll:</h3>
                <div class=" grid grid-cols-2 gap-x-4">
                    <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                        <h3 class=" mb-2 font-semibold text-lg">Total Views</h3>
                        <p class=" text-3xl text-green-400">{{ $totalViews }}</p>
                    </div>
                    <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                        <h3 class=" mb-2 font-semibold text-lg">Unique Visitors</h3>
                        <p class=" text-3xl text-green-400">{{ $uniqueViews }}</p>
                    </div>
                </div>
            
            
            </div>
            
            <div class=" lg:col-span-2 lg:order-1 p-3">
                <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                    <h3 class=" mb-2 font-semibold text-lg">New Users Today</h3>
                    <p class=" text-5xl text-green-400">{{ $newUsersToday }}</p>
                </div>
                <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                    <h3 class=" mb-2 font-semibold text-lg">New Users Yesteraday</h3>
                    <p class=" text-5xl text-green-400">{{ $newUsersYesterday }}</p>
                </div>
                <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                    <h3 class=" mb-2 font-semibold text-lg">New Users last 7 Days</h3>
                    <p class=" text-5xl text-green-400">{{ $newUsersLast7Days }}</p>
                </div>
                <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                    <h3 class=" mb-2 font-semibold text-lg">New Users This Month</h3>
                    <p class=" text-5xl text-green-400">{{ $newUsersThisMonth }}</p>
                </div>
                <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                    <h3 class=" mb-2 font-semibold text-lg">Total verified users</h3>
                    <p class=" text-5xl text-green-400">{{ $verifiedUsers }}</p>
                </div>
            </div>
        </div>
        <h2 class=" text-center text-3xl  font-bold my-3">Old Metrics</h2>
        <div  class="lg:grid lg:grid-cols-2 gap-4">
<div class="p-3 ">
            <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                <h3 class=" mb-2 font-semibold text-lg">Registered Users</h3>
                <p class=" text-5xl text-green-400">{{ $usersCount }}</p>
            </div>
            <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                <h3 class=" mb-2 font-semibold text-lg">Total No of Posts</h3>
                <p class=" text-5xl text-green-400">{{ $postsCount }}</p>
            </div>
            <div class=" grid grid-cols-3 gap-x-3">
                <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                    <h3 class=" mb-2 font-semibold text-lg">Marketplace</h3>
                    <p class=" text-3xl text-green-400">{{ $marketplaceCount }}</p>
                </div>
                <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                    <h3 class=" mb-2 font-semibold text-lg">Services</h3>
                    <p class=" text-3xl text-green-400">{{ $servicesCount }}</p>
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
            
            

        </div>
        <div class=" p-3">
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
                <div class=" border-2 border-gray-300 p-4 rounded-md my-3 text-center bg-white">
                    <h3 class=" mb-2 font-semibold text-lg">Total Enquiry Contacts</h3>
                    <p class=" text-5xl text-green-400">{{$totalEnquiriesContacts}}</p>
                </div>
            
        </div>
        </div>
        
        <div class=" lg:grid lg: grid-cols-2 gap-4 p-3">
<div class=" border-2 border-gray-300 p-4 rounded-md my-3  bg-white">
                <h2 class=" text-center text-xl font-semibold my-3">Top 10 Posts in the last 7 days</h2>
                <h3 class=" font-semibold grid grid-cols-6"><span class=" col-span-5">Title</span> <span>Views</span></h3>
              
            </div>
            <div class=" border-2 border-gray-300 p-4 rounded-md my-3  bg-white">
                <h2 class=" text-center text-xl font-semibold my-3">Top 10 Campuses</h2>
                <h3 class=" font-semibold grid grid-cols-6"><span class=" col-span-5">Name</span> <span>Students</span></h3>
                @foreach ($topCampuses as $campus)
                    <p class=" grid grid-cols-6 gap-x-2 border-b border-gray-200 py-2"><span
                            class=" col-span-5 ">{{ $campus->name }}</span> <span>{{ $campus->users->count() }}</span></p>

                @endforeach
            </div>
        </div>

    </div>
@endsection
