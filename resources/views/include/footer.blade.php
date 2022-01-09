<footer class=" bg-gray-700 text-white p-5 ">
    <div class=" grid md:grid-cols-2 gap-3 max-w-7xl mx-auto">
        <div>
            <div class=" p-2">
                <p>If you run into any issues, have a complaint or want to recommend something for the website. You can reach me instantly on: </p>
                <div class=" grid grid-cols-2 gap-x-4 my-3">
                    <a href="tel:07040214836" class=" border p-2 border-white text-center font-medium rounded-sm"> <i class=" fa fa-phone mr-2"></i>Call</a>
                    <a href="https://wa.me/2347040214836" class=" border p-2 border-white text-center font-medium rounded-sm"> <i class=" fab fa-whatsapp mr-2"></i>whatsapp</a>
                </div>
            </div>

            <div>
                <i class="fa fa-map-marker mr-2 fa-2x"></i> We are currently located in Federal University of Technology, Minna Campus
            </div>

            <div class=" p-2 my-4">
                <p class=" text-center">To stay up to date with our latest updates, new features, student news and happenings, follow us on:</p>
                <div class=" grid grid-cols-1 gap-3 my-3 ">
                    <a href="https://fb.me/percampus" class=" border p-2 border-white text-center font-medium rounded-sm w-3/4 mx-auto"> <i class=" fab fa-facebook mr-2 "></i>Facebook Page</a>
                    <a href="https://t.me/percampus" class=" border p-2 border-white text-center font-medium rounded-sm w-3/4 mx-auto"> <i class=" fab fa-telegram mr-2"></i>Telegram Channel</a>
                </div>
            </div>
        </div>
        <div>
            <ul class=" md:max-w-lg">
                <li class="border-b-2 p-2 font-medium "><a href="/about" class="flex justify-between focus:bg-gray-800"><span>About</span> <i class=" la la-angle-right "></i></a></li>
                <li class="border-b-2 p-2 font-medium "><a href="/howto" class="flex justify-between focus:bg-gray-800"><span>How to Use</span> <i class=" la la-angle-right "></i></a></li>
                <li class="border-b-2 p-2 font-medium "><a href="https://forms.gle/wkVRH7yDWBEKg6QV6" class="flex justify-between focus:bg-gray-800" target="_blank"><span>Leave a feedback</span> <i class=" la la-angle-right "></i></a></li>
                <li class="border-b-2 p-2 font-medium "><a href="/safety" class="flex justify-between focus:bg-gray-800"><span> Safety tips</span> <i class=" la la-angle-right "></i></a></li>
                <li class="border-b-2 p-2 font-medium "><a href="/terms" class="flex justify-between focus:bg-gray-800"><span>Terms & Conditions</span> <i class=" la la-angle-right "></i></a></li>
                <li class="border-b-2 p-2 font-medium "><a href="https://wa.me/2347040214836"class="flex justify-between focus:bg-gray-800"><span>Contact Us</span> <i class=" la la-angle-right "></i></a></li>
            </ul>
        </div>
        <div class="my-4">
            <h1 class=" text-xl font-semibold"> {{config('app.name')}} &copy;</h1>
            <p>{{config('app.name')}} is one of the fastest growing online classified ads specifically made  for students on campus where they can buy and sell used items, new products and even services at affordable rates to one another,</p>
            {{-- <p>Built with Lots of &#128151; by <strong>Ajonye Paul</strong></p> --}}
        </div>
        
        
    </div>
</footer>


<script>
    function copyLink() {
            let referlink = document.getElementById('referlink');
            let copylink = document.getElementById('copylink');

            referlink.select();
            referlink.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(referlink.value).then(() => {
                copylink.innerHTML = 'Link Copied to clipboard';
            }, (err) => {
                copylink.innerHTML = 'Error: Copy it manually';
            });

        }
    $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                $("#closeEnquiry").click(function() {
                    $("#Enquiry").hide(500)
                })
                $(".showEnquiry").click(function() {
                    $("#menu").hide()
                    $("#Enquiry").show(500)
                })

                $(".addPost").click(function() {

                    $("#picktype").show(500)
                })

                $("#closepicktype").click(function() {
                    $("#picktype").hide(500)
                })
                $("#openmenu").click(function() {

                    $("#menu").show(500)
                })

                $("#closemenu").click(function() {
                    $("#menu").hide(500)
                })

                $("#contact_mode").change(function() {
                    let contactMode = $(this).val()
                    $("#contact_label").text(`Enter ${contactMode} number`)
                })



                $("#enquiryform").submit(function(e) {
                    e.preventDefault()
                    let submitBtn = $("input[name='submitEnquiry']")
                    submitBtn.val('Submitting...')
                    let _token = $('meta[name="csrf-token"]').attr('content');
                    let name = $("input[name='name']").val();
                    let campus = $("select[name='campusID']").val();
                    let contact_mode = $("select[name='contact_mode']").val();
                    let contact_info = $("input[name='contact_info']").val();
                    let message = $("textarea[name='message']").val();

                    // console.log(name, campus, contact_mode, contact_info, message);
                    
                    $.ajax({
                    type: "POST",
                    url: "{{ route('enquiries.store')}}",
                    data: { name , campus, contact_mode, contact_info,  message},
                    success : function(data) {
                        console.log(data.feedback);
                        if ( data.feedback == 'success') {
                            $("#enquiryBg").hide(200)
                            $(".enquiryContainer").css("height", "40%")
                            $("#successMessage").show(400).css("display", "flex")
                        }

                    },
                });
                   
                });

                $(".contactBuyer").click(function() {
                    console.log($(this).attr('id'));


                    let enquiryID = $(this).attr('id');


                $.ajax({
                    type: "POST",
                    url: "{{ route('contact.buyer') }}",
                    data: {
                        enquiryID
                    }
                    // success : function(data) {
                    //     console.log(data.success);
                    // },
                });

                
            });
    })
</script>
