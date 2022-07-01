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

				<div class="px-4 py-4 md:max-w-lg mx-auto md:shadow-lg rounded-md bg-white">

						<div>
								<h1 class="text-center text-xl font-semibold my-4">Add details about your Service</h1>
						</div>

						<form method="POST" action="{{ route('gigs.store') }}" enctype="multipart/form-data"
								class=" space-y-4 text-gray-500">
								@csrf
								<div>

										<label for="" class="font-semibold">What is the title of the Service<b
														class=" text-red-500 ">*</b></label><br>
										<input name="title" type="text"
												class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
												placeholder="e.g I will design a nice looking website for your business" value="{{ old('title') }}"><br>
										@error('title')
												<small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">please enter a valid title</small>
										@enderror
								</div>
								<div>
										<label for="description" class="font-semibold">Tell us more about the Service <b class=" text-red-500">*</b>
										</label><br>
										<textarea name="description" id="" cols="30" rows="7"
										  class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
										  placeholder="Provide more details about the Service such as experience level additional bonuses etc. This is your chance to convice the client to contact you">{{ old('description') }}
          </textarea><br>
										@error('description')
												<small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ $message }}</small>
										@enderror
								</div>
								<div class="">
										<label for="" class="font-semibold">Choose the Category of the Service<b class=" text-red-500">*</b>
												<br>
												<small>note you can't change this later</small></label>
										<select name="subcategory" id=""
												class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">

												@foreach ($subcategories as $subcategory)
														<option value="{{ $subcategory->id }}" class="">{{ $subcategory->name }}</option>
												@endforeach
										</select>
								</div>
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
										<div>
												<label for="price" class="font-semibold">Set any price<b class=" text-red-500">*</b></label>
												<input type="number"
														class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
														name="price" placeholder=" e.g 2500 or 300 (without spacing)" value="{{ old('price') }}" required>
												@error('price')
														<small
																class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'the price of the item is Required' }}</small>
												@enderror
										</div>

										{{-- for admins to add campuses to posts --}}

										<label for="" class="font-semibold">What's is the seller real campus</label><br>
										<select name="campus" id=""
												class=" p-1 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200 col-span-3 lg:p-2 lg:m-0">
												<option value="{{ null }}" selected>Pick the Campus to search in...</option>
												@foreach ($campuses as $campus)
														<option value="{{ $campus->id }}" class="">{{ $campus->name }}</option>
												@endforeach
										</select>
								@else
										<div>
												<label for="price" class="font-semibold">The lowest price you charge per Service <b
																class=" text-red-500">*</b></label>
												<input type="number"
														class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
														name="price" placeholder=" e.g 2500 or 300 (without spacing)" required>
												@error('price')
														<small
																class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'the price of the item is Required' }}
														</small>
												@enderror
										</div>
								@endif


								<div>
										<label for="contact" class="font-semibold">Phone or Whatsapp Number<br> <small>leave it empty if you want to
														use the number you used to register</small></label>
										<input type="number" name="contact"
												class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
												placeholder="enter a number for the buyer to contact you">
								</div>
								<div>
										<label for="images" class="font-semibold"><i class="fa fa-photo "></i>Upload a maximum of 2 pics related to
												your Service (maybe your past projects, each image shouldn't be more than 2MB server resources is cost now
												oo)</label>
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
												class="uppercase font-bold bg-green-500 hover:bg-green-600 focus:outline-none focus:bg-green-600 w-full rounded-md p-3  text-white  text-center"
												value="Submit Service">
								</div>
						</form>
				</div>
		</div>

@endsection
