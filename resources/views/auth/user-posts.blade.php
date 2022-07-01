@extends('layouts.app')

@section('title')
  {{ Auth::user()->name }} posts
@endsection

@section('content')

  <div class=" my-2 bg-gray-50 p-3">
    <h2 class=" font-semibold text-xl my-3">Your Latest Posts</h2>

    <div class=" grid lg:grid-cols-3 gap-4">


      @if (count(Auth::user()->posts) > 0)
        @foreach (Auth::user()->posts()->whereIn('status', ['active', 'pending', 'rejected'])->orderBy('created_at', 'desc')->with('user', 'subcategory')->get()
      as $each_post)
          <div class=" border-2 border-gray-200 rounded-md  px-4 py-3 ">
            <div class="">
              <h2 class="text-xl text-gray-700 font-semibold mb-2">{{ $each_post->title }}</h2>
              <p class=" flex justify-between my-3">
                <small>views: <span
                    class=" text-green-400">{{ $each_post->view_count + $each_post->postViews->count() }}</span></small>
                <small> status: <span
                    class=" font-semibold @if ($each_post->status == 'rejected') {{ 'text-red-500' }}
                                            @elseif ($each_post->status == 'pending')
                                                {{ 'text-yellow-500' }}
                                            @else {{ 'text-green-500' }} @endif
                                                ">{{ $each_post->status }}</span>
                </small>
                <small> Added: {{ $each_post->created_at->diffForHumans() }}</small>
              </p>
            </div>

            <div class=" flex justify-between mt-2">
              <div>
                <a href="{{ route('posts.show', $each_post->slug) }}"
                  class=" bg-gray-200 py-2 px-3 rounded-md inline-block hover:bg-gray-400 focus:bg-gray-400">
                  <i class="la la-paint-brush"></i> View</a>
              </div>
              <div>
                <a href="{{ route('posts.edit', $each_post->id) }}"
                  class=" bg-gray-200 py-2 px-3 rounded-md inline-block hover:bg-gray-400 focus:bg-gray-400">
                  <i class="la la-paint-brush"></i> Edit</a>
              </div>
              <div>
                <form action="{{ route('posts.delete', ['id' => $each_post->id]) }}" method="POST">
                  @csrf
                  <input type="hidden" name="_method" value="DELETE">
                  <button type="submit" name="submit"
                    class="text-red-400 font-semibold py-2 px-2 rounded-md hover:bg-red-300 hover:text-white focus:bg-red-300 focus:text-white">
                    <i class="la la-trash"></i> Delete</button>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      @else
        <div class=" bg-gray-100 text-xl rounded-md p-4  my-3 text-center">
          <p>Sell your first item or service today to see how easy the process is. <br> Start by clicking the "sell
            A..." button at top right</p>
        </div>
      @endif
    </div>


  </div>
@endsection
