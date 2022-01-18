@extends('layouts.focused')
@section('title') Sign Up @endsection

@section('focus')
<div class=" bg-gray-100 py-4">

            @php
                use Illuminate\Support\Carbon;
                use Illuminate\Support\Facades\Cookie;
                use App\Models\User;
                use App\Models\Campus;
                
                $campuses = Cache::remember('campuses', Carbon::now()->addDay(), function () {
                 return Campus::orderBy('name', 'asc')->get();
                });
                // $campuses = Campus::orderBy('name')->get();
                
            @endphp
            
    
        
            <div class="px-4 py-4 md:max-w-lg mx-auto md:shadow-lg rounded-md bg-white ">

                <div class=" text-center text-xl font-semibold my-4">Hello, you are about to experince the Joy of online selling. You can login with:
                    @if (Cookie::has('referer'))
                    {{$referer->name}} referred you
                    @endif 
                </div>

                <div>
                    <a href="{{route('login.google')}}" class=" w-full p-3 text-center border-2 border-gray-100 rounded-lg text-white font-semibold block bg-blue-500 my-4"><i class="fab fa-google mr-3 "></i> With Your Google Account</a>
                </div>

                <p  class=" font-bold text-xl mx-auto w-4 my-3">OR</p>

                <button class="w-full p-3 text-center border-2 border-gray-100 rounded-lg  font-medium block bg-gray-200 my-4" id="openform"> <i class="fa fa-envelope mr-3"></i>
                    Continue With Your Email
                </button>
               

                <div class="  " id="signup">
                    <form method="POST" action="{{ route('register') }}" class=" space-y-4" >
                        @csrf

                        <div class="  ">
                            <label for="name" class=" text-gray-800"> <i class=" fa fa-user text-gray-500 mr-2"></i> what's that your fine name?</label>

                            <div class="">
                                <input id="name" type="text" class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="e.g John Wick">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- input for phone number --}}
                        <div class="  ">
                            <label for="phone" class=" text-gray-800"><i class=" fa fa-mobile text-gray-500 mr-2"></i> Your phone number so buyers can contact you</label>

                            <div class="">
                                <input id="phone" type="number" class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200 @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus placeholder=" e.g 09012345678">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="">
                            <label for="email" class=" text-gray-800"><i class=" fa fa-envelope text-gray-500 mr-2"></i> Your active Email Address</label>

                            <div class="">
                                <input id="email" type="email" class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="e.g jonsnow@gmail.com">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="">
                            <label for="campus" class=" text-gray-800"><i class=" fa fa-graduation-cap text-gray-500 mr-2"></i> what campus are you based in?</label>

                            <div class="">
                                
                                <select name="campus" id="campus" class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"required>
                                    <option value="" disabled selected>Pick your campus from this list</option>
                                    @foreach ($campuses as $campus)
                                        <option value="{{$campus->id}}" class="">{{$campus->name}}</option>
                                    @endforeach
                                </select>
                                <small class=" my-2 block">If can't find your campus on the list, <a href="https://wa.me/2347040214836?text={{ rawurlencode("Hello Paul, I can't find my campus on the list ") }}" class=" font-semibold text-green-600">click here</a></small>
                            </div>
                        </div>

                        <div class="">
                            <label for="password" class="text-gray-800"><i class=" fa fa-lock text-gray-500 mr-2"></i> {{ __('Password') }}</label>

                            <div class="">
                                <input id="password" type="password" class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="pick an easy to remember pword">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="">
                            <label for="password-confirm" class="text-gray-800"><i class=" fa fa-lock text-gray-500 mr-2"></i> {{ __('Confirm Password') }}</label>

                            <div class="">
                                <input id="password-confirm" type="password" class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div>
                            <input type="checkbox" name="terms" id="terms" required>
                            <label for="terms">Accept Terms & Conditions <a href="/terms" class=" text-green-500">read here</a></label>
                        </div>

                        
                        <div class="">
                            <button type="submit" class="uppercase font-semibold bg-green-500 hover:bg-green-600 focus:bg-green-600 w-full rounded-md my-3 p-3 text-white  text-center focus:outline-none">
                                    {{ __('Register') }}
                            </button>
                            
                        </div>
                        
                    </form>
                </div>
                <p class=" my-2"><i>Already have an Account? </i> <a href="/login" class=" text-green-500 ml-2"><b> Login</b></a></p>
            </div>
        
    
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $("#openform").click(function(){
            $("#signup").show(1000)
        })
    })
</script>
    
@endsection