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
  Mass create posts
@endsection

@section('content')

  <div class="bg-gray-100 py-4">

    <div class="px-4 py-4 md:max-w-lg mx-auto md:shadow-lg rounded-md bg-white">

      <div>
        <h1 class="text-center text-xl font-semibold my-4">Add items</h1>
      </div>

      <form method="POST" action="{{ route('mass.store') }}" enctype="multipart/form-data"
        class=" space-y-4 text-gray-500">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div>

          <label for="" class="font-semibold">What is the name of the item you want to sell<b
              class=" text-red-500 ">*</b></label><br>
          <input name="title" type="text"
            class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
            placeholder=" e.g Tecno hot 8 for sale" value="{{ old('title') }}"><br>
          @error('title')
            <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">please enter a valid title</small>
          @enderror
        </div>

        {{-- for admins to add posts --}}
        @if (Auth::user()->role_id === 1)
          <div>

            <label for="" class="font-semibold">What's is the seller real name</label><br>
            <input name="alias" type="text"
              class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
              placeholder="the seller's name" value="{{ old('alias') }}"><br>
            @error('title')
              <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">please enter a valid name</small>
            @enderror
          </div>

          {{-- for admins to add campuses to posts --}}

          <label for="" class="font-semibold">What's is the seller real campus</label><br>
          <select name="alias_campus" id=""
            class=" p-1 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200 col-span-3 lg:p-2 lg:m-0">
            <option value="{{ null }}" selected>Pick the Campus to search in...</option>
            @foreach ($campuses as $campus)
              <option value="{{ $campus->id }}" class="">{{ $campus->name }}</option>
            @endforeach
          </select>
        @endif

        <div>
          <label for="description" class="font-semibold">Please describe it for us ( don't lie oo &#128512;) <b
              class=" text-red-500">*</b></label><br>
          <textarea name="description" id="" cols="30" rows="7"
            class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
            placeholder="give a clear description of the item such how long you haved used it, it features and physical description etc.">{{ old('description') }}</textarea><br>
          @error('description')
            <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ $message }}</small>
          @enderror
        </div>

        <div class="">
          <label for="campus" class="font-semibold">Select the category of the item <b class=" text-red-500">*</b> <br>
            <small>note you can't change this later</small></label>
          <select name="subcategory" id=""
            class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">

            @foreach ($subcategories as $subcategory)
              <option value="{{ $subcategory->id }}" class="">{{ $subcategory->name }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label for="price" class="font-semibold">A fair Price for the item <b class=" text-red-500">*</b></label>
          <input type="number"
            class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
            name="price" placeholder=" e.g 2500 or 300 (without spacing)" required value="{{ old('price') }}">
          @error('price')
            <small
              class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'the price of the item is Required' }}</small>
          @enderror
        </div>

        <div>
          <label for="condition" class="font-semibold">What is the Condition of the item?</label>
          <select name="condition" id=""
            class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">
            <option value="used">I've Used it</option>
            <option value="new">No it's new</option>
          </select>

        </div>

        <div>
          <label for="instock" class="font-semibold">Do you have more of this item?</label>
          <select name="instock" id=""
            class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">
            <option value="no">No, just one</option>
            <option value="yes">Yes, there is more</option>
          </select>

        </div>

        <div>
          <label for="venue" class="font-semibold">Where should a buyer meet you for the exchange</label>
          <input type="text" name="venue"
            class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
            placeholder=" a safe place to meet the buyer e.g hostel, offcampus" required value="{{ old('venue') }}">
        </div>

        <div>
          <label for="contact" class="font-semibold">Phone or Whatsapp Number<br> <small>leave it empty if you want to
              use the number you used to register</small></label>
          <input type="number" name="contact"
            class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
            placeholder="enter a number for the buyer to contact you" value="{{ old('contact') }}">
        </div>

        <div>
          <label for="images" class="font-semibold"><i class="fa fa-photo "></i>You can only Upload a maximum of 2
            images for now (each image shouldn't be more than 2MB, server resources is cost now oo)</label>
          <input type="file" name="images[]" multiple
            class="p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">
          @error('images')
            <small
              class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'the images should not be more than 2' }}</small>
          @enderror
          @error('images.*')
            <small
              class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'please enter a maximum of 2 valid images and less than 2MB' }}</small>
          @enderror
        </div>

        <div class="">
          <input type="submit" name="submit"
            class="uppercase font-semibold bg-green-500 hover:bg-green-600 focus:outline-none focus:bg-green-600 w-full rounded-md p-3  text-white  text-center"
            value="Submit Item">
        </div>
        
      </form>
    </div>
  </div>

@endsection
