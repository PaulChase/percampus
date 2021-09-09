@extends('layouts.app')

@section('title') How to use @endsection


@section('content')
     <div class=" max-w-4xl mx-auto  p-3">
         <div>
             <h3 class=" bg-green-100 rounded-sm p-2 text-center text-lg font-bold  text-green-700 mb-3 lg:text-xl">How to Add a listing</h3>
             <ul class=" text-base md:text-lg space-y-3 mb-3">
                 <li>Before you proceed, <a href="/terms#rules" class=" text-green-500">Read our rules and guidelines for adding a listing.</a></li>
                 <li> <span class="fa fa-dot-circle text-green-500 mr-2"></span><strong>Registartion:</strong> The initial step is to Register using your email. Ensure you're entering the right information, so your potential could get in touch with you</li>
                 <li><span class="fa fa-dot-circle text-green-500 mr-2"></span>Click on the <strong>Add item </strong> on the top right corner.</li>
                 <li><span class="fa fa-dot-circle text-green-500 mr-2"></span>Choose the type of listing that you want to add to the website (for now only <i>forsale</i> and <i>acommodation</i>) and then fill the details of the listing accurately.</li>
                 <li><span class="fa fa-dot-circle text-green-500 mr-2"></span>Upload 2 clear images of the item or apartment ( <strong>note:</strong> the size of each image should not be more than 2MB, you can use an App like <b><i>Lit Photo</i></b> to resize your images). </li>
                 <li><span class="fa fa-dot-circle text-green-500 mr-2"></span>After submission of the post, it will immediately appear on the website in its respective category to students of your campus.</li>
                 <li><span class="fa fa-dot-circle text-green-500 mr-2"></span>After the sale has been made, please make sure to delete the post from your dashboard to avoid unnecessary calls concerning the listing.</li>
             </ul>
         </div>
         <div>
            <h3 class=" bg-green-100 rounded-sm p-2 text-center text-lg font-bold  text-green-700 mb-3 lg:text-xl">How to buy</h3>
            <ul class=" text-base space-y-3 mb-3 md:text-lg">
                <li><span class="fa fa-dot-circle text-green-500 mr-2"></span>From the homepage your campus space and if your are logged in you will automatically be taken to your campus homepage.</a></li>
                <li><span class="fa fa-dot-circle text-green-500 mr-2"></span>Note that you can only see posts from the students of that are on your campus, this is to facilitate legitemacy as there is high chance that you already know the student that added that post. </li>
                <li><span class="fa fa-dot-circle text-green-500 mr-2"></span>You can then proceed into the particular category of your choosing or you can as well search for the item you're looking for.</li>
                <li><span class="fa fa-dot-circle text-green-500 mr-2"></span>Once you see a listing that interests you, go to the page and copy the contact of the student that added the post.</li>
                <li><span class="fa fa-dot-circle text-green-500 mr-2"></span>You can go ahead and call the seller or chat on whatsapp to negotiate on the price and pick a suitable meeting point. </li>
                <li><span class="fa fa-dot-circle text-green-500 mr-2"></span>Make sure you meet the seller in a safe public place and if possible go with a friend(s). </li>
                <li><span class="fa fa-dot-circle text-green-500 mr-2"></span>Only pay after you've gotten and inspected the item or the apartment, also the verify that the seller is the owner of the item or is the caretaker of the apartment (I don't need to tell of the scams that happen daily in our country).</li>
                <li><span class="fa fa-dot-circle text-green-500 mr-2"></span>And if you're satisfied with the experience, you can refer a friend and help us spread the word. </li>
                
            </ul>
        </div>
        
     </div>
@endsection
       
    
