@extends('layouts.app')

@section('title') Terms and Conditions @endsection


@section('content')
     <div class="max-w-4xl mx-auto  p-3">
         <div class="py-3 space-y-3">
             <h3 class=" bg-green-100 rounded-sm p-2 text-center text-lg font-bold  text-green-700 mb-3 lg:text-xl">Terms & Conditions</h3>
             <p class="md:text-lg">Your access to and use of the information, materials, and services provided on this Site is conditional upon your acceptance and compliance with the Terms. 
    
            Your continued use of this site will be deemed as acceptance of these Terms by you. If you do not agree to these terms, please do not use this Resource. {{config('app.name')}} reserves the right to change Terms and Conditions at any time by publishing the new Terms and Conditions on the Resource. By continuing to use the service you are indicating your acceptance to be bound by the amended Terms and Conditions.    
            </p>
            <p class="md:text-lg">
                As a condition of your use of {{config('app.name')}}, you agree that you are a student and older than 18 years of age.
                You are solely responsible for all information that you submit to {{config('app.name')}} and any consequences that may result from your post.
    
                We reserve the right at our discretion to refuse or remove content, or those parts thereof, that we believe is inappropriate or breaching our terms of use. We may, at our discretion, remove ads, put ads on hold or make minor changes thereto, when they do not comply with the Posting rules listed below.
            </p>
         </div>
         <div id="rules">
            <h3 class=" bg-green-100 rounded-sm p-2 text-center text-lg font-bold  text-green-700 mb-3 lg:text-xl">Rules and Guidelines</h3>
            <p>You are <strong>NOT</strong> allowed to add a listing or post:</p>
            <ul class=" text-base space-y-3 mb-3 md:text-lg">
                <li><span class="fa fa-ban text-red-200 mr-2"></span>That is pornographic or depicts a human being engaged in actual sexual conduct;</li>
                <li><span class="fa fa-ban text-red-200 mr-2"></span>That is unlawful, harmful, threatening, abusive, harassing, defamatory, libelous, invasive of another's privacy, or is harmful to minors in any way;</li>
                <li><span class="fa fa-ban text-red-200 mr-2"></span>That harasses, degrades, intimidates or is hateful towards any individual or group of individuals based on religion, gender, sexual orientation, race, ethnicity, age, or disability;</li>
                <li><span class="fa fa-ban text-red-200 mr-2"></span>That includes personal or identifying information about another person without that person's explicit consent;</li>
                <li><span class="fa fa-ban text-red-200 mr-2"></span>That is false, deceptive, misleading, deceitful, misinformative; </li>
                <li><span class="fa fa-ban text-red-200 mr-2"></span>That infringes any patent, trademark, trade secret, copyright or other proprietary rights of any party;</li>
                <li><span class="fa fa-ban text-red-200 mr-2"></span>That constitutes or contains 'link referral code,' 'junk mail,' 'spam,' 'chain letters,' 'pyramid schemes,' or unsolicited commercial advertisement;</li>
                <li><span class="fa fa-ban text-red-200 mr-2"></span>That advertises any illegal service or the sale of any item which is prohibited or restricted by any applicable law;</li>
                <li><span class="fa fa-ban text-red-200 mr-2"></span>That contains software viruses or any other computer code, files or programs designed to interrupt, destroy or limit the functionality of any computer software or hardware or telecommunications equipment;</li>
                <li><span class="fa fa-ban text-red-200 mr-2"></span>That employs misleading email addresses, or forged headers or otherwise manipulated identifiers to disguise the origin of content transmitted through the service.</li>
                <li><span class="fa fa-ban text-red-200 mr-2"></span>That violates any applicable laws including but not limited to consumer protection, data protection and intellectual property laws (including their regulations and guidelines)</li>
                <li><span class="fa fa-ban text-red-200 mr-2"></span><strong>Voilation of any of the above will result in a permanent ban of account. (No warning oo)</</strong></li>
            </ul>
        </div>
     </div>
     
@endsection
       
    
