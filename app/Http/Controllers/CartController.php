<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Asset;
use App\Stock;
use App\Inventory;
use DB;
class CartController extends Controller
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
        $cart = Cart::all();
        $asset = Asset::all();
        $stock = Stock::all();
        $inventory = Inventory::all();

        //if to date is less than current date then delete cart

        $check_if_to_date = DB::select('SELECT id FROM carts WHERE items IN 
                                        (SELECT items FROM carts WHERE to_date > CURDATE())
                                        ');

        if(!empty($check_if_to_date))
        {
            DB::delete("DELETE FROM carts WHERE id = $check_if_to_date");
        }

       
        $asset_array = array();
        $stock_array = array();
        $inventory_array = array();
        
        foreach($asset as $a)
        {
            array_push($asset_array,$a->name.' 0');
        }

        $stock_array = array();
        foreach($stock as $a)
        {
            array_push($stock_array,$a->name.' 1');
        }
        
        $inventory_array = array();
        foreach($inventory as $a)
        {
            array_push($inventory_array,$a->name.' 2');
        }

       
        
        $data = array('cart'=>$cart,'asset'=>$asset_array,'stock'=>$stock_array,'inventory'=>$inventory_array);
        
        return view('pages.add_to_cart')->with($data);
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
        $from_date = $request['from_date'];
        $to_date = $request['to_date'];
        

        if($from_date < date('Y-m-d',time()) || $from_date > $to_date || $to_date < date('Y-m-d',time()))
        {
            return redirect('http://localhost/vesit/public/cart')->with('error','Entered dates are invalid');

        }
        $quantity =  $request['quantity'];
       $item = $request['item'];
 
       
       if(substr($item,-1) == '0')
       {
            $asset_name = substr($item,0,-2);
          
            $asset = DB::table('assets')->where('name',$asset_name)->get();
            $id = $asset[0]->id;
           $check_if_under_service = DB::select("SELECT item_id FROM services WHERE item_id=$id AND expected_complete_date > $from_date");
            
           if(!empty($check_if_under_service))
           {
                return redirect('http://localhost/vesit/public/cart')->with('error','Selected asset is under service');       
            }
            
            ////check if requested quantity is grater than available
            if($asset[0]->available < $quantity)
            {
                return redirect('http://localhost/vesit/public/cart')->with('error','Requested Asset quantity is greater than available');       

            }
            $check_if_reserved = DB::select("SELECT item_id FROM reservations WHERE item_id = $id AND to_date > $from_date");

            if(!empty($check_if_reserved))
            {
                return redirect('http://localhost/vesit/public/cart')->with('error','Requested Asset is already reserved in that duration');       

            }
            $check_if_checked_out = DB::select("SELECT item_id FROM checkouts WHERE item_id = $id AND return_date >= CURDATE()");

            if(!empty($check_if_checked_out))
            {
                return redirect('http://localhost/vesit/public/cart')->with('error','Requested Asset is already checked out');       

            }

            
        }
        if(substr($item,-1) == '1')
       {
            $asset_name = substr($item,0,-2);
            $asset_name;
            $asset = DB::table('stocks')->where('name',$asset_name)->get();
            $id = $asset[0]->id;
           $check_if_under_service = DB::select("SELECT stock_id FROM services WHERE stock_id=$id AND expected_complete_date > $from_date");
             
           if(!empty($check_if_under_service))
           {
                return redirect('http://localhost/vesit/public/asset')->with('error','Selected asset stock  is under service');       
            }  
            
            if($asset[0]->available < $quantity)
            {
                return redirect('http://localhost/vesit/public/asset')->with('error','Requested Stock quantity is greater than available');       
            }   
            $check_if_reserved = DB::select("SELECT stock_id FROM reservations WHERE stock_id = $id AND to_date > $from_date");

            if(!empty($check_if_reserved))
            {
                return redirect('http://localhost/vesit/public/cart')->with('error','Requested Asset Stock is already reserved in that duration');       

            } 
            $check_if_checked_out = DB::select("SELECT stock_id FROM checkouts WHERE stock_id = $id AND return_date >= CURDATE()");

            if(!empty($check_if_checked_out))
            {
                return redirect('http://localhost/vesit/public/cart')->with('error','Requested Asset Stock is already checked out');       

            }

         }
        
       if(substr($item,-1) == '2')
       {
            $asset_name = substr($item,0,-2);
            $asset = DB::table('inventories')->where('name',$asset_name)->get();
            $id = $asset[0]->id;
           $check_if_under_service = DB::select("SELECT inventory_id FROM services WHERE inventory_id=$id AND expected_complete_date > $from_date");
             
           if(!empty($check_if_under_service))
           {
                return redirect('http://localhost/vesit/public/asset')->with('error','Selected inventory is under service');       
            }  

            if($asset[0]->available < $quantity)
            {
                return redirect('http://localhost/vesit/public/asset')->with('error','Requested Inventory quantity is greater than available');       

            }  
            $check_if_reserved = DB::select("SELECT inventory_id FROM reservations WHERE inventory_id = $id AND to_date > $from_date");

            if(!empty($check_if_reserved))
            {
                return redirect('http://localhost/vesit/public/cart')->with('error','Requested Inventory is already reserved in that duration');       

            }  
            $check_if_checked_out = DB::select("SELECT inventory_id FROM checkouts WHERE inventory_id = $id AND return_date >= CURDATE()");

            if(!empty($check_if_checked_out))
            {
                return redirect('http://localhost/vesit/public/cart')->with('error','Requested Inventory is already checked out');       

            }
 
     }
        
           $cart = New Cart;
            
            $cart->name = $request['name'];
            $cart->quantity = $request['quantity'];
            $cart->items = $request['item'];
            $cart->from_date = $request['from_date'];
            $cart->to_date = $request['to_date'];

            $cart->save();

            return redirect('http://localhost/vesit/public/cart')->with('success','Cart Created');
        
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
        $cart = Cart::find($id);

        $asset = Asset::all();
        $stock = Stock::all();
        $inventory = Inventory::all();

        $asset_array = array();
        $stock_array = array();
        $inventory_array = array();
        
        foreach($asset as $a)
        {
            array_push($asset_array,$a->name.' 0');
        }

        $stock_array = array();
        foreach($stock as $a)
        {
            array_push($stock_array,$a->name.' 1');
        }
        
        $inventory_array = array();
        foreach($inventory as $a)
        {
            array_push($inventory_array,$a->name.' 2');
        }

       
        
        $data = array('cart'=>$cart,'asset'=>$asset_array,'stock'=>$stock_array,'inventory'=>$inventory_array);
        
        return view('pages.editcart')->with($data);
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
        $quantity =  $request['quantity'];
       $item = $request['item'];
        $from_date = $request['from_date'];
        $to_date = $request['to_date'];
       
       if(substr($item,-1) == '0')
       {
            $asset_name = substr($item,0,-2);
          
            $asset = DB::table('assets')->where('name',$asset_name)->get();
            $id = $asset[0]->id;
           $check_if_under_service = DB::select("SELECT item_id FROM services WHERE item_id=$id AND expected_complete_date > $from_date");
            
           if(!empty($check_if_under_service))
           {
                return redirect('http://localhost/vesit/public/cart')->with('error','Selected asset is under service');       
            }
            
            ////check if requested quantity is grater than available
            if($asset[0]->available < $quantity)
            {
                return redirect('http://localhost/vesit/public/cart')->with('error','Requested Asset quantity is greater than available');       

            }
            $check_if_reserved = DB::select("SELECT item_id FROM reservations WHERE item_id = $id AND to_date > $from_date");

            if(!empty($check_if_reserved))
            {
                return redirect('http://localhost/vesit/public/cart')->with('error','Requested Asset is already reserved in that duration');       

            }

            
        }
        if(substr($item,-1) == '1')
       {
            $asset_name = substr($item,0,-2);
            $asset_name;
            $asset = DB::table('stocks')->where('name',$asset_name)->get();
            $id = $asset[0]->id;
           $check_if_under_service = DB::select("SELECT stock_id FROM services WHERE stock_id=$id AND expected_complete_date > $from_date");
             
           if(!empty($check_if_under_service))
           {
                return redirect('http://localhost/vesit/public/asset')->with('error','Selected asset stock  is under service');       
            }  
            
            if($asset[0]->available < $quantity)
            {
                return redirect('http://localhost/vesit/public/asset')->with('error','Requested Stock quantity is greater than available');       
            }   
            $check_if_reserved = DB::select("SELECT stock_id FROM reservations WHERE stock_id = $id AND to_date > $from_date");

            if(!empty($check_if_reserved))
            {
                return redirect('http://localhost/vesit/public/cart')->with('error','Requested Asset Stock is already reserved in that duration');       

            } 
         }
        
       if(substr($item,-1) == '2')
       {
            $asset_name = substr($item,0,-2);
            $asset = DB::table('inventories')->where('name',$asset_name)->get();
            $id = $asset[0]->id;
           $check_if_under_service = DB::select("SELECT inventory_id FROM services WHERE inventory_id=$id AND expected_complete_date > $from_date");
             
           if(!empty($check_if_under_service))
           {
                return redirect('http://localhost/vesit/public/asset')->with('error','Selected inventory is under service');       
            }  

            if($asset[0]->available < $quantity)
            {
                return redirect('http://localhost/vesit/public/asset')->with('error','Requested Inventory quantity is greater than available');       

            }  
            $check_if_reserved = DB::select("SELECT inventory_id FROM reservations WHERE inventory_id = $id AND to_date > $from_date");

            if(!empty($check_if_reserved))
            {
                return redirect('http://localhost/vesit/public/cart')->with('error','Requested Inventory is already reserved in that duration');       

            }   
            
     }
        $cart = Cart::find($id);
        $cart->items .= ','.$request['item'];
        $cart->quantity += $request['quantity'];

        $cart->save();

        return redirect('http://localhost/vesit/public/cart')->with('success','Cart Successfully Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asset = Cart::find($id);
        $asset->delete();

        return redirect('http://localhost/vesit/public/cart')->with('success','Cart Removed');
    }
    
}
