 <div class="px-4 py-4 md:max-w-lg mx-auto md:shadow-lg rounded-md bg-white">

   <div>
     <h1 class="text-center text-xl font-semibold my-4">Add an Item</h1>
   </div>

   <form enctype="multipart/form-data" class=" space-y-4 text-gray-500" wire:submit.prevent='addProduct'>

     @csrf
     <div>

       <label for="" class="font-semibold">Name of the item you want to sell<b
           class=" text-red-500 ">*</b></label><br>
       <input name="title" type="text"
         class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
         placeholder=" e.g Tecno hot 8 for sale" wire:model.lazy='title'><br>
       @error('title')
         <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">please enter a valid title</small>
       @enderror
     </div>

     {{-- for admins to add posts --}}
     @if (Auth::user()->isAdmin())
       <div>

         <label for="" class="font-semibold">What's is the seller real name</label><br>
         <input name="alias" type="text"
           class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
           placeholder="the seller's name" wire:model.lazy='alias'><br>
         @error('title')
           <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">please enter a valid name</small>
         @enderror
       </div>

       {{-- for admins to add campuses to posts --}}

       <label for="" class="font-semibold">What's is the seller real campus</label><br>
       <select name="alias_campus" id=""
         class=" p-1 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200 col-span-3 lg:p-2 lg:m-0"
         wire:model.lazy='alias_campus'>
         <option value="{{ null }}" selected>Pick the Campus to search in...</option>
         @foreach ($univerisities as $campus)
           <option value="{{ $campus->id }}" class="">{{ $campus->name }}</option>
         @endforeach
       </select>
     @endif

     <div>
       <label for="description" class="font-semibold">Provide a clear description <b
           class=" text-red-500">*</b></label><br>
       <textarea name="description" id="" cols="30" rows="7"
         class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
         wire:model.lazy='description'
         placeholder="give a clear description of the item such how long you haved used it, it features and physical description etc."></textarea><br>
       @error('description')
         <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ $message }}</small>
       @enderror
     </div>

     <div class="">
       <label for="campus" class="font-semibold">Select the category of the item <b class=" text-red-500">*</b> <br>
         <select name="subcategory" wire:model.lazy='subcategory_id'
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
         name="price" placeholder=" e.g 2500 or 300 (without spacing)" wire:model.lazy='price' min="50"
         required>
       @error('price')
         <small
           class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ 'the price of the item is Required' }}</small>
       @enderror
     </div>

     <div>
       <label for="condition" class="font-semibold">What is the Condition?</label>
       <select name="item_condition" id="" wire:model.lazy='item_condition'
         class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">
         <option value="used" selected>I've Used it</option>
         <option value="new">No it's new</option>
       </select>

     </div>

     <div>
       <label for="instock" class="font-semibold">Are there more of this item?</label>
       <select name="in_stock" id="" wire:model.lazy='in_stock'
         class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200">
         <option value="yes" selected>Yes, there is more</option>
         <option value="no">No, just one</option>
       </select>

     </div>

     <div>
       <label for="venue" class="font-semibold">Where should a buyer meet you for the exchange?</label>
       <input type="text" name="venue"
         class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
         placeholder=" a safe place to meet the buyer e.g hostel, offcampus" wire:model.lazy='venue' required>
     </div>

     <div>
       <label for="contact" class="font-semibold">Phone or Whatsapp Number<br> <small>leave it empty if you want to
           use the number you used to register</small>
       </label>

       <input type="number" name="contact_info"
         class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
         placeholder="enter a number for the buyer to contact you" wire:model.lazy='contact_info'>
     </div>

     <div>
       <label for="images" class="font-semibold"><i class="fa fa-photo "></i>You can only Upload a maximum of 2
         images for now (each image shouldn't be more than 2MB)</label>

       <div>
         <label for="images" class="font-semibold"><i class="fa fa-photo "></i>1st Image</label>
         <input type="file" name="image1"
           class="p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
           wire:model='image1' accept="image/*" required>
         @error('image1')
           <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ $message }}
           </small>
         @enderror
       </div>

       <div>
         <label for="images" class="font-semibold"><i class="fa fa-photo "></i>2nd Image (optional)</label>
         <input type="file" name="image1"
           class="p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
           wire:model='image2' accept="image/*">
         @error('image2')
           <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ $message }}
           </small>
         @enderror
       </div>


     </div>

     <div class="">
       <input type="submit" name="submit"
         class="uppercase font-semibold bg-green-500 hover:bg-green-600 focus:outline-none focus:bg-green-600 w-full rounded-md p-3  text-white  text-center"
         value="Submit Item">
     </div>

   </form>
 </div>
