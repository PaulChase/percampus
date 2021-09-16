@extends('layouts.app')

@section('title') About @endsection

@section('content')
  <div class=" max-w-4xl mx-auto  p-3">
        <div class=" bg-green-100 rounded-sm p-2 text-center text-lg font-bold  text-green-700 mb-3 lg:text-xl "><h2>About the Website</h2></div>
        <div class=" text-base space-y-3 mb-3 md:text-lg" >
          <p>{{config('app.name')}} is the best place for students to trade stuff, do business online  and keep up with things that is happening within their Campus.</p>
          <p>Our main offering is not just for just for students to buy and sell online, but to be the one place to find solutions to the problems faced by freshers, undergraduates, Student Entrepreneurs and even the campus at large.</p>
          <p>This is just the initial version of the website, in the nearest future we will be adding features and resources to the website based on the feedback gotten from students concerning the issues that they encountered on campus.</p>
        </div>
        <div class=" bg-green-100 rounded-sm p-2 text-center text-lg  font-bold  mb-3 text-green-700 lg:text-xl "><h2>Meet the Founder</h2></div>
        <div class=" text-base space-y-3 mb-3 md:text-lg" >
          <p><strong>Ajonye Paul</strong> is a 300L Mechanical Engineering student in Federal University of Technology, Minna.</p>
          <p>He is a Full stack Web developer with great interest in programming, BlockChain, business and tech in general. If he is not coding then he is probably watching a TV Series, a documentary or reading about recent innovations in the Tech Industry.</p>
          <p>The thought of this website (which was initially just a side project) came when a friend of his has to travel all the way from makurdi to Minna just to find and book a lodge here in minna. </p>
          <p>He goal is to provide a way for students to solve most of their problems online and also aid the student Entrepreneurs to run  a successful business within their respective campuses (<i>features coming soon</i>).</p>
          <p>Our lecturers already exists to frustrate us, our stay throughout the university should also not be that stressful.</p>
          
        </div>
  </div>
@endsection
        
    