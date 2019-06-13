<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Asset;
use App\Group;
use App\ProductToHide;
use App\Location;
use App\User;
use App\Stock;
use App\Inventory;
use App\Service;
use App\Mail\SendMail;
use DB;
use Mail;
use App\Vendor;
use App\Notification;
use App\Exports\ExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Customer;

//use App\Http\Controllers\Mail;

class AssetController extends Controller
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
    
    public function show_payment_func()
    {
        return view('pages.payment_process');
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
        //$group_name = $request['group'];

        //$group_id = DB::select("SELECT id FROM groups WHERE 'name'= $group_name");

        if($cost <= 0 || $quantity <= 0)
        {
            return redirect('http://localhost/vesit/public/asset')->with('error','Invalid Input');

        }
       
        $asset = New Asset;
        $asset->name = $request->input('name');
        $asset->description = $request->input('description');
        $asset->location = $request->input('location');
        $asset->group = $request->input('group');        
        $asset->purchased_on = $request->input('purchased_on');
        $asset->cost_price = $request->input('cost_price');
        $asset->quantity = $request->input('quantity');
        $asset->vendor = $request['vendor'];
        $asset->available = $asset->quantity;
       // $asset->group_id = $group_id;
        $asset->user_id = auth()->user()->id;
        $asset->save();

        $value = 'Asset '. $asset->name.' has been added Successfully';
        $status = 'Successful';
        $created_at = $request->input('purchased_on');

        $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
        DB::table('notifications')->insert($a);

        return redirect('http://localhost/vesit/public/asset')->with('success','Asset Added');
       
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
       $asset = Asset::find($id); 

        $q1 = DB::table('assets')->where('id',$id)->first();
        $q2 = DB::table('groups')->where('name',$q1->group)->get();
        $q3 = DB::select("SELECT total_salvage FROM retires WHERE item_id=$id");

        $user_find = DB::select("SELECT user_id FROM checkouts WHERE return_date >= CURDATE() AND item_id=$id");
        //return $user_find;
        if(!empty($user_find))
        {
            $user_id = $user_find[0]->user_id;
            $checkedout_status = 1; 
        }
        else
        {
            $user_id ='';
            $checkedout_status = 0;
        }
       
        if(!empty($q3))
        {
            $percent = $q2[0]->depreciation_rate;
            $total_cost = $asset['quantity'] * $asset['cost_price'];

            $d_rate = $total_cost - $q3[0]->total_salvage * $duration * 0.01;
            $data = array('asset'=>$asset,'d_rate'=>$d_rate,'user_id'=>$user_id);
        }
        else
        {
            $data = array('asset'=>$asset,'user_id'=>$user_id);
        }


        return view('pages.showasset')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asset = Asset::find($id);
        return view('pages.edit')->with('asset',$asset);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
       
        $asset = Asset::find($id);
        $asset->name=$request->input('name');
        $asset->description = $request->input('description');
        $asset->location = $request->input('location');
        $asset->group = $request->input('group');
  

        $asset->purchased_on = $request->input('purchased_on');
        $asset->save();
        $value = 'Asset '. $asset->name.' has been updated Successfully';
        $status = 'Successful';
        $created_at = $request->input('purchased_on');

        $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
        DB::table('notifications')->insert($a);

        return redirect('http://localhost/vesit/public/asset')->with('success','Asset Updated Successfully');
    }

    public function customer(Request $request,$id)
    {
        $asset = Asset::find($id);

        $cus = new Customer;
        $cus->product_name = $asset->name;
        $cus->seller_id = auth()->user()->id;
        $cus->cost = $request['price'];
        $cus->quantity = $request['quantity'];
        $asset->available = $asset->available - $cus->quantity;
        $asset->save();
        
        $cus->vendor = $asset->vendor;
        $cus->customer = $request['name'];
        $cus->save();

        return redirect('http://localhost/vesit/public/asset')->with('success','Asset Sold Successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $asset = Asset::find($id);

        $cus = new Customer;
        $cus->product_name = $asset->name;
        $cus->seller_id = auth()->user()->id;
        $cus->cost = $request['price'];
        $cus->quantity = $request['quantity'];
        $asset->available = $asset->available - $cus->quantity;
        $asset->save();
        
        $cus->vendor = $asset->vendor;
        $cus->customer = $request['name'];
        $cus->save();
        

        return redirect('http://localhost/vesit/public/asset')->with('success','Asset Removed');
    
    }

    public function member()
    {
        $users = User::all();
        return view('pages.members')->with('users',$users);
    }

    public function showItems()
    {
        $state = auth()->user()->state;
        

        if($state == 'Active')
        {
             $asset = Asset::all();
            $stock = Stock::all();
            $inventory = Inventory::all();
            $users = User::all();

            $user_to_hide = DB::select("SELECT user_name FROM product_to_hides WHERE user_name = 'Auth()::user()->name'");
            if(!empty($user_to_hide))
            {
                $pth = $user_to_hide->product_name;
                $data = array('asset'=>$asset,'stock'=>$stock,'inventory'=>$inventory,'pth'=>$pth,'users'=>$users);
                
            }
            else
            {
                $data = array('asset'=>$asset,'stock'=>$stock,'inventory'=>$inventory,'users'=>$users);
            }
            return view('pages.additems')->with($data);
                
        }
        else
        {
            return redirect('http://localhost/vesit/public/asset')->with('error','Your state is inactive');
   
        }
    }
    public function pay()
    {
        return view('paywithstripe');
    }

   public function somefunction($id)
   {
      // $user_id = $request->input('id');
      if(auth()->user()->role == 'Admin')
      {
            $user = User::find($id);
            if($user['state'] == 'Active')
            {
                $user['state'] = 'Inactive';
            }
            else
            {
                $user['state'] = 'Active';
            }
            $user->save();

            $value = 'State of Member with id '. $user->id.' has been changed ';
            $status = 'State Changed';
            $created_at = date('Y-m-d',time());
            $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
            DB::table('notifications')->insert($a);

            $users = User::all();
            return view('pages.members')->with('users',$users);
      }
      else
      {
        return redirect('http://localhost/vesit/public/asset')->with('error','You are not authorized to change the state');

      }
    }
    public function export() 
    {
        return Excel::download(new ExcelExport, 'assets.xlsx');
    }
    public function purchaseOrder()
    {
        $location = Location::all();
        $group = Group::all();
        $asset = Asset::all();
        $stock = Stock::all();
        $inventory = Inventory::all();
        $vendor = Vendor::all();
        $notification = Notification::all();
        $userAdmins = User::where('role','Admin');

        $data = array('location'=>$location,'group'=>$group,'asset'=>$asset,'stock'=>$stock,'inventory'=>$inventory,'vendor'=>$vendor,'notification'=>$notification,'userAdmins'=>$userAdmins);

        return view('pages.dashboard')->with($data);
    }
   
}
