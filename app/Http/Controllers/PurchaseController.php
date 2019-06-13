<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\Asset;
use App\Group;
use App\Location;
use App\User;
use App\Stock;
use App\Inventory;
use App\Service;
use App\Vendor;
use App\Notification;

class PurchaseController extends Controller
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
        $purchase = Purchase::all();
        if(count($purchase) == 0)
        {
            return redirect('http://localhost/vesit/public/asset')->with('error','No purchased order drafted');

        }
        else
        {
            return view('pages.purchaseorders')->with('purchase',$purchase);
        }
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
        $del_date = $request->input('delivery_date');
        
        if($del_date < date('Y-m-d',time()))
        {
            return redirect('http://localhost/vesit/public/asset')->with('error','Invalid delivery date');
        }
        $purchase = New Purchase;
        $purchase->delivery_date = $request['delivery_date'];
        $purchase->vendor = $request['vendor'];
        $purchase->approver = $request['approver'];

        $purchase_asset = $request['purchase_asset'];
        $purchase_stock = $request['purchase_stock'];
        $purchase_inventory = $request['purchase_inventory'];
        
        $items = array('purchase_asset'=>$purchase_asset,'purchase_stock'=>$purchase_stock,'purchase_inventory'=>$purchase_inventory);
        $purchase->items = implode(',',$items);
        $purchase->description = $request['description'];
        $purchase->payment_terms = $request['payment_terms'];
        $purchase->status = 0;

        $purchase->save();
        return redirect('http://localhost/vesit/public/asset')->with('success','Successfully Drafted Purchased');

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
    public function confirmPurchase($id)
    {
        $purchase = Purchase::find($id);
        $purchase->status = 1;
        $purchase->save();

        return redirect('http://localhost/vesit/public/asset')->with('success','Successfully Purchased Order');
 
    }
}
