<div id="Enquiry" class=" fixed  w-full h-full z-30 overflow-auto  top-0 left-0 hidden" style="background-color: rgba(0,0,0,0.7); ">
    <div class=" bg-white bottom-0 absolute w-full rounded-t-lg p-4 h-3/4 lg:w-1/3 lg:h-full lg:right-0 lg:rounded-l-md overflow-auto enquiryContainer">
        <button class=" float-right m-3 bg-gray-200 px-3 py-1 rounded-full focus:bg-gray-500"
            id="closeEnquiry">X</button><br>
        <div class=" " id="enquiryBg">
            <div>
                <h1 class="text-center text-lg font-semibold my-4">Ask about item for sale or a service you need</h1>
            </div>
            
            <form method="POST" action=""  id="enquiryform" class=" space-y-4 text-gray-500">
                @csrf
                <div>
            
                    <label for="name" class="font-semibold">Just your first name<b class=" text-red-500 ">*</b></label><br>
                    <input name="name" type="text"
                        class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
                        placeholder="" id="name" required><br>
                    @error('title')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">please enter a valid name</small>
                    @enderror
                </div>
            
                <div class="">
                    <label for="campus" class="font-semibold">What campus are you in?<b class=" text-red-500">*</b> </label>
                    <select name="campusID" id="campus"
                        class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
                        required>
                        <option value="{{ null }}" selected disabled>Pick your campus below</option>
                        @foreach ($campuses as $campus)
                            <option value="{{ $campus->id }}" class="">{{ $campus->name }}</option>
                        @endforeach
                    </select>
            
                </div>
            
            
                <div class=" grid grid-cols-5 gap-2">
                    <div class=" col-span-2">
                        <label for="contact_mode" class="font-semibold">Contact Mode:<br> </label>
                        <select name="contact_mode" id="contact_mode"
                            class=" p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
                            required>
                            <option value="{{ null }}" selected disabled>Pick one</option>
                            <option value="whatsapp">Whatsapp Message</option>
                            <option value="call">Phone call</option>
                        </select>
                    </div>
                    <div class=" col-span-3">
                        <label for="contact_info" class="font-semibold " id="contact_label">Contact info<br> </label>
                        <input type="number" name="contact_info" id="contact_info"
                            class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
                            placeholder="e.g 09012345678" required>
                    </div>
                </div>
                <div>
                    <label for="message" class="font-semibold">what are you in need of? <b
                            class=" text-red-500">*</b></label><br>
                    <textarea name="message" id="message" cols="30" rows="4"
                        class="  p-2 bg-gray-100 rounded-lg w-full mt-1  focus:outline-none focus:ring-2 focus:ring-green-200"
                        placeholder="be very specific in your request e.g who has a fairly used dell laptop for sale with price below N100k or who can  tie a very fine gele for wedding ceremony"
                        required>{{ old('description') }}</textarea><br>
                    @error('description')
                        <small class="bg-red-300 p-2 inline-block rounded-sm text-sm mt-1">{{ $message }}</small>
                    @enderror
                </div>
            
                <div class="">
                    <input type="submit" name="submitEnquiry"
                        class=" font-semibold bg-green-500 hover:bg-green-600 focus:outline-none focus:bg-green-600 w-full rounded-md p-3  text-white  text-center"
                        value="I'm done, Submit">
                </div>
            </form>
        </div>
        <div class=" text-center  justify-center items-center h-full hidden" id="successMessage">
            <p><i class=" fa fa-thumbs-up fa-5x text-green-500 mb-4"></i> <br>
            Your request has been sucessfully submitted  for review  and will soon be live on the website</p>
        </div>
    </div>
</div>