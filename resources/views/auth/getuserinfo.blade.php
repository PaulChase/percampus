@extends('layouts.focused')

@section('title') Complete Registration @endsection

@php
                use Illuminate\Support\Carbon;
                use App\Models\Campus;
                
                $campuses = Cache::remember('campuses', Carbon::now()->addDay(), function () {
                 return Campus::orderBy('name', 'asc')->get();
                });
                // $campuses = Campus::orderBy('name')->get();
                
    @endphp

@section('focus') 
<div style="height:100vh" class=" bg-gray-100 py-4 ">

   
    <div class="px-5 py-4 md:max-w-xl  mx-auto md:shadow-lg rounded-md bg-white  mt-10">
        
                <div class="text-center text-xl font-semibold my-4">Hello {{ Auth::user()->name}}, one more step to go and Pooof!! you are done </div>
                
                <div class="">
                    <form method="POST" action="{{ route('push.userinfo')}}">
                        @csrf

                        <div class=" my-3">
                            <label for="campus" class=" text-gray-800">Please select your Campus</label>

                            <div class="">
                                
                                <select name="campus" id="campus" class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">
                                    @foreach ($campuses as $campus)
                                        <option value="{{$campus->id}}" class="">{{$campus->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="my-2">
                            <label for="phone" class="">Your phone number so buyers can reach you</label>

                            <div class="">
                                <input id="phone" type="number" class="p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200 " name="phone" required >
                            </div>
                        </div>

                            <div class="">
                                <button type="submit" class=" bg-green-500 hover:bg-green-600 w-full rounded-md uppercase p-3 text-white font-semibold my-3 focus:outline-none">
                                    Complete my sign up
                                </button>

                    </form>
                </div>
           
       
    </div>
</div>
@endsection
