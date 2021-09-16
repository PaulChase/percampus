@extends('layouts.app')

@section('title') Add Post @endsection

@section('content')

    <div class="bg-gray-100 py-4">

        <div class="px-4 py-4 md:max-w-lg mx-auto md:shadow-lg rounded-md bg-white">

            <div><h1 class="text-center text-xl font-semibold my-4">Edit your post</h1></div>

            <form method="POST" action="{{ route('opportunities.update', ['opportunity' => $post->id])}}" enctype="multipart/form-data" class=" space-y-4">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div>
                    
                    <label for="">Title of the post <b class=" text-red-500">*</b></label><br>
                    <input name="title" type="text" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" placeholder=" scholarship for fresh students.." value="{{ $post->title}}"><br>
                    @error('title')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">please enter a valid title</small>
                    @enderror
                </div>
                <div>
                    <label for="description">Description <b class=" text-red-500">*</b></label><br>
                    <textarea name="description" id="" cols="30" rows="8" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" placeholder="give accurate information concerning the opportunity such as who is eligible and the necessary requirements to apply etc">{{ $post->title}}</textarea><br>
                    @error('description')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ $message }}</small>
                    @enderror
                </div>
                
                <div>
                    <label for="price">What is the Reward? <b class=" text-red-500">*</b></label>
                    <input type="text" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" name="reward" placeholder="such as scholarship amount, job salary etc" value="{{ $post->price}}">
                    @error('price')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'the price of the item is Required' }}</small>
                    @enderror
                </div>
                <div>
                    <label for="price">What is the Deadline? <b class=" text-red-500">*</b></label>
                    <input type="date" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" name="deadline" placeholder="" value="{{ $post->apply_deadline}}" >
                    @error('price')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'the price of the item is Required' }}</small>
                    @enderror
                </div>
                
                {{-- <div>
                    <label for="venue">Venue/ Meeting Point</label>
                    <input type="text" name="venue" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" placeholder=" a safe place to meet the buyer e.g hostel, offcampus">
                </div> --}}
                <div>
                    <label for="contact">Link for application<br>
                    <input type="url" name="apply_link" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" placeholder="enter a url to the application website " value="{{ $post->apply_link}}">
                </div>
                <div>
                    <label for="image"><i class="la la-photo"></i> Upload a cover photo for this post (only 1 required)</label>
                    <input type="file" name="image"  class="p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" >
                    @error('image')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'the images should not be more than 2' }}</small>
                    @enderror
                    @error('image.*')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'please enter a maximum of 2 valid images and less than 2MB' }}</small>
                    @enderror
                </div>
                <input type="hidden" name="_method" value="PUT"><br>
                <div class="">
                    <input type="submit" name="submit" class="uppercase font-semibold bg-green-500 hover:bg-green-600 focus:outline-none focus:bg-green-600 w-full rounded-md p-3  text-white  text-center" value="Update post">
                </div>
            </form>
        </div>
    </div>
    
@endsection