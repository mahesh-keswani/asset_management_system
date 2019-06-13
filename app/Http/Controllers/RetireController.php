<?php

namespace App\Http\Controllers;
use Mail;
use Illuminate\Http\Request;
use App\Location;
use App\Group;
use App\Asset;
use App\Stock;
use App\Inventory;
use App\Retire;
use DB;

class RetireController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function showRetire($asset_id)
    {
        $check_if_under_service = DB::select("SELECT item_id FROM services WHERE item_id = $asset_id AND expected_complete_date >= CURDATE()");

        if(!empty($check_if_under_service))
        {
            echo '<script>
                        alert("Error");
                    </script>';
             return redirect('http://localhost/vesit/public/asset')->with('error','Requested asset is under service');

        }

        return view('pages.retireasset')->with('asset_id',$asset_id);
    }
    public function showStockRetire($stock_id)
    {
        
        $check_if_under_service = DB::select("SELECT stock_id FROM services WHERE stock_id = $stock_id AND expected_complete_date >= CURDATE()");

        if(!empty($check_if_under_service))
        {
            echo '<script>
                        alert("Error");
                    </script>';
             return redirect('http://localhost/vesit/public/asset')->with('error','Requested asset is under service');

        }
        return view('pages.retirestock')->with('stock_id',$stock_id);
    }
    public function showInventoryRetire($inventory_id)
    {
        $check_if_under_service = DB::select("SELECT inventory_id FROM services WHERE inventory_id = $inventory_id AND expected_complete_date >= CURDATE()");

        if(!empty($check_if_under_service))
        {
            echo '<script>
                        alert("Error");
                    </script>';
             return redirect('http://localhost/vesit/public/asset')->with('error','Requested asset is under service');

        }
        return view('pages.retireinventory')->with('inventory_id',$inventory_id);
    }
    public function assetRetire(Request $request)
    {
        $location = Location::all();
        $group = Group::all();
        $asset = Asset::all();
        $stock = Stock::all();
        $inventory = Inventory::all();

        $data = array('location'=>$location,'group'=>$group,'asset'=>$asset,'stock'=>$stock,'inventory'=>$inventory);

        $retire_date = $request->input('retire_date');
        if($retire_date < date('Y-m-d',time()))
        {
            echo '<script>
                        alert("Retire date has been passed out");
                    </script>';
             return redirect('http://localhost/vesit/public/asset')->with('error','Retire date has been passed out');
        }
        
        $service = New Retire;
        $service->retire_date = $request->input('retire_date');
        $service->reason = $request->input('reason');
        $service->comments = $request->input('comments');
        $service->total_salvage = $request->input('salvage');
        $service->item_id = $request->input('asset_id'); 
        
     

        $service->save();

        $value = 'Asset with is '. $service->item_id.' has been retired';
        $status = 'Retire';
        $created_at = $request->input('retire_date');
        $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
        DB::table('notifications')->insert($a);
        Mail::send('pages.reservationmail',['name'=>'Admin'],function($message)
                {
                    $message->to('2017.mahesh.keswani@ves.ac.in');
                    $message->subject('Retire Alert');
                    $message->from(auth()->user()->email);
                });
        return redirect('http://localhost/vesit/public/asset')->with('success','Successfully Retired');
        }
    public function inventoryRetire(Request $request)
    {
        $location = Location::all();
        $group = Group::all();
        $asset = Asset::all();
        $stock = Stock::all();
        $inventory = Inventory::all();

        $data = array('location'=>$location,'group'=>$group,'asset'=>$asset,'stock'=>$stock,'inventory'=>$inventory);

        $retire_date = $request->input('retire_date');
        if($retire_date < date('Y-m-d',time()))
        {
            echo '<script>
                        alert("Retire date has been passed out");
                    </script>';
             return redirect('http://localhost/vesit/public/asset')->with('error','Retire date has been passed out');
        }
     
        $service = New Retire;
        $service->retire_date = $request->input('retire_date');
        $service->reason = $request->input('reason');
        $service->total_salvage = $request->input('salvage');
        $service->comments = $request->input('comments');
        $service->inventory_id = $request->input('inventory_id'); 
        
     

        $service->save();
        $value = 'Inventory with is '. $service->inventory_id.' has been retired';
        $status = 'Retire';
        $created_at = $request->input('retire_date');
        $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
        DB::table('notifications')->insert($a);
        Mail::send('pages.reservationmail',['name'=>'Admin'],function($message)
                {
                    $message->to('2017.mahesh.keswani@ves.ac.in');
                    $message->subject('Retire Alert');
                    $message->from(auth()->user()->email);
                });
             return redirect('http://localhost/vesit/public/asset')->with('success','Successfully Retired');
    }
    public function stockRetire(Request $request)
    {
        $location = Location::all();
        $group = Group::all();
        $asset = Asset::all();
        $stock = Stock::all();
        $inventory = Inventory::all();

        $data = array('location'=>$location,'group'=>$group,'asset'=>$asset,'stock'=>$stock,'inventory'=>$inventory);

         $retire_date = $request->input('retire_date');
        if($retire_date < date('Y-m-d',time()))
        {
            echo '<script>
                        alert("Retire date has been passed out");
                    </script>';
             return redirect('http://localhost/vesit/public/asset')->with('error','Retire date has been passed out');
        }
     
        $service = New Retire;
        $service->retire_date = $request->input('retire_date');
        $service->reason = $request->input('reason');
        $service->total_salvage = $request->input('salvage');
        $service->comments = $request->input('comments');
        $service->stock_id = $request->input('stock_id'); 
        
     

        $service->save();
        $value = 'Asset Stock with is '. $service->stock_id.' has been retired';
        $status = 'Retire';
        $created_at = $request->input('retire_date');
        $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
        DB::table('notifications')->insert($a);
        Mail::send('pages.reservationmail',['name'=>'Admin'],function($message)
                {
                    $message->to('2017.mahesh.keswani@ves.ac.in');
                    $message->subject('Retire Alert');
                    $message->from(auth()->user()->email);
                });
             return redirect('http://localhost/vesit/public/asset')->with('success','Successfully Retired');
}
}