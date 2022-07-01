@extends('layouts.app')


@section('title') Edit Post {{$cName ?? ''}} @endsection

@section('content')

<div class="bg-gray-100 py-4">
    <div class="px-4 py-4 md:max-w-lg mx-auto md:shadow-lg rounded-md bg-white">
        
            <h1 class="text-center text-xl font-semibold my-4">Edit post</h1>

            <form method="POST" action="{{ route('posts.update', ['id' => $post->id])}}" enctype="multipart/form-data" class=" space-y-4">
               @csrf
                <div>
                    <label for="">title</label><br>
                    <input name="title" class="p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" type="text" value="{{$post->title}}" required><br>
                    @error('title')
                        <small class="alert alert-danger mt-1 mb-1">please enter a valid title</small>
                    @enderror
                </div>
                <div>
                    <label for="">Details</label><br>
                    <textarea name="description" id="" cols="30" rows="7" class="p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" required>{{$post->description}}</textarea><br>
                    @error('description')
                        <small class="alert alert-danger mt-1 mb-1">{{ $message }}</small>
                    @enderror
                </div>
                <div>
                    @php
                        $price = str_ireplace(',', '', $post->price)
                    @endphp
                    <label for="price">Price <b class=" text-red-500">*</b></label>
                    <input type="number" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" name="price" placeholder="e.g 2500" value="{{ intval($price) }}" >
                    @error('price')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'the price of the item is Required' }}</small>
                    @enderror
                </div>
                <div class=" @if ($post->subcategory->category->name == 'gigs')
                    {{'hidden'}}
                @else
                    {{'block'}}
                @endif">
                    <label for="">Venue / Meeting point</label>
                    <input type="text" class="p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" name="venue" value="{{$post->venue}}" >
                </div>
                <div>
                    <label for="contact">Phone Number</label>
                    <input type="number" name="contact" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" placeholder="enter a number for someone to call you" value="{{$post->contact_info}}" required>
                </div>
                <div>
                    <label for="images"><i class="la la-photo"></i> You can edit Image of the Item</label>
                    <input type="file" name="images[]" multiple class="p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">
                    @error('images')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'the images should not be more than 2' }}</small>
                    @enderror
                    @error('images.*')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'please enter a maximum of 2 valid images and less than 2MB' }}</small>
                    @enderror
                </div>
                <input type="hidden" name="_method" value="PUT"><br>
                <div class=" grid grid-cols-2">
                    <a href="/dashboard" class=" uppercase font-medium text-center mt-2">cancel</a>
                    <input type="submit" name="submit" class="uppercase font-semibold bg-green-500 hover:bg-green-600 focus:outline-none focus:bg-green-600 w-full rounded-md p-3  text-white  text-center" value="update">
                </div>
            </form>
            
    </div>
</div>
    
@endsection