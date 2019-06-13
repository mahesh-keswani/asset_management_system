<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Inventory;
use App\Group;
use App\Asset;
use App\Stock;
use App\Location;

class InventoryController extends Controller
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
        $asset = New Inventory;
        $asset->name=$request->input('name');
        $asset->description = $request->input('description');
        $asset->location = $request->input('location');
        $asset->group = $request->input('group');
        $asset->purchased_on = $request->input('purchased_on');
        $asset->low_stock = $request->input('low_stock');
        $asset->quantity = $request->input('quantity');
        $asset->available = $asset->quantity;
        $asset->vendor = $request['vendor'];
        $asset->user_id = auth()->user()->id;
        $asset->cost_price = $request->input('cost_price');

        $asset->save();
        $value = 'Inventory with name '. $asset->name.' has been added successfully ';
        $status = 'Successful';
        $created_at = $request->input('purchased_on');
        $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
        DB::table('notifications')->insert($a);

        return redirect('http://localhost/vesit/public/asset')->with('success','Inventory has been added successfully');
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
        $inventory = Inventory::find($id); 
 
         $q1 = DB::table('inventories')->where('id',$id)->first();
         $q2 = DB::table('groups')->where('name',$q1->group)->get();
         $q3 = DB::select("SELECT total_salvage FROM retires WHERE inventory_id=$id");
         
     
         $user_find = DB::select("SELECT user_id FROM checkouts WHERE return_date >= CURDATE() AND inventory_id=$id");
        
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
             $total_cost = $inventory['quantity'] * $inventory['cost_price'];
 
             $d_rate = $total_cost - $q3[0]->total_salvage * $duration * 0.01;
             
             $data = array('asset'=>$asset,'d_rate'=>$d_rate,'user_id'=>$user_id);
         }
         else
         {
             $data = array('inventory'=>$inventory,'user_id'=>$user_id);
         }
         return view('pages.showinventory')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asset = Inventory::find($id);
        return view('pages.editinventory')->with('asset',$asset);
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
        $asset = Inventory::find($id);
        $asset->name=$request->input('name');
        $asset->description = $request->input('description');
        $asset->location = $request->input('location');
        $asset->group = $request->input('group');
        $asset->purchased_on = $request->input('purchased_on');
        $asset->low_stock = $request->input('low_stock');
        $asset->save();

        $value = 'Inventory '. $asset->name.' has been updated successfully ';
        $status = 'successful';
        $created_at = $request->input('purchased_on');
        $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
        DB::table('notifications')->insert($a);     

        
      return redirect('http://localhost/vesit/public/asset')->with('success','Inventory has been updated successfully');
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
      return redirect('http://localhost/vesit/public/asset')->with('success','Inventory has been sold successfully');
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

        return redirect('http://localhost/ams/public/assets')->with('success','Inventory Removed');
    }
}
