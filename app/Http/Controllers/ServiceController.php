<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Location;
use App\Group;
use App\Asset;
use App\Stock;
use App\Inventory;
use DB;
use Mail;
class ServiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public static function serviceMail($email)
    {
        if(!empty($email))
        {
            Mail::send('servicemail',['name'=>'Admin'],function($message) use($email)
            {
                $message->to($email);
                $message->subject('Service Alert');
                $message->from('2017.mahesh.keswani@ves.ac.in');
            });
        }

    }
    public function showService($asset_id)
    {
        $location = Location::all();
        $group = Group::all();
        $asset = Asset::all();
        $stock = Stock::all();
        $inventory = Inventory::all();

        $data = array('location'=>$location,'group'=>$group,'asset'=>$asset,'stock'=>$stock,'inventory'=>$inventory);

        $check_if_date_less_than_today = DB::select("SELECT id FROM services WHERE item_id IN 
                                                        (SELECT item_id FROM services WHERE expected_complete_date <= CURDATE())
                                                    ");
        if(!empty($check_if_date_less_than_today))
        {
            $id = $check_if_date_less_than_today[0]->id;
            
            DB::delete("DELETE FROM services WHERE id=$id");
            return redirect('http://localhost/vesit/public/asset')->with('error','The selected asset is recovered automatically from service');


        }
        $check_if_already_exits = DB::select("SELECT item_id FROM services WHERE item_id = $asset_id AND expected_complete_date >= CURDATE()");

        if(!empty($check_if_already_exits))
        {
    
            $email_tp = DB::select("SELECT email FROM users WHERE id = 
                                    (SELECT user_id FROM assets WHERE id IN
                                        (SELECT item_id FROM services WHERE expected_complete_date >= CURDATE())
                                    )
                                ");
            
            echo '<script>
                        alert("The selected asset is already under service");
                </script>';

            ServiceController::serviceMail($email_tp[0]->email);           
            return redirect('http://localhost/vesit/public/asset')->with('error','The selected asset is already under service');
         

        }
        $check_if_checked_out = DB::select("SELECT item_id FROM checkouts WHERE return_date >= CURDATE()");

        if(!empty($check_if_checked_out))
        {
            return redirect('http://localhost/vesit/public/asset')->with('error','The selected asset is already checked out');

        }
        else
        {
            return view('pages.serviceasset')->with('asset_id',$asset_id);
        }
       
    }
    public function showStockService($stock_id)
    {
        $location = Location::all();
        $group = Group::all();
        $asset = Asset::all();
        $stock = Stock::all();
        $inventory = Inventory::all();

        $data = array('location'=>$location,'group'=>$group,'asset'=>$asset,'stock'=>$stock,'inventory'=>$inventory);

        $check_if_date_less_than_today = DB::select("SELECT id FROM services WHERE stock_id IN 
                                                        (SELECT stock_id FROM services WHERE expected_complete_date <= CURDATE())
                                                    ");
        if(!empty($check_if_date_less_than_today))
        {
            $id = $check_if_date_less_than_today[0]->id;
            
            DB::delete("DELETE FROM services WHERE id=$id");
            return redirect('http://localhost/vesit/public/asset')->with('error','The selected asset stock is recovered automatically from service');


        }
        $check_if_already_exits = DB::select("SELECT stock_id FROM services WHERE stock_id = $stock_id AND expected_complete_date >= CURDATE()");

        if(!empty($check_if_already_exits))
        {

          
            //return CURDATE();
            $email_tp = DB::select("SELECT email FROM users WHERE id = 
                                    (SELECT user_id FROM stocks WHERE id =
                                        (SELECT stock_id FROM services WHERE expected_complete_date >= CURDATE())
                                    )
                                ");

            if(!empty($email_tp))
            {
                echo '<script>
                            alert("The selected asset is already under service");
                    </script>';

                ServiceController::serviceMail($email_tp[0]->email);           
            }
           else
            {   
                echo '<script>
                            alert("The selected asset is already under service");
                    </script>';
            }
            return redirect('http://localhost/vesit/public/asset')->with('error','The selected asset is already under service');

        }
        $check_if_checked_out = DB::select("SELECT stock_id FROM checkouts WHERE return_date >= CURDATE()");

            if(!empty($check_if_checked_out))
            {
                return redirect('http://localhost/vesit/public/asset')->with('error','The selected asset stock is already checked out');

            }
        else
        {
            return view('pages.servicestock')->with('stock_id',$stock_id);
        }
       
    }
    public function showInventoryService($inventory_id)
    {
        $location = Location::all();
        $group = Group::all();
        $asset = Asset::all();
        $stock = Stock::all();
        $inventory = Inventory::all();

        $data = array('location'=>$location,'group'=>$group,'asset'=>$asset,'stock'=>$stock,'inventory'=>$inventory);

        $check_if_date_less_than_today = DB::select("SELECT id FROM services WHERE inventory_id IN 
                                                        (SELECT inventory_id FROM services WHERE expected_complete_date <= CURDATE())
                                                    ");
        if(!empty($check_if_date_less_than_today))
        {
            $id = $check_if_date_less_than_today[0]->id;
            
            DB::delete("DELETE FROM services WHERE id=$id");
            return redirect('http://localhost/vesit/public/asset')->with('error','The selected inventory is recovered automatically from service');


        }
        
      $check_if_already_exits = DB::select("SELECT inventory_id FROM services WHERE inventory_id = $inventory_id AND expected_complete_date >= CURDATE()");


        if(!empty($check_if_already_exits))
        {

            $time = time();
            $actual_date = date('Y-m-d');
    
            $service = Service::all();
            //return CURDATE();
            $email_tp = DB::select("SELECT email FROM users WHERE id = 
                                    (SELECT user_id FROM inventories WHERE id =
                                        (SELECT inventory_id FROM services WHERE expected_complete_date >= CURDATE())
                                    )
                                ");
           if(!empty($email_tp))
           {
               echo '<script>
                           alert("The selected asset is already under service");
                   </script>';

               ServiceController::serviceMail($email_tp[0]->email);           
           }
           else
           {   
               echo '<script>
                           alert("The selected asset is already under service");
                   </script>';
           }
           return redirect('http://localhost/vesit/public/asset')->with('error','The selected asset is already under service');

        }
        $check_if_checked_out = DB::select("SELECT inventory_id FROM checkouts WHERE return_date >= CURDATE()");

            if(!empty($check_if_checked_out))
            {
                return redirect('http://localhost/vesit/public/asset')->with('error','The selected inventory is already checked out');

            }
        else
        {
            return view('pages.serviceinventory')->with('inventory_id',$inventory_id);
        }
    }
    public function assetService(Request $request)
    {
        $location = Location::all();
        $group = Group::all();
        $asset = Asset::all();
        $stock = Stock::all();
        $inventory = Inventory::all();

        $data = array('location'=>$location,'group'=>$group,'asset'=>$asset,'stock'=>$stock,'inventory'=>$inventory);

        $cost = $request['cost'];
        $expected_complete_date = $request['expected_complete_date'];

        if($cost <= 0)
        {
            echo '<script>
                        alert("Cost entered is Invalid");
                 </script>';
                 return redirect('http://localhost/vesit/public/asset')->with('error','Cost eneterd is n valid');
   
        }
        if($expected_complete_date < date('Y-m-d',time()))
        {
            echo '<script>
                        alert("Invalid expected complete date");
                 </script>';
                 return redirect('http://localhost/vesit/public/asset')->with('error','Invalid expected complete date');
          }
        else
        {
            $service = New Service;
            $service->expected_complete_date = $request->input('expected_complete_date');
            $service->cost = $request->input('cost');
            $service->performed_by = $request->input('performed_by');
            $service->item_id = $request->input('asset_id'); 
            
            $service->type = $request->input('type');
         
            
            $service->save();


            $value = 'Service for asset with id '. $service->item_id.' is expected to complete on  '.$service->expected_complete_date;
            $status = 'Service Pending';
            $created_at = $request->input('expected_complete_date');

            $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
            DB::table('notifications')->insert($a);
            return redirect('http://localhost/vesit/public/asset')->with('success','Service for Asset');

        }

    }
    public function inventoryService(Request $request)
    {
        $location = Location::all();
        $group = Group::all();
        $asset = Asset::all();
        $stock = Stock::all();
        $inventory = Inventory::all();

        $data = array('location'=>$location,'group'=>$group,'asset'=>$asset,'stock'=>$stock,'inventory'=>$inventory);

        $cost = $request['cost'];
        $expected_complete_date = $request['expected_complete_date'];

        if($cost <= 0)
        {
            echo '<script>
                        alert("Cost entered is Invalid");
                 </script>';
                 return redirect('http://localhost/vesit/public/asset')->with('error','Cost eneterd is n valid');
   
        }
        if($expected_complete_date < date('Y-m-d',time()))
        {
            echo '<script>
                        alert("Invalid expected complete date");
                 </script>';
                 return redirect('http://localhost/vesit/public/asset')->with('error','Invalid expected complete date');
        }
        else
        {
            $service = New Service;
            $service->expected_complete_date = $request->input('expected_complete_date');
            $service->cost = $request->input('cost');
            $service->performed_by = $request->input('performed_by');
            $service->inventory_id = $request->input('inventory_id'); 
            
            $service->type = $request->input('type');
         
            
            $service->save();
            $value = 'Service for inventory with id '. $service->inventory_id.' is expected to complete on  '.$service->expected_complete_date;
            $status = 'Service Pending';
            $created_at = $request->input('expected_complete_date');

            $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
            DB::table('notifications')->insert($a);
            return redirect('http://localhost/vesit/public/asset')->with('success','Service for Inventory');

        }   
     }
    public function stockService(Request $request)
    {
        $location = Location::all();
        $group = Group::all();
        $asset = Asset::all();
        $stock = Stock::all();
        $inventory = Inventory::all();

        $data = array('location'=>$location,'group'=>$group,'asset'=>$asset,'stock'=>$stock,'inventory'=>$inventory);

        $cost = $request['cost'];
        $expected_complete_date = $request['expected_complete_date'];

        if($cost <= 0)
        {
            echo '<script>
                        alert("Cost entered is Invalid");
                 </script>';
                 return redirect('http://localhost/vesit/public/asset')->with('error','Cost eneterd is n valid');
   
        }
        if($expected_complete_date < date('Y-m-d',time()))
        {
            echo '<script>
                        alert("Invalid expected complete date");
                 </script>';
                 return redirect('http://localhost/vesit/public/asset')->with('error','Invalid expected complete date');
        }
        else
        {
            $service = New Service;
            $service->expected_complete_date = $request->input('expected_complete_date');
            $service->cost = $request->input('cost');
            $service->performed_by = $request->input('performed_by');
            $service->stock_id = $request->input('stock_id'); 
            
            $service->type = $request->input('type');
         
            
            $service->save();
            $value = 'Service for asset stock with id '. $service->stock_id.' is expected to complete on  '.$service->expected_complete_date;
            $status = 'Service Pending';
            $created_at = $request->input('expected_complete_date');

            $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
            DB::table('notifications')->insert($a);
            return redirect('http://localhost/vesit/public/asset')->with('success','Service for Asset Stock');

        }
    }
}
