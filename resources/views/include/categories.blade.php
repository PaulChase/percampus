@php
    use  App\Models\SubCategory;

    $subCategories = SubCategory::all();
@endphp

<div class=" bg-gray-300 p-3 lg:p-8 lg:text-lg">
    <h2 class=" uppercase text-lg font-bold mb-5 text-center lg:text-2xl">All Categories</h2>
    <div class=" grid grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach (  $subCategories as $subCategory)
            <a class=" block font-medium focus:text-green-500" href="{{ route('getposts.bycategory', ['m' => $subCategory->category->name, 'c' => $subCategory->slug] ) }}">
                <i class="fa fa-dot-circle mr-2"></i> {{$subCategory->name }}</a>
        @endforeach
    </div>
    
</div>