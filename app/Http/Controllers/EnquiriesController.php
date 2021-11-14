<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;



class EnquiriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $enquiries = Enquiry::where('status', 'active')->orderBy('created_at', 'desc')->with('campus')->paginate(20);


        return view('pages.allrequests')->with('enquiries', $enquiries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $enquiry = new Enquiry;
        $enquiry->name = $request->input('name');
        $enquiry->campus_id = $request->input('campus');
        $enquiry->contact_mode = $request->input('contact_mode');
        $enquiry->contact_info = ltrim($request->input('contact_info'), 0);
        $enquiry->message = $request->input('message');
        $enquiry->status = 'pending';
        $enquiry->save();

        return response()->json(['feedback' => 'success']);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function contactBuyer(Request $request)
    {
        $enquiryID = $request->input('enquiryID');
        $enquiry = Enquiry::find($enquiryID);


        if (!Cookie::has($enquiry->id)) {

            Cookie::queue($enquiry->id, 'contactedBuyer', 1440);
            $enquiry->incrementEnquiryCount();
        }


        return response()->json(['success' => 'yep']);
    }
}
