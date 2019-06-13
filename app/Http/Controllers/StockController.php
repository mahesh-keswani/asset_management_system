<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Stock;
use App\Location;
use App\Asset;
use App\Inventory;
use  App\Group;
class StockController extends Controller
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
        $location = Location::all();
        $group = Group::all();
        $asset = Asset::all();
        $stock = Stock::all();
        $inventory = Inventory::all();
        $vendor = Vendor::all();
        $notification = Notification::all();
        $userAdmins = DB::select("SELECT * FROM users WHERE role = 'Admin'");

       

        $data = array('location'=>$location,'group'=>$group,'asset'=>$asset,'stock'=>$stock,'inventory'=>$inventory,'vendor'=>$vendor,'notification'=>$notification,'userAdmins'=>$userAdmins);

        return view('pages.dashboard')->with($data);
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
        $cost = $request['cost_price'];
        $quantity = $request['quantity'];
        $low_stock = $request['low_stock'];

        if($cost <= 0 || $quantity <= 0 || $low_stock <= 0)
        {
            return redirect('http://localhost/vesit/public/asset')->with('error','Invalid Input');

        }
        $asset = New Stock;
        $asset->name=$request->input('name');
        $asset->description = $request->input('description');
        $asset->location = $request->input('location');
        $asset->group = $request->input('group');
       
        $asset->purchased_on = $request->input('purchased_on');
        $asset->cost_price = $request->input('cost_price');
        $asset->low_stock = $request->input('low_stock');
        $asset->quantity = $request->input('quantity');
        $asset->available = $asset->quantity;
        $asset->vendor = $request['vendor'];
        $asset->user_id = auth()->user()->id;
        $asset->save();

        $value = 'Asset Stock'. $asset->name.' has been added Successfully';
        $status = 'Successful';
        $created_at = $request->input('purchased_on');

        $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
        DB::table('notifications')->insert($a);       
     return redirect('http://localhost/vesit/public/asset')->with('success','Asset Stock has been added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $duration = 3;
       $stock = Stock::find($id); 

        $q1 = DB::table('stocks')->where('id',$id)->first();
        $q2 = DB::table('groups')->where('name',$q1->group)->get();
        $q3 = DB::select("SELECT total_salvage FROM retires WHERE stock_id=$id");
        
    
        $user_find = DB::select("SELECT user_id FROM checkouts WHERE return_date >= CURDATE() AND stock_id=$id");
        
         if(!empty($user_find))
         {
             $user_id = $user_find[0]->user_id;
         }
         else
         {
             $user_id ='';
         }
         if(!empty($q3))
         {
             $percent = $q2[0]->depreciation_rate;
             $total_cost = $stock['quantity'] * $stock['cost_price'];
 
             $d_rate = $total_cost - $q3[0]->total_salvage * $duration * 0.01;
             
             $data = array('stock'=>$stock,'d_rate'=>$d_rate,'user_id'=>$user_id);
         }
         else
         {
             $data = array('stock'=>$stock,'user_id'=>$user_id);
         }
         return view('pages.showstock')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asset = Stock::find($id);
        return view('pages.editstock')->with('asset',$asset);
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
        $low_stock = $request['low_stock'];

        if($low_stock <= 0)
        {
            return redirect('http://localhost/vesit/public/asset')->with('error','Invalid Input');

        }
        $asset = Stock::find($id);
        $asset->name=$request->input('name');
        $asset->description = $request->input('description');
        $asset->location = $request->input('location');
        $asset->group = $request->input('group');
        $asset->purchased_on = $request->input('purchased_on');
        $asset->low_stock = $request->input('low_stock');
        $asset->save();

        $value = 'Asset Stock'. $asset->name.' has been updated Successfully';
        $status = 'Successful';
        $created_at = $request->input('purchased_on');

        $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
        DB::table('notifications')->insert($a);

        
        return redirect('http://localhost/vesit/public/asset')->with('success','Asset Stock Has been successfully updated');
    }
    public function customer(Request $request,$id)
    {
        $products = Inventory::find($id);

        $cus = new Customer;
        $cus->product_name = $products->name;
        $cus->seller_id = auth()->user()->id;
        $cus->cost = $request['price'];
        $cus->quantity = $request['quantity'];
        $asset->available = $products->available - $cus->quantity;
        $asset->save();
        
        $cus->vendor = $products->vendor;
        $cus->customer = $request['name'];
        $cus->save();
        return redirect('http://localhost/vesit/public/asset')->with('success','Asset Stock Has been sold successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $products = Stock::find($id);

        $cus = new Customer;
        $cus->product_name = $products->name;
        $cus->seller_id = auth()->user()->id;
        $cus->cost = $request['price'];
        $cus->quantity = $request['quantity'];
        $asset->available = $products->available - $cus->quantity;
        $asset->save();
        
        $cus->vendor = $products->vendor;
        $cus->customer = $request['name'];
        $cus->save();

        return redirect('http://localhost/vesit/public/asset')->with('success','Asset Stock Removed');
    }
    
}
