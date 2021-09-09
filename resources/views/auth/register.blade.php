@extends('layouts.focused')
@section('title') Sign Up @endsection

@section('focus')
<div class=" bg-gray-100 py-4">

            @php
                use App\Models\Campus;
                $campuses = Campus::orderBy('name')->get();
            @endphp
            
    
        
            <div class="px-4 py-4 md:max-w-lg mx-auto md:shadow-lg rounded-md bg-white ">

                <div class=" text-center text-xl font-semibold my-4">{{ __('Sign Up for a Personal Account') }}</div>

                <div class=" ">
                    <form method="POST" action="{{ route('register') }}" class=" space-y-4" >
                        @csrf

                        <div class="  ">
                            <label for="name" class=" text-gray-800">{{ __('Full Name') }}</label>

                            <div class="">
                                <input id="name" type="text" class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- input for phone number --}}
                        <div class="  ">
                            <label for="phone" class=" text-gray-800">{{ __('Phone Number') }}</label>

                            <div class="">
                                <input id="phone" type="number" class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200 @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="">
                            <label for="email" class=" text-gray-800">{{ __('E-Mail Address') }}</label>

                            <div class="">
                                <input id="email" type="email" class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="">
                            <label for="email" class=" text-gray-800">Please select your Campus</label>

                            <div class="">
                                
                                <select name="campus" id="" class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">
                                    @foreach ($campuses as $campus)
                                        <option value="{{$campus->id}}" class="">{{$campus->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="">
                            <label for="password" class="text-gray-800">{{ __('Password') }}</label>

                            <div class="">
                                <input id="password" type="password" class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="">
                            <label for="password-confirm" class="text-gray-800">{{ __('Confirm Password') }}</label>

                            <div class="">
                                <input id="password-confirm" type="password" class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div>
                            <input type="checkbox" name="terms" id="">
                            <label for="terms">Accept Terms & Conditions <a href="/terms" class=" text-green-500">read here</a></label>
                        </div>

                        
                        <div class="">
                            <button type="submit" class="uppercase font-semibold bg-green-500 hover:bg-green-600 focus:bg-green-600 w-full rounded-md my-3 p-3 text-white  text-center focus:outline-none">
                                    {{ __('Register') }}
                            </button>
                            <p class=" my-2"><i>Already have an Account? </i> <a href="/login" class=" text-green-500 ml-2"><b> Login</b></a></p>
                        </div>
                        
                    </form>
                </div>
            </div>
        
    
</div>
@endsection
