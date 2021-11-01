
@extends('layouts.app')
@section('title') Create Ad @endsection

@section('content')

    <div class="bg-gray-100 py-4">

        <div class="px-4 py-4 md:max-w-lg mx-auto md:shadow-lg rounded-md bg-white">

            <div><h1 class="text-center text-xl font-semibold my-4">Post An Advert</h1></div>

            <form method="POST" action="{{ route('ads.save')}}" enctype="multipart/form-data" class=" space-y-4">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div>
                    
                    <label for="">title of the Ad <b class=" text-red-500">*</b></label><br>
                    <input name="title" type="text" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" placeholder="enter a catchy title for the ad" value="{{ old('title')}}"><br>
                    @error('title')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">please enter a valid title</small>
                    @enderror
                </div>
                <div>
                    
                    <label for="">The URL the Ad should link to <b class=" text-red-500">*</b></label><br>
                    <input name="url" type="url" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" placeholder="enter a valid url" value="{{ old('url')}}"><br>
                    @error('title')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">please enter a valid title</small>
                    @enderror
                </div>
                <div class="">
                     <label for="campus">Pick the campus to show your Ad</label>           
                    <select name="campus" id="" class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">
                        <option value="0">All the campuses</option>
                        @foreach ($campuses as $campus)
                            <option value="{{$campus->id}}" class="">{{$campus->name}}</option>
                        @endforeach
                    </select>
                </div>
                
                
                <div class="">
                    <label for="campus">Pick the category to show your Ad</label>           
                   <select name="subcategory" id="" class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">
                        <option value="0">All the categories</option>
                       @foreach ($subcategories as $category)
                           <option value="{{$category->id}}" class="">{{$category->name}}</option>
                       @endforeach
                   </select>
               </div>

               <div class="">
                     <label for="campus">Pick the Position of the AD</label>           
                    <select name="position" id="" class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">
                        <option value="middle">Middle</option>
                        <option value="bottom">Bottom</option>
                        
                    </select>
                </div>
                <div>
                    <label for="images"><i class="la la-photo"></i> Upload a nice image for the Ad</label>
                    <input type="file" name="image" multiple class="p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">
                    @error('images')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'the images should not be more than 2' }}</small>
                    @enderror
                    @error('images.*')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'please enter a maximum of 2 valid images and less than 2MB' }}</small>
                    @enderror
                </div>
                <div class="">
                    <input type="submit" name="submit" class="uppercase font-semibold bg-green-500 hover:bg-green-600 focus:outline-none focus:bg-green-600 w-full rounded-md p-3  text-white  text-center" value="Publish Ad">
                </div>
            </form>
        </div>
    </div>
    
@endsection