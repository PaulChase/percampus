
@guest
    <div class=" mt-3 p-5 bg-gray-50 lg:rounded-sm text-center">
    <p> <strong>Great Nigerian Student!</strong>  If you have used or new items for sale on campus? OR have a Business that students on your campus need to know about. You can post them for FREE on our marketplace</p>
    <a href="/register" class=" block my-3 border border-gray-300 uppercase p-3 rounded-sm font-semibold focus:bg-gray-500 focus:text-white" target="_blank"> <i class=" fa fa-shopping-cart mr-2"></i> Start selling</a>
</div>
@else
<div class=" mt-3 p-5 bg-gray-50 lg:rounded-sm text-center">
    <p>
        Hello {{Auth::user()->name}}, do you have anything for sell or Business to advertise?. You can post them for FREE on our marketplace
        </p>
    <a href="/posts/create" class=" block my-3 border border-gray-300 uppercase p-3 rounded-sm font-semibold focus:bg-gray-500 focus:text-white" target="_blank"> <i class=" fa fa-shopping-cart mr-2"></i> sure, I have</a>
</div>
@endguest