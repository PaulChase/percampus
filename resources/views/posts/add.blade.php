@extends('layouts.app')

@section('title') Add Post @endsection

@section('content')

    <div class="bg-gray-100 py-4">

        <div class="px-4 py-4 md:max-w-lg mx-auto md:shadow-lg rounded-md bg-white">

            <div><h1 class="text-center text-xl font-semibold my-4">Add an Item</h1></div>

            <form method="POST" action="{{ route('posts.save')}}" enctype="multipart/form-data" class=" space-y-4">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div>
                    
                    <label for="">Name of the item <b class=" text-red-500">*</b></label><br>
                    <input name="title" type="text" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" placeholder=" e.g Tecno hot 8 for sale"><br>
                    @error('title')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">please enter a valid title</small>
                    @enderror
                </div>
                <div>
                    <label for="description">Description <b class=" text-red-500">*</b></label><br>
                    <textarea name="description" id="" cols="30" rows="4" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" placeholder="give a clear description of the item such how long you haved used it, it features and physical description etc."></textarea><br>
                    @error('description')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ $message }}</small>
                    @enderror
                </div>
                <div class="">
                    <label for="campus">Pick the category of the item <b class=" text-red-500">*</b> <br> <small>note you can't change this later</small></label>           
                   <select name="subcategory" id="" class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">
                    
                       @foreach ($subcategories as $subcategory)
                           <option value="{{$subcategory->id}}" class="">{{$subcategory->name}}</option>
                       @endforeach
                   </select>
               </div>
                <div>
                    <label for="price">Price of the item <b class=" text-red-500">*</b></label>
                    <input type="text" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" name="price" placeholder="a fair price for the item " >
                    @error('price')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'the price of the item is Required' }}</small>
                    @enderror
                </div>
                <div>
                    <label for="condition">What is the Condition of the item?</label>
                    <select name="condition" id="" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">
                        <option value="used" >Used</option>
                        <option value="new">New</option>
                    </select>
                   
                </div>
                <div>
                    <label for="instock">Do you have more of this item?</label>
                    <select name="instock" id="" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">
                        <option value="no" >No, just one</option>
                        <option value="yes">Yes, there is more</option>
                    </select>
                    
                </div>
                <div>
                    <label for="venue">Venue/ Meeting Point</label>
                    <input type="text" name="venue" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" placeholder=" a safe place to meet the buyer e.g hostel, offcampus">
                </div>
                <div>
                    <label for="contact">Phone or Whatsapp Number<br> <small>leave it empty if you want to use the number you used to register</small></label>
                    <input type="number" name="contact" class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200" placeholder="enter a number for the buyer to contact you" >
                </div>
                <div>
                    <label for="images"><i class="la la-photo"></i> Upload a maximum of 2 images (each shouldn't be more than 2MB)</label>
                    <input type="file" name="images[]" multiple class="p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">
                    @error('images')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'the images should not be more than 2' }}</small>
                    @enderror
                    @error('images.*')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'please enter a maximum of 2 valid images and less than 2MB' }}</small>
                    @enderror
                </div>
                <div class="">
                    <input type="submit" name="submit" class="uppercase font-semibold bg-green-500 hover:bg-green-600 focus:outline-none focus:bg-green-600 w-full rounded-md p-3  text-white  text-center" value="Submit Item">
                </div>
            </form>
        </div>
    </div>
    
@endsection