<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Location;
use App\Group;
use App\Asset;
use App\Stock;
use App\Inventory;
use App\Checkout;
use DB;
use App\Notification;
class CheckoutController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function showCheckout($asset_id)
    {
        
        $check_if_under_service = DB::select("SELECT item_id FROM services WHERE item_id = $asset_id AND expected_complete_date >= CURDATE()");

        
        if(!empty($check_if_under_service))
        {
            echo '<script>
                        alert("Error");
                    </script>';

             return redirect('http://localhost/vesit/public/asset')->with('error','Requested asset is under service');

        }
        //check if asset is already reserved

        $check_if_already_reserved = DB::select("SELECT item_id FROM reservations WHERE item_id = $asset_id AND to_date >= CURDATE()");

        if(!empty($check_if_already_reserved))
        {
            return redirect('http://localhost/vesit/public/asset')->with('error','Requested asset is already reserved');

        }
        

        //Check if return date of checkout is equal to current date
        $user_reserved = DB::select("SELECT id FROM checkouts WHERE item_id IN
                                        (SELECT item_id FROM checkouts WHERE return_date <= CURDATE())
                                        "); 
        

        if(!empty($user_reserved))
        {
            $id = $user_reserved[0]->id;
            $tp1 = DB::select("SELECT item_id FROM checkouts WHERE return_date <= CURDATE()");

            $asset_find = Asset::find($tp1[0]->item_id);

            $asset_find['available'] = $asset_find['quantity'];
            $asset_find->save();

            DB::delete("DELETE FROM checkouts WHERE id=$id");

            return redirect('http://localhost/vesit/public/asset')->with('error','Asset with id '.$tp1[0]->item_id.'has been automatically checked out');
 
        }
        
        $user = User::all();
        $location = Location::all();

        $asset= Asset::find($asset_id);             
       
        $data = array('asset_id'=>$asset_id,'user'=>$user,'location'=>$location);
        return view('pages.checkoutasset')->with($data);
        
    }
    public function showStockCheckout($stock_id)
    {
        $check_if_under_service = DB::select("SELECT stock_id FROM services WHERE stock_id = $stock_id AND expected_complete_date >= CURDATE()");

        if(!empty($check_if_under_service))
        {
            echo '<script>
                        alert("Error");
                    </script>';
             return redirect('http://localhost/vesit/public/asset')->with('error','Requested asset is under service');

        }

        $user_reserved = DB::select("SELECT id FROM checkouts WHERE stock_id IN
                                        (SELECT stock_id FROM checkouts WHERE return_date <= CURDATE())
                                     "); 


        if(!empty($user_reserved))
        {
            $id = $user_reserved[0]->id;
            $tp1 = DB::select("SELECT stock_id FROM checkouts WHERE return_date <= CURDATE()");

            $asset_find = Stock::find($tp1[0]->stock_id);

            $asset_find['available'] = $asset_find['quantity'];
            $asset_find->save();

            DB::delete("DELETE FROM checkouts WHERE id=$id");

            return redirect('http://localhost/vesit/public/asset')->with('error','Asset Stock  with id '.$tp1[0]->stock_id.' has been automatically checked out');

        }
        
        $check_if_already_reserved = DB::select("SELECT stock_id FROM reservations WHERE stock_id = $stock_id AND to_date >= CURDATE()");

        if(!empty($check_if_already_reserved))
        {
            return redirect('http://localhost/vesit/public/asset')->with('error','Requested asset stock is already reserved');

        }
        

        $user = User::all();
        $location = Location::all();

        $stock= Stock::find($stock_id);             
       
        $data = array('stock_id'=>$stock_id,'user'=>$user,'location'=>$location);
        return view('pages.checkoutstock')->with($data);
    }
    public function showInventoryCheckout($inventory_id)
    {
        $check_if_under_service = DB::select("SELECT inventory_id FROM services WHERE inventory_id = $inventory_id AND expected_complete_date >= CURDATE()");

        if(!empty($check_if_under_service))
        {
            echo '<script>
                        alert("Error");
                    </script>';
             return redirect('http://localhost/vesit/public/asset')->with('error','Requested asset is under service');

        }

        $user_reserved = DB::select("SELECT id FROM checkouts WHERE inventory_id IN
                                         (SELECT inventory_id FROM checkouts WHERE return_date <= CURDATE())
                                    "); 


        if(!empty($user_reserved))
        {
            $id = $user_reserved[0]->id;
            $tp1 = DB::select("SELECT inventory_id FROM checkouts WHERE return_date <= CURDATE()");

            $asset_find = Inventory::find($tp1[0]->item_id);

            $asset_find['available'] = $asset_find['quantity'];
            $asset_find->save();

            DB::delete("DELETE FROM checkouts WHERE id=$id");

            return redirect('http://localhost/vesit/public/asset')->with('error','Inventory with id '.$tp1[0]->item_id.'has been automatically checked out');

        }
        
        $check_if_already_reserved = DB::select("SELECT inventory_id FROM reservations WHERE inventory_id = $inventory_id AND to_date >= CURDATE()");

        if(!empty($check_if_already_reserved))
        {
            return redirect('http://localhost/vesit/public/asset')->with('error','Requested inventory is already reserved');

        }
        

        $user = User::all();
        $location = Location::all();

        $inventory= Inventory::find($inventory_id);             
       
        $data = array('inventory_id'=>$inventory_id,'user'=>$user,'location'=>$location);
        return view('pages.checkoutinventory')->with($data);
    }
    public function assetCheckout(Request $request)
    {
        
        $id = $request['asset_id'];
       
         $tp =  Asset::find($id);
        
        if($tp['available'] < 1)
        {
            echo '<script>
                        alert("Available Quantity is less than 1");
                    </script>';
             return redirect('http://localhost/vesit/public/asset')->with('error','Available Quantity is less than 1');

        }
        else if($request->input('quantity') > $tp['available'])
        {
            echo '<script>
                        alert("Requested quantity is greater than availablequantity");
                    </script>';
             return redirect('http://localhost/vesit/public/asset')->with('error','Requested quantity is greater than availablequantity');
         }
        else if($request->input('return_date') < date('Y-m-d',time()))
        { 
                echo '<script>
                         alert("Return date cannot be less than request date");
                     </script>';
                     return redirect('http://localhost/vesit/public/asset')->with('error','Return date cannot be less than request date');
         }
       
        else
        {
            
            $service = New Checkout;
            $service->return_date = $request->input('return_date');
            $service->checkout_to = $request->input('checkout_to');
            $service->location = $request->input('location');
            $service->description = $request->input('description');
            $service->item_id = $request->input('asset_id'); 
            $service->user_id = auth()->user()->id;
            $service->created_at = $request->input('created_at');
            $service->quantity = $request->input('quantity');
            $tp->available = $tp->available -  $service->quantity;

    
            $value = 'Asset '. $tp->name.' has been checked out to '.$service->checkout_to;
            $status = 'CheckIn Pending';
            $created_at = $request->input('created_at');

            $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
            DB::table('notifications')->insert($a);

            $tp->save();
            $service->save();
           

            return redirect('http://localhost/vesit/public/asset')->with('success','Asset has been successfully checked out');
        }
    }
    public function inventoryCheckout(Request $request)
    {
        $location = Location::all();
        $group = Group::all();
        $asset = Asset::all();
        $stock = Stock::all();
        $inventory = Inventory::all();

        $data = array('location'=>$location,'group'=>$group,'asset'=>$asset,'stock'=>$stock,'inventory'=>$inventory);
        $id = $request['inventory_id'];
       
         $tp =  Inventory::find($id);
      
        if($tp['available'] <= 0 || ($request->input('quantity') <= 0))
        {
            echo '<script>
                        alert("Error");
                    </script>';
             return redirect('http://localhost/vesit/public/asset')->with('error','Available Quantity is less than 1');

        }
        else if($request->input('quantity') > $tp['available'])
        {
            echo '<script>
                        alert("Requested quantity is greater than availablequantity");
                    </script>';
                    return redirect('http://localhost/vesit/public/asset')->with('error','Requested quantity is greater than availablequantity');
                }
        else if($request->input('return_date') < $request->input('created_at'))
        { 
                echo '<script>
                         alert("Return date cannot be less than request date");
                     </script>';
                     return redirect('http://localhost/vesit/public/asset')->with('error','Return date cannot be less than request date');
        }
       
        else
        {
            $service = New Checkout;
            $service->return_date = $request->input('return_date');
            $service->checkout_to = $request->input('checkout_to');
            $service->location = $request->input('location');
            $service->description = $request->input('description');
            $service->inventory_id = $request->input('inventory_id'); 
            $service->user_id = auth()->user()->id;
            $service->created_at = $request->input('created_at');
            $service->quantity = $request->input('quantity');
            $tp['available'] = $tp['available'] - $request['quantity'];
            
            $value = 'Asset Stock '. $tp->name.' has been checked out to '.$service->checkout_to;
            $status = 'CheckIn Pending';
            $created_at = $request->input('created_at');

            $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
            DB::table('notifications')->insert($a);

            $tp->save();
            $service->save();
           

            return redirect('http://localhost/vesit/public/asset')->with('success','Inventory has been successfully checked out');
        }
    }
    public function stockCheckout(Request $request)
    {
        $location = Location::all();
        $group = Group::all();
        $asset = Asset::all();
        $stock = Stock::all();
        $inventory = Inventory::all();

        $data = array('location'=>$location,'group'=>$group,'asset'=>$asset,'stock'=>$stock,'inventory'=>$inventory);
        $id = $request['stock_id'];
       
         $tp =  Stock::find($id);
        
      
        if($tp['available'] <= 0)
        {
            echo '<script>
                        alert("Error");
                    </script>';
             return redirect('http://localhost/vesit/public/asset')->with('error','Available Quantity is less than 1');

        }
        else if($request->input('quantity') > $tp['available'])
        {
            echo '<script>
                        alert("Requested quantity is greater than availablequantity");
                    </script>';
                    return redirect('http://localhost/vesit/public/asset')->with('error','Requested quantity is greater than availablequantity');
                }
        else if($request->input('return_date') < $request->input('created_at'))
        { 
                echo '<script>
                         alert("Return date cannot be less than request date");
                     </script>';
                     return redirect('http://localhost/vesit/public/asset')->with('error','Return date cannot be less than request date');
        }
       
        else
        {
            $service = New Checkout;
            $service->return_date = $request->input('return_date');
            $service->checkout_to = $request->input('checkout_to');
            $service->location = $request->input('location');
            $service->description = $request->input('description');
            $service->stock_id = $request->input('stock_id'); 
            $service->user_id = auth()->user()->id;
            $service->created_at = $request->input('created_at');
            $service->quantity = $request->input('quantity');
            $tp['available'] = $tp['available'] - $request['quantity'];

            $value = 'Stock '. $tp->name.' has been checked out to '.$service->checkout_to;
            $status = 'CheckIn Pending';
            $created_at = $request->input('created_at');

            $a = array('messages'=>$value,'status'=>$status,'created_at'=>$request->input('created_at'));
            DB::table('notifications')->insert($a);

            $tp->save();
            $service->save();
           

            return redirect('http://localhost/vesit/public/asset')->with('success','Stock has been successfully checked out');
        }
    }
    public function confirmAsset($id,$user_id)
    {
        if(auth()->user()->id == $user_id)
        {
            $asset  = Asset::find($id);
            $asset['available'] = $asset['quantity'];
            $asset->save();
            return redirect('http://localhost/vesit/public/asset')->with('success','Checked I successfully');

        }
        else
        {
            return redirect('http://localhost/vesit/public/asset')->with('success','You did not checked out,so dont try to checkin');

        }
    }
    public function confirmInventory($id,$user_id)
    {
        if(auth()->user()->id == $user_id)
        {
            $asset  = Inventory::find($id);
            $asset['available'] = $asset['quantity'];
            $asset->save();
            return redirect('http://localhost/vesit/public/asset')->with('success','Checked I successfully');

        }
        else
        {
            return redirect('http://localhost/vesit/public/asset')->with('success','You did not checked out,so dont try to checkin');

        }
    }
    public function confirmStock($id,$user_id)
    {
        if(auth()->user()->id == $user_id)
        {
            $asset  = Stock::find($id);
            $asset['available'] = $asset['quantity'];
            $asset->save();
            return redirect('http://localhost/vesit/public/asset')->with('success','Checked I successfully');

        }
        else
        {
            return redirect('http://localhost/vesit/public/asset')->with('success','You did not checked out,so dont try to checkin');

        }
    }
}
