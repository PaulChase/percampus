@extends('layouts.focused')
@section('title')
  Sign Up
@endsection

@section('focus')
  @livewire('register-user')
@endsection

@section('js')
  <script>
    $(document).ready(function() {

     

      $("#openform").click(function() {
        $("#signup").show(1000)
      })


    })
  </script>
@endsection
