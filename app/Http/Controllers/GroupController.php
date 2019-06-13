<?php

namespace App\Http\Controllers;
use App\ProductToHide;
use Illuminate\Http\Request;
use App\Group;
use App\Location;
use App\Asset;
use App\Stock;
use App\Inventory;
use DB;
use App\Customer;

class GroupController extends Controller
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
        $d_rate = $request['depreciation_rate'];

        if($d_rate <= 1)
        {
            return redirect('http://localhost/vesit/public/asset')->with('error','Invalid Deprecation Rate');

        }
        $group = New Group;
        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->depreciation_rate = $request->input('depreciation_rate');
        $group->save();

        $value = 'Group with name'. $group->name.' has been added successfully';
        $status = 'Successful';
        $created_at = $group->created_at;
        $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
        DB::table('notifications')->insert($a);
        return redirect('http://localhost/vesit/public/asset')->with('success','Group has been added successfully');

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

    public function show_customer()
    {
        $cus = Customer::all();

        return view('pages.customer')->with('cus',$cus);
    }

    public function changeView(Request $request)
    {
        $abc = new ProductToHide;

        $abc->product_to_hide = $request['product_to_hide'];
        $abc->user_name = $request['user_name'];
        $abc->description = $request['description'];

        $abc->save();
        
         return redirect('http://localhost/vesit/public/asset')->with('success','Partial View Created');
    }
}
