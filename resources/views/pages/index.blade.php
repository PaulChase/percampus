@extends('layouts.focused') 

@section('title') Welcome to the Online marketplace for students on campus @endsection


@section('focus')

    {{-- hero section  --}}
    <header style="background: url(/storage/images/herob.jpg) no-repeat center center/cover;
        height: 90vh;" class=" relative text-white  ">
        
        
        <div class=" bg-black top-0 right-0 w-full h-full absolute opacity-90 ">
            <nav class=" flex flex-row justify-between max-w-7xl mx-auto align-middle p-4">
                <h1 class=" no-underline hover:no-underline font-extrabold  text-2xl lg:text-3xl tracking-widest"> {{config('app.name')}}</h1>
                @guest
                <a href="/login" class=" inline-block border-2 px-4 py-2 rounded-md text-white text-sm font-semibold md:text-base focus:bg-green-700">Log In</a >
                @endguest
                
                
            </nav>
            <div class=" flex flex-row justify-center items-center h-full p-3 ">
                <div class="px-2 ">
                    <p class=" text-3xl lg:text-5xl lg:max-w-3xl  font-semibold my-3">Discover  cheap products up For Sale  by other Students on your Campus.
                    </p>
                    <p>Welcome to our campus marketplace, you will be able to sell new and used items very fast to students on your campus  </p>
                    <p class="grid gap-3 grid-cols-2">
                        <a href="/register" class=" inline-block bg-green-500 opacity-100 py-4  rounded-md text-white text-sm font-semibold md:text-base focus:bg-green-700 mt-5 border-2 border-green-500 shadow-xl  text-center">Start selling for FREE</a>
                        <a href="/allcampuses" class=" inline-block opacity-100 py-4  rounded-md text-white text-sm font-semibold md:text-base border-2 border-white focus:border-green-700 mt-5 shadow-xl  text-center">View Items for Sale</a>
                    </p>
                </div>
            </div>
        </div>
    </header>
    {{-- end of hero section --}}


    <main class=" bg-green-50 text-gray-700 m-0">
        <div class=" text-center lg:px-3 lg:py-9">
            <div class=" px-3 py-8 text-xl text-center font-semibold lg:flex lg:items-center lg:max-w-xl lg:text-3xl  italic mx-auto ">
                <p>
                    <i class=" fa fa-quote-left text-green-500 fa-2x "></i><br>
                    Join Us as we are taking the University Experience Online <br>
                    <i class=" fa fa-quote-right text-green-500 fa-2x"></i>
                </p>
            </div>

            <div class=" px-7 py-3 text-lg">
                <h3 class=" text-3xl font-bold my-4">How It Works</h3>
                <div class="mb-10">
                    <i class="fa fa-check-circle fa-3x my-4"></i>
                    <p>If you  have an item for sale whether used or new, the first step is to create your account for FREE <a href="/register" class=" text-green-500">here.</a> </p>
                </div>
                <div class="mb-10">
                    <i class="fa fa-check-circle fa-3x my-4"></i>
                    <p>In your account dashboard, you can click on the add post button to go to  the add post page. </p>
                </div>
                <div class="mb-10">
                    <i class="fa fa-check-circle fa-3x my-4"></i>
                    <p> Fill out the information about the item correctly and review it again for any possible errors and click the submit button when you are done.</p>
                </div>
                <div class="mb-10">
                    <i class="fa fa-check-circle fa-3x my-4"></i>
                    <p>In a few seconds your post will go live on the website. Students on your campus who are interested in the item will call you with the contact you provided. </p>
                </div>

            </div>

            {{-- list of our services --}}
            {{-- <div class=" mt-4 p-3">
                <h3 class=" my-4 py-3 text-center text-2xl font-bold" >What you will Enjoy as a Student</h3>
                <ul class=" text-lg space-y-4">
                    <li class=" flex"><i class="fa fa-check-circle fa-2x mr-2 text-green-400"></i><span>A platform to buy new or used items at a very price cheap from other students</span></li>
                    <li class=" flex"><i class="fa fa-check-circle fa-2x mr-2 text-green-400"></i><span>A simple way to sell that item you no longer need and taking up space in your room</span></li>
                    <li class=" flex"><i class="fa fa-check-circle fa-2x mr-2 text-green-400"></i><span>For the student Entrepreneur, you can market your products to to your fellow students for FREE</span></li>
                    <li class=" flex"><i class="fa fa-check-circle fa-2x mr-2 text-green-400"></i><span>As a housing Agent, you can list your lodges that is open to let.</span></li>
                    <li class=" flex"><i class="fa fa-check-circle fa-2x mr-2 text-green-400"></i><span>For the Jackers, there is an E-library section for you to find all your necessary course materials.</span></li>
                </ul>
            </div> --}}

            {{-- end of list of our services --}}
        </div>
        
        
        <div class=" mt-4 mb-10 px-4 py-2 text-2xl text-gray-600 font-bold text-center">
            <p>No need to share your product in few whatsapp groups and your status hoping someone will buy it, be rest assured that students coming here are ready to buy.</p>
        </div>

        @guest
            {{-- call to action --}}
        <div class="mx-3 shadow-2xl rounded-md bg-gray-800 px-3 py-8 h-auto text-xl text-white font-semibold text-center my-5 lg:h-72 lg:flex  lg:items-center lg:px-10">
            <p class=" md:w-3/12"><i class="fa fa-rocket fa-3x text-green-500 mb-4"></i></p>
            <div>
                <p class=" lg:text-3xl italic"> If you start posting now, your items will be seen first when buyers start flooding in.  <br> So what are you waiting for?</p> 
                <p class=" mt-5"> <a href="/register" class=" rounded-full border-2 py-3 px-5 text-base bg-green-500 border-green-500 focus:bg-green-500 focus:border-green-500 md:text-lg">Sign Me up ASAP</a></p>
            </div>
        </div>
        @endguest
        

        
        

        <div class=" grid lg:grid-cols-2 gap-4 p-4"> 
            

            <div class=" p-4 rounded-sm space-y-4 my-4 text-center">
                <p class=" md:text-lg font-semibold">You know a friend that this website may change his/her life for good? Don't hesitate to click the share buttons below </p>
                {!! $social!!}
            </div>
        </div>

    </main>
@include('include.footer')
    
@endsection
