@extends('layouts.focused') 

@section('title') Choose the Category of the post @endsection

@section('focus')

<section class="py-6 px-3 max-w-7xl mx-auto">
    <div class="px-3 py-5 border-2 border-green-400 bg-green-100 rounded-sm text-center font-semibold mb-3 text-lg">
        Please selct the Category of the Post 
        
    </div>
    <div class=" grid lg:grid-cols-3 gap-6">
        
            <div class=" border-2  border-gray-200 border-solid p-3 rounded-sm hover:shadow-lg lg:text-lg lg:p-5">
                <a href="/posts/create" class=" ">
                    <h3 class="font-semibold text-green-400 my-3 block text-lg lg:text-xl "> An Item for sale <i class=" fa fa-chevron-right "></i></h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur illo ullam eaque magni ipsa natus sint exercitationem aperiam ex, earum at blanditiis aut, cupiditate expedita, repudiandae quis. Sit, eveniet unde.</p>
                </a>
            </div>
            
            <div class=" border-2  border-gray-200 border-solid p-3 rounded-sm hover:shadow-lg lg:text-lg lg:p-5">
                <a href="{{ route('opportunities.create')}}" class=" ">
                    <h3 class="font-semibold text-green-400 my-3 block text-lg lg:text-xl "> A scholarship opportunity <i class=" fa fa-chevron-right "></i></h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur illo ullam eaque magni ipsa natus sint exercitationem aperiam ex, earum at blanditiis aut, cupiditate expedita, repudiandae quis. Sit, eveniet unde.</p>
                </a>
            </div>
        
    </div>
    
</section>
    


@endsection
