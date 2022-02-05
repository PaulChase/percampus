@extends('layouts.focused')
@section('title') Verify your email @endsection

@section('focus')
 <main class=" px-4 py-12 text-lg lg:max-w-3xl mx-auto lg:text-3xl">
     <h2 class=" text-xl font-bold mb-4 lg:text-4xl"> Hi there {{Auth::user()->name}},</h2>
     <p class=" mb-3">We can't wait to have  you start selling  with us, but you first need to confirm that this email belongs to you. </p>
     <p class=" mb-3">Just check your email App, and click on the verification link in the email that we   just sent to you.</p>
     <p class=" mb-6">And that's it. you're done.</p>
      <form class="" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <label for="">And if you counldn't find the email, first check your spam folder or click the link below to request another email.</label>
                        <button type="submit" class="uppercase font-semibold  focus:bg-green-600 w-full rounded-md my-3 p-3 text-green-600  text-center focus:outline-none">{{ __('click here to request another') }}</button>.
                    </form>
 </main>
@endsection

