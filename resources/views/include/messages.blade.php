@if(session('success'))
    <div class="bg-green-200 rounded-sm p-2 m-2">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-200 rounded-sm p-2 m-2 ">
        {{ session('error') }}
    </div>
@endif