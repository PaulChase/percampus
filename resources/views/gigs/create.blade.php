@extends('layouts.app')

@section('title') Offer A Gig @endsection

@section('content')

    <div class="bg-gray-100 py-4">

        <div class="px-4 py-4 md:max-w-lg mx-auto md:shadow-lg rounded-md bg-white">

            <div><h1 class="text-center text-xl font-semibold my-4">Add details about your Gig</h1></div>

            <form method="POST" action="{{ route('gigs.store')}}" enctype="multipart/form-data" class=" space-y-4 text-gray-500">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div>
                    
                    <label for="" class="font-semibold">What is the title of the Gig<b class=" text-red-500 ">*</b></label><br>
                    <input name="title" type="text" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" placeholder="e.g I will design a nice looking website for your business"><br>
                    @error('title')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">please enter a valid title</small>
                    @enderror
                </div>
                <div>
                    <label for="description" class="font-semibold" >Tell us more about the Gig <b class=" text-red-500">*</b></label><br>
                    <textarea name="description" id="" cols="30" rows="7" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" placeholder="Provide more details about the Gig such as experience level additional bonuses etc. This is your chance to convice the client to contact you" >{{ old('description')}}</textarea><br>
                    @error('description')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ $message }}</small>
                    @enderror
                </div>
                <div class="">
                    <label for="" class="font-semibold">Choose the Category of the Gig<b class=" text-red-500">*</b> <br> <small>note you can't change this later</small></label>           
                   <select name="subcategory" id="" class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">
                    
                       @foreach ($subcategories as $subcategory)
                           <option value="{{$subcategory->id}}" class="">{{$subcategory->name}}</option>
                       @endforeach
                   </select>
               </div>
                <div>
                    <label for="price" class="font-semibold">The lowest price you charge per Gig<b class=" text-red-500">*</b></label>
                    <input type="number" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" name="price" placeholder=" e.g 2500 or 300 (without spacing)" required>
                    @error('price')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'the price of the item is Required' }}</small>
                    @enderror
                </div>
                
                <div>
                    <label for="contact" class="font-semibold">Phone or Whatsapp Number<br> <small>leave it empty if you want to use the number you used to register</small></label>
                    <input type="number" name="contact" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" placeholder="enter a number for the buyer to contact you" >
                </div>
                <div>
                    <label for="images" class="font-semibold"><i class="fa fa-photo "></i>Upload a maximum of 2 pics related to your Gig (maybe your past projects, each image shouldn't be more than 2MB  server resources is cost now oo)</label>
                    <input type="file" name="images[]" multiple class="p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">
                    @error('images')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'the images should not be more than 2' }}</small>
                    @enderror
                    @error('images.*')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'please enter a maximum of 2 valid images and less than 2MB' }}</small>
                    @enderror
                </div>
                <div class="">
                    <input type="submit" name="submit" class="uppercase font-semibold bg-green-500 hover:bg-green-600 focus:outline-none focus:bg-green-600 w-full rounded-md p-3  text-white  text-center" value="Submit Gig">
                </div>
            </form>
        </div>
    </div>
    
@endsection