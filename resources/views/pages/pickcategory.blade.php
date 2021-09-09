@extends('layouts.focused') 

@section('title') Choose the Category of the post @endsection

@section('focus')

<section class="py-6 px-3 max-w-7xl mx-auto">
    <div class="px-3 py-5 border-2 border-green-400 bg-green-100 rounded-sm text-center font-semibold mb-8 text-lg">
        Please select the Category of the Post you want to Add
        
    </div>
    <div class=" grid lg:grid-cols-3 gap-6">
        
            <div class=" border-2  border-gray-200 border-solid p-4 rounded-sm hover:shadow-lg lg:text-lg lg:p-5">
                <a href="/posts/create" class=" ">
                    <h3 class="font-semibold text-green-400 my-3 block text-lg lg:text-xl "> An Item for sale <i class=" fa fa-chevron-right "></i></h3>
                    <p>Do you have Items that you would like to sell to other students such as books, reading tables, clothes and shoes etc. Be sure to have clear pictures of the items before proceeding. </p>
                </a>
            </div>
            
            <div class=" border-2  border-gray-200 border-solid p-4 rounded-sm hover:shadow-lg lg:text-lg lg:p-5">
                <a href="{{ route('opportunities.create')}}" class=" ">
                    <h3 class="font-semibold text-green-400 my-3 block text-lg lg:text-xl "> A scholarship opportunity <i class=" fa fa-chevron-right "></i></h3>
                    <p>If come across a scholarship opportunity, grants or competitions that you think will beneficial to some students, do proceed to submit it.</p>
                </a>
            </div>
        
    </div>
    
</section>
    


@endsection
