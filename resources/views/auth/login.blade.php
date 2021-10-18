@extends('layouts.focused')

@section('title') Login @endsection

@section('focus') 
<div style="height:100vh" class=" bg-gray-100 py-4 ">

    <div class=" bg-green-100 border border-green-400 my-3 p-3 rounded-sm md:max-w-xl  mx-auto">
        As a logged In User, You will be able to add a post, search for posts, edit and delete your posts and so much more.
    </div>
    <div class="px-4 py-4 md:max-w-xl  mx-auto md:shadow-lg rounded-md bg-white  mt-10">
        
                <div class="text-center text-xl font-semibold my-4  ">{{ __('Login into your Account') }}</div>
                <div>
                    <a href="{{route('login.google')}}" class=" w-full p-3 text-center border-2 border-gray-100 rounded-lg text-white font-semibold block bg-blue-500 my-4"><i class="fab fa-google mr-3 "></i> With Your Google Account</a>
                </div>

                <p  class=" font-bold text-xl mx-auto w-4 my-3">OR</p>
                
                <div class="">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="">
                            <label for="email" class="">{{ __(' Your E-Mail Address') }}</label>

                            <div class="">
                                <input id="email" type="email" class="p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="my-2">
                            <label for="password" class="">{{ __('Password') }}</label>

                            <div class="">
                                <input id="password" type="password" class="p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class=" bg-red-300 p-2 inline-block rounded-sm text-sm mt-1" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                                <div class=" my-3">
                                    <input class=" rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50 " type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Keep Me Logged In') }}
                                    </label>
                                </div>


                        
                            <div class="">
                                <button type="submit" class=" bg-green-500 hover:bg-green-600 w-full rounded-md uppercase p-3 text-white font-semibold my-3 focus:outline-none">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <div class="my-3">
                                        <a  href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <a href="/register" class="">I don't have Account,  <span class=" text-green-500 font-semibold">Register</span></a >
                            </div>
                       
                    </form>
                </div>
           
       
    </div>
</div>
@endsection
