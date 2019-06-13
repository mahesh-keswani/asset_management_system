<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Group;
use App\Stock;
use App\Asset;
use App\Inventory;
class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        
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
        $location = New Location;
        $location->name = $request->input('name');
        $location->country = $request->input('country');
        $location->state = $request->input('state');
        $location->city = $request->input('city');
        $location->address = $request->input('address');
        $location->zipcode = $request->input('zipcode');
        $location->phone = $request->input('phone');
        $location->save();

        $value = 'Location '. $location->name.' has been added on '.$location->created_at;
        $status = 'Location';
        $created_at = $location->created_at;
        $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
        DB::table('notifications')->insert($a);

        return redirect('http://localhost/vesit/public/asset')->with('success','Location has been added successfully');
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
}
