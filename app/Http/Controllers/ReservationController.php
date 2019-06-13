<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation;
use App\Asset;
use App\Stock;
use App\Inventory;
use App\Location;
use App\User;
use App\Group;
use DB;
use Mail;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showReservation($asset_id)
    {
        $user = User::all();
        $location = Location::all();

        $check_if_already_reserved = DB::select("SELECT item_id FROM reservations WHERE item_id = $asset_id AND to_date >= CURDATE()");

        if(!empty($check_if_already_reserved))
        {
            echo '<script>
                     alert("The selected asset is already reserved");
                </script>';

            return redirect('http://localhost/vesit/public/asset')->with('error','The selected asset is already reserved');

        }
        $check_if_under_service = DB::select("SELECT item_id FROM services WHERE item_id = $asset_id AND expected_complete_date >= CURDATE()");

        if(!empty($check_if_under_service))
        {
            echo '<script>
                        alert("Error");
                    </script>';
             return redirect('http://localhost/vesit/public/asset')->with('error','Requested asset is under service');

        }

        $check_if_already_checked_out = DB::select("SELECT item_id FROM checkouts WHERE item_id = $asset_id AND return_date >= CURDATE()");

        if(!empty($check_if_already_checked_out))
        {
            return redirect('http://localhost/vesit/public/asset')->with('error','Requested asset is already checked out');

        }
        else
        {
            
                $data = array('asset_id'=>$asset_id,'user'=>$user,'location'=>$location);
                return view('pages.reserveasset')->with($data);   
            
        }
      
    }
    public function showStockReservation($stock_id)
    {
        $user = User::all();
        $location = Location::all();
        $check_if_already_reserved = DB::select("SELECT stock_id FROM reservations WHERE stock_id = $stock_id AND to_date >= CURDATE()");

        if(!empty($check_if_already_reserved))
        {
            echo '<script>
                     alert("The selected asset is already reserved");
                </script>';

            return redirect('http://localhost/vesit/public/asset')->with('error','The selected asset is already reserved');

        }
        $check_if_under_service = DB::select("SELECT stock_id FROM services WHERE stock_id = $stock_id AND expected_complete_date >= CURDATE()");

        if(!empty($check_if_under_service))
        {
            echo '<script>
                        alert("Error");
                    </script>';
             return redirect('http://localhost/vesit/public/asset')->with('error','Requested asset is under service');

        }
        
        $check_if_already_checked_out = DB::select("SELECT stock_id FROM checkouts WHERE stock_id = $stock_id AND return_date >= CURDATE()");

        if(!empty($check_if_already_checked_out))
        {
            return redirect('http://localhost/vesit/public/asset')->with('error','Requested asset stock is already checked out');

        }
        else
        {
            $data = array('stock_id'=>$stock_id,'user'=>$user,'location'=>$location);
            return view('pages.reservestock')->with($data);
        }
    }
    public function showInventoryReservation($inventory_id)
    {
        $user = User::all();
        $location = Location::all();
        $check_if_already_reserved = DB::select("SELECT inventory_id FROM reservations WHERE inventory_id = $inventory_id AND to_date >= CURDATE()");

        if(!empty($check_if_already_reserved))
        {
            echo '<script>
                     alert("The selected asset is already reserved");
                </script>';

            return redirect('http://localhost/vesit/public/asset')->with('error','The selected asset is already under service');

        }
        $check_if_under_service = DB::select("SELECT inventory_id FROM services WHERE inventory_id = $inventory_id AND expected_complete_date >= CURDATE()");

        if(!empty($check_if_under_service))
        {
            echo '<script>
                        alert("Error");
                    </script>';
             return redirect('http://localhost/vesit/public/asset')->with('error','Requested asset is under service');

        }
        
        $check_if_already_checked_out = DB::select("SELECT inventory_id FROM checkouts WHERE inventory_id = $inventory_id AND return_date >= CURDATE()");

        if(!empty($check_if_already_checked_out))
        {
            return redirect('http://localhost/vesit/public/asset')->with('error','Requested inventory is already checked out');

        }
        else
        {
            $data = array('inventory_id'=>$inventory_id,'user'=>$user,'location'=>$location);
            return view('pages.reserveinventory')->with($data);
        }
    }
    public function assetReservation(Request $request)
    {
        $location = Location::all();
        $group = Group::all();
        $asset = Asset::all();
        $stock = Stock::all();
        $inventory = Inventory::all();

        $data = array('location'=>$location,'group'=>$group,'asset'=>$asset,'stock'=>$stock,'inventory'=>$inventory);

        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
        $asset_id = $request['asset_id'];
        $quantity = $request['quantity'];

        $asset = Asset::find($asset_id);

      
        if($from_date < date('Y-m-d',time()))
        {
            echo '<script>
                        alert("Entered From date has been passed out");
                </script>'; 
         return redirect('http://localhost/vesit/public/asset')->with('error','Entered From date has been passed out');

        }
        else if($from_date > $to_date)
        {
            echo '<script>
                        alert("Invalid From date and To date");
                </script>';
        return redirect('http://localhost/vesit/public/asset')->with('error','Entered From date has been passed out');

            
        }
        else if($asset['available'] < $quantity)
        {
            echo '<script>
                        alert("Requested quantity is greater than available quantity");
                </script>';
            return redirect('http://localhost/vesit/public/asset')->with('error','Entered From date has been passed out');

        }
        else if($quantity <= 0)
        {
            echo '<script>
                        alert("Entered quantity is invalid");
                </script>';
         return redirect('http://localhost/vesit/public/asset')->with('error','Entered From date has been passed out');

        }
        else
        {
            
            $service = New Reservation;
            $service->from_date = $request->input('from_date');
            $service->to_date = $request->input('to_date');
            $service->location = $request->input('location');
            $service->reservation_for = $request->input('reservation_for');
            $service->item_id = $request->input('asset_id'); 
            $service->user_id = auth()->user()->id;
            $service->quantity = $request->input('quantity');

            $email = auth()->user()->email;
            $role = auth()->user()->role;

            if($role == 'Staff')
            {
               
                Mail::send('pages.reservationmail',['name'=>'Admin'],function($message) use($email)
                {
                    $message->to('2017.mahesh.keswani@ves.ac.in');
                    $message->subject('Reservation Request');
                    $message->from($email);
                });  
                echo '<script>
                            alert("Your request has been sent to admin");
                    </script>';
                
                $value = 'Reservation Request for '. $asset->name.' has been made by '.$service->reservation_for;
                $status = $asset->status;
                $created_at = $request->input('from_date');

                $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
                DB::table('notifications')->insert($a);

             //  ConfirmController::receiveRequest($value,$created_at,$service->item_id,$service->quantity);
            /* $asset['available'] = $asset['available'] - $quantity;
                $asset->save();
                $service->save();
                */
                return redirect('http://localhost/vesit/public/asset')->with('success','Your request has been sent to admin');
            }
            else
            {
                $asset['available'] = $asset['available'] - $quantity;
                $asset->save();
                $service->status = 1;
                $service->save();

                $value = 'Reservation Request for '. $asset->name.' has been made by '.$service->reservation_for;
                $status = 'Approved';
                $created_at = $request->input('from_date');
                $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
                DB::table('notifications')->insert($a);

                return redirect('http://localhost/vesit/public/asset')->with('success','Reservation made successfully');


            }
        }
      
    }
    public function inventoryReservation(Request $request)
    {
        $location = Location::all();
        $group = Group::all();
        $asset = Asset::all();
        $stock = Stock::all();
        $inventory = Inventory::all();

        $data = array('location'=>$location,'group'=>$group,'asset'=>$asset,'stock'=>$stock,'inventory'=>$inventory);

        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
        $inventory_id = $request['inventory_id'];
        $quantity = $request['quantity'];

        $asset = Inventory::find($inventory_id);

       

        if($from_date < date('Y-m-d',time()))
        {
            echo '<script>
                        alert("Entered From date has been passed out");
                </script>'; 
         return redirect('http://localhost/vesit/public/asset')->with('error','Entered From date has been passed out');

        }
        else if($from_date > $to_date)
        {
            echo '<script>
                        alert("Invalid From date and To date");
                </script>';
        return redirect('http://localhost/vesit/public/asset')->with('error','Invalid From date and To date');

            
        }
        else if($asset['available'] < $quantity)
        {
            echo '<script>
                        alert("Requested quantity is greater than available quantity");
                </script>';
            return redirect('http://localhost/vesit/public/asset')->with('error','Requested quantity is greater than available quantity');

        }
        else if($quantity <= 0)
        {
            echo '<script>
                        alert("Entered quantity is invalid");
                </script>';
         return redirect('http://localhost/vesit/public/asset')->with('error','Entered quantity is invalid');

        }
        else
        {
            $service = New Reservation;
            $service->from_date = $request->input('from_date');
            $service->to_date = $request->input('to_date');
            $service->location = $request->input('location');
            $service->reservation_for = $request->input('reservation_for');
            $service->inventory_id = $request->input('inventory_id'); 
            $service->user_id = auth()->user()->id;
            $service->quantity = $request->input('quantity');

            $role = auth()->user()->role;

            if($role == 'Staff')
            {
                Mail::send('pages.reservationmail',['name'=>'Admin'],function($message)
                {
                    $message->to('2017.mahesh.keswani@ves.ac.in');
                    $message->subject('Reservation Request');
                    $message->from(auth()->user()->email);
                });  
                echo '<script>
                            alert("Your request has been sent to admin");
                    </script>';
               
                $value = 'Reservation Request for '. $asset->name.' has been made by '.$service->reservation_for;
                $status = 'Pending';
                $created_at = $request->input('from_date');
                $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
                DB::table('notifications')->insert($a);
                
            /* $asset['available'] = $asset['available'] - $quantity;
                $asset->save();
                $service->save();
                */
                return redirect('http://localhost/vesit/public/asset')->with('success','Your request has been sent to admin');
            }
            else
            {
                $asset['available'] = $asset['available'] - $quantity;
                $asset->save();
                $service->status = 1;
                $service->save();

                $value = 'Reservation for '. $asset->name.' has been made by '.$service->reservation_for;
                $status = 'Approved';
                $created_at = $request->input('from_date');
    
                $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
                DB::table('notifications')->insert($a);

                return redirect('http://localhost/vesit/public/asset')->with('success','Reservation made successfully');


            }  
         }
      
    }
    public function stockReservation(Request $request)
    {
        $location = Location::all();
        $group = Group::all();
        $asset = Asset::all();
        $stock = Stock::all();
        $inventory = Inventory::all();

        $data = array('location'=>$location,'group'=>$group,'asset'=>$asset,'stock'=>$stock,'inventory'=>$inventory);

        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
        $stock_id = $request['stock_id'];
        $quantity = $request['quantity'];

        $asset = Stock::find($stock_id);

      

        if($from_date < date('Y-m-d',time()))
        {
            echo '<script>
                        alert("Entered From date has been passed out");
                </script>'; 
         return redirect('http://localhost/vesit/public/asset')->with('error','Entered From date has been passed out');

        }
        else if($from_date > $to_date)
        {
            echo '<script>
                        alert("Invalid From date and To date");
                </script>';
        return redirect('http://localhost/vesit/public/asset')->with('error','Invalid From date and To date');

            
        }
        else if($asset['available'] < $quantity)
        {
            echo '<script>
                        alert("Requested quantity is greater than available quantity");
                </script>';
            return redirect('http://localhost/vesit/public/asset')->with('error','Requested quantity is greater than available quantity');

        }
        else if($quantity <= 0)
        {
            echo '<script>
                        alert("Entered quantity is invalid");
                </script>';
         return redirect('http://localhost/vesit/public/asset')->with('error','Entered quantity is invalid');

        }
        else
        {
            $service = New Reservation;
            $service->from_date = $request->input('from_date');
            $service->to_date = $request->input('to_date');
            $service->location = $request->input('location');
            $service->reservation_for = $request->input('reservation_for');
            $service->stock_id = $request->input('stock_id'); 
            $service->user_id = auth()->user()->id;
            $service->quantity = $request->input('quantity');

            $role = auth()->user()->role;
            $email = auth()->user()->email;
            if($role == 'Staff')
            {
                Mail::send('pages.reservationmail',['name'=>'Admin'],function($message) use($email)
                {
                    $message->to('2017.mahesh.keswani@ves.ac.in');
                    $message->subject('Reservation Reqest');
                    $message->from($email);
                });  
                echo '<script>
                            alert("Your request has been sent to admin");
                    </script>';
                
               

                $value = 'Reservation Request for '. $asset->name.' has been made by '.$service->reservation_for;
                $status = 'Pending';
                $created_at = $request->input('from_date');
                $service->save();
                $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
                DB::table('notifications')->insert($a);
            /* $asset['available'] = $asset['available'] - $quantity;
                $asset->save();
                $service->save();
                */
                return redirect('http://localhost/vesit/public/asset')->with('success','Your request has been sent to admin');
            }
            else
            {
                $asset['available'] = $asset['available'] - $quantity;
                $asset->save();
                $service->status = 1;
                $service->save();
            }
            if($service->status == 1 || $role == 'Admin')
            {
                $value = 'Reservation Request for '. $asset->name.' has been made by '.$service->reservation_for;
                $status = 'Approved';
                $created_at = $request->input('from_date');
                $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);
                DB::table('notifications')->insert($a);
        
            }     
           return redirect('http://localhost/vesit/public/asset')->with('success','Reservation made successfully');


         
        }
      
    }
    public function index()
    {
        $reservations = Reservation::all();
        return view('pages.confirm')->with('reservations',$reservations);
    }
    public function confirm($id)
    {
        $r = Reservation::find($id);

        $r->status = 1;

        $value = 'Reservation Confirmed for '. $r->name.' made by '.$r->reservation_for;
        $status = 'Approved';
        $created_at = $r->from_date;
        $a = array('messages'=>$value,'status'=>$status,'created_at'=>$created_at);

        DB::table('notifications')->insert($a);

        $r->save();

        $item  = DB::select("SELECT item_id FROM reservations WHERE from_date = CURDATE() AND item_id = $r->item_id");

        $asset = Asset::find($id);
        $asset->available -= $r->quantity;
        $asset->save();
        
        $item  = DB::select("SELECT stock_id FROM reservations WHERE from_date = CURDATE() AND stock_id = $r->stock_id");
        
        $asset = Stock::find($id);
        $asset->available -= $r->quantity;
        $asset->save();

        $item  = DB::select("SELECT inventory_id FROM reservations WHERE from_date = CURDATE() AND inventory_id = $r->inventory_id");

        $asset = Inventory::find($id);
        $asset->available -= $r->quantity;
        $asset->save();
        
        return redirect('http://localhost/vesit/public/asset')->with('success','Reservation made successfully');

    }
}
