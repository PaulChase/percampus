@php

use App\Models\Campus;
use Illuminate\Support\Carbon;

// $campuses = Campus::orderBy('name')->get();
$campuses = Cache::remember('campuses', Carbon::now()->addDay(), function () {
    return Campus::orderBy('name', 'asc')->get();
});

@endphp


@extends('layouts.app')

@section('title')
  Offer A Service
@endsection

@section('content')
  <div class="bg-gray-100 py-4">

    @livewire('add-service')

  </div>
@endsection
